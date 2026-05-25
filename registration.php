<?php 
require_once 'includes/db.php';

$success_msg = '';
$error_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $participant_type = $_POST['participant_type'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $institution = '';
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $password_conf = $_POST['password_conf'];

    // Basic validation
    if ($password !== $password_conf) {
        $error_msg = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM participants WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error_msg = "Email already registered.";
        } else {
            // Password hash
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $bukti_transfer = '';
            $bukti_diri = '';

            // Insert Database
            $stmt = $conn->prepare("INSERT INTO participants (participant_type, first_name, last_name, institution, email, phone, password_hash, bukti_transfer, bukti_diri) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $participant_type, $first_name, $last_name, $institution, $email, $phone, $password_hash, $bukti_transfer, $bukti_diri);
            
            if ($stmt->execute()) {
                header("Location: information.php?type=" . urlencode($participant_type));
                exit();
            } else {
                $error_msg = "Error registering participant: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1518182170546-076616fd4803?q=80&w=2070&auto=format&fit=crop');">
    <div class="cover-overlay"></div>
    <div class="container page-header-content text-center">
        <h1 class="section-title text-white">Conference Registration</h1>
        <p class="text-white" style="font-size: 1.1rem; opacity: 0.9;">Join the 5th International Conference on Tropical Biology</p>
    </div>
</section>

<!-- Conference Fee Section -->
<section id="fees" style="padding: 80px 0 20px;">
    <div class="container">
        <div class="section-header text-center reveal-up">
            <span class="section-subtitle">Pricing Details</span>
            <h2 class="section-title">Conference Fee</h2>
            <p class="mt-4" style="color: var(--text-muted); max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
                Registration will be conducted online through the conference website.
            </p>
        </div>
        
        <div class="fee-table-container reveal-up" style="transition-delay: 0.1s;">
            <table class="fee-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Early Bird<br><span style="font-size:12px;font-weight:400;">(before 31 August 2026)</span></th>
                        <th>Regular Rate<br><span style="font-size:12px;font-weight:400;">(1 – 25 September 2026)</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-group-header">
                        <td colspan="3">Foreign Participants <span style="font-size: 13px; font-weight: normal; text-transform: none; color: var(--text-muted); margin-left: 8px;">(incl. airport transportation)</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Presenter <span style="color: var(--text-muted); font-size: 13px; font-weight: normal; margin-left: 8px;">(oral, poster)</span></td>
                        <td>USD 150</td>
                        <td style="font-size: 12px; color: var(--text-muted); font-style: italic;">Conference Organizer will no longer accept paper submission after 25 August 2026</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">General <span style="color: var(--text-muted); font-size: 13px; font-weight: normal; margin-left: 8px;">(no paper)</span></td>
                        <td>USD 80</td>
                        <td>USD 100</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Student</td>
                        <td>USD 60</td>
                        <td>USD 80</td>
                    </tr>

                    <tr class="table-group-header">
                        <td colspan="3">Indonesian Participants</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Presenter <span style="color: var(--text-muted); font-size: 13px; font-weight: normal; margin-left: 8px;">(oral, poster)</span></td>
                        <td>IDR 1,200,000</td>
                        <td style="font-size: 12px; color: var(--text-muted); font-style: italic;">Conference Organizer will no longer accept paper submission after 25 August 2026</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">General <span style="color: var(--text-muted); font-size: 13px; font-weight: normal; margin-left: 8px;">(no paper)</span></td>
                        <td>IDR 850,000</td>
                        <td>IDR 1,000,000</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Student</td>
                        <td>IDR 600,000</td>
                        <td>IDR 750,000</td>
                    </tr>
                </tbody>
            </table>

            <table class="fee-table" style="margin-top: -1px;">
                <thead>
                    <tr>
                        <th colspan="2">Publication Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 600; width: 50%;">In selected Scopus-indexed journals</td>
                        <td>To be determined by the journal</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Sinta accredited journal</td>
                        <td>To be determined by the journal</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Scopus-indexed proceedings</td>
                        <td>IDR 2,500,000</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">ICTB proceeding book (ISBN)</td>
                        <td>IDR 800,000 / USD 80</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Registration Form Section -->
<section class="bg-alt" id="important-info" style="padding: 20px 0 80px;">
    <div class="container">
        <div class="registration-wrapper reveal-up">
            <div class="registration-info" style="border-left: 4px solid var(--primary-color);">
                <h3 style="display: flex; align-items: center; gap: 8px; color: var(--primary-color); font-family: var(--font-subheading); font-size: 24px; margin-bottom: 16px;">
                    <i class="ph-bold ph-calendar-blank" style="color: var(--primary-color); font-size: 24px;"></i>
                    Important Dates & Info
                </h3>
                <p style="font-size: 14px; margin-bottom: 20px; color: var(--text-muted);">Please take note of the following crucial deadlines for the conference registration and submission process:</p>
                
                <div class="timeline-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                    
                    <div class="timeline-item" style="border-left: 2px solid #e2e8f0; padding-left: 15px; position: relative;">
                        <span style="position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: var(--accent-color);"></span>
                        <div style="font-size: 12px; font-weight: bold; color: var(--accent-color); text-transform: uppercase;">10 August 2026</div>
                        <div style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Abstract Submission Deadline</div>
                    </div>

                    <div class="timeline-item" style="border-left: 2px solid #e2e8f0; padding-left: 15px; position: relative;">
                        <span style="position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: var(--primary-color);"></span>
                        <div style="font-size: 12px; font-weight: bold; color: var(--primary-color); text-transform: uppercase;">25 August 2026</div>
                        <div style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Paper Submission Deadline</div>
                    </div>

                    <div class="timeline-item" style="border-left: 2px solid #e2e8f0; padding-left: 15px; position: relative;">
                        <span style="position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: #17a2b8;"></span>
                        <div style="font-size: 12px; font-weight: bold; color: #17a2b8; text-transform: uppercase;">31 August 2026</div>
                        <div style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Early Bird Deadline</div>
                    </div>

                    <div class="timeline-item" style="border-left: 2px solid #e2e8f0; padding-left: 15px; position: relative;">
                        <span style="position: absolute; left: -6px; top: 4px; width: 10px; height: 10px; border-radius: 50%; background: #28a745;"></span>
                        <div style="font-size: 12px; font-weight: bold; color: #28a745; text-transform: uppercase;">25 September 2026</div>
                        <div style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Registration Deadline</div>
                    </div>

                </div>

                <div style="background: rgba(13, 148, 136, 0.05); padding: 15px; border-radius: 8px; border: 1px solid rgba(13, 148, 136, 0.15); display: flex; gap: 10px; align-items: flex-start;">
                    <i class="ph-bold ph-info" style="color: var(--primary-color); font-size: 20px; margin-top: 2px;"></i>
                    <div style="font-size: 13px; color: var(--text-dark); line-height: 1.5;">
                        For <strong>Group Registrations</strong> or other inquiries, please contact our secretariat at <a href="mailto:ictb@biotrop.org" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">ictb@biotrop.org</a>.
                    </div>
                </div>
            </div>
            
            <div class="registration-form-card">
                <?php if($success_msg): ?>
                    <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <i class="ph-bold ph-check-circle"></i> <?php echo $success_msg; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($error_msg): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <i class="ph-bold ph-warning-circle"></i> <?php echo $error_msg; ?>
                    </div>
                <?php endif; ?>

                <?php
                // Get the predefined type from URL if it exists (e.g. ?type=presenter)
                $selected_type = isset($_GET['type']) ? $_GET['type'] : 'participant';
                ?>
                <form action="registration.php#important-info" method="POST" class="conference-form" enctype="multipart/form-data">
                    <h4 style="margin-bottom: 20px; color: var(--primary-color);">Main author or Participant Only</h4>
                    
                    <div class="form-group">
                        <label for="participantType">Type of Participant</label>
                        <select id="participantType" name="participant_type" class="form-control" required>
                            <option value="author" <?php echo $selected_type == 'author' ? 'selected' : ''; ?>>Author</option>
                            <option value="participant" <?php echo $selected_type == 'participant' ? 'selected' : ''; ?>>Participant Only</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input type="text" id="firstName" name="first_name" class="form-control" placeholder="First name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last name</label>
                            <input type="text" id="lastName" name="last_name" class="form-control" placeholder="Last name" required>
                        </div>
                    </div>

                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="password" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordConf">Password Confirmation</label>
                            <input type="password" id="passwordConf" name="password_conf" class="form-control" placeholder="password" required>
                        </div>
                    </div>


                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn" style="background-color: #17a2b8; color: #000; padding: 8px 16px; font-weight: bold; border: 1px solid #117a8b;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
