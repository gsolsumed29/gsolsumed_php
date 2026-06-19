<?php
define('NUM_ITEMS_BY_PAGE', 16);
define('NUM_ITEMS_BY_PAGE_CART', 6);
define('APP_NOMBRE', "Empresa | Nombre");
define('APP_DIRECCION', "DIRECCION DE PRUEBA");
define('APP_TELEFONO', "+58-123-4455");
define('APP_CORREO', "empresa@empresa.com");
define('APP_RIF', "j-123456789-9");

define('SERVERNAME', getenv('DB_HOST') ?: '192.168.0.135');
define('DBNAME', getenv('DB_NAME') ?: 'A_GSOL');
define('USERNAME', getenv('DB_USER') ?: 'profit');
define('PASSWORD', getenv('DB_PASSWORD') ?: 'profit');


?>