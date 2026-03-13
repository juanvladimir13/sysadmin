# Configuracion de php-fpm para Ubuntu Server con nginx

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

    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm-bth.webapp.sock;
        fastcgi_read_timeout 60;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Caché para archivos estáticos
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|otf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
        access_log off;
    }

    location ~ /\.ht {
        deny all;
    }
    
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