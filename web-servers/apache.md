## Instalacion y configuracion de apache

### Agregar repositorio de apache
```bash
sudo add-apt-repository ppa:ondrej/apache2
```

### Instalar apache
```bash
sudo apt install apache2
```

### Habilitar modulos esenciales de apache
```bash
# Reescritura y Cabeceras
sudo a2enmod rewrite headers env

# Rendimiento (Compresión y Caché)
sudo a2enmod deflate filter expires

# Seguridad y Protocolos
sudo a2enmod ssl http2

# Proxy (para PHP-FPM si se usa)
sudo a2enmod proxy proxy_fcgi
```

### Configuracion de seguridad global
```bash
sudo vim /etc/apache2/conf-available/security.conf
```

```apache
# Ocultar versión de apache
ServerTokens Prod
ServerSignature Off
TraceEnable Off

# Cabeceras de seguridad globales
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
```

### Ajuste de rendimiento MPM Event
```bash
sudo vim /etc/apache2/mods-available/mpm_event.conf
```

```apache
<IfModule mpm_event_module>
    StartServers             3
    MinSpareThreads          25
    MaxSpareThreads          75
    ThreadLimit              64
    ThreadsPerChild          25
    MaxRequestWorkers        150
    MaxConnectionsPerChild   0
</IfModule>
```

### Verificar comandos para habilitar virtualhosts
```bash
man a2ensite
```

```bash
man a2dissite
```

### Recargar servicios de apache
```bash
sudo apachectl configtest
sudo systemctl reload apache2
sudo systemctl restart apache2
```

### Detener el servicio de apache y deshabilitar su inicio automatico (solo desktop)
```bash
sudo systemctl stop apache2
sudo systemctl disable apache2
```
