<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // always hash
    $role = 'jobseeker'; // Set the correct role

    // Insert into users table
    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed (users): " . $conn->error);
    }

    $stmt->bind_param("ssss", $full_name, $email, $password, $role);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // Insert into jobseekers table
        $sql2 = "INSERT INTO job_seekers (user_id) VALUES (?)";
        $stmt2 = $conn->prepare($sql2);

        if (!$stmt2) {
            die("Prepare failed (job_seekers): " . $conn->error);
        }

        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();

        echo "Registration successful. You can now log in.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Seeker Registration</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      text-align: center;
    }

    .header {
      background-color: #333;
      padding: 15px;
      color: white;
    }
    .nav-links {
      margin-top: 10px;
    }

    .nav-links a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    .nav-links a:hover {
      text-decoration: underline;
    }

    .form-container {
      background-color: white;
      width: 90%;
      max-width: 500px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #333;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
    }

    button:hover {
      background-color: #555;
    }

    .back-home {
      display: inline-block;
      margin-top: 20px;
      text-align: center;
    }

    .back-home a {
      text-decoration: none;
      color: white;
      background-color: #333;
      padding: 10px 20px;
      border-radius: 4px;
      display: inline-block;
    }

    .back-home a:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
    <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="login.php">Login</a>
      <a href="registeremployer.php">Register as employer</a>
    </div>
  </div>

  <div class="form-container">
    <h3>Job Seeker Registration</h3>
   <form method="POST" action="registerjobseeker.php" enctype="multipart/form-data">
  <label>Full Name:
    <input type="text" name="full_name" placeholder="John Doe" required>
  </label>
  
  <label>Email:
    <input type="email" name="email" placeholder="john@example.com" required>
  </label>
  
  <label>Password:
    <input type="password" name="password" required>
  </label>
  
  <label>Confirm Password:
    <input type="password" name="confirm_password" required>
  </label>

  <label>Upload CV:
    <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
  </label>

  <button type="submit">Register</button>
  <button type="reset">Reset</button>
</form>


    <div class="back-home">
      <a href="homepage.php">← Back to Home</a>
    </div>
  </div>

</body>
</html>
