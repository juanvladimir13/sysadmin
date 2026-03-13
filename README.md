# Proyecto de Administración de Sistemas (Sysadmin)

Este repositorio contiene guías y configuraciones detalladas para la administración de servidores Linux (Ubuntu), bases de datos, servidores web y aplicaciones PHP.

## Descripción de Archivos

### Directorio Raíz
- **[README.md](README.md)**: Descripción general del proyecto y sus archivos.
- **[index.php](index.php)**: Ejemplo práctico de manejo de sesiones seguras en PHP, implementando mejores prácticas de seguridad.

### Base de Datos (`database/`)
- **[mysql.md](database/mysql.md)**: Guía completa de instalación, configuración inicial, gestión de usuarios y bases de datos en MySQL.
- **[postgres.md](database/postgres.md)**: Instrucciones para instalar PostgreSQL, configurar el usuario administrador, manejar zonas horarias y cambiar el propietario (owner) de bases de datos y tablas.

### E-commerce (`ecommerce/`)
- **[bagisto.md](ecommerce/bagisto.md)**: Documentación paso a paso para la instalación de Bagisto v2.3.7 sobre un servidor Apache.

### Lenguajes (`language/`)
- **[php.md](language/php.md)**: Guía de instalación de PHP 8.4, configuración de seguridad para sesiones, instalación de Composer y gestión de extensiones.

### Servidores (`server/`)
- **[ubuntu.md](server/ubuntu.md)**: Guía de configuración inicial para Ubuntu Server, incluyendo gestión de usuarios, actualización del sistema, configuración regional, sincronización horaria y firewall (UFW).

### Aplicaciones de Prueba (`tests/`)
- **[limesurvey.md](tests/limesurvey.md)**: Instrucciones detalladas para desplegar LimeSurvey, incluyendo requisitos de PHP y configuración de Virtual Host en Apache.

### Servidores Web (`web-servers/`)
- **[apache.md](web-servers/apache.md)**: Comandos esenciales para la instalación de Apache, habilitación de módulos (rewrite, headers) y gestión del servicio.
- **[nginx.md](web-servers/nginx.md)**: Guía avanzada de instalación de Nginx desde repositorios oficiales, optimización del motor y configuración global con PHP-FPM.
- **[virtual-nginx.md](web-servers/virtual-nginx.md)**: Configuración específica de Virtual Hosts para Nginx utilizando pools de PHP-FPM dedicados y sockets Unix.
- **[virtualhost-apache.md](web-servers/virtualhost-apache.md)**: Guía para la creación de Virtual Hosts en Apache, configuración de puertos y persistencia de sesiones PHP por sitio.
