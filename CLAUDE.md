# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Qué es esto

Aplicación web PHP heredada para operaciones administrativas de Grupo Solsumed (ventas, inventario, facturación). Microframework MVC propio llamado **Lb** ("legobox"). UI basada en la plantilla Vuexy Bootstrap 5 (vendorizada bajo `app-assets/`). Base de datos **SQL Server** vía PDO `sqlsrv`. Sin Composer, sin autoloader PSR, sin gestor de dependencias del framework — `core/autoload.php` hace `include` manual de cada controlador.

El toolchain `package.json` / `gulpfile.js` / `src/scss` pertenece **solo al build de la plantilla Vuexy** (compila JS/CSS de vendors y SCSS hacia `app-assets/`). No es un paso de build de la aplicación — la app PHP corre directamente desde los fuentes.

## Ejecución

No hay paso de build para la aplicación. Servir desde un host PHP con PDO `mssql`/`sqlsrv` disponible, document root en la raíz del repo. `index.php` es el punto de entrada.

La config de base de datos vive en `core/controller/Config.php` como constantes `define()`: `SERVERNAME`, `DBNAME`, `USERNAME`, `PASSWORD`. Cambiarlas por entorno — no existe mecanismo `.env`.

```bash
# Rebuild de assets de plantilla Vuexy (solo al editar src/scss o listas de vendors en config.json)
npm install
npx gulp dist-vendor-js dist-vendor-css   # rebuild de bundles JS/CSS vendorizados
npx gulp dist-css                         # SCSS → app-assets/css
npx gulp monitor                          # watch SCSS
```

No hay suite de pruebas, ni linter, ni CI configurado.

## Framework Lb — flujo de una petición

El `index.php` de cada portal son siempre las mismas tres líneas:

```php
include "core/autoload.php";
$lb = new Lb();
$lb->loadModule("index");
```

El ruteo se hace por parámetros de query string, no por rutas de URL. `Lb::loadModule()` (`core/controller/Lb.php`) lee `$_GET` y despacha:

- `?module=X` → carga `core/modules/X/init.php` (por defecto `index`)
- `?view=Y`  → `Module::loadLayout()` llama a `View::load(...)`, que incluye `core/modules/{module}/view/{Y}/widget-default.php`
- `?action=Z` → `Action::load(Z)` incluye `core/modules/{module}/action/{Z}/action-default.php` (esta es la convención para endpoints AJAX / JSON — ver `admin/core/modules/index/action/auth/action-default.php` como patrón: leer `$_SERVER['REQUEST_METHOD']` + `$_GET['path']`, emitir `json_encode`)
- `?path=` → sub-router usado dentro de los handlers de action

Cada módulo tiene el esqueleto fijo: `action/`, `view/`, `boot/`, `model/`, `res/`, más `autoload.php`, `superboot.php`, `init.php`. El `autoload.php` registra `Model::exists` / `Model::getFullpath` vía `spl_autoload_register` — los nombres de clase se resuelven a `admin/core/modules/index/model/{ClassName}.php` (ojo: hard-codeado al directorio de modelos del portal `admin`).

`init.php` es el punto de bifurcación por petición:

```php
if(!isset($_GET["action"])) Module::loadLayout();
else Action::load($_GET["action"], new Request());
```

Los archivos de layout (`view/layout.php`) renderizan el shell HTML completo y luego ejecutan `View::load("dashboard")` condicionalmente cuando `$_SESSION["logged_in"]` está seteado; de lo contrario despachan la action `salir` (logout). Llaves de sesión de las que depende el layout: `nombre`, `nombreUsuario`, `identidad`, `name`, `logged_in`.

`core/controller/` y `admin/core/controller/` existen ambos y se solapan parcialmente — el `core/autoload.php` raíz toma algunas clases de `core/controller/` y otras (`Database`, `Viewer`, `IpLogger`, `Upload`, `functions.php`) solo desde `admin/core/controller/`. Tratar `admin/core/` como la fuente canónica para esas clases; `core/` es el loader compartido más delgado.

## Portales por rol

Los directorios de rol del nivel superior contienen cada uno su propio `index.php` + árbol `core/` y actúan como puntos de entrada separados por rol de usuario:

`admin/`, `gerencia/`, `gerente/`, `gerenciacomercial/`, `administracion/`, `secretaria/`, `vendedor/`, `visitador/`, `chofer/`, `almacen/`, `inventario/`, `compras/`, `ventas/`, `facturacion/`, `mercadeo/`, `cliente/`, `clientes/`, `dev/`.

Comparten el mismo esqueleto Lb pero cada uno tiene su propio conjunto de módulos bajo `<portal>/core/modules/index/`. Al cambiar comportamiento a nivel de framework, el cambio suele tener que aplicarse en varios portales; no asumir que un fix en `admin/` llega a los demás.

## Réplicas del sitio (ngsol / nsola / nsolh)

`ngsol/`, `nsola/`, `nsolh/` son **copias completas del repo entero** (su propio `admin/`, `vendedor/`, `gerente/`, `secretaria/`, `app-assets/`, `gulpfile.js`, etc.). Parecen ser ramas paralelas de tenant/entorno mantenidas en sincronía por copia. Antes de editar una, revisar si el mismo archivo existe en las otras — un fix en el árbol raíz generalmente debe replicarse en `ngsol/`, `nsola/`, `nsolh/`.

## Acceso a base de datos

`Database::getCon()` (`core/controller/Database.php` y `admin/core/controller/Database.php`) devuelve una conexión PDO singleton usando las constantes de `Config.php`. Driver hard-codeado a `sqlsrv` con `encrypt=false`. Las queries están escritas como strings SQL concatenados a lo largo del codebase — la mayoría del código existente no usa prepared statements. `Executor::doit($sql)` es el helper raw legacy; algunos archivos todavía llaman `$query->fetch_array()` estilo mysqli sobre resultados PDO, lo cual es una superficie de bug conocida.

## Patrón de autenticación

Auth estilo JWT en las actions: `Auth::login(user, pass)`, `Auth::requireAuth()`, `Auth::requireRole('admin')`, `JWT::generate($user, $ttlSeconds)`. Estas clases se resuelven a través del autoloader de `Model`, por lo que viven bajo `admin/core/modules/index/model/`. La action `salir` maneja logout/destrucción de sesión y se invoca desde los layouts cuando la sesión es inválida.

## Dumps JSON en el árbol de fuentes

`archivos_json/` y la raíz de `admin/` contienen una cantidad grande de archivos JSON en runtime (`anulacion_*.json`, `descarga_*.json`, `debug_nota_credito_*.json`). Son artefactos operacionales/snapshots de debug commiteados al repo — no tratarlos como fixtures ni schema. Ignorar salvo petición explícita.

## Convenciones a mantener

- Endpoints nuevos: crear un folder de action bajo `<portal>/core/modules/index/action/<name>/action-default.php`; llamarlo desde JS vía `index.php?action=<name>&path=<subroute>`.
- Pantallas nuevas: crear un folder de view bajo `<portal>/core/modules/index/view/<name>/widget-default.php` y un item de menú en el `view/layout.php` de ese portal.
- Nueva clase de modelo `Foo`: la ruta del archivo debe ser `admin/core/modules/index/model/Foo.php` para que el autoloader la encuentre.
- Páginas con sesión obligatoria deben chequear `$_SESSION["logged_in"]` y caer en `Action::execute("salir", [])` — igualar el patrón existente del layout.
- UI usa las convenciones del tema Vuexy (Feather icons, markup Bootstrap 5, jQuery DataTables, Select2, Flatpickr, Toastr, SweetAlert2). Reutilizar las clases existentes y los atributos `data-feather` en vez de introducir otro toolkit.
