<?php

/**
 * Vercel PHP Serverless Function entrypoint.
 */

// Create the SQLite database if it doesn't exist
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
}

// Ensure the storage directories exist in /tmp for Laravel
$storageFolders = [
    '/tmp/app',
    '/tmp/framework/cache',
    '/tmp/framework/sessions',
    '/tmp/framework/views',
];
foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

// Automatically migrate the database if it doesn't have tables
if (!file_exists($dbPath) || filesize($dbPath) == 0) {
    touch($dbPath);
    // Use the artisan command to migrate and seed
    shell_exec('php ' . __DIR__ . '/../artisan migrate --seed --force');
}

// Fail-safe: Ensure admin user exists (one-time fix for login issues)
try {
    // This is a quick injection to make sure the user is there
    shell_exec('php ' . __DIR__ . '/../artisan tinker --execute="if(!\App\Models\User::where(\'email\', \'admin@lahad.com\')->exists()) { \App\Models\User::create([\'name\' => \'Admin Lahad\', \'email\' => \'admin@lahad.com\', \'password\' => \Illuminate\Support\Facades\Hash::make(\'password\'), \'is_admin\' => true]); }"');
} catch (\Throwable $e) {}

try {
    // Check if the mandatory SQLite extension is available
    if (!extension_loaded('pdo_sqlite')) {
        throw new \Error("L'extension PHP 'pdo_sqlite' n'est pas activée sur ce serveur Vercel. Veuillez vérifier votre version de vercel-php.");
    }
    
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>L'application a rencontré une erreur fatale</h1>";
    echo "<strong>Message :</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Fichier :</strong> " . $e->getFile() . " à la ligne " . $e->getLine() . "<br>";
    echo "<strong>Trace :</strong> <pre>" . $e->getTraceAsString() . "</pre>";
    die();
}
