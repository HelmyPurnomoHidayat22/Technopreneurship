# GitHub Repository Setup Script - DigitalCreativeHub
# Run this script in a NEW PowerShell window after Git/GH CLI installation

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "  GitHub Repository Setup Script" -ForegroundColor Cyan
Write-Host "  DigitalCreativeHub" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# 1. Verify Git and GH CLI installed
Write-Host "[1/8] Checking Git installation..." -ForegroundColor Yellow
try {
    $gitVersion = git --version
    Write-Host "✓ Git installed: $gitVersion" -ForegroundColor Green
}
catch {
    Write-Host "✗ Git not found! Please restart terminal." -ForegroundColor Red
    exit 1
}

Write-Host "[2/8] Checking GitHub CLI installation..." -ForegroundColor Yellow
try {
    $ghVersion = gh --version | Select-Object -First 1
    Write-Host "✓ GitHub CLI installed: $ghVersion" -ForegroundColor Green
}
catch {
    Write-Host "✗ GitHub CLI not found! Please restart terminal." -ForegroundColor Red
    exit 1
}

# 2. Initialize Git Repository
Write-Host "[3/8] Initializing Git repository..." -ForegroundColor Yellow
if (Test-Path ".git") {
    Write-Host "✓ Git already initialized" -ForegroundColor Green
}
else {
    git init
    Write-Host "✓ Git repository initialized" -ForegroundColor Green
}

# 3. Configure Git User
Write-Host "[4/8] Configuring Git user..." -ForegroundColor Yellow
git config user.name "Helmy Purnomo"
git config user.email "helmypurnomo234@gmail.com"
Write-Host "✓ Git user configured" -ForegroundColor Green

# 4. GitHub Authentication
Write-Host "[5/8] GitHub Authentication..." -ForegroundColor Yellow
Write-Host "Opening browser for GitHub login..." -ForegroundColor Cyan
Write-Host "Please authenticate in your browser" -ForegroundColor Cyan
gh auth login

# Check if authenticated
$authStatus = gh auth status 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ GitHub authentication successful!" -ForegroundColor Green
}
else {
    Write-Host "✗ Authentication failed. Please try again." -ForegroundColor Red
    exit 1
}

# 5. Create GitHub Repository
Write-Host "[6/8] Creating GitHub repository 'digitalcreativehub'..." -ForegroundColor Yellow
try {
    gh repo create digitalcreativehub --public --description "Digital Product Marketplace - Platform jual beli produk digital dengan fitur custom design" --source=. --remote=origin
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Repository created successfully!" -ForegroundColor Green
    }
    else {
        Write-Host "Repository might already exist or creation failed" -ForegroundColor Yellow
    }
}
catch {
    Write-Host "Error creating repository: $_" -ForegroundColor Yellow
}

# 6. Add all files
Write-Host "[7/8] Adding files to Git..." -ForegroundColor Yellow
git add .
Write-Host "✓ Files staged for commit" -ForegroundColor Green

# 7. Initial Commit
Write-Host "[8/8] Creating initial commit..." -ForegroundColor Yellow
git commit -m "Initial commit - DigitalCreativeHub

- Laravel 11.x marketplace for digital products
- Admin panel with dashboard, orders, products management
- User panel with cart, checkout, order tracking
- Custom design workflow with file upload & chat
- Payment verification system
- Real-time chat between admin & users
- Complete authentication & authorization"

Write-Host "✓ Initial commit created" -ForegroundColor Green

# 8. Push to GitHub
Write-Host "Pushing to GitHub..." -ForegroundColor Yellow
git branch -M main
git push -u origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "=====================================" -ForegroundColor Green
    Write-Host "  ✓ SUCCESS!" -ForegroundColor Green
    Write-Host "=====================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Repository URL:" -ForegroundColor Cyan
    $repoUrl = gh repo view --json url -q .url
    Write-Host $repoUrl -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Cyan
    Write-Host "1. Visit your repository on GitHub" -ForegroundColor White
    Write-Host "2. Update repository settings if needed" -ForegroundColor White
    Write-Host "3. Invite collaborators" -ForegroundColor White
    Write-Host "4. Set up GitHub Actions (optional)" -ForegroundColor White
    Write-Host ""
}
else {
    Write-Host "✗ Push failed. Please check errors above." -ForegroundColor Red
}
