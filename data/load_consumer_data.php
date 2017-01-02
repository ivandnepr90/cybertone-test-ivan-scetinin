<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/application.run.config.php';

$db = new PDO(sprintf('mysql:dbname=%s;host=%s;charset=utf8;', DB_NAME, DB_HOST) . realpath(__DIR__) . '/consumers.db');
$fh = fopen(__DIR__ . '/album-fixtures.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);