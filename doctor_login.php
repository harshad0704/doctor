<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'], $_POST['password'])) {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $query = "SELECT * FROM doctors WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $doctor = mysqli_fetch_assoc($result);

        if ($doctor && password_verify($password, $doctor['password'])) {
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['name'];

           header("Location: doctor_dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Please fill all fields";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="all.css">
</head>
<body>

<!-- Background Image -->
<div class="full-img-page">
    <img src="images/sg.jpg" alt="Background">
</div>

<!-- Login Form -->
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">

    <form method="POST" action="doctor_login.php"
          class="card p-4 shadow"
          style="max-width:420px; width:100%;">

        <h3 class="text-center mb-4">Doctor Login</h3>

        <!-- Error Message -->
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php } ?>

        <input type="email"
               name="email"
               class="form-control mb-3"
               placeholder="Email"
               required>

        <input type="password"
               name="password"
               class="form-control mb-3"
               placeholder="Password"
               required>

        <button type="submit" class="btn btn-warning w-100">
            Login
        </button>

        <p class="text-center mt-3">
            New doctor? <a href="doctor_register.php">Register</a>
        </p>

    </form>
</div>

</body>
</html>
