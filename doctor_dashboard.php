<?php
session_start();

// 🔒 Protect dashboard
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Doctor Dashboard</span>
        <!-- ✅ Proper logout -->
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- ✅ Doctor name from session -->
    <h3 class="mb-4">Welcome, Dr. <?php echo $_SESSION['doctor_name']; ?> 👨‍⚕️</h3>

    <div class="row g-4">

        <!-- View Appointments -->
        <div class="col-md-4">
            <div class="card shadow text-center p-3">
                <h5>Appointments</h5>
                <p class="text-muted">View patient requests</p>
                <!-- future page -->
                <a href="doctor_appointment.php" class="btn btn-primary">View</a>
            </div>
        </div>

        <!-- Manage Availability -->
        <div class="col-md-4">
            <div class="card shadow text-center p-3">
                <h5>Availability</h5>
                <p class="text-muted">Set available timings</p>
                <a href="doctor_availability.php" class="btn btn-success">Manage</a>
            </div>
        </div>
        

    </div>
</div>

</body>
</html>
