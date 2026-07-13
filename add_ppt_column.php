<?php
require_once 'includes/db.php';
$sql = "ALTER TABLE applications ADD COLUMN ppt_file VARCHAR(255) DEFAULT NULL";
if ($conn->query($sql) === TRUE) {
    echo "Column added successfully";
} else {
    echo "Error adding column: " . $conn->error;
}
?>
