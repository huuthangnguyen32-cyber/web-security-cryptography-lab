<?php
include 'header.php';

$conn = new mysqli("localhost", "root", "", "demo_security");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // ❗ SQL Injection
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        $is_valid = false;
        if ($userData['hash_type'] == 'md5') {
            if (md5($pass) === $userData['password_hash']) $is_valid = true;
        } else {
            if (password_verify($pass, $userData['password_hash'])) $is_valid = true;
        }

        if ($is_valid) {
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['username'] = $userData['username'];
            $_SESSION['role'] = $userData['role'];

            if ($userData['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: payment.php");
            }
        } else {
            $msg = "<div class='alert alert-danger'>Sai mật khẩu!</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Không tồn tại!</div>";
    }
}
?>

<div class="row justify-content-center">
<div class="col-md-5">
<div class="card shadow">
<div class="card-body">

<h3 class="text-center text-danger">Login</h3>
<?php echo $msg; ?>

<form method="POST">
<input name="username" class="form-control mb-3" placeholder="Username">
<input name="password" type="password" class="form-control mb-3" placeholder="Password">
<button class="btn btn-danger w-100">Login</button>
</form>

</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>