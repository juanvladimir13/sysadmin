# Configuracion de php-fpm para Ubuntu Server con nginx

## Entorno de hardware y software
### Servidor
| Característica | Detalle |
| :--- | :--- |
| Sistema Operativo | Ubuntu 24.04 LTS |
| Servidor Web | Nginx 1.28 |
| Lenguaje | PHP 8.4 |

### Dominio y control de acceso
| Propiedad | Valor |
| :--- | :--- |
| Dominio | bthsanjulian.website |
| Puerto | 8000 |
| Usuario | www-data |
| Grupo | www-data |
| Directorio | /var/www/bth.webapp |
| Archivo de configuracion | /etc/nginx/sites-available/bth.webapp |

### PHP
| Configuración | Ruta |
| :--- | :--- |
| Directorio de sesiones | /var/lib/php/sessions/bth.webapp |
| Archivo pool.d | /etc/php/8.4/fpm/pool.d/bth.webapp.conf |
| Socket de php-fpm | /run/php/php8.4-fpm-bth.webapp.sock |


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
# Optimización de subidas
post_max_size = 64M
upload_max_filesize = 64M
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

## Configuracion de php-fpm para un sitio web

### Crear directorio para sesiones PHP
```bash
sudo mkdir -p /var/lib/php/sessions/bth.webapp
sudo chown www-data:www-data /var/lib/php/sessions/bth.webapp
sudo chmod 700 /var/lib/php/sessions/bth.webapp
```

## Crear virtual host para bth.webapp

### Agregar permisos de grupo usuario al sitio web
```bash
sudo chown -R www-data:www-data /var/www/bth.webapp
```

### Modificar permisos
```bash
sudo chmod -R 755 /var/www/bth.webapp
```

### Crear pool php-fpm para bth.webapp
```bash
sudo vim /etc/php/8.4/fpm/pool.d/bth.webapp.conf
```

### Configuracion php-fpm para bth.webapp
```ini
[bth.webapp]
user = www-data
group = www-data
listen = /run/php/php8.4-fpm-bth.webapp.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = dynamic
pm.max_children = 40
pm.start_servers = 8
pm.min_spare_servers = 4
pm.max_spare_servers = 12

pm.max_requests = 500

# Redirigir salida de errores a Nginx
catch_workers_output = yes
php_admin_flag[log_errors] = on
php_admin_value[error_log] = /var/log/fpm-php.bth.webapp.log
request_terminate_timeout = 60s

php_value[session.name] = bth.webapp
php_value[session.save_path] = /var/lib/php/sessions/bth.webapp
```

### Crear el archivo de configuracion
```bash
sudo vim /etc/nginx/sites-available/bth.webapp
```

```nginx
server {
    listen 8000;
    #server_name bthsanjulian.website;

    root /var/www/bth.webapp/public;
    index index.php index.html;

    access_log /var/log/nginx/bth_webapp_access.log;
    error_log /var/log/nginx/bth_webapp_error.log warn;

	#ssl_certificate     /etc/letsencrypt/live/bthsanjulian.website/fullchain.pem;
    #ssl_certificate_key /etc/letsencrypt/live/bthsanjulian.website/privkey.pem;

    #include /etc/letsencrypt/options-ssl-nginx.conf;
    #ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;
    
    # HSTS (Habilitar solo después de verificar funcionamiento de SSL)
    # add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    include snippets/security.conf;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Procesar archivos PHP usando el snippet global
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm-bth.webapp.sock;
        fastcgi_read_timeout 60;
    }

    # Caché para archivos estáticos
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|otf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
        access_log off;
    }

    # Denegar acceso a archivos ocultos (dotfiles)
    location ~ /\.(?!well-known).* {
        deny all;
        access_log off;
        log_not_found off;
    }
    
    # Configuración de CORS
    add_header Access-Control-Allow-Origin "*" always;
    add_header Access-Control-Allow-Methods "GET, POST, OPTIONS, PUT, DELETE" always;
    add_header Access-Control-Allow-Headers "Origin, Content-Type, Authorization, X-Requested-With, Accept" always;
    add_header Access-Control-Allow-Credentials "true" always;

    # Manejo de preflight OPTIONS
    if ($request_method = OPTIONS) {
        return 204;
    }
}
```

### Activar el virtual host

```bash
sudo ln -s /etc/nginx/sites-available/bth.webapp /etc/nginx/sites-enabled/
```

### Verificar configuracion
```bash
sudo nginx -t
```

### Reiniciar servicios
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.4-fpm
```

## Verificar pool de conexiones PHP-FPM
```bash
ps aux | grep php-fpm
```

### Verificar pool
```bash
ls /run/php/
```

### Habilitar puerto en el firewal
```bash
sudo ufw allow 8000/tcp
```