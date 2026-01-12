<?php
session_start();
include "db.php";

// 🔒 Protect page
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}

$msg = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $patient_id = $_SESSION['patient_id'];

    // Check if doctor is available at that date and time
    $avail_check = mysqli_query($conn, "
        SELECT * FROM doctor_availability 
        WHERE doctor_id='$doctor_id' 
          AND available_date='$date'
          AND start_time <= '$time' 
          AND end_time >= '$time'
    ");

    if (mysqli_num_rows($avail_check) > 0) {
        // Insert appointment
        $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date)
                VALUES ('$patient_id', '$doctor_id', '$date')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Appointment booked successfully!";
        } else {
            $msg = "Error booking appointment.";
        }
    } else {
        $msg = "Selected time is not available for this doctor.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card p-4 shadow">
        <h3 class="mb-3">Book Appointment</h3>

        <?php if ($msg) { ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php } ?>

        <form method="POST">

            <!-- Doctor List -->
            <label class="form-label">Select Doctor</label>
            <select name="doctor_id" class="form-control mb-3" required>
                <option value="">-- Choose Doctor --</option>
                <?php
                $doctors = mysqli_query($conn, "SELECT id, name, specialization FROM doctors");
                while ($doc = mysqli_fetch_assoc($doctors)) {
                    echo "<option value='{$doc['id']}'>
                            Dr. {$doc['name']} ({$doc['specialization']})
                          </option>";
                }
                ?>
            </select>

            <!-- Date -->
            <label class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control mb-3" required>

            <!-- Time -->
            <label class="form-label">Appointment Time</label>
            <input type="time" name="appointment_time" class="form-control mb-3" required>

            <button type="submit" class="btn btn-success w-100">
                Book Appointment
            </button>
        </form>

        <a href="patient_dashboard.php" class="btn btn-link mt-3">
            ← Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>
