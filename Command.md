# Documentación de Comandos — RegistroPQRS v1

---

## 1. Instalación de Composer

### Windows

1. Descargar el instalador desde [getcomposer.org](https://getcomposer.org/download/)
2. Ejecutar `Composer-Setup.exe` y seguir el asistente
3. Verificar la instalación:

```bash
composer --version
```

### Linux / macOS

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### Instalar dependencias del proyecto

```bash
cd include
composer install
```

Esto descarga **PHPMailer ^6.8** en `include/vendor/`.
composer require phpmailer/phpmailer

---

## 2. Inicialización del Proyecto con Docker

### Estructura esperada

```
RegistroPQRS_v1/
├── docker-compose.yml      ← orquestación de servicios
├── Dockerfile              ← (opcional) imagen PHP personalizada
├── config/
│   └── conexion.php        ← apunta a MySQL por Docker (host: mysql, no localhost)
├── docs/
│   └── Backup v1.sql       ← dump a importar
└── ...resto del proyecto
```

### Crear `docker-compose.yml` (raíz del proyecto)

```yaml
version: "3.8"

services:
  app:
    image: php:8.1-apache
    container_name: registro_pqrs_app
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - mysql

  mysql:
    image: mysql:8.0
    container_name: registro_pqrs_mysql
    ports:
      - "3307:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: registro_pqrs
      MYSQL_USER: user_mesa
      MYSQL_PASSWORD: pass_mesa
    volumes:
      - mysql_data:/var/lib/mysql
      - ./docs/Backup v1.sql:/docker-entrypoint-initdb.d/init.sql

volumes:
  mysql_data:
```

> **Nota:** El puerto 3307 evita conflictos con MySQL local. Ajusta `conexion.php` para usar `mysql:host=mysql;dbname=registro_pqrs` (corrigiendo el typo `local` → `host`).

### Iniciar todos los servicios

```bash
docker-compose up -d
```

### Ver estado de los contenedores

```bash
docker-compose ps
```

### Detener y eliminar contenedores

```bash
docker-compose down
```

Para eliminar también el volumen de datos:

```bash
docker-compose down -v
```

---

## 3. Despliegue de MySQL por Docker

### Comando único (sin docker-compose)

```bash
docker run -d \
  --name registro_pqrs_mysql \
  -p 3307:3306 \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=registro_pqrs \
  -e MYSQL_USER=user_mesa \
  -e MYSQL_PASSWORD=pass_mesa \
  -v mysql_data:/var/lib/mysql \
  mysql:8.0
```

### Variables de entorno

| Variable              | Valor         | Descripción                     |
|-----------------------|---------------|----------------------------------|
| `MYSQL_ROOT_PASSWORD` | `root`        | Contraseña del usuario root      |
| `MYSQL_DATABASE`      | `registro_pqrs`| Base de datos a crear            |
| `MYSQL_USER`          | `user_mesa`   | Usuario adicional                |
| `MYSQL_PASSWORD`      | `pass_mesa`   | Contraseña del usuario adicional |

### Importar el dump manualmente

```bash
docker exec -i registro_pqrs_mysql mysql -uroot -proot registro_pqrs < "docs/Backup v1.sql"
```

---

## 4. Ejecución y conexión a MySQL

### Iniciar contenedor

```bash
docker start registro_pqrs_mysql
```

### Detener contenedor

```bash
docker stop registro_pqrs_mysql
```

### Conectarse desde el host

```bash
mysql -h 127.0.0.1 -P 3307 -u root -p
```

Contraseña: `root`

### Conectarse desde dentro del contenedor

```bash
docker exec -it registro_pqrs_mysql mysql -uroot -p
```

### Verificar funcionamiento

```bash
docker exec registro_pqrs_mysql mysql -uroot -proot -e "SHOW DATABASES;"
```

Salida esperada:

```
+--------------------+
| Database           |
+--------------------+
| information_schema |
| registro_pqrs       |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
```

### Verificar la tabla de usuarios

```bash
docker exec registro_pqrs_mysql mysql -uroot -proot registro_pqrs -e "DESCRIBE tm_usuario;"
```

---

## Referencia rápida

```bash
# Composer
composer --version
cd include && composer install

# Docker Compose
docker-compose up -d
docker-compose down -v

# MySQL Docker standalone
docker run -d --name registro_pqrs_mysql -p 3307:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=registro_pqrs mysql:8.0

# MySQL shell
docker exec -it registro_pqrs_mysql mysql -uroot -p

# Importar dump
docker exec -i registro_pqrs_mysql mysql -uroot -proot registro_pqrs < "docs/Backup v1.sql"
```
