<?php

class PageController {
    public function showProcessing() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // Display the processing page
        require_once __DIR__ . '/../views/processing.php';
    }
} 