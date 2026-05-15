<?php
// Dynamic Pricing Logic based on Registration Type (Indonesian Participants)
$participant_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'Author'; // 'Author', 'Participant', 'Exhibitor'
$participant_category = isset($_REQUEST['category']) ? $_REQUEST['category'] : 'General'; // Default to 'General' instead of 'Student'
$is_early_bird = isset($_REQUEST['earlybird']) ? filter_var($_REQUEST['earlybird'], FILTER_VALIDATE_BOOLEAN) : true;

// Get publication type from POST (from application.php) or fallback to GET/default
$publication_type = isset($_POST['publication']) ? $_POST['publication'] : (isset($_GET['pub']) ? $_GET['pub'] : 'ICTB proceeding book (ISBN)');

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

if ($publication_type == 'Scopus-indexed proceedings') {
    $publication_fee = 2500000;
    $pub_fee_label = "IDR " . number_format($publication_fee, 0, ',', ',');
} elseif ($publication_type == 'ICTB proceeding book (ISBN)' || $publication_type == 'Program book and proceeding (full paper) - Rp. 800.000 / USD 80') {
    $publication_fee = 800000;
    $pub_fee_label = "IDR " . number_format($publication_fee, 0, ',', ',');
} elseif (strpos(strtolower($publication_type), 'free') !== false || $publication_type == 'Program book (abstract only) - free') {
    $publication_fee = 0;
    $pub_fee_label = "Free";
}

$total_payment = $participation_fee + $publication_fee;
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
            <div class="wizard-step">
                <div class="wizard-step-name active">Application</div>
                <div class="wizard-step-dot active"></div>
            </div>
            <div class="wizard-step">
                <div class="wizard-step-name active">Confirmation</div>
                <div class="wizard-step-dot active"></div>
            </div>
        </div>

        <div class="info-alert">
            Summary of all the information that you have entered earlier. Please make sure all information shown are correct before clicking on Confirmation Button.
        </div>

        <fieldset class="info-fieldset">
            <legend class="info-legend">Registrant Information</legend>
            <div class="summary-line"><span class="summary-label">Registration ID:</span> <span class="summary-val">5ICTB-OR-0075</span></div>
            <div class="summary-line"><span class="summary-label">Fullname:</span> <span class="summary-val">Ms. Destriana, Indira</span></div>
            <div class="summary-line"><span class="summary-label">Registration Code:</span> <span class="summary-val">5ICTB-OR-0075</span></div>
            <div class="summary-line"><span class="summary-label">Email address:</span> <span class="summary-val">kunci027@gmail.com</span></div>
            <div class="summary-line"><span class="summary-label">Phone number:</span> <span class="summary-val">087711761206</span></div>
            <div class="summary-line"><span class="summary-label">Gender:</span> <span class="summary-val">Female</span></div>
            <div class="summary-line"><span class="summary-label">Organization:</span> <span class="summary-val">Telkom University (Private Company)</span></div>
            <div class="summary-line"><span class="summary-label">Country:</span> <span class="summary-val">Indonesia</span></div>
            <div class="summary-line"><span class="summary-label">Participant Type:</span> <span class="summary-val"><?php echo ucfirst(htmlspecialchars($participant_type)); ?></span></div>
            <div class="summary-line"><span class="summary-label">Participant Category:</span> <span class="summary-val"><?php echo htmlspecialchars($participant_category); ?></span> | <a href="#" style="color: #1a73e8; text-decoration: none;">Proof</a></div>
            <div class="summary-line"><span class="summary-label">Food allergies:</span> <span class="summary-val"></span></div>
        </fieldset>

        <fieldset class="info-fieldset">
            <legend class="info-legend">Application Information</legend>
            <div class="summary-line"><span class="summary-label">Application Type:</span> <span class="summary-val">Oral</span></div>
            <div class="summary-line"><span class="summary-label">Theme:</span> <span class="summary-val">Biodiversity Beyond Boundaries: Advancing Global Education, Bio-Science, and Sustainable Landscapes</span></div>
            <div class="summary-line"><span class="summary-label">Subtheme:</span> <span class="summary-val">Nature-Based Livelihoods</span></div>
            <div class="summary-line"><span class="summary-label">Title:</span> <span class="summary-val">test</span></div>
            
            <a href="#" class="btn-dark-blue">Extended Abstract File</a>
            
            <div class="summary-line" style="margin-top: 5px;"><span class="summary-label">Keywords:</span></div>
            <div class="summary-line"><span class="summary-val">test</span></div>
            
            <div class="summary-line"><span class="summary-label">Publication Type:</span> <span class="summary-val"><?php echo htmlspecialchars($publication_type); ?> - <?php echo $pub_fee_label; ?></span></div>
        </fieldset>

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
                
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="highlight-box">
                        <input type="file" name="payment_receipt" id="payment_receipt" style="font-size: 12px; background: #e9ecef; border: 1px solid #ccc; padding: 2px;">
                    </div>
                    <div>
                        <button type="submit" class="btn-yellow-submit">Submit</button>
                    </div>
                </form>
            </div>
        </fieldset>

        <button type="button" class="btn-yellow-confirm">Confirm Data</button>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
