@echo off
:: ============================================================
::  Registro de PQRS v1 — Script de Permisos (Windows)
::  Ejecutar como Administrador desde la raíz del proyecto
:: ============================================================

echo [Registro de PQRS] Configurando permisos de archivos sensibles...

:: Restringir .env: solo el usuario actual puede leerlo
if exist ".env" (
    icacls ".env" /inheritance:r /grant:r "%USERNAME%:(R)" >nul 2>&1
    echo  [OK] .env — acceso restringido al usuario actual
) else (
    echo  [!!] .env no encontrado. Copie .env.example a .env primero.
)

:: Directorio logs — el proceso de PHP/Apache necesita escribir
if exist "logs" (
    icacls "logs" /grant "%USERNAME%:(OI)(CI)(M)" >nul 2>&1
    echo  [OK] logs/ — permisos de escritura configurados
) else (
    mkdir logs
    echo  [OK] logs/ — directorio creado
)

:: Asegurar que include/vendor NO sea accesible desde el web
if exist "include\vendor" (
    echo  [OK] include/vendor/ existe — verificar bloqueo en .htaccess
)

echo.
echo [Registro de PQRS] Listo. Revise el .htaccess para bloqueo web de /config y /logs.
pause
