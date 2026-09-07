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

        if ($action === 'update') {
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

                $application_stmt = $conn->prepare('SELECT id FROM applications WHERE participant_id = ? ORDER BY id DESC LIMIT 1');
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
                    $type_stmt = $conn->prepare('UPDATE applications SET apptype_id = ? WHERE id = ?');
                    $type_stmt->bind_param('si', $application_type, $application['id']);
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
                        $default_application_type = $application_type;
                        $default_subtheme = 'Belum diisi';
                        $default_title = 'Abstract diunggah oleh admin';
                        $default_abstract = '';
                        $default_keyword = '';
                        $default_firstsubmit = 0;
                        $default_publication = 'Belum diisi';
                        $create_application = $conn->prepare('INSERT INTO applications (participant_id, apptype_id, subtheme_id, title, abstract, keyword, firstsubmit, publication_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                        $create_application->bind_param('isssssis', $participant_id, $default_application_type, $default_subtheme, $default_title, $default_abstract, $default_keyword, $default_firstsubmit, $default_publication);
                        if ($create_application->execute()) {
                            $application = ['id' => $conn->insert_id];
                        } else {
                            $error = 'Aplikasi abstract tidak dapat dibuat: ' . $create_application->error;
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
        $application_stmt = $conn->prepare('SELECT * FROM applications WHERE participant_id = ? ORDER BY id DESC LIMIT 1');
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

include 'includes/header.php';
?>

<div class="admin-container" style="padding: 120px 20px 50px; min-height: 80vh; background-color: #f8f9fa;">
    <div class="container" style="max-width: 1100px;">
        <h2 class="admin-title" style="font-family: 'Oswald', sans-serif; color: #333;">UPDATE PESERTA</h2>

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

                <h3 style="margin:30px 0 12px;">Upload file</h3>
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
        <?php elseif ($participant_id): ?>
            <div style="background:#fff;padding:20px;">Peserta dengan ID tersebut tidak ditemukan.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>