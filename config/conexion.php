<?php

function cargarEnv()
{
    $archivo = __DIR__ . "/../.env";
    if (!file_exists($archivo)) {
        return;
    }
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if ($linea === "" || str_starts_with($linea, "#")) {
            continue;
        }
        $partes = explode("=", $linea, 2);
        if (count($partes) === 2) {
            $clave = trim($partes[0]);
            $valor = trim($partes[1], " '\"");
            putenv("$clave=$valor");
            $_ENV[$clave] = $valor;
        }
    }
}

cargarEnv();

function obtenerConexion()
{
    $host    = getenv('DB_HOST') ?: 'localhost';
    $port    = getenv('DB_PORT') ?: '3306';
    $db      = getenv('DB_NAME') ?: 'citas_medicas';
    $user    = getenv('DB_USER') ?: 'root';
    $pass    = getenv('DB_PASS') ?: '';
    $sslCa   = getenv('DB_SSL_CA') ?: '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    if ($sslCa !== '') {
        $opciones[PDO::MYSQL_ATTR_SSL_CA] = $sslCa;
        $opciones[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    } elseif (getenv('DB_SSL') === 'REQUIRED') {
        $opciones[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }

    try {
        return new PDO($dsn, $user, $pass, $opciones);
    } catch (PDOException $e) {
        die('Error de conexion: ' . $e->getMessage());
    }
}
