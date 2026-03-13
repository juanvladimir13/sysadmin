# Crear virtual host

**Consideraciones**

Servidor
- Ubuntu 24.04 LTS
- PHP 8.4
- Apache 2.4

Dominio
- El dominio es **bthsanjulian.website**
- El puerto es **8000**
- El usuario es **www-data** y grupo es **www-data**
- El directorio es **/var/www/bth.webapp**
- El archivo de configuracion **/etc/apache2/sites-available/bth.webapp.conf**

PHP
- Directorio de sesiones PHP **/var/lib/php/sessions/bth.webapp**

## Habilitar puertos en apache
### Agregar puertos a utilizar
```bash
sudo vim /etc/apache2/ports.conf
```

### Agregar puerto
```apache
Listen 8000
```

### Habilitar puerto el el firewal
```bash
sudo ufw allow 8000/tcp
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
	Options Indexes FollowSymLinks
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
    DocumentRoot /var/www/bth.webapp/
    ErrorLog ${APACHE_LOG_DIR}/bth.webapp_error.log
    CustomLog ${APACHE_LOG_DIR}/bth.webapp_access.log combined

    php_value session.name "bth.webapp"
    php_value session.save_path "/var/lib/php/sessions/bth.webapp"

    <Directory /var/www/bth.webapp/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
</VirtualHost>
```

### Verificar sintaxis de configuraciones de virtual hosts
```bash
sudo apachectl configtest
```

```bash
apache2ctl -t
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