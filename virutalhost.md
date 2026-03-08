## Crear virtual host

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
sudo touch /etc/apache2/sites-available/bagisto1.com.conf
```

### Editar archivo de configuracion
```bash
sudo vim /etc/apache2/sites-available/bagisto1.com.conf
```

Agregar el siguiente contenido, modificando el 9013, DocumentRoot y Directory por los datos que correspondan

```apache
<VirtualHost *:9013>
    ServerAdmin juanvladimir13@gmail.com
    #ServerName example.com
    #ServerAlias www.example.com
    DocumentRoot /var/www/bagisto1/
    ErrorLog ${APACHE_LOG_DIR}/bagisto1_error.log
    CustomLog ${APACHE_LOG_DIR}/bagisto1_access.log combined

    <Directory /var/www/bagisto1/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
</VirtualHost>
```

### Habilitar el puerto en apache
```bash
sudo vim /etc/apache2/ports.conf
```

### Agregar puerto
```apache
Listen 9013
```

### Habilitar host
```bash
sudo a2ensite bagisto1.com.conf
```

### Reiniciar apache

```bash
sudo systemctl reload apache2
```

```bash
sudo systemctl restart apache2
```