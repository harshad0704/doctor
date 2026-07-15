<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Delete Doctor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM doctors WHERE id='$id'");

    header("Location: manage_doctors.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM doctors ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>Manage Doctors</h3>

<a href="admin_dashboard.php" class="btn btn-secondary mb-3">← Dashboard</a>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Specialization</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['name'] ?></td>

<td><?= $row['email'] ?></td>

<td><?= $row['specialization'] ?></td>

<td>

<a
href="?delete=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Doctor?')">

Delete

</a>

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