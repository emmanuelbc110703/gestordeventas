<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('respaldo:crear')->dailyAt('02:00');
Schedule::command('pagos-servicios:activar-pendientes')->dailyAt('00:05');
