<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = $_POST['company_name'];
    $industry = $_POST['industry'];
    $contact = $_POST['contact_person'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $logo = $_FILES['logo']['name'];

    $target_dir = "uploads/";
    move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir . $logo);

    // Insert into users table first
    $role = "employer";
    $sql2 = "INSERT INTO users (full_name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ssss", $contact, $email, $password, $role);

    if ($stmt2->execute()) {
        $user_id = $stmt2->insert_id; // get the ID of the new user

        // Insert into employers table (with user_id foreign key)
        $sql1 = "INSERT INTO employers (user_id, company_name, industry, location, profile_description)
                 VALUES (?, ?, ?, '', '')";
        $stmt1 = $conn->prepare($sql1);

        if (!$stmt1) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt1->bind_param("iss", $user_id, $company, $industry);

        if ($stmt1->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            echo "Error inserting employer: " . $stmt1->error;
        }
    } else {
        echo "Error inserting user: " . $stmt2->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Registration</title>
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

    input, select {
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

    .back-btn {
      margin-top: 20px;
      background-color: #888;
    }
  </style>
</head>
<body>

  <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="login.php">Login</a>
      <a href="registerjobseeker.php">Register as job-seeker</a>
    </div>
  </div>

  <div class="form-container">
    <h3>Employer Registration</h3>
 <form method="POST" action="registeremployer.php" enctype="multipart/form-data">
  <label>Company Name:
    <input type="text" name="company_name" placeholder="ABC Corporation" required>
  </label>
  
  <label>Industry:
    <input type="text" name="industry" placeholder="e.g. IT, Healthcare, Finance" required>
  </label>

  <label>Contact Person:
    <input type="text" name="contact_person" placeholder="Jane Smith" required>
  </label>

  <label>Email:
    <input type="email" name="email" placeholder="hr@company.com" required>
  </label>

  <label>Password:
    <input type="password" name="password" required>
  </label>

  <label>Confirm Password:
    <input type="password" name="confirm_password" required>
  </label>

  <label>Upload Company Logo:
    <input type="file" name="logo" accept=".jpg,.jpeg,.png,.svg">
  </label>

  <button type="submit">Register</button>
  <button type="reset">Reset</button>
</form>

    <button class="back-btn" onclick="window.location.href='homepage.php'">← Back to Home</button>
  </div>

</body>
</html>
