# Lae CSV fail
$kasutajad = Import-Csv -Path "C:\kasutajad.csv" -Delimiter ','

foreach ($kasutaja in $kasutajad) {
    $fullname = $kasutaja.Nimi
    $ouPath = $kasutaja.OU
    $password = $kasutaja.Password
    $username = $kasutaja.Username

    # Eesnimi ja perenimi eraldamine
    $nameParts = $fullname -split ' ', 2
    $eesnimi = $nameParts[0]
    $perenimi = if ($nameParts.Length -gt 1) { $nameParts[1] } else { "" }

    # AD OU DN vorming
    $ouComponents = $ouPath -split '/'
    $fullOU = ""
    foreach ($component in [array]::Reverse($ouComponents)) {
        if ($fullOU -eq "") {
            $fullOU = "OU=$component"
        } else {
            $fullOU = "OU=$component,$fullOU"
        }
    }
    $fullOU = "$fullOU,DC=oige,DC=local"

    # Kontrolli, kas OU eksisteerib; kui ei, loo see
    if (-not (Get-ADOrganizationalUnit -Filter "DistinguishedName -eq '$fullOU'" -ErrorAction SilentlyContinue)) {
        $parentOU = ($fullOU -split ',', 2)[1]
        New-ADOrganizationalUnit -Name $ouComponents[-1] -Path $parentOU -ProtectedFromAccidentalDeletion $false
        Write-Host "Loodud OU: $fullOU"
    }

    # Kontrolli, kas kasutaja juba eksisteerib
    if (-not (Get-ADUser -Filter "SamAccountName -eq '$username'" -ErrorAction SilentlyContinue)) {
        # Loo kasutaja
        New-ADUser `
            -Name $fullname `
            -GivenName $eesnimi `
            -Surname $perenimi `
            -SamAccountName $username `
            -UserPrincipalName "$username@oige.local" `
            -Path $fullOU `
            -AccountPassword (ConvertTo-SecureString $password -AsPlainText -Force) `
            -Enabled $true `
            -ChangePasswordAtLogon $true

        Write-Host "Loodud kasutaja: $username"
    } else {
        Write-Host "Kasutaja $username on juba olemas."
    }
}
