<?php

require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

class StudentProfileController {
    private $studentProfile;
    private $db;

    public function __construct() {
        // Initialize database connection
        try {
            $this->db = Database::connect();
            $this->studentProfile = new StudentProfile($this->db);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Database connection failed'], 500);
        }
    }

    public function handleProfileSubmission() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['error' => 'Invalid request method'], 405);
        }

        // Validate user session
        if (!isset($_SESSION['user_id'])) {
            return $this->jsonResponse(['error' => 'User not authenticated'], 401);
        }

        // Validate and sanitize input
        $data = $this->validateAndSanitizeInput($_POST);
        if (!$data) {
            return $this->jsonResponse(['error' => 'Invalid input data'], 400);
        }

        // Add user_id to data
        $data['user_id'] = $_SESSION['user_id'];

        // Check if profile exists
        $existingProfile = $this->studentProfile->getProfile($_SESSION['user_id']);
        
        if ($existingProfile) {
            // Update existing profile
            $result = $this->studentProfile->updateProfile($_SESSION['user_id'], $data);
        } else {
            // Create new profile
            $result = $this->studentProfile->createProfile($data);
        }

        if ($result !== true) {
            return $this->jsonResponse(['error' => 'Failed to save profile: ' . print_r($result, true)], 500);
        }

        // Generate recommendations
        $recommendations = $this->studentProfile->generateRecommendations($_SESSION['user_id']);
        
        return $this->jsonResponse([
            'success' => true,
            'message' => 'Profile saved successfully',
            'recommendations' => $recommendations
        ]);
    }

    public function getProfile() {
        if (!isset($_SESSION['user_id'])) {
            return $this->jsonResponse(['error' => 'User not authenticated'], 401);
        }

        $profile = $this->studentProfile->getProfile($_SESSION['user_id']);
        
        if (!$profile) {
            return $this->jsonResponse(['error' => 'Profile not found'], 404);
        }

        return $this->jsonResponse(['profile' => $profile]);
    }

    private function validateAndSanitizeInput($data) {
        $required = [
            'grade_level', 'strand', 'gpa', 'college_type', 'location',
            'primary_interest', 'secondary_interest', 'math_skill',
            'science_skill', 'communication_skill', 'problem_solving_skill',
            'parent_occupation', 'family_income'
        ];

        // Check required fields
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return false;
            }
        }

        // Validate GPA
        if (!is_numeric($data['gpa']) || $data['gpa'] < 0 || $data['gpa'] > 4) {
            return false;
        }

        // Validate skill ratings
        $skills = ['math_skill', 'science_skill', 'communication_skill', 'problem_solving_skill'];
        foreach ($skills as $skill) {
            if (!is_numeric($data[$skill]) || $data[$skill] < 1 || $data[$skill] > 5) {
                return false;
            }
        }

        // Sanitize string inputs
        $stringFields = ['parent_occupation', 'strand', 'college_type', 'location'];
        foreach ($stringFields as $field) {
            $data[$field] = filter_var($data[$field], FILTER_SANITIZE_STRING);
        }

        return $data;
    }

    private function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 