<?php
// Helper: env var with fallback default
if (!function_exists('lb_env')) {
    function lb_env($key, $default = null) {
        $v = getenv($key);
        return ($v === false || $v === '') ? $default : $v;
    }
}

define('NUM_ITEMS_BY_PAGE', 15);
define('NUM_ITEMS_BY_PAGE_CART', 6);
define('APP_NOMBRE',    lb_env('APP_NOMBRE',    "Empresa | Nombre"));
define('APP_DIRECCION', lb_env('APP_DIRECCION', "DIRECCION DE PRUEBA"));
define('APP_TELEFONO',  lb_env('APP_TELEFONO',  "+58-123-4455"));
define('APP_CORREO',    lb_env('APP_CORREO',    "empresa@empresa.com"));
define('APP_RIF',       lb_env('APP_RIF',       "j-123456789-9"));

define('SERVERNAME', lb_env('DB_HOST',     '192.168.0.135'));
define('DBNAME',     lb_env('DB_NAME',     'A_GSOL'));
define('USERNAME',   lb_env('DB_USER',     'profit'));
define('PASSWORD',   lb_env('DB_PASSWORD', 'profit'));
?>
