-- 1. Cohorts Table
CREATE TABLE cohorts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    batch VARCHAR(100) NOT NULL,
    info TEXT,
    number_of_people INT DEFAULT 0
);

-- 2. Users Table
CREATE TABLE users (
    id_number VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL UNIQUE,
    cohort_id INT,
    role ENUM('admin', 'member', 'DSIOG', 'core') NOT NULL,
    FOREIGN KEY (cohort_id) REFERENCES cohorts(id) ON DELETE SET NULL
);

-- 3. Feedback Table
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    mentorship_rating INT CHECK (mentorship_rating BETWEEN 1 AND 5),
    concept_rating INT CHECK (concept_rating BETWEEN 1 AND 5),
    feedback_text TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id_number) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS grievances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    information TEXT NOT NULL,
    date_reported DATETIME DEFAULT CURRENT_TIMESTAMP,
    ongoing TINYINT DEFAULT 1,
    result VARCHAR(255) DEFAULT 'Pending'
);

-- 5. Projects Table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    tech_stack VARCHAR(255),
    github_link VARCHAR(255),
    deployed_link VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 6. Project Members Table (Junction Table)
CREATE TABLE project_members (
    project_id INT NOT NULL,
    user_id VARCHAR(255) NOT NULL,
    role ENUM('member', 'lead') DEFAULT 'member',
    PRIMARY KEY (project_id, user_id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id_number) ON DELETE CASCADE
);

-- 7. Events Table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATETIME NOT NULL,
    description TEXT,
    created_by VARCHAR(255),
    FOREIGN KEY (created_by) REFERENCES users(id_number) ON DELETE SET NULL
);

-- 8. Attendance Table
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id VARCHAR(255) NOT NULL,
    attendance_status ENUM('attended', 'not_attended') DEFAULT 'attended',
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id_number) ON DELETE CASCADE
);
