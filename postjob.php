<?php
session_start();
require 'db_connect.php';

$user_id = $_SESSION['user_id']; // Logged in user ID

// 1. Get employer_id linked to this user
$empQuery = $conn->prepare("SELECT id FROM employers WHERE user_id = ?");
$empQuery->bind_param("i", $user_id);
$empQuery->execute();
$empResult = $empQuery->get_result();

if ($empResult->num_rows > 0) {
    $empRow = $empResult->fetch_assoc();
    $employer_id = $empRow['id'];
} else {
    die("Employer profile not found.");
}

// 2. Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description']; // NEW field
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO job_posts (employer_id, title, description, requirements, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $employer_id, $title, $description, $requirements, $location);

    if ($stmt->execute()) {
        echo "Job posted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post a Job</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .header {
      background: #333;
      padding: 10px 0;
      text-align: center;
      color: white;
    }

    .navbar {
      background: #555;
      padding: 10px 0;
      text-align: center;
    }

    .navbar a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    .container {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .job-form {
      background: white;
      padding: 30px;
      border-radius: 8px;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .job-form h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .job-form label {
      display: block;
      margin-bottom: 15px;
      font-weight: bold;
    }

    .job-form input[type="text"],
    .job-form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .job-form button {
      background: #333;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      margin-top: 20px;
      margin-right: 10px;
      cursor: pointer;
    }

    .job-form button:hover {
      background: #444;
    }

    .back-home {
      margin-top: 20px;
    }

    .back-home a button {
      background: #333;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .back-home a button:hover {
      background: #444;
    }
  </style>
</head>

<body>
  <div class="header">
    <h2>GLOBAL-LINK</h2>
  </div>

  <div class="container">
    <form class="job-form" method="POST" action="postjob.php">
       <h3>Post a New Job</h3>

       <label>Job Title:
       <input type="text" name="title">
       </label>

       <label>Requirements:
       <textarea name="requirements" required></textarea>
       </label>

       <label>Location:
        <input type="text" name="location">
       </label>
       
       <label>Job Description:
        <textarea name="description" required></textarea>
       </label>




       <button type="submit">Post Job</button>
       <button type="reset">Reset</button>
    </form>

    <div class="back-home">
      <a href="employerdashboard.php"><button>← Back to Home</button></a>
    </div>
  </div>

</body>
</html>
