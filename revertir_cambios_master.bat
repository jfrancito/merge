@echo off
echo =======================================================================
echo          SCRIPT DE REVERSION DE EMERGENCIA PARA MASTER
echo =======================================================================
echo.
echo Este script revertira los cambios de optimizaciones contables en la rama
echo master volviendo exactamente al estado previo (tag: backup_master_antes_contabilidad_041126).
echo.
set /p CONFIRM="Desea proceder con la reversion en master? (S/N): "
if /i "%CONFIRM%" neq "S" (
    echo Operacion cancelada.
    pause
    exit /b
)

echo.
echo 1. Asegurando rama master...
git checkout master
if %errorlevel% neq 0 (
    echo Error al cambiar a master.
    pause
    exit /b %errorlevel%
)

echo.
echo 2. Aplicando rollback al tag de respaldo seguro...
git reset --hard backup_master_antes_contabilidad_041126
if %errorlevel% neq 0 (
    echo Fallo el reset local.
    pause
    exit /b %errorlevel%
)

echo.
echo 3. Actualizando origin/master forzado al estado original...
git push origin master --force
if %errorlevel% neq 0 (
    echo Fallo el push a origin/master.
    pause
    exit /b %errorlevel%
)

echo.
echo =======================================================================
echo Reversion completada con exito. La rama master esta en su estado previo.
echo =======================================================================
pause
