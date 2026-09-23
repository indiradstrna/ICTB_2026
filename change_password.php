<?php
session_start();
require_once 'includes/db.php';

$error   = '';
$success = '';

// Determine if user is already logged in
$logged_in     = isset($_SESSION['participant_id']);
$participant   = null;

// Pre-fill email when coming from forgot_password redirect
$prefill_email = trim($_GET['email'] ?? '');

// ── POST HANDLER ────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_pass  = $_POST['current_password']  ?? '';
    $new_pass      = $_POST['new_password']       ?? '';
    $confirm_pass  = $_POST['confirm_password']   ?? '';
    $form_email    = trim($_POST['form_email']    ?? '');

    // Basic validation
    if (strlen($new_pass) < 8) {
        $error = 'New password must be at least 8 characters.';
    } elseif ($new_pass !== $confirm_pass) {
        $error = 'New password and confirmation do not match.';
    } else {

        // Identify the participant
        if ($logged_in) {
            $stmt = $conn->prepare('SELECT id, first_name, email, password_hash FROM participants WHERE id = ? LIMIT 1');
            $stmt->bind_param('i', $_SESSION['participant_id']);
        } else {
            if ($form_email === '') {
                $error = 'Please enter your registered email address.';
                goto render;
            }
            if (!filter_var($form_email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
                goto render;
            }
            $stmt = $conn->prepare('SELECT id, first_name, email, password_hash FROM participants WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $form_email);
        }

        $stmt->execute();
        $participant = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$participant) {
            $error = 'Email address not found.';
        } elseif (!password_verify($current_pass, $participant['password_hash'])) {
            $error = 'Current / temporary password is incorrect.';
        } else {
            // All good — update the password
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $upd = $conn->prepare('UPDATE participants SET password_hash = ? WHERE id = ?');
            $upd->bind_param('si', $new_hash, $participant['id']);
            $upd->execute();
            $upd->close();

            $success = 'Your password has been updated successfully. You can now <a href="login.php" style="color:var(--primary-color,#0d9488);font-weight:600;">log in</a> with your new password.';
        }
    }
}

render:
include 'includes/header.php';
?>

<style>
.cp-wrap{display:flex;justify-content:center;align-items:flex-start;padding:160px 20px 100px;min-height:calc(100vh - 300px);}
.cp-card{background:#fff;width:100%;max-width:560px;border:1px solid #e2e8f0;border-radius:6px;box-shadow:0 4px 20px rgba(0,0,0,.06);}
.cp-header{padding:15px 24px;border-bottom:1px solid #e2e8f0;background:#f8f9fa;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;color:#475569;}
.cp-body{padding:32px 36px;}
.cp-notice{background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:14px 16px;margin-bottom:22px;font-size:13px;color:#1e40af;line-height:1.6;}
.cp-notice strong{display:block;margin-bottom:4px;font-size:13.5px;}
.cp-group{margin-bottom:18px;}
.cp-group label{display:block;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:#475569;margin-bottom:6px;}
.cp-group input{width:100%;box-sizing:border-box;padding:10px 14px;border:1px solid #cbd5e1;border-radius:4px;font-size:14px;font-family:'Inter',sans-serif;transition:border-color .2s,box-shadow .2s;}
.cp-group input:focus{outline:none;border-color:var(--primary-color,#0d9488);box-shadow:0 0 0 3px rgba(13,148,136,.12);}
.cp-group .hint{font-size:11.5px;color:#94a3b8;margin-top:4px;}
.btn-cp{background:var(--primary-color,#0d9488);color:#fff;border:none;padding:10px 22px;border-radius:4px;font-size:14px;font-weight:600;cursor:pointer;transition:background .2s;}
.btn-cp:hover{background:#0b7a70;}
.alert-success{background:#d1fae5;color:#065f46;padding:14px 16px;border-radius:5px;font-size:14px;margin-bottom:18px;line-height:1.6;}
.alert-error{background:#fee2e2;color:#991b1b;padding:14px 16px;border-radius:5px;font-size:14px;margin-bottom:18px;}
.back-link{display:inline-block;margin-top:16px;font-size:13px;color:var(--primary-color,#0d9488);text-decoration:none;}
.back-link:hover{text-decoration:underline;}
.divider{border:none;border-top:1px solid #e2e8f0;margin:22px 0;}
</style>

<div class="cp-wrap">
    <div class="cp-card">
        <div class="cp-header">Change Password</div>
        <div class="cp-body">

            <?php if ($error): ?>
                <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert-success"><?php echo $success; ?></div>
                <a href="login.php" class="back-link">&larr; Back to Login</a>

            <?php else: ?>

                <!-- Info box: shown when arriving from forgot_password or when not logged in -->
                <?php if (!$logged_in): ?>
                <div class="cp-notice">
                    <strong>🔑 Using a temporary password?</strong>
                    If an admin has reset your password, you should have received a <strong>temporary password</strong> via email.
                    Enter that temporary password in the <em>"Current Password"</em> field below, then choose your own new password.
                </div>
                <?php endif; ?>

                <form method="POST" action="change_password.php">

                    <?php if (!$logged_in): ?>
                    <!-- Email field — only needed when not logged in -->
                    <div class="cp-group">
                        <label for="form_email">Registered Email Address</label>
                        <input type="email" id="form_email" name="form_email"
                               value="<?php echo htmlspecialchars($prefill_email); ?>"
                               placeholder="your@email.com" required autofocus>
                    </div>
                    <?php endif; ?>

                    <div class="cp-group">
                        <label for="current_password">
                            <?php echo $logged_in ? 'Current Password' : 'Current / Temporary Password'; ?>
                        </label>
                        <input type="password" id="current_password" name="current_password"
                               placeholder="Enter your current or temporary password"
                               required <?php echo $logged_in ? 'autofocus' : ''; ?>>
                        <?php if (!$logged_in): ?>
                        <p class="hint">This is the temporary password sent to you by the ICTB secretariat.</p>
                        <?php endif; ?>
                    </div>

                    <hr class="divider">

                    <div class="cp-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password"
                               placeholder="Minimum 8 characters" required minlength="8">
                    </div>

                    <div class="cp-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Repeat your new password" required minlength="8">
                    </div>

                    <button type="submit" class="btn-cp">Save New Password</button>
                </form>

                <a href="login.php" class="back-link">&larr; Back to Login</a>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
