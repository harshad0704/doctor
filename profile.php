<?php
session_start();
include "db.php";

// 🔒 Protect patient
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
$msg = "";

// Fetch patient details
$result = mysqli_query($conn, "SELECT * FROM patients WHERE id='$patient_id'");
$patient = mysqli_fetch_assoc($result);

// Handle form submission (update profile)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Update password only if provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE patients SET name='$name', email='$email', password='$password' WHERE id='$patient_id'";
    } else {
        $sql = "UPDATE patients SET name='$name', email='$email' WHERE id='$patient_id'";
    }

    if (mysqli_query($conn, $sql)) {
        $msg = "Profile updated successfully!";
        $_SESSION['patient_name'] = $name; // update session name
    } else {
        $msg = "Error updating profile: " . mysqli_error($conn);
    }
}

// Refresh patient details
$result = mysqli_query($conn, "SELECT * FROM patients WHERE id='$patient_id'");
$patient = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">My Profile</h3>

    <?php if ($msg) { ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php } ?>

    <div class="card p-4 shadow" style="max-width:500px;">
        <form method="POST">

            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control mb-3" value="<?= $patient['name'] ?>" required>

            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control mb-3" value="<?= $patient['email'] ?>" required>

            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control mb-3">

            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>
    </div>

    <a href="patient_dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>
</div>

</body>
</html>
