<?php
require_once(realpath(__DIR__) . '/../src/File/Model.php');
require_once(realpath(__DIR__) . '/../src/File/Entity.php');
require_once(realpath(__DIR__) . '/../src/File/Mapper.php');
require_once(realpath(__DIR__) . '/../src/File/Query.php');
require_once(realpath(__DIR__) . '/../src/File/Named.php');
require_once(realpath(__DIR__) . '/../src/File/Collection.php');
require_once(realpath(__DIR__) . '/../src/File/Relation.php');
require_once(realpath(__DIR__) . '/../src/Writer.php');

if (count($argv) < 3) {
    echo "Usage: {$argv[0]} <model> <table> [columns] [config]\n";
    exit;
}

if (file_exists('.atlas/canvas.php')) {
    /* Guess a config path */
    $config = include('.atlas/canvas.php'); 
}

if (isset($argv[2])) {
    /* A config path was provided */
    $table = $argv[2];
}

if (isset($argv[3])) {
    /* A config path was provided */
    $columns = explode(',', $argv[3]); 
}

if (isset($argv[4])) {
    /* A config path was provided */
    $config = include($argv[4]); 
}

if (!isset($config)) {
    echo "Could not find config file, please specify path\n";
    exit;
}

$model = ucfirst($argv[1]);

if (!is_dir($config['canvas']['path'])) {
    echo "Path specified in config does not exist: {$config['canvas']['path']}\n";
    exit;
}

if (!is_dir("{$config['canvas']['path']}/{$model}")) {
    echo "Creating {$model} model in directory: {$config['canvas']['path']}\n";
    mkdir("{$config['canvas']['path']}/{$model}");
}

$files = array(
    new Canvas\File\Model($config['canvas']['namespace'], $model),
    new Canvas\File\Entity($config['canvas']['namespace'], $model, $columns),
    new Canvas\File\Mapper($config['canvas']['namespace'], $model, $table, $columns),
    new Canvas\File\Collection($config['canvas']['namespace'], $model),
    new Canvas\File\Query($config['canvas']['namespace'], $model),
    new Canvas\File\Named($config['canvas']['namespace'], $model),
    new Canvas\File\Relation($config['canvas']['namespace'], $model),
);

$writer = new Canvas\Writer($config['canvas']['path']);

foreach ($files as $file) {
    try {
        $writer->create($file);
        echo "- Created {$file->getRelativePath()}\n";
    } catch (Exception $e) {
        echo "- {$e->getMessage()}\n";
    }
}

