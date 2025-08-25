<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = trim($_POST['company_name']);
    $industry = trim($_POST['industry']);
    $contact = trim($_POST['contact_person']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "employer";

    // ✅ Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "❌ Email already registered. Please use another one.";
    } else {
        // ✅ Handle logo upload (optional)
        $logo = NULL;
        if (!empty($_FILES['logo']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $logo = time() . "_" . basename($_FILES["logo"]["name"]);
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir . $logo);
        }

        // ✅ Insert into users
        $sql2 = "INSERT INTO users (full_name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ssss", $contact, $email, $password, $role);

        if ($stmt2->execute()) {
            $user_id = $stmt2->insert_id;

            // ✅ Insert into employers
            $sql1 = "INSERT INTO employers (user_id, company_name, industry, logo, location, profile_description) 
                     VALUES (?, ?, ?, ?, '', '')";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("isss", $user_id, $company, $industry, $logo);

            if ($stmt1->execute()) {
                echo "✅ Registration successful! Redirecting...";
                header("Refresh:2; url=login.php");
                exit();
            } else {
                echo "Error inserting employer: " . $stmt1->error;
            }
        } else {
            echo "Error inserting user: " . $stmt2->error;
        }
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employer Registration</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; text-align: center; }
    .header { background-color: #333; padding: 15px; color: white; }
    .nav-links { margin-top: 10px; }
    .nav-links a { color: white; margin: 0 15px; text-decoration: none; font-weight: bold; }
    .nav-links a:hover { text-decoration: underline; }
    .form-container { background-color: white; width: 90%; max-width: 500px; margin: 30px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; text-align: left; }
    label { display: block; margin-bottom: 10px; }
    input, select { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; transition: all 0.3s ease; }
    input.valid { border: 2px solid #28a745; background: #f9fff9; }
    input.invalid { border: 2px solid #dc3545; background: #fff8f8; }
    label small { display: block; font-size: 13px; margin-top: -5px; margin-bottom: 10px; visibility: hidden; color: #dc3545; }
    label small.visible { visibility: visible; }
    #strengthMessage { font-size: 13px; font-weight: bold; margin-top: -5px; margin-bottom: 10px; }
    button { background-color: #333; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; transition: 0.3s; }
    button:hover { background-color: #555; transform: scale(1.05); }
    .back-btn { margin-top: 20px; background: #888; }
  </style>
</head>
<body>
  <div class="header">
    <h2>GLOBAL-LINK</h2>
    <div class="nav-links">
      <a href="login.php">Login</a>
      <a href="registerjobseeker.php">Register as Job Seeker</a>
    </div>
  </div>

  <div class="form-container">
    <h3>Employer Registration</h3>
    <form method="POST" action="registeremployer.php" enctype="multipart/form-data" id="employerForm">
      <label>Company Name:
        <input type="text" name="company_name" required>
        <small>Company name is required.</small>
      </label>
      
      <label>Industry:
        <input type="text" name="industry" required>
        <small>Industry is required.</small>
      </label>

      <label>Contact Person:
        <input type="text" name="contact_person" required>
        <small>Contact person is required.</small>
      </label>

      <label>Email:
        <input type="email" name="email" id="email" required>
        <small>Enter a valid email.</small>
      </label>

      <label>Password:
        <input type="password" name="password" id="password" required>
        <small>Password must be at least 8 characters with letters & numbers.</small>
        <div id="strengthMessage"></div>
      </label>

      <label>Confirm Password:
        <input type="password" name="confirm_password" id="confirm_password" required>
        <small>Passwords do not match.</small>
      </label>

      <label>Upload Company Logo:
        <input type="file" name="logo" accept=".jpg,.jpeg,.png,.svg">
        <small>Upload a valid company logo.</small>
      </label>

      <button type="submit">Register</button>
      <button type="reset">Reset</button>
    </form>

    <button class="back-btn" onclick="window.location.href='homepage.php'">← Back to Home</button>
  </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("employerForm");
    const strengthMessage = document.getElementById("strengthMessage");

    function showError(input, message) {
        const small = input.parentElement.querySelector("small");
        if (small) { small.textContent = message; small.classList.add("visible"); }
        input.classList.add("invalid"); input.classList.remove("valid");
    }
    function showSuccess(input) {
        const small = input.parentElement.querySelector("small");
        if (small) { small.textContent = ""; small.classList.remove("visible"); }
        input.classList.add("valid"); input.classList.remove("invalid");
    }
    function isValidEmail(email) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }
    function checkPasswordStrength(pass) {
        let strong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        let medium = /^(?=.*[a-z])(?=.*\d).{6,}$/;
        if (strong.test(pass)) { strengthMessage.textContent = "Strong ✅"; strengthMessage.style.color = "green"; }
        else if (medium.test(pass)) { strengthMessage.textContent = "Medium ⚠"; strengthMessage.style.color = "orange"; }
        else { strengthMessage.textContent = "Weak ❌"; strengthMessage.style.color = "red"; }
    }

    const fields = form.querySelectorAll("input[required]");
    fields.forEach(input => {
        input.addEventListener("input", () => {
            if (input.type === "email") {
                if (isValidEmail(input.value)) {
                    // ✅ AJAX check email
                    fetch("check_email.php", {
                        method: "POST",
                        headers: {"Content-Type": "application/x-www-form-urlencoded"},
                        body: "email=" + encodeURIComponent(input.value)
                    })
                    .then(res => res.text())
                    .then(data => {
                        if (data === "taken") { showError(input, "Email already registered."); }
                        else { showSuccess(input); }
                    });
                } else { showError(input, "Enter a valid email."); }
            }
            else if (input.id === "password") {
                checkPasswordStrength(input.value);
                input.value.length >= 8 ? showSuccess(input) : showError(input, "Password too short.");
                const confirm = form.querySelector("#confirm_password");
                if (confirm.value !== "") { confirm.value === input.value ? showSuccess(confirm) : showError(confirm, "Passwords do not match."); }
            }
            else if (input.id === "confirm_password") {
                const password = form.querySelector("#password");
                input.value === password.value ? showSuccess(input) : showError(input, "Passwords do not match.");
            }
            else { input.value.trim() !== "" ? showSuccess(input) : showError(input, "This field is required."); }
        });
    });

    form.addEventListener("submit", e => {
        let allValid = true;
        fields.forEach(input => {
            if (!input.classList.contains("valid")) { showError(input, "This field is required or invalid."); allValid = false; }
        });
        if (!allValid) e.preventDefault();
    });
});
</script>
</body>
</html>
