<?php

session_start();
include "db.php";

if(!isset($_SESSION['admin_id']))
{
    header("Location: admin_login.php");
    exit();
}

$doctor = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM doctors"));

$patient = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM patients"));

$appointment = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointments"));

$pending = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointments WHERE status='Pending'"));

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

<div class="container-fluid">

<span class="navbar-brand">
Admin Dashboard
</span>

<a href="logout.php" class="btn btn-danger">
Logout
</a>

</div>

</nav>

<div class="container mt-5">

<h3 class="mb-4">
Welcome,
<?= $_SESSION['admin_name']; ?>
</h3>

<div class="row">

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Doctors</h5>

<h2><?= $doctor ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Patients</h5>

<h2><?= $patient ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Appointments</h5>

<h2><?= $appointment ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Pending</h5>

<h2><?= $pending ?></h2>

</div>

</div>

</div>

</div>

<hr>

<div class="row mt-4">

<div class="col-md-4">

<a href="manage_doctors.php" class="btn btn-primary w-100 p-3">
Manage Doctors
</a>

</div>

<div class="col-md-4">

<a href="manage_patients.php" class="btn btn-success w-100 p-3">
Manage Patients
</a>

</div>

<div class="col-md-4">

<a href="manage_appointments.php" class="btn btn-warning w-100 p-3">
Manage Appointments
</a>

</div>

</div>

</div>

</body>

</html>