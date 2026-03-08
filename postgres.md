# Instalacion y configuracion de postgres

## Agregar repositorio de postgres
```bash
sudo apt install -y postgresql-common
```

```bash
sudo /usr/share/postgresql-common/pgdg/apt.postgresql.org.sh
```

### Instalar postgres
```bash
sudo apt install postgresql-18
```

## Configurar usuario administrador de postgres
### Ingresar a postgres
```bash
sudo -u postgres psql
```

### Actualizar password del usuario postgres
```sql
ALTER USER postgres WITH PASSWORD 'juanvladimir13';
```

### Crear usuarios
```sql
CREATE USER juanvladimir13 WITH PASSWORD 'juanvladimir13';
```

## Configurar idioma y timezone de postgres
### Verificar el idioma de la base de datos
```sql
SELECT datname, datcollate, datctype
FROM pg_database;
```

### Verificar zona horaria
```sql
SHOW timezone;
```

### Modificar timezone si es necesario
```bash
sudo vim /etc/postgresql/18/main/postgresql.conf
```

```ini
timezone = 'America/La_Paz'
```

```bash
sudo systemctl restart postgresql
```

## Cambiar owner de base de datos	

### Cambiar owner de base de datos
```bash
sudo -u postgres psql -d nextcloud
```

```sql
ALTER DATABASE bth_inscripcion OWNER TO sysadmin;
```

### Cambiar owner de tablas
```sql
DO $$
DECLARE r RECORD;
BEGIN
  FOR r IN SELECT tablename FROM pg_tables WHERE schemaname = 'public'
  LOOP
    EXECUTE 'ALTER TABLE public.' || quote_ident(r.tablename) || ' OWNER TO sysadmin';
  END LOOP;
END $$;
```

### Verificar los cambios
```sql
\dt
```