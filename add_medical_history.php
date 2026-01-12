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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $prescription = mysqli_real_escape_string($conn, $_POST['prescription']);

    $sql = "INSERT INTO medical_records (patient_id, doctor_id, diagnosis, prescription, record_date)
            VALUES ('$patient_id', '$doctor_id', '$diagnosis', '$prescription', NOW())";

    if (mysqli_query($conn, $sql)) {
        $msg = "Medical record added successfully!";
    } else {
        $msg = "Error adding medical record: " . mysqli_error($conn);
    }
}

// Fetch patients for this doctor (or all patients)
$patients = mysqli_query($conn, "SELECT * FROM patients ORDER BY name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medical Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h3 class="mb-4">Add Medical Record</h3>

    <?php if ($msg) { ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php } ?>

    <div class="card p-4 shadow">
        <form method="POST">

            <!-- Select Patient -->
            <label class="form-label">Select Patient</label>
            <select name="patient_id" class="form-control mb-3" required>
                <option value="">-- Choose Patient --</option>
                <?php
                while ($row = mysqli_fetch_assoc($patients)) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <!-- Diagnosis -->
            <label class="form-label">Diagnosis</label>
            <textarea name="diagnosis" class="form-control mb-3" rows="3" required></textarea>

            <!-- Prescription -->
            <label class="form-label">Prescription</label>
            <textarea name="prescription" class="form-control mb-3" rows="3" required></textarea>

            <button type="submit" class="btn btn-success w-100">Add Record</button>
        </form>
    </div>

    <a href="doctor_dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>

</div>

</body>
</html>
