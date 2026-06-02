-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jun 2026 pada 09.11
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ictb_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `apptype_id` varchar(255) NOT NULL,
  `subtheme_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `firstsubmit` int(11) NOT NULL,
  `publication_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `countries`
--

CREATE TABLE `countries` (
  `id` int(11) DEFAULT NULL,
  `country_name` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `participant_type` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT '',
  `bukti_diri` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `subthemes`
--

CREATE TABLE `subthemes` (
  `id` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL,
  `sub_theme` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `subthemes`
--

INSERT INTO `subthemes` (`id`, `id_theme`, `sub_theme`) VALUES
(1, 1, 'Restoration in parks and protected areas'),
(2, 1, 'Restoration in agro-ecological and silvicultural systems'),
(3, 1, 'Restoration in an urban context'),
(4, 1, 'Community and landscape scale restoration'),
(5, 2, 'Traditional ecological knowledge and community-based restoration'),
(6, 2, 'Monitoring and adaptive management'),
(7, 3, 'Threatened and endangered species, populations and habitats'),
(8, 3, 'Invasive species management'),
(9, 3, 'The role of restoration in mitigating and adapting to climate change'),
(10, 4, 'Planning and decision-making frameworks on ecological restoration'),
(11, 1, 'Restoration in mined areas'),
(12, 4, 'Effectivity & efficiency of policies and legal frameworks on ecological restoration'),
(13, 4, 'Science and policy interactions in determining ecological restoration options');

-- --------------------------------------------------------

--
-- Struktur dari tabel `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `theme` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `themes`
--

INSERT INTO `themes` (`id`, `theme`) VALUES
(1, 'Approaches, Techniques and Innovations in Ecological Restoration'),
(2, 'Socio-economic, Cultural and Ethical Dimensions of Ecological Restoration'),
(3, 'Ecological Restoration, Biodiversity, and Climate Change'),
(4, 'Ecological Restoration Policies and Other Legal Frameworks');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_application`
--

CREATE TABLE `type_application` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` int(11) NOT NULL,
  `title` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Table of Title';

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
  `id` int(10) UNSIGNED NOT NULL,
  `registration_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_participant_id` int(11) NOT NULL,
  `type_organization_id` int(11) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `type_title_id` int(11) DEFAULT NULL,
  `countries_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(125) DEFAULT NULL,
  `student` varchar(125) DEFAULT NULL,
  `studentid` varchar(255) DEFAULT NULL,
  `funding` varchar(125) DEFAULT NULL,
  `fundingsource` varchar(255) DEFAULT NULL,
  `contribution` text DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `payment` varchar(125) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `subthemes`
--
ALTER TABLE `subthemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `type_application`
--
ALTER TABLE `type_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `type_organization`
--
ALTER TABLE `type_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `type_publication`
--
ALTER TABLE `type_publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `type_title`
--
ALTER TABLE `type_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
