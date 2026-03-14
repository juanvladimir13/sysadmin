# Configuracion de Django para nginx y uwsgi

## Entorno de hardware y software
### Servidor
| Característica | Detalle |
| :--- | :--- |
| Sistema Operativo | Ubuntu 24.04 LTS |
| Servidor Web | Nginx 1.28 |
| Lenguaje | Python 3.12 |
| Framework | Django 5.2 |
| Proxy inverso | uwsgi 2.0.25 |

### Dominio y control de acceso
| Propiedad | Valor |
| :--- | :--- |
| Dominio | bthsanjulian.website |
| Puerto | 8080 |
| Usuario | www-data |
| Grupo | www-data |
| Directorio | /var/www/bth.webapp |
| Archivo de configuracion | /etc/nginx/sites-available/bth.webapp |

### Python
| Configuración | Ruta |
| :--- | :--- |
| Directorio de webserver | /etc/uwsgi/sites |
| Directorio de log | /var/log/uwsgi |
| Socket de uwsgi | unix:///run/bth.webapp.sock |

### Instalar dependencias en el servidor

```bash
sudo apt install uwsgi-plugin-python3
```

### Crear directorio de configuracion de uwsgi
```bash
sudo mkdir -p /etc/uwsgi/sites
sudo mkdir -p /var/log/uwsgi
```

### Configurar permisos de uwsgi

```bash
sudo chown -R www-data:www-data /etc/uwsgi
sudo chmod -R 664 /etc/uwsgi
sudo chown -R www-data:www-data /var/log/uwsgi
sudo chmod -R 664 /var/log/uwsgi
```

## Configurar virtual host de nginx

```bash
sudo vim /etc/nginx/sites-available/bth.webapp
```

```nginx
upstream django {
    server unix:///run/bth.webapp.sock;
}

server {
    listen      8080;
    server_name localhost;
    charset     utf-8;

    client_max_body_size 75M;

    # Habilitar compresión Gzip para mejorar el rendimiento
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

    location /media  {
        alias /var/www/bth.webapp/media;
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }

    location /static {
        alias /var/www/bth.webapp/static;
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }

    location / {
        uwsgi_pass  django;
        include     uwsgi_params;
    }

    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "DENY" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
}
```

### Verificar configuracion de nginx
```bash
sudo nginx -t
```

### Habilitar virtual host de nginx
```bash
sudo ln -s /etc/nginx/sites-available/bth.webapp /etc/nginx/sites-enabled/
```

### Reiniciar los servicios
```bash
sudo /etc/init.d/nginx restart
```

## Crea un archivo llamado `bth.webapp.ini`:

```bash
sudo vim /etc/uwsgi/sites/bth.webapp.ini
```

```ini
[uwsgi]
chdir           = /var/www/bth.webapp
module          = repositorio_bth.wsgi
home            = /opt/venv/bth.webapp
virtualenv      = /opt/venv/bth.webapp
master          = true
processes       = 4
threads         = 2
enable-threads  = true
max-requests    = 5000
harakiri        = 60
buffer-size     = 32768
socket          = /run/bth.webapp.sock
vacuum          = true

logto           = /var/log/uwsgi/bth.webapp.log

uid = www-data
gid = www-data
chown-socket = www-data:www-data
chmod-socket = 660
```

### Habilitar puerto en el firewal
```bash
sudo ufw allow 8080/tcp
```

### Ejecutar webapp
```bash
uwsgi --ini /etc/uwsgi/sites/bth.webapp.ini
```