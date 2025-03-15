CREATE DATABASE IF NOT EXISTS portfolio_generator;

USE portfolio_generator;


-- User table: Stores authentication & basic user info

CREATE TABLE IF NOT EXISTS user (
    Id INT(10) PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

-- Personal Info: Stores additional user details
CREATE TABLE IF NOT EXISTS personal_info (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    fullName VARCHAR(50), 
    phone VARCHAR(20),                -- Moved from user table
    profile_picture VARCHAR(255),      -- Path to .jpg/.png
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Skills: Stores soft and technical skills
CREATE TABLE IF NOT EXISTS skills (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    soft_skills TEXT,
    technical_skills TEXT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Academic Background: Optional section
CREATE TABLE IF NOT EXISTS academic_background (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    institution VARCHAR(150),
    degree VARCHAR(100),
    graduation_year YEAR,
    grade VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Work Experience: Stores employment history
CREATE TABLE IF NOT EXISTS professional_experience (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    job_title VARCHAR(100),
    job_duration VARCHAR(50),  -- Example: "Jan 2020 - Dec 2021"
    responsibilities TEXT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Projects & Publications: Unified table for both
CREATE TABLE IF NOT EXISTS projects_publications (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    link VARCHAR(255),  -- Optional link (GitHub, DOI, etc.)
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);