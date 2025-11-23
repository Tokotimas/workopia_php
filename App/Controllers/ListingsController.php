<?php

namespace App\Controllers;

use Framework\Database;

class ListingsController
{
    protected $db;
    public function __construct()
    {
        $config = require basePath(path: 'config/db.php');
        $this->db = new Database(config: $config);
    }

    /**
     * Show all listings
     * 
     * @return void
     */
    public function index(): void
    {
        $listings = $this->db->query(query: 'SELECT * FROM listings')->fetchAll();
        loadView(name: 'listings/index', data: [
            'listings' => $listings
        ]);
    }
    /**
     * Show the create listing form
     * 
     * @return void
     */
    public function create(): void
    {
        loadView(name: 'listings/create');
    }
    /**
     * Show a single listing
     * 
     * @return void
     */
    public function show($params): void
    {
        $id = $params['id'] ?? '';

        if (!is_numeric(value: $id)) {
            ErrorController::notFound(message: 'Listing not found');
            return;
        }

        $id = (int) $id;

        $listing = $this->db->query(query: 'SELECT * FROM listings WHERE id = :id', params: ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound(message: 'Listing not found');
            return;
        }

        loadView(name: 'listings/show', data: [
            'listing' => $listing
        ]);
    }
}