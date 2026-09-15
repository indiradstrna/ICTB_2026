-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 08 Jun 2026 pada 03.07
-- Versi server: 8.0.46-0ubuntu0.24.04.2
-- Versi PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ictb26`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `participant_id` int NOT NULL,
  `apptype_id` varchar(255) NOT NULL,
  `subtheme_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `firstsubmit` int NOT NULL,
  `publication_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `applications`
--

INSERT INTO `applications` (`id`, `participant_id`, `apptype_id`, `subtheme_id`, `title`, `abstract`, `keyword`, `firstsubmit`, `publication_id`, `created_at`, `updated_at`) VALUES
(1, 13, 'Oral', 'Biodiversity Education through Geoparks, National Parks, and Landscape-Based Learning Systems', 'SEAMEO BIOTROP', 'uploads/1780387017_abstract_template_abstract.docx', '-', 1, 'Program book (abstract only) - free', '2026-06-02 07:56:57', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `countries`
--

CREATE TABLE `countries` (
  `id` int DEFAULT NULL,
  `country_name` varchar(200) COLLATE utf8mb3_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data untuk tabel `countries`
--

INSERT INTO `countries` (`id`, `country_name`) VALUES
(83, 'Rwanda'),
(2, 'Somalia'),
(3, 'Yemen'),
(4, 'Iraq'),
(5, 'Saudi Arabia'),
(6, 'Iran'),
(7, 'Cyprus'),
(8, 'Tanzania'),
(9, 'Syria'),
(10, 'Armenia'),
(11, 'Kenya'),
(12, 'Congo'),
(13, 'Djibouti'),
(14, 'Uganda'),
(15, 'Central African Republic'),
(16, 'Seychelles'),
(17, 'Hashemite Kingdom of Jordan'),
(18, 'Lebanon'),
(19, 'Kuwait'),
(20, 'Oman'),
(21, 'Qatar'),
(22, 'Bahrain'),
(23, 'United Arab Emirates'),
(24, 'Israel'),
(25, 'Turkey'),
(26, 'Ethiopia'),
(27, 'Eritrea'),
(28, 'Egypt'),
(29, 'Sudan'),
(30, 'Greece'),
(31, 'Burundi'),
(32, 'Estonia'),
(33, 'Latvia'),
(34, 'Azerbaijan'),
(35, 'Republic of Lithuania'),
(36, 'Svalbard and Jan Mayen'),
(37, 'Georgia'),
(38, 'Republic of Moldova'),
(39, 'Belarus'),
(40, 'Finland'),
(41, 'Aland'),
(42, 'Ukraine'),
(43, 'Macedonia'),
(44, 'Hungary'),
(45, 'Bulgaria'),
(46, 'Albania'),
(47, 'Poland'),
(48, 'Romania'),
(49, 'Kosovo'),
(50, 'Zimbabwe'),
(51, 'Zambia'),
(52, 'Comoros'),
(53, 'Malawi'),
(54, 'Lesotho'),
(55, 'Botswana'),
(56, 'Mauritius'),
(57, 'Swaziland'),
(58, 'Reunion'),
(59, 'South Africa'),
(60, 'Mayotte'),
(61, 'Mozambique'),
(62, 'Madagascar'),
(63, 'Afghanistan'),
(64, 'Pakistan'),
(65, 'Bangladesh'),
(66, 'Turkmenistan'),
(67, 'Tajikistan'),
(68, 'Sri Lanka'),
(69, 'Bhutan'),
(70, 'India'),
(71, 'Maldives'),
(72, 'British Indian Ocean Territory'),
(73, 'Nepal'),
(74, 'Myanmar [Burma]'),
(75, 'Uzbekistan'),
(76, 'Kazakhstan'),
(77, 'Kyrgyzstan'),
(78, 'French Southern Territories'),
(79, 'Cocos [Keeling] Islands'),
(80, 'Palau'),
(81, 'Vietnam'),
(82, 'Thailand'),
(1, 'Indonesia'),
(84, 'Laos'),
(85, 'Taiwan'),
(86, 'Philippines'),
(87, 'Malaysia'),
(88, 'China'),
(89, 'Hong Kong'),
(90, 'Brunei'),
(91, 'Macao'),
(92, 'Cambodia'),
(93, 'Republic of Korea'),
(94, 'Japan'),
(95, 'North Korea'),
(96, 'Singapore'),
(97, 'Cook Islands'),
(98, 'East Timor'),
(99, 'Russia'),
(100, 'Mongolia'),
(101, 'Australia'),
(102, 'Christmas Island'),
(103, 'Marshall Islands'),
(104, 'Federated States of Micronesia'),
(105, 'Papua New Guinea'),
(106, 'Solomon Islands'),
(107, 'Tuvalu'),
(108, 'Nauru'),
(109, 'Vanuatu'),
(110, 'New Caledonia'),
(111, 'Norfolk Island'),
(112, 'New Zealand'),
(113, 'Fiji'),
(114, 'Libya'),
(115, 'Cameroon'),
(116, 'Senegal'),
(117, 'Republic of the Congo'),
(118, 'Portugal'),
(119, 'Liberia'),
(120, 'Ivory Coast'),
(121, 'Ghana'),
(122, 'Equatorial Guinea'),
(123, 'Nigeria'),
(124, 'Burkina Faso'),
(125, 'Togo'),
(126, 'Guinea-Bissau'),
(127, 'Mauritania'),
(128, 'Benin'),
(129, 'Gabon'),
(130, 'Sierra Leone'),
(131, 'Sao Tome and Principe'),
(132, 'Gibraltar'),
(133, 'Gambia'),
(134, 'Guinea'),
(135, 'Chad'),
(136, 'Niger'),
(137, 'Mali'),
(138, 'Tunisia'),
(139, 'Spain'),
(140, 'Morocco'),
(141, 'Malta'),
(142, 'Algeria'),
(143, 'Faroe Islands'),
(144, 'Denmark'),
(145, 'Iceland'),
(146, 'United Kingdom'),
(147, 'Switzerland'),
(148, 'Sweden'),
(149, 'Netherlands'),
(150, 'Austria'),
(151, 'Belgium'),
(152, 'Germany'),
(153, 'Luxembourg'),
(154, 'Ireland'),
(155, 'Monaco'),
(156, 'France'),
(157, 'Andorra'),
(158, 'Liechtenstein'),
(159, 'Jersey'),
(160, 'Isle of Man'),
(161, 'Guernsey'),
(162, 'Slovakia'),
(163, 'Czech Republic'),
(164, 'Norway'),
(165, 'Vatican City'),
(166, 'San Marino'),
(167, 'Italy'),
(168, 'Slovenia'),
(169, 'Montenegro'),
(170, 'Croatia'),
(171, 'Bosnia and Herzegovina'),
(172, 'Angola'),
(173, 'Namibia'),
(174, 'Saint Helena'),
(175, 'Barbados'),
(176, 'Cape Verde'),
(177, 'Guyana'),
(178, 'French Guiana'),
(179, 'Suriname'),
(180, 'Saint Pierre and Miquelon'),
(181, 'Greenland'),
(182, 'Paraguay'),
(183, 'Uruguay'),
(184, 'Brazil'),
(185, 'Falkland Islands'),
(186, 'South Georgia and the South Sandwich Islands'),
(187, 'Jamaica'),
(188, 'Dominican Republic'),
(189, 'Cuba'),
(190, 'Martinique'),
(191, 'Bahamas'),
(192, 'Bermuda'),
(193, 'Anguilla'),
(194, 'Trinidad and Tobago'),
(195, 'Saint Kitts and Nevis'),
(196, 'Dominica'),
(197, 'Antigua and Barbuda'),
(198, 'Saint Lucia'),
(199, 'Turks and Caicos Islands'),
(200, 'Aruba'),
(201, 'British Virgin Islands'),
(202, 'Saint Vincent and the Grenadines'),
(203, 'Montserrat'),
(204, 'Saint Martin'),
(205, 'Saint-Bartholemy'),
(206, 'Guadeloupe'),
(207, 'Grenada'),
(208, 'Cayman Islands'),
(209, 'Belize'),
(210, 'El Salvador'),
(211, 'Guatemala'),
(212, 'Honduras'),
(213, 'Nicaragua'),
(214, 'Costa Rica'),
(215, 'Venezuela'),
(216, 'Ecuador'),
(217, 'Colombia'),
(218, 'Panama'),
(219, 'Haiti'),
(220, 'Argentina'),
(221, 'Chile'),
(222, 'Bolivia'),
(223, 'Peru'),
(224, 'Mexico'),
(225, 'French Polynesia'),
(226, 'Pitcairn Islands'),
(227, 'Kiribati'),
(228, 'Tokelau'),
(229, 'Tonga'),
(230, 'Wallis and Futuna'),
(231, 'Samoa'),
(232, 'Niue'),
(233, 'Northern Mariana Islands'),
(234, 'Guam'),
(235, 'Puerto Rico'),
(236, 'U.S. Virgin Islands'),
(237, 'U.S. Minor Outlying Islands'),
(238, 'American Samoa'),
(239, 'Canada'),
(240, 'United States'),
(241, 'Palestine'),
(242, 'Serbia'),
(243, 'Antarctica'),
(244, 'Sint Maarten'),
(245, 'Curacao'),
(246, 'Bonaire'),
(247, 'South Sudan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `participant_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '',
  `bukti_diri` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `org_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attendance` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `funding` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `funding_source` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `allergies` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `participants`
--

INSERT INTO `participants` (`id`, `participant_type`, `first_name`, `last_name`, `institution`, `email`, `phone`, `password_hash`, `bukti_transfer`, `bukti_diri`, `created_at`, `title`, `gender`, `org_type`, `country`, `attendance`, `funding`, `funding_source`, `allergies`) VALUES
(3, 'author', 'Indira', 'Destriana', 'Telkom University', 'kunci027@gmail.com', '081234567890', '$2y$10$kNW8ZfYOOCG4MBkHg6hp6uh32vS8Q0Hm4fx9Ik5QqxFfi4.S2wzL.', '', 'uploads/1780386218_proof_6.  bukti upload foto formal.png', '2026-05-15 09:17:27', 'Mr.', 'Male', 'Academic institution', 'Indonesia', 'Offline', 'No', '', ''),
(4, 'participant', 'Indira', 'Destriana', '', 'gionkys12@gmail.com', '081234567890', '$2y$10$mDXeS4WJFiWTROZD2.BDZOiRRxNPGq2kpbTL7niJfM0lQUfaIHBRK', '', '', '2026-05-21 01:45:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'participant', 'Indira', 'Destriana', '', 'dira@gmail.com', '081234567890', '$2y$10$vk5v7AweLN.7v2iDhHye9uSawVNQ2S/VdM.6pSHYjg9nlFKr3o.o.', '', '', '2026-05-26 02:05:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'participant', 'Indira', 'Destriana', '', 'indira@biotrop.org', '081234567890', '$2y$10$eiq3B4nFOkdxiue6EC2p6u5T5le04vr/WpDvwkxinjYJK6QMIcLeK', '', '', '2026-06-02 04:10:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'participant', 'Achmad', 'Fayad', '', 'fayad@biotrop.org', '081234567890', '$2y$10$XcQ7aHO.zIAWKq0ilaBC2uX.c1NUpKC0Gaaa.UKH.APwbMahcsJ9e', '', '', '2026-06-02 04:22:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'participant', 'Achmad', 'Fayad', '', 'fayad@biotrop.org1', '081234567890', '$2y$10$6lvVlyWEj03iIE2CzS7kJ.eQS8m6rbwIffn2qN1VW4wPRqh4Duz5q', '', '', '2026-06-02 06:31:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'participant', 'Indira', 'Destriana', '', 'indiradstrna@student.telkomuniversity.ac.id', '081234567890', '$2y$10$MkvEF.Jp315ScAzSIARFueRAjKcoNG6IXIprerwMj6fvN6uOJnXv6', 'uploads/1780382499_receipt_iPhone 11_ Verification Report_0000785E0AE0802E.png', 'uploads/1780382491_proof_FZL04616.JPG', '2026-06-02 06:41:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'participant', 'sheni', 'olvianda', 'Telkom University', 'test@gmail.com', '081234567890', '$2y$10$aHk.yICclKhsmWqOt8WVe.L1r2vZUBFfQ9ot3oQ1Jam.zMYpcIfTC', '', 'uploads/1780384947_proof_a8b0aed5cf58f96005c435f87dff8db5.jpg', '2026-06-02 07:17:39', 'Ms.', 'Female', 'Academic institution', 'Indonesia', 'Offline', 'No', '', ''),
(12, 'participant', 'Achmad ', 'Fayad', 'Telkom University', 'indira1@biotrop.org', '081324708264', '$2y$10$/QbLemKTOBhhpytGPUAsEOCZNIOBfaOqIyJnueRx/7yaTP1GqocyG', 'uploads/1780386313_receipt_Screenshot (4).png', 'uploads/1780386292_proof_6.  bukti upload foto formal.png', '2026-06-02 07:44:31', 'Ms.', 'Female', 'Academic institution', 'Indonesia', 'Offline', 'No', '', ''),
(13, 'author', 'M Raushan', 'Fiqr', 'SEAMEO BIOTROP', 'raushanfiqr14@gmail.com', '081383422616', '$2y$10$045IdeLPwNFGqa9ts1FCT.AU9/qi/jMkCyttdmFcb8kUebmIuuS2i', 'uploads/1780387066_receipt_WhatsApp_Image_2026-06-02_at_13.59.24-removebg-preview.png', '', '2026-06-02 07:53:57', 'Mr.', 'Male', 'Government', 'Indonesia', 'Offline', 'No', '', '-'),
(14, 'author', 'Haritz', 'Cahya Nugraha', 'SEAMEO BIOTROP', 'haritzcn@gmail.com', '6285649838585', '$2y$10$HHRotoEVFEoLmo6HakEPbecyaYMBELzNu06wiLHMpAa7YRDiPy2N2', '', '', '2026-06-08 02:56:43', 'Mr.', 'Male', 'Government', 'Indonesia', 'Offline', 'No', '', 'Halal Food');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `subthemes`
--

CREATE TABLE `subthemes` (
  `id` int NOT NULL,
  `id_theme` int NOT NULL,
  `sub_theme` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subthemes`
--

INSERT INTO `subthemes` (`id`, `id_theme`, `sub_theme`) VALUES
(1, 1, 'Geoparks & protected areas as living laboratories (aligned with UNESCO Global Geopark principles)'),
(2, 1, 'Inclusive biodiversity education models (schools & communities, gender-responsive)'),
(3, 1, 'Landscape-based, experiential, and community-driven learning'),
(4, 1, 'Management of weeds & invasive alien species (IAS)'),
(5, 1, 'Citizen science & participatory learning'),
(6, 1, 'Eco-DRR & nature-based solutions (including hazard mapping)'),
(7, 1, 'Strengthening community resilience & capacity'),
(8, 1, 'Community empowerment for conservation & sustainable landscape governance'),
(9, 1, 'Digital transformation in biodiversity education (e-learning, virtual labs, immersive technologies)'),
(10, 1, 'Artificial intelligence (AI), GIS, and remote sensing for biodiversity monitoring and participatory mapping'),
(11, 1, 'Digital citizen science platforms and data-driven environmental education'),
(12, 2, 'Sustainable utilization of sub-optimal and degraded lands'),
(13, 2, 'Ecological restoration and rehabilitation of post-mining areas'),
(14, 2, 'Soil, water, and ecosystem recovery strategies'),
(15, 2, 'Climate-resilient land management practices'),
(16, 2, 'Policy, governance, and innovation in land restoration'),
(17, 2, 'Circular economy approaches in land restoration and post-mining systems (waste-to-resource, resource efficiency)'),
(18, 2, 'AI and digital technologies for land monitoring, degradation assessment, and restoration planning'),
(19, 2, 'Remote sensing, big data, and digital twin technologies for landscape management'),
(20, 3, 'Integration of agro-tourism and ecotourism for biodiversity conservation'),
(21, 3, 'Community-based tourism and sustainable rural livelihoods'),
(22, 3, 'Circular economy approaches in agro-ecosystems'),
(23, 3, 'Conservation and sustainable utilization of edible insects'),
(24, 3, 'Education and capacity building through agro-eco-tourism models'),
(25, 3, 'Circular bioeconomy, regenerative agriculture, and zero-waste production systems'),
(26, 3, 'Digital platforms and smart technologies for sustainable livelihoods and eco-tourism'),
(27, 3, 'AI and precision agriculture for resource-efficient and climate-smart production systems'),
(28, 4, 'Environmental biotechnology and bioremediation'),
(29, 4, 'Microbial biotechnology for ecosystem restoration'),
(30, 4, 'Plant biotechnology for resilience and sustainable production'),
(31, 4, 'Biotechnology applications in biodiversity conservation'),
(32, 4, 'Biotechnology and climate change mitigation and adaptation'),
(33, 4, 'Biotechnological innovations for food, feed, fuel'),
(34, 4, 'Biotechnology for forest conservation'),
(35, 4, 'AI-driven biotechnology, bioinformatics, and big data analytics for biodiversity and environmental research'),
(36, 4, 'Integration of digital technologies in biotechnology for sustainable solutions');

-- --------------------------------------------------------

--
-- Struktur dari tabel `themes`
--

CREATE TABLE `themes` (
  `id` int NOT NULL,
  `theme` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `themes`
--

INSERT INTO `themes` (`id`, `theme`) VALUES
(1, 'Biodiversity Education through Geoparks, National Parks, and Landscape-Based Learning Systems'),
(2, 'Sustainable Management of Sub-optimal Lands and Post-Mining Landscapes'),
(3, 'Nature-Based Livelihoods'),
(4, 'Biotechnology for Biodiversity, Environment, and Climate Change');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_application`
--

CREATE TABLE `type_application` (
  `id` int NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `type_application`
--

INSERT INTO `type_application` (`id`, `type`) VALUES
(1, 'Oral'),
(2, 'Poster'),
(3, 'Oral or Poster');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_organization`
--

CREATE TABLE `type_organization` (
  `id` int NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `type_organization`
--

INSERT INTO `type_organization` (`id`, `type`) VALUES
(1, 'Government'),
(2, 'Non-Government'),
(3, 'Private Company'),
(4, 'Academic Institution'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_participant`
--

CREATE TABLE `type_participant` (
  `id` int NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `type_participant`
--

INSERT INTO `type_participant` (`id`, `type`) VALUES
(1, 'Author'),
(2, 'Exhibitor'),
(3, 'Participant Only');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_publication`
--

CREATE TABLE `type_publication` (
  `id` int NOT NULL,
  `kode` varchar(15) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `type_publication`
--

INSERT INTO `type_publication` (`id`, `kode`, `type`) VALUES
(1, 'pbook', 'Program book (abstract only) - free'),
(2, 'proceeding', 'Program book and proceeding (ext. abstract)'),
(3, 'journal', 'Program book and thematic issue (full paper) of BIOTROPIA, The Southeast Asian Journal of Tropical Biology (through Editorial and Publishing Process) - free');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_title`
--

CREATE TABLE `type_title` (
  `id` int NOT NULL,
  `title` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table of Title';

--
-- Dumping data untuk tabel `type_title`
--

INSERT INTO `type_title` (`id`, `title`) VALUES
(1, 'Mr.'),
(2, 'Ms.'),
(3, 'Dr.'),
(4, 'Prof.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `registration_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_participant_id` int NOT NULL,
  `type_organization_id` int DEFAULT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_title_id` int DEFAULT NULL,
  `countries_id` int DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `studentid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `funding` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fundingsource` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contribution` text COLLATE utf8mb4_unicode_ci,
  `allergies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `subthemes`
--
ALTER TABLE `subthemes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type_application`
--
ALTER TABLE `type_application`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type_organization`
--
ALTER TABLE `type_organization`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type_participant`
--
ALTER TABLE `type_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type_publication`
--
ALTER TABLE `type_publication`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type_title`
--
ALTER TABLE `type_title`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `subthemes`
--
ALTER TABLE `subthemes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `type_application`
--
ALTER TABLE `type_application`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `type_organization`
--
ALTER TABLE `type_organization`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `type_publication`
--
ALTER TABLE `type_publication`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `type_title`
--
ALTER TABLE `type_title`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
