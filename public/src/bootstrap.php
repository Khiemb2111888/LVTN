<?php
require_once 'functions.php';
require_once __DIR__ . '/../libraries/Psr4AutoloaderClass.php';

$loader = new Psr4AutoloaderClass;
$loader->register();

// Các lớp có không gian tên bắt đầu với CT275\Labs nằm ở src/classes
$loader->addNamespace('CT275\Labs', __DIR__ . '/classes');

try {
    $PDO = (new CT275\Labs\PDOFactory())->create([
        'dbhost' => 'localhost',
        'dbname' => 'computer_store',
        'dbuser' => 'root',
        'dbpass' => ''
    ]);
} catch (Exception $ex) {
    echo 'Không thể kết nối đến MySQL, vui lòng kiểm tra lại username/password.<br>';
    exit("<pre>Error: {$ex->getMessage()}</pre>");
}
