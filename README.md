# Cero1PHP

Cero1PHP is a web application designed to facilitate collaboration and management within the ZeroOne Code Club. It serves as a centralized portal for communication, project management, event organization, and resource sharing.

## Table of Contents
1. [Introduction](#introduction)
2. [Objectives](#objectives)
3. [Target Audience](#target-audience)
4. [User Roles](#user-roles)
5. [Features](#features)
6. [Technology Stack](#technology-stack)
7. [File Structure](#file-structure)
8. [Implementation Plan](#implementation-plan)
9. [Conclusion](#conclusion)

## Introduction
Cero1PHP streamlines collaboration among students, core members, advisors, and the Directorate for Strategic Initiatives and Operational Governance (DSIOG).

## Objectives
- **User-Friendly Interface**: Intuitive navigation for all user levels.
- **Streamlined Communication**: Facilitate effective interactions.
- **Project & Event Management**: Efficient handling from planning to execution.
- **Data Integrity & Security**: Robust access controls for club data.
- **Feedback Mechanisms**: Enhance member satisfaction through feedback collection.

## Target Audience
- **Club Members**: Students accessing cohorts, projects, and events.
- **Core Members (Admins)**: Manage operations, projects, and events.
- **DSIOG**: Oversee club operations and strategic initiatives.
- **Advisors (Directors SAC)**: Provide guidance and support.

## User Roles
- **Club Members**: Access to cohorts, projects, events, and personal profiles.
- **Core Members**: Manage cohorts, projects, events, and reports.
- **DSIOG**: High-level administrative access for monitoring and evaluation.
- **Advisors**: Oversee and guide operations and strategic reports.

## Features
- **User Registration & Authentication**: Secure onboarding and account management.
- **Member Dashboard**: Access to cohorts, projects, events, and achievements.
- **Admin Dashboard**: Manage cohorts, projects, events, and generate reports.

## Technology Stack
- **Frontend & Backend**: PHP, JavaScript
- **Database**: MySQL
- **Containerization**: Docker
- **Version Control**: Git

## File Structure
The following is the directory structure of the Cero1PHP project:

Cero1PHP ├── Dockerfile # Docker configuration file for container setup ├── LICENSE # License file for the project ├── README.md # Documentation for the project ├── docker-compose.yml # Docker Compose configuration for multi-container applications └── my-app # Main application directory ├── assets # Directory for static assets like images │ └── Team_Work.jpg # Image asset used in the application ├── config.php # Configuration file for database and application settings ├── db.php # Database connection file ├── global.css # Global stylesheet for the application ├── includes # Directory for reusable PHP components │ ├── dashnav.php # Navigation component for the dashboard │ ├── footer.php # Footer component included in pages │ ├── nav.php # Main navigation component for the application │ ├── sidebar.css # Stylesheet for the sidebar component │ └── sidebar.php # Sidebar component included in pages ├── index.php # Main entry point of the application ├── insert.php # File for handling data insertion into the database ├── login.php # User login page ├── logout.php # User logout functionality └── pages # Directory for application-specific pages ├── dashboard # Dashboard page directory │ ├── dashboard.css # Stylesheet specific to the dashboard │ ├── dashboard.js # JavaScript for dashboard functionality │ └── dashboard.php # Dashboard page implementation └── sidebarOptions # Directory for sidebar option pages ├── cohorts.php # Page for managing cohorts └── projects.php # Page for managing projects

### File Descriptions:
- **Dockerfile**: A script for building the Docker image for the application, defining how the environment is set up.
- **LICENSE**: Contains the licensing information for the project.
- **README.md**: Provides documentation about the project, including objectives, features, and usage instructions.
- **docker-compose.yml**: A configuration file for Docker Compose, allowing you to define and run multi-container Docker applications.
- **my-app/**: The main directory containing all application files.
  - **assets/**: Contains static files like images used in the application.
  - **config.php**: Configuration file to set up database connection and application settings.
  - **db.php**: Handles database connections and queries.
  - **global.css**: Global CSS file for styles shared across the application.
  - **includes/**: Contains reusable components of the application, such as navigation and footer.
    - **dashnav.php**: Navigation bar for the dashboard.
    - **footer.php**: Footer section of the application.
    - **nav.php**: Main navigation structure.
    - **sidebar.css**: Styles for the sidebar component.
    - **sidebar.php**: Sidebar structure used in various pages.
  - **index.php**: The main entry point for the application that handles routing and displaying content.
  - **insert.php**: Handles data insertion for forms and databases.
  - **login.php**: Manages user login functionality.
  - **logout.php**: Implements user logout functionality.
  - **pages/**: Contains specific pages of the application, such as:
    - **dashboard/**: Directory containing files for the dashboard page, including its CSS and JavaScript.
    - **sidebarOptions/**: Contains specific options for the sidebar, like cohorts and projects management.

## Implementation Plan
1. **Phase 1**: Core functionalities development.
2. **Phase 2**: User testing and feedback collection.
3. **Phase 3**: Iterative improvements based on feedback.
4. **Phase 4**: Official launch and user onboarding.

## Conclusion
Cero1PHP aims to foster collaboration and engagement within the ZeroOne Code Club, enhancing project execution and community building.

