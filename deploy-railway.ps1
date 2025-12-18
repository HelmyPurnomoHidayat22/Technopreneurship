# ========================================
# Railway Deployment Helper Script
# ========================================
# Script ini membantu push kode ke GitHub untuk auto-deploy ke Railway

Write-Host "🚀 Railway Deployment Helper" -ForegroundColor Cyan
Write-Host "================================`n" -ForegroundColor Cyan

# Check if git is initialized
if (-not (Test-Path ".git")) {
    Write-Host "❌ Git belum diinisialisasi!" -ForegroundColor Red
    Write-Host "Jalankan: git init" -ForegroundColor Yellow
    exit 1
}

# Check git status
Write-Host "📊 Checking git status..." -ForegroundColor Yellow
git status --short

Write-Host "`n"

# Ask for commit message
$commitMessage = Read-Host "💬 Masukkan commit message (atau Enter untuk 'Update application')"
if ([string]::IsNullOrWhiteSpace($commitMessage)) {
    $commitMessage = "Update application"
}

# Add all files
Write-Host "`n📦 Adding files..." -ForegroundColor Yellow
git add .

# Commit
Write-Host "💾 Committing changes..." -ForegroundColor Yellow
git commit -m $commitMessage

# Check if remote exists
$remotes = git remote
if ($remotes -notcontains "origin") {
    Write-Host "`n⚠️  Remote 'origin' belum di-set!" -ForegroundColor Yellow
    Write-Host "Contoh: git remote add origin https://github.com/USERNAME/REPO.git" -ForegroundColor Cyan
    
    $addRemote = Read-Host "`nApakah ingin menambahkan remote sekarang? (y/n)"
    if ($addRemote -eq "y") {
        $remoteUrl = Read-Host "Masukkan URL repository GitHub"
        git remote add origin $remoteUrl
        Write-Host "✅ Remote berhasil ditambahkan!" -ForegroundColor Green
    } else {
        Write-Host "❌ Deployment dibatalkan. Tambahkan remote terlebih dahulu." -ForegroundColor Red
        exit 1
    }
}

# Push to GitHub
Write-Host "`n🚀 Pushing to GitHub..." -ForegroundColor Yellow
$branch = git branch --show-current
if ([string]::IsNullOrWhiteSpace($branch)) {
    $branch = "main"
    git branch -M main
}

git push -u origin $branch

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n✅ Successfully pushed to GitHub!" -ForegroundColor Green
    Write-Host "🎉 Railway akan otomatis deploy aplikasi Anda dalam beberapa menit." -ForegroundColor Cyan
    Write-Host "`nCek progress di: https://railway.app" -ForegroundColor Yellow
} else {
    Write-Host "`n❌ Push gagal! Cek error di atas." -ForegroundColor Red
    Write-Host "Mungkin perlu login GitHub atau resolve conflicts." -ForegroundColor Yellow
}

Write-Host "`n================================" -ForegroundColor Cyan
Write-Host "Tekan Enter untuk keluar..."
Read-Host
