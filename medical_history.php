<?php
session_start();
include "db.php";

// Protect Patient
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];

$query = "
SELECT
    mr.*,
    d.name AS doctor_name,
    d.specialization,
    a.appointment_date

FROM medical_records mr

JOIN doctors d
ON mr.doctor_id = d.id

LEFT JOIN appointments a
ON mr.appointment_id = a.id

WHERE mr.patient_id = '$patient_id'

ORDER BY mr.record_date DESC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Medical History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>My Medical History</h3>

</div>

<div class="card-body">

<?php
if(mysqli_num_rows($result)==0)
{
?>

<div class="alert alert-info">

No Medical Records Found.

</div>

<?php
}
else
{
?>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Appointment Date</th>

<th>Doctor</th>

<th>Specialization</th>

<th>Diagnosis</th>

<th>Prescription</th>

<th>Remarks</th>

<th>Record Date</th>

</tr>

</thead>

<tbody>

<?php

$count = 1;

while($row = mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $count++; ?></td>

<td>

<?php

if($row['appointment_date'])
{
    echo date("d-m-Y", strtotime($row['appointment_date']));
}
else
{
    echo "-";
}

?>

</td>

<td>

Dr. <?= htmlspecialchars($row['doctor_name']) ?>

</td>

<td>

<?= htmlspecialchars($row['specialization']) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row['diagnosis'])) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row['prescription'])) ?>

</td>

<td>

<?= nl2br(htmlspecialchars($row['remarks'])) ?>

</td>

<td>

<?= date("d-m-Y h:i A", strtotime($row['record_date'])) ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<?php
}
?>

<a href="patient_dashboard.php" class="btn btn-secondary">

← Back to Dashboard

</a>

</div>

</div>

</div>

</body>

</html>