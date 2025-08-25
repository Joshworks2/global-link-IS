<?php
   session_start();
   echo "<pre>";
   print_r($_SESSION);
    echo "</pre>";
   exit;

  require "db_connect.php"; // DB connection

  // Only jobseekers can view this
  if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "jobseeker") {
      header("Location: login.php");
      exit();
  }

  $user_id = $_SESSION["id"];
  $message = "";

  // Handle application submission
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["job_id"])) {
      $job_id = intval($_POST["job_id"]);

      // Check if already applied
      $check = $conn->prepare("SELECT id FROM applications WHERE user_id=? AND job_id=?");
      $check->bind_param("ii", $user_id, $job_id);
      $check->execute();
      $check->store_result();

      if ($check->num_rows == 0) {
          $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, status) VALUES (?, ?, 'pending')");
          $stmt->bind_param("ii", $user_id, $job_id);
          $stmt->execute();
          $stmt->close();
          $message = "✅ Application submitted successfully!";
      } else {
          $message = "⚠️ You already applied for this job.";
      }
      $check->close();
  }

  // Fetch jobs
  $sql = "SELECT job_posts.id, job_posts.title, job_posts.description, job_posts.requirements, job_posts.location, employers.company_name
          FROM job_posts
          INNER JOIN employers ON job_posts.employer_id = employers.id
          ORDER BY job_posts.posted_at DESC";
  $result = $conn->query($sql);
  $conn->close();
  ?>


  <?php
  session_start();
  require "db_connect.php"; // DB connection

  // ✅ Only jobseekers can view this page
  if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "jobseeker") {
      header("Location: login.php");
      exit();
  }

  // ✅ Ensure session user_id is set
  if (!isset($_SESSION["id"])) {
      header("Location: login.php");
      exit();
  }

  $user_id = $_SESSION["id"];
  $message = "";

  // ✅ Handle job application submission
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["job_id"])) {
      $job_id = intval($_POST["job_id"]);

      // Check if already applied
      $check = $conn->prepare("SELECT id FROM applications WHERE user_id=? AND job_id=?");
      $check->bind_param("ii", $user_id, $job_id);
      $check->execute();
      $check->store_result();

      if ($check->num_rows == 0) {
          $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, status) VALUES (?, ?, 'pending')");
          $stmt->bind_param("ii", $user_id, $job_id);
          if ($stmt->execute()) {
              $message = "✅ Application submitted successfully!";
          } else {
              $message = "⚠️ Error submitting application. Please try again.";
          }
          $stmt->close();
      } else {
          $message = "⚠️ You already applied for this job.";
      }
      $check->close();
  }

  // ✅ Fetch available jobs
  $sql = "SELECT job_posts.id, job_posts.title, job_posts.description, job_posts.requirements, job_posts.location, employers.company_name
          FROM job_posts
          INNER JOIN employers ON job_posts.employer_id = employers.id
          ORDER BY job_posts.posted_at DESC";
  $result = $conn->query($sql);
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Available Jobs</title>
    <style>
      body { margin:0; font-family:'Segoe UI',sans-serif; background:#f2f2f2; color:#333; }
      .header { background:#333; color:white; padding:20px; display:flex; justify-content:space-between; align-items:center; }
      .header .title { font-size:22px; font-weight:bold; }
      .header a button { background:#555; color:white; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; }
      .job-card { background:#fff; border-radius:8px; padding:20px; margin:20px auto; max-width:700px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
      .job-card h3 { margin:0 0 10px; }
      .job-card p { margin:5px 0; }
      .job-card button { background:#333; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; }
      .job-card button:hover { background:#555; }
      .message { text-align:center; margin:15px; font-weight:bold; }
      .success { color:green; }
      .error { color:darkred; }
    </style>
  </head>
  <body>
    <div class="header">
      <div class="title">GLOBAL-LINK</div>
      <a href="jobseekerdashboard.php"><button>HOME</button></a>
    </div>

    <main style="padding:20px;">
      <h2 style="text-align:center;">Available Jobs</h2>

      <?php if (!empty($message)): ?>
        <p class="message <?= strpos($message,'✅')!==false ? 'success' : 'error' ?>">
          <?= htmlspecialchars($message) ?>
        </p>
      <?php endif; ?>

      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="job-card">
            <h3><?= htmlspecialchars($row["title"]) ?></h3>
            <p><strong>Company:</strong> <?= htmlspecialchars($row["company_name"]) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($row["location"]) ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row["description"])) ?></p>
            <p><strong>Requirements:</strong> <?= nl2br(htmlspecialchars($row["requirements"])) ?></p>
            <form method="POST" action="">
              <input type="hidden" name="job_id" value="<?= $row['id'] ?>">
              <button type="submit">Apply Now</button>
            </form>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;">No jobs available at the moment.</p>
      <?php endif; ?>
    </main>
  </body>
  </html>
  <?php $conn->close(); ?>

