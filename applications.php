<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Applicants - Global-Link</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
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
      color: white;
      font-size: 24px;
      font-weight: bold;
    }

    .nav-links {
      list-style: none;
      display: flex;
      padding: 0;
      margin: 0;
    }

    .nav-links li {
      margin-left: 20px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 12px;
      border-radius: 4px;
      transition: background 0.3s;
    }

    .nav-links a:hover {
      background-color: #444;
    }

    .container {
      padding: 20px;
      max-width: 800px;
      margin: auto;
    }

    .card {
      background: white;
      padding: 15px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
    }

    .card button {
      background: #333;
      color: white;
      border: none;
      padding: 5px 10px;
      margin-top: 5px;
      cursor: pointer;
    }

    .card button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar">
      <h1 class="logo">GLOBAL-LINK</h1>
      <ul class="nav-links">
        <li><a href="employerdashboard.php">Home</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main Content -->
  <div class="container">
    <h3 style="color:#333;">View Applicants</h3>

    <!-- Applicant card 1 -->
    <div class="card">
      <strong>Jane Doe</strong><br>
      Applied for: Web Developer<br>
      <button>View Resume</button>
    </div>

    <!-- Applicant card 2 -->
    <div class="card">
      <strong>John Smith</strong><br>
      Applied for: Graphic Designer<br>
      <button>View Resume</button>
    </div>
  </div>
</body>
</html>
