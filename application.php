<?php
session_start();
require_once 'includes/db.php';

$is_student = isset($_SESSION['is_student']) ? $_SESSION['is_student'] : 'No';
$participant_type = isset($_GET['type']) ? $_GET['type'] : 'author';

$existing_app = [];
if (isset($_SESSION['participant_id'])) {
    $stmt = $conn->prepare("SELECT * FROM applications WHERE participant_id = ? ORDER BY id DESC LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['participant_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $existing_app = $res->fetch_assoc();
        }
        $stmt->close();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apptype_id = $_POST['application_type'] ?? '';
    $subtheme_id = $_POST['sub_theme'] ?? '';
    $title = $_POST['title'] ?? '';
    $keyword = $_POST['keywords'] ?? '';
    $firstsubmit = ($_POST['first_time'] ?? 'Yes') == 'Yes' ? 1 : 0;
    $publication_id = $_POST['publication'] ?? '';
    
    $_SESSION['publication'] = $publication_id; // Pass to Confirmation.php

    $abstract_path = '';
    if (isset($_FILES['extended_abstract']) && $_FILES['extended_abstract']['error'] == UPLOAD_ERR_OK) {
        $filename = time() . '_abstract_' . basename($_FILES['extended_abstract']['name']);
        $target_path = 'uploads/' . $filename;
        if (move_uploaded_file($_FILES['extended_abstract']['tmp_name'], $target_path)) {
            $abstract_path = $target_path;
        }
    }

    if (isset($_SESSION['participant_id'])) {
        if ($abstract_path == '' && !empty($existing_app['abstract'])) {
            $abstract_path = $existing_app['abstract'];
        }

        if (!empty($existing_app)) {
            $stmt = $conn->prepare("UPDATE applications SET apptype_id=?, subtheme_id=?, title=?, abstract=?, keyword=?, firstsubmit=?, publication_id=? WHERE id=?");
            if (!$stmt) {
                die("Database Error in application.php (Update): " . $conn->error);
            }
            $stmt->bind_param("sssssisi", $apptype_id, $subtheme_id, $title, $abstract_path, $keyword, $firstsubmit, $publication_id, $existing_app['id']);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO applications (participant_id, apptype_id, subtheme_id, title, abstract, keyword, firstsubmit, publication_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Database Error in application.php: " . $conn->error . ". Pastikan kolom apptype_id, subtheme_id, publication_id bertipe VARCHAR di tabel applications hosting Anda.");
            }
            $stmt->bind_param("isssssis", $_SESSION['participant_id'], $apptype_id, $subtheme_id, $title, $abstract_path, $keyword, $firstsubmit, $publication_id);
            $stmt->execute();
        }
    }
    
    header("Location: Confirmation.php?type=" . urlencode($participant_type));
    exit();
}

$themes_result = $conn->query("SELECT * FROM themes ORDER BY id ASC");
$themes_data = [];
while($row = $themes_result->fetch_assoc()) {
    $themes_data[] = $row;
}

$subthemes_result = $conn->query("SELECT * FROM subthemes ORDER BY id ASC");
$subthemes_data = [];
while($row = $subthemes_result->fetch_assoc()) {
    if(!isset($subthemes_data[$row['id_theme']])) {
        $subthemes_data[$row['id_theme']] = [];
    }
    $subthemes_data[$row['id_theme']][] = $row;
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
    flex-direction: column;
    gap: 10px;
    font-size: 13px;
    color: #555;
}
.info-radio-group-horizontal {
    display: flex;
    gap: 30px;
    font-size: 13px;
    color: #555;
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
.btn-submit {
    background: #17a2b8; /* Cyan color matching the image submit button */
    border: 1px solid #117a8b;
    color: #000;
    padding: 6px 16px;
    font-size: 13px;
    cursor: pointer;
    border-radius: 2px;
    font-weight: bold;
}
.btn-submit:hover {
    background: #138496;
}
.btn-dark {
    background: #343a40;
    color: #fff;
    border: none;
    padding: 8px 12px;
    font-size: 12px;
    cursor: pointer;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 10px;
    text-decoration: none;
}
.btn-dark:hover {
    background: #23272b;
    color: #fff;
}
.highlight-box {
    background: #ffff00;
    padding: 5px;
    border: 1px solid #ccc;
    display: inline-block;
    width: 100%;
    box-sizing: border-box;
}
.hint-text {
    color: #1a73e8;
    font-size: 11px;
    display: block;
    margin-bottom: 2px;
}
</style>

<section class="section-padding bg-alt" style="min-height: 80vh; padding-top: 120px;">
    <div class="container" style="max-width: 1000px; background: #fff; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

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
            <div class="wizard-step">
                <div class="wizard-step-name active">Application</div>
                <div class="wizard-step-dot active"></div>
            </div>
            <div class="wizard-step">
                <div class="wizard-step-name">Confirmation</div>
                <div class="wizard-step-dot"></div>
            </div>
        </div>

        <div class="info-alert">
            Please fill in the form. All fields are required. When you are ready to submit, please check that all fields are filled. A red border indicates that the information entered does not conform with the required format, and needs to be changed.
        </div>

        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateAbstractForm()">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($participant_type); ?>">
            <input type="hidden" name="category" value="<?php echo (strtolower($is_student) == 'yes') ? 'student' : 'General'; ?>">
            <fieldset class="info-fieldset">
                <legend class="info-legend">Application</legend>
                
                <div class="info-form-group">
                    <label class="info-form-label" for="application_type">Application type</label>
                    <select id="application_type" name="application_type" class="info-form-control">
                        <option value="Oral" <?php echo (isset($existing_app['apptype_id']) && $existing_app['apptype_id'] == 'Oral') ? 'selected' : ''; ?>>Oral</option>
                        <option value="Poster" <?php echo (isset($existing_app['apptype_id']) && $existing_app['apptype_id'] == 'Poster') ? 'selected' : ''; ?>>Poster</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="theme">Theme</label>
                    <select id="theme" name="theme" class="info-form-control" onchange="updateSubthemes()" required>
                        <option value="">Select Theme</option>
                        <?php foreach($themes_data as $t): ?>
                            <?php 
                                // Determine if this theme is selected based on the subtheme. 
                                // This is tricky because existing_app only has subtheme_id.
                                // We can use JS to pre-select, or find the theme_id of the existing subtheme in PHP.
                                $is_selected_theme = false;
                                if (!empty($existing_app['subtheme_id'])) {
                                    foreach($subthemes_data as $tid => $st_arr) {
                                        foreach($st_arr as $st) {
                                            if ($st['sub_theme'] == $existing_app['subtheme_id'] && $tid == $t['id']) {
                                                $is_selected_theme = true;
                                            }
                                        }
                                    }
                                }
                            ?>
                            <option value="<?php echo htmlspecialchars($t['theme']); ?>" data-id="<?php echo $t['id']; ?>" <?php echo $is_selected_theme ? 'selected' : ''; ?>><?php echo htmlspecialchars($t['theme']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="sub_theme">Sub-Theme</label>
                    <select id="sub_theme" name="sub_theme" class="info-form-control" required>
                        <option value="">Select Sub-Theme</option>
                        <?php if(!empty($existing_app['subtheme_id'])): ?>
                            <option value="<?php echo htmlspecialchars($existing_app['subtheme_id']); ?>" selected><?php echo htmlspecialchars($existing_app['subtheme_id']); ?></option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="title">Title</label>
                    <span class="hint-text">15 words left</span>
                    <input type="text" id="title" name="title" class="info-form-control" placeholder="Title" value="<?php echo htmlspecialchars($existing_app['title'] ?? ''); ?>" required>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Abstract</label>
                    <a href="template_abstract.docx" download class="btn-dark">Download Abstract Template</a>
                    <div class="highlight-box">
                        <input type="file" name="extended_abstract" id="extended_abstract" accept=".docx" style="font-size: 12px; background: #e9ecef; border: 1px solid #ced4da; padding: 2px;" <?php echo empty($existing_app['abstract']) ? 'required' : ''; ?>>
                    </div>
                    <?php if(!empty($existing_app['abstract'])): ?>
                        <div style="font-size: 11px; margin-top: 5px;">Current file: <a href="<?php echo htmlspecialchars($existing_app['abstract']); ?>" target="_blank">View Abstract</a></div>
                    <?php endif; ?>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="keywords">Keywords</label>
                    <span class="hint-text">(separate each keyword by comma)</span>
                    <input type="text" id="keywords" name="keywords" class="info-form-control" placeholder="Keywords" value="<?php echo htmlspecialchars($existing_app['keyword'] ?? ''); ?>" required>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Is it the first time this abstract has been submitted for publication?</label>
                    <div class="info-radio-group-horizontal">
                        <label class="info-radio-label">
                            <input type="radio" name="first_time" value="No" <?php echo (isset($existing_app['firstsubmit']) && $existing_app['firstsubmit'] == 0) ? 'checked' : ''; ?>> No
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="first_time" value="Yes" <?php echo (!isset($existing_app['firstsubmit']) || $existing_app['firstsubmit'] == 1) ? 'checked' : ''; ?>> Yes
                        </label>
                    </div>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Which publication do you prefer for your abstract & full paper?</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="publication" value="Program book (abstract only) - free" <?php echo (isset($existing_app['publication_id']) && $existing_app['publication_id'] == 'Program book (abstract only) - free') ? 'checked' : ''; ?> required> Program book (abstract only) - free
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="publication" value="ICTB proceeding book (ISBN) - IDR 800,000 / USD 80" <?php echo (isset($existing_app['publication_id']) && $existing_app['publication_id'] == 'ICTB proceeding book (ISBN) - IDR 800,000 / USD 80') ? 'checked' : ''; ?> required> ICTB proceeding book (ISBN) - IDR 800,000 / USD 80
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="publication" value="Scopus-indexed proceedings - IDR 2,500,000" <?php echo (isset($existing_app['publication_id']) && $existing_app['publication_id'] == 'Scopus-indexed proceedings - IDR 2,500,000') ? 'checked' : ''; ?> required> Scopus-indexed proceedings - IDR 2,500,000
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="publication" value="Sinta accredited journal - To be determined by the journal" <?php echo (isset($existing_app['publication_id']) && $existing_app['publication_id'] == 'Sinta accredited journal - To be determined by the journal') ? 'checked' : ''; ?> required> Sinta accredited journal - To be determined by the journal
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="publication" value="In selected Scopus-indexed journals - To be determined by the journal" <?php echo (isset($existing_app['publication_id']) && $existing_app['publication_id'] == 'In selected Scopus-indexed journals - To be determined by the journal') ? 'checked' : ''; ?> required> In selected Scopus-indexed journals - To be determined by the journal
                        </label>
                    </div>
                </div>

            </fieldset>

            <button type="submit" class="btn-submit"><?php echo !empty($existing_app) ? 'Update Data' : 'Submit'; ?></button>
        </form>

    </div>
</section>

<script>
var subthemesMap = <?php echo json_encode($subthemes_data); ?>;

function updateSubthemes(initialVal = null) {
    var themeSelect = document.getElementById('theme');
    var subthemeSelect = document.getElementById('sub_theme');
    var selectedOption = themeSelect.options[themeSelect.selectedIndex];
    var themeId = selectedOption.getAttribute('data-id');

    subthemeSelect.innerHTML = '<option value="">-- Select Topic --</option>';
    
    if (themeId && subthemesMap[themeId]) {
        var topics = subthemesMap[themeId];
        for (var i = 0; i < topics.length; i++) {
            var option = document.createElement('option');
            option.value = topics[i].sub_theme;
            option.textContent = topics[i].sub_theme;
            if (initialVal && topics[i].sub_theme == initialVal) {
                option.selected = true;
            }
            subthemeSelect.appendChild(option);
        }
    }
}

// On load, if sub_theme is already in the options and we need to populate properly without removing the selected
document.addEventListener('DOMContentLoaded', function() {
    var existingSubtheme = '<?php echo isset($existing_app['subtheme_id']) ? addslashes($existing_app['subtheme_id']) : ''; ?>';
    if (existingSubtheme) {
        updateSubthemes(existingSubtheme);
    }
});


function validateAbstractForm() {
    var fileInput = document.getElementById('extended_abstract');
    var hasExisting = <?php echo !empty($existing_app['abstract']) ? 'true' : 'false'; ?>;
    if (fileInput && fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var fileName = file.name;
        var extension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
        
        if (extension !== '.docx') {
            alert('Format file tidak didukung! Harap unggah file dengan format .docx saja.');
            fileInput.value = ''; // Reset input file
            return false;
        }
    } else if (!hasExisting) {
        alert('Harap unggah file abstrak Anda (.docx) terlebih dahulu.');
        return false;
    }
    return true;
}
</script>

<?php include 'includes/footer.php'; ?>
