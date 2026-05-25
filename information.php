<?php
$participant_type = isset($_GET['type']) ? $_GET['type'] : 'author';
$is_participant_only = (strtolower($participant_type) == 'participant');
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

        <?php
        $form_action = $is_participant_only ? 'Confirmation.php?type=participant' : 'application.php?type=' . urlencode($participant_type);
        ?>
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            <fieldset class="info-fieldset">
                <legend class="info-legend">Other Information</legend>
                
                <div class="info-form-group">
                    <label class="info-form-label" for="organization">Organization</label>
                    <input type="text" id="organization" name="organization" class="info-form-control" placeholder="Affiliated Organization">
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="org_type">Organization type</label>
                    <select id="org_type" name="org_type" class="info-form-control">
                        <option value="Government">Government</option>
                        <option value="Non-government">Non-government</option>
                        <option value="Private company">Private company</option>
                        <option value="Academic institution">Academic institution</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="title">Title</label>
                    <select id="title" name="title" class="info-form-control">
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Prof.">Prof.</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label" for="country">Country</label>
                    <select id="country" name="country" class="info-form-control">
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Brunei">Brunei</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cabo Verde">Cabo Verde</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czechia">Czechia</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Eswatini">Eswatini</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Greece">Greece</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Laos">Laos</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libya">Libya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="North Korea">North Korea</option>
                        <option value="North Macedonia">North Macedonia</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestine State">Palestine State</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russia</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Korea">South Korea</option>
                        <option value="South Sudan">South Sudan</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syria</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-Leste">Timor-Leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States of America">United States of America</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Gender</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="gender" value="Male"> Male
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="gender" value="Female"> Female
                        </label>
                    </div>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Are you student?</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="is_student" value="No" onclick="document.getElementById('student_upload_wrapper').style.display='none'"> No
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="is_student" value="Yes" onclick="document.getElementById('student_upload_wrapper').style.display='block'"> Yes
                        </label>
                    </div>
                </div>

                <div class="info-form-group" id="student_upload_wrapper" style="display: none; margin-top: 10px; margin-bottom: 20px;">
                    <label class="info-form-label" for="student_proof" style="color: #555;">If "Yes", Provide your scanned-copy of student identification or other identification as proof (max. 300 Kb)</label>
                    <input type="file" id="student_proof" name="student_proof" class="info-form-control" style="border: 1px solid #ccc; padding: 5px; background: #f9f9f9;">
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">How do you plan to attend the conference?</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="attendance" value="Offline" checked> Offline in Bogor, Indonesia
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="attendance" value="Online"> Online
                        </label>
                    </div>
                </div>

                <div class="info-form-group">
                    <label class="info-form-label">Do you have funding support for attending this conference?</label>
                    <div class="info-radio-group">
                        <label class="info-radio-label">
                            <input type="radio" name="funding" value="No" onclick="document.getElementById('funding_source_wrapper').style.display='none'"> No
                        </label>
                        <label class="info-radio-label">
                            <input type="radio" name="funding" value="Yes" checked onclick="document.getElementById('funding_source_wrapper').style.display='block'"> Yes
                        </label>
                    </div>
                </div>

                <div class="info-form-group" id="funding_source_wrapper">
                    <label class="info-form-label" for="funding_source">If 'Yes', from where?</label>
                    <input type="text" id="funding_source" name="funding_source" class="info-form-control" placeholder="Funding support">
                </div>

                <div class="info-form-group" style="margin-bottom: 10px;">
                    <label class="info-form-label" for="allergies">Do you have any food or beverage allergies? If 'Yes', please state here:</label>
                    <input type="text" id="allergies" name="allergies" class="info-form-control" placeholder="Food or beverage allergies">
                </div>

            </fieldset>

            <button type="submit" class="btn-update">Update Data</button>
        </form>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
