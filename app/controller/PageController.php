<?php

namespace root_dev\Controller;

class PageController {
    private $apiKey = 'sk-a05081075c064ce8a6f669e09535ca6c'; // Replace with your DeepSeek API key
    private $apiUrl = 'https://api.deepseek.com/v1/chat/completions';

    public function showProcessing() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // Get student profile data
        $profile = $this->getStudentProfile($_SESSION['user_id']);
        if (!$profile) {
            $_SESSION['error'] = 'Profile not found';
            header('Location: /dashboard');
            exit();
        }

        // Check if recommendations are already generated
        if (isset($_SESSION['recommendations']) && isset($_SESSION['recommendations_timestamp'])) {
            // If recommendations are less than 5 minutes old, use cached version
            if (time() - $_SESSION['recommendations_timestamp'] < 300) {
                header('Location: /recommendations');
                exit();
            }
        }

        // Generate recommendations using DeepSeek
        $recommendations = $this->generateRecommendations($profile);
        
        // Store recommendations in session with timestamp
        $_SESSION['recommendations'] = $recommendations;
        $_SESSION['recommendations_timestamp'] = time();
        
        // Display the processing page
        require_once __DIR__ . '/../views/processing.php';
    }

    public function checkRecommendations() {
        header('Content-Type: application/json');
        
        if (isset($_SESSION['recommendations']) && isset($_SESSION['recommendations_timestamp'])) {
            // Check if recommendations are still valid (less than 5 minutes old)
            if (time() - $_SESSION['recommendations_timestamp'] < 300) {
                echo json_encode(['ready' => true]);
                exit;
            }
        }
        
        echo json_encode(['ready' => false]);
        exit;
    }

    private function getStudentProfile($userId) {
        try {
            $db = \root_dev\Config\Database::connect();
            $stmt = $db->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error fetching profile: " . $e->getMessage());
            return false;
        }
    }

    private function generateRecommendations($profile) {
        try {
            // Prepare the prompt for DeepSeek
            $prompt = $this->createPrompt($profile);
            
            // Call DeepSeek API
            $response = $this->callDeepSeek($prompt);
            
            if (!$response) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to get response from DeepSeek API',
                    'raw_response' => 'The AI service is currently unavailable. Please try again later.',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }

            return [
                'status' => 'success',
                'raw_response' => $response,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        } catch (\Exception $e) {
            error_log("Error generating recommendations: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Error generating recommendations: ' . $e->getMessage(),
                'raw_response' => 'There was an error processing your request. Please try again later.',
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    private function createPrompt($profile) {
        return "As a career guidance counselor, analyze this student profile and provide detailed career recommendations:
        
        Academic Information:
        - Grade Level: {$profile['grade_level']}
        - Strand: {$profile['strand']}
        - GPA: {$profile['gpa']}
        
        Career Interests:
        - Primary Interest: {$profile['primary_interest']}
        - Secondary Interest: {$profile['secondary_interest']}
        
        Skills Assessment:
        - Mathematics: {$profile['math_skill']}/5
        - Science: {$profile['science_skill']}/5
        - Communication: {$profile['communication_skill']}/5
        - Problem Solving: {$profile['problem_solving_skill']}/5
        
        College Preferences:
        - Type: {$profile['college_type']}
        - Location: {$profile['location']}
        
        Family Background:
        - Parent's Occupation: {$profile['parent_occupation']}
        - Family Income: {$profile['family_income']}
        
        Please provide:
        1. Top 3 recommended college courses
        2. Career paths for each course
        3. Required skills and qualifications
        4. Potential universities/colleges
        5. Scholarship opportunities
        6. Action plan for preparation";
    }

    private function callDeepSeek($prompt) {
        $data = [
            'model' => 'deepseek-chat',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a career guidance counselor specializing in helping students choose their college courses and career paths.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 2000
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("DeepSeek API Error: " . $error);
            return false;
        }

        $result = json_decode($response, true);
        if (!isset($result['choices'][0]['message']['content'])) {
            error_log("Invalid response from DeepSeek: " . json_encode($result));
            return false;
        }

        return $result['choices'][0]['message']['content'];
    }
} 