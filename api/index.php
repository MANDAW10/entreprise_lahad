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
    require __DIR__ . '/../public/index.php';
} catch (\Exception $e) {
    echo "L'application a rencontré une erreur fatale lors du démarrage : <br>";
    echo "Message : " . $e->getMessage() . "<br>";
    echo "Fichier : " . $e->getFile() . ":" . $e->getLine() . "<br>";
    die();
}
