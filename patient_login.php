<?php
include "db.php";

// Initialize error message
//$error = "not found at ... times";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Fetch user from database
        $sql = "SELECT * FROM patients WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login success
                session_start();
                $_SESSION['patient_id'] = $user['id'];
                $_SESSION['patient_name'] = $user['name'];
                header("Location: patient_dashboard.php");
               $erroor="successfully logged in";
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Email not found";
        }
    } else {
        $error = "Please enter email and password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <form method="POST" action="patient_login.php" class="card p-4 shadow" style="max-width:400px; width:100%;">
        <h3 class="text-center mb-4">Patient Login</h3>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="text-center mt-3">
            Not registered? <a href="patient_register.php">Register</a>
        </p>
    </form>
</div>
</body>
</html>
