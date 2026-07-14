<?php
session_start();
require_once 'includes/db.php';

$upload_success = false;
$upload_error_msg = "";

$user_data = [];
$app_data = [];
if (isset($_SESSION['participant_id'])) {
    $stmt = $conn->prepare("SELECT * FROM participants WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['participant_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    }
    $stmt->close();
    
    $stmt2 = $conn->prepare("SELECT * FROM applications WHERE participant_id = ? ORDER BY id DESC LIMIT 1");
    $stmt2->bind_param("i", $_SESSION['participant_id']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
        $app_data = $result2->fetch_assoc();
    }
    $stmt2->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['payment_receipt'])) {
        if ($_FILES['payment_receipt']['error'] == UPLOAD_ERR_OK) {
            $filename = time() . '_receipt_' . basename($_FILES['payment_receipt']['name']);
            $target_path = 'uploads/' . $filename;
            if (move_uploaded_file($_FILES['payment_receipt']['tmp_name'], $target_path)) {
                if (isset($_SESSION['participant_id'])) {
                    $stmt = $conn->prepare("UPDATE participants SET bukti_transfer = ? WHERE id = ?");
                    if (!$stmt) {
                        die("Database Error in Confirmation.php: " . $conn->error);
                    }
                    $stmt->bind_param("si", $target_path, $_SESSION['participant_id']);
                    $stmt->execute();
                    
                    // Set explicitly for the current page load
                    $user_data['bukti_transfer'] = $target_path;
                }
                $upload_success = true;
            }
        } else if ($_FILES['payment_receipt']['error'] != UPLOAD_ERR_NO_FILE) {
            if ($_FILES['payment_receipt']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['payment_receipt']['error'] == UPLOAD_ERR_FORM_SIZE) {
                $upload_error_msg = "Error: Ukuran file bukti pembayaran terlalu besar (melebihi batas maksimal server). Harap kompres file Anda.";
            } else {
                $upload_error_msg = "Error uploading receipt: Code " . $_FILES['payment_receipt']['error'];
            }
        }
    }

    // Handling PPT Upload
    if (isset($_FILES['update_ppt'])) {
        if ($_FILES['update_ppt']['error'] == UPLOAD_ERR_OK) {
            $max_size = 20 * 1024 * 1024; // 20 MB
            if ($_FILES['update_ppt']['size'] > $max_size) {
                $upload_error_msg = "Error: Ukuran file PPT/PDF maksimal adalah 20 MB.";
            } else {
                $filename = time() . '_ppt_' . basename($_FILES['update_ppt']['name']);
                $target_path = 'uploads/' . $filename;
                if (move_uploaded_file($_FILES['update_ppt']['tmp_name'], $target_path)) {
                    if (isset($_SESSION['participant_id'])) {
                        if (!empty($app_data)) {
                            $stmt = $conn->prepare("UPDATE applications SET ppt_file = ? WHERE participant_id = ? ORDER BY id DESC LIMIT 1");
                            if ($stmt) {
                                $stmt->bind_param("si", $target_path, $_SESSION['participant_id']);
                                $stmt->execute();
                                $app_data['ppt_file'] = $target_path;
                            }
                        }
                    }
                    $upload_success = true;
                }
            }
        } else if ($_FILES['update_ppt']['error'] != UPLOAD_ERR_NO_FILE) {
            $upload_error_msg = "Error uploading PPT. Please ensure the file size does not exceed the maximum allowed size (20 MB).";
        }
    }

    if (isset($_FILES['update_abstract']) && $_FILES['update_abstract']['error'] == UPLOAD_ERR_OK) {
        $filename = time() . '_abstract_' . basename($_FILES['update_abstract']['name']);
        $target_path = 'uploads/' . $filename;
        if (move_uploaded_file($_FILES['update_abstract']['tmp_name'], $target_path)) {
            if (isset($_SESSION['participant_id'])) {
                if (!empty($app_data)) {
                    $stmt = $conn->prepare("UPDATE applications SET abstract = ? WHERE participant_id = ? ORDER BY id DESC LIMIT 1");
                    $stmt->bind_param("si", $target_path, $_SESSION['participant_id']);
                    $stmt->execute();
                    $app_data['abstract'] = $target_path;
                } else {
                    $stmt = $conn->prepare("INSERT INTO applications (participant_id, abstract) VALUES (?, ?)");
                    $stmt->bind_param("is", $_SESSION['participant_id'], $target_path);
                    $stmt->execute();
                    $app_data['abstract'] = $target_path;
                }
            }
            $upload_success = true;
        }
    }
}

// Dynamic Pricing Logic based on Registration Type (Indonesian Participants)
$participant_type = isset($user_data['participant_type']) && !empty($user_data['participant_type']) ? $user_data['participant_type'] : (isset($_GET['type']) ? $_GET['type'] : 'Author');

// Determine category based on is_student
$is_student = isset($_SESSION['is_student']) ? $_SESSION['is_student'] : 'No';
$participant_category = (strtolower($is_student) == 'yes') ? 'student' : 'General';

$is_participant_only = (strtolower($participant_type) == 'participant');

// Automatic Early Bird calculation based on current date
$early_bird_deadline = strtotime('2026-08-31 23:59:59');
$current_time = time();
$is_early_bird = ($current_time <= $early_bird_deadline);

// Get publication type from database or session
$publication_type = "";
if (!empty($app_data['publication_id'])) {
    $publication_type = $app_data['publication_id'];
} elseif (isset($_SESSION['publication'])) {
    $publication_type = $_SESSION['publication'];
} else {
    $publication_type = 'ICTB proceeding book (ISBN) - IDR 800,000 / USD 80'; // Default fallback
}

$participation_fee = 0;
$fee_label = "";
$rate_title = "";

// Determine participation fee based on Type and Category
if (strtolower($participant_category) == 'student') {
    $participation_fee = $is_early_bird ? 600000 : 750000;
    $fee_label = "Participation as Student" . (strtolower($participant_type) == 'author' ? ' (Author)' : '');
    $rate_title = "Student";
} elseif (strtolower($participant_type) == 'author') {
    $participation_fee = $is_early_bird ? 1200000 : 1500000;
    $fee_label = "Participation as Presenter (oral, poster)";
    $rate_title = "Presenter";
} elseif (strtolower($participant_type) == 'participant') {
    $participation_fee = $is_early_bird ? 850000 : 1000000;
    $fee_label = "Participation as General (no paper)";
    $rate_title = "General";
} else {
    // Default / Exhibitor fallback
    $participation_fee = 0;
    $fee_label = "Participation as " . ucfirst($participant_type);
    $rate_title = ucfirst($participant_type);
}

$publication_fee = 0;
$pub_fee_label = "To be determined by the journal";

if ($is_participant_only) {
    $publication_fee = 0;
    $pub_fee_label = "Not Applicable";
    $publication_type = "None";
} else {
    if (strpos($publication_type, 'Scopus-indexed proceedings') !== false && strpos($publication_type, '2,500,000') !== false) {
        $publication_fee = 2500000;
        $pub_fee_label = "IDR " . number_format($publication_fee, 0, ',', ',');
    } elseif (strpos($publication_type, 'ICTB proceeding book') !== false || strpos($publication_type, 'Rp. 800.000') !== false) {
        $publication_fee = 800000;
        $pub_fee_label = "IDR " . number_format($publication_fee, 0, ',', ',');
    } elseif (strpos(strtolower($publication_type), 'free') !== false) {
        $publication_fee = 0;
        $pub_fee_label = "Free";
    }
}

$total_payment = $participation_fee;
$total_payment_formatted = "IDR " . number_format($total_payment, 0, ',', ',');
?>
<?php include 'includes/header.php'; ?>

<style>
.wizard-progress {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px dotted #ccc;
}
.wizard-progress::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 10%;
    right: 10%;
    height: 1px;
    background: #ccc;
    z-index: 0;
}
.wizard-step {
    text-align: center;
    position: relative;
    z-index: 1;
    flex: 1;
}
.wizard-step-name {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #999;
}
.wizard-step-name.active {
    color: #1a73e8; /* Blue color similar to image */
}
.wizard-step-dot {
    width: 10px;
    height: 10px;
    background: #ddd;
    border-radius: 50%;
    margin: 0 auto;
}
.wizard-step-dot.active {
    background: #f1c40f; /* Yellow color from image */
}
.info-alert {
    font-size: 13px;
    color: #333;
    margin-bottom: 25px;
}
.info-fieldset {
    border: 1px solid #e0e0e0;
    padding: 20px;
    margin-bottom: 20px;
    background: #fff;
}
.info-legend {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    padding: 0 5px;
    width: auto;
    border-bottom: none;
    margin-bottom: 0;
}
.summary-line {
    font-size: 13px;
    color: #444;
    margin-bottom: 8px;
}
.summary-label {
    color: #666;
    display: inline-block;
}
.summary-val {
    font-weight: bold;
    color: #333;
}
.btn-dark-blue {
    background: #2b5d8c;
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
    text-decoration: none;
    margin-top: 5px;
    margin-bottom: 5px;
}
.btn-dark-blue:hover {
    background: #1f4366;
    color: #fff;
}
.payment-info {
    font-size: 13px;
    line-height: 1.6;
    color: #444;
}
.payment-info h3 {
    font-size: 20px;
    font-family: serif;
    color: #333;
    margin-bottom: 15px;
    margin-top: 5px;
}
.highlight-box {
    background: #ffff00;
    padding: 5px;
    border: 1px solid #ccc;
    display: inline-block;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 10px;
}
.btn-yellow-submit {
    background: #ffff00;
    border: 1px solid #000;
    color: #000;
    padding: 4px 12px;
    font-size: 13px;
    cursor: pointer;
}
.btn-yellow-confirm {
    background: #ffff00;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 20px;
    border-radius: 2px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
.btn-yellow-confirm:hover {
    background: #e6e600;
}
</style>

<section class="section-padding bg-alt" style="min-height: 80vh; padding-top: 120px;">
    <div class="container" style="max-width: 1000px; background: #fff; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

        <div style="display: flex; align-items: center; margin-bottom: 30px;">
            <div style="width: 4px; height: 24px; background-color: #1a73e8; margin-right: 10px;"></div>
            <h2 style="font-family: var(--font-subheading); color: #333; font-size: 22px; margin: 0; font-weight: bold;">
                Registration Summary for: 5ICTB-OR-0075
            </h2>
        </div>

        <!-- Progress Tracker -->
        <div class="wizard-progress">
            <div class="wizard-step">
                <div class="wizard-step-name active">Identification</div>
                <div class="wizard-step-dot active"></div>
            </div>
            <div class="wizard-step">
                <div class="wizard-step-name active">Additional Information</div>
                <div class="wizard-step-dot active"></div>
            </div>
            <?php if (!$is_participant_only): ?>
            <div class="wizard-step">
                <div class="wizard-step-name active">Application</div>
                <div class="wizard-step-dot active"></div>
            </div>
            <?php endif; ?>
            <div class="wizard-step">
                <div class="wizard-step-name active">Confirmation</div>
                <div class="wizard-step-dot active"></div>
            </div>
        </div>

        <div class="info-alert">
            Summary of all the information that you have entered earlier. Please make sure all information shown are correct before clicking on Confirmation Button.
        </div>
        <?php if (!empty($upload_error_msg)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 4px;">
                <?php echo htmlspecialchars($upload_error_msg); ?>
            </div>
        <?php endif; ?>

        <fieldset class="info-fieldset">
            <legend class="info-legend">Registrant Information</legend>
            <?php
            $reg_id = isset($user_data['id']) ? "5ICTB-".strtoupper(substr($user_data['participant_type']??'PART', 0, 3))."-".str_pad($user_data['id'], 4, "0", STR_PAD_LEFT) : 'N/A';
            $fullname = trim(($user_data['title']??'').' '.($user_data['first_name']??'').' '.($user_data['last_name']??''));
            $org_display = ($user_data['institution']??'');
            if (!empty($user_data['org_type'])) $org_display .= ' (' . $user_data['org_type'] . ')';
            ?>
            <div class="summary-line"><span class="summary-label">Registration ID:</span> <span class="summary-val"><?php echo htmlspecialchars($reg_id); ?></span></div>
            <div class="summary-line"><span class="summary-label">Fullname:</span> <span class="summary-val"><?php echo htmlspecialchars($fullname); ?></span></div>
            <div class="summary-line"><span class="summary-label">Registration Code:</span> <span class="summary-val"><?php echo htmlspecialchars($reg_id); ?></span></div>
            <div class="summary-line"><span class="summary-label">Email address:</span> <span class="summary-val"><?php echo htmlspecialchars($user_data['email']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Phone number:</span> <span class="summary-val"><?php echo htmlspecialchars($user_data['phone']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Gender:</span> <span class="summary-val"><?php echo htmlspecialchars($user_data['gender']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Organization:</span> <span class="summary-val"><?php echo htmlspecialchars($org_display); ?></span></div>
            <div class="summary-line"><span class="summary-label">Country:</span> <span class="summary-val"><?php echo htmlspecialchars($user_data['country']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Participant Type:</span> <span class="summary-val"><?php echo ucfirst(htmlspecialchars($user_data['participant_type'] ?? $participant_type)); ?></span></div>
            <div class="summary-line"><span class="summary-label">Participant Category:</span> <span class="summary-val"><?php echo ucfirst(htmlspecialchars($participant_category)); ?> <?php if (!empty($user_data['bukti_diri'])): ?>| <a href="<?php echo htmlspecialchars($user_data['bukti_diri']); ?>" target="_blank" style="color: #1a73e8; text-decoration: none;">Proof</a><?php endif; ?></span></div>
            <div class="summary-line"><span class="summary-label">Food allergies:</span> <span class="summary-val"><?php echo htmlspecialchars($user_data['allergies']??''); ?></span></div>
        </fieldset>

        <?php if (!$is_participant_only): ?>
        <fieldset class="info-fieldset">
            <legend class="info-legend">Application Information</legend>
            <div class="summary-line"><span class="summary-label">Application Type:</span> <span class="summary-val"><?php echo htmlspecialchars($app_data['apptype_id']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Theme:</span> <span class="summary-val">Biodiversity Beyond Boundaries: Advancing Global Education, Bio-Science, and Sustainable Landscapes</span></div>
            <div class="summary-line"><span class="summary-label">Subtheme:</span> <span class="summary-val"><?php echo htmlspecialchars($app_data['subtheme_id']??''); ?></span></div>
            <div class="summary-line"><span class="summary-label">Title:</span> <span class="summary-val"><?php echo htmlspecialchars($app_data['title']??''); ?></span></div>
            
            <div style="margin-top: 15px; margin-bottom: 10px;">
                <strong>Upload / Update Abstract File (.docx):</strong>
                
                <?php if (!empty($app_data['abstract'])): ?>
                    <div style="color: green; font-weight: bold; margin-top: 5px; margin-bottom: 10px;">
                        Upload Successful: <a href="<?php echo htmlspecialchars($app_data['abstract']); ?>" target="_blank" style="color: green; text-decoration: underline;"><?php echo htmlspecialchars(basename($app_data['abstract'])); ?></a>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateAbstractUpdate()">
                    <div class="highlight-box" style="margin-top: 5px; margin-bottom: 5px;">
                        <input type="file" name="update_abstract" id="update_abstract" accept=".docx" style="font-size: 12px; background: #e9ecef; border: 1px solid #ccc; padding: 2px;">
                    </div>
                    <button type="submit" class="btn-yellow-submit" style="margin-bottom: 10px;"><?php echo !empty($app_data['abstract']) ? 'Update Abstract' : 'Submit Abstract'; ?></button>
                </form>
            </div>
            
            <div class="summary-line" style="margin-top: 5px;"><span class="summary-label">Keywords:</span></div>
            <div style="font-family: 'Inter', sans-serif; font-size: 13px; color: #555; background: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px solid #e9ecef; margin-top: 5px;">
                <?php echo nl2br(htmlspecialchars($app_data['keyword']??'')); ?>
            </div>
            <div class="summary-line"><span class="summary-label">Publication Type:</span> <span class="summary-val"><?php echo htmlspecialchars($publication_type); ?> - <?php echo $pub_fee_label; ?></span></div>
            
            <?php if (strtolower($participant_type) == 'author'): ?>
                <?php if (!empty($user_data['bukti_transfer'])): ?>
                <div style="margin-top: 20px; margin-bottom: 10px; border-top: 1px dashed #ccc; padding-top: 15px;">
                    <strong>Upload / Update Presentation File (PPT/PDF):</strong>
                    <div style="font-size: 11px; color: #d9534f; margin-bottom: 5px;">
                        <em>Note: Maximum file size allowed is 20 MB.</em>
                    </div>
                    
                    <?php if (!empty($app_data['ppt_file'])): ?>
                        <div style="color: green; font-weight: bold; margin-top: 5px; margin-bottom: 10px;">
                            Upload Successful: <a href="<?php echo htmlspecialchars($app_data['ppt_file']); ?>" target="_blank" style="color: green; text-decoration: underline;"><?php echo htmlspecialchars(basename($app_data['ppt_file'])); ?></a>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validatePPTUpdate()">
                        <div class="highlight-box" style="margin-top: 5px; margin-bottom: 5px;">
                            <input type="file" name="update_ppt" id="update_ppt" accept=".ppt,.pptx,.pdf" style="font-size: 12px; background: #e9ecef; border: 1px solid #ccc; padding: 2px;">
                        </div>
                        <button type="submit" class="btn-yellow-submit" style="margin-bottom: 10px;"><?php echo !empty($app_data['ppt_file']) ? 'Update Presentation' : 'Submit Presentation'; ?></button>
                    </form>
                </div>
                <?php else: ?>
                <div style="margin-top: 20px; margin-bottom: 10px; border-top: 1px dashed #ccc; padding-top: 15px;">
                    <div style="font-size: 13px; color: #856404; background-color: #fff3cd; border: 1px solid #ffeeba; padding: 12px; border-radius: 4px; text-align: center;">
                        <strong>Note for Presenters:</strong><br>
                        The form to upload your presentation file (PPT/PPTX/PDF) will appear here <strong>after you have successfully uploaded your payment receipt</strong> at the Payment Information section below.
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </fieldset>
        <?php endif; ?>

        <fieldset class="info-fieldset">
            <legend class="info-legend">Payment Information</legend>
            <div class="payment-info">
                <h3><?php echo htmlspecialchars($rate_title); ?> Rate <?php echo $is_early_bird ? '(Early Bird)' : '(Regular)'; ?></h3>
                
                <div style="margin-bottom: 5px;"><?php echo $fee_label; ?>: <span class="summary-val">IDR <?php echo number_format($participation_fee, 0, ',', ','); ?></span></div>
                <div style="margin-bottom: 10px;">Publication: <span class="summary-val"><?php echo $pub_fee_label; ?></span></div>
                <div style="margin-bottom: 20px; font-size: 14px;"><strong>Total payment: <span class="summary-val"><?php echo $total_payment_formatted; ?></span></strong></div>

                <div style="margin-bottom: 5px;">Should you need formal invoice, please contact <a href="mailto:ictb@biotrop.org" style="color: #1a73e8; text-decoration: none;">ictb@biotrop.org</a></div>
                
                <div style="margin-left: 20px; margin-bottom: 20px;">
                    <div>Please pay for the amount of <strong><?php echo $total_payment_formatted; ?></strong>, to:</div>
                    <div>SEAMEO BIOTROP</div>
                    <div>Account Number: 1330013406830</div>
                    <div>Bank MANDIRI (Persero) Tbk, Bogor Branch</div>
                    <div>Jl. Raya Tajur No. 121 B-C, Bogor, Indonesia</div>
                    <div>Account Currency: IDR &nbsp;|&nbsp; Branch Code: 13310</div>
                    <div>SWIFT CODE: BNINIDJABGR</div>
                </div>

                <div style="margin-bottom: 10px;">After you have completed the payment, please upload your receipt here:</div>
                
                <?php if (!empty($user_data['bukti_transfer'])): ?>
                    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                        Upload Successful: <a href="<?php echo htmlspecialchars($user_data['bukti_transfer']); ?>" target="_blank" style="color: green; text-decoration: underline;"><?php echo htmlspecialchars(basename($user_data['bukti_transfer'])); ?></a>
                    </div>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateReceiptUpdate()">
                    <div class="highlight-box">
                        <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf" style="font-size: 12px; background: #e9ecef; border: 1px solid #ccc; padding: 2px;">
                    </div>
                    <div>
                        <button type="submit" class="btn-yellow-submit"><?php echo !empty($user_data['bukti_transfer']) ? 'Update Receipt' : 'Submit Receipt'; ?></button>
                    </div>
                </form>
            </div>
        </fieldset>

        <?php $has_receipt = !empty($user_data['bukti_transfer']); ?>
        <a href="<?php echo $has_receipt ? 'success.php' : '#'; ?>" class="btn-yellow-confirm" style="display: inline-block; text-decoration: none; text-align: center; <?php echo $has_receipt ? '' : 'opacity: 0.5; cursor: not-allowed; pointer-events: none;'; ?>">Confirm Data</a>

    </div>
</section>

<script>
function validateAbstractUpdate() {
    var fileInput = document.getElementById('update_abstract');
    if (fileInput && fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var fileName = file.name;
        var extension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
        
        if (extension !== '.docx') {
            alert('Format file tidak didukung! Harap unggah file dengan format .docx saja.');
            fileInput.value = ''; 
            return false;
        }
    } else {
        alert('Harap pilih file abstrak Anda (.docx) terlebih dahulu.');
        return false;
    }
    return true;
}

function validatePPTUpdate() {
    var fileInput = document.getElementById('update_ppt');
    if (fileInput && fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var fileName = file.name;
        var extension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
        
        var allowedExtensions = ['.ppt', '.pptx', '.pdf'];
        if (!allowedExtensions.includes(extension)) {
            alert('Format file tidak didukung! Harap unggah file dengan format .ppt, .pptx, atau .pdf.');
            fileInput.value = ''; 
            return false;
        }
        
        var maxSize = 20 * 1024 * 1024; // 20 MB
        if (file.size > maxSize) {
            alert('Ukuran file melebihi batas maksimal yang diizinkan (20 MB).');
            fileInput.value = '';
            return false;
        }
    } else {
        alert('Harap pilih file presentasi Anda terlebih dahulu.');
        return false;
    }
    return true;
}
function validateReceiptUpdate() {
    var fileInput = document.getElementById('payment_receipt');
    if (fileInput && fileInput.files.length > 0) {
        var file = fileInput.files[0];
        
        var maxSize = 5 * 1024 * 1024; // 5 MB limit
        if (file.size > maxSize) {
            alert('Gagal: Ukuran file bukti transfer terlalu besar (' + (file.size/1024/1024).toFixed(2) + ' MB). Batas maksimal adalah 5 MB. Harap kompres/resize foto bukti transfer Anda.');
            fileInput.value = '';
            return false;
        }
    } else {
        alert('Harap pilih file bukti transfer Anda terlebih dahulu.');
        return false;
    }
    return true;
}
</script>

<?php include 'includes/footer.php'; ?>
