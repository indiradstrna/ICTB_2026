<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=1000'); background-position: center 30%;">
    <div class="cover-overlay"></div>
    <div class="container page-header-content text-center reveal-up">
        <h1 class="section-title text-white">Accommodation Options</h1>
        <p class="text-white" style="font-size: 1.1rem; opacity: 0.9;">Hotels available in Bogor near the venue</p>
    </div>
</section>

<style>
    /* Alternating background for each hotel group */
    .fee-table tbody.hotel-group:nth-child(even) {
        background-color: rgba(13, 148, 136, 0.03);
    }
    .fee-table tbody.hotel-group:nth-child(odd) {
        background-color: #ffffff;
    }
    /* Highlight the entire hotel group on hover */
    .fee-table tbody.hotel-group:hover {
        background-color: rgba(13, 148, 136, 0.08);
        transition: background-color 0.3s ease;
    }
    /* Disable default single-row hover effect from style.css */
    .fee-table tbody.hotel-group tr:hover {
        background-color: transparent !important;
    }
</style>

<!-- Accommodation Section -->
<section class="section-padding" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="section-header text-center reveal-up">
            <h2 class="section-title">Accommodation Options</h2>
            <p class="mt-4" style="color: var(--text-muted); max-width: 800px; margin: 0 auto; font-size: 1.1rem;">
                The following are rates and websites of hotels that are available in Bogor.
            </p>
        </div>
        
        <div class="fee-table-container reveal-up" style="margin-top: 40px;">
            <table class="fee-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Name of Hotel</th>
                        <th style="width: 20%;">Room Type</th>
                        <th style="width: 15%;">Daily Rate (IDR)</th>
                        <th style="width: 15%;">Distance</th>
                        <th style="width: 30%;">Addresses</th>
                    </tr>
                </thead>
                <!-- Bianco Costel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="4" style="font-weight: 600; vertical-align: top;">Bianco Costel<br><a href="tel:02518396507" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">0251 8396507</a> / <a href="https://wa.me/628111525950" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">08111525950</a></td>
                        <td>Superior Room</td>
                        <td>± Rp275.000</td>
                        <td rowspan="4" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Bianco+Costel+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,3 km<br>(± 3–5 menit jalan kaki)</a></td>
                        <td rowspan="4" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Prof. DR. H. Andi Hakim Nasoetion, Tegallega, Kec. Bogor Tengah, Kota Bogor, Jawa Barat 16129</td>
                    </tr>
                    <tr><td>Deluxe Room</td><td>± Rp350.000</td></tr>
                    <tr><td>Suite Room</td><td>± Rp550.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite Panoramic</td><td style="border-bottom: 1px solid var(--border-color);">± Rp600.000</td></tr>
                </tbody>

                <!-- Bigland Bogor Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Bigland Bogor Hotel<br><a href="mailto:reservation-bogor@biglandhotels.com" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Email</a> | <a href="tel:+622518305555" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Phone</a> | <a href="https://wa.me/628119625627" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">WA</a></td>
                        <td>Superior</td>
                        <td>± Rp500.000 – 650.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Bigland+Bogor+Hotel" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,5–0,8 km<br>(± 5–10 menit)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl Malabar 1B Kel. Tegalega, Kec. Bogor Tengah, Bogor, Jawa Barat 16127</td>
                    </tr>
                    <tr><td>Deluxe</td><td>± Rp700.000 – 850.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Executive</td><td style="border-bottom: 1px solid var(--border-color);">± Rp900.000 – 1.100.000</td></tr>
                </tbody>

                <!-- favehotel Padjajaran Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="2" style="font-weight: 600; vertical-align: top;">favehotel Padjajaran Bogor<br><a href="tel:02518356100" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8356100</a></td>
                        <td>Standard / Faveroom</td>
                        <td>± Rp400.000 – 550.000</td>
                        <td rowspan="2" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=favehotel+Padjajaran+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,7–0,8 km<br>(± 8–10 menit)</a></td>
                        <td rowspan="2" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Cidangiang No.1, RT.04/RW.05, Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16129</td>
                    </tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Deluxe</td><td style="border-bottom: 1px solid var(--border-color);">± Rp550.000 – 700.000</td></tr>
                </tbody>

                <!-- Hotel Grand Savero -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Hotel Grand Savero<br><a href="tel:02518358888" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8358888</a></td>
                        <td>Superior</td>
                        <td>± Rp650.000 – 800.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Hotel+Grand+Savero+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,6 km<br>(± 5–8 menit)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran No.27, RT.03/RW.08, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128</td>
                    </tr>
                    <tr><td>Deluxe</td><td>± Rp850.000 – 1.000.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.200.000 – 1.500.000</td></tr>
                </tbody>

                <!-- Amaris Pajajaran Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td style="font-weight: 600; vertical-align: top; border-bottom: 1px solid var(--border-color);">Amaris Pajajaran Hotel<br><a href="tel:02518312200" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8312200</a></td>
                        <td style="border-bottom: 1px solid var(--border-color);">Smart Room Twin/Queen</td>
                        <td style="border-bottom: 1px solid var(--border-color);">± Rp350.000 – 500.000</td>
                        <td style="vertical-align: top; border-bottom: 1px solid var(--border-color);"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Amaris+Pajajaran+Hotel+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,8–1 km<br>(± 8–12 menit)</a></td>
                        <td style="font-size: 13px; line-height: 1.6; vertical-align: top; border-bottom: 1px solid var(--border-color);">Jl. Raya Pajajaran No.25, RT.03/RW.08, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16129</td>
                    </tr>
                </tbody>

                <!-- Hotel Permata -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Hotel Permata<br><a href="tel:02518318007" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8318007</a></td>
                        <td>Superior</td>
                        <td>± Rp450.000 – 600.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Hotel+Permata+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 1–1,5 km<br>(± 5–10 menit berkendara)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran No.36, RT.03/RW.08, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128</td>
                    </tr>
                    <tr><td>Deluxe</td><td>± Rp650.000 – 850.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.000.000+</td></tr>
                </tbody>

                <!-- ibis Styles Bogor Pajajaran -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">ibis Styles Bogor Pajajaran<br><a href="tel:02518305757" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8305757</a></td>
                        <td>Standard</td>
                        <td>± Rp650.000 – 850.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=ibis+Styles+Bogor+Pajajaran" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,1–0,8 km<br>(± 2–10 menit)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran No.37, RT.03/RW.08, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128</td>
                    </tr>
                    <tr><td>Superior</td><td>± Rp850.000 – 1.000.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Family Room</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.200.000+</td></tr>
                </tbody>

                <!-- Luminor Hotel Padjadjaran Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Luminor Hotel Padjadjaran Bogor<br><span style="font-weight:normal; font-size:13px; color:var(--text-muted);">(Bintang 4)</span><br><a href="https://wa.me/6285195551111" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">WA</a> | <a href="tel:02518203888" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Phone</a></td>
                        <td>Deluxe</td>
                        <td>± Rp580.000 – 750.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Luminor+Hotel+Padjadjaran+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 0,1–0,5 km<br>(± 3–7 menit)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Cidangiang No.9, RT.004/RW.05, Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16127</td>
                    </tr>
                    <tr><td>Executive</td><td>± Rp850.000 – 1.000.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.300.000+</td></tr>
                </tbody>

                <!-- The 1O1 Bogor Suryakancana -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">The 1O1 Bogor Suryakancana<br><a href="tel:02517565101" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 7565101</a></td>
                        <td>Deluxe</td>
                        <td>± Rp650.000 – 850.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=The+1O1+Bogor+Suryakancana" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 1,2–1,5 km<br>(± 5–10 menit berkendara)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Suryakencana St No.179 - 181, RT.01/RW.2, Babakan Pasar, Bogor Tengah, Bogor City, West Java 16123</td>
                    </tr>
                    <tr><td>Superior</td><td>± Rp850.000 – 1.000.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.500.000+</td></tr>
                </tbody>

                <!-- Hotel Salak The Heritage -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Hotel Salak The Heritage<br><a href="tel:02518373111" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8373111</a></td>
                        <td>Deluxe</td>
                        <td>± Rp700.000 – 900.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Hotel+Salak+The+Heritage" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">1–1,3 km<br>(± 5–10 menit berkendara)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Ir. H. Juanda No.8, RT.01/RW.01, Pabaton, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16121</td>
                    </tr>
                    <tr><td>Executive</td><td>± Rp1.000.000 – 1.300.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.500.000 – 2.000.000</td></tr>
                </tbody>

                <!-- Royal Hotel Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Royal Hotel Bogor<br><a href="tel:02518347123" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8347123</a></td>
                        <td>Superior</td>
                        <td>± Rp450.000 – 650.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Royal+Hotel+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 1–2 km<br>(± 5–10 menit berkendara)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Ir. H. Juanda No.16, RT.01/RW.07, Paledang, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16122</td>
                    </tr>
                    <tr><td>Deluxe</td><td>± Rp700.000 – 900.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.000.000+</td></tr>
                </tbody>

                <!-- Royal Padjadjaran Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Royal Padjadjaran Hotel<br><a href="tel:02518385777" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8385777</a></td>
                        <td>Superior</td>
                        <td>± Rp500.000 – 700.000</td>
                        <td rowspan="3" style="vertical-align: top;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Royal+Padjadjaran+Hotel" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">± 2–3 km<br>(± 10–15 menit berkendara)</a></td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran No.12, RT.02/RW.04, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128</td>
                    </tr>
                    <tr><td>Deluxe</td><td>± Rp750.000 – 950.000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Junior Suite</td><td style="border-bottom: 1px solid var(--border-color);">± Rp1.200.000+</td></tr>
                </tbody>

                <!-- Hotel Santika Botani -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="5" style="font-weight: 600; vertical-align: top; border-bottom: none;">Hotel Santika Botani<br><a href="tel:02518400707" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">CP: (0251) 8400707</a></td>
                        <td>Superior</td>
                        <td>Rp 900.000 – 1.000.000<br><span style="font-size: 11px; color: var(--text-muted);">(2 pax breakfast)</span></td>
                        <td rowspan="5" style="vertical-align: top; border-bottom: none;"><a href="https://www.google.com/maps/dir/?api=1&origin=IPB+International+Convention+Center,+Botani+Square+Bogor&destination=Hotel+Santika+Botani+Square+Bogor" target="_blank" style="color: var(--primary-color); text-decoration: underline; font-weight: 500;">Jalan kaki: ± 0–200 meter<br>(1–3 menit)</a></td>
                        <td rowspan="5" style="font-size: 13px; line-height: 1.6; vertical-align: top; border-bottom: none;">Botani Square Bogor, Jl. Raya Pajajaran, RT.04/RW.05, Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16127</td>
                    </tr>
                    <tr><td>Deluxe</td><td>Rp 1.100.000 – 1.300.000<br><span style="font-size: 11px; color: var(--text-muted);">(2 pax breakfast)</span></td></tr>
                    <tr><td>Executive</td><td>Rp 1.400.000 – 1.700.000<br><span style="font-size: 11px; color: var(--text-muted);">(2 pax breakfast)</span></td></tr>
                    <tr><td>Suite</td><td>Rp 1.730.000<br><span style="font-size: 11px; color: var(--text-muted);">(2 pax breakfast)</span></td></tr>
                    <tr><td style="border-bottom: none;">Presidential Suite</td><td style="border-bottom: none;">Rp 2.030.000<br><span style="font-size: 11px; color: var(--text-muted);">(2 pax breakfast)</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
