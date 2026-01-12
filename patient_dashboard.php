<?php
session_start();

// 🔒 Protect dashboard
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <span class="navbar-brand">Patient Dashboard</span>
        <!-- ✅ Proper logout -->
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- ✅ Patient name from session -->
    <h3 class="mb-4">Welcome, <?php echo $_SESSION['patient_name']; ?> 👋</h3>

    <!-- Cards -->
    <div class="row g-4">

        <!-- Book Appointment -->
        <div class="col-md-4">
            <div class="card shadow text-center p-3">
                <h5>Book Appointment</h5>
                <p class="text-muted">Schedule a visit with doctor</p>
                <!-- future page -->
                <a href="book_appointment.php" class="btn btn-success">Book Now</a>
            </div>
        </div>

        <!-- View Appointments -->
        <div class="col-md-4">
            <div class="card shadow text-center p-3">
                <h5>My Appointments</h5>
                <p class="text-muted">View appointment status</p>
                <a href="patient_appointment.php" class="btn btn-primary">View</a>
            </div>
        </div>

        <!-- Medical History Card -->


        <!-- Profile -->
        <div class="col-md-4">
            <div class="card shadow text-center p-3">
                <h5>My Profile</h5>
                <p class="text-muted">View personal details</p>
                <a href="profile.php" class="btn btn-warning">Profile</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
