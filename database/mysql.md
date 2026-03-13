# Instalacion y configuracion de MySql
## Verificar la ultima version de mysql
[Pagina principal](https://dev.mysql.com/downloads/repo/apt/)

Modificar la version en los siguientes comandos

### Agregar repositorios de MySql Community
```bash
wget https://dev.mysql.com/get/mysql-apt-config_0.8.36-1_all.deb
```

### Instalar paquete
```bash
sudo dpkg -i mysql-apt-config_0.8.36-1_all.deb
```

### Actualizar paquetes
```bash
sudo apt update
```

### Instalacion de mysql
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
CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'password';
```

### Crear base de datos
```
CREATE DATABASE mi_base_de_datos
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;
```

### Asignar privilegios de usuario a la base de datos
```
GRANT ALL PRIVILEGES ON mi_base_de_datos.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;
```

> Configuracion
>
> sudo dpkg-reconfigure mysql-apt-config
>
> Configuracion
>
> sudo mysql_secure_installation

