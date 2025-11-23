<?php

namespace App\Controllers;

use Framework\Database;

class HomeController
{
    protected $db;
    public function __construct()
    {
        $config = require basePath(path: 'config/db.php');
        $this->db = new Database(config: $config);
    }
    /**
     * Show the latest listings
     * 
     * @return void
     */
    public function index(): void
    {
        $listings = $this->db->query(query: 'SELECT * FROM listings LIMIT 6')->fetchAll();
        loadView(name: 'home', data: [
            'listings' => $listings
        ]);
    }
}