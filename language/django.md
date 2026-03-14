# Configurar django para deploy

## Crear entono de ejecucion
### Crear entorno virtual
```bash
python3 -m venv /opt/venv/bth.webapp
```

### Activar entorno virtual
```bash
source /opt/venv/bth.webapp/bin/activate
```

### Ingresar al proyecto
```bash
cd /var/www/bth.webapp
```

### Instalar dependencias de la aplicacion
```bash
pip3 install -r requirements.txt
```

## Configurar settings.py

### Personalizar configuraciones
```python
import os
ALLOWED_HOSTS = ['midominio.com', 'www.midominio.com', 'tu_ip_publica']
DEBUG = False

STATIC_URL = '/static/'
STATIC_ROOT = os.path.join(BASE_DIR, "static/")

MEDIA_URL = '/media/'
MEDIA_ROOT = os.path.join(BASE_DIR, "media/")
```
### Seguridad HTTP
```python
SECURE_CONTENT_TYPE_NOSNIFF = True
SECURE_BROWSER_XSS_FILTER = True
X_FRAME_OPTIONS = 'DENY'
```

### Seguridad HTTPS
```python
if not DEBUG:
    SECURE_HSTS_SECONDS = 31536000 
    SECURE_HSTS_INCLUDE_SUBDOMAINS = True
    SECURE_HSTS_PRELOAD = True

    SECURE_SSL_REDIRECT = True
    SESSION_COOKIE_SECURE = True
    CSRF_COOKIE_SECURE = True
    SECURE_PROXY_SSL_HEADER = ('HTTP_X_FORWARDED_PROTO', 'https')
```

### Generar secret key
```bash
python3 -c "from django.core.management.utils import get_random_secret_key; print(get_random_secret_key())"
```

### Reemplazar en settings.py
```python
SECRET_KEY = 'tu-secret-key-generada'
```

## Configurar archivos estaticos

### Generar archivos estaticos
```bash
python3 manage.py collectstatic --dry-run --noinput
```

## Verificar proyecto django para deploy

### Permisos de directorios del proyecto
```bash
sudo chown -R www-data:www-data /var/www/bth.webapp
sudo chmod -R 755 /var/www/bth.webapp
```

### Verificar migraciones pendientes
```bash
python3 manage.py migrate --check
```

### Verificar proyecto django para deploy
```bash
python3 manage.py check --deploy
```

### Probar en modo producción local
```bash
python3 manage.py runserver --insecure 0.0.0.0:8000
```