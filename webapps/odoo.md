# Instalacion de odoo

## Ubuntu Server 24.04 LTS

### Credenciales
- **user:** si
- **password:** bthsanjulian

### Acceso por ssh 
```bash
ssh si@192.168.56.13
```

## Habilitar el firewall
### Habilitar puerto 8069
```bash
sudo ufw allow 8069/tcp
```

### Verificar puertos habilitados en el firewall
```bash
sudo ufw status
```

## Repositorios

```bash
wget -q -O - https://nightly.odoo.com/odoo.key | sudo gpg --dearmor -o /usr/share/keyrings/odoo-archive-keyring.gpg
```

### odoo 19

```bash
echo 'deb [signed-by=/usr/share/keyrings/odoo-archive-keyring.gpg] https://nightly.odoo.com/19.0/nightly/deb/ ./' | sudo tee /etc/apt/sources.list.d/odoo.list
```

### odoo 18

```bash
echo 'deb [signed-by=/usr/share/keyrings/odoo-archive-keyring.gpg] https://nightly.odoo.com/18.0/nightly/deb/ ./' | sudo tee /etc/apt/sources.list.d/odoo.list
```

### Instalacion

```bash
sudo apt-get update && sudo apt-get install odoo
```

### Post Instalacion

```bash
sudo apt-get install fontconfig xfonts-75dpi xfonts-base
```

```bash
wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-3/wkhtmltox_0.12.6.1-3.jammy_amd64.deb
```

```bash
sudo dpkg -i wkhtmltox_0.12.6.1-3.jammy_amd64.deb
```

### Iniciar odoo
- Abrir un navegador web
- introducir la url [192.168.56.13:8069](192.168.56.13:8069)
- Introducir todas las credenciales e iniciar

### Instalacion de modulos en odoo
- Modulo de ventas
```bash
sudo -u odoo odoo -c /etc/odoo/odoo.conf -d odoo -i sale --stop-after-init
```

- Modulo de punto de venta
- ```bash
sudo -u odoo odoo -c /etc/odoo/odoo.conf -d odoo -i point_of_sale --stop-after-init
```

- Modulo de compras
```bash
sudo -u odoo odoo -c /etc/odoo/odoo.conf -d odoo -i purchase --stop-after-init
```
