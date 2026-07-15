<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admins WHERE username='$username'");

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);
if($password == $admin['password']){

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];

            header("Location: admin_dashboard.php");
            exit();

        }else{
            $error = "Invalid Password";
        }

    }else{
        $error = "Invalid Username";
    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

<div class="card shadow p-4" style="width:400px;">

<h3 class="text-center mb-4">Admin Login</h3>

<?php
if($error!=""){
?>
<div class="alert alert-danger">
<?= $error ?>
</div>
<?php
}
?>

<form method="POST">

<input
type="text"
name="username"
class="form-control mb-3"
placeholder="Username"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button class="btn btn-primary w-100">
Login
</button>

</form>

</div>

</div>

</body>
</html>