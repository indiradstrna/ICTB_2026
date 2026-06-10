<?php
require_once 'includes/db.php';

// Menambah kolom is_admin jika belum ada
$sql = "SHOW COLUMNS FROM participants LIKE 'is_admin'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE participants ADD is_admin TINYINT(1) DEFAULT 0");
    echo "Kolom is_admin berhasil ditambahkan.<br>";
} else {
    echo "Kolom is_admin sudah ada.<br>";
}

// Buat akun admin default
$admin_email = 'admin@ictb.org';
$admin_password = password_hash('admin', PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM participants WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE participants SET is_admin = 1, password_hash = ? WHERE email = ?");
    $stmt->bind_param("ss", $admin_password, $admin_email);
    $stmt->execute();
    echo "Akun admin berhasil diupdate.<br>";
} else {
    $stmt = $conn->prepare("INSERT INTO participants (participant_type, first_name, last_name, institution, email, phone, password_hash, is_admin) VALUES ('admin', 'System', 'Admin', 'ICTB', ?, '00000', ?, 1)");
    $stmt->bind_param("ss", $admin_email, $admin_password);
    $stmt->execute();
    echo "Akun admin baru berhasil dibuat.<br>";
}

echo "<br><b>Selesai! Database hosting sudah siap. Silakan hapus file update_db.php ini dari hostingan Anda demi keamanan.</b>";
?>
