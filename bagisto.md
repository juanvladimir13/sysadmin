# Instalacion de bagisto
## Requerimientos para la Bagisto v2.3.7
https://github.com/bagisto/bagisto/blob/master/README.md#getting-started

- Ubuntu 16.04 LTS or Higher / Windows 7 or Higher (WAMP / XAMPP)
- SERVER - Apache 2 or NGINX
- RAM - 4 GB or Higher
- PHP - 8.1 or Higher
- Processor - Clock Cycle 1Ghz or Higher
- Mysql - 8.0.32 or Higher
- MariaDB users - 10.3 or Higher
- Node - 18.12.0 LTS or Higher
- Composer - 2.5 or Higher

## Instalaciones previas
- Mysql Community
- Apache
- PHP 8.1

### Instalacion de PHP y modulos necesarios
```bash
sudo apt-get install php8.1-intl php8.1-gd php8.1-mbstring php8.1-curl php8.1-mysql
```

> Verificar aplicaciones instaladas en el servidor: openssl, tokenizer, json

## Configuracion del proyecto
> **Proyecto**: bagisto1
>
> **Puerto**: 9003
>
> Todas las configuraciones se realizaran con este nombre, si cambia el nombre de proyecto o el puerto, debe cambiar en todos los lugares donde se esta utilizan estos datos

## Crear base de datos
```bash
mysql -u root -p
```

```bash
CREATE DATABASE bagisto_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;
```

## Crear de usuario de base de datos
```bash
CREATE USER 'bagisto_user'@'localhost'
IDENTIFIED WITH caching_sha2_password
BY 'bagisto_password';
```

## Asignacion de privilegios de usuario a base de datos
```bash
GRANT ALL PRIVILEGES ON bagisto_db.*
TO 'bagisto_user'@'localhost'
WITH GRANT OPTION;
```

## Aplicar cambios de configuracion MySql
```bash
FLUSH PRIVILEGES;
```

Salir del CLI de mysql escribiendo `\q` presionar enter

### Crear virtual host
Crear archivo de configuracion
```bash
sudo touch /etc/apache2/sites-available/bagisto1.com.conf
```

```bash
sudo vim /etc/apache2/sites-available/bagisto1.com.conf
```

Agregar el siguiente contenido, modificando el 9003, DocumentRoot y Directory por los datos que correspondan

```apache
<VirtualHost *:9003>
    ServerAdmin juanvladimir13@gmail.com
    #ServerName example.com
    #ServerAlias www.example.com
    DocumentRoot /var/www/bagisto1/public
    ErrorLog ${APACHE_LOG_DIR}/bagisto1_error.log
    CustomLog ${APACHE_LOG_DIR}/bagisto1_access.log combined

    <Directory /var/www/bagisto1/public>
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
Agregar
```apache
Listen 9003
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

### Crear proyecto
### Ingresar a la carpeta www
```bash
cd /var/www
```

```bash
sudo composer create-project bagisto/bagisto bagisto1
```

### Modificar acceso a directorios
```bash
sudo chown -R www-data:www-data /var/www/bagisto1
```
```bash
sudo chmod -R 777 /var/www/bagisto1
```

### Ingresar a la carpeta del proyecto
```bash
cd /var/www/bagisto1
```

### Modificar las credenciales de acceso
```bash
sudo vim .env
```

```
APP_DEBUG=false
APP_URL = http://localhost:9003
APP_TIMEZONE=America/La_Paz
APP_LOCALE=es
APP_CURRENCY=BOB
DB_DATABASE=bagisto_db
DB_USERNAME=bagisto_user
DB_PASSWORD=bagisto_password
```

### Instalar bagisto
```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

```bash
php artisan vendor:publish
```

```bash
php artisan storage:link
```

### Datos para ingresar al sistema como administrador
Ingresar al enlace http://localhost:9003/admin

> Email: admin@example.com
>
> Password: admin123

# Proceso de eliminacion de datos para una nueva instalacion
## Quitar la web de apache
```bash
sudo a2dissite bagisto1.com.conf
```

## Reiniciar el servidor
```bash
sudo systemctl reload apache2
```

## Elimnar la configuracion de virtual host
```bash
sudo rm -v /etc/apache2/sites-available/bagisto1.com.conf
```

## Elimnar proyecto web
```bash
sudo rm -r /var/www/bagisto1
```

## Eliminar base de datos
```bash
mysql -u root -p
```
## Eliminar usuario
```bash
drop database bagisto_db;
```

## Eliminar usuario
```bash
drop user 'bagisto_user'@'localhost';
```

Salir del CLI de mysql escribiendo `\q` presionar enter