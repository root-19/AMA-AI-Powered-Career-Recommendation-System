-- Create student_profiles table
CREATE TABLE IF NOT EXISTS student_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    grade_level VARCHAR(20) NOT NULL,
    strand VARCHAR(50) NOT NULL,
    gpa DECIMAL(3,2) NOT NULL,
    college_type VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
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

-- Create career_recommendations table
CREATE TABLE IF NOT EXISTS career_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    profile_id INT NOT NULL,
    career_title VARCHAR(100) NOT NULL,
    confidence_score DECIMAL(5,2) NOT NULL,
    reasoning TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (profile_id) REFERENCES student_profiles(id) ON DELETE CASCADE
);

-- Create college_programs table
CREATE TABLE IF NOT EXISTS college_programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    program_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    required_skills TEXT NOT NULL,
    career_paths TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create program_recommendations table
CREATE TABLE IF NOT EXISTS program_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    profile_id INT NOT NULL,
    program_id INT NOT NULL,
    match_score DECIMAL(5,2) NOT NULL,
    reasoning TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (profile_id) REFERENCES student_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (program_id) REFERENCES college_programs(id) ON DELETE CASCADE
);

-- Add indexes for better performance
CREATE INDEX idx_user_id ON student_profiles(user_id);
CREATE INDEX idx_profile_id ON career_recommendations(profile_id);
CREATE INDEX idx_program_id ON program_recommendations(program_id); 