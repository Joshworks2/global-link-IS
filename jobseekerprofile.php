<?php
require "auth_check.php";
requireRole("jobseeker");
include "db_connect.php";

$user_id = $_SESSION["user_id"]; // ensure user_id is saved in session at login

// Fetch existing data
$sql = "SELECT u.full_name, u.email, js.skills, js.education, js.profile_summary 
        FROM users u 
        LEFT JOIN job_seekers js ON u.id = js.user_id 
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $skills = $_POST["skills"];
    $education = $_POST["education"];
    $profile_summary = $_POST["profile_summary"];

    // Update users table
    $stmt1 = $conn->prepare("UPDATE users SET full_name=?, email=? WHERE id=?");
    $stmt1->bind_param("ssi", $full_name, $email, $user_id);
    $stmt1->execute();

    // Update job_seekers table
    $stmt2 = $conn->prepare("UPDATE job_seekers SET skills=?, education=?, profile_summary=? WHERE user_id=?");
    $stmt2->bind_param("sssi", $skills, $education, $profile_summary, $user_id);
    $stmt2->execute();

    // Optional: handle video upload
    if (!empty($_FILES["profile_video"]["name"])) {
        $targetDir = "uploads/videos/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $videoName = time() . "_" . basename($_FILES["profile_video"]["name"]);
        $targetFile = $targetDir . $videoName;
        if (move_uploaded_file($_FILES["profile_video"]["tmp_name"], $targetFile)) {
            $stmt3 = $conn->prepare("UPDATE job_seekers SET profile_summary=? WHERE user_id=?");
            $stmt3->bind_param("si", $targetFile, $user_id);
            $stmt3->execute();
        }
    }

    header("Location: jobseekerprofile.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Job Seeker Profile</title>
  <style>
    body {
      background-color: #f3f3f3;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #444;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    .header h1 { margin: 0; font-size: 22px; }
    .container {
      max-width: 700px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label { display: block; margin-top: 15px; color: #555; }
    input[type="text"], input[type="email"], input[type="file"], textarea {
      width: 100%; padding: 10px; border: 1px solid #ccc;
      border-radius: 6px; margin-bottom: 10px;
    }
    button[type="submit"] {
      width: 100%; padding: 12px; background-color: #666; color: white;
      border: none; border-radius: 6px; font-size: 16px; cursor: pointer;
    }
    button[type="submit"]:hover { background-color: #555; }
    .success { color: green; text-align: center; }
  </style>
</head>
<body>

  <div class="header">
    <h1>GLOBAL LINK</h1>
    <nav>
    <a href="jobseekerdashboard.php">HOME</a>
    </nav>
  </div>

  <div class="container">
    <h2>My Profile</h2>
    <?php if (isset($_GET["success"])): ?>
      <p class="success">Profile updated successfully!</p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <label>Full Name:</label>
      <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">

      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

      <label>Skills:</label>
      <input type="text" name="skills" value="<?php echo htmlspecialchars($user['skills']); ?>">

      <label>Education:</label>
      <input type="text" name="education" value="<?php echo htmlspecialchars($user['education']); ?>">

      <label>Profile Summary:</label>
      <textarea name="profile_summary"><?php echo htmlspecialchars($user['profile_summary']); ?></textarea>

      <label>Upload New Profile Video:</label>
      <input type="file" name="profile_video" accept="video/*">

      <button type="submit">Save Changes</button>
    </form>
  </div>

</body>
</html>
