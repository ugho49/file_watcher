<?php
include 'vendor/autoload.php';

$folder_files = __DIR__ . DIRECTORY_SEPARATOR . 'files';
$folder_logs = __DIR__. DIRECTORY_SEPARATOR . 'logs';

$pdo = new App\MyPDO();
$logger = new Katzgrau\KLogger\Logger($folder_logs);

$files = new Illuminate\Filesystem\Filesystem;
$tracker = new JasonLewis\ResourceWatcher\Tracker;
$watcher = new JasonLewis\ResourceWatcher\Watcher($tracker, $files);

$listener = $watcher->watch($folder_files);

$listener->create(function(\JasonLewis\ResourceWatcher\Resource\FileResource $resource, $path) use ($logger, $pdo) {
    $filename = $resource->getSplFileInfo()->getFilename();
    $logger->info($filename . " has been created into " . dirname($path));

    $pdo->execute('INSERT INTO files (name) VALUES (?)', $filename);
});

$watcher->start();