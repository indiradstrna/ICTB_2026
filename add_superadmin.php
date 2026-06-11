<?php
require_once 'includes/db.php';

$sql = "SHOW COLUMNS FROM participants LIKE 'is_superadmin'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE participants ADD is_superadmin TINYINT(1) DEFAULT 0");
    echo "Column is_superadmin added.\n";
} else {
    echo "Column is_superadmin already exists.\n";
}

// Update the default admin to be superadmin
$conn->query("UPDATE participants SET is_superadmin = 1 WHERE email = 'admin@ictb.org'");
echo "Superadmin role granted to admin@ictb.org.\n";
?>
