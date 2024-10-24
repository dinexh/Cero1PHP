
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  id_number VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(255),
  mail VARCHAR(100) NOT NULL UNIQUE,
  cohort VARCHAR(50) NOT NULL,
  role ENUM('member', 'core', 'DSIOG') NOT NULL,
  message VARCHAR(255),
  status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE feedback (
  id INT NOT NULL AUTO_INCREMENT,
  user_id VARCHAR(50),
  feedback_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  event_name VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  event_date DATE NOT NULL,
  concept_rating INT NOT NULL,
  mentorship_rating INT NOT NULL,
  domain_of_event VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id_number)
);

CREATE TABLE grievances (
  id INT NOT NULL AUTO_INCREMENT,
  user_id_number VARCHAR(50),
  grievance_text TEXT NOT NULL,
  status ENUM('pending', 'resolved', 'dismissed') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

CREATE TABLE events (
  id INT NOT NULL AUTO_INCREMENT,
  user_id_number VARCHAR(50),
  event_name VARCHAR(100) NOT NULL,
  event_date DATETIME NOT NULL,
  status ENUM('upcoming', 'completed', 'cancelled') NOT NULL DEFAULT 'upcoming',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

CREATE TABLE cohorts (
  id INT NOT NULL AUTO_INCREMENT,
  cohort_name VARCHAR(50) NOT NULL UNIQUE,
  number_of_students INT DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE projects (
  id INT NOT NULL AUTO_INCREMENT,
  user_id_number VARCHAR(50),
  project_name VARCHAR(100) NOT NULL,
  description TEXT,
  status ENUM('active', 'completed', 'archived') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id_number) REFERENCES users(id_number)
);

CREATE TABLE core_team_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    id_number VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    domain ENUM('Strategic Planning', 'Public Relations and Additional Operations', 'Video Editor and Social Media Manager') NOT NULL,
    role_expectations TEXT NOT NULL,
    club_expectations TEXT NOT NULL,
    full_potential ENUM('Yes', 'No') NOT NULL,
    previous_experience_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
