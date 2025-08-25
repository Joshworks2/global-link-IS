<?php
session_start();
include 'db_connect.php'; // database connection

// Assuming user is logged in and user_id is in session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("You must be logged in to view this page.");
}

if (isset($_GET['id'])) {
    // ===== Show application details =====
    $app_id = intval($_GET['id']);

    $query = "
        SELECT a.id, a.status, a.cover_letter, a.video_path, a.applied_at, 
               j.title AS job_title, j.description, j.requirements,
               e.company_name, e.industry, e.location,
               u.full_name, r.file_path AS resume_path
        FROM applications a
        JOIN job_posts j ON a.job_id = j.id
        JOIN employers e ON j.employer_id = e.id
        JOIN users u ON a.user_id = u.id
        LEFT JOIN resumes r ON a.user_id = r.user_id
        WHERE a.id = ? AND a.user_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $app_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $app = $result->fetch_assoc();

    if (!$app) {
        die("Application not found.");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Application Details</title>
      <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; }
        .status { font-weight: bold; text-transform: capitalize; }
        .status.pending { color: orange; }
        .status.shortlisted { color: green; }
        .status.rejected { color: red; }
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #333; color: #fff; text-decoration: none; border-radius: 6px; }
        .section { margin-bottom: 20px; }
      </style>
    </head>
    <body>
      <div class="container">
        <h2><?= htmlspecialchars($app['job_title']) ?> at <?= htmlspecialchars($app['company_name']) ?></h2>
        <p><strong>Industry:</strong> <?= htmlspecialchars($app['industry']) ?> | <strong>Location:</strong> <?= htmlspecialchars($app['location']) ?></p>
        <p><strong>Applied on:</strong> <?= date("F j, Y", strtotime($app['applied_at'])) ?></p>
        <p><strong>Status:</strong> <span class="status <?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></p>

        <div class="section">
          <h3>Job Description</h3>
          <p><?= nl2br(htmlspecialchars($app['description'])) ?></p>
        </div>

        <div class="section">
          <h3>Requirements</h3>
          <p><?= nl2br(htmlspecialchars($app['requirements'])) ?></p>
        </div>

        <?php if (!empty($app['cover_letter'])): ?>
          <div class="section">
            <h3>Cover Letter</h3>
            <p><?= nl2br(htmlspecialchars($app['cover_letter'])) ?></p>
          </div>
        <?php endif; ?>

        <?php if (!empty($app['video_path'])): ?>
          <div class="section">
            <h3>Video Application</h3>
            <video controls width="100%">
              <source src="<?= htmlspecialchars($app['video_path']) ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        <?php endif; ?>

        <?php if (!empty($app['resume_path'])): ?>
          <div class="section">
            <h3>Resume</h3>
            <a href="<?= htmlspecialchars($app['resume_path']) ?>" target="_blank">Download Resume</a>
          </div>
        <?php endif; ?>

        <a href="applicationhistory.php" class="back-btn">← Back to Applications</a>
      </div>
    </body>
    </html>
    <?php
} else {
    // ===== Show application history list =====
    $query = "
        SELECT a.id, a.status, a.applied_at, 
               j.title AS job_title, 
               e.company_name
        FROM applications a
        JOIN job_posts j ON a.job_id = j.id
        JOIN employers e ON j.employer_id = e.id
        WHERE a.user_id = ?
        ORDER BY a.applied_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Application History</title>
      <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
        .header { background-color: #333; color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); }
        .header h1 { margin: 0; font-size: 22px; }
        .header .back-button { background-color: #555; color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .container { max-width: 800px; margin: 40px auto; background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .job-card { margin-top: 20px; padding: 20px; background-color: #e9e9e9; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .job-card strong { font-size: 18px; }
        .job-card p { margin: 5px 0; color: #666; }
        .status { font-weight: bold; text-transform: capitalize; }
        .status.pending { color: orange; }
        .status.shortlisted { color: green; }
        .status.rejected { color: red; }
        .view-btn { padding: 10px 20px; background-color: #666; color: #fff; border: none; border-radius: 6px; text-decoration: none; }
      </style>
    </head>
    <body>
      <div class="header">
        <h1>Application History</h1>
        <a href="jobseekerdashboard.php" class="back-button">HOME</a>
      </div>

      <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="job-card">
                <div>
                  <strong><?= htmlspecialchars($row['job_title']) ?> at <?= htmlspecialchars($row['company_name']) ?></strong>
                  <p>Submitted: <?= date("F j, Y", strtotime($row['applied_at'])) ?></p>
                  <p>Status: <span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></p>
                </div>
                <a href="applicationhistory.php?id=<?= $row['id'] ?>" class="view-btn">View</a>
              </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No applications found.</p>
        <?php endif; ?>
      </div>
    </body>
    </html>
    <?php
}
