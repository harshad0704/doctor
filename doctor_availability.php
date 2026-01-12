<?php
session_start();
include "db.php";

// 🔒 Protect doctor
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$msg = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['available_date'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];

    $sql = "INSERT INTO doctor_availability (doctor_id, available_date, start_time, end_time)
            VALUES ('$doctor_id', '$date', '$start', '$end')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Availability added successfully!";
    } else {
        $msg = "Error adding availability";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">Manage Availability</h3>

    <?php if ($msg) { ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php } ?>

    <!-- Add Availability Form -->
    <div class="card p-4 shadow mb-4">
        <form method="POST">
            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="available_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Add Availability</button>
        </form>
    </div>

    <!-- List Existing Availability -->
    <div class="card p-4 shadow">
        <h5>My Availability</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $avail = mysqli_query($conn, "SELECT * FROM doctor_availability WHERE doctor_id='$doctor_id' ORDER BY available_date");
                while ($row = mysqli_fetch_assoc($avail)) {
                    echo "<tr>
                            <td>{$row['available_date']}</td>
                            <td>{$row['start_time']}</td>
                            <td>{$row['end_time']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <a href="doctor_dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>

</div>

</body>
</html>
