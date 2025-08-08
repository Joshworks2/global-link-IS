<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - Global-Link</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
    }

    .header {
      background: #333;
      padding: 25px 10px;
      color: white;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
    }

    .navbar {
      background: #333;
      padding: 15px 10px;
      text-align: center;
    }

    .navbar a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
    }

    .main-content {
      padding: 40px 20px;
      display: flex;
      justify-content: center;
    }

    .form-box {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 500px;
    }

    .form-box h3 {
      text-align: center;
      color: #333;
    }

    .form-box label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
    }

    .form-box input,
    .form-box textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #999;
      font-size: 14px;
    }

    .form-box button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      border: none;
      background: #333;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-box button:hover {
      background: #555;
    }

    .back-button {
      margin-top: 10px;
      text-align: center;
    }

    .back-button a button {
      width: 100%;
      padding: 12px;
      border: none;
      background: #444;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .back-button a button:hover {
      background: #666;
    }
  </style>
</head>
<body>

  <div class="header">GLOBAL-LINK</div>
  <div class="main-content">
    <div class="form-box">
      <h3>Edit Profile</h3>
      <form action="#" method="POST">
        <label for="name">Company Name:</label>
        <input type="text" id="name" name="name" value="Company Name">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="employer@example.com">

        <label for="about">About:</label>
        <textarea id="about" name="about" rows="5">We are a leading company in the tech industry...</textarea>

        <button type="submit">Save Changes</button>
      </form>

      <div class="back-button">
        <a href="employerprofile.php">
          <button type="button">BACK</button>
        </a>
      </div>
    </div>
  </div>

</body>
</html>
