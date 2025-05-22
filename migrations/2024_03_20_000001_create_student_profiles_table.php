<?php

class CreateStudentProfilesTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE IF NOT EXISTS student_profiles (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                grade_level VARCHAR(20) NOT NULL,
                strand VARCHAR(50) NOT NULL,
                gpa DECIMAL(3,2) NOT NULL,
                college_type VARCHAR(50) NOT NULL,
                preferred_location VARCHAR(100) NOT NULL,
                primary_interest VARCHAR(100) NOT NULL,
                secondary_interest VARCHAR(100) NOT NULL,
                math_skill INT NOT NULL,
                science_skill INT NOT NULL,
                communication_skill INT NOT NULL,
                problem_solving_skill INT NOT NULL,
                parent_occupation VARCHAR(100) NOT NULL,
                family_income VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ";
        $pdo->exec($query);
        echo "✔️  Student profiles table created successfully\n";
    }

    public function down($pdo) {
        $query = "DROP TABLE IF EXISTS student_profiles;";
        $pdo->exec($query);
    }
} 