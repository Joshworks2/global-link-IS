<?php
session_start();
require 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to apply for jobs.");
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null; // Get job_id from URL

if (!$job_id) {
    die("Invalid job selected.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = $_POST['message'];

    // Handle CV upload (optional)
    $cvPath = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
        $cvName = time() . "_" . basename($_FILES['cv']['name']);
        $cvPath = "uploads/cv/" . $cvName;
        move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);

        // Save/update in resumes table (so each user has only 1 latest resume)
        $stmt = $conn->prepare("INSERT INTO resumes (user_id, file_path) VALUES (?, ?)
                                ON DUPLICATE KEY UPDATE file_path = VALUES(file_path)");
        $stmt->bind_param("is", $user_id, $cvPath);
        $stmt->execute();
        $stmt->close();
    }

    // Handle video upload (optional)
    $videoPath = null;
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $videoName = time() . "_" . basename($_FILES['video']['name']);
        $videoPath = "uploads/videos/" . $videoName;
        move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
    }

    // Insert into applications table
    $stmt = $conn->prepare("
        INSERT INTO applications (user_id, job_id, status, cover_letter, video_path) 
        VALUES (?, ?, 'pending', ?, ?)
    ");
    $stmt->bind_param("iiss", $user_id, $job_id, $message, $videoPath);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>✅ Application submitted successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply for Job</title>
  <style>
    body { margin:0; font-family: Arial,sans-serif; background:#f7f7f7; text-align:center; }
    .header { background:#333; color:white; padding:20px; display:flex; justify-content:space-between; align-items:center; }
    .nav-links a { color:white; margin:0 10px; text-decoration:none; font-weight:bold; }
    .nav-links a:hover { text-decoration:underline; }
    .form-container { background:#fff; width:90%; max-width:500px; margin:30px auto; padding:20px; border:1px solid #ccc; border-radius:8px; text-align:left; }
    label { display:block; margin-bottom:15px; font-weight:bold; }
    textarea, input[type="file"] { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:4px; }
    button { background:#333; color:white; padding:10px 20px; border:none; border-radius:4px; cursor:pointer; margin-right:10px; }
    button:hover { background:#555; }
  </style>
</head>
<body>
  <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="jobs.php">← Back</a>
    </div>
  </div>

  <div class="form-container">
   <h3>Why do you want to apply?</h3>
   <form method="POST" enctype="multipart/form-data">
    <label for="message">Your Cover Letter / Motivation:
      <textarea name="message" rows="5" required></textarea>
    </label>

    <label for="cv">Upload CV (optional):
      <input type="file" name="cv" accept=".pdf,.doc,.docx">
    </label>

    <label for="video">Upload Video (optional):
      <input type="file" name="video" accept="video/*">
    </label>

    <button type="submit">Submit Application</button>
    <button type="reset">Reset</button>
   </form>
  </div>
</body>
</html>
