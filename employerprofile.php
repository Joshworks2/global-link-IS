<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Global-Link</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f4f4;
    }

    .navbar {
      background: #333;
      padding: 25px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .navbar .logo {
      color: white;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .nav-links {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    .nav-links li {
      margin-left: 30px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 18px;
      padding: 8px 16px;
      border-radius: 4px;
      transition: background 0.3s;
    }

    .nav-links a:hover {
      background: #555;
    }

    .main-content {
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .profile-box {
      background: white;
      padding: 30px 50px;
      border: 1px solid #ccc;
      border-radius: 12px;
      max-width: 600px;
      width: 100%;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .profile-box p {
      font-size: 17px;
      margin: 12px 0;
    }

    .profile-box a button {
      background: #333;
      color: white;
      border: none;
      padding: 12px 28px;
      margin-top: 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
    }

    .profile-box a button:hover {
      background: #555;
    }

    h3 {
      color: #333;
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <div class="logo">GLOBAL-LINK</div>
    <ul class="nav-links">
      <li><a href="employerdashboard.php">Home</a></li>
    </ul>
  </nav>

  <div class="main-content">
    <h3>My Profile</h3>
    <div class="profile-box">
      <p><strong>Name:</strong> Company Name</p>
      <p><strong>Email:</strong> employer@example.com</p>
      <p><strong>About:</strong> We are a leading company in the tech industry...</p>
      <a href="profile.php"><button>Edit Profile</button></a>
    </div>
  </div>

</body>
</html>
