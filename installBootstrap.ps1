# bootstrap-setup.ps1

$zipUrl = "https://github.com/twbs/bootstrap/releases/download/v5.3.6/bootstrap-5.3.6-dist.zip"
$zipFile = "bootstrap-5.3.6-dist.zip"
$unpackedDir = "bootstrap-5.3.6-dist"
$targetDir = "wwwroot\lib\bootstrap"

# Download the ZIP file
Invoke-WebRequest -Uri $zipUrl -OutFile $zipFile

# Extract ZIP using built-in Expand-Archive
Expand-Archive -Path $zipFile -DestinationPath $unpackedDir -Force

# Create target directory if it doesn't exist
if (-not (Test-Path $targetDir)) {
    New-Item -ItemType Directory -Path $targetDir | Out-Null
}

# Copy js and css folders
Copy-Item "$unpackedDir\js" -Destination "$targetDir\js" -Recurse -Force
Copy-Item "$unpackedDir\css" -Destination "$targetDir\css" -Recurse -Force

# Clean up
Remove-Item -Recurse -Force $unpackedDir
Remove-Item -Force $zipFile

Write-Host "Bootstrap setup completed."