# Proyecto de Administración de Sistemas (Sysadmin)

Este repositorio contiene guías y configuraciones detalladas para la administración de servidores Linux (Ubuntu), bases de datos, servidores web y aplicaciones web.

## Descripción de Archivos

### Directorio Raíz
- **[README.md](README.md)**: Descripción general del proyecto y sus archivos.
- **[index.php](index.php)**: Ejemplo práctico de manejo de sesiones seguras en PHP, implementando mejores prácticas de seguridad.

### Base de Datos (`database/`)
- **[mysql.md](database/mysql.md)**: Guía completa de instalación, configuración inicial, gestión de usuarios y bases de datos en MySQL.
- **[postgres.md](database/postgres.md)**: Instrucciones para instalar PostgreSQL, configurar el usuario administrador, manejar zonas horarias y cambiar el propietario (owner) de bases de datos y tablas.

### Lenguajes (`language/`)
- **[django.md](language/django.md)**: Configuración de Django para despliegue, creación de entorno virtual, seguridad HTTP/HTTPS y recolección de archivos estáticos.
- **[php.md](language/php.md)**: Guía de instalación de PHP 8.4, configuración de seguridad para sesiones, instalación de Composer y gestión de extensiones.

### Máquinas Virtuales (`virtual-machine/`)
- **[virtualbox.md](virtual-machine/virtualbox.md)**: Configuración de red e IP estática en VirtualBox 7.2 con Ubuntu Server.

### Servidores (`server/`)
- **[ubuntu.md](server/ubuntu.md)**: Guía de configuración inicial para Ubuntu Server, incluyendo gestión de usuarios, actualización del sistema, configuración regional, sincronización horaria y firewall (UFW).

### Servidores Web (`web-servers/`)
- **[apache-php.md](web-servers/apache-php.md)**: Guía para crear y habilitar un Virtual Host en Apache para aplicaciones PHP (8.4) con configuraciones de seguridad.
- **[apache.md](web-servers/apache.md)**: Comandos esenciales para la instalación de Apache, habilitación de módulos (rewrite, headers) y gestión del servicio.
- **[nginx-django.md](web-servers/nginx-django.md)**: Configuración de Nginx y uWSGI como proxy inverso para proyectos Django.
- **[nginx-php.md](web-servers/nginx-php.md)**: Configuración avanzada de PHP-FPM con Nginx, ajustando pools y creando Virtual Hosts.
- **[nginx.md](web-servers/nginx.md)**: Guía avanzada de instalación de Nginx desde repositorios oficiales, optimización del motor y configuración global con PHP-FPM.

### Aplicaciones Web (`webapps/`)
- **[bagisto.md](webapps/bagisto.md)**: Documentación paso a paso para la instalación de Bagisto v2.3.7 sobre servidor Apache.
- **[limesurvey.md](webapps/limesurvey.md)**: Instrucciones detalladas para instalar y desplegar LimeSurvey CE.
- **[nextcloud.md](webapps/nextcloud.md)**: Configuración básica de Virtual Host en Apache para Nextcloud.
- **[odoo.md](webapps/odoo.md)**: Guía de instalación de Odoo 18/19 en Ubuntu Server mediante repositorios y utilidades de pdf.
