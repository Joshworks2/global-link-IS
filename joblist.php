<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Job Listings - Global-Link</title>
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

    .top-btn {
      text-align: left;
      margin-bottom: 10px;
    }

    .top-btn a button {
      background: #333;
      color: white;
      border: none;
      padding: 8px 14px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
    }

    .top-btn a button:hover {
      background-color: #555;
    }

    h3 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
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
      padding: 6px 12px;
      margin-right: 10px;
      cursor: pointer;
      border-radius: 3px;
    }

    .card button:last-child {
      background: #999;
    }

    .card button:hover {
      opacity: 0.9;
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

  <div class="container">
    <div class="top-btn">
    </div>

    <h3>My Job Listings</h3>

    <div class="card">
      <strong>Web Developer</strong><br>
      Location: Remote<br><br>
      <button>Edit</button>
      <button>Delete</button>
    </div>

    <div class="card">
      <strong>Graphic Designer</strong><br>
      Location: New York<br><br>
      <button>Edit</button>
      <button>Delete</button>
    </div>
  </div>
</body>
</html>
