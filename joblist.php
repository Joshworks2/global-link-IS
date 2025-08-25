<?php
session_start();
include 'db_connect.php';

// ✅ Make sure employer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Get employer ID for this user
$empQuery = $conn->prepare("SELECT id FROM employers WHERE user_id = ?");
$empQuery->bind_param("i", $user_id);
$empQuery->execute();
$employer = $empQuery->get_result()->fetch_assoc();

if (!$employer) {
    die("Employer profile not found.");
}

$employer_id = $employer['id'];

// ✅ Handle DELETE
if (isset($_GET['delete'])) {
    $job_id = (int) $_GET['delete'];

    $delete = $conn->prepare("
        DELETE jp FROM job_posts jp
        JOIN employers e ON jp.employer_id = e.id
        WHERE jp.id = ? AND e.user_id = ?
    ");
    $delete->bind_param("ii", $job_id, $user_id);
    $delete->execute();

    header("Location: joblist.php");
    exit;
}

// ✅ Handle EDIT form submission
if (isset($_POST['update'])) {
    $job_id = (int) $_POST['job_id'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];

    $update = $conn->prepare("
        UPDATE job_posts 
        SET title=?, location=?, description=?, requirements=? 
        WHERE id=? 
    ");
    $update->bind_param("ssssi", $title, $location, $description, $requirements, $job_id);
    $update->execute();

    header("Location: joblist.php");
    exit;
}

// ✅ Fetch all jobs by this employer
$jobQuery = $conn->prepare("SELECT * FROM job_posts WHERE employer_id = ? ORDER BY posted_at DESC");
$jobQuery->bind_param("i", $employer_id);
$jobQuery->execute();
$jobs = $jobQuery->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Job Listings - Global-Link</title>
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
    h3 { text-align: center; color: #333; margin-bottom: 20px; }
    .card { background: white; padding: 15px; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 5px; }
    .card button { background: #333; color: white; border: none; padding: 6px 12px; margin-right: 10px; cursor: pointer; border-radius: 3px; }
    .card button:last-child { background: #999; }
    .card button:hover { opacity: 0.9; }
    form { background: white; padding: 20px; border-radius: 5px; margin-top: 10px; }
    form input, form textarea { width: 100%; padding: 8px; margin: 8px 0; }
    form button { background: #333; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 3px; }
    form button:hover { background: #555; }
    .edit-form { margin-top: 10px; background: #f9f9f9; padding: 15px; border-radius: 5px; }
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
    <h3>My Job Listings</h3>

    <!-- ✅ Job List -->
    <?php if ($jobs->num_rows > 0): ?>
      <?php while ($job = $jobs->fetch_assoc()): ?>
        <div class="card">
          <strong><?php echo htmlspecialchars($job['title']); ?></strong><br>
          Location: <?php echo htmlspecialchars($job['location']); ?><br>
          <small>Posted on: <?php echo $job['posted_at']; ?></small><br><br>

          <!-- Default Buttons -->
          <button onclick="toggleEdit(<?php echo $job['id']; ?>)">Edit</button>
          <button onclick="if(confirm('Are you sure you want to delete this job?')) window.location.href='joblist.php?delete=<?php echo $job['id']; ?>'">Delete</button>
          <button onclick="window.location.href='applications.php?job_id=<?php echo $job['id']; ?>'">View Applicants</button>

          <!-- Inline Edit Form (hidden by default) -->
          <div id="edit-form-<?php echo $job['id']; ?>" class="edit-form" style="display: none;">
            <form method="POST">
              <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

              <label>Title:</label>
              <input type="text" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>

              <label>Location:</label>
              <input type="text" name="location" value="<?php echo htmlspecialchars($job['location']); ?>" required>

              <label>Description:</label>
              <textarea name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>

              <label>Requirements:</label>
              <textarea name="requirements" required><?php echo htmlspecialchars($job['requirements']); ?></textarea>

              <button type="submit" name="update">Update Job</button>
              <button type="button" onclick="toggleEdit(<?php echo $job['id']; ?>)">Cancel</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No jobs posted yet.</p>
    <?php endif; ?>
  </div>

  <script>
    function toggleEdit(jobId) {
      const form = document.getElementById('edit-form-' + jobId);
      form.style.display = (form.style.display === 'none' ? 'block' : 'none');
    }
  </script>
</body>
</html>
