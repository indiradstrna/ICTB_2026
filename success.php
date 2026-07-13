<?php
session_start();
$is_author = false;
if (isset($_SESSION['participant_id'])) {
    require_once 'includes/db.php';
    $stmt = $conn->prepare("SELECT participant_type FROM participants WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['participant_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (strtolower($row['participant_type']) == 'author') {
            $is_author = true;
        }
    }
    $stmt->close();
}
session_destroy();
?>
<?php include 'includes/header.php'; ?>

<section class="section-padding bg-alt" style="min-height: 80vh; padding-top: 120px;">
    <div class="container" style="max-width: 800px; background: #fff; padding: 40px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="font-family: var(--font-subheading); color: #333; font-size: 28px; margin-bottom: 20px; font-weight: bold;">
            Registration Completed Successfully!
        </h2>
        <p style="font-size: 16px; color: #555; margin-bottom: 30px;">
            Thank you for registering. Your details and files have been successfully saved to our database.
            We will review your submission and contact you via email shortly.
        </p>

        <?php if ($is_author): ?>
        <div style="background: #e9f2ff; border-left: 4px solid #1a73e8; padding: 20px; text-align: left; margin-bottom: 30px; border-radius: 0 4px 4px 0;">
            <h4 style="margin-top: 0; color: #1a73e8; font-size: 18px; margin-bottom: 10px;">Note for Presenters</h4>
            <p style="font-size: 14px; margin-bottom: 0; color: #333;">
                If you haven't uploaded your presentation file (PPT/PPTX/PDF) yet, or if you need to update it, you can do so later at any time.<br><br>
                Simply click the <strong>Login</strong> menu on the homepage, enter your credentials, and you will be directed back to the Confirmation page where you can upload your presentation.
            </p>
        </div>
        <?php endif; ?>

        <a href="index.php" style="background: #1a73e8; color: #fff; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 4px;">Return to Homepage</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
