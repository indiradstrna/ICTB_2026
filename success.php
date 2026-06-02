<?php
session_start();
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
        <a href="index.php" style="background: #1a73e8; color: #fff; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 4px;">Return to Homepage</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
