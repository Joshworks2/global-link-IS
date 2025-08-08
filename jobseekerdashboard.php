<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - GLOBALLINK</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }

    header {
      background-color: #2e2e2e;
      padding: 1rem 2rem;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      color: #fff;
      font-size: 1.8rem;
      font-weight: 600;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }

    .nav-links li a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-links li a:hover {
      color: #ffb347;
    }

    .dashboard {
      text-align: center;
      padding: 4rem 2rem;
    }

    .dashboard h2 {
      font-size: 2.2rem;
      margin-bottom: 2rem;
      color: #2e2e2e;
    }

    .dashboard-links {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .dashboard-card {
      background-color: #fff;
      width: 250px;
      padding: 2rem 1.5rem;
      border-radius: 12px;
      text-align: center;
      text-decoration: none;
      color: #2e2e2e;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .dashboard-card img {
      width: 60px;
      margin-bottom: 1rem;
    }

    .dashboard-card h3 {
      margin-top: 0.5rem;
      font-size: 1.2rem;
    }

    footer {
      background-color: #2e2e2e;
      color: #fff;
      text-align: center;
      padding: 1rem 0;
      font-size: 0.9rem;
      margin-top: 3rem;
    }

    @media (max-width: 768px) {
      .dashboard-links {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar">
      <h1 class="logo">GLOBAL-LINK</h1>
      <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="login.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="dashboard">
    <h2>Welcome!</h2>
    <div class="dashboard-links">
      <a href="applicationhistory.php" class="dashboard-card">
        <img src="https://img.icons8.com/ios-filled/100/upload.png" alt="Upload">
        <h3>application History</h3>
      </a>
      <a href="myjobs.php" class="dashboard-card">
        <img src="https://img.icons8.com/ios-filled/100/suitcase.png" alt="Jobs">
        <h3>Browse Jobs</h3>
      </a>
      <a href="myprofile.php" class="dashboard-card">
        <img src="https://img.icons8.com/ios-filled/100/user.png" alt="Profile">
        <h3>Edit Profile</h3>
      </a>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 SkillsMatch. All rights reserved.</p>
  </footer>
</body>
</html>
