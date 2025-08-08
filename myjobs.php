<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Jobs</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
      color: #333;
    }

    .header {
      background-color: #333;
      color: white;
      padding: 30px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .header .title {
      font-size: 20px;
      font-weight: bold;
    }

    .header .header-buttons {
      display: flex;
      gap: 12px;
    }

    .header .header-buttons a {
      text-decoration: none;
    }

    .header .header-buttons button {
      background-color: #555;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }

    .header .header-buttons button:hover {
      background-color: #777;
    }

    .job-card {
      background-color: #e0e0e0;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      margin: 1.5rem auto;
      max-width: 650px;
    }

    .job-card button {
      background-color: #555;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .job-card button:hover {
      background-color: #333;
    }

    .back-home {
      text-align: center;
      margin: 40px 0;
    }

    .back-home a button {
      background-color: #333;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }

    .back-home a button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="title">GLOBAL-LINK</div>
    <div class="header-buttons">
      <a href="jobseekerdashboard.php"><button>HOME</button></a>
    </div>
  </div>

  <main style="padding: 2rem; min-height: 100vh;">
    <h2 style="text-align: center; font-size: 2.2rem; margin-bottom: 2.5rem;">Available Jobs</h2>

    <!-- Sample Job Cards -->
    <div class="job-card">
      <h3>🖥️ Front-End Web Developer</h3>
      <p><strong>Skills:</strong> HTML, CSS, JavaScript</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>🎨 Graphic Designer Needed</h3>
      <p><strong>Skills:</strong> Adobe Photoshop, Portfolio</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>📲 Mobile App Developer</h3>
      <p><strong>Skills:</strong> Flutter, Firebase, UX Design</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>📝 Content Writer</h3>
      <p><strong>Skills:</strong> SEO, Copywriting, Research</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>📷 Social Media Manager</h3>
      <p><strong>Skills:</strong> Instagram, Analytics, Branding</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>🎬 Video Editor</h3>
      <p><strong>Skills:</strong> Premiere Pro, Timing, Visuals</p>
      <a href="aplly.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>📦 Logistics Coordinator</h3>
      <p><strong>Skills:</strong> Inventory, Communication, Fast Typing</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>👨‍💼 Virtual Assistant</h3>
      <p><strong>Skills:</strong> Calendar Management, Email Handling</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>🛒 E-commerce Product Uploader</h3>
      <p><strong>Skills:</strong> Excel, Shopify, Basic Image Editing</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

    <div class="job-card">
      <h3>🔧 UI/UX Tester</h3>
      <p><strong>Skills:</strong> Attention to Detail, Bug Reporting</p>
      <a href="apply.php"><button>Apply Now</button>
    </div>

  </main>

</body>
</html>
