<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\User;

$users = User::with('roles')->get();
foreach ($users as $user) {
    echo "User: " . $user->name . " (ID: " . $user->id . ") - Roles: " . $user->getRoleNames() . "\n";
    echo "Can Impersonate: " . ($user->canImpersonate() ? 'Yes' : 'No') . "\n";
}
