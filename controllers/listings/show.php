<?php

$config = require basePath(path: 'config/db.php');
$db = new Database(config: $config);

$id = $_GET['id'] ?? '';

$params = [
    'id' => $id
];

$listing = $db->query(query: 'SELECT * FROM listings WHERE id = :id', params: $params)->fetch();

loadView(name: 'listings/show', data: [
    'listing' => $listing
]);