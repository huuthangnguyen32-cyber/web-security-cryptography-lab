<?php
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","demo_security");
$result = $conn->query("SELECT * FROM users");
?>

<h3>ADMIN PANEL</h3>

<table class="table table-bordered">
<tr>
<th>ID</th><th>User</th><th>Hash</th><th>Role</th><th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['username'] ?></td>
<td><?= $row['password_hash'] ?></td>
<td><?= $row['role'] ?></td>
<td>
<?php if($row['role']!='admin'): ?>
<a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>

</table>

<?php include 'footer.php'; ?>