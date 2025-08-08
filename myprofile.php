<!DOCTYPE html>
<html>
<head>
  <title>Job Seeker Profile</title>
  <style>
    body {
      background-color: #f3f3f3;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #444;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .header h1 {
      margin: 0;
      font-size: 22px;
    }

    .header button {
      background-color: #ffffff;
      color: #444;
      border: none;
      border-radius: 6px;
      padding: 10px 18px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .header button:hover {
      background-color: #ddd;
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .container h2 {
      text-align: center;
      color: #444;
    }

    label {
      display: block;
      margin-top: 15px;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 10px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #666;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #555;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>GLOBAL LINK</h1>
    <a href="jobseekerdashboard.php"><button>HOME</button></a>
  </div>

  <div class="container">
    <h2>My Profile</h2>

    <form>
      <label>Full Name:</label>
      <input type="text" value="John Doe">

      <label>Email:</label>
      <input type="email" value="johndoe@email.com">

      <label>Skills:</label>
      <input type="text" value="Adobe Photoshop, Figma">

      <label>Education:</label>
      <input type="text" value="Diploma in IT">

      <label>Upload New Profile Video:</label>
      <input type="file" accept="video/*">

      <button type="submit">Save Changes</button>
    </form>
  </div>

</body>
</html>
