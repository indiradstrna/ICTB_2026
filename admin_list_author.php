<?php
session_start();
require_once 'includes/db.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Fetch authors
$query = "SELECT p.*, a.apptype_id, a.abstract as abstract_file 
          FROM participants p 
          LEFT JOIN applications a ON p.id = a.participant_id 
          WHERE p.participant_type = 'author' 
          ORDER BY p.id DESC";
$result = $conn->query($query);

include 'includes/header.php';
?>

<style>
    .admin-container {
        padding: 120px 20px 50px;
        min-height: 80vh;
        background-color: #f8f9fa;
    }
    .admin-header {
        margin-bottom: 30px;
    }
    .admin-title {
        font-family: 'Oswald', sans-serif;
        font-size: 28px;
        color: #333;
        text-transform: uppercase;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
    }
    .admin-table th, .admin-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }
    .admin-table th {
        background-color: #f1f3f5;
        color: #495057;
        font-weight: 600;
    }
    .admin-table tbody tr:nth-of-type(even) {
        background-color: #f8f9fa;
    }
    .admin-table tbody tr:hover {
        background-color: #e9ecef;
    }
    .link-action {
        color: #00b894;
        text-decoration: none;
        font-weight: 500;
    }
    .link-action:hover {
        text-decoration: underline;
    }
</style>

<div class="admin-container">
    <div class="container" style="max-width: 1200px;">
        <div class="admin-header">
            <h2 class="admin-title">List of Author</h2>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Registration ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Country</th>
                        <th>Student</th>
                        <th>Allergies</th>
                        <th>Attendance</th>
                        <th>Payment</th>
                        <th>Abstract</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <?php 
                                $reg_id = "5ICTB-AUT-" . str_pad($row['id'], 4, "0", STR_PAD_LEFT);
                                $name = htmlspecialchars(trim(($row['first_name']??'') . ' ' . ($row['last_name']??'')));
                                $is_student = !empty($row['bukti_diri']) ? 'Yes' : 'No';
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $reg_id; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['institution'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['country'] ?? ''); ?></td>
                                <td><?php echo $is_student; ?></td>
                                <td><?php echo htmlspecialchars($row['allergies'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['attendance'] ?? ''); ?></td>
                                <td>
                                    <?php if (!empty($row['bukti_transfer'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['bukti_transfer']); ?>" target="_blank" class="link-action">View Proof</a>
                                    <?php else: ?>
                                        <?php if (isset($_SESSION['is_superadmin']) && $_SESSION['is_superadmin']): ?>
                                            <?php 
                                                $wa_num = preg_replace('/[^0-9]/', '', $row['phone'] ?? ''); 
                                                if (strpos($wa_num, '0') === 0) {
                                                    $wa_num = '62' . substr($wa_num, 1);
                                                }
                                                $wa_text = urlencode("Halo {$name}, mohon segera mengunggah bukti transfer Anda untuk pendaftaran ICTB.");
                                            ?>
                                            <a href="https://wa.me/<?php echo $wa_num; ?>?text=<?php echo $wa_text; ?>" target="_blank" class="link-action" style="color: #0984e3; display: inline-block; padding: 2px 6px; border: 1px solid #0984e3; border-radius: 4px; font-size: 11px;">Remind WA</a>
                                        <?php else: ?>
                                            <span style="color: #999;">-</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['abstract_file'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['abstract_file']); ?>" target="_blank" class="link-action" download><?php echo htmlspecialchars($row['apptype_id'] ?? 'Download'); ?></a>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 20px;">No authors found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
