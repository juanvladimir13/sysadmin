### Crear virtual host
Crear archivo de configuracion
```bash
sudo touch /etc/apache2/sites-available/bagisto1.com.conf
```

```bash
sudo vim /etc/apache2/sites-available/bagisto1.com.conf
```
### Habilitar el puerto en apache
```bash
sudo vim /etc/apache2/ports.conf
```
Agregar
```apache
Listen 9012
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


## Configurar virtualhost de apache
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
