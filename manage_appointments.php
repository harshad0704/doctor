<?php

session_start();

include "db.php";

if(!isset($_SESSION['admin_id']))
{
    header("Location: admin_login.php");
    exit;
}

$query="

SELECT
a.*,
p.name AS patient_name,
d.name AS doctor_name

FROM appointments a

JOIN patients p
ON a.patient_id=p.id

JOIN doctors d
ON a.doctor_id=d.id

ORDER BY appointment_date DESC

";

$result=mysqli_query($conn,$query);

?>

<!DOCTYPE html>

<html>

<head>

<title>Manage Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>Manage Appointments</h3>

<a href="admin_dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>Patient</th>

<th>Doctor</th>

<th>Date</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $row['patient_name'] ?></td>

<td><?= $row['doctor_name'] ?></td>

<td><?= $row['appointment_date'] ?></td>

<td>

<?php

if($row['status']=="Approved")
{

echo "<span class='badge bg-success'>Approved</span>";

}
elseif($row['status']=="Rejected")
{

echo "<span class='badge bg-danger'>Rejected</span>";

}
else
{

echo "<span class='badge bg-warning text-dark'>Pending</span>";

}

?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</body>

</html>