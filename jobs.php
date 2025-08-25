<?php
require 'db_connect.php';

// Fetch all jobs
$query = "SELECT job_posts.*, employers.company_name 
          FROM job_posts 
          JOIN employers ON job_posts.employer_id = employers.id 
          ORDER BY job_posts.posted_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Jobs</title>
  <style>
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f2f2f2; color: #333; }
    .header { background-color: #333; color: white; padding: 15px; text-align: center; }
    .job-card { background-color: #e0e0e0; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.06); margin: 1.5rem auto; max-width: 650px; }
    .job-card button { background-color: #555; border: none; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background-color 0.3s ease; }
    .job-card button:hover { background-color: #333; }
    .back-home { text-align: center; margin: 40px 0; }
    .back-home a button { background-color: #333; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
    .back-home a button:hover { background-color: #555; }
  </style>
</head>
<body>

  <div class="header">
    <h2>GLOBAL-LINK</h2>
  </div>

  <main style="padding: 2rem; min-height: 100vh;">
    <h2 style="text-align: center; font-size: 2.2rem; margin-bottom: 2.5rem;">Browse Jobs</h2>

    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="job-card">
        <h3>📌 <?php echo htmlspecialchars($row['title']); ?></h3>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($row['company_name']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
        <p><strong>Requirements:</strong> <?php echo nl2br(htmlspecialchars($row['requirements'])); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
        <a href="apply.php?job_id=<?php echo $row['id']; ?>"><button>Apply Now</button></a>
      </div>
    <?php } ?>

    <div class="back-home">
      <a href="homepage.php"><button>Back to Home</button></a>
    </div>

  </main>

</body>
</html>
