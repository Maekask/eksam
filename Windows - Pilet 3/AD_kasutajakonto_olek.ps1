
# Hankige kõik kasutajakontod
$allUsers = Get-ADUser -Filter * -Properties LastLogonDate, Enabled, LockedOut

# Kontod, mis pole kunagi loginud (LastLogonDate on tühi)
$neverLoggedIn = $allUsers | Where-Object { -not $_.LastLogonDate }

# Keelatud kontod
$disabledAccounts = $allUsers | Where-Object { $_.Enabled -eq $false }

# Lukustatud kontod
$lockedAccounts = $allUsers | Where-Object { $_.LockedOut -eq $true }

# Väljasta raport
Write-Host "-----------------------------"
Write-Host "Kontod, mis pole kunagi loginud:" -ForegroundColor Cyan
$neverLoggedIn | Select-Object Name, SamAccountName | Format-Table -AutoSize

Write-Host "-----------------------------"
Write-Host "Keelatud kontod:" -ForegroundColor Red
$disabledAccounts | Select-Object Name, SamAccountName | Format-Table -AutoSize

Write-Host "-----------------------------"
Write-Host "Lukustatud kontod:" -ForegroundColor Yellow
$lockedAccounts | Select-Object Name, SamAccountName | Format-Table -AutoSize
Write-Host "-----------------------------"
