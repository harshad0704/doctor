<?php
session_start();
include "db.php";

// 🔒 Protect doctor
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Handle approve / reject
if (isset($_GET['action'], $_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE appointments SET status='Approved' WHERE id='$id'");
    }

    if ($action == 'reject') {
        mysqli_query($conn, "UPDATE appointments SET status='Rejected' WHERE id='$id'");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">My Appointments</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $query = "
            SELECT a.*, p.name AS patient_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            WHERE a.doctor_id = '$doctor_id'
            ORDER BY a.appointment_date
        ";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $row['patient_name'] ?></td>
                <td><?= $row['appointment_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <a href="?action=approve&id=<?= $row['id'] ?>"
                           class="btn btn-success btn-sm">Approve</a>

                        <a href="?action=reject&id=<?= $row['id'] ?>"
                           class="btn btn-danger btn-sm">Reject</a>
                    <?php } else { ?>
                        <span class="text-muted">No action</span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <a href="doctor_dashboard.php" class="btn btn-secondary">
        ← Back to Dashboard
    </a>

</div>

</body>
</html>
