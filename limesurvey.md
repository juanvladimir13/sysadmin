# Instalacion de Lime Survey

## 1. Requerimientos para la instalacion

https://www.limesurvey.org/manual/manual/Installation_-_LimeSurvey_CE/es

### Aplicaciones de servidor
- Espacio mínimo en disco de 250 MB.
- MariaDB 10.3.38 o posterior 
- MySQL 8 o posterior 
- Postgres 12 o posterior.

### Requisitos de la versión PHP:
- LS 6.x de PHP 7.4.x a 8.x
- LS 5.x de PHP 7.2.5 a 8.0.x
- LS 3.x de PHP 5.5.9 a 7.4.x

## 2. Verificar instalaciones previas
- hash, Zlib, session, openssl, fileinfo, SimpleXML
- Mysql Community
- Apache
- PHP 8.1

## 3. Administracion de la base de datos
### Crear base de datos
```bash
mysql -u root -p
```

```bash
CREATE DATABASE limesurvey_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Crear de usuario de base de datos
```
CREATE USER 'limesurvey_user'@'localhost'
IDENTIFIED BY 'limesurvey_password';
```

### Asignacion de privilegios de usuario a base de datos
```
GRANT ALL PRIVILEGES ON limesurvey_db.*
TO 'limesurvey_user'@'localhost'
WITH GRANT OPTION;
```

### Aplicar cambios de configuracion MySql
```
FLUSH PRIVILEGES;
```

Salir del CLI de mysql escribiendo `\q` presionar enter

## 4. Instalacion de modulos necesarios de PHP
```
sudo apt-get install php8.1-mbstring php8.1-imap php8.1-ldap php8.1-mysql php8.1-pgsql php8.1-zip php8.1-gd php8.1-mcrypt php8.1-xml php8.1-intl
```

> Verificar la configuración `short_open_tag` de php.ini este en `ON`

## 5. Configuracion del proyecto
> **Proyecto**: limesurvey1
>
> **Puerto**: 9001
>
> Todas las configuraciones se realizaran con este nombre, si cambia el nombre de proyecto o el puerto, debe cambiar en todos los lugares donde se esta utilizan estos datos

## 6. Descarga de instalador
https://community.limesurvey.org/downloads/

### Descargar Download LimeSurvey CE
Ingresar a la carpeta home
```bash
cd
```

```bash
wget https://download.limesurvey.org/latest-master/limesurvey6.15.15+250929.zip
```

```bash
sudo unzip limesurvey6.15.15+250929.zip -d .
```

```bash
sudo mv limesurvey /var/www/limesurvey1
```

### Modificar acceso a directorios
```bash
sudo chown -R www-data:www-data /var/www/limesurvey1
```

```bash
sudo chmod -R 777 /var/www/limesurvey1
```

## 7. Crear virtual host
Crear archivo de configuracion
```bash
sudo touch /etc/apache2/sites-available/limesurvey1.com.conf
```

```bash
sudo vim /etc/apache2/sites-available/limesurvey1.com.conf
```

Agregar el siguiente contenido, modificando el 9003, DocumentRoot y Directory por los datos que correspondan

```apache
<VirtualHost *:9001>
    ServerAdmin juanvladimir13@gmail.com
    #ServerName example.com
    #ServerAlias www.example.com
    DocumentRoot /var/www/limesurvey1/
    ErrorLog ${APACHE_LOG_DIR}/limesurvey1_error.log
    CustomLog ${APACHE_LOG_DIR}/limesurvey1_access.log combined

    <Directory /var/www/limesurvey1/>
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
Listen 9001
```

### Habilitar host
```bash
sudo a2ensite limesurvey1.com.conf
```

### Reiniciar apache
```bash
sudo systemctl reload apache2
```

```bash
sudo systemctl restart apache2
```

## 8. Datos para ingresar al sistema como administrador
Ingresar al enlace http://localhost:9004/admin

## 9. Proceso de eliminacion de datos para una nueva instalacion
### Quitar la web de apache
```bash
sudo a2dissite limesurvey1.com.conf
```

### Reiniciar el servidor
```bash
sudo systemctl reload apache2
```

### Elimnar la configuracion de virtual host
```bash
sudo rm -v /etc/apache2/sites-available/limesurvey1.com.conf
```

### Elimnar proyecto web
```bash
sudo rm -r /var/www/limesurvey1
```

### Eliminar base de datos
```bash
mysql -u root -p
```
```bash
drop database limesurvey_db;
```

### Eliminar usuario
```bash
drop user 'limesurvey_user'@'localhost';
```

Salir del CLI de mysql escribiendo `\q` presionar enter
