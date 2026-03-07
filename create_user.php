<?php
require './vendor/autoload.php';
$app = require_once './bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = new User;
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('password123');
$user->user_type = 1;
$user->is_delete = 0;
$user->save();

echo "✓ User created successfully!\n";
echo "Email: admin@example.com\n";
echo "Password: password123\n";
