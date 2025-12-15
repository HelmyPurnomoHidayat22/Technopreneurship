<?php

// Reset Admin Password Script
// Run: php reset_admin_password.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('role', 'admin')->first();

if ($admin) {
    $admin->password = Hash::make('admin123');
    $admin->save();
    
    echo "✅ Admin password reset successfully!\n";
    echo "Email: {$admin->email}\n";
    echo "Password: admin123\n";
} else {
    echo "❌ No admin user found!\n";
}
