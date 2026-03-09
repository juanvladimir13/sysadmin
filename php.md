# Configuracion de php

## Crear directorio de sesiones
```bash
sudo mkdir -p /var/lib/php/sessions
```

```bash
sudo chown -R www-data:www-data /var/lib/php/sessions
```

```bash
sudo chmod 1733 /var/lib/php/sessions
```

```bash
sudo ls -ld /var/lib/php/sessions
```

## Modificar archivo php.ini para apache
```bash
sudo vim /etc/php/8.4/apache2/php.ini
```

- Agregar el siguiente contenido:
```ini
; DIRECTORIO DE SESIONES
session.save_handler = files
session.save_path = "/var/lib/php/sessions"

; SEGURIDAD
session.use_strict_mode = 1
session.use_only_cookies = 1
session.cookie_httponly = 1
session.cookie_secure = 1 ; Cámbialo a 0 si no tienes SSL (pero consíguelo pronto)

; PROTECCION CSRF / SESSION FIXATION
session.cookie_samesite = Lax

; TIEMPO DE VIDA
session.gc_maxlifetime = 1440

; PROBABILIDAD DE LIMPIEZA
session.gc_probability = 1
session.gc_divisor = 1000

; LONGITUD Y ENTROPIA
session.sid_length = 48
session.sid_bits_per_character = 6

; NOMBRE DE SESION
session.name = PHPSESSID
```

## Habilitar modulos para encabezados HTTP
```bash
sudo a2enmod headers
```

```bash
sudo vim /etc/apache2/conf-available/security.conf
```

- Agregar el siguiente contenido:
```ini
Header always edit Set-Cookie ^(.*)$ $1;HttpOnly;Secure;SameSite=Lax
```

## Verificar configuracion de sesiones
```bash
sudo cat /usr/lib/tmpfiles.d/php.conf
```

## Verificar configuracion de sesiones
```bash
session_regenerate_id(true);
```

## Configurar nombre de sesion por virtualhost
```bash
<VirtualHost *:80>
  ServerName sitio1.com
  DocumentRoot /var/www/sitio1

  # Nombre de sesión único para este Virtual Host
  php_value session.name "SESSID_SITIO_1"
  
  # Opcional: Ruta única para los archivos de sesión (Altamente recomendado por seguridad)
  php_value session.save_path "/var/www/sitio1/sessions"
</VirtualHost>
```