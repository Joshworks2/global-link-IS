<?php
session_start();
require 'db_connect.php';

// Ensure employer is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in as an employer to view applicants.");
}

$user_id = $_SESSION['user_id'];

// Get employer ID
$empQuery = $conn->prepare("SELECT id FROM employers WHERE user_id = ?");
$empQuery->bind_param("i", $user_id);
$empQuery->execute();
$empResult = $empQuery->get_result();

if ($empResult->num_rows === 0) {
    die("Employer profile not found.");
}
$employer_id = $empResult->fetch_assoc()['id'];

// ✅ Handle status update form
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['application_id'], $_POST['status'])) {
    $application_id = intval($_POST['application_id']);
    $status = $_POST['status'];

    // Update status only if the application belongs to this employer
    $updateQuery = "
        UPDATE applications a
        JOIN job_posts j ON a.job_id = j.id
        SET a.status = ?
        WHERE a.id = ? AND j.employer_id = ?
    ";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sii", $status, $application_id, $employer_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch applicants for this employer's jobs
$query = "
    SELECT 
        a.id AS application_id, 
        u.full_name, 
        u.email, 
        j.title AS job_title,
        r.file_path AS resume_path,
        a.status,
        a.applied_at
    FROM applications a
    JOIN users u ON a.user_id = u.id
    JOIN job_posts j ON a.job_id = j.id
    LEFT JOIN resumes r ON a.user_id = r.user_id
    WHERE j.employer_id = ?
    ORDER BY a.applied_at DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Applicants - Global-Link</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
    header { background-color: #2e2e2e; padding: 1rem 2rem; }
    .navbar { display: flex; justify-content: space-between; align-items: center; }
    .logo { color: white; font-size: 24px; font-weight: bold; }
    .nav-links { list-style: none; display: flex; padding: 0; margin: 0; }
    .nav-links li { margin-left: 20px; }
    .nav-links a { color: white; text-decoration: none; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: background 0.3s; }
    .nav-links a:hover { background-color: #444; }
    .container { padding: 20px; max-width: 800px; margin: auto; }
    .card { background: white; padding: 15px; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 6px; }
    .card strong { font-size: 1.1em; }
    .card form { margin-top: 10px; }
    .card select, .card button { padding: 6px 10px; margin-top: 5px; }
    .card button { background: #333; color: white; border: none; cursor: pointer; border-radius: 4px; }
    .card button:hover { background-color: #555; }
    .status { font-size: 0.9em; color: #666; }
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

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong> <br>
                Applied for: <em><?php echo htmlspecialchars($row['job_title']); ?></em> <br>
                Email: <?php echo htmlspecialchars($row['email']); ?> <br>
                Applied at: <?php echo $row['applied_at']; ?> <br>

                <?php if ($row['resume_path']): ?>
                    <a href="<?php echo $row['resume_path']; ?>" target="_blank">
                        <button type="button">View Resume</button>
                    </a>
                <?php else: ?>
                    <p>No resume uploaded</p>
                <?php endif; ?>

                <p>Status: <span class="status"><?php echo ucfirst($row['status']); ?></span></p>

                <!-- Status Update Form -->
                <form method="POST">
                    <input type="hidden" name="application_id" value="<?php echo $row['application_id']; ?>">
                    <select name="status">
                        <option value="pending" <?php if ($row['status'] == "pending") echo "selected"; ?>>Pending</option>
                        <option value="shortlisted" <?php if ($row['status'] == "shortlisted") echo "selected"; ?>>Shortlisted</option>
                        <option value="rejected" <?php if ($row['status'] == "rejected") echo "selected"; ?>>Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No applicants yet for your jobs.</p>
    <?php endif; ?>
  </div>
</body>
</html>

