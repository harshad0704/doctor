<?php
session_start();
include "db.php";

// Protect doctor
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Handle Actions
if(isset($_GET['action']) && isset($_GET['id']))
{
    $id=$_GET['id'];
    $action=$_GET['action'];

    if($action=="approve")
    {
        mysqli_query($conn,"
        UPDATE appointments
        SET status='Approved'
        WHERE id='$id'
        ");
    }

    elseif($action=="reject")
    {
        mysqli_query($conn,"
        UPDATE appointments
        SET status='Rejected'
        WHERE id='$id'
        ");
    }

    elseif($action=="complete")
    {
        mysqli_query($conn,"
        UPDATE appointments
        SET status='Completed'
        WHERE id='$id'
        ");
    }

    header("Location: doctor_appointment.php");
    exit();
}

$query="

SELECT

a.*,

p.name AS patient_name,

da.start_time,

da.end_time

FROM appointments a

JOIN patients p
ON a.patient_id=p.id

LEFT JOIN doctor_availability da
ON a.slot_id=da.id

WHERE a.doctor_id='$doctor_id'

ORDER BY
a.appointment_date,
da.start_time

";

$result=mysqli_query($conn,$query);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Doctor Appointments</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>My Appointments</h3>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Patient</th>

<th>Date</th>

<th>Time Slot</th>

<th>Status</th>


</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?= $row['patient_name'] ?>

</td>

<td>

<?= $row['appointment_date'] ?>

</td>

<td>

<?php

if($row['start_time'])
{

echo date("h:i A",strtotime($row['start_time']));

echo " - ";

echo date("h:i A",strtotime($row['end_time']));

}
else
{

echo "-";

}

?>

</td>

<td>

<?php

if($row['status']=="Pending")
{
    echo "<span class='badge bg-warning text-dark'>Pending</span>";
}
elseif($row['status']=="Approved")
{
    echo "<span class='badge bg-success'>Approved</span>";
}
elseif($row['status']=="Rejected")
{
    echo "<span class='badge bg-danger'>Rejected</span>";
}
elseif($row['status']=="Completed")
{
    echo "<span class='badge bg-primary'>Completed</span>";
}

?>

</td>

<td>

<?php

if($row['status']=="Pending")
{

?>

<a
href="?action=approve&id=<?= $row['id'] ?>"
class="btn btn-success btn-sm">

Approve

</a>

<a
href="?action=reject&id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm">

Reject

</a>

<?php

}
elseif($row['status']=="Approved")
{

?>


<?php

}
else
{

if($row['status']=="Completed")
{
?>




<?php
}
else
{
    echo "<span class='text-muted'>No Action</span>";
}

}

?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<a
href="doctor_dashboard.php"
class="btn btn-secondary">

← Back to Dashboard

</a>

</div>

</div>

</div>

</body>

</html>