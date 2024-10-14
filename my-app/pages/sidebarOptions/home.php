<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Home</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/home.css">
</head>
<body>
    <div class="home-container">
        <div class="home-container-in">
            <div class="home-container-in-heading">
                <h1>Greetings, <?php echo htmlspecialchars($name); ?>!</h1>
                <p>Welcome to your member dashboard.</p>
            </div>
            <div class="home-container-in-main">
                <div class="main-box">
                    <p>Number of Projects: 8+</p>
                    <div class="progress-container">
                        <div class="progress" style="width: 80%;"></div>
                    </div>
                </div>
                <div class="main-box">
                    <p>Number of Sessions: 50+</p>
                    <div class="progress-container">
                        <div class="progress" style="width: 70%;"></div>
                    </div>
                </div>
                <div class="main-box">
                    <p>Recent Contributions: 5</p>
                    <div class="progress-container">
                        <div class="progress" style="width: 90%;"></div>
                    </div>
                </div>
                <div class="main-box">
                    <p>Ongoing Projects: 3</p>
                    <div class="progress-container">
                        <div class="progress" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
            <div class="home-container-in-sub">
                <h2>Project Overview</h2>
                <div class="project-overview">
                    <div class="project-item">
                        <div class="project-name">Project 1</div>
                        <div class="project-status">Completed</div>
                        <div class="project-progress-container">
                            <div class="project-progress" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-name">Project 2</div>
                        <div class="project-status">In Progress</div>
                        <div class="project-progress-container">
                            <div class="project-progress" style="width: 60%;"></div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-name">Project 3</div>
                        <div class="project-status">In Progress</div>
                        <div class="project-progress-container">
                            <div class="project-progress" style="width: 40%;"></div>
                        </div>
                    </div>
                    <div class="project-item">
                        <div class="project-name">Project 4</div>
                        <div class="project-status">Pending Review</div>
                        <div class="project-progress-container">
                            <div class="project-progress" style="width: 20%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
