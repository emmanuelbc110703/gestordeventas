<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 100px 20px 30px;
    }

    nav {
        width: 100%;
        padding: 15px 7%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.96);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .marca {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #6a1b9a;
        font-size: 20px;
        font-weight: bold;
    }

    .marca i { font-size: 25px; }

    .menu { display: flex; align-items: center; gap: 22px; }

    .menu a {
        color: #444;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    .menu a:hover { color: #6a1b9a; }

    .contenedor {
        width: 90%;
        max-width: 420px;
        background-color: white;
        border-radius: 15px;
        padding: 35px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .logo {
        width: 130px;
        height: 130px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    h1 { color: #6a1b9a; margin-bottom: 5px; }

    .subtitulo { color: #666; margin-bottom: 30px; }

    .campo { position: relative; margin-bottom: 20px; }

    .campo i {
        position: absolute;
        left: 15px;
        top: 14px;
        color: #6a1b9a;
    }

    .campo input {
        width: 100%;
        padding: 13px 15px 13px 45px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
    }

    .campo input:focus { border-color: #6a1b9a; }

    .campo input[readonly] { background: #f3f3f3; color: #666; }

    .error {
        color: #c62828;
        font-size: 14px;
        text-align: left;
        margin-top: -12px;
        margin-bottom: 15px;
    }

    .error a { color: #6a1b9a; font-weight: bold; }

    .exito {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
    }

    .ayuda-password {
        font-size: 12px;
        color: #777;
        margin: -8px 0 14px;
        text-align: left;
    }

    .boton-login {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 8px;
        background-color: #6a1b9a;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .boton-login:hover { background-color: #4a126d; }

    .registro { margin-top: 25px; color: #666; }

    .registro a {
        color: #6a1b9a;
        font-weight: bold;
        text-decoration: none;
    }

    .registro a:hover { text-decoration: underline; }

    @media (max-width: 750px) {
        nav { padding: 12px 5%; flex-direction: column; gap: 12px; }
        .marca { font-size: 18px; }
        .menu { width: 100%; justify-content: center; flex-wrap: wrap; gap: 8px 15px; }
        .menu a { font-size: 14px; }
        body { padding-top: 150px; }
    }

    @media (max-width: 500px) {
        .contenedor { width: 100%; padding: 25px 20px; }
    }
</style>