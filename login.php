<?php 
session_start();
require_once 'includes/db.php';

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, first_name, password_hash FROM participants WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['participant_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Invalid password.";
        }
    } else {
        $error_msg = "Email not found.";
    }
    $stmt->close();
}

include 'includes/header.php'; 
?>

<style>
    /* Specific styles for the login page matching the screenshot */
    body {
        background-color: var(--bg-light, #ffffff);
    }
    
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 160px 20px 100px; /* Space for the fixed header */
        min-height: calc(100vh - 300px); /* Adjust based on footer height */
    }
    
    .login-card {
        background: #ffffff;
        width: 100%;
        max-width: 650px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        /* Using minimal shadow to match the flat/clean look in screenshot */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }
    
    .login-card-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #f8f9fa;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #64748b;
    }
    
    .login-card-body {
        padding: 35px 40px;
    }
    
    .login-form-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .login-form-label {
        width: 160px;
        text-align: right;
        padding-right: 20px;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .login-form-input {
        flex: 1;
    }
    
    .login-form-input input[type="email"],
    .login-form-input input[type="password"] {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #333;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .login-form-input input:focus {
        outline: none;
        border-color: #3b82f6; /* Blue border on focus */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .login-checkbox-group {
        display: flex;
        align-items: center;
        margin-left: 160px; /* Matches label width */
        margin-bottom: 25px;
        margin-top: -5px;
    }
    
    .login-checkbox-group input[type="checkbox"] {
        margin-right: 8px;
        cursor: pointer;
    }
    
    .login-checkbox-group label {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }
    
    .login-actions {
        margin-left: 160px; /* Matches label width */
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .btn-login {
        background-color: #007bff; /* Bright blue as seen in screenshot */
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-login:hover {
        background-color: #0069d9;
    }
    
    .forgot-password {
        color: #20c997; /* Teal color for the forgot password link */
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .forgot-password:hover {
        color: #1aa179;
        text-decoration: underline;
    }
    
    /* Responsive adjustments */
    @media (max-width: 650px) {
        .login-form-group {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .login-form-label {
            width: 100%;
            text-align: left;
            margin-bottom: 8px;
        }
        
        .login-checkbox-group, .login-actions {
            margin-left: 0;
        }
        
        .login-card-body {
            padding: 25px;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-card-header">
            Login
        </div>
        <div class="login-card-body">
            <?php if (!empty($error_msg)): ?>
                <div style="color: red; margin-bottom: 15px; font-size: 14px; text-align: center; font-family: 'Inter', sans-serif;">
                    <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="login-form-group">
                    <label class="login-form-label" for="email">E-mail Address</label>
                    <div class="login-form-input">
                        <input type="email" id="email" name="email" required autofocus>
                    </div>
                </div>
                
                <div class="login-form-group">
                    <label class="login-form-label" for="password">Password</label>
                    <div class="login-form-input">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="login-checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>
                
                <div class="login-actions">
                    <button type="submit" class="btn-login">Login</button>
                    <a href="#" class="forgot-password">Forgot Your Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
