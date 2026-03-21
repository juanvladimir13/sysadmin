# Instalacion de odoo

## Ubuntu Server 24.04 LTS

### Credenciales
- **user:** si
- **password:** bthsanjulian

### Acceso por ssh 
```bash
ssh si@192.168.56.13
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
sudo apt install fontconfig xfonts-75dpi xfonts-base
```

```bash
wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-3/wkhtmltox_0.12.6.1-3.jammy_amd64.deb
```

```bash
sudo dpkg -i wkhtmltox_0.12.6.1-3.jammy_amd64.deb
```