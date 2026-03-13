# Instalacion y configuracion de Ubuntu Server

## Descarga del sistema operativo
- Pagina principal [Ubuntu Server](https://ubuntu.com/download/server)
- Seleccionar versiones LTS [Ubuntu Server LTS](https://ubuntu.com/download/alternative-downloads)
- Version LTS actual [Ubuntu Server 24.04](https://releases.ubuntu.com/noble/)

## Gestion de usuarios y credenciales
### Actualizar password del usuario root
```bash
passwd root
```

### Crear el usuario ubuntu
```bash
adduser ubuntu
```

### Agregar usuario ubuntu al grupo sudo
```bash
usermod -aG sudo ubuntu
```
> Salir del sistema operativo y volver a ingresar con el usuario **ubuntu**
```bash
exit
```

## Actualizacion del sistema operativo
### Actualizar lista de paquetes
```bash
sudo apt update
```

### Actualizar sistema operativo
```bash
sudo apt upgrade
```

## Instalacion de herramientas necesarias
### Instalar servidor ssh y herramientas de red
```bash
sudo apt install openssh-server net-tools
```

### Instalar paquetes necesarios (htop unzip sqlite3)
```bash
sudo apt-get install htop unzip sqlite3
```

## Configuracion regional del idioma del servidor
### Ver idiomas del sistema operativo
```bash
locale -a
```

### Configurar idiomas
```bash
sudo dpkg-reconfigure locales
```

### Establecer el idioma español de Bolivia
```bash
sudo update-locale LANG=es_BO.UTF-8
```

### Recargar el idioma generado
```bash
sudo source /etc/default/locale
```

### Ver configuraciones
```bash
sudo vim /etc/default/locale
```

## Configuracion regional de la fecha y hora del servidor
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

### Habilitar la sincronización con el servidor NTP
```bash
sudo timedatectl set-ntp on
```

### Ver fecha y zona horaria
```bash
timedatectl
```

## Seguridad firewall
### Instalar paquete ufw
```bash
sudo apt install ufw
```

### Habilitar puertos de servicios/virtualhosts
```bash
sudo ufw allow ssh
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 5432/tcp
sudo ufw allow 3306/tcp
```

### Habilitar ufw
```bash
sudo ufw enable
```

### Ver estado de servicios
```bash
sudo ufw status verbose
```