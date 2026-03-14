# Crear virtual host

## Entorno de hardware y software
### Servidor
| Característica | Detalle |
| :--- | :--- |
| Sistema Operativo | Ubuntu 24.04 LTS |
| Servidor Web | Apache 2.4 |
| Lenguaje | PHP 8.4 |

### Dominio y control de acceso
| Propiedad | Valor |
| :--- | :--- |
| Dominio | bthsanjulian.website |
| Puerto | 8000 |
| Usuario | www-data |
| Grupo | www-data |
| Directorio | /var/www/bth.webapp |
| Archivo de configuracion | /etc/apache2/sites-available/bth.webapp.conf |

### PHP
| Configuración | Ruta |
| :--- | :--- |
| Directorio de sesiones | /var/lib/php/sessions/bth.webapp |

## Habilitar puertos en apache
### Agregar puertos a utilizar
```bash
sudo vim /etc/apache2/ports.conf
```

### Agregar puerto
```apache
Listen 8000
```

### Crear directorio para sesiones PHP
```bash
sudo mkdir -p /var/lib/php/sessions/bth.webapp
sudo chown www-data:www-data /var/lib/php/sessions/bth.webapp
sudo chmod 700 /var/lib/php/sessions/bth.webapp
```

### Configurar virtualhost de apache
```bash
sudo vim /etc/apache2/sites-available/000-default.conf
```

```apache
<Directory /var/www>
	Options -Indexes +FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```

### Crear archivo de configuracion
```bash
sudo vim /etc/apache2/sites-available/bth.webapp.conf
```

```apache
<VirtualHost *:8000>
    ServerAdmin juanvladimir13@gmail.com
    #ServerName bthsanjulian.website
    #ServerAlias bthsanjulian.website
    DocumentRoot /var/www/bth.webapp/public

    ErrorLog ${APACHE_LOG_DIR}/bth_webapp_error.log
    CustomLog ${APACHE_LOG_DIR}/bth_webapp_access.log combined

    # Sesiones PHP (Solo si se usa mod_php)
    # php_value session.name "bth.webapp"
    # php_value session.save_path "/var/lib/php/sessions/bth.webapp"

    <Directory /var/www/bth.webapp/public>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    # Bloquear archivos sensibles
    <FilesMatch "^\.|\.(env|log|git|sh|sql|bak|inc|ini|conf)$">
        Require all denied
    </FilesMatch>

    # Cabeceras de seguridad adicionales
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    Header set Permissions-Policy "geolocation=(), microphone=(), camera=()"

    # Soporte CORS
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, OPTIONS, PUT, DELETE"
    Header always set Access-Control-Allow-Headers "Origin, Content-Type, Authorization, X-Requested-With, Accept"
    Header always set Access-Control-Allow-Credentials "true"

    # Compresión Gzip (mod_deflate)
    <IfModule mod_deflate.module>
        AddOutputFilterByType DEFLATE text/plain text/html text/xml text/css application/xml application/xhtml+xml application/rss+xml application/javascript application/x-javascript application/json image/svg+xml
    </IfModule>

    # Caché del navegador (mod_expires)
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresDefault "access plus 1 month"
        ExpiresByType image/x-icon "access plus 1 year"
        ExpiresByType image/jpeg "access plus 1 month"
        ExpiresByType image/png "access plus 1 month"
        ExpiresByType image/gif "access plus 1 month"
        ExpiresByType text/css "access plus 1 month"
        ExpiresByType application/javascript "access plus 1 month"
    </IfModule>

</VirtualHost>
```

### Verificar sintaxis de configuraciones de virtual hosts
```bash
sudo apachectl configtest
```

### Habilitar puerto el el firewal
```bash
sudo ufw allow 8000/tcp
```

### Habilitar host
```bash
sudo a2ensite bth.webapp.conf
```

### Reiniciar apache
```bash
sudo systemctl reload apache2
sudo systemctl restart apache2
```