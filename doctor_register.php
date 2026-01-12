
<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['specialization'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $spec = mysqli_real_escape_string($conn, $_POST['specialization']);

        $sql = "INSERT INTO doctors (name, email, password, specialization)
                VALUES ('$name', '$email', '$password', '$spec')";

        if (mysqli_query($conn, $sql)) {
            header("Location: doctor_login.php");
            exit;
        } else {
            $error = "Registration Failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="all.css">
</head>
<body>

<!-- FULL PAGE BACKGROUND IMAGE -->
<div class="full-img-page">
    <img src="images/sg.jpeg" alt="Background">
</div>

<!-- FORM CONTENT -->
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <form method="POST" action="doctor_register.php" class="card p-4 shadow" style="max-width:450px; width:100%;">
        <h3 class="text-center mb-4">Doctor Registration</h3>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <input type="text" name="name" class="form-control mb-3" placeholder="Doctor Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <input type="text" name="specialization" class="form-control mb-3" placeholder="Specialization" required>

        <button type="submit" class="btn btn-primary w-100">Register</button>

        <p class="text-center mt-3">
            Already registered? <a href="doctor_login.php">Login</a>
        </p>
    </form>
</div>

</body>
</html>

