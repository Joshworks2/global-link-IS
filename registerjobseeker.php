<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'jobseeker';

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("Email already registered. Please log in.");
    }
    $check->close();

    // ✅ Insert into users table
    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Prepare failed (users): " . $conn->error);

    $stmt->bind_param("ssss", $full_name, $email, $password, $role);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // ✅ Insert into job_seekers table
        $sql2 = "INSERT INTO job_seekers (user_id) VALUES (?)";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) die("Prepare failed (job_seekers): " . $conn->error);
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $stmt2->close();

        // ✅ Handle CV upload
        if (!empty($_FILES['cv']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES["cv"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFile)) {
                $sql3 = "INSERT INTO resumes (user_id, file_path) VALUES (?, ?)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("is", $user_id, $targetFile);
                $stmt3->execute();
                $stmt3->close();
            }
        }

        echo "✅ Registration successful. You can now log in.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Seeker Registration</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      text-align: center;
    }

    .header {
      background-color: #333;
      padding: 15px;
      color: white;
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
      margin-bottom: 10px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #333;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
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
    /* Form inputs */
input {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: all 0.3s ease;
  font-size: 14px;
}

/* Success / error border colors */
input.valid {
  border: 2px solid #28a745; /* green */
  background-color: #f9fff9;
}

input.invalid {
  border: 2px solid #dc3545; /* red */
  background-color: #fff8f8;
}

/* Error messages */
label small {
  display: block;
  font-size: 13px;
  margin-top: -5px;
  margin-bottom: 10px;
  visibility: hidden;
  color: #dc3545; /* red by default */
  transition: all 0.3s ease;
}

label small.visible {
  visibility: visible;
}

/* Password strength meter */
#strengthMessage {
  font-size: 13px;
  font-weight: bold;
  margin-top: -5px;
  margin-bottom: 10px;
}

/* Buttons */
button {
  background-color: #333;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 10px;
  font-size: 14px;
  transition: all 0.3s ease;
}

button:hover {
  background-color: #555;
  transform: scale(1.05);
}

    
  </style>
</head>
<body>
    <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="login.php">Login</a>
      <a href="registeremployer.php">Register as employer</a>
    </div>
  </div>

  <div class="form-container">
    <h3>Job Seeker Registration</h3>
   <form method="POST" action="registerjobseeker.php" enctype="multipart/form-data" id="registrationForm">
  <label>Full Name:
    <input type="text" name="full_name" id="full_name" placeholder="John Doe" required>
    <small>Full name is required.</small>
  </label>
  
  <label>Email:
    <input type="email" name="email" id="email" placeholder="john@example.com" required>
    <small>Enter a valid email.</small>
  </label>
  
  <label>Password:
    <input type="password" name="password" id="password" required>
    <small>Password must be at least 8 characters with letters & numbers.</small>
    <div class="strength" id="strengthMessage"></div>
  </label>
  
  <label>Confirm Password:
    <input type="password" name="confirm_password" id="confirm_password" required>
    <small>Passwords do not match.</small>
  </label>

  <label>Upload CV:
    <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
    <small>Please upload your CV.</small>
  </label>

  <button type="submit">Register</button>
  <button type="reset">Reset</button>
</form>


    <div class="back-home">
      <a href="homepage.php">← Back to Home</a>
    </div>
  </div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registrationForm");
    const strengthMessage = document.getElementById("strengthMessage");

    function showError(input, message) {
        const small = input.parentElement.querySelector("small");
        if (small) {
            small.textContent = message;
            small.classList.add("visible");
        }
        input.classList.add("invalid");
        input.classList.remove("valid");
    }

    function showSuccess(input) {
        const small = input.parentElement.querySelector("small");
        if (small) {
            small.textContent = "";
            small.classList.remove("visible");
        }
        input.classList.add("valid");
        input.classList.remove("invalid");
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function checkPasswordStrength(pass) {
        let strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        let mediumRegex = /^(?=.*[a-z])(?=.*\d).{6,}$/;

        if (!strengthMessage) return;

        if (strongRegex.test(pass)) {
            strengthMessage.textContent = "Strong ✅";
            strengthMessage.style.color = "green";
        } else if (mediumRegex.test(pass)) {
            strengthMessage.textContent = "Medium ⚠";
            strengthMessage.style.color = "orange";
        } else {
            strengthMessage.textContent = "Weak ❌";
            strengthMessage.style.color = "red";
        }
    }

    const fields = form.querySelectorAll("input[required]");

    fields.forEach(input => {
        input.addEventListener("input", () => {
            if (input.type === "email") {
                isValidEmail(input.value) ? showSuccess(input) : showError(input, "Enter a valid email.");
            } 
            else if (input.id === "password") {
                checkPasswordStrength(input.value);
                input.value.length >= 8 ? showSuccess(input) : showError(input, "Password too short.");
                const confirmPassword = form.querySelector("#confirm_password");
                if (confirmPassword.value !== "") {
                    confirmPassword.value === input.value
                        ? showSuccess(confirmPassword)
                        : showError(confirmPassword, "Passwords do not match.");
                }
            }
            else if (input.id === "confirm_password") {
                const password = form.querySelector("#password");
                input.value === password.value
                    ? showSuccess(input)
                    : showError(input, "Passwords do not match.");
            }
            else {
                input.value.trim() !== "" ? showSuccess(input) : showError(input, "This field is required.");
            }
        });
    });

    form.addEventListener("submit", e => {
        let allValid = true;
        fields.forEach(input => {
            if (!input.classList.contains("valid")) {
                showError(input, "This field is required or invalid.");
                allValid = false;
            }
        });
        if (!allValid) e.preventDefault();
    });
});

</script>
</body>

</html>
