# Configuracion de nginx y php-fpm para Ubuntu Server

## Consideraciones
Servidor
- Ubuntu 24.04 LTS
- PHP 8.4
- Nginx 1.28

Dominio
- El dominio es **bthsanjulian.website**
- El puerto es **8000**
- El usuario es **www-data** y grupo es **www-data**
- El directorio es **/var/www/bth.webapp**
- El archivo de configuracion **/etc/nginx/sites-available/bth.webapp**

PHP
- Directorio de sesiones PHP **/var/lib/php/sessions/bth.webapp**
- El archivo para php-fpm **/etc/php/8.4/fpm/pool.d/bth.webapp.conf**
- El Socket de php-fpm **/run/php/php8.4-fpm-bth.sock**

## Configuraciones globales para php-fpm
### Editar php.ini para php-fpm
```bash
sudo vim /etc/php/8.4/fpm/php.ini
```

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=60
```

### Editar www.conf para php-fpm
```bash
sudo vim /etc/php/8.4/fpm/pool.d/www.conf
```

```ini
pm = dynamic

pm.max_children = 40
pm.start_servers = 8
pm.min_spare_servers = 4
pm.max_spare_servers = 12

pm.max_requests = 500
```

## Instalacion de nginx

### Agregar repositorio principal
- [Instrucciones de instalacion de nginx en ubuntu](https://nginx.org/en/linux_packages.html#Ubuntu)
```bash
sudo apt install curl gnupg2 ca-certificates lsb-release ubuntu-keyring
```

```bash
curl https://nginx.org/keys/nginx_signing.key | gpg --dearmor \
| sudo tee /usr/share/keyrings/nginx-archive-keyring.gpg >/dev/null
gpg --dry-run --quiet --no-keyring --import --import-options import-show /usr/share/keyrings/nginx-archive-keyring.gpg
```

```bash
echo "deb [signed-by=/usr/share/keyrings/nginx-archive-keyring.gpg] \
https://nginx.org/packages/ubuntu `lsb_release -cs` nginx" \
| sudo tee /etc/apt/sources.list.d/nginx.list
```

```bash
echo -e "Package: *\nPin: origin nginx.org\nPin: release o=nginx\nPin-Priority: 900\n" \
| sudo tee /etc/apt/preferences.d/99nginx
```

### Actualizar repositorio
```bash
sudo apt update
```

### Instalar nginx
```bash
sudo apt install nginx
```

## Manejo de servicios

### Iniciar nginx
```bash
sudo systemctl start nginx
```

### Habilitar nginx
```bash
sudo systemctl enable nginx
```

### Verificar estado de nginx
```bash
sudo systemctl status nginx
```

## Configuracion optima de nginx

### Verificar archivos y directorios de configuracion
```bash
ls /etc/nginx
```

### Crear directorios si es necesario
```bash
sudo mkdir -p /etc/nginx/sites-available
sudo mkdir -p /etc/nginx/sites-enabled
```

### Crear 
```bash
sudo vim /etc/nginx/fastcgi.conf
```

```ini
fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
fastcgi_param  QUERY_STRING       $query_string;
fastcgi_param  REQUEST_METHOD     $request_method;
fastcgi_param  CONTENT_TYPE       $content_type;
fastcgi_param  CONTENT_LENGTH     $content_length;

fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
fastcgi_param  REQUEST_URI        $request_uri;
fastcgi_param  DOCUMENT_URI       $document_uri;
fastcgi_param  DOCUMENT_ROOT      $document_root;
fastcgi_param  SERVER_PROTOCOL    $server_protocol;
fastcgi_param  REQUEST_SCHEME     $scheme;
fastcgi_param  HTTPS              $https if_not_empty;

fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;

fastcgi_param  REMOTE_ADDR        $remote_addr;
fastcgi_param  REMOTE_PORT        $remote_port;
fastcgi_param  REMOTE_USER        $remote_user;
fastcgi_param  SERVER_ADDR        $server_addr;
fastcgi_param  SERVER_PORT        $server_port;
fastcgi_param  SERVER_NAME        $server_name;

fastcgi_param  REDIRECT_STATUS    200;
```

### Crear el directorio
```bash
sudo mkdir -p /etc/nginx/snippets
```

### Crear archivo de configuracion
```bash
sudo vim /etc/nginx/snippets/fastcgi-php.conf
```

```nginx
# regex to split $uri to $fastcgi_script_name and $fastcgi_path
fastcgi_split_path_info ^(.+\.php)(/.+)$;

# Check that the PHP script exists before passing it
try_files $fastcgi_script_name =404;

# Bypass the fact that try_files resets $fastcgi_path_info
set $path_info $fastcgi_path_info;
fastcgi_param PATH_INFO $path_info;

fastcgi_index index.php;
include fastcgi.conf;
```

### Editar archivo de configuracion principal
```bash
sudo vim /etc/nginx/nginx.conf
```

```nginx
user www-data;
worker_processes auto;
pid /run/nginx.pid;

events {
    worker_connections 4096;
    multi_accept on;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;

    keepalive_timeout 65;
    types_hash_max_size 2048;

    server_tokens off;

    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    client_body_buffer_size 16K;
    client_header_buffer_size 1k;
    large_client_header_buffers 4 16k;

    client_body_timeout 12;
    client_header_timeout 12;
    send_timeout 10;

    gzip on;
    gzip_comp_level 5;
    gzip_min_length 256;
    gzip_vary on;

    gzip_types
        text/plain
        text/css
        text/xml
        application/json
        application/javascript
        application/xml
        application/rss+xml;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    include /etc/nginx/sites-enabled/*;
}
```

### Verificar configuracion
```bash
sudo nginx -t
```

### Cargar configuraciones nginx
```bash
sudo systemctl reload nginx
sudo systemctl restart nginx
```

### Agregar cerbot
```bash
sudo apt install certbot python3-certbot-nginx
```

### Generar certificado
```bash
sudo certbot --nginx -d bthsanjulian.website
```

## Error en el host

### Verificar hosts
```bash
sudo vim /etc/hosts
```

### Agregar IP
```bash
[IP_ADDRESS] bthsanjulian.website
```