#!/bin/bash
# ============================================================
#  Registro de PQRS v1 — Script de Permisos (Linux / macOS)
#  Ejecutar desde la raíz del proyecto:  bash setup-permisos.sh
# ============================================================

set -e

echo "[Registro de PQRS] Configurando permisos de archivos sensibles..."

# .env — solo el propietario puede leer/escribir (sin acceso a grupo/otros)
if [ -f ".env" ]; then
    chmod 600 .env
    echo " [OK] .env — chmod 600 (solo propietario)"
else
    echo " [!!] .env no encontrado. Copie .env.example a .env primero:"
    echo "       cp .env.example .env && chmod 600 .env"
fi

# .env.example — lectura pública (no contiene credenciales reales)
if [ -f ".env.example" ]; then
    chmod 644 .env.example
    echo " [OK] .env.example — chmod 644"
fi

# logs/ — el proceso web (www-data / apache) necesita escribir
if [ ! -d "logs" ]; then
    mkdir -p logs
fi
chmod 755 logs
echo " [OK] logs/ — chmod 755"

# config/ — solo lectura para el propietario, sin ejecución para otros
chmod 750 config/
echo " [OK] config/ — chmod 750"

# Archivos PHP de configuración
find config/ -name "*.php" -exec chmod 640 {} \;
echo " [OK] config/*.php — chmod 640"

echo ""
echo "[Registro de PQRS] Listo. Verifique que el usuario web (www-data/apache)"
echo "tenga acceso de lectura a config/ y escritura a logs/."
