<?php
session_start();

$conn = new mysqli("localhost", "root", "", "globallink_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// ✅ Show logout success message
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    $success = "You have been logged out successfully.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"]; // employer or jobseeker

    // Fetch user by email + role
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // ✅ Store session
            $_SESSION["user_id"]   = $user["id"];
            $_SESSION["email"]     = $user["email"];
            $_SESSION["role"]      = $user["role"];
            $_SESSION["full_name"] = $user["full_name"];

            // ✅ Redirect based on role
            if ($role === "employer") {
                header("Location: employerdashboard.php");
            } else {
                header("Location: jobseekerdashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found or role mismatch.";
    }

    $stmt->close();
}

$conn->close();
?>





  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>GLOBAL-LINK - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Poppins', sans-serif;
        background-color: #f2f2f2;
        color: #333;
      }

      .header {
        background-color: #333;
        color: white;
        padding: 1rem;
        text-align: center;
      }

      .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 90vh;
        padding: 2rem;
      }

      #loginForm {
        background-color: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
      }

      #loginForm h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #2e2e2e;
      }

      #loginForm input,
      #loginForm select {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
      }

      #loginForm button {
        width: 100%;
        padding: 0.9rem;
        background-color: #333;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1rem;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      #loginForm button:hover {
        background-color: #555;
      }

      .register-links {
        margin-top: 1.5rem;
        text-align: center;
      }

      .register-links a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
      }

      .register-links a:hover {
        text-decoration: underline;
      }

      .back-home {
        margin-top: 2rem;
        text-align: center;
      }

      .back-home a button {
        background-color: #333;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
      }

      .back-home a button:hover {
        background-color: #555;
      }

      .error {
        color: red;
        text-align: center;
        margin-bottom: 1rem;
      }
    </style>
  </head>
  <body>
    <div class="header">
      <h2>GLOBAL-LINK</h2>
    </div>

    <main class="login-container">
      <?php if (!empty($success)): ?>
    <div style="color: green; font-weight: bold; text-align:center; margin-bottom:10px;">
        <?= htmlspecialchars($success) ?>
    </div>
     <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div style="color: red; font-weight: bold; text-align:center; margin-bottom:10px;">
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

      <form method="POST" action="login.php" id="loginForm">
        <h2>Login</h2>

        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">

        <select name="role" required>
        <option value="">Select Role</option>
        <option value="jobseeker">Job Seeker</option>
        <option value="employer">Employer</option>
        </select>


        <button type="submit">Login</button>

        <div class="register-links">
          <p>Don't have an account?</p>
          <a href="registerjobseeker.php">Job Seeker Register</a> |
          <a href="registeremployer.php">Employer Register</a>
        </div>
      </form>

      <div class="back-home">
        <a href="homepage.php"><button>Back to Home</button></a>
      </div>
    </main>
  </body>
  </html>
