<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use PDO;
use RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class RespaldoService
{
    private const TABLAS_REQUERIDAS = ['users', 'inventarios', 'migrations'];

    public function carpeta(): string
    {
        $ruta = storage_path('app/respaldos');

        if (!is_dir($ruta)) {
            mkdir($ruta, 0775, true);
        }

        return $ruta;
    }

    private function conexion(): array
    {
        return config('database.connections.' . config('database.default'), []);
    }

    private function driver(): string
    {
        return $this->conexion()['driver'] ?? '';
    }

    private function esSqlite(): bool
    {
        return $this->driver() === 'sqlite';
    }

    private function esMysql(): bool
    {
        return in_array($this->driver(), ['mysql', 'mariadb'], true);
    }

    public function extension(): string
    {
        return $this->esSqlite() ? 'sqlite' : 'sql';
    }

    public function motivoNoDisponible(): ?string
    {
        if ($this->esSqlite()) {
            return null;
        }

        if (!$this->esMysql()) {
            return 'El respaldo automático solo está disponible para SQLite, MySQL y MariaDB.';
        }

        if (!$this->binario(['mariadb-dump', 'mysqldump'])) {
            return 'No se encontró mysqldump / mariadb-dump en el servidor. Instálalo o indica su carpeta en '
                . 'config/database.php (clave "dump" => ["dump_binary_path" => ...]).';
        }

        if (!$this->binario(['mariadb', 'mysql'])) {
            return 'No se encontró el cliente mysql / mariadb en el servidor. Instálalo o indica su carpeta en '
                . 'config/database.php (clave "dump" => ["dump_binary_path" => ...]).';
        }

        return null;
    }

    public function disponible(): bool
    {
        return $this->motivoNoDisponible() === null;
    }

    private function asegurarDisponible(): void
    {
        $motivo = $this->motivoNoDisponible();

        if ($motivo !== null) {
            throw new RuntimeException($motivo);
        }
    }

    private function rutaBaseDatos(): string
    {
        if (!$this->esSqlite()) {
            throw new RuntimeException('La base de datos activa no es SQLite.');
        }

        $ruta = config('database.connections.sqlite.database');

        if ($ruta === ':memory:' || !is_file($ruta)) {
            throw new RuntimeException('No se encontró el archivo de la base de datos.');
        }

        return $ruta;
    }

    private function binario(array $nombres): ?string
    {
        $finder = new ExecutableFinder();
        $carpetas = array_filter([$this->conexion()['dump']['dump_binary_path'] ?? null]);

        foreach ($nombres as $nombre) {
            $ruta = $finder->find($nombre, null, $carpetas);

            if ($ruta) {
                return $ruta;
            }
        }

        return null;
    }

    private function argumentosConexion(): array
    {
        $c = $this->conexion();

        $args = ['--user=' . ($c['username'] ?? 'root')];

        if (!empty($c['unix_socket'])) {
            $args[] = '--socket=' . $c['unix_socket'];
        } else {
            $args[] = '--host=' . ($c['host'] ?? '127.0.0.1');
            $args[] = '--port=' . ($c['port'] ?? 3306);
        }

        return $args;
    }

    private function ejecutar(array $comando, $entrada = null, int $timeout = 600): void
    {
        $password = (string) ($this->conexion()['password'] ?? '');

        $proceso = new Process($comando, null, $password !== '' ? ['MYSQL_PWD' => $password] : []);
        $proceso->setTimeout($timeout);

        if ($entrada !== null) {
            $proceso->setInput($entrada);
        }

        $proceso->run();

        if (!$proceso->isSuccessful()) {
            $detalle = trim($proceso->getErrorOutput());

            throw new RuntimeException($detalle !== '' ? $detalle : 'El comando terminó con error.');
        }
    }

    private function ultimosBytes(string $ruta, int $cantidad): string
    {
        $tamano = filesize($ruta);
        $gestor = fopen($ruta, 'rb');

        if ($gestor === false || $tamano === 0) {
            return '';
        }

        fseek($gestor, -min($tamano, $cantidad), SEEK_END);
        $texto = (string) fread($gestor, $cantidad);
        fclose($gestor);

        return $texto;
    }

    private function volcarMysql(string $destino): void
    {
        $dump = $this->binario(['mariadb-dump', 'mysqldump']);

        try {
            $this->ejecutar(array_merge(
                [$dump],
                $this->argumentosConexion(),
                [
                    '--single-transaction',
                    '--routines',
                    '--triggers',
                    '--default-character-set=utf8mb4',
                    '--result-file=' . $destino,
                    $this->conexion()['database'],
                ]
            ));
        } catch (RuntimeException $e) {
            @unlink($destino);

            throw new RuntimeException('No se pudo crear el respaldo: ' . $e->getMessage());
        }

        if (!str_contains($this->ultimosBytes($destino, 512), 'Dump completed')) {
            @unlink($destino);

            throw new RuntimeException('El respaldo quedó incompleto y fue descartado.');
        }
    }


    public function nombreValido(string $nombre): bool
    {
        return (bool) preg_match('/^respaldo_[A-Za-z0-9_-]+\.' . $this->extension() . '$/', $nombre);
    }

    public function rutaDe(string $nombre): string
    {
        if (!$this->nombreValido($nombre)) {
            throw new RuntimeException('Nombre de respaldo no válido.');
        }

        $ruta = $this->carpeta() . DIRECTORY_SEPARATOR . $nombre;

        if (!is_file($ruta)) {
            throw new RuntimeException('El respaldo no existe.');
        }

        return $ruta;
    }

    public function listar(): array
    {
        $respaldos = [];

        foreach (glob($this->carpeta() . DIRECTORY_SEPARATOR . 'respaldo_*.' . $this->extension()) ?: [] as $archivo) {
            $nombre = basename($archivo);

            $respaldos[] = [
                'nombre'  => $nombre,
                'tamano'  => filesize($archivo),
                'fecha'   => \Carbon\Carbon::createFromTimestamp(filemtime($archivo)),
                'tipo'    => str_contains($nombre, '_antes-de-restaurar') ? 'Automático (previo a restaurar)'
                            : (str_contains($nombre, '_programado') ? 'Programado' : 'Manual'),
            ];
        }

        usort($respaldos, fn ($a, $b) => $b['fecha']->timestamp <=> $a['fecha']->timestamp);

        return $respaldos;
    }

    public function crear(string $etiqueta = 'manual'): string
    {
        $this->asegurarDisponible();

        if ($this->esSqlite()) {
            $this->rutaBaseDatos();
        }

        $nombre = 'respaldo_' . now()->format('Y-m-d_His') . '-' . substr(uniqid(), -3)
                . '_' . $etiqueta . '.' . $this->extension();
        $destino = $this->carpeta() . DIRECTORY_SEPARATOR . $nombre;

        if ($this->esSqlite()) {
            DB::statement('VACUUM INTO ' . DB::getPdo()->quote($destino));
        } else {
            $this->volcarMysql($destino);
        }

        if (!is_file($destino)) {
            throw new RuntimeException('No se pudo crear el respaldo.');
        }

        return $nombre;
    }

    public function validarArchivo(string $ruta): void
    {
        if ($this->esSqlite()) {
            $this->validarSqlite($ruta);
        } else {
            $this->validarSql($ruta);
        }
    }

    private function validarSqlite(string $ruta): void
    {
        $cabecera = @file_get_contents($ruta, false, null, 0, 16);

        if ($cabecera !== "SQLite format 3\0") {
            throw new RuntimeException('El archivo no es una base de datos SQLite válida.');
        }

        try {
            $pdo = new PDO('sqlite:' . $ruta);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $integridad = $pdo->query('PRAGMA integrity_check')->fetchColumn();

            if ($integridad !== 'ok') {
                throw new RuntimeException('El archivo está dañado (falló la verificación de integridad).');
            }

            $tablas = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
            $pdo = null;
        } catch (\PDOException $e) {
            throw new RuntimeException('El archivo no se puede leer como base de datos.');
        }

        foreach (self::TABLAS_REQUERIDAS as $tabla) {
            if (!in_array($tabla, $tablas, true)) {
                throw new RuntimeException('El archivo no pertenece a este sistema (falta la tabla "' . $tabla . '").');
            }
        }
    }

    private function validarSql(string $ruta): void
    {
        if (!is_file($ruta) || filesize($ruta) === 0) {
            throw new RuntimeException('El archivo está vacío o no se puede leer.');
        }

        $gestor = fopen($ruta, 'rb');

        if ($gestor === false) {
            throw new RuntimeException('El archivo no se puede leer.');
        }

        if (fread($gestor, 16) === "SQLite format 3\0") {
            fclose($gestor);

            throw new RuntimeException('Este archivo es un respaldo de SQLite; la base de datos actual es MariaDB/MySQL.');
        }

        rewind($gestor);

        $faltan = array_flip(self::TABLAS_REQUERIDAS);

        while ($faltan && ($linea = fgets($gestor, 8192)) !== false) {
            if (preg_match('/^CREATE TABLE (?:IF NOT EXISTS )?`?(users|inventarios|migrations)`?[\s(]/i', $linea, $m)) {
                unset($faltan[strtolower($m[1])]);
            }
        }

        fclose($gestor);

        if ($faltan) {
            throw new RuntimeException(
                'El archivo no pertenece a este sistema (falta la tabla "' . array_key_first($faltan) . '").'
            );
        }

        if (!str_contains($this->ultimosBytes($ruta, 512), 'Dump completed')) {
            throw new RuntimeException('El archivo parece incompleto (no termina como un respaldo válido).');
        }
    }

    public function restaurar(string $rutaOrigen): string
    {
        $this->asegurarDisponible();
        $this->validarArchivo($rutaOrigen);

        if ($this->esSqlite()) {
            $destino = $this->rutaBaseDatos();

            $previo = $this->crear('antes-de-restaurar');

            DB::disconnect();

            if (!copy($rutaOrigen, $destino)) {
                throw new RuntimeException('No se pudo reemplazar la base de datos. Se conserva la copia previa: ' . $previo);
            }

            DB::purge();

            return $previo;
        }

        $previo = $this->crear('antes-de-restaurar');
        $cliente = $this->binario(['mariadb', 'mysql']);
        $entrada = fopen($rutaOrigen, 'rb');

        try {
            $this->ejecutar(array_merge(
                [$cliente],
                $this->argumentosConexion(),
                ['--default-character-set=utf8mb4', $this->conexion()['database']]
            ), $entrada);
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                'No se pudo restaurar: ' . $e->getMessage() . ' Se conserva la copia previa: ' . $previo
            );
        } finally {
            if (is_resource($entrada)) {
                fclose($entrada);
            }
        }

        DB::purge();

        return $previo;
    }

    public function eliminar(string $nombre): void
    {
        unlink($this->rutaDe($nombre));
    }
}