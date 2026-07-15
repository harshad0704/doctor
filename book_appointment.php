<?php
session_start();
include "db.php";

// Protect page
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
$msg = "";

// Book Appointment
if (isset($_POST['book'])) {

    $doctor_id = $_POST['doctor_id'];
    $slot_id = $_POST['slot_id'];

    // Check Slot
    $check = mysqli_query($conn,"
        SELECT *
        FROM doctor_availability
        WHERE id='$slot_id'
        AND doctor_id='$doctor_id'
        AND is_booked=0
    ");

    if(mysqli_num_rows($check)>0)
    {
        $slot=mysqli_fetch_assoc($check);

        $date=$slot['available_date'];

        $insert=mysqli_query($conn,"
        INSERT INTO appointments
        (patient_id,doctor_id,appointment_date,status,slot_id)
        VALUES
        ('$patient_id','$doctor_id','$date','Pending','$slot_id')
        ");

        if($insert)
        {
            mysqli_query($conn,"
            UPDATE doctor_availability
            SET is_booked=1
            WHERE id='$slot_id'
            ");

            $msg="Appointment Booked Successfully.";
        }
        else
        {
            $msg="Booking Failed.";
        }

    }
    else
    {
        $msg="Selected Slot is already booked.";
    }

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Book Appointment</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<script>

function loadSlots()
{

var doctor=document.getElementById("doctor").value;
var date=document.getElementById("date").value;

if(doctor=="" || date=="")
{
document.getElementById("slots").innerHTML=
"<option>Select Doctor & Date</option>";
return;
}

var xhr=new XMLHttpRequest();

xhr.onreadystatechange=function()
{

if(this.readyState==4 && this.status==200)
{
document.getElementById("slots").innerHTML=this.responseText;
}

};

xhr.open("GET",
"get_slots.php?doctor_id="+doctor+"&date="+date,
true);

xhr.send();

}

</script>

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Book Appointment</h3>

</div>

<div class="card-body">

<?php

if($msg!="")
{
?>

<div class="alert alert-info">

<?= $msg ?>

</div>

<?php
}
?>

<form method="POST">

<label class="form-label">

Select Doctor

</label>

<select
name="doctor_id"
id="doctor"
class="form-control mb-3"
onchange="loadSlots()"
required>

<option value="">Choose Doctor</option>

<?php

$doctor=mysqli_query($conn,"
SELECT *
FROM doctors
ORDER BY name
");

while($d=mysqli_fetch_assoc($doctor))
{
?>

<option value="<?= $d['id'] ?>">

Dr. <?= $d['name'] ?>

(<?= $d['specialization'] ?>)

</option>

<?php
}
?>

</select>

<label class="form-label">

Appointment Date

</label>

<input
type="date"
name="appointment_date"
id="date"
class="form-control mb-3"
onchange="loadSlots()"
required>

<label class="form-label">

Available Slots

</label>

<select
name="slot_id"
id="slots"
class="form-control mb-3"
required>

<option>

Select Doctor & Date

</option>

</select>
            <button
            type="submit"
            name="book"
            class="btn btn-success w-100">

            Book Appointment

            </button>

        </form>

        <a href="patient_dashboard.php"
        class="btn btn-secondary mt-3">

        ← Back to Dashboard

        </a>

    </div>

</div>

</div>

</body>

</html>