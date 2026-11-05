param([int]$Port = 8088)
$ErrorActionPreference = 'Stop'
$projectRoot = $PSScriptRoot
$phpPath = 'C:\xampp\php\php.exe'
if (!(Test-Path -LiteralPath $phpPath)) { throw 'Không tìm thấy PHP tại C:\xampp\php\php.exe. Hãy sửa phpPath trong start-local.ps1.' }
$runtimeRoot = Join-Path $projectRoot '.runtime'
$sessionsPath = Join-Path $runtimeRoot 'sessions'
$uploadsPath = Join-Path $runtimeRoot 'uploads'
New-Item -ItemType Directory -Force -Path $sessionsPath,$uploadsPath | Out-Null
Write-Host "Thinh Tech: http://127.0.0.1:$Port/ - MySQL port 3307"
& $phpPath -d "session.save_path=$sessionsPath" -d "upload_tmp_dir=$uploadsPath" -S "127.0.0.1:$Port" -t $projectRoot (Join-Path $projectRoot 'router.php')
