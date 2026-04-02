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
