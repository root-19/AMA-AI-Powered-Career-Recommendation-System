<?php

class StudentProfile {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createProfile($data) {
        try {
            $sql = "INSERT INTO student_profiles (
                user_id,
                grade_level,
                strand,
                gpa,
                college_type,
                location,
                primary_interest,
                secondary_interest,
                math_skill,
                science_skill,
                communication_skill,
                problem_solving_skill,
                parent_occupation,
                family_income,
                created_at
            ) VALUES (
                :user_id,
                :grade_level,
                :strand,
                :gpa,
                :college_type,
                :location,
                :primary_interest,
                :secondary_interest,
                :math_skill,
                :science_skill,
                :communication_skill,
                :problem_solving_skill,
                :parent_occupation,
                :family_income,
                NOW()
            )";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                'user_id' => $data['user_id'],
                'grade_level' => $data['grade_level'],
                'strand' => $data['strand'],
                'gpa' => $data['gpa'],
                'college_type' => $data['college_type'],
                'location' => $data['location'],
                'primary_interest' => $data['primary_interest'],
                'secondary_interest' => $data['secondary_interest'],
                'math_skill' => $data['math_skill'],
                'science_skill' => $data['science_skill'],
                'communication_skill' => $data['communication_skill'],
                'problem_solving_skill' => $data['problem_solving_skill'],
                'parent_occupation' => $data['parent_occupation'],
                'family_income' => $data['family_income']
            ]);
            if (!$result) {
                return $stmt->errorInfo();
            }
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProfile($userId) {
        try {
            $sql = "SELECT * FROM student_profiles WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching student profile: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $sql = "UPDATE student_profiles SET 
                grade_level = :grade_level,
                strand = :strand,
                gpa = :gpa,
                college_type = :college_type,
                location = :location,
                primary_interest = :primary_interest,
                secondary_interest = :secondary_interest,
                math_skill = :math_skill,
                science_skill = :science_skill,
                communication_skill = :communication_skill,
                problem_solving_skill = :problem_solving_skill,
                parent_occupation = :parent_occupation,
                family_income = :family_income,
                updated_at = NOW()
                WHERE user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                'user_id' => $userId,
                'grade_level' => $data['grade_level'],
                'strand' => $data['strand'],
                'gpa' => $data['gpa'],
                'college_type' => $data['college_type'],
                'location' => $data['location'],
                'primary_interest' => $data['primary_interest'],
                'secondary_interest' => $data['secondary_interest'],
                'math_skill' => $data['math_skill'],
                'science_skill' => $data['science_skill'],
                'communication_skill' => $data['communication_skill'],
                'problem_solving_skill' => $data['problem_solving_skill'],
                'parent_occupation' => $data['parent_occupation'],
                'family_income' => $data['family_income']
            ]);
            if (!$result) {
                return $stmt->errorInfo();
            }
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function generateRecommendations($userId) {
        try {
            $profile = $this->getProfile($userId);
            if (!$profile) {
                return false;
            }

            // Get recommendations based on profile data
            $sql = "SELECT * FROM career_recommendations 
                   WHERE strand = :strand 
                   AND (primary_interest = :primary_interest 
                   OR secondary_interest = :secondary_interest)
                   ORDER BY match_score DESC 
                   LIMIT 5";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'strand' => $profile['strand'],
                'primary_interest' => $profile['primary_interest'],
                'secondary_interest' => $profile['secondary_interest']
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error generating recommendations: " . $e->getMessage());
            return false;
        }
    }
} 