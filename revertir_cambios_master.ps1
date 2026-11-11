# Script de reversion de emergencia para la rama master
Write-Host "=======================================================================" -ForegroundColor Yellow
Write-Host "         SCRIPT DE REVERSION DE EMERGENCIA PARA MASTER" -ForegroundColor Yellow
Write-Host "=======================================================================" -ForegroundColor Yellow
Write-Host ""
Write-Host "Este script revertira los cambios de optimizaciones contables en master"
Write-Host "volviendo exactamente al estado previo (tag: backup_master_antes_contabilidad_041126)."
Write-Host ""

$confirm = Read-Host "Desea proceder con la reversion en master? (S/N)"
if ($confirm -ne 'S' -and $confirm -ne 's') {
    Write-Host "Operacion cancelada por el usuario." -ForegroundColor Cyan
    exit
}

Write-Host "1. Cambiando a master..." -ForegroundColor Green
git checkout master

Write-Host "2. Aplicando rollback directo con git reset --hard al tag de respaldo..." -ForegroundColor Green
git reset --hard backup_master_antes_contabilidad_041126

Write-Host "3. Actualizando origin/master..." -ForegroundColor Green
git push origin master --force

Write-Host "=======================================================================" -ForegroundColor Green
Write-Host "Reversion completada. Master esta nuevamente en el estado previo." -ForegroundColor Green
Write-Host "=======================================================================" -ForegroundColor Green
