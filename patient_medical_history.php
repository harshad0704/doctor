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
    <title>My Medical History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">My Medical History</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Doctor</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $query = "
            SELECT m.*, d.name AS doctor_name
            FROM medical_records m
            JOIN doctors d ON m.doctor_id = d.id
            WHERE m.patient_id = '$patient_id'
            ORDER BY m.record_date DESC
        ";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='4' class='text-center'>No medical records found</td></tr>";
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['record_date']}</td>
                    <td>Dr. {$row['doctor_name']}</td>
                    <td>{$row['diagnosis']}</td>
                    <td>{$row['prescription']}</td>
                  </tr>";
        }
        ?>

        </tbody>
    </table>

    <a href="patient_dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>

</div>

</body>
</html>
