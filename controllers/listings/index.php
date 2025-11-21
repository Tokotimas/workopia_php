<?php
$config = require basePath(path: 'config/db.php');
$db = new Database(config: $config);

$listings = $db->query(query: 'SELECT * FROM listings')->fetchAll();

loadView(name: 'listings/index', data: [
    'listings' => $listings
]);