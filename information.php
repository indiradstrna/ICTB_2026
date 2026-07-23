<?php
session_start();
require_once 'includes/db.php';

$participant_type = isset($_GET['type']) ? $_GET['type'] : 'author';
$is_participant_only = (strtolower($participant_type) == 'participant');

$existing_data = [];
if (isset($_SESSION['participant_id'])) {
    $stmt = $conn->prepare("SELECT * FROM participants WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['participant_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $existing_data = $res->fetch_assoc();
        }
        $stmt->close();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $is_student = $_POST['is_student'] ?? 'No';
    $_SESSION['is_student'] = $is_student;
    
    $title = $_POST['title'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $organization = $_POST['organization'] ?? '';
    $org_type = $_POST['org_type'] ?? '';
    $country = $_POST['country'] ?? '';
    $attendance = $_POST['attendance'] ?? '';
    $funding = $_POST['funding'] ?? '';
    $funding_source = $_POST['funding_source'] ?? '';
    $allergies = $_POST['allergies'] ?? '';

    $student_proof_path = '';
    if ($is_student == 'Yes' && isset($_FILES['student_proof']) && $_FILES['student_proof']['error'] == UPLOAD_ERR_OK) {
        $filename = time() . '_proof_' . basename($_FILES['student_proof']['name']);
        $target_path = 'uploads/' . $filename;
        if (move_uploaded_file($_FILES['student_proof']['tmp_name'], $target_path)) {
            $student_proof_path = $target_path;
        }
    }
    
    if (isset($_SESSION['participant_id'])) {
        $stmt = $conn->prepare("UPDATE participants SET title=?, gender=?, institution=?, org_type=?, country=?, attendance=?, funding=?, funding_source=?, allergies=? WHERE id=?");
        if (!$stmt) {
            die("Database Error in information.php (Update participants): " . $conn->error . ". Harap pastikan tabel participants di hosting sudah memiliki kolom baru (title, gender, dll). Hapus tabel lama dan import ulang ictb26.sql.");
        }
        $stmt->bind_param("sssssssssi", $title, $gender, $organization, $org_type, $country, $attendance, $funding, $funding_source, $allergies, $_SESSION['participant_id']);
        $stmt->execute();
        
        if ($student_proof_path != '') {
            $stmt_proof = $conn->prepare("UPDATE participants SET bukti_diri = ? WHERE id = ?");
            if (!$stmt_proof) {
                die("Database Error in information.php (Update bukti_diri): " . $conn->error);
            }
            $stmt_proof->bind_param("si", $student_proof_path, $_SESSION['participant_id']);
            $stmt_proof->execute();
        }
    }
    
    if ($is_participant_only) {
        header("Location: Confirmation.php?type=participant");
        exit();
    } else {
        header("Location: application.php?type=" . urlencode($participant_type));
        exit();
    }
}
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
.info-form-group {
    margin-bottom: 15px;
}
.info-form-label {
    display: block;
    font-size: 12px;
    color: #555;
    margin-bottom: 5px;
}
.info-form-control {
    width: 100%;
    border: 1px solid #ccc;
    padding: 6px 10px;
    font-size: 13px;
    border-radius: 2px;
    box-sizing: border-box;
}
.info-form-control:focus {
    border-color: #1a73e8;
    outline: none;
}
.info-radio-group {
    display: flex;
    gap: 30px;
    font-size: 13px;
    color: #333;
}
.info-radio-label {
    display: flex;
    align-items: center;
    font-weight: normal;
    margin: 0;
    cursor: pointer;
}
.info-radio-label input {
    margin-right: 8px;
    margin-top: 0;
}
.btn-update {
    background: #f8f9fa;
    border: 1px solid #ced4da;
    color: #212529;
    padding: 4px 12px;
    font-size: 12px;
    cursor: pointer;
    border-radius: 2px;
}
.btn-update:hover {
    background: #e2e6ea;
}
</style>

<section class="section-padding bg-alt" style="min-height: 80vh; padding-top: 120px;">
    <div class="container" style="max-width: 1000px; background: #fff; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        
        <div style="display: flex; align-items: center; margin-bottom: 30px;">
            <div style="width: 4px; height: 24px; background-color: #1a73e8; margin-right: 10px;"></div>
            <h2 style="font-family: var(--font-subheading); color: #333; font-size: 22px; margin: 0; font-weight: bold;">
                Information Form for: 5ICTB-OR-0075
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
                <div class="wizard-step-name">Application</div>
                <div class="wizard-step-dot"></div>
            </div>
            <?php endif; ?>
            <div class="wizard-step">
                <div class="wizard-step-name">Confirmation</div>
                <div class="wizard-step-dot"></div>
            </div>
        </div>

        <div class="info-alert">
            Information entered does not conform with the required format, and needs to be changed.
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset class="info-fieldset">
                <legend class="info-legend">Other Information</legend>
                
                <div class="info-form-group">
                    <label class="info-form-label" for="organization">Organization</label>
                    <input type="text" id="organization" name="organization" class="info-form-control" placeholder="Affiliated Organization" value="<?php echo htmlspecialchars($existing_data['institution'] ?? ''); ?>">
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="org_type">Organization type</label>
                    <select id="org_type" name="org_type" class="info-form-control">
                        <option value="Government" <?php echo (isset($existing_data['org_type']) && $existing_data['org_type'] == 'Government') ? 'selected' : ''; ?>>Government</option>
                        <option value="Non-government" <?php echo (isset($existing_data['org_type']) && $existing_data['org_type'] == 'Non-government') ? 'selected' : ''; ?>>Non-government</option>
                        <option value="Private company" <?php echo (isset($existing_data['org_type']) && $existing_data['org_type'] == 'Private company') ? 'selected' : ''; ?>>Private company</option>
                        <option value="Academic institution" <?php echo (isset($existing_data['org_type']) && $existing_data['org_type'] == 'Academic institution') ? 'selected' : ''; ?>>Academic institution</option>
                        <option value="Others" <?php echo (isset($existing_data['org_type']) && $existing_data['org_type'] == 'Others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="title">Title</label>
                    <select id="title" name="title" class="info-form-control">
                        <option value="Mr." <?php echo (isset($existing_data['title']) && $existing_data['title'] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                        <option value="Ms." <?php echo (isset($existing_data['title']) && $existing_data['title'] == 'Ms.') ? 'selected' : ''; ?>>Ms.</option>
                        <option value="Dr." <?php echo (isset($existing_data['title']) && $existing_data['title'] == 'Dr.') ? 'selected' : ''; ?>>Dr.</option>
                        <option value="Prof." <?php echo (isset($existing_data['title']) && $existing_data['title'] == 'Prof.') ? 'selected' : ''; ?>>Prof.</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="country">Country</label>
                    <select id="country" name="country" class="info-form-control">
                        <option value="">-- Select Country --</option>
                        <?php 
                        $countries_list = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"];
                        foreach ($countries_list as $c) {
                            $sel = (isset($existing_data['country']) && $existing_data['country'] == $c) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($c) . '" ' . $sel . '>' . htmlspecialchars($c) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Gender</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="gender" value="Male" <?php echo (isset($existing_data['gender']) && $existing_data['gender'] == 'Male') ? 'checked' : ''; ?>> Male
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="gender" value="Female" <?php echo (isset($existing_data['gender']) && $existing_data['gender'] == 'Female') ? 'checked' : ''; ?>> Female
                        </label>
                    </div>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Are you student?</label>
                    <?php $is_student_val = isset($_SESSION['is_student']) ? $_SESSION['is_student'] : 'No'; ?>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="is_student" value="No" <?php echo ($is_student_val == 'No') ? 'checked' : ''; ?> onclick="document.getElementById('student_upload_wrapper').style.display='none'"> No
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="is_student" value="Yes" <?php echo ($is_student_val == 'Yes') ? 'checked' : ''; ?> onclick="document.getElementById('student_upload_wrapper').style.display='block'"> Yes
                        </label>
                    </div>
                </div>

                <div class="info-form-group" id="student_upload_wrapper" style="display: <?php echo ($is_student_val == 'Yes') ? 'block' : 'none'; ?>; margin-top: 10px; margin-bottom: 20px;">
                    <label class="info-form-label" for="student_proof" style="color: #555;">If "Yes", Provide your scanned-copy of student identification or other identification as proof (max. 300 Kb)</label>
                    <input type="file" id="student_proof" name="student_proof" class="info-form-control" style="border: 1px solid #ccc; padding: 5px; background: #f9f9f9;">
                    <?php if(!empty($existing_data['bukti_diri'])): ?>
                        <div style="font-size: 11px; margin-top: 5px;">Current file: <a href="<?php echo htmlspecialchars($existing_data['bukti_diri']); ?>" target="_blank">View Proof</a></div>
                    <?php endif; ?>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">How do you plan to attend the conference?</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="attendance" value="Offline" <?php echo (!isset($existing_data['attendance']) || $existing_data['attendance'] == 'Offline') ? 'checked' : ''; ?>> Offline in Bogor, Indonesia
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="attendance" value="Online" <?php echo (isset($existing_data['attendance']) && $existing_data['attendance'] == 'Online') ? 'checked' : ''; ?>> Online
                        </label>
                    </div>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Do you have funding support for attending this conference?</label>
                    <?php $funding_val = isset($existing_data['funding']) ? $existing_data['funding'] : 'Yes'; ?>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="funding" value="No" <?php echo ($funding_val == 'No') ? 'checked' : ''; ?> onclick="document.getElementById('funding_source_wrapper').style.display='none'"> No
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="funding" value="Yes" <?php echo ($funding_val == 'Yes') ? 'checked' : ''; ?> onclick="document.getElementById('funding_source_wrapper').style.display='block'"> Yes
                        </label>
                    </div>
                </div>

                <div class="info-form-group" id="funding_source_wrapper" style="display: <?php echo ($funding_val == 'Yes') ? 'block' : 'none'; ?>;">
                    <label class="info-form-label" for="funding_source">If 'Yes', from where?</label>
                    <input type="text" id="funding_source" name="funding_source" class="info-form-control" placeholder="Funding support" value="<?php echo htmlspecialchars($existing_data['funding_source'] ?? ''); ?>">
                </div>

                <div class="info-form-group" style="margin-bottom: 10px;">
                    <label class="info-form-label" for="allergies">Do you have any food or beverage allergies? If 'Yes', please state here:</label>
                    <input type="text" id="allergies" name="allergies" class="info-form-control" placeholder="Food or beverage allergies" value="<?php echo htmlspecialchars($existing_data['allergies'] ?? ''); ?>">
                </div>

            </fieldset>

            <button type="submit" class="btn-update">Update Data</button>
        </form>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
