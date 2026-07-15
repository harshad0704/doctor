<?php
session_start();
include "db.php";

// Protect Doctor
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

if (!isset($_GET['patient_id'])) {
    die("Patient not found.");
}

$patient_id = $_GET['patient_id'];

$msg = "";

if(isset($_POST['save']))
{
    $diagnosis = mysqli_real_escape_string($conn,$_POST['diagnosis']);
    $prescription = mysqli_real_escape_string($conn,$_POST['prescription']);
    $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);

    $sql = "
    INSERT INTO medical_records
    (
        patient_id,
        doctor_id,
        diagnosis,
        prescription,
        remarks
    )
    VALUES
    (
        '$patient_id',
        '$doctor_id',
        '$diagnosis',
        '$prescription',
        '$remarks'
    )";

    if(mysqli_query($conn,$sql))
    {
        header("Location: doctor_appointment.php?success=1");
        exit();
    }
    else
    {
        $msg = mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Add Medical Record</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Add Medical Record</h3>

</div>

<div class="card-body">

<?php
if($msg!="")
{
?>
<div class="alert alert-danger">
<?= $msg ?>
</div>
<?php
}
?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Diagnosis</label>

<textarea
name="diagnosis"
class="form-control"
rows="4"
required></textarea>

</div>

<div class="mb-3">

<label class="form-label">Prescription</label>

<textarea
name="prescription"
class="form-control"
rows="4"
required></textarea>

</div>

<div class="mb-3">

<label class="form-label">Remarks</label>

<textarea
name="remarks"
class="form-control"
rows="3"></textarea>

</div>

<button
type="submit"
name="save"
class="btn btn-success">

Save Medical Record

</button>

<a
href="doctor_appointment.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>