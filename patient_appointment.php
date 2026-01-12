<?php
session_start();
include "db.php";

// 🔒 Protect patient
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">My Appointments</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $query = "
            SELECT a.appointment_date, a.status,
                   d.name AS doctor_name, d.specialization
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.id
            WHERE a.patient_id = '$patient_id'
            ORDER BY a.appointment_date DESC
        ";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='4' class='text-center'>No appointments found</td></tr>";
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $row['doctor_name'] ?></td>
                <td><?= $row['specialization'] ?></td>
                <td><?= $row['appointment_date'] ?></td>
                <td>
                    <?php
                    if ($row['status'] == 'Approved') {
                        echo "<span class='badge bg-success'>Approved</span>";
                    } elseif ($row['status'] == 'Rejected') {
                        echo "<span class='badge bg-danger'>Rejected</span>";
                    } else {
                        echo "<span class='badge bg-warning text-dark'>Pending</span>";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <a href="patient_dashboard.php" class="btn btn-secondary">
        ← Back to Dashboard
    </a>

</div>

</body>
</html>
