# Määra serveri nimi (vajadusel asenda)
$dhcpServer = "localhost"

# Loo sihtkaust
$folderPath = "C:\DHCP_Raport"
if (!(Test-Path -Path $folderPath)) {
    New-Item -ItemType Directory -Path $folderPath | Out-Null
}

# Kontrolli, kas DHCP teenus töötab
$serviceStatus = Get-Service -Name DHCPServer | Select-Object Status, Name
$serviceStatus | Export-Csv -Path "$folderPath\DHCP_ServiceStatus.csv" -NoTypeInformation -Encoding UTF8

# Hankige DHCP skoopide info
$scopes = Get-DhcpServerv4Scope -ComputerName $dhcpServer
$scopes | Select-Object ScopeId, Name, State, StartRange, EndRange, SubnetMask |
    Export-Csv -Path "$folderPath\DHCP_Scopes.csv" -NoTypeInformation -Encoding UTF8

# Iteratsiooni kõigi skoopide kohta
$allLeases = @()
$freeIPs = @()

foreach ($scope in $scopes) {
    # Hankige kasutusel IP-d ja MACid
    $leases = Get-DhcpServerv4Lease -ScopeId $scope.ScopeId -ComputerName $dhcpServer
    $leases | Select-Object IPAddress, ClientId, HostName, AddressState |
        Export-Csv -Path "$folderPath\Leases_$($scope.ScopeId).csv" -NoTypeInformation -Encoding UTF8
    $allLeases += $leases

    # Arvuta vabad IP-d
    $usedIPs = $leases.IPAddress
    $ipRange = [IPAddress]::Parse($scope.StartRange)..[IPAddress]::Parse($scope.EndRange)
    foreach ($ip in $ipRange) {
        if ($usedIPs -notcontains $ip.ToString()) {
            $freeIPs += [PSCustomObject]@{
                ScopeId = $scope.ScopeId
                FreeIPAddress = $ip.ToString()
            }
        }
    }
}

# Salvesta vabad IP-aadressid
$freeIPs | Export-Csv -Path "$folderPath\FreeIPAddresses.csv" -NoTypeInformation -Encoding UTF8

# Kinnita
Write-Host "`nRaport salvestati kausta: $folderPath" -ForegroundColor Green
