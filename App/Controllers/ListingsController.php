<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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
     * @param array listing
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
    /**
     * Store data in database
     * 
     * @return void
     */
    public function store(): void
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $newListingData = array_intersect_key($_POST, array_flip(array: $allowedFields));

        $newListingData['user_id'] = '1';

        $newListingData = array_map(callback: 'sanitize', array: $newListingData);

        $requiredFields = ['title', 'description', 'email', 'city', 'salary'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string(value: $newListingData[$field])) {
                $errors[$field] = ucfirst(string: $field) . ' is required';
            }
        }

        if (!empty($errors)) {
            // Reload view with errors
            loadView(name: 'listings/create', data: [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            $fields = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(separator: ', ', array: $fields);

            $values = [];

            foreach ($newListingData as $field => $value) {
                // Convert empty strings to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }

            $values = implode(separator: ', ', array: $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            $this->db->query(query: $query, params: $newListingData);

            redirect(url: 'listings');
        }
    }
    /**
     * 
     * @param array @params
     * @return void
     */
    public function destroy($params): void
    {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query(query: 'SELECT * FROM listings WHERE id = :id', params: $params)->fetch();

        if (!$listing) {
            ErrorController::notFound(message: 'Listing not found');
            return;
        }

        $this->db->query(query: 'DELETE FROM listings WHERE id = :id', params: $params);

        // Set flash mesage
        $_SESSION['success_message'] = 'Listing deleted successfully';

        redirect(url: '/listings');
    }
    /**
     * Show the listing edit form
     * 
     * @param array $params
     * @return void
     */
    public function edit($params): void
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query(query: 'SELECT * FROM listings WHERE id = :id', params: ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound(message: 'Listing not found');
            return;
        }

        loadView(name: 'listings/edit', data: [
            'listing' => $listing
        ]);
    }
    /**
     * Update a listing
     * 
     * @param array $params
     * return void
     */
    public function update($params): void {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query(query: 'SELECT * FROM listings WHERE id = :id', params: ['id' => $id])->fetch();

        // Check if listing exists
        if (!$listing) {
            ErrorController::notFound(message: 'Listing not found');
            return;
        }

        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $updateValues = [];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updateValues = array_map(callback: 'sanitize', array: $updateValues);

        $requiredField = ['title', 'description', 'salary', 'email', 'city'];

        $errors = [];

        foreach ($requiredField as $field) {
            if(empty($updateValues[$field]) || !Validation::string(value: $updateValues[$field])) {
                $errors[$field] = ucfirst(string: $field) . ' is required';
            }
        }

        if(!empty($errors)) {
            loadView(name: 'listings/edit', data: [
                'listing' => $listing,
                'errors' => $errors
            ]);
            exit;
        } else {
            // Submit to database
            $updateFields = [];

            foreach(array_keys(array: $updateValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
            }
            $updateFields = implode(separator: ', ', array: $updateFields);
            
            $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";
            
            $updateValues['id'] = $id;

            $this->db->query(query: $updateQuery, params: $updateValues);

            $_SESSION['success_message'] = 'Listing Updated';

            redirect(url: '/listings/' . $id);
        }
        
    }
}