<?php
include 'header.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "demo_security");
$msg = "";

// Key phải là 32 ký tự cho AES-256
$secret_key = "12345678901234567890123456789012"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_name = $_POST['customer_name'];
    $card_num = $_POST['card_number'];
    $user_id = $_SESSION['user_id'];

    // --- QUY TRÌNH MÃ HÓA AES-256-CBC ---
    // 1. Tạo Vector khởi tạo (IV) ngẫu nhiên
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($iv_length);

    // 2. Thực hiện mã hóa
    $encrypted_data = openssl_encrypt($card_num, 'aes-256-cbc', $secret_key, 0, $iv);

    // 3. Mã hóa IV sang base64 để lưu vào Database an toàn
    $iv_base64 = base64_encode($iv);

    // 4. Lưu vào bảng payments
    $stmt = $conn->prepare("INSERT INTO payments (user_id, customer_name, card_number_encrypted, iv) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $cust_name, $encrypted_data, $iv_base64);
    
    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Thanh toán thành công! Dữ liệu thẻ đã được mã hóa AES-256.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Lỗi hệ thống!</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">💳 Thanh toán an toàn (AES-256-CBC)</h5>
            </div>
            <div class="card-body">
                <p>Chào mừng <strong><?= $_SESSION['username'] ?></strong>, vui lòng nhập thông tin thẻ:</p>
                <?php echo $msg; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên chủ thẻ</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số thẻ tín dụng</label>
                        <input type="text" name="card_number" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📋 Lịch sử thẻ đã lưu (Đã giải mã từ DB)</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Chủ thẻ</th>
                            <th>Dữ liệu trong DB (Mã hóa)</th>
                            <th>Dữ liệu giải mã</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $res = $conn->query("SELECT * FROM payments WHERE user_id = $user_id");
                        while ($row = $res->fetch_assoc()) {
                            // QUY TRÌNH GIẢI MÃ
                            $iv_dec = base64_decode($row['iv']);
                            $decrypted_card = openssl_decrypt($row['card_number_encrypted'], 'aes-256-cbc', $secret_key, 0, $iv_dec);
                            
                            echo "<tr>
                                    <td>{$row['customer_name']}</td>
                                    <td><small class='text-muted'>" . substr($row['card_number_encrypted'], 0, 15) . "...</small></td>
                                    <td class='fw-bold text-success'>$decrypted_card</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>