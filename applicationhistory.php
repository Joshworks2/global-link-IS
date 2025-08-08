<!DOCTYPE html>
<html>
<head>
  <title>Application History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #333;
      color: white;
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .header h1 {
      margin: 0;
      font-size: 22px;
    }

    .header .back-button {
      background-color: #555;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .job-card {
      margin-top: 20px;
      padding: 20px;
      background-color: #e9e9e9;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .job-card strong {
      font-size: 18px;
    }

    .job-card p {
      margin: 5px 0;
      color: #666;
    }

    .view-btn {
      padding: 10px 20px;
      background-color: #666;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>Application History</h1>
    <a href="jobseekerdashboard.php" class="back-button">HOME</a>
  </div>

  <div class="container">
    <!-- Example Job Application Card -->
    <div class="job-card">
      <div>
        <strong>Graphic Designer at Creative Co.</strong>
        <p>Submitted: July 10, 2025</p>
      </div>
      <button class="view-btn">View</button>
    </div>

    <!-- You can add more job application entries here -->

  </div>

</body>
</html>
