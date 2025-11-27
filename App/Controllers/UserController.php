<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath(path: 'config/db.php');
        $this->db = new Database(config: $config);
    }
    /**
     * Show the login page
     * 
     * @return void
     */
    public function login(): void
    {
        loadView(name: 'users/login');
    }
    /**
     * Show the register page
     * 
     * @return void
     */
    public function create(): void
    {
        loadView(name: 'users/create');
    }
    /**
     * Store user in database
     * 
     * @return void
     */
    public function store(): void
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $errors = [];

        // Validation
        if (!Validation::email(value: $email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (!Validation::string(value: $name, min: 2, max: 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if (!Validation::string(value: $name, min: 6, max: 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (!Validation::match(value1: $password, value2: $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            loadView(name: 'users/create', data: [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city
                ]
            ]);
            exit;
        }

        // Check if email exists
        $params = [
            'email' => $email
        ];

        $user = $this->db->query(query: 'SELECT * FROM users WHERE email = :email', params: $params)->fetch();

        if ($user) {
            $errors['email'] = 'That email already exists';
            loadView(name: 'users/create', data: [
                'errors' => $errors
            ]);
            exit;
        }

        // Create user account
        $params = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'password' => password_hash(password: $password, algo: PASSWORD_DEFAULT)
        ];

        $this->db->query(query: 'INSERT INTO users (name, email, city, password) VALUES (:name, :email, :city, :password)', params: $params);

        redirect(url: '/');
    }
}