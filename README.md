# Configuracion de sistema operativo Ubuntu Server 

## Descarga del sistema operativo
- Pagina principal https://ubuntu.com/download/server
- Seleccionar versiones LTS https://ubuntu.com/download/alternative-downloads
- Version 22.04 https://releases.ubuntu.com/jammy/

### Actualizar sistema operativo
```bash
sudo apt-get update
```

```bash
sudo apt-get upgrade
```

### Instalar paquetes para conexion remota
```bash
sudo apt-get install openssh-server net-tools
```

### Idiomas del sistema operativo
```bash
locale -a
```

### Configurar idiomas
```bash
sudo dpkg-reconfigure locales
```

### Ver idiomas
```bash
locale
```

### Configuraciones
```bash
sudo vim /etc/default/locale
```

### Ver formato de fecha y hora
```bash
date
```

### Ver la zona horaria
```bash
cat /etc/timezone
```

### Modificar la zona horaria
```bash
sudo timedatectl set-timezone "America/La_Paz"
```

### Habilitar la sincronización
```bash
sudo timedatectl set-ntp on
```

### Ver fecha y zona horaria
```bash
timedatectl
```

## Instalacion y configuracion de apache

### Agregar repositorio de apache
```bash
sudo add-apt-repository ppa:ondrej/apache2
```

### Instalar apache
```bash
sudo apt install apache2
```

### Configuraciones apache
```bash
sudo a2enmod rewrite
```

```bash
sudo a2enmod headers
```

```bash
sudo a2enmod env
```

### Verificar comandos
```bash
man a2ensite
```

```bash
man a2dissite
```

### Recargar servicios de apache
```bash
sudo systemctl restart apache2
```

```bash
sudo systemctl reload apache2
```

## Instalacion y configuracion de MySql
### Agregar repositorios de MySql Community
```bash
wget https://dev.mysql.com/get/mysql-apt-config_0.8.34-1_all.deb
```
### Instalar paquete
```bash
sudo dpkg -i mysql-apt-config_0.8.34-1_all.deb
```

### Actualizar paquetes
```bash
sudo apt update
```

### Instalacion de MySql
```bash
sudo apt install mysql-server
```

### Habilitar servicio de base de datos
```bash
sudo systemctl enable mysql
```

### Verificar estados del servicio
```bash
sudo systemctl start mysql
```

```bash
sudo systemctl status mysql
```

### Modificar zona horaria
```bash
sudo vim /etc/mysql/my.cnf
```

> Agregar
```bash
[mysqld]
default-time-zone = 'America/La_Paz'
```

### Aplicar cambios
```bash
sudo systemctl restart mysql
```

### Ingresar al MySql
```
mysql -u root -p
```

### Crear usuario
```
CREATE USER 'juanvladimir13'@'localhost' IDENTIFIED BY 'password';
```
### Crear base de datos
```
CREATE DATABASE mi_base_de_datos
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;
```

### Asignar privilegios de usuario a la base de datos
```
GRANT ALL PRIVILEGES ON mi_base_de_datos.* TO 'juanvladimir13'@'localhost';
FLUSH PRIVILEGES;
```

> Configuracion
>
> sudo dpkg-reconfigure mysql-apt-config
>
> Configuracion
>
> sudo mysql_secure_installation

## Instalacion de php
### Repositorio de php
```bash
sudo add-apt-repository ppa:ondrej/php
```

### Instalacion de php
```bash
sudo apt install php php-cli php-fpm
```

### Instalacion de modulos de apache
```bash
sudo apt install libapache2-mod-php
```

## Instalacion de composer
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```

```bash
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

### Agregar a las variables de entorno del sistema
```bash
sudo mv composer.phar /usr/local/bin/composer
```

## Configurar php para apache
```bash
sudo vim /etc/php/8.2/apache2/php.ini
```

Agregar al final del archivo
> date.timezone = "America/La_Paz"
>
> short_open_tag = On

### Recargar servicios de apache
```bash
sudo systemctl restart apache2
```

```bash
sudo systemctl reload apache2
```




