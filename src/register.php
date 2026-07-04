<?php
include 'header.php';

$conn = new mysqli("localhost", "root", "", "demo_security");
$msg = "";

if ($_POST) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $type = $_POST['type'];

    $final = ($type == "md5") ? md5($pass) : password_hash($pass, PASSWORD_BCRYPT);

    // ❗ SQL Injection
    $conn->query("INSERT INTO users (username,password_hash,hash_type,role)
                  VALUES ('$user','$final','$type','user')");

    $msg = "<div class='alert alert-success'>Đăng ký OK</div>";
}
?>

<h3>Register</h3>
<?php echo $msg; ?>

<form method="POST">
<input name="username" class="form-control mb-2" placeholder="Tài khoản">
<input name="password" type="password" class="form-control mb-2" placeholder="Mật khẩu">
<select name="type" class="form-select mb-2">
<option value="md5">MD5</option>
<option value="bcrypt">Bcrypt</option>
</select>
<button class="btn btn-primary">Register</button>
</form>

<?php include 'footer.php'; ?>