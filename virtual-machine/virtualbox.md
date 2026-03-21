# Configuracion de virtualbox 7.2 con IP estatica

## Confgiracion de red

### Crear red
- Menu -> network -> Crear red
```ini
vbonet0	192.168.56.1
```

### Configuracion en la maquina virtual
- Virtual machines
	- Network
		- **Adapter 1**
			- NAT
		- **Adapter 2**
			- Host-only adapter

## Configuracion de IP estatica en Ubuntu Server

### Editar archivo netplan
```bash
sudo vim /etc/netplan/00-installer-config.yaml
```

```yaml
network:
  version: 2
  ethernets:
    enp0s3:
      dhcp4: true
    enp0s8:
      dhcp4: false
      addresses:
        - 192.168.56.13/24
```

### Aplicar cambios

```bash
sudo netplan apply
```

### Acceso por ssh 
```bash
ssh si@192.168.56.13
```