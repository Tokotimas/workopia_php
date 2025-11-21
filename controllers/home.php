<?php

$config = require basePath(path: 'config/db.php');
$db = new Database(config: $config);

$listings = $db->query(query: 'SELECT * FROM listings LIMIT 6')->fetchAll();

loadView(name: 'home', data: [
    'listings' => $listings
]);