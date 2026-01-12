<?php
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ CHECK IF EMAIL ALREADY EXISTS
    $check = "SELECT * FROM patients WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already registered. Please login.";
    } else {

        // ✅ INSERT ONLY IF EMAIL IS NEW
        $sql = "INSERT INTO patients (name, email, password)
                VALUES ('$name', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            header("Location: patient_login.php");
            exit();
        } else {
            $error = "Registration Failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Register</title>
    <link rel="stylesheet" href="all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="full-img-page">
    <img src="images/pg.jpeg" alt="Background">
</div>

<div class="container mt-5">
    <h3 class="text-center mb-4">Patient Registration</h3>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <form method="POST" action="patient_register.php" class="card p-4">

        <input type="text" class="form-control mb-3"
               name="name" placeholder="Full Name" required>

        <input type="email" class="form-control mb-3"
               name="email" placeholder="Email" required>

        <input type="password" class="form-control mb-3"
               name="password" placeholder="Password" required>

        <button type="submit" class="btn btn-primary w-100">
            Register
        </button>

        <p class="text-center mt-3">
            Already registered? <a href="patient_login.php">Login</a>
        </p>
    </form>
</div>

</body>
</html>

