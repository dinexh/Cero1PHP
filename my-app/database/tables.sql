-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_number VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE,
    cohort VARCHAR(50) NOT NULL,
    role ENUM('member', 'core', 'DSIOG') NOT NULL,
    message VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the grievances table
CREATE TABLE grievances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_number VARCHAR(50),
    grievance_text TEXT NOT NULL,
    status ENUM('pending', 'resolved', 'dismissed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

-- Create the feedback table
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_number VARCHAR(50),
    feedback_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

-- Create the projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_number VARCHAR(50),
    project_name VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('active', 'completed', 'archived') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

-- Create the events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_number VARCHAR(50),
    event_name VARCHAR(100) NOT NULL,
    event_date DATETIME NOT NULL,
    status ENUM('upcoming', 'completed', 'cancelled') NOT NULL DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

-- Create the cohorts table
CREATE TABLE cohorts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cohort_name VARCHAR(50) NOT NULL UNIQUE,
    number_of_students INT DEFAULT 0
);
