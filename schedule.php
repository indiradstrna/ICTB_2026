<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=1000'); background-position: center 30%;">
    <div class="cover-overlay"></div>
    <div class="container page-header-content text-center reveal-up">
        <h1 class="section-title text-white">Conference Schedule</h1>
        <p class="text-white" style="font-size: 1.1rem; opacity: 0.9;">Tentative Agenda & Program Details</p>
    </div>
</section>

<!-- Schedule Section -->
<section class="section-padding" style="background-color: var(--bg-light); padding: 80px 0;">
    <div class="container">
        <div class="section-header text-center reveal-up">
            <span class="section-subtitle">Conference Program</span>
            <h2 class="section-title">Tentative Agenda</h2>
        </div>
        
        <style>
            .schedule-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border: 1px solid var(--border-color);
                margin-bottom: 24px;
                overflow: hidden;
                transition: var(--transition);
            }
            .schedule-card:hover {
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            }
            .schedule-preview {
                padding: 24px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 16px;
            }
            .schedule-preview-info h3 {
                margin-bottom: 8px;
                color: var(--primary-color);
                font-family: var(--font-heading);
                font-size: 28px;
                letter-spacing: 1px;
            }
            .schedule-preview-info .date {
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 8px;
                font-size: 16px;
            }
            .schedule-preview-info .summary {
                color: var(--text-muted);
                font-size: 14px;
                margin: 0;
            }
            .schedule-details {
                display: none;
                padding: 0 24px 24px 24px;
                border-top: 1px solid var(--border-color);
            }
            .fee-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 24px;
            }
            .fee-table th {
                background-color: var(--primary-color);
                color: white;
                padding: 12px 16px;
                font-weight: 600;
                text-align: left;
            }
            .fee-table td {
                padding: 12px 16px;
                border-bottom: 1px solid var(--border-color);
                vertical-align: top;
            }
            .fee-table tr:last-child td {
                border-bottom: none;
            }
            .parallel-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 16px;
            }
            .parallel-col {
                background: var(--bg-alt);
                padding: 12px;
                border-radius: 8px;
                font-size: 13px;
            }
            .parallel-col strong {
                display: block;
                margin-bottom: 8px;
                color: var(--primary-dark);
            }
            @media (max-width: 768px) {
                .parallel-grid {
                    grid-template-columns: 1fr;
                }
                .schedule-preview {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>

        <div class="schedule-tabs reveal-up" style="max-width: 1000px; margin: 40px auto 0;">
            <button class="tab-btn active" data-target="day1">Day 1 <span>Oct 5</span></button>
            <button class="tab-btn" data-target="day2">Day 2 <span>Oct 6</span></button>
            <button class="tab-btn" data-target="day3">Day 3 <span>Oct 7</span></button>
        </div>
        
        <div class="schedule-content reveal-up" style="max-width: 1000px; margin: 0 auto;">
            <!-- Day 1 Content -->
            <div class="schedule-pane active" id="day1">
                <div class="schedule-details" style="display: block; padding: 0; border: none;">
                    <h3 style="margin-bottom: 20px; color: var(--primary-color); text-align: center;">Monday, 5 October 2026</h3>
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Time (GMT +7)</th>
                                <th style="width: 80%;">Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>08.00 – 08.45</strong></td>
                                <td><strong>Registration</strong></td>
                            </tr>
                            <tr>
                                <td><strong>08.45 – 08.50</strong></td>
                                <td>Traditional Dance Performance</td>
                            </tr>
                            <tr>
                                <td><strong>08.50 – 08.55</strong></td>
                                <td><strong>Opening Ceremony:</strong><br>1. Indonesian National Anthem “Indonesia Raya”<br>2. SEAMEO Colours</td>
                            </tr>
                            <tr>
                                <td><strong>08.55 – 09.05</strong></td>
                                <td><strong>General Introduction</strong><br>Dr. Doni Yusri<br><span style="color:var(--text-muted);">(Scientific Committee of the 5th International Conference on Tropical Biology)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.05 – 09.10</strong></td>
                                <td><strong>Welcome Remarks</strong><br>Prof. Dr. Edi Santosa<br><span style="color:var(--text-muted);">(Director of SEAMEO BIOTROP)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.10 – 09.20</strong></td>
                                <td><strong>Remarks</strong><br>1. Datuk Dr. Habibah Abdul Rahim<br><span style="color:var(--text-muted);">(Director of SEAMEO Secretariat)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.20 – 09.25</strong></td>
                                <td>2. Dr. Alim Setiawan<br><span style="color:var(--text-muted);">(President of IPB University/Governing Board Member from Indonesia)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.25 – 09.35</strong></td>
                                <td>3. Mr. Dedie Abdu Rachim<br><span style="color:var(--text-muted);">(Major of Bogor City)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.35 – 09.45</strong></td>
                                <td><strong>Opening Remarks & Program Launching</strong><br>H.E. Prof Dr Abdul Mu'ti, M.Ed.<br><span style="color:var(--text-muted);">(Minister of Primary and Secondary Education, Republic of Indonesia)</span><br><br>Official Launch of The PROTIBAGURU <em>(Program Praktik Baik Guru Berkelanjutan)</em></td>
                            </tr>
                            <tr>
                                <td><strong>09.45 – 10.00</strong></td>
                                <td><strong>Keynote Session</strong><br><strong>Keynote 1.</strong> <em>Global Biodiversity Crisis: Bridging Science, Policy, Education, and Innovation for Transformative Action</em><br>H.E. Prof. Dr. Arif Satria<br><span style="color:var(--text-muted);">(Head of the National Research and Innovation Agency, Republic of Indonesia)</span></td>
                            </tr>
                            <tr>
                                <td><strong>10.00 – 10.15</strong></td>
                                <td><strong>Keynote 2.</strong> <em>Indonesia's Commitment to Biodiversity Conservation and Sustainable Landscape Management in a Changing World</em><br>H.E. Mr. Mohammad Jumhur Hidayat<br><span style="color:var(--text-muted);">(Minister of Environment, Republic of Indonesia)</span></td>
                            </tr>
                            <tr>
                                <td><strong>10.15 – 10.30</strong></td>
                                <td><strong>Keynote 3.</strong> <em>Revitalizing Local Wisdom for Biodiversity Conservation and Sustainable Development in West Java</em><br>Mr. Dedi Mulyadi, S.H. M.M<br><span style="color:var(--text-muted);">(Governor of West Java)</span></td>
                            </tr>
                            <tr>
                                <td><strong>10.30 – 10.40</strong></td>
                                <td><strong>Group Photo</strong></td>
                            </tr>
                            <tr>
                                <td><strong>10.40 – 11.00</strong></td>
                                <td><strong>Coffee Break</strong><br>Parallel Agenda: Press Conference</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; background-color:var(--bg-alt); padding: 16px;"><strong>Panel Session</strong><br>Moderator: Prof. Dr. Bambang Purwantara (IPB University/Director of SEAMEO BIOTROP 2009 - 2014)</td>
                            </tr>
                            <tr>
                                <td><strong>11.00 – 11.20</strong></td>
                                <td><em>Biodiversity Education through Geoparks, National Parks, and Landscape-Based Learning Systems</em><br>Associate Professor Dr. Ir. Peter van der Meer<br><span style="color:var(--text-muted);">(Associate Professor of Oil Palm & Tropical Forests at Van Hall Larenstein University of Applied Sciences)</span></td>
                            </tr>
                            <tr>
                                <td><strong>11.20 – 11.40</strong></td>
                                <td><em>Sustainable Management of Sub-Optimal Lands and Post-Mining Landscapes</em><br>Professor David Mulligan<br><span style="color:var(--text-muted);">(Deputy Director of Research, Sustainable Minerals Institute, University of Queensland)</span></td>
                            </tr>
                            <tr>
                                <td><strong>11.40 – 12.00</strong></td>
                                <td><em>Empowering Livelihoods through Nature-Based Solutions</em><br>Dr. Ravindra Chandra Joshi<br><span style="color:var(--text-muted);">(Philippine Rice Research Institute)</span></td>
                            </tr>
                            <tr>
                                <td><strong>12.00 – 12.20</strong></td>
                                <td><em>Biotechnology for Biodiversity, Environment, and Climate Change</em><br>Prof. Dato' Dr. Amirul Al-Ashraf Abdullah<br><span style="color:var(--text-muted);">(Honorary Professor, School of Biological Sciences, Universiti Sains Malaysia/ Governing Board Member from Malaysia)</span></td>
                            </tr>
                            <tr>
                                <td><strong>12.20 – 12.30</strong></td>
                                <td>Discussion</td>
                            </tr>
                            <tr>
                                <td><strong>12.30 – 12.35</strong></td>
                                <td>House Keeping Announcement</td>
                            </tr>
                            <tr>
                                <td><strong>12.35 – 13.30</strong></td>
                                <td><strong>Lunch Break</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; background-color:var(--bg-alt); padding: 16px;"><strong>Parallel Session</strong></td>
                            </tr>
                            <tr>
                                <td><strong>13.30 – 13.40</strong></td>
                                <td>
                                    <div class="parallel-grid">
                                        <div class="parallel-col">
                                            <strong>Sub Theme 1:</strong> Biodiversity Education through Geoparks, National Parks, and Landscape-Based Learning Systems<br><br>
                                            <strong>Speaker:</strong> Prof. Dr. Yayan Sumekar, S.P., M.P<br>(Weed Science Society of Indonesia)
                                        </div>
                                        <div class="parallel-col">
                                            <strong>Sub Theme 2:</strong> Sustainable Management of Sub-Optimal Lands and Post-Mining Landscapes<br><br>
                                            <strong>Speaker:</strong> Dr. Ir. Irdika Mansur, M.For.Sc<br>(Department of Silviculture, Faculty of Forestry IPB University)
                                        </div>
                                        <div class="parallel-col">
                                            <strong>Sub Theme 3:</strong> Empowering Livelihoods through Nature-Based Solutions<br><br>
                                            <strong>Speaker:</strong> Prof. Dr. Ir. Andi Muhammad Syakir, M.S.<br>(Indonesian Agronomy Association)
                                        </div>
                                        <div class="parallel-col">
                                            <strong>Sub Theme 4:</strong> Biotechnology for Biodiversity, Environment, and Climate Change<br><br>
                                            <strong>Speaker:</strong> Dr. Wahyu Purbowasito Setyo Waskito, M.Sc<br>(Indonesian Biotechnology Consortium)
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>13.40 – 16.00</strong></td>
                                <td>
                                    <div class="parallel-grid" style="text-align:center; font-weight: 500;">
                                        <div style="padding: 10px; background: rgba(0,0,0,0.02); border-radius: 4px;">Paper presentation</div>
                                        <div style="padding: 10px; background: rgba(0,0,0,0.02); border-radius: 4px;">Paper presentation</div>
                                        <div style="padding: 10px; background: rgba(0,0,0,0.02); border-radius: 4px;">Paper presentation</div>
                                        <div style="padding: 10px; background: rgba(0,0,0,0.02); border-radius: 4px;">Paper presentation</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>16.00 – 16.30</strong></td>
                                <td><strong>Coffee Break – Closing Session Day 1</strong></td>
                            </tr>
                            <tr>
                                <td><strong>16.30 – 18.00</strong></td>
                                <td><strong>Break Session</strong></td>
                            </tr>
                            <tr>
                                <td><strong>18.00 – 20.00</strong></td>
                                <td><strong>Welcome Dinner</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Day 2 Content -->
            <div class="schedule-pane" id="day2">
                <div class="schedule-details" style="display: block; padding: 0; border: none;">
                    <h3 style="margin-bottom: 20px; color: var(--primary-color); text-align: center;">Tuesday, 6 October 2026</h3>
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Time (GMT +7)</th>
                                <th style="width: 80%;">Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>08.30 – 08.45</strong></td>
                                <td><strong>Keynote 4</strong><br><em>Climate Change in a Warming World: Pathways towards Resilient and Sustainable Futures</em><br>Professor Piers Forster<br><span style="color:var(--text-muted);">(University of Leeds)</span></td>
                            </tr>
                            <tr>
                                <td><strong>08.45 – 09.00</strong></td>
                                <td><strong>Keynote 5</strong><br><em>Transforming Natural Capital into Sustainable Economic Opportunities through Biodiversity</em><br>Andrew Bovarnick<br><span style="color:var(--text-muted);">(United Nations Development Programme)</span></td>
                            </tr>
                            <tr>
                                <td><strong>09.00 – 09.15</strong></td>
                                <td><strong>Keynote 6</strong><br><em>Water Science and Blue Economy</em><br>Karen Sack<br><span style="color:var(--text-muted);">(Ocean Risk and Resilience Action Alliance)</span></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; background-color:var(--bg-alt); padding: 16px;"><strong>Parallel Agenda</strong></td>
                            </tr>
                            <tr>
                                <td><strong>09.15 – 09.45</strong></td>
                                <td>
                                    <div style="margin-bottom: 16px; font-weight: bold;">Poster Presentation</div>
                                    <div style="margin-bottom: 8px; font-weight: bold;">Oral Presentation</div>
                                    <div class="parallel-grid">
                                        <div class="parallel-col" style="display: flex; flex-direction: column;">
                                            <div><strong>Topic:</strong> Biodiversity Education through Geoparks, National Parks, and Landscape-Based Learning Systems</div>
                                            <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center; margin-top: auto;">Paper presentation</div>
                                        </div>
                                        <div class="parallel-col" style="display: flex; flex-direction: column;">
                                            <div><strong>Topic:</strong> Sustainable Management of Sub-optimal Lands and Post-Mining Landscapes</div>
                                            <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center; margin-top: auto;">Paper presentation</div>
                                        </div>
                                        <div class="parallel-col" style="display: flex; flex-direction: column;">
                                            <div><strong>Topic:</strong> Empowering Livelihoods through Nature-Based Solutions</div>
                                            <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center; margin-top: auto;">Paper presentation</div>
                                        </div>
                                        <div class="parallel-col" style="display: flex; flex-direction: column;">
                                            <div><strong>Topic:</strong> Biotechnology: food, feed, fuel, and forest</div>
                                            <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center; margin-top: auto;">Paper presentation</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>09.45 – 10.15</strong></td>
                                <td><strong>Coffee Break</strong></td>
                            </tr>
                            <tr>
                                <td><strong>10.15 – 12.00</strong></td>
                                <td>
                                    <div style="margin-bottom: 16px; font-weight: bold;">Poster Presentation</div>
                                    <div class="parallel-grid">
                                        <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center;">Paper presentation</div>
                                        <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center;">Paper presentation</div>
                                        <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center;">Paper presentation</div>
                                        <div style="padding: 6px; background: rgba(0,0,0,0.02); border-radius: 4px; text-align: center;">Paper presentation</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>12.00 – 13.30</strong></td>
                                <td><strong>Lunch Break</strong></td>
                            </tr>
                            <tr>
                                <td><strong>13.30 – 14.30</strong></td>
                                <td>Conference Synthesis</td>
                            </tr>
                            <tr>
                                <td><strong>14.30 – 15.30</strong></td>
                                <td>
                                    <strong>Closing Ceremony of the 5th International Conference on Tropical Biology</strong>
                                    <ol type="a" style="margin-top: 8px; padding-left: 20px;">
                                        <li style="margin-bottom: 4px;">Announcement of Best Presenter and Poster Presentation</li>
                                        <li style="margin-bottom: 4px;">Video Documentation</li>
                                        <li style="margin-bottom: 4px;">Closing Remarks by Prof. Dr. Edi Santosa (Director of SEAMEO BIOTROP)</li>
                                        <li>Housekeeping announcement</li>
                                    </ol>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Day 3 Content -->
            <div class="schedule-pane" id="day3">
                <div class="schedule-details" style="display: block; padding: 0; border: none;">
                    <h3 style="margin-bottom: 20px; color: var(--primary-color); text-align: center;">Wednesday, 7 October 2026</h3>
                    <table class="fee-table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Time (GMT +7)</th>
                                <th style="width: 80%;">Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="background-color:rgba(13, 148, 136, 0.05); padding: 12px 16px;"><strong>Dress code: Casual</strong></td>
                            </tr>
                            <tr>
                                <td><strong>08.00 – 10.00</strong></td>
                                <td>Excursions to Bogor Botanical Garden</td>
                            </tr>
                            <tr>
                                <td><strong>10.00 – 12.00</strong></td>
                                <td>SEAMEO BIOTROP Campus Tour*</td>
                            </tr>
                            <tr>
                                <td><strong>12.00 – 13.00</strong></td>
                                <td><strong>Lunch Break – Closing Session Day 3</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
