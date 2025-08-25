<?php
require "auth_check.php";
requireRole("employer"); 
include "db_connect.php";

$user_id = $_SESSION["user_id"]; // must be stored at login

// Fetch employer details
$sql = "SELECT u.full_name, u.email, e.company_name, e.industry, e.location, e.profile_description
        FROM users u
        LEFT JOIN employers e ON u.id = e.user_id
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$employer = $result->fetch_assoc();

// Handle updates
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $company_name = $_POST["company_name"];
    $industry = $_POST["industry"];
    $location = $_POST["location"];
    $profile_description = $_POST["profile_description"];

    // Update users table
    $stmt1 = $conn->prepare("UPDATE users SET full_name=?, email=? WHERE id=?");
    $stmt1->bind_param("ssi", $full_name, $email, $user_id);
    $stmt1->execute();

    // Update employers table
    $stmt2 = $conn->prepare("UPDATE employers 
                             SET company_name=?, industry=?, location=?, profile_description=? 
                             WHERE user_id=?");
    $stmt2->bind_param("ssssi", $company_name, $industry, $location, $profile_description, $user_id);
    $stmt2->execute();

    header("Location: employerprofile.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Profile - Global-Link</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f4f4f4; }
    .navbar {
      background: #333; padding: 25px 40px; display: flex;
      justify-content: space-between; align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .navbar .logo { color: white; font-size: 28px; font-weight: bold; }
    .nav-links { list-style: none; display: flex; margin: 0; padding: 0; }
    .nav-links li { margin-left: 30px; }
    .nav-links a { color: white; text-decoration: none; font-size: 18px; }
    .main-content { padding: 40px; display: flex; justify-content: center; }
    .profile-box {
      background: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 600px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .profile-box h3 { text-align: center; margin-bottom: 20px; }
    label { display: block; margin-top: 12px; font-weight: bold; }
    input, textarea {
      width: 100%; padding: 10px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 6px;
    }
    button {
      margin-top: 20px; width: 100%; padding: 12px;
      background: #333; color: white; border: none; border-radius: 6px;
      font-size: 16px; cursor: pointer;
    }
    button:hover { background: #555; }
    .success { color: green; text-align: center; }
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
    <div class="profile-box">
      <h3>My Profile</h3>
      <?php if (isset($_GET["success"])): ?>
        <p class="success">Profile updated successfully!</p>
      <?php endif; ?>

      <form method="POST">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($employer['full_name']); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($employer['email']); ?>">

        <label>Company Name</label>
        <input type="text" name="company_name" value="<?php echo htmlspecialchars($employer['company_name']); ?>">

        <label>Industry</label>
        <input type="text" name="industry" value="<?php echo htmlspecialchars($employer['industry']); ?>">

        <label>Location</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($employer['location']); ?>">

        <label>About</label>
        <textarea name="profile_description"><?php echo htmlspecialchars($employer['profile_description']); ?></textarea>

        <button type="submit">Save Changes</button>
      </form>
    </div>
  </div>

</body>
</html>
