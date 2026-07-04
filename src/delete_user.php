<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$conn = new mysqli("localhost","root","","demo_security");

$id = $_GET['id'];

// ❗ SQL Injection
$conn->query("DELETE FROM users WHERE id=$id");

header("Location: admin.php");