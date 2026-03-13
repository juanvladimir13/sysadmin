## Instalacion y configuracion de apache

### Agregar repositorio de apache
```bash
sudo add-apt-repository ppa:ondrej/apache2
```

### Instalar apache
```bash
sudo apt install apache2
```

### Habilitar modulos de apache
```bash
sudo a2enmod rewrite
```

```bash
sudo a2enmod headers
```

```bash
sudo a2enmod env
```

### Verificar comandos para habilitar virtualhosts
```bash
man a2ensite
```

```bash
man a2dissite
```

### Recargar servicios de apache
```bash
sudo systemctl reload apache2
```
```bash
sudo systemctl restart apache2
```

### Detener el servicio de apache y deshabilitar su inicio automatico (solo desktop)
```bash
sudo systemctl stop apache2
sudo systemctl disable apache2
```
