<?php
session_start();
require_once 'includes/db.php';
include 'includes/header.php';
?>

<style>
.forgot-wrap{display:flex;justify-content:center;align-items:center;padding:160px 20px 100px;min-height:calc(100vh - 300px);}
.forgot-card{background:#fff;width:100%;max-width:520px;border:1px solid #e2e8f0;border-radius:6px;box-shadow:0 4px 20px rgba(0,0,0,.06);}
.forgot-card-header{padding:15px 24px;border-bottom:1px solid #e2e8f0;background:#f8f9fa;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;color:#475569;}
.forgot-card-body{padding:32px 36px;}
.forgot-card-body p{font-size:14px;color:#64748b;margin-bottom:16px;line-height:1.8;}
.contact-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:5px;padding:16px 20px;margin:20px 0;}
.contact-box a{color:#15803d;font-weight:600;text-decoration:none;}
.contact-box a:hover{text-decoration:underline;}
.note{font-size:13px;color:#94a3b8;margin-top:8px;line-height:1.7;}
.back-link{display:inline-block;margin-top:10px;font-size:13px;color:var(--primary-color,#0d9488);text-decoration:none;}
.back-link:hover{text-decoration:underline;}
</style>

<div class="forgot-wrap">
    <div class="forgot-card">
        <div class="forgot-card-header">Forgot Password</div>
        <div class="forgot-card-body">

            <p>
                If you have forgotten your password, please contact the ICTB 2026 Secretariat directly.
                We will verify your registration and get back to you as soon as possible.
            </p>

            <div class="contact-box">
                📧 <strong>ICTB 2026 Secretariat</strong><br>
                <a href="mailto:ictb@biotrop.org">ictb@biotrop.org</a>
            </div>

            <p class="note">
                Further instructions on how to reset your password will be sent to your registered email address
                after you have contacted the secretariat.
            </p>

            <a href="login.php" class="back-link">&larr; Back to Login</a>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
