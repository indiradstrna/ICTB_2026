<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['admin_edit_token'])) {
    $_SESSION['admin_edit_token'] = bin2hex(random_bytes(32));
}

$message = '';
$error = '';
$participant = null;
$application = null;
$participant_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = filter_input(INPUT_POST, 'participant_id', FILTER_VALIDATE_INT);

    if (!hash_equals($_SESSION['admin_edit_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Permintaan tidak valid. Silakan muat ulang halaman.';
    } elseif (!$participant_id) {
        $error = 'Peserta belum dipilih.';
    } else {
        $action = $_POST['action'] ?? 'update';

        if ($action === 'reset_password') {
            // Generate a temporary password and update the participant's hash
            $chars        = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789@#!';
            $temp_pass    = '';
            for ($i = 0; $i < 10; $i++) {
                $temp_pass .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $temp_hash = password_hash($temp_pass, PASSWORD_DEFAULT);

            $rp_stmt = $conn->prepare('UPDATE participants SET password_hash = ? WHERE id = ?');
            $rp_stmt->bind_param('si', $temp_hash, $participant_id);
            $rp_stmt->execute();
            $rp_stmt->close();

            $message = 'PASSWORD_RESET::' . $temp_pass;

        } elseif ($action === 'update') {
            $allowed_types = ['author', 'participant'];
            $participant_type = in_array($_POST['participant_type'] ?? '', $allowed_types, true) ? $_POST['participant_type'] : 'participant';
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $institution = trim($_POST['institution'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $gender = trim($_POST['gender'] ?? '');
            $org_type = trim($_POST['org_type'] ?? '');
            $country = trim($_POST['country'] ?? '');
            $attendance = trim($_POST['attendance'] ?? '');
            $funding = trim($_POST['funding'] ?? '');
            $funding_source = trim($_POST['funding_source'] ?? '');
            $allergies = trim($_POST['allergies'] ?? '');
            $application_type = in_array($_POST['application_type'] ?? '', ['Oral', 'Poster'], true) ? $_POST['application_type'] : 'Oral';
            $app_title       = trim($_POST['app_title'] ?? '');
            $app_subtheme    = trim($_POST['app_subtheme'] ?? '');
            $app_keywords    = trim($_POST['app_keywords'] ?? '');
            $app_publication = trim($_POST['app_publication'] ?? '');

            if ($first_name === '' || $last_name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Nama depan, nama belakang, dan email yang valid wajib diisi.';
            }

            $file_fields = [
                'payment_receipt' => ['column' => 'bukti_transfer', 'prefix' => 'receipt'],
                'student_proof' => ['column' => 'bukti_diri', 'prefix' => 'proof'],
            ];
            $application_file_fields = [
                'abstract_file' => ['column' => 'abstract', 'prefix' => 'abstract'],
                'ppt_file' => ['column' => 'ppt_file', 'prefix' => 'ppt'],
            ];
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'ppt', 'pptx'];
            $max_file_size = 20 * 1024 * 1024;
            $uploaded_files = [];

            foreach (array_merge($file_fields, $application_file_fields) as $input_name => $file_config) {
                if (!isset($_FILES[$input_name]) || $_FILES[$input_name]['error'] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                if ($_FILES[$input_name]['error'] !== UPLOAD_ERR_OK) {
                    $error = 'File ' . $input_name . ' gagal diunggah.';
                    break;
                }
                if ($_FILES[$input_name]['size'] > $max_file_size) {
                    $error = 'Ukuran setiap file maksimal 20 MB.';
                    break;
                }
                $extension = strtolower(pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $allowed_extensions, true)) {
                    $error = 'Format file harus JPG, PNG, PDF, Word, atau PowerPoint.';
                    break;
                }
                $uploaded_files[$input_name] = [
                    'column' => $file_config['column'],
                    'prefix' => $file_config['prefix'],
                    'extension' => $extension,
                    'temporary_name' => $_FILES[$input_name]['tmp_name'],
                ];
            }

            if ($error === '') {
                $duplicate_stmt = $conn->prepare('SELECT id FROM participants WHERE email = ? AND id <> ? LIMIT 1');
                $duplicate_stmt->bind_param('si', $email, $participant_id);
                $duplicate_stmt->execute();
                $duplicate_result = $duplicate_stmt->get_result();
                if ($duplicate_result->num_rows > 0) {
                    $error = 'Email tersebut sudah dipakai peserta lain.';
                }
                $duplicate_stmt->close();
            }

            if ($error === '') {
                $stmt = $conn->prepare('UPDATE participants SET participant_type=?, first_name=?, last_name=?, email=?, phone=?, institution=?, title=?, gender=?, org_type=?, country=?, attendance=?, funding=?, funding_source=?, allergies=? WHERE id=?');
                $stmt->bind_param('ssssssssssssssi', $participant_type, $first_name, $last_name, $email, $phone, $institution, $title, $gender, $org_type, $country, $attendance, $funding, $funding_source, $allergies, $participant_id);
                $stmt->execute();
                $stmt->close();

                $application_stmt = $conn->prepare('SELECT * FROM applications WHERE participant_id = ? ORDER BY id ASC LIMIT 1');
                $application_stmt->bind_param('i', $participant_id);
                $application_stmt->execute();
                $application_result = $application_stmt->get_result();
                $application = $application_result->fetch_assoc() ?: null;
                $application_stmt->close();

                $application_columns = [];
                $columns_result = $conn->query('SHOW COLUMNS FROM applications');
                while ($column = $columns_result->fetch_assoc()) {
                    $application_columns[] = $column['Field'];
                }

                if ($application) {
                    // Selalu update semua field abstrak; gunakan nilai DB jika form dikosongkan
                    $upd_title       = $app_title !== ''       ? $app_title       : ($application['title'] ?? '');
                    $upd_subtheme    = $app_subtheme !== ''    ? $app_subtheme    : ($application['subtheme_id'] ?? '');
                    $upd_keywords    = $app_keywords !== ''    ? $app_keywords    : ($application['keyword'] ?? '');
                    $upd_publication = $app_publication !== '' ? $app_publication : ($application['publication_id'] ?? '');
                    $type_stmt = $conn->prepare('UPDATE applications SET apptype_id=?, title=?, subtheme_id=?, keyword=?, publication_id=? WHERE id=?');
                    $type_stmt->bind_param('ssssi', $application_type, $upd_title, $upd_subtheme, $upd_keywords, $upd_publication, $application['id']);
                    $type_stmt->execute();
                    $type_stmt->close();
                }

                $has_abstract_upload = isset($uploaded_files['abstract_file']);
                $has_ppt_upload = isset($uploaded_files['ppt_file']);
                if (!$application && ($has_abstract_upload || $has_ppt_upload)) {
                    if (!in_array('abstract', $application_columns, true)) {
                        $error = 'Kolom abstract tidak tersedia pada tabel applications.';
                    } elseif ($has_ppt_upload && !in_array('ppt_file', $application_columns, true)) {
                        $error = 'Kolom ppt_file belum tersedia pada tabel applications. Abstract tetap bisa diunggah tanpa file PPT.';
                    } else {
                        // Gunakan nilai dari form jika ada, jangan pakai dummy
                        $new_title       = $app_title !== '' ? $app_title : '-';
                        $new_subtheme    = $app_subtheme !== '' ? $app_subtheme : '-';
                        $new_publication = $app_publication !== '' ? $app_publication : '-';
                        $new_keyword     = '';
                        $new_firstsubmit = 0;
                        $create_application = $conn->prepare('INSERT INTO applications (participant_id, apptype_id, subtheme_id, title, abstract, keyword, firstsubmit, publication_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                        $create_application->bind_param('isssssis', $participant_id, $application_type, $new_subtheme, $new_title, $new_keyword, $new_keyword, $new_firstsubmit, $new_publication);
                        if ($create_application->execute()) {
                            $application = ['id' => $conn->insert_id];
                        } else {
                            $error = 'Aplikasi tidak dapat dibuat: ' . $create_application->error;
                        }
                        $create_application->close();
                    }
                }

                foreach ($uploaded_files as $input_name => $file_data) {
                    if (in_array($file_data['column'], ['abstract', 'ppt_file'], true)) {
                        if (!$application) {
                            $error = 'Data aplikasi peserta belum dapat dibuat.';
                            break;
                        }
                        if (!in_array($file_data['column'], $application_columns, true)) {
                            $error = 'Kolom ' . $file_data['column'] . ' belum tersedia pada tabel applications.';
                            break;
                        }
                    }

                    $filename = date('YmdHis') . '_' . $file_data['prefix'] . '_' . bin2hex(random_bytes(4)) . '.' . $file_data['extension'];
                    $relative_path = 'uploads/' . $filename;
                    $absolute_path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative_path);
                    if (!move_uploaded_file($file_data['temporary_name'], $absolute_path)) {
                        $error = 'File ' . $input_name . ' tidak dapat disimpan ke folder uploads.';
                        break;
                    }

                    if (in_array($file_data['column'], ['abstract', 'ppt_file'], true)) {
                        $file_stmt = $conn->prepare('UPDATE applications SET ' . $file_data['column'] . ' = ? WHERE id = ?');
                        $file_stmt->bind_param('si', $relative_path, $application['id']);
                    } else {
                        $file_stmt = $conn->prepare('UPDATE participants SET ' . $file_data['column'] . ' = ? WHERE id = ?');
                        $file_stmt->bind_param('si', $relative_path, $participant_id);
                    }
                    $file_stmt->execute();
                    $file_stmt->close();
                }

                if ($error === '') {
                    $message = 'Data peserta berhasil diperbarui.';
                }
            }
        }
    }
}

if ($participant_id) {
    $stmt = $conn->prepare('SELECT * FROM participants WHERE id = ?');
    $stmt->bind_param('i', $participant_id);
    $stmt->execute();
    $participant = $stmt->get_result()->fetch_assoc() ?: null;
    $stmt->close();

    if ($participant) {
        $application_stmt = $conn->prepare('SELECT * FROM applications WHERE participant_id = ? ORDER BY id ASC LIMIT 1');
        $application_stmt->bind_param('i', $participant_id);
        $application_stmt->execute();
        $application = $application_stmt->get_result()->fetch_assoc() ?: null;
        $application_stmt->close();
    }
}

$search_results = [];
$search_term = trim($_GET['search'] ?? '');
if ($search_term !== '') {
    $like_term = '%' . $search_term . '%';
    $search_stmt = $conn->prepare('SELECT id, first_name, last_name, email, participant_type FROM participants WHERE email LIKE ? OR first_name LIKE ? OR last_name LIKE ? ORDER BY id DESC LIMIT 30');
    $search_stmt->bind_param('sss', $like_term, $like_term, $like_term);
    $search_stmt->execute();
    $search_results = $search_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $search_stmt->close();
}

// Fetch themes & subthemes for the form dropdowns
$themes_data = [];
$subthemes_data = [];
$tr = $conn->query('SELECT * FROM themes ORDER BY id ASC');
if ($tr) { while ($row = $tr->fetch_assoc()) { $themes_data[] = $row; } }
$sr = $conn->query('SELECT * FROM subthemes ORDER BY id ASC');
if ($sr) { while ($row = $sr->fetch_assoc()) {
    if (!isset($subthemes_data[$row['id_theme']])) { $subthemes_data[$row['id_theme']] = []; }
    $subthemes_data[$row['id_theme']][] = $row;
} }

include 'includes/header.php';
?>

<div class="admin-container" style="padding: 120px 20px 50px; min-height: 80vh; background-color: #f8f9fa;">
    <div class="container" style="max-width: 1100px;">
        <h2 class="admin-title" style="font-family: 'Oswald', sans-serif; color: #333;">UPDATE PESERTA</h2>

        <?php
        $reset_plain_pass = '';
        if ($message && strpos($message, 'PASSWORD_RESET::') === 0) {
            $reset_plain_pass = substr($message, strlen('PASSWORD_RESET::'));
            $message = ''; // suppress generic green bar; we show a custom box
        }
        ?>
        <?php if ($reset_plain_pass): ?>
            <div style="background:#fff3cd;border:1px solid #ffc107;color:#7d5a00;padding:20px;margin:15px 0;border-radius:6px;">
                <strong>✅ Password berhasil direset!</strong><br>
                Salin password sementara di bawah ini dan kirimkan ke peserta melalui email:
                <div style="display:flex;align-items:center;gap:10px;margin-top:12px;">
                    <input type="text" id="tmp_pass_box" value="<?php echo htmlspecialchars($reset_plain_pass); ?>"
                        readonly
                        style="flex:1;padding:10px 14px;font-size:15px;font-family:monospace;border:1px solid #ffc107;border-radius:4px;background:#fffdf0;letter-spacing:1px;">
                    <button type="button"
                        onclick="navigator.clipboard.writeText(document.getElementById('tmp_pass_box').value).then(function(){this.textContent='✔ Disalin!';}.bind(this),function(){alert('Salin manual: <?php echo htmlspecialchars($reset_plain_pass); ?>');});"
                        style="padding:10px 16px;background:#ffc107;color:#000;border:0;border-radius:4px;cursor:pointer;font-weight:600;white-space:nowrap;">
                        📋 Salin Password
                    </button>
                </div>
                <p style="margin:12px 0 0;font-size:13px;color:#856404;">
                    📧 <strong>Template email siap pakai:</strong><br>
<?php
$_cp_login    = 'https://ictb.biotrop.org/login.php';
$_cp_chgpwd   = 'https://ictb.biotrop.org/change_password.php';
$_cp_name     = htmlspecialchars(trim(($participant['first_name'] ?? '') . ' ' . ($participant['last_name'] ?? '')));
$_cp_tmppass  = htmlspecialchars($reset_plain_pass);
?>
                    <textarea rows="22" readonly style="width:100%;box-sizing:border-box;margin-top:6px;padding:10px;font-size:12px;font-family:monospace;border:1px solid #ffc107;border-radius:4px;background:#fffdf0;resize:vertical;">Dear <?php echo $_cp_name; ?>,

We have reset your ICTB 2026 Conference portal password as requested. Please follow the steps below to regain access and set your own password.

Your Temporary Password: <?php echo $_cp_tmppass; ?>


STEPS TO SET YOUR NEW PASSWORD:

  1. Open the following link in your browser:
     <?php echo $_cp_chgpwd; ?>

  2. Fill in the form:
     - Email Address      : (your registered email)
     - Current Password   : <?php echo $_cp_tmppass; ?>
       (this is the temporary password above)
     - New Password       : (choose a password, min. 8 characters)
     - Confirm Password   : (repeat your new password)

  3. Click "Save New Password".

  4. Once saved, you can log in normally at:
     <?php echo $_cp_login; ?>

If you run into any trouble, feel free to reply to this email and we will assist you.

Best regards,
ICTB 2026 Secretariat
ictb@biotrop.org</textarea>
                </p>
            </div>
        <?php endif; ?>
        <?php if ($message): ?><div style="background:#d4edda;color:#155724;padding:12px;margin:15px 0;border-radius:4px;"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div style="background:#f8d7da;color:#721c24;padding:12px;margin:15px 0;border-radius:4px;"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <form method="get" style="background:#fff;padding:20px;margin:20px 0;">
            <label for="search"><strong>Cari peserta berdasarkan nama atau email</strong></label>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <input id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Nama atau email" style="flex:1;padding:10px;border:1px solid #ccc;">
                <button type="submit" style="padding:10px 18px;background:#17a2b8;color:#fff;border:0;cursor:pointer;">Cari</button>
            </div>
        </form>

        <?php if ($search_term !== ''): ?>
            <div style="background:#fff;padding:20px;margin-bottom:20px;overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <tr><th style="text-align:left;padding:8px;border-bottom:1px solid #ddd;">ID</th><th style="text-align:left;padding:8px;border-bottom:1px solid #ddd;">Nama</th><th style="text-align:left;padding:8px;border-bottom:1px solid #ddd;">Email</th><th style="padding:8px;border-bottom:1px solid #ddd;"></th></tr>
                    <?php foreach ($search_results as $row): ?>
                        <tr><td style="padding:8px;"><?php echo (int) $row['id']; ?></td><td style="padding:8px;"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td><td style="padding:8px;"><?php echo htmlspecialchars($row['email']); ?></td><td style="padding:8px;text-align:right;"><a href="admin_edit_peserta.php?id=<?php echo (int) $row['id']; ?>" style="color:#0984e3;">Pilih</a></td></tr>
                    <?php endforeach; ?>
                    <?php if (!$search_results): ?><tr><td colspan="4" style="padding:12px;">Peserta tidak ditemukan.</td></tr><?php endif; ?>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($participant): ?>
            <form method="post" enctype="multipart/form-data" style="background:#fff;padding:25px;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['admin_edit_token']); ?>">
                <input type="hidden" name="participant_id" value="<?php echo (int) $participant['id']; ?>">
                <input type="hidden" name="action" value="update">
                <h3 style="margin-top:0;">Peserta #<?php echo (int) $participant['id']; ?></h3>
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px;">
                    <?php
                    $fields = [
                        'first_name' => 'Nama depan', 'last_name' => 'Nama belakang', 'email' => 'Email', 'phone' => 'Telepon',
                        'institution' => 'Institusi', 'title' => 'Gelar', 'gender' => 'Gender', 'org_type' => 'Jenis organisasi',
                        'country' => 'Negara', 'attendance' => 'Kehadiran', 'funding' => 'Funding', 'funding_source' => 'Sumber funding', 'allergies' => 'Alergi'
                    ];
                    foreach ($fields as $field => $label): ?>
                        <label><?php echo $label; ?><input type="text" name="<?php echo $field; ?>" value="<?php echo htmlspecialchars($participant[$field] ?? ''); ?>" style="display:block;width:100%;box-sizing:border-box;padding:9px;margin-top:5px;border:1px solid #ccc;"></label>
                    <?php endforeach; ?>
                    <label>Jenis peserta<select name="participant_type" style="display:block;width:100%;padding:9px;margin-top:5px;border:1px solid #ccc;"><option value="participant" <?php echo ($participant['participant_type'] ?? '') === 'participant' ? 'selected' : ''; ?>>Participant</option><option value="author" <?php echo ($participant['participant_type'] ?? '') === 'author' ? 'selected' : ''; ?>>Author</option></select></label>
                </div>

                <h3 style="margin:30px 0 8px;">Data Abstrak / Aplikasi</h3>
                <div style="background:#fffbe6;border:1px solid #ffe08a;padding:20px;border-radius:4px;">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:15px;">
                        <label style="grid-column:1/-1;">Judul Abstrak / Paper
                            <input type="text" name="app_title" value="<?php echo htmlspecialchars($application['title'] ?? ''); ?>" style="display:block;width:100%;box-sizing:border-box;padding:9px;margin-top:5px;border:1px solid #ccc;">
                        </label>

                        <label>Theme
                            <select id="admin_theme" name="admin_theme" onchange="adminUpdateSubthemes()" style="display:block;width:100%;box-sizing:border-box;padding:9px;margin-top:5px;border:1px solid #ccc;">
                                <option value="">-- Select Theme --</option>
                                <?php foreach ($themes_data as $t):
                                    $sel_theme = false;
                                    if (!empty($application['subtheme_id'])) {
                                        foreach ($subthemes_data as $tid => $st_arr) {
                                            foreach ($st_arr as $st) {
                                                if ($st['sub_theme'] === $application['subtheme_id'] && $tid == $t['id']) {
                                                    $sel_theme = true;
                                                }
                                            }
                                        }
                                    }
                                ?>
                                    <option value="<?php echo htmlspecialchars($t['theme']); ?>" data-id="<?php echo $t['id']; ?>" <?php echo $sel_theme ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($t['theme']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <label>Sub-Theme
                            <select id="admin_sub_theme" name="app_subtheme" style="display:block;width:100%;box-sizing:border-box;padding:9px;margin-top:5px;border:1px solid #ccc;">
                                <option value="">-- Select Sub-Theme --</option>
                                <?php if (!empty($application['subtheme_id'])): ?>
                                    <option value="<?php echo htmlspecialchars($application['subtheme_id']); ?>" selected>
                                        <?php echo htmlspecialchars($application['subtheme_id']); ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </label>

                        <label>Keywords <small style="color:#888;font-weight:normal;">(pisahkan dengan koma)</small>
                            <input type="text" name="app_keywords" value="<?php echo htmlspecialchars($application['keyword'] ?? ''); ?>" placeholder="contoh: tropical, biodiversity, ecology" style="display:block;width:100%;box-sizing:border-box;padding:9px;margin-top:5px;border:1px solid #ccc;">
                        </label>

                        <label style="grid-column:1/-1;">Publikasi
                            <?php
                            $pub_options = [
                                'Program book (abstract only) - free',
                                'ICTB proceeding book (ISBN) - IDR 800,000 / USD 80',
                                'Scopus-indexed proceedings - IDR 3,000,000',
                                'Sinta accredited journal - To be determined by the journal',
                                'In selected Scopus-indexed journals - To be determined by the journal',
                            ];
                            $cur_pub = $application['publication_id'] ?? '';
                            ?>
                            <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px;font-weight:normal;">
                                <?php foreach ($pub_options as $po): ?>
                                    <label style="display:flex;align-items:center;gap:8px;font-weight:normal;cursor:pointer;">
                                        <input type="radio" name="app_publication" value="<?php echo htmlspecialchars($po); ?>" <?php echo ($cur_pub === $po) ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($po); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </label>
                    </div>
                </div>

                <h3 style="margin:25px 0 12px;">Upload file</h3>
                <p style="font-size:13px;color:#666;">Format: JPG, PNG, PDF, Word, atau PowerPoint. Maksimal 20 MB per file.</p>
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px;">
                    <label>Jenis aplikasi<select name="application_type" style="display:block;width:100%;padding:9px;margin-top:7px;border:1px solid #ccc;"><option value="Oral" <?php echo (($application['apptype_id'] ?? 'Oral') === 'Oral') ? 'selected' : ''; ?>>Oral</option><option value="Poster" <?php echo (($application['apptype_id'] ?? '') === 'Poster') ? 'selected' : ''; ?>>Poster</option></select></label>
                    <label>Bukti pembayaran<input type="file" name="payment_receipt" style="display:block;margin-top:7px;"><?php if (!empty($participant['bukti_transfer'])): ?><small>File saat ini: <a href="<?php echo htmlspecialchars($participant['bukti_transfer']); ?>" target="_blank">Lihat</a></small><?php endif; ?></label>
                    <label>Bukti mahasiswa<input type="file" name="student_proof" style="display:block;margin-top:7px;"><?php if (!empty($participant['bukti_diri'])): ?><small>File saat ini: <a href="<?php echo htmlspecialchars($participant['bukti_diri']); ?>" target="_blank">Lihat</a></small><?php endif; ?></label>
                    <label>Abstract<input type="file" name="abstract_file" style="display:block;margin-top:7px;"><?php if (!empty($application['abstract'] ?? '')): ?><small>File saat ini: <a href="<?php echo htmlspecialchars($application['abstract']); ?>" target="_blank">Lihat</a></small><?php else: ?><small>Belum ada file. Upload baru akan membuat data aplikasi otomatis.</small><?php endif; ?></label>
                    <label>PPT<?php if ($application): ?><input type="file" name="ppt_file" style="display:block;margin-top:7px;"><?php if (!empty($application['ppt_file'] ?? '')): ?><small>File saat ini: <a href="<?php echo htmlspecialchars($application['ppt_file']); ?>" target="_blank">Lihat</a></small><?php endif; ?><?php else: ?><small>Upload abstract terlebih dahulu agar data aplikasi dibuat.</small><?php endif; ?></label>
                </div>
                <button type="submit" style="margin-top:25px;padding:11px 20px;background:#17a2b8;color:#fff;border:0;cursor:pointer;">Simpan perubahan</button>

            </form>

            <!-- ===== RESET PASSWORD SECTION ===== -->
            <div style="margin-top:20px;background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:20px;">
                <h3 style="margin:0 0 8px;font-size:15px;color:#495057;">🔐 Reset Password Peserta</h3>
                <p style="font-size:13px;color:#6c757d;margin:0 0 14px;">Gunakan fitur ini jika peserta lupa password dan tidak bisa reset sendiri. Sistem akan men-generate password sementara yang bisa kamu copy dan kirim manual ke peserta.</p>
                <form method="post" onsubmit="return confirm('Reset password untuk peserta ini? Password lama tidak dapat dipakai lagi.');">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['admin_edit_token']); ?>">
                    <input type="hidden" name="participant_id" value="<?php echo (int) $participant['id']; ?>">
                    <input type="hidden" name="action" value="reset_password">
                    <button type="submit" style="padding:10px 20px;background:#dc3545;color:#fff;border:0;border-radius:4px;cursor:pointer;font-weight:600;">🔄 Generate & Reset Password Sementara</button>
                </form>
            </div>
        <?php elseif ($participant_id): ?>
            <div style="background:#fff;padding:20px;">Peserta dengan ID tersebut tidak ditemukan.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
var adminSubthemesMap = <?php echo json_encode($subthemes_data); ?>;

function adminUpdateSubthemes(initialVal) {
    var themeSelect = document.getElementById('admin_theme');
    var subthemeSelect = document.getElementById('admin_sub_theme');
    if (!themeSelect || !subthemeSelect) return;

    var selectedOption = themeSelect.options[themeSelect.selectedIndex];
    var themeId = selectedOption ? selectedOption.getAttribute('data-id') : null;

    subthemeSelect.innerHTML = '<option value="">-- Select Sub-Theme --</option>';

    if (themeId && adminSubthemesMap[themeId]) {
        adminSubthemesMap[themeId].forEach(function(st) {
            var opt = document.createElement('option');
            opt.value = st.sub_theme;
            opt.textContent = st.sub_theme;
            if (initialVal && st.sub_theme === initialVal) {
                opt.selected = true;
            }
            subthemeSelect.appendChild(opt);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var existingSub = '<?php echo isset($application['subtheme_id']) ? addslashes($application['subtheme_id']) : ''; ?>';
    if (existingSub) {
        adminUpdateSubthemes(existingSub);
    }
});
</script>
