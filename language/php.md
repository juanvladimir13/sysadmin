# Instalacion y configuracion de php

## Instalacion de php
### Agregar repositorio de php
```bash
sudo add-apt-repository ppa:ondrej/php
```

### Instalacion del core de php
```bash
sudo apt install php php-cli php-fpm php-cgi php-common php-xml php-mbstring php-gd php-pgsql php-zip libapache2-mod-php
```

## Configurar la fecha y hora regional de php
```bash
sudo vim /etc/php/8.4/apache2/php.ini
sudo vim /etc/php/8.4/cli/php.ini
sudo vim /etc/php/8.4/fpm/php.ini
```

```ini
date.timezone = "America/La_Paz"
short_open_tag = On
```

## Modificar archivo php.ini para todos los servicios
```bash
sudo vim /etc/php/8.4/apache2/php.ini
sudo vim /etc/php/8.4/cli/php.ini
sudo vim /etc/php/8.4/fpm/php.ini
```

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

```ini
Header always edit Set-Cookie ^(.*)$ $1;HttpOnly;Secure;SameSite=Lax
```

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

### Verificar configuracion de sesiones
```bash
sudo cat /usr/lib/tmpfiles.d/php.conf
```

### Verificar configuracion de sesiones
```bash
session_regenerate_id(true);
```

## Instalacion de composer
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```

```bash
php composer-setup.php
```

```bash
php -r "unlink('composer-setup.php');"
```

### Agregar a las variables de entorno del sistema
```bash
sudo mv composer.phar /usr/local/bin/composer
```

### Verificar modulos para instalar de un proyecto
```bash
composer check-platform-reqs
```