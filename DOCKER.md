# Docker quickstart

App PHP solo. SQL Server externo (no se levanta contenedor de DB).

## Requisitos
- Docker + Docker Compose v2
- SQL Server accesible por red desde el host Docker

## Levantar

```bash
cp .env.example .env       # ajustar DB_HOST/DB_USER/DB_PASSWORD
docker compose up -d --build
```

App: http://localhost:8080

## DB_HOST segun ubicacion del SQL Server

| Ubicacion DB | Valor DB_HOST |
|---|---|
| Otra maquina LAN | IP directa, ej `192.168.0.135` |
| Mismo host donde corre Docker | `host.docker.internal` |
| Servidor remoto | hostname / IP publica |

Linux: `host.docker.internal` resuelve via `extra_hosts: host-gateway` (ya configurado).

## Verificar conexion DB desde dentro del contenedor

```bash
docker compose exec app bash -lc "php -r \"
  try { new PDO('sqlsrv:server='.getenv('DB_HOST').';Database='.getenv('DB_NAME').';encrypt=false;TrustServerCertificate=true;LoginTimeout=5', getenv('DB_USER'), getenv('DB_PASSWORD')); echo 'OK\n'; }
  catch(Exception \\\$e){ echo 'FAIL: '.\\\$e->getMessage().\"\n\"; }
\""
```

## Logs

```bash
docker compose logs -f app
docker compose exec app tail -f /var/log/apache2/error.log
```

## Rebuild

```bash
docker compose up -d --build app
```

## Parar

```bash
docker compose down
```

## Notas

- `Config.php` de cada portal lee `DB_HOST/DB_NAME/DB_USER/DB_PASSWORD` via `getenv()`. Sin env var usa el literal original (compat).
- Driver `pdo_sqlsrv` 5.x sobre MS ODBC 18. Cadena PDO envia `encrypt=false;TrustServerCertificate=true`.
- Timezone PHP fijado a `America/Caracas`.
- `OPENSSL_CONF` apunta a `openssl_legacy.cnf` (necesario para scraping BCV con TLS legacy).
- Replicas `ngsol/`, `nsola/`, `nsolh/` excluidas del build.
