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
                <!-- Novotel Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Novotel Bogor Golf Resort & Convention Center<br><a href="https://www.novotelbogor.com/id/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior</td>
                        <td>969,628</td>
                        <td rowspan="3" style="vertical-align: top;">12 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Golf Estate Bogor Raya, 16710, West Java Bogor, Indonesia<br><strong>Phone:</strong> +62 251 8271555, +62 87785593707</td>
                    </tr>
                    <tr><td>Superior</td><td>1,048,140</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Deluxe</td><td style="border-bottom: 1px solid var(--border-color);">1,268,594</td></tr>
                </tbody>

                <!-- Bigland Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Bigland Hotel International & Convention Hall<br><a href="https://biglandhotels.com/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe King</td>
                        <td>873,000</td>
                        <td rowspan="3" style="vertical-align: top;">5.4 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Malabar No.1B, Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16127<br><strong>Phone:</strong> +62 251 8305555</td>
                    </tr>
                    <tr><td>Family</td><td>1,323,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite dg Balkon</td><td style="border-bottom: 1px solid var(--border-color);">1,413,000</td></tr>
                </tbody>

                <!-- Royal Hotel Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="6" style="font-weight: 600; vertical-align: top;">Royal Hotel Bogor<br><a href="https://hotelroyalbogor.com/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior</td>
                        <td>590,000</td>
                        <td rowspan="6" style="vertical-align: top;">6.7 KM</td>
                        <td rowspan="6" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Ir. H. Djuanda No.16, Bogor - Indonesia<br><strong>Phone:</strong> +62 251 8347123</td>
                    </tr>
                    <tr><td>Deluxe</td><td>690,000</td></tr>
                    <tr><td>Balcony Room</td><td>1,050,000</td></tr>
                    <tr><td>Executive Room</td><td>1,350,000</td></tr>
                    <tr><td>Suite Room</td><td>1,800,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Penthouse Room</td><td style="border-bottom: 1px solid var(--border-color);">4,500,000</td></tr>
                </tbody>

                <!-- Swiss-Belinn Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="4" style="font-weight: 600; vertical-align: top;">Swiss-Belinn Bogor<br><a href="https://www.swiss-belhotel.com/id-id/swiss-belinn-bogor" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe - Member</td>
                        <td>1,080,000</td>
                        <td rowspan="4" style="vertical-align: top;">4.4 KM</td>
                        <td rowspan="4" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jalan Pajajaran Indah V, Baranangsiang, Bogor Timur, Bogor, Indonesia<br><strong>Phone:</strong> +62 251 830 6666</td>
                    </tr>
                    <tr><td>Deluxe - Flexi</td><td>1,200,000</td></tr>
                    <tr><td>Superior Deluxe</td><td>1,215,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Superior Deluxe - Sarapan</td><td style="border-bottom: 1px solid var(--border-color);">1,341,000</td></tr>
                </tbody>

                <!-- Royal Padjajaran Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="4" style="font-weight: 600; vertical-align: top;">Royal Padjajaran Hotel<br><a href="https://royalpadjadjaranhotel.com/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior King Room</td>
                        <td>650,000</td>
                        <td rowspan="4" style="vertical-align: top;">6.0 KM</td>
                        <td rowspan="4" style="font-size: 13px; line-height: 1.6; vertical-align: top;">JL. Raya Padjadjaran No. 12, Bogor, Jawa Barat - Indonesia<br><strong>Phone:</strong> +62 251 8385777</td>
                    </tr>
                    <tr><td>Deluxe King Room</td><td>750,000</td></tr>
                    <tr><td>Balcony King Room</td><td>1,050,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite King Room</td><td style="border-bottom: 1px solid var(--border-color);">1,500,000</td></tr>
                </tbody>

                <!-- ASTON Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="8" style="font-weight: 600; vertical-align: top;">ASTON Bogor Hotel & Resort<br><a href="https://www.astonhotelsinternational.com" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior</td>
                        <td>1,018,704</td>
                        <td rowspan="8" style="vertical-align: top;">5.5 KM</td>
                        <td rowspan="8" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Pahlawan, RT.05/RW.12, Mulyaharja, Kec. Bogor Selatan, Kota Bogor, Jawa Barat 16132<br><strong>Phone:</strong> +62 251 8200300</td>
                    </tr>
                    <tr><td>Deluxe</td><td>1,098,144</td></tr>
                    <tr><td>Condotel One Bedroom</td><td>1,144,544</td></tr>
                    <tr><td>Condotel One Bedroom Pool View</td><td>1,192,944</td></tr>
                    <tr><td>Condotel Deluxe One Bedroom</td><td>1,241,344</td></tr>
                    <tr><td>Condotel Two Bedroom</td><td>1,978,304</td></tr>
                    <tr><td>Condotel Two Bedroom Pool View</td><td>2,026,704</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Condotel Two Bedroom Deluxe</td><td style="border-bottom: 1px solid var(--border-color);">2,075,104</td></tr>
                </tbody>

                <!-- Zest Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Zest Hotel<br><a href="https://www.zesthotel.com/id-id/zest-hotel-bogor/rooms" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Zest Twin Room</td>
                        <td>400,500</td>
                        <td rowspan="3" style="vertical-align: top;">5.6 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Pajajaran No. 27, Bogor, Indonesia<br><strong>Phone:</strong> +62 251 7568888</td>
                    </tr>
                    <tr><td>Zest Queen Room</td><td>414,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Zest Suite Room</td><td style="border-bottom: 1px solid var(--border-color);">787,500</td></tr>
                </tbody>

                <!-- Sahira Butik -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="7" style="font-weight: 600; vertical-align: top;">Sahira Butik Hotel<br><a href="https://www.sahirahotels.com/hotels/sahira-butik-hotel-paledang" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe Double</td>
                        <td>1,200,000</td>
                        <td rowspan="7" style="vertical-align: top;">6.8 KM</td>
                        <td rowspan="7" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Paledang No 53, Rt.03/Rw.02, Paledang, Kota Bogor, Jawa Barat 16122<br><strong>Phone:</strong> +62 251 8322413</td>
                    </tr>
                    <tr><td>Deluxe Twin</td><td>1,200,000</td></tr>
                    <tr><td>Deluxe Family</td><td>1,400,000</td></tr>
                    <tr><td>Executive</td><td>1,500,000</td></tr>
                    <tr><td>Deluxe Suite</td><td>1,300,000</td></tr>
                    <tr><td>Royal Suite</td><td>2,000,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Sahira Suite</td><td style="border-bottom: 1px solid var(--border-color);">2,500,000</td></tr>
                </tbody>

                <!-- Horison Ultima -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="5" style="font-weight: 600; vertical-align: top;">Horison Ultima Bhuvana Ciawi<br><a href="https://myhorison.com/website/unit/horison-ultima-bhuvana-ciawi" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe Twin - Room Only</td>
                        <td>840,000</td>
                        <td rowspan="5" style="vertical-align: top;">4.9 KM</td>
                        <td rowspan="5" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. K.H RM Toha, Desa Bendungan Ciawi Bogor<br><strong>Phone:</strong> +62 251 830 3636</td>
                    </tr>
                    <tr><td>Deluxe Twin - Breakfast</td><td>945,000</td></tr>
                    <tr><td>Executive - Breakfast</td><td>1,085,000</td></tr>
                    <tr><td>Junior Suite - Breakfast</td><td>1,183,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Family Suite - Breakfast</td><td style="border-bottom: 1px solid var(--border-color);">1,512,000</td></tr>
                </tbody>

                <!-- Hotel Savero Style -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="9" style="font-weight: 600; vertical-align: top;">Hotel Savero Style<br><a href="https://www.bookandlink.com/booking/booking-page.php?checkin=18-07-2023&checkout=19-07-2023&id=2764&lang_id=id&currency=IDR&source=localuniversal&google=yes/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Style Twin Bed - Room Only</td>
                        <td>400,000</td>
                        <td rowspan="9" style="vertical-align: top;">5.6 KM</td>
                        <td rowspan="9" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran No.38, RT.01/RW.04, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128, Bogor - Indonesia<br><strong>Phone:</strong> +62 251 8577100</td>
                    </tr>
                    <tr><td>Style Twin Bed - Breakfast</td><td>500,000</td></tr>
                    <tr><td>Style Queen Bed - Room Only</td><td>450,000</td></tr>
                    <tr><td>Style Queen Bed - Breakfast</td><td>550,000</td></tr>
                    <tr><td>Deluxe Queen Bed - Room Only</td><td>500,000</td></tr>
                    <tr><td>Deluxe Queen Bed - Breakfast</td><td>600,000</td></tr>
                    <tr><td>Grand Deluxe Queen Bed - Room Only</td><td>800,000</td></tr>
                    <tr><td>Grand Deluxe Queen Bed - Breakfast</td><td>850,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite King Bed - Breakfast</td><td style="border-bottom: 1px solid var(--border-color);">1,300,000</td></tr>
                </tbody>

                <!-- Amaroossa Royal Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Amaroossa Royal Bogor<br><a href="https://amaroossahotel.com/bogor-royal/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe</td>
                        <td>400,000</td>
                        <td rowspan="3" style="vertical-align: top;">4.6 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Otto Iskandardinata No.84, RT.04/RW.02, Baranangsiang, Kec. Bogor Timur, Kota Bogor, Jawa Barat 16143<br><strong>Phone:</strong> +62 251 8354333</td>
                    </tr>
                    <tr><td>Executive</td><td>600,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">900,000</td></tr>
                </tbody>

                <!-- The Mirah Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">The Mirah Hotel<br><a href="https://mirahhotelbogor.com/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior</td>
                        <td>500,000</td>
                        <td rowspan="3" style="vertical-align: top;">6.1 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Pangrango No. 9A, Bogor 16151 West Java, Indonesia<br><strong>Phone:</strong> +62 251 8348040</td>
                    </tr>
                    <tr><td>Deluxe</td><td>600,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Deluxe Balcony</td><td style="border-bottom: 1px solid var(--border-color);">850,000</td></tr>
                </tbody>

                <!-- Amaris Hotel Padjajaran Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">Amaris Hotel Padjajaran Bogor<br><a href="https://amarishotel.com/id/hotel/amaris-hotel-padjajaran-bogor/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Smart Room Queen</td>
                        <td>451,000</td>
                        <td rowspan="3" style="vertical-align: top;">5.3 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Padjajaran No. 125, Bogor 16127<br><strong>Phone:</strong> +62 251 8312200</td>
                    </tr>
                    <tr><td>Smart Room Hollywood</td><td>492,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Smart Room Twin</td><td style="border-bottom: 1px solid var(--border-color);">492,000</td></tr>
                </tbody>

                <!-- Favehotel Padjajaran -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="2" style="font-weight: 600; vertical-align: top;">Favehotel Padjajaran<br><a href="https://www.favehotels.com/id/hotel/view/24/favehotel-padjajaran" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Faveroom</td>
                        <td>556,966</td>
                        <td rowspan="2" style="vertical-align: top;">5.1 KM</td>
                        <td rowspan="2" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Cidangiang No. 1 Tegallega, Bogor, Kota Bogor, 16129<br><strong>Phone:</strong> +62 251 8356100</td>
                    </tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Fabroom</td><td style="border-bottom: 1px solid var(--border-color);">1,010,322</td></tr>
                </tbody>

                <!-- Hotel Salak The Heritage -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="7" style="font-weight: 600; vertical-align: top;">Hotel Salak The Heritage<br><a href="https://www.hotelsalak.co.id/index.php?page=rooms" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Standard Twin Room</td>
                        <td>650,000</td>
                        <td rowspan="7" style="vertical-align: top;">6.8 KM</td>
                        <td rowspan="7" style="font-size: 13px; line-height: 1.6; vertical-align: top;">JL. IR. H JUANDA NO.8 16121 BOGOR - INDONESIA<br><strong>Phone:</strong> +62 251 8373111</td>
                    </tr>
                    <tr><td>Superior Twin Room</td><td>680,000</td></tr>
                    <tr><td>Superior Double</td><td>700,000</td></tr>
                    <tr><td>Deluxe Twin Room</td><td>820,000</td></tr>
                    <tr><td>Deluxe Double</td><td>850,000</td></tr>
                    <tr><td>Deluxe Suite</td><td>1,250,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Salak View</td><td style="border-bottom: 1px solid var(--border-color);">1,350,000</td></tr>
                </tbody>

                <!-- Hotel Santika Bogor -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="2" style="font-weight: 600; vertical-align: top;">Hotel Santika Bogor<br><a href="https://www.mysantika.com/indonesia/bogor/hotel-santika-bogor/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior Room Twin</td>
                        <td>750,750</td>
                        <td rowspan="2" style="vertical-align: top;">5.7 KM</td>
                        <td rowspan="2" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Pajajaran, RT.04/RW.05, Tegallega, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16129<br><strong>Phone:</strong> +62 251 8400707</td>
                    </tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Executive Room Queen</td><td style="border-bottom: 1px solid var(--border-color);">1,023,750</td></tr>
                </tbody>

                <!-- Lido Lake Resort -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="6" style="font-weight: 600; vertical-align: top;">Lido Lake Resort<br><a href="https://www.lidolakeresort.com/rooms-suite/" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe</td>
                        <td>1,480,000</td>
                        <td rowspan="6" style="vertical-align: top;">21 KM</td>
                        <td rowspan="6" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Raya Bogor - Sukabumi KM 21 Kawasan Ekonomi Khusus MNC Lido City Bogor, Jawa Barat, Indonesia<br><strong>Phone:</strong> +62 251 8220922</td>
                    </tr>
                    <tr><td>Deluxe Pool Access</td><td>1,630,000</td></tr>
                    <tr><td>Family Suite</td><td>1,800,000</td></tr>
                    <tr><td>Executive Suite</td><td>2,140,000</td></tr>
                    <tr><td>Lido Suite</td><td>2,910,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Junior Suite</td><td style="border-bottom: 1px solid var(--border-color);">1,810,000</td></tr>
                </tbody>

                <!-- The Alana Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="3" style="font-weight: 600; vertical-align: top;">The Alana Hotel and Conference Sentul City<br><a href="https://www.alanahotels.com/id/hotel/view/5/the-alana-hotel---conference-center---sentul-city" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Deluxe Room</td>
                        <td>1,293,750</td>
                        <td rowspan="3" style="vertical-align: top;">13 KM</td>
                        <td rowspan="3" style="font-size: 13px; line-height: 1.6; vertical-align: top;">Jl. Ir. H. Juanda No. 76 Sentul City, Bogor 16810<br><strong>Phone:</strong> +62 21 84280888</td>
                    </tr>
                    <tr><td>Deluxe Pool View</td><td>1,449,000</td></tr>
                    <tr><td style="border-bottom: 1px solid var(--border-color);">Suite</td><td style="border-bottom: 1px solid var(--border-color);">2,587,500</td></tr>
                </tbody>

                <!-- The 1O1 Hotel -->
                <tbody class="hotel-group">
                    <tr>
                        <td rowspan="10" style="font-weight: 600; vertical-align: top; border-bottom: none;">The 1O1 Hotel Bogor Surya Kencana<br><a href="https://www.phm-hotels.com/hotel/1O1BSK" target="_blank" style="font-size: 13px; font-weight: normal; color: var(--primary-color);">Visit Website</a></td>
                        <td>Superior Room Only</td>
                        <td>639,000</td>
                        <td rowspan="10" style="vertical-align: top; border-bottom: none;">7.7 KM</td>
                        <td rowspan="10" style="font-size: 13px; line-height: 1.6; vertical-align: top; border-bottom: none;">Jl. Surya kencana No. 179-181, Kota Bogor, Indonesia<br><strong>Phone:</strong> +62 51 7565101</td>
                    </tr>
                    <tr><td>Deluxe Room Only</td><td>674,100</td></tr>
                    <tr><td>Deluxe Breakfast</td><td>764,100</td></tr>
                    <tr><td>Deluxe Balcony - Room Only</td><td>764,100</td></tr>
                    <tr><td>Deluxe Balcony - Breakfast</td><td>854,100</td></tr>
                    <tr><td>Executive Suite</td><td>1,484,100</td></tr>
                    <tr><td>Executive Suite - Balcony</td><td>1,574,100</td></tr>
                    <tr><td>Deluxe - Two Room</td><td>1,664,100</td></tr>
                    <tr><td>Suite Heritage</td><td>1,710,000</td></tr>
                    <tr><td style="border-bottom: none;">Deluxe Balcony - Two Room</td><td style="border-bottom: none;">1,934,100</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
