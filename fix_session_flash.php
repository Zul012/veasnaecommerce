<?php

/**
 * This script will update all controllers to use the Session facade
 * instead of request()->session()->flash()
 * 
 * To use:
 * 1. Place this file in the root of your Laravel project
 * 2. Run: php fix_session_flash.php
 */

// Configuration
$controllersPath = __DIR__ . '/app/Http/Controllers/';
$backupFolder = __DIR__ . '/controller_backups_' . date('Ymd_His') . '/';

// Create backup folder
if (!is_dir($backupFolder)) {
    mkdir($backupFolder, 0755, true);
}

echo "Starting session flash fix process...\n";
echo "Backup folder: {$backupFolder}\n\n";

// Find all controller files
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($controllersPath)
);

$controllerFiles = [];
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $controllerFiles[] = $file->getPathname();
    }
}

echo "Found " . count($controllerFiles) . " controller files.\n\n";

$fixedCount = 0;
$skippedCount = 0;

foreach ($controllerFiles as $file) {
    $filename = basename($file);
    $relativePath = str_replace($controllersPath, '', $file);
    
    echo "Processing: {$relativePath}\n";
    
    $content = file_get_contents($file);
    $originalContent = $content;

    // Check if the file needs fixing
    if (strpos($content, 'request()->session()->flash') === false) {
        echo "  - No session flash calls found, skipping.\n";
        $skippedCount++;
        continue;
    }
    
    // Backup the file
    $backupPath = $backupFolder . $relativePath;
    $backupDir = dirname($backupPath);
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    file_put_contents($backupPath, $content);
    
    // Add Session facade import if needed
    if (strpos($content, 'use Illuminate\Support\Facades\Session;') === false) {
        // Find the last use statement
        $pattern = '/^use\s+[^;]+;/m';
        if (preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
            $lastUse = end($matches[0]);
            $insertPos = $lastUse[1] + strlen($lastUse[0]) + 1; // +1 for newline
            $before = substr($content, 0, $insertPos);
            $after = substr($content, $insertPos);
            $content = $before . "use Illuminate\Support\Facades\Session;\n" . $after;
        }
    }
    
    // Replace flash calls
    $content = preg_replace(
        '/request\(\)->session\(\)->flash\(([^)]+)\)/', 
        'Session::flash($1)', 
        $content
    );
    
    // Only update if changes were made
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "  - Fixed session flash calls and added Session facade import if needed.\n";
        $fixedCount++;
    } else {
        echo "  - Error: Failed to apply fixes.\n";
    }
}

echo "\nSummary:\n";
echo "- Controllers fixed: {$fixedCount}\n";
echo "- Controllers skipped: {$skippedCount}\n";
echo "- Backups stored in: {$backupFolder}\n";
echo "\nDone!\n";
