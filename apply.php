<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply for Job</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      text-align: center;
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

    .nav-links {
      margin-top: 10px;
    }

    .nav-links a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    .nav-links a:hover {
      text-decoration: underline;
    }

    .form-container {
      background-color: white;
      width: 90%;
      max-width: 500px;
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 20px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    textarea {
      resize: vertical;
    }

    button {
      background-color: #333;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      margin-right: 10px;
    }

    button:hover {
      background-color: #555;
    }

    .back-home {
      display: inline-block;
      margin-top: 20px;
      text-align: center;
    }

    .back-home a {
      text-decoration: none;
      color: white;
      background-color: #333;
      padding: 10px 20px;
      border-radius: 4px;
      display: inline-block;
    }

    .back-home a:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="myjobs.php">← Back</a>
    </div>
  </div>

  <div class="form-container">
    <h3>Welcome to applications</h3>
    <form>
      <label for="fullName">Full Name:
        <input type="text" id="fullName" placeholder="John Doe" required>
      </label>

      <label for="email">Email:
        <input type="email" id="email" placeholder="you@example.com" required>
      </label>

      <label for="phone">Phone Number:
        <input type="tel" id="phone" placeholder="+2547XXXXXXX" required>
      </label>

      <label for="message">Why are you fit for this job?
        <textarea id="message" rows="4" placeholder="Write something brief..." required></textarea>
      </label>

      <label for="cv">Upload CV:
        <input type="file" id="cv" accept=".pdf,.doc,.docx">
      </label>

      <label for="video">Upload Video:
        <input type="file" id="video" accept="video/*">
      </label>

      <button type="submit">Submit Application</button>
      <button type="reset">Reset</button>
    </form>
    
    </div>
  </div>
</body>
</html>
