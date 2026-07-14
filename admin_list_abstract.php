<?php
session_start();
require_once 'includes/db.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Fetch applications (abstracts)
$query = "SELECT a.*, p.first_name, p.last_name, p.email, p.participant_type 
          FROM applications a 
          JOIN participants p ON a.participant_id = p.id 
          ORDER BY a.id DESC";
$result = $conn->query($query);

include 'includes/header.php';
?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

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
            <h2 class="admin-title">List of Abstract</h2>
        </div>
        
        <div style="overflow-x: auto; padding-bottom: 20px;">
            <table class="admin-table display" id="abstractTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Registration ID</th>
                        <th>Title</th>
                        <th>Abstract</th>
                        <th>App Type</th>
                        <th>Theme</th>
                        <th>Subtheme</th>
                        <th>Publication</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <?php 
                                // Determine Registration ID based on participant ID and type
                                $reg_id = "5ICTB-AUT-" . str_pad($row['participant_id'], 4, "0", STR_PAD_LEFT);
                                // The conference theme is generally fixed for this edition
                                $theme = "Biodiversity Beyond Boundaries: Advancing Global Education, Bio-Science, and Sustainable Landscapes";
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td style="white-space: nowrap;"><?php echo $reg_id; ?></td>
                                <td style="max-width: 250px; white-space: normal; line-height: 1.4;"><?php echo htmlspecialchars($row['title'] ?? ''); ?></td>
                                <td>
                                    <?php if (!empty($row['abstract'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['abstract']); ?>" target="_blank" class="link-action" style="font-weight: bold;" download>Abstract</a>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['apptype_id'] ?? ''); ?></td>
                                <td style="max-width: 200px; white-space: normal; line-height: 1.4;"><?php echo htmlspecialchars($theme); ?></td>
                                <td style="max-width: 200px; white-space: normal; line-height: 1.4;"><?php echo htmlspecialchars($row['subtheme_id'] ?? ''); ?></td>
                                <td style="max-width: 200px; white-space: normal; line-height: 1.4;"><?php echo htmlspecialchars($row['publication_id'] ?? ''); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 20px;">No abstracts found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#abstractTable').DataTable({
        "pageLength": 25,
        "order": [] // disable initial sort to keep DESC order from query
    });
});
</script>

<?php include 'includes/footer.php'; ?>
