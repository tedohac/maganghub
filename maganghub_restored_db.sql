-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2021 at 10:08 PM
-- Server version: 10.3.30-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magangh1_maganghub`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_province_id` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_nama` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_province_id`, `city_nama`) VALUES
('1101', '11', 'Kab. Simeulue'),
('1102', '11', 'Kab. Aceh Singkil'),
('1103', '11', 'Kab. Aceh Selatan'),
('1104', '11', 'Kab. Aceh Tenggara'),
('1105', '11', 'Kab. Aceh Timur'),
('1106', '11', 'Kab. Aceh Tengah'),
('1107', '11', 'Kab. Aceh Barat'),
('1108', '11', 'Kab. Aceh Besar'),
('1109', '11', 'Kab. Pidie'),
('1110', '11', 'Kab. Bireuen'),
('1111', '11', 'Kab. Aceh Utara'),
('1112', '11', 'Kab. Aceh Barat Daya'),
('1113', '11', 'Kab. Gayo Lues'),
('1114', '11', 'Kab. Aceh Tamiang'),
('1115', '11', 'Kab. Nagan Raya'),
('1116', '11', 'Kab. Aceh Jaya'),
('1117', '11', 'Kab. Bener Meriah'),
('1118', '11', 'Kab. Pidie Jaya'),
('1171', '11', 'Kota Banda Aceh'),
('1172', '11', 'Kota Sabang'),
('1173', '11', 'Kota Langsa'),
('1174', '11', 'Kota Lhokseumawe'),
('1175', '11', 'Kota Subulussalam'),
('1201', '12', 'Kab. Nias'),
('1202', '12', 'Kab. Mandailing Natal'),
('1203', '12', 'Kab. Tapanuli Selatan'),
('1204', '12', 'Kab. Tapanuli Tengah'),
('1205', '12', 'Kab. Tapanuli Utara'),
('1206', '12', 'Kab. Toba Samosir'),
('1207', '12', 'Kab. Labuhan Batu'),
('1208', '12', 'Kab. Asahan'),
('1209', '12', 'Kab. Simalungun'),
('1210', '12', 'Kab. Dairi'),
('1211', '12', 'Kab. Karo'),
('1212', '12', 'Kab. Deli Serdang'),
('1213', '12', 'Kab. Langkat'),
('1214', '12', 'Kab. Nias Selatan'),
('1215', '12', 'Kab. Humbang Hasundutan'),
('1216', '12', 'Kab. Pakpak Bharat'),
('1217', '12', 'Kab. Samosir'),
('1218', '12', 'Kab. Serdang Bedagai'),
('1219', '12', 'Kab. Batu Bara'),
('1220', '12', 'Kab. Padang Lawas Utara'),
('1221', '12', 'Kab. Padang Lawas'),
('1222', '12', 'Kab. Labuhan Batu Selatan'),
('1223', '12', 'Kab. Labuhan Batu Utara'),
('1224', '12', 'Kab. Nias Utara'),
('1225', '12', 'Kab. Nias Barat'),
('1271', '12', 'Kota Sibolga'),
('1272', '12', 'Kota Tanjung Balai'),
('1273', '12', 'Kota Pematang Siantar'),
('1274', '12', 'Kota Tebing Tinggi'),
('1275', '12', 'Kota Medan'),
('1276', '12', 'Kota Binjai'),
('1277', '12', 'Kota Padangsidimpuan'),
('1278', '12', 'Kota Gunungsitoli'),
('1301', '13', 'Kab. Kepulauan Mentawai'),
('1302', '13', 'Kab. Pesisir Selatan'),
('1303', '13', 'Kab. Solok'),
('1304', '13', 'Kab. Sijunjung'),
('1305', '13', 'Kab. Tanah Datar'),
('1306', '13', 'Kab. Padang Pariaman'),
('1307', '13', 'Kab. Agam'),
('1308', '13', 'Kab. Lima Puluh Kota'),
('1309', '13', 'Kab. Pasaman'),
('1310', '13', 'Kab. Solok Selatan'),
('1311', '13', 'Kab. Dharmasraya'),
('1312', '13', 'Kab. Pasaman Barat'),
('1371', '13', 'Kota Padang'),
('1372', '13', 'Kota Solok'),
('1373', '13', 'Kota Sawah Lunto'),
('1374', '13', 'Kota Padang Panjang'),
('1375', '13', 'Kota Bukittinggi'),
('1376', '13', 'Kota Payakumbuh'),
('1377', '13', 'Kota Pariaman'),
('1401', '14', 'Kab. Kuantan Singingi'),
('1402', '14', 'Kab. Indragiri Hulu'),
('1403', '14', 'Kab. Indragiri Hilir'),
('1404', '14', 'Kab. Pelalawan'),
('1405', '14', 'Kab. S I A K'),
('1406', '14', 'Kab. Kampar'),
('1407', '14', 'Kab. Rokan Hulu'),
('1408', '14', 'Kab. Bengkalis'),
('1409', '14', 'Kab. Rokan Hilir'),
('1410', '14', 'Kab. Kepulauan Meranti'),
('1471', '14', 'Kota Pekanbaru'),
('1473', '14', 'Kota D U M A I'),
('1501', '15', 'Kab. Kerinci'),
('1502', '15', 'Kab. Merangin'),
('1503', '15', 'Kab. Sarolangun'),
('1504', '15', 'Kab. Batang Hari'),
('1505', '15', 'Kab. Muaro Jambi'),
('1506', '15', 'Kab. Tanjung Jabung Timur'),
('1507', '15', 'Kab. Tanjung Jabung Barat'),
('1508', '15', 'Kab. Tebo'),
('1509', '15', 'Kab. Bungo'),
('1571', '15', 'Kota Jambi'),
('1572', '15', 'Kota Sungai Penuh'),
('1601', '16', 'Kab. Ogan Komering Ulu'),
('1602', '16', 'Kab. Ogan Komering Ilir'),
('1603', '16', 'Kab. Muara Enim'),
('1604', '16', 'Kab. Lahat'),
('1605', '16', 'Kab. Musi Rawas'),
('1606', '16', 'Kab. Musi Banyuasin'),
('1607', '16', 'Kab. Banyu Asin'),
('1608', '16', 'Kab. Ogan Komering Ulu Selatan'),
('1609', '16', 'Kab. Ogan Komering Ulu Timur'),
('1610', '16', 'Kab. Ogan Ilir'),
('1611', '16', 'Kab. Empat Lawang'),
('1671', '16', 'Kota Palembang'),
('1672', '16', 'Kota Prabumulih'),
('1673', '16', 'Kota Pagar Alam'),
('1674', '16', 'Kota Lubuklinggau'),
('1701', '17', 'Kab. Bengkulu Selatan'),
('1702', '17', 'Kab. Rejang Lebong'),
('1703', '17', 'Kab. Bengkulu Utara'),
('1704', '17', 'Kab. Kaur'),
('1705', '17', 'Kab. Seluma'),
('1706', '17', 'Kab. Mukomuko'),
('1707', '17', 'Kab. Lebong'),
('1708', '17', 'Kab. Kepahiang'),
('1709', '17', 'Kab. Bengkulu Tengah'),
('1771', '17', 'Kota Bengkulu'),
('1801', '18', 'Kab. Lampung Barat'),
('1802', '18', 'Kab. Tanggamus'),
('1803', '18', 'Kab. Lampung Selatan'),
('1804', '18', 'Kab. Lampung Timur'),
('1805', '18', 'Kab. Lampung Tengah'),
('1806', '18', 'Kab. Lampung Utara'),
('1807', '18', 'Kab. Way Kanan'),
('1808', '18', 'Kab. Tulangbawang'),
('1809', '18', 'Kab. Pesawaran'),
('1810', '18', 'Kab. Pringsewu'),
('1811', '18', 'Kab. Mesuji'),
('1812', '18', 'Kab. Tulang Bawang Barat'),
('1813', '18', 'Kab. Pesisir Barat'),
('1871', '18', 'Kota Bandar Lampung'),
('1872', '18', 'Kota Metro'),
('1901', '19', 'Kab. Bangka'),
('1902', '19', 'Kab. Belitung'),
('1903', '19', 'Kab. Bangka Barat'),
('1904', '19', 'Kab. Bangka Tengah'),
('1905', '19', 'Kab. Bangka Selatan'),
('1906', '19', 'Kab. Belitung Timur'),
('1971', '19', 'Kota Pangkal Pinang'),
('2101', '21', 'Kab. Karimun'),
('2102', '21', 'Kab. Bintan'),
('2103', '21', 'Kab. Natuna'),
('2104', '21', 'Kab. Lingga'),
('2105', '21', 'Kab. Kepulauan Anambas'),
('2171', '21', 'Kota B A T A M'),
('2172', '21', 'Kota Tanjung Pinang'),
('3101', '31', 'Kab. Kepulauan Seribu'),
('3171', '31', 'Kota Jakarta Selatan'),
('3172', '31', 'Kota Jakarta Timur'),
('3173', '31', 'Kota Jakarta Pusat'),
('3174', '31', 'Kota Jakarta Barat'),
('3175', '31', 'Kota Jakarta Utara'),
('3201', '32', 'Kab. Bogor'),
('3202', '32', 'Kab. Sukabumi'),
('3203', '32', 'Kab. Cianjur'),
('3204', '32', 'Kab. Bandung'),
('3205', '32', 'Kab. Garut'),
('3206', '32', 'Kab. Tasikmalaya'),
('3207', '32', 'Kab. Ciamis'),
('3208', '32', 'Kab. Kuningan'),
('3209', '32', 'Kab. Cirebon'),
('3210', '32', 'Kab. Majalengka'),
('3211', '32', 'Kab. Sumedang'),
('3212', '32', 'Kab. Indramayu'),
('3213', '32', 'Kab. Subang'),
('3214', '32', 'Kab. Purwakarta'),
('3215', '32', 'Kab. Karawang'),
('3216', '32', 'Kab. Bekasi'),
('3217', '32', 'Kab. Bandung Barat'),
('3218', '32', 'Kab. Pangandaran'),
('3271', '32', 'Kota Bogor'),
('3272', '32', 'Kota Sukabumi'),
('3273', '32', 'Kota Bandung'),
('3274', '32', 'Kota Cirebon'),
('3275', '32', 'Kota Bekasi'),
('3276', '32', 'Kota Depok'),
('3277', '32', 'Kota Cimahi'),
('3278', '32', 'Kota Tasikmalaya'),
('3279', '32', 'Kota Banjar'),
('3301', '33', 'Kab. Cilacap'),
('3302', '33', 'Kab. Banyumas'),
('3303', '33', 'Kab. Purbalingga'),
('3304', '33', 'Kab. Banjarnegara'),
('3305', '33', 'Kab. Kebumen'),
('3306', '33', 'Kab. Purworejo'),
('3307', '33', 'Kab. Wonosobo'),
('3308', '33', 'Kab. Magelang'),
('3309', '33', 'Kab. Boyolali'),
('3310', '33', 'Kab. Klaten'),
('3311', '33', 'Kab. Sukoharjo'),
('3312', '33', 'Kab. Wonogiri'),
('3313', '33', 'Kab. Karanganyar'),
('3314', '33', 'Kab. Sragen'),
('3315', '33', 'Kab. Grobogan'),
('3316', '33', 'Kab. Blora'),
('3317', '33', 'Kab. Rembang'),
('3318', '33', 'Kab. Pati'),
('3319', '33', 'Kab. Kudus'),
('3320', '33', 'Kab. Jepara'),
('3321', '33', 'Kab. Demak'),
('3322', '33', 'Kab. Semarang'),
('3323', '33', 'Kab. Temanggung'),
('3324', '33', 'Kab. Kendal'),
('3325', '33', 'Kab. Batang'),
('3326', '33', 'Kab. Pekalongan'),
('3327', '33', 'Kab. Pemalang'),
('3328', '33', 'Kab. Tegal'),
('3329', '33', 'Kab. Brebes'),
('3371', '33', 'Kota Magelang'),
('3372', '33', 'Kota Surakarta'),
('3373', '33', 'Kota Salatiga'),
('3374', '33', 'Kota Semarang'),
('3375', '33', 'Kota Pekalongan'),
('3376', '33', 'Kota Tegal'),
('3401', '34', 'Kab. Kulon Progo'),
('3402', '34', 'Kab. Bantul'),
('3403', '34', 'Kab. Gunung Kidul'),
('3404', '34', 'Kab. Sleman'),
('3471', '34', 'Kota Yogyakarta'),
('3501', '35', 'Kab. Pacitan'),
('3502', '35', 'Kab. Ponorogo'),
('3503', '35', 'Kab. Trenggalek'),
('3504', '35', 'Kab. Tulungagung'),
('3505', '35', 'Kab. Blitar'),
('3506', '35', 'Kab. Kediri'),
('3507', '35', 'Kab. Malang'),
('3508', '35', 'Kab. Lumajang'),
('3509', '35', 'Kab. Jember'),
('3510', '35', 'Kab. Banyuwangi'),
('3511', '35', 'Kab. Bondowoso'),
('3512', '35', 'Kab. Situbondo'),
('3513', '35', 'Kab. Probolinggo'),
('3514', '35', 'Kab. Pasuruan'),
('3515', '35', 'Kab. Sidoarjo'),
('3516', '35', 'Kab. Mojokerto'),
('3517', '35', 'Kab. Jombang'),
('3518', '35', 'Kab. Nganjuk'),
('3519', '35', 'Kab. Madiun'),
('3520', '35', 'Kab. Magetan'),
('3521', '35', 'Kab. Ngawi'),
('3522', '35', 'Kab. Bojonegoro'),
('3523', '35', 'Kab. Tuban'),
('3524', '35', 'Kab. Lamongan'),
('3525', '35', 'Kab. Gresik'),
('3526', '35', 'Kab. Bangkalan'),
('3527', '35', 'Kab. Sampang'),
('3528', '35', 'Kab. Pamekasan'),
('3529', '35', 'Kab. Sumenep'),
('3571', '35', 'Kota Kediri'),
('3572', '35', 'Kota Blitar'),
('3573', '35', 'Kota Malang'),
('3574', '35', 'Kota Probolinggo'),
('3575', '35', 'Kota Pasuruan'),
('3576', '35', 'Kota Mojokerto'),
('3577', '35', 'Kota Madiun'),
('3578', '35', 'Kota Surabaya'),
('3579', '35', 'Kota Batu'),
('3601', '36', 'Kab. Pandeglang'),
('3602', '36', 'Kab. Lebak'),
('3603', '36', 'Kab. Tangerang'),
('3604', '36', 'Kab. Serang'),
('3671', '36', 'Kota Tangerang'),
('3672', '36', 'Kota Cilegon'),
('3673', '36', 'Kota Serang'),
('3674', '36', 'Kota Tangerang Selatan'),
('5101', '51', 'Kab. Jembrana'),
('5102', '51', 'Kab. Tabanan'),
('5103', '51', 'Kab. Badung'),
('5104', '51', 'Kab. Gianyar'),
('5105', '51', 'Kab. Klungkung'),
('5106', '51', 'Kab. Bangli'),
('5107', '51', 'Kab. Karang Asem'),
('5108', '51', 'Kab. Buleleng'),
('5171', '51', 'Kota Denpasar'),
('5201', '52', 'Kab. Lombok Barat'),
('5202', '52', 'Kab. Lombok Tengah'),
('5203', '52', 'Kab. Lombok Timur'),
('5204', '52', 'Kab. Sumbawa'),
('5205', '52', 'Kab. Dompu'),
('5206', '52', 'Kab. Bima'),
('5207', '52', 'Kab. Sumbawa Barat'),
('5208', '52', 'Kab. Lombok Utara'),
('5271', '52', 'Kota Mataram'),
('5272', '52', 'Kota Bima'),
('5301', '53', 'Kab. Sumba Barat'),
('5302', '53', 'Kab. Sumba Timur'),
('5303', '53', 'Kab. Kupang'),
('5304', '53', 'Kab. Timor Tengah Selatan'),
('5305', '53', 'Kab. Timor Tengah Utara'),
('5306', '53', 'Kab. Belu'),
('5307', '53', 'Kab. Alor'),
('5308', '53', 'Kab. Lembata'),
('5309', '53', 'Kab. Flores Timur'),
('5310', '53', 'Kab. Sikka'),
('5311', '53', 'Kab. Ende'),
('5312', '53', 'Kab. Ngada'),
('5313', '53', 'Kab. Manggarai'),
('5314', '53', 'Kab. Rote Ndao'),
('5315', '53', 'Kab. Manggarai Barat'),
('5316', '53', 'Kab. Sumba Tengah'),
('5317', '53', 'Kab. Sumba Barat Daya'),
('5318', '53', 'Kab. Nagekeo'),
('5319', '53', 'Kab. Manggarai Timur'),
('5320', '53', 'Kab. Sabu Raijua'),
('5371', '53', 'Kota Kupang'),
('6101', '61', 'Kab. Sambas'),
('6102', '61', 'Kab. Bengkayang'),
('6103', '61', 'Kab. Landak'),
('6104', '61', 'Kab. Pontianak'),
('6105', '61', 'Kab. Sanggau'),
('6106', '61', 'Kab. Ketapang'),
('6107', '61', 'Kab. Sintang'),
('6108', '61', 'Kab. Kapuas Hulu'),
('6109', '61', 'Kab. Sekadau'),
('6110', '61', 'Kab. Melawi'),
('6111', '61', 'Kab. Kayong Utara'),
('6112', '61', 'Kab. Kubu Raya'),
('6171', '61', 'Kota Pontianak'),
('6172', '61', 'Kota Singkawang'),
('6201', '62', 'Kab. Kotawaringin Barat'),
('6202', '62', 'Kab. Kotawaringin Timur'),
('6203', '62', 'Kab. Kapuas'),
('6204', '62', 'Kab. Barito Selatan'),
('6205', '62', 'Kab. Barito Utara'),
('6206', '62', 'Kab. Sukamara'),
('6207', '62', 'Kab. Lamandau'),
('6208', '62', 'Kab. Seruyan'),
('6209', '62', 'Kab. Katingan'),
('6210', '62', 'Kab. Pulang Pisau'),
('6211', '62', 'Kab. Gunung Mas'),
('6212', '62', 'Kab. Barito Timur'),
('6213', '62', 'Kab. Murung Raya'),
('6271', '62', 'Kota Palangka Raya'),
('6301', '63', 'Kab. Tanah Laut'),
('6302', '63', 'Kab. Kota Baru'),
('6303', '63', 'Kab. Banjar'),
('6304', '63', 'Kab. Barito Kuala'),
('6305', '63', 'Kab. Tapin'),
('6306', '63', 'Kab. Hulu Sungai Selatan'),
('6307', '63', 'Kab. Hulu Sungai Tengah'),
('6308', '63', 'Kab. Hulu Sungai Utara'),
('6309', '63', 'Kab. Tabalong'),
('6310', '63', 'Kab. Tanah Bumbu'),
('6311', '63', 'Kab. Balangan'),
('6371', '63', 'Kota Banjarmasin'),
('6372', '63', 'Kota Banjar Baru'),
('6401', '64', 'Kab. Paser'),
('6402', '64', 'Kab. Kutai Barat'),
('6403', '64', 'Kab. Kutai Kartanegara'),
('6404', '64', 'Kab. Kutai Timur'),
('6405', '64', 'Kab. Berau'),
('6409', '64', 'Kab. Penajam Paser Utara'),
('6471', '64', 'Kota Balikpapan'),
('6472', '64', 'Kota Samarinda'),
('6474', '64', 'Kota Bontang'),
('6501', '65', 'Kab. Malinau'),
('6502', '65', 'Kab. Bulungan'),
('6503', '65', 'Kab. Tana Tidung'),
('6504', '65', 'Kab. Nunukan'),
('6571', '65', 'Kota Tarakan'),
('7101', '71', 'Kab. Bolaang Mongondow'),
('7102', '71', 'Kab. Minahasa'),
('7103', '71', 'Kab. Kepulauan Sangihe'),
('7104', '71', 'Kab. Kepulauan Talaud'),
('7105', '71', 'Kab. Minahasa Selatan'),
('7106', '71', 'Kab. Minahasa Utara'),
('7107', '71', 'Kab. Bolaang Mongondow Utara'),
('7108', '71', 'Kab. Siau Tagulandang Biaro'),
('7109', '71', 'Kab. Minahasa Tenggara'),
('7110', '71', 'Kab. Bolaang Mongondow Selatan'),
('7111', '71', 'Kab. Bolaang Mongondow Timur'),
('7171', '71', 'Kota Manado'),
('7172', '71', 'Kota Bitung'),
('7173', '71', 'Kota Tomohon'),
('7174', '71', 'Kota Kotamobagu'),
('7201', '72', 'Kab. Banggai Kepulauan'),
('7202', '72', 'Kab. Banggai'),
('7203', '72', 'Kab. Morowali'),
('7204', '72', 'Kab. Poso'),
('7205', '72', 'Kab. Donggala'),
('7206', '72', 'Kab. Toli-toli'),
('7207', '72', 'Kab. Buol'),
('7208', '72', 'Kab. Parigi Moutong'),
('7209', '72', 'Kab. Tojo Una-una'),
('7210', '72', 'Kab. Sigi'),
('7271', '72', 'Kota Palu'),
('7301', '73', 'Kab. Kepulauan Selayar'),
('7302', '73', 'Kab. Bulukumba'),
('7303', '73', 'Kab. Bantaeng'),
('7304', '73', 'Kab. Jeneponto'),
('7305', '73', 'Kab. Takalar'),
('7306', '73', 'Kab. Gowa'),
('7307', '73', 'Kab. Sinjai'),
('7308', '73', 'Kab. Maros'),
('7309', '73', 'Kab. Pangkajene Dan Kepulauan'),
('7310', '73', 'Kab. Barru'),
('7311', '73', 'Kab. Bone'),
('7312', '73', 'Kab. Soppeng'),
('7313', '73', 'Kab. Wajo'),
('7314', '73', 'Kab. Sidenreng Rappang'),
('7315', '73', 'Kab. Pinrang'),
('7316', '73', 'Kab. Enrekang'),
('7317', '73', 'Kab. Luwu'),
('7318', '73', 'Kab. Tana Toraja'),
('7322', '73', 'Kab. Luwu Utara'),
('7325', '73', 'Kab. Luwu Timur'),
('7326', '73', 'Kab. Toraja Utara'),
('7371', '73', 'Kota Makassar'),
('7372', '73', 'Kota Parepare'),
('7373', '73', 'Kota Palopo'),
('7401', '74', 'Kab. Buton'),
('7402', '74', 'Kab. Muna'),
('7403', '74', 'Kab. Konawe'),
('7404', '74', 'Kab. Kolaka'),
('7405', '74', 'Kab. Konawe Selatan'),
('7406', '74', 'Kab. Bombana'),
('7407', '74', 'Kab. Wakatobi'),
('7408', '74', 'Kab. Kolaka Utara'),
('7409', '74', 'Kab. Buton Utara'),
('7410', '74', 'Kab. Konawe Utara'),
('7471', '74', 'Kota Kendari'),
('7472', '74', 'Kota Baubau'),
('7501', '75', 'Kab. Boalemo'),
('7502', '75', 'Kab. Gorontalo'),
('7503', '75', 'Kab. Pohuwato'),
('7504', '75', 'Kab. Bone Bolango'),
('7505', '75', 'Kab. Gorontalo Utara'),
('7571', '75', 'Kota Gorontalo'),
('7601', '76', 'Kab. Majene'),
('7602', '76', 'Kab. Polewali Mandar'),
('7603', '76', 'Kab. Mamasa'),
('7604', '76', 'Kab. Mamuju'),
('7605', '76', 'Kab. Mamuju Utara'),
('8101', '81', 'Kab. Maluku Tenggara Barat'),
('8102', '81', 'Kab. Maluku Tenggara'),
('8103', '81', 'Kab. Maluku Tengah'),
('8104', '81', 'Kab. Buru'),
('8105', '81', 'Kab. Kepulauan Aru'),
('8106', '81', 'Kab. Seram Bagian Barat'),
('8107', '81', 'Kab. Seram Bagian Timur'),
('8108', '81', 'Kab. Maluku Barat Daya'),
('8109', '81', 'Kab. Buru Selatan'),
('8171', '81', 'Kota Ambon'),
('8172', '81', 'Kota Tual'),
('8201', '82', 'Kab. Halmahera Barat'),
('8202', '82', 'Kab. Halmahera Tengah'),
('8203', '82', 'Kab. Kepulauan Sula'),
('8204', '82', 'Kab. Halmahera Selatan'),
('8205', '82', 'Kab. Halmahera Utara'),
('8206', '82', 'Kab. Halmahera Timur'),
('8207', '82', 'Kab. Pulau Morotai'),
('8271', '82', 'Kota Ternate'),
('8272', '82', 'Kota Tidore Kepulauan'),
('9101', '91', 'Kab. Fakfak'),
('9102', '91', 'Kab. Kaimana'),
('9103', '91', 'Kab. Teluk Wondama'),
('9104', '91', 'Kab. Teluk Bintuni'),
('9105', '91', 'Kab. Manokwari'),
('9106', '91', 'Kab. Sorong Selatan'),
('9107', '91', 'Kab. Sorong'),
('9108', '91', 'Kab. Raja Ampat'),
('9109', '91', 'Kab. Tambrauw'),
('9110', '91', 'Kab. Maybrat'),
('9171', '91', 'Kota Sorong'),
('9401', '94', 'Kab. Merauke'),
('9402', '94', 'Kab. Jayawijaya'),
('9403', '94', 'Kab. Jayapura'),
('9404', '94', 'Kab. Nabire'),
('9408', '94', 'Kab. Kepulauan Yapen'),
('9409', '94', 'Kab. Biak Numfor'),
('9410', '94', 'Kab. Paniai'),
('9411', '94', 'Kab. Puncak Jaya'),
('9412', '94', 'Kab. Mimika'),
('9413', '94', 'Kab. Boven Digoel'),
('9414', '94', 'Kab. Mappi'),
('9415', '94', 'Kab. Asmat'),
('9416', '94', 'Kab. Yahukimo'),
('9417', '94', 'Kab. Pegunungan Bintang'),
('9418', '94', 'Kab. Tolikara'),
('9419', '94', 'Kab. Sarmi'),
('9420', '94', 'Kab. Keerom'),
('9426', '94', 'Kab. Waropen'),
('9427', '94', 'Kab. Supiori'),
('9428', '94', 'Kab. Mamberamo Raya'),
('9429', '94', 'Kab. Nduga'),
('9430', '94', 'Kab. Lanny Jaya'),
('9431', '94', 'Kab. Mamberamo Tengah'),
('9432', '94', 'Kab. Yalimo'),
('9433', '94', 'Kab. Puncak'),
('9434', '94', 'Kab. Dogiyai'),
('9435', '94', 'Kab. Intan Jaya'),
('9436', '94', 'Kab. Deiyai'),
('9471', '94', 'Kota Jayapura');

-- --------------------------------------------------------

--
-- Table structure for table `dospems`
--

CREATE TABLE `dospems` (
  `dospem_id` bigint(20) UNSIGNED NOT NULL,
  `dospem_user_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dospem_prodi_id` bigint(20) UNSIGNED NOT NULL,
  `dospem_nik` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dospem_nama` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dospems`
--

INSERT INTO `dospems` (`dospem_id`, `dospem_user_email`, `dospem_prodi_id`, `dospem_nik`, `dospem_nama`, `created_at`, `updated_at`) VALUES
(1, 'bambang@ui.co.id', 1, '09873927', 'Bambang Susilo', '2021-04-25 03:04:45', '2021-04-25 03:04:45'),
(2, 'john@esgul.com', 2, '9898989', 'John Doe', '2021-04-26 20:27:28', '2021-04-26 20:28:27'),
(3, 'niken@esgul.com', 3, '9990000', 'Niken Nur Khasanah', '2021-04-26 20:28:07', '2021-04-26 20:28:07'),
(4, 'bahri@esgul.com', 2, '1231233', 'Bahri', '2021-04-26 20:29:49', '2021-04-26 20:29:49'),
(5, 'arif@unbraw.co.id', 4, '09865234', 'Arif Wibowo', '2021-05-31 07:46:45', '2021-05-31 07:46:45'),
(6, 'salsabila@mercu.com', 5, '10091998', 'Sal Sabila', '2021-06-02 01:07:33', '2021-06-02 01:07:33'),
(7, 'ifan@pancasila.com', 7, '190876', 'Ifan Prihandi', '2021-06-08 09:35:58', '2021-06-08 09:35:58'),
(8, 'iwan@pancasila.com', 8, '1222345', 'Iwan', '2021-06-08 09:36:38', '2021-06-08 09:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `fungsis`
--

CREATE TABLE `fungsis` (
  `fungsi_id` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fungsi_nama` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `fungsis`
--

INSERT INTO `fungsis` (`fungsi_id`, `fungsi_nama`) VALUES
('00', 'admin'),
('01', 'akuntansi'),
('02', 'asuransi'),
('03', 'desain'),
('04', 'hospitality'),
('05', 'HRD'),
('06', 'hubungan masyarakat'),
('07', 'kesehatan'),
('08', 'keuangan'),
('09', 'konstruksi dan bangunan'),
('10', 'makanan dan minuman'),
('11', 'manajemen'),
('12', 'manufakturing'),
('13', 'media dan periklanan'),
('14', 'pelayanan profesional'),
('15', 'pendidikan'),
('16', 'pemasaran'),
('17', 'perawatan kecantikan'),
('18', 'perbankan'),
('19', 'perdagangan dan pembelian'),
('20', 'properti'),
('21', 'teknik'),
('22', 'teknologi informasi'),
('23', 'transportasi dan logistik'),
('24', 'sipil'),
('25', 'lainya ..');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `kegiatan_rekrut_id` bigint(20) UNSIGNED NOT NULL,
  `kegiatan_tgl` date NOT NULL,
  `kegiatan_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan_path` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan_verify_mentor` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`kegiatan_id`, `kegiatan_rekrut_id`, `kegiatan_tgl`, `kegiatan_desc`, `kegiatan_path`, `kegiatan_verify_mentor`) VALUES
(1, 2, '2021-04-28', 'Diskusi meeting untuk campaign', '2-20210428.txt', '2021-04-30 14:11:46'),
(2, 2, '2021-04-29', 'Edit Photo', '2-20210429.jpg', '2021-05-25 12:53:25'),
(3, 1, '2021-05-02', 'Menginput data laporan', '1-20210502.jpeg', '2021-05-02 23:43:14'),
(4, 1, '2021-05-03', 'Mmenginput data', '1-20210503.PNG', '2021-05-02 23:45:02'),
(5, 5, '2021-05-08', 'Menginput data karyawan PT Sejahtera&lt;br&gt;', '5-20210508.png', '2021-05-08 16:12:10'),
(6, 5, '2021-05-09', 'Mendata stock barang yang masuk&lt;br&gt;', '5-20210509.png', '2021-05-08 16:12:15'),
(7, 5, '2021-05-10', 'Membuat laporan hasil meeting 10 May 2021&lt;br&gt;', '5-20210510.png', '2021-05-08 16:12:21'),
(8, 5, '2021-05-11', 'Membuat laporan hasil meeting 11 May 2021&lt;br&gt;', '5-20210511.png', '2021-05-08 16:12:26'),
(9, 5, '2021-05-12', 'Melakukan input data karyawan&lt;br&gt;', '5-20210512.png', '2021-05-08 16:12:30'),
(10, 5, '2021-05-13', 'Membuat bahan presentasi untuk meeting &lt;br&gt;', '5-20210513.png', '2021-05-08 16:12:34'),
(11, 5, '2021-05-14', 'Membuat laporan mingguan&lt;br&gt;', '5-20210514.png', '2021-05-08 16:12:38'),
(12, 5, '2021-05-15', 'Input data karyawan&lt;br&gt;', '5-20210515.png', '2021-05-08 16:12:42'),
(13, 5, '2021-05-16', 'Membuat laporan hasil meeting 16 May 2021&lt;br&gt;', '5-20210516.png', '2021-05-08 16:12:57'),
(14, 5, '2021-05-17', 'Input data stock barang&lt;br&gt;', '5-20210517.png', '2021-05-08 16:13:01'),
(15, 5, '2021-05-18', 'Input data stock barang&lt;br&gt;', '5-20210518.png', '2021-05-08 16:13:05'),
(16, 5, '2021-05-19', 'Input data stock barang&lt;br&gt;', '5-20210519.png', '2021-05-08 16:13:09'),
(17, 5, '2021-05-20', 'Input data stock barang&lt;br&gt;', '5-20210520.png', '2021-05-08 16:13:13'),
(18, 5, '2021-05-21', 'Input data stock barang', '5-20210521.png', '2021-05-08 16:13:17'),
(19, 5, '2021-05-22', 'Membuat laporan mingguan', '5-20210522.png', '2021-05-08 16:13:21'),
(32, 2, '2021-05-24', 'Diskusi dengan user', '2-20210524.png', '2021-05-25 11:42:01'),
(33, 4, '2021-05-28', 'test upload', '4-20210528.png', '2021-05-28 10:57:27'),
(34, 8, '2021-06-09', 'diskusi dengan user', '8-20210609.pdf', '2021-06-09 00:13:10'),
(35, 6, '2021-06-13', 'Perkenalan', '6-20210613.png', '2021-06-22 21:52:53'),
(36, 6, '2021-06-14', 'input data&lt;br&gt;', '6-20210614.png', '2021-06-22 21:52:58'),
(37, 6, '2021-06-15', 'input data&lt;br&gt;', '6-20210615.png', '2021-06-22 21:53:16'),
(38, 6, '2021-06-16', 'input data&lt;br&gt;', '6-20210616.png', '2021-06-22 21:53:21'),
(39, 6, '2021-06-17', 'input data', '6-20210617.png', '2021-06-22 21:53:25'),
(40, 6, '2021-06-18', 'input data', '6-20210618.png', '2021-06-22 21:53:30'),
(41, 6, '2021-06-19', 'input data', '6-20210619.png', '2021-06-22 21:53:34'),
(42, 6, '2021-06-20', 'input data', '6-20210620.png', '2021-06-22 21:53:39'),
(43, 6, '2021-06-21', '&lt;p&gt;input data&lt;/p&gt;', '6-20210621.png', '2021-06-22 21:53:45'),
(44, 6, '2021-06-22', 'input data', '6-20210622.png', '2021-06-22 21:53:51'),
(45, 6, '2021-06-23', 'input data', '6-20210623.png', '2021-06-22 21:53:57'),
(46, 6, '2021-06-24', 'input data', '6-20210624.png', '2021-06-22 21:54:02'),
(47, 6, '2021-06-25', 'input data', '6-20210625.png', '2021-06-22 21:54:09'),
(48, 6, '2021-06-26', 'input data', '6-20210626.png', '2021-06-22 21:54:17'),
(49, 6, '2021-06-27', 'input data', '6-20210627.pdf', '2021-06-22 21:54:22'),
(50, 6, '2021-06-28', 'input data', '6-20210628.png', '2021-06-22 21:54:26'),
(51, 6, '2021-06-29', 'input data', '6-20210629.png', '2021-06-22 21:54:31'),
(52, 6, '2021-06-30', 'input data', '6-20210630.png', '2021-06-22 21:54:36'),
(53, 6, '2021-07-01', 'input data', '6-20210701.png', '2021-06-22 21:46:42'),
(54, 6, '2021-07-02', 'input data', '6-20210702.png', '2021-06-22 21:46:49'),
(55, 6, '2021-06-01', 'input data', '6-20210601.png', '2021-06-22 21:49:39'),
(56, 6, '2021-06-02', 'input data', '6-20210602.png', '2021-06-22 21:49:43'),
(57, 6, '2021-06-03', 'input data', '6-20210603.png', '2021-06-22 21:49:48'),
(58, 6, '2021-06-04', 'input data', '6-20210604.PNG', '2021-06-22 21:49:53'),
(59, 6, '2021-06-05', 'input data', '6-20210605.png', '2021-06-22 21:49:58'),
(60, 6, '2021-06-06', 'input data', '6-20210606.png', '2021-06-22 21:50:04'),
(61, 6, '2021-06-07', 'input data', '6-20210607.png', '2021-06-22 21:50:10'),
(62, 6, '2021-06-08', 'input data', '6-20210608.png', '2021-06-22 21:50:15'),
(63, 6, '2021-06-09', 'input data', '6-20210609.png', '2021-06-22 21:50:20'),
(64, 6, '2021-06-10', 'input data', '6-20210610.png', '2021-06-22 21:50:35'),
(65, 6, '2021-06-11', 'input data', '6-20210611.png', '2021-06-22 21:50:39'),
(66, 6, '2021-06-12', 'input data', '6-20210612.png', '2021-06-22 21:52:38'),
(67, 5, '2021-05-23', 'Input data&lt;br&gt;', '5-20210523.jpeg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lowongans`
--

CREATE TABLE `lowongans` (
  `lowongan_id` bigint(20) UNSIGNED NOT NULL,
  `lowongan_perusahaan_id` bigint(20) UNSIGNED NOT NULL,
  `lowongan_fungsi_id` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_city_id` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_judul` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_tgl_mulai` date NOT NULL,
  `lowongan_durasi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_requirement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_jobdesk` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lowongan_jlh_dibutuhkan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `lowongans`
--

INSERT INTO `lowongans` (`lowongan_id`, `lowongan_perusahaan_id`, `lowongan_fungsi_id`, `lowongan_city_id`, `lowongan_status`, `lowongan_judul`, `lowongan_tgl_mulai`, `lowongan_durasi`, `lowongan_requirement`, `lowongan_jobdesk`, `lowongan_jlh_dibutuhkan`, `created_at`, `updated_at`) VALUES
(1, 1, '00', '3174', 'draft', 'Admin Staff', '2021-05-01', '3-Bulan', '&lt;p&gt;&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Usia max. 28 tahun&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Pendidikan minimal SMU sederajat.&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Mahir menggunakan Ms. Excel dan Ms. Office lainnya&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Teliti dan dapat mengetik dengan cepat&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Aktif di Media Sosial&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Rajin, tekun, sabar, dan disiplin&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Dapat bekerja di bawah tekanan&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Mampu berkomunikasi dengan baik dan Bekerja secara tim&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Pengalaman kerja min. 1 tahun di posisi Administrasi atau bidang terkait lainnya&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Diutamakan berpengalaman dibidang Food&amp;amp;Beverages&lt;/p&gt;&lt;br&gt;&lt;p&gt;&lt;/p&gt;', '&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Berkomunikasi dengan baik di platform google bisnis milik Perusahaan&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Input dan merekap database dari penjualan setiap harinya&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Merespon pertanyaan di WhatsApp dan Media Sosial&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Posting konten di WhatsApp Story dan Media Sosial&lt;/p&gt;&lt;p&gt;·&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;Broadcast program promosi Sales dan Marketing&lt;/p&gt;&lt;/span&gt;', 0, '2021-04-25 23:20:39', '2021-06-11 07:39:10'),
(2, 2, '16', '3171', 'post', 'Staff Marketing', '2021-05-03', '3-Bulan', '&lt;ol&gt;&lt;li&gt;Mampu membuat video pendek dan konten menarik&lt;/li&gt;&lt;li&gt;Terampil mengoperasikan Photoshop&lt;/li&gt;&lt;li&gt;Terbiasa atau memiliki kemampuan untuk menangani sosial media terutama target B2B\r\n&lt;/li&gt;&lt;li&gt;Terbiasa bekerja memiliki target viewer yang tinggi pada setiap postingan&lt;/li&gt;&lt;/ol&gt;', '&lt;ol&gt;&lt;li&gt;Membuat design untuk konten sosial media perusahaan\r\n&lt;/li&gt;&lt;li&gt;Membuat tools penjualan seperti video , brosur, pamflet dll\r\n&lt;/li&gt;&lt;li&gt;Meningkatkan branding perusahaan melalui konten digital\r\nMaintain website/social media perusahaan\r\n&lt;/li&gt;&lt;li&gt;Membuat acara kegiatan online/offline&lt;/li&gt;&lt;/ol&gt;', 1, '2021-04-26 19:48:27', '2021-06-08 09:58:22'),
(3, 2, '16', '3171', 'post', 'Marketing Solutions Intern', '2021-05-10', '3-Bulan', '&lt;ol&gt;&lt;li&gt;Saat ini belajar di universitas yang diakui\r\n&lt;/li&gt;&lt;li&gt;Mampu berkomunikasi dengan jelas dan ringkas&lt;/li&gt;&lt;li&gt;\r\nKemahiran dalam pemasaran digital dan perencanaan media digital lebih disukai&lt;/li&gt;&lt;li&gt;\r\nBerorientasi detail\r\nManajemen pemangku kepentingan yang kuat&lt;/li&gt;&lt;/ol&gt;', '&lt;ol&gt;&lt;li&gt;Menjadi bagian dari tim solusi pemasaran yang berfokus pada menawarkan kepada penjual akses ke aset pemasaran. Untuk mendorong lalu lintas dan penjualan\r\n&lt;/li&gt;&lt;li&gt;Pantau dan lacak kinerja pemasaran digital dari mitra merek\r\n&lt;/li&gt;&lt;li&gt;Dukung tim dalam mengkoordinasikan inisiatif seperti iklan Facebook dan Solusi Pemasaran &lt;/li&gt;&lt;li&gt;Afiliasi\r\nKoordinasi kampanye seperti 11.11, 12.12, CNY dengan bekerja sama dengan Manajer Akun Utama Pengembangan Bisnis dan brand partner&lt;/li&gt;&lt;li&gt;Pemrosesan laporan lalu lintas reguler&lt;/li&gt;&lt;/ol&gt;', 1, '2021-04-27 21:05:03', '2021-05-27 20:04:32'),
(4, 2, '00', '3174', 'post', 'Administrasi Projek', '2021-05-10', '2-Bulan', '&lt;p&gt;1. Mahasiswa semester akhir untuk semua jurusan&lt;/p&gt;&lt;p&gt;2. Mampu mengoperasikan Ms. Office&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;1. Melakukan Proses Data Entry\r\n&lt;/p&gt;&lt;p&gt;2. Melakukan Sesi Dokumentasi\r\n&lt;/p&gt;&lt;p&gt;3. Menjaga dan Mengecek Inventory Kantor\r\n&lt;/p&gt;&lt;p&gt;4. Mengecek Biaya Operasional dan Membuat Reiburstment Ke Pusat\r\n&lt;/p&gt;&lt;p&gt;5. Membuat Surat Jalan&lt;/p&gt;', 1, '2021-04-29 20:04:09', '2021-04-29 20:36:55'),
(5, 1, '22', '3171', 'post', 'Staff IT', '2021-06-05', '2-Bulan', '&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;ul&gt;&lt;li&gt;&lt;div&gt;Installing, configuring hardware, software, and other information processing facilities&lt;/div&gt;&lt;/li&gt;&lt;li&gt;Responding to user support for troubleshooting and repairing network connectivity issues&lt;/li&gt;&lt;li&gt;Maintaining hardware inventory and distribution, developing and maintining technical documentation&lt;/li&gt;&lt;li&gt;Testing and evaluating technologies&lt;/li&gt;&lt;li&gt;Interfacing with other teams/division and service vendors to resolve problems&lt;/li&gt;&lt;li&gt;Manage and support computer network, servers and workstations (users) on linux and windows platform&lt;/li&gt;&lt;li&gt;Report IT facilities usage, problems and solutions, service level&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', '&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;ul&gt;&lt;li&gt;Installing, configuring hardware, software, and other information processing facilities&lt;/li&gt;&lt;li&gt;Responding to user support for troubleshooting and repairing network connectivity issues&lt;/li&gt;&lt;li&gt;Maintaining hardware inventory and distribution, developing and maintining technical documentation&lt;/li&gt;&lt;li&gt;Testing and evaluating technologies&lt;/li&gt;&lt;li&gt;Interfacing with other teams/division and service vendors to resolve problems&lt;/li&gt;&lt;li&gt;Manage and support computer network, servers and workstations (users) on linux and windows platform&lt;/li&gt;&lt;li&gt;Report IT facilities usage, problems and solutions, service level&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', 3, '2021-05-31 05:10:46', '2021-05-31 05:10:46'),
(6, 4, '22', '3173', 'post', 'IT Network & Support Staff', '2021-06-23', '3-Bulan', '&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;ul&gt;&lt;li&gt;Maksimal 35 thn, berpengalaman minimal 2 tahun di bidang yg sama&lt;/li&gt;&lt;li&gt;Minimal Diploma/ S1 jurusan IT&lt;/li&gt;&lt;li&gt;Berdomisili di daerah Jalan Raya Perancis Tangerang dan sekitarnya&lt;/li&gt;&lt;li&gt;Menguasai LAN/WAN, Sql, Html, Mikrotik, CCTV, PoS, PABX, Finger Print&lt;/li&gt;&lt;li&gt;Menguasai instalasi &amp;amp; setting Server&lt;/li&gt;&lt;li&gt;Bersedia melakukan support ke cabang&lt;/li&gt;&lt;li&gt;Dapat bergabung secepatnya&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', '&lt;span class=&quot;FYwKg _2Bz3E C6ZIU_0 _6ufcS_0 _2DNlq_0 _29m7__0&quot;&gt;&lt;ul&gt;&lt;li&gt;Memperbaiki jaringan komputer yang bermasalah&lt;/li&gt;&lt;li&gt;Memperbaiki sistem, hardware, software yang bermasalah ketika user menggunakannya.&lt;/li&gt;&lt;li&gt;Melakukan update sistem maupun aplikasi&lt;/li&gt;&lt;li&gt;Melakukan instalasi dan konfigurasi&lt;/li&gt;&lt;li&gt;Melaksanakan back up data perusahaan&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', 3, '2021-05-31 08:02:53', '2021-05-31 08:02:53'),
(7, 2, '01', '3204', 'post', 'Accounting intern', '2021-07-17', '3-Bulan', '&lt;p&gt;Menguasai aplikasi komputer\r\n&lt;/p&gt;&lt;p&gt;Memiliki kemampuan bahasa Inggris\r\n&lt;/p&gt;&lt;p&gt;Menyukai pekerjaan pendataan dan akuntansi\r\n&lt;/p&gt;&lt;p&gt;Mampu bekerja-sama dengan baik.\r\n&lt;/p&gt;&lt;p&gt;Memiliki kemampuan komunikasi yang baik&lt;/p&gt;', '&lt;p&gt;Mengentri jurnal ke sistem&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 4, '2021-07-14 06:28:09', '2021-07-14 06:28:09'),
(8, 2, '05', '3204', 'post', 'HRGA Intern', '2021-08-02', '1-Bulan', '&lt;p&gt;Mahasiswa Semester Akhir / Fresh Graduate dari universitas terkemuka dengan IPK minimal 3,00.\r\n&lt;/p&gt;&lt;p&gt;Pemikiran analitis yang baik dan mampu bekerja di bawah tekanan.\r\n&lt;/p&gt;&lt;p&gt;Menguasai komputer&lt;/p&gt;&lt;p&gt;Bersedia ditempatkan di Bandung&lt;/p&gt;', '&lt;p&gt;Memantau dan melaporkan kehadiran mingguan dan bulanan\r\n&lt;/p&gt;&lt;p&gt;Memelihara database karyawan\r\n&lt;/p&gt;&lt;p&gt;Melakukan Recruitment &lt;/p&gt;&lt;p&gt;Mengelola General Affair&lt;/p&gt;', 1, '2021-07-14 06:32:55', '2021-07-14 06:32:55'),
(9, 9, '22', '3174', 'post', 'IT Application Development', '2021-08-12', '3-Bulan', '&lt;span class=&quot;sx2jih0 zcydq82b _18qlyvc0 _18qlyvcv _18qlyvc1 _18qlyvc8&quot;&gt;&lt;ul&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Candidate\r\n must possess at least Bachelor\'s Degree in Engineering \r\n(Computer/Telecommunication), Computer Science/Information Technology or\r\n equivalent.&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;At least 2 Year(s) of working experience in the related field is required for this position.&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Preferably Supervisor/Coordinator specialized in IT/Computer - Software or equivalent.&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Programming: Javascript (preferable), C#.net&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Database: SQL Server, PostgreSQL with store procedure, function, trigger, etc&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Knows another programming language are advantages&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Having knowledge in OOP/MVC Framework, API, or Mobile Programming is advantage&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Having knowledge in Manufacturing os advantage&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Comfortable producing well-commented and structured/modular code&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Strong personality, self motivation, able to work independent or team, and able to work under pressure&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Can make good relationship with team and user/customer&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Willing to be place at Tangerang, Banten&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', '&lt;span class=&quot;sx2jih0 zcydq82b _18qlyvc0 _18qlyvcv _18qlyvc1 _18qlyvc8&quot;&gt;&lt;ul&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Build and develop new or running applications&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Evaluate and improve performance on running applications&lt;/li&gt;&lt;li style=&quot;text-align:justify&quot;&gt;Conducting\r\n the process of research and development related to applications to be \r\nbuilt (technology, programming languages, database, etc.)&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', 4, '2021-07-15 07:22:35', '2021-07-15 07:22:35'),
(10, 9, '22', '1275', 'post', 'System Analyst', '2021-08-05', '3-Bulan', '&lt;span class=&quot;sx2jih0 zcydq82b _18qlyvc0 _18qlyvcv _18qlyvc1 _18qlyvc8&quot;&gt;&lt;li&gt;Proven work experience as a system analyst minimal 3 years&lt;/li&gt;&lt;li&gt;At least 2 years of working experiences as programmer&lt;/li&gt;&lt;li&gt;Experience\r\n with software development, creating FSD, TSD,&amp;nbsp;Database Relationship \r\nDiagram, Sequence Diagram, Application Architecture Diagram&amp;nbsp;and other \r\nrequired documentation&lt;/li&gt;&lt;li&gt;Strong knowledge of business information system&lt;/li&gt;&lt;li&gt;Required\r\n Skill(s): Programming, SDLC, Software Development, Java, PHP, \r\nFullstack, ASP.net, .NET, Visual Basic, C#, Android, Frontend, Solution \r\nArchitecture, MVC, OOP, UML, FSD, TSD, UAT, Software Testing, Insurance,\r\n Finance&lt;/li&gt;&lt;li&gt;Familiarity with Enterprise application platform using .NET/Java &amp;amp; BI&lt;/li&gt;&lt;li&gt;Ability to explain technical details&lt;/li&gt;&lt;li&gt;Excellent analytical skills&lt;/li&gt;&lt;li&gt;Good English proficiency, especially in writing&lt;/li&gt;&lt;li&gt;Fast learner, good problem solving, teamwork and analytical skill&lt;/li&gt;&lt;/span&gt;&lt;br&gt;', '&lt;span class=&quot;sx2jih0 zcydq82b _18qlyvc0 _18qlyvcv _18qlyvc1 _18qlyvc8&quot;&gt;&lt;ul&gt;&lt;li&gt;Collecting, analyze requirements and confirm the functional requirements of the system to be developed&lt;/li&gt;&lt;li&gt;Prepare\r\n documentation related to system development in accordance with the \r\napplicable SDLC, including but not limited to FSD, TSD, Database \r\nRelationship Diagrams, Sequence Diagrams, Application Architecture \r\nDiagrams and other required documentation.&lt;/li&gt;&lt;li&gt;Coordinate and communicate effectively with the internal developer team, vendors and related parties.&lt;/li&gt;&lt;li&gt;Work closely with the team concerned to ensure application development goes as planned&lt;/li&gt;&lt;li&gt;Coordinating\r\n with business units, vendors and related parties in the process of \r\nclarifying the functions of the system being developed.&lt;/li&gt;&lt;li&gt;Provide \r\nsupport regarding the preparation and execution of tests, including in \r\nthe preparation of test scenarios and test scripts.&lt;/li&gt;&lt;li&gt;Assisting the Project Manager in preparing the required project documentation.&lt;/li&gt;&lt;li&gt;Assisting companies in analyzing operational risk from a functional point of view.&lt;/li&gt;&lt;/ul&gt;&lt;/span&gt;&lt;br&gt;', 3, '2021-07-15 07:24:17', '2021-07-15 07:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_user_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_dospem_id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_city_id` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_nim` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mahasiswa_nama` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mahasiswa_no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_alamat` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_tempat_lahir` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_tgl_lahir` date DEFAULT NULL,
  `mahasiswa_profile_pict` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_cv` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_khs` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mahasiswa_status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mahasiswas`
--

INSERT INTO `mahasiswas` (`mahasiswa_id`, `mahasiswa_user_email`, `mahasiswa_dospem_id`, `mahasiswa_city_id`, `mahasiswa_nim`, `mahasiswa_nama`, `mahasiswa_no_tlp`, `mahasiswa_alamat`, `mahasiswa_tempat_lahir`, `mahasiswa_tgl_lahir`, `mahasiswa_profile_pict`, `mahasiswa_cv`, `mahasiswa_khs`, `mahasiswa_status`, `created_at`, `updated_at`) VALUES
(1, 'ari@ui.co.id', 1, '3171', '41819183747', 'Ari Setyati', '085683375923', 'Jl Mawar No 4', 'Jakarta', '1999-07-22', '1.jpeg', '1.png', '1.pdf', 'selesai', '2021-04-25 03:05:53', '2021-05-04 16:58:29'),
(2, 'nate@esgul.com', 3, '3171', '1422116', 'Nate Crang', '0898765456', 'Setiabudi', 'Jakarta', '1999-11-29', '2.jpg', '2.pdf', '2.pdf', 'magang', '2021-04-27 20:52:20', '2021-05-28 03:04:32'),
(3, 'jean@esgul.com', 2, '3173', '1288643', 'Jeannette Leyshon', '0858787898', 'Kemayotran', 'Jakarta', '1998-10-28', '3.jpg', '3.pdf', '3.pdf', 'selesai', '2021-04-27 20:54:09', '2021-07-14 14:36:27'),
(4, 'blane@esgul.com', 4, NULL, '9220757', 'Blane Oscroft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mencari', '2021-04-27 20:54:14', '2021-04-27 20:54:14'),
(5, 'sherline@esgul.com', 2, '3171', '8520442', 'Sherline Simeone', '08597878788', 'jakarta', 'Jakarta', '2000-12-28', '5.jpg', '5.pdf', '5.pdf', 'mencari', '2021-04-27 20:54:18', '2021-06-11 08:06:21'),
(6, 'lega@ui.co.id', 1, '3175', '09863525', 'Lega Anrima', '083007652234', 'Jl Pluit Dalam', 'Jakarta', '1999-07-21', '6.jpg', '6.png', '6.png', 'magang', '2021-05-08 01:26:39', '2021-05-08 08:44:12'),
(7, 'deti@ui.co.id', 1, NULL, '098263322', 'Deti Febrianti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mencari', '2021-05-10 01:12:01', '2021-05-10 01:12:01'),
(8, 'bila@unbraw.co.id', 5, '3174', '4181711019', 'Sal Sabila', '08765326244', 'Jl Kebon Jeruk', 'Jakarta', '1998-11-25', '8.jpg', '8.pdf', '8.png', 'selesai', '2021-05-31 07:50:44', '2021-06-22 15:09:13'),
(9, 'tedo@pancasila.com', 7, NULL, '41811100', 'Tedo haris', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mencari', '2021-06-08 09:42:26', '2021-06-08 09:42:26'),
(10, 'niken@pancasila.com', 8, '3174', '41115566', 'Niken', '098789000', 'gondrong', 'Jakarta', '1998-12-17', '10.jpeg', '10.pdf', '10.pdf', 'selesai', '2021-06-08 09:43:01', '2021-06-08 17:35:30'),
(11, 'niken@unbraw.co.id', 5, '3671', '769365244', 'Niken Nur Khasanah', '087635273553', 'Jl Mawar No 4', 'Jakarta', '1998-12-17', '11.jpg', '11.pdf', '11.jpeg', 'mencari', '2021-06-15 08:46:08', '2021-06-15 08:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_08_19_000001_create_provinces_table', 1),
(5, '2019_08_19_000002_create_cities_table', 1),
(6, '2019_08_19_000004_create_univs_table', 1),
(7, '2019_08_19_000005_create_prodis_table', 1),
(8, '2019_08_19_000007_create_dospems_table', 1),
(9, '2020_11_06_153642_change_jenjang_length_on_prodis', 1),
(10, '2020_11_06_232959_rename_nik_and_nama_on_dospems', 1),
(11, '2020_11_20_021505_change_dospem_email_to_nullable', 1),
(12, '2020_11_20_080000_create_mahasiswas_table', 1),
(13, '2020_11_23_090156_create_skills_table', 1),
(14, '2020_11_27_132628_create_perusahaans_table', 1),
(15, '2020_11_30_000001_create_fungsis_table', 1),
(16, '2020_11_30_000002_create_lowongans_table', 1),
(17, '2020_12_04_035815_create_rekruts_table', 1),
(18, '2020_12_11_091616_add_tolak_undangan_reason_to_rekruts', 1),
(19, '2020_12_12_072324_create_kegiatans_table', 1),
(20, '2020_12_14_154024_add_verified_to_univs', 1),
(21, '2020_12_14_154921_add_verified_to_perusahaans', 1),
(22, '2020_12_15_073936_add_rating_to_rekruts', 1),
(24, '2021_04_24_022525_create_notifications_table', 2),
(25, '2021_06_13_123236_add_key_to_rekruts', 3),
(26, '2021_06_16_153507_add_aspek_to_rekruts', 4),
(27, '2021_06_16_163828_delete_rating_from_rekruts', 4),
(28, '2021_06_16_164014_add_rating2_from_rekruts', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('228e68b6-ebbe-4e33-88f2-b58ade425740', 'App\\Notifications\\Notifikasi', 'App\\User', 'niken@pancasila.com', '{\"text\":\"Selamat! anda diterima magang pada <b>PT. Abcd<\\/b>. Semoga sukses!\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/8\"}', '2021-06-08 10:00:08', '2021-06-08 16:58:26', '2021-06-08 10:00:08'),
('3c9d30d8-47cd-445a-9d4f-c3ee2da75239', 'App\\Notifications\\Notifikasi', 'App\\User', 'bila@unbraw.co.id', '{\"text\":\"<b>Pt Sejahtera Abadi<\\/b> mengundang anda untuk test pada 12 June 2021 pukul 19:30\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/6\"}', '2021-06-11 07:17:29', '2021-06-11 14:15:59', '2021-06-11 07:17:29'),
('5bca66fc-e329-49de-8e64-a7a33c0a4fa6', 'App\\Notifications\\Notifikasi', 'App\\User', 'bila@unbraw.co.id', '{\"text\":\"Mohon maaf, <b>Pt Sejahtera Abadi<\\/b> menolak lamaran anda pada lowongan Admin Staff\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/6\"}', '2021-06-08 08:46:45', '2021-06-08 08:44:55', '2021-06-08 08:46:45'),
('6ef5de7c-dd17-4fa7-bbb9-d0112875eadd', 'App\\Notifications\\Notifikasi', 'App\\User', 'hrd@abcd.com', '{\"text\":\"Lamaran baru dari <b>Universitas Esa Unggul<\\/b> pada lowongan Staff Marketing\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/pelamar?filter_status=melamar\"}', '2021-06-11 08:08:01', '2021-06-11 15:07:22', '2021-06-11 08:08:01'),
('749a7074-876a-4f43-a854-44db5fe82d84', 'App\\Notifications\\Notifikasi', 'App\\User', 'bila@unbraw.co.id', '{\"text\":\"<b>Pt Sejahtera Abadi<\\/b> membatalkan penolakan lamaran anda pada lowongan Admin Staff, semoga beruntung!\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/6\"}', '2021-06-08 08:47:44', '2021-06-08 08:47:29', '2021-06-08 08:47:44'),
('8c1365be-55f6-46e7-98ba-15a6341ce484', 'App\\Notifications\\Notifikasi', 'App\\User', 'niken@pancasila.com', '{\"text\":\"<b>PT. Abcd<\\/b> mengundang anda untuk test pada 11 June 2021 pukul 09:30\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/8\"}', '2021-06-08 09:54:21', '2021-06-08 16:53:38', '2021-06-08 09:54:21'),
('953be684-cb74-45fc-b9ae-67511552d4e9', 'App\\Notifications\\Notifikasi', 'App\\User', 'hrd@abcd.com', '{\"text\":\"Lamaran baru dari <b>Universitas Pancasila<\\/b> pada lowongan Staff Marketing\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/pelamar?filter_status=melamar\"}', '2021-06-08 09:52:10', '2021-06-08 16:50:23', '2021-06-08 09:52:10'),
('968d8f6a-5d69-4135-b14f-091d5c9d2cba', 'App\\Notifications\\Notifikasi', 'App\\User', 'bila@unbraw.co.id', '{\"text\":\"Selamat! anda diterima magang pada <b>Pt Sejahtera Abadi<\\/b>. Semoga sukses!\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detaillamaran\\/6\"}', '2021-06-14 08:56:30', '2021-06-11 14:39:14', '2021-06-14 08:56:30'),
('97910cd1-e6f9-430e-ae98-1414c770a5eb', 'App\\Notifications\\Notifikasi', 'App\\User', 'admin@sejahtera.co.id', '{\"text\":\"Lamaran baru dari <b>Universitas Brawijaya<\\/b> pada lowongan Staff IT\",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/pelamar?filter_status=melamar\"}', '2021-06-15 08:55:58', '2021-06-15 15:55:34', '2021-06-15 08:55:58'),
('a32cbb29-14a1-4af4-8fdf-b67981d05c36', 'App\\Notifications\\Notifikasi', 'App\\User', 'hrd@abcd.com', '{\"text\":\"<b>Niken<\\/b> mengkonfirrmasi undangan test anda pada 01 January 1970 pukul \",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detailpelamar\\/8\"}', '2021-07-14 06:23:57', '2021-06-08 16:54:31', '2021-07-14 06:23:57'),
('ab503229-b485-4b03-a363-c48fc3d3fc70', 'App\\Notifications\\Notifikasi', 'App\\User', 'admin@sejahtera.co.id', '{\"text\":\"<b>Sal Sabila<\\/b> mengkonfirrmasi undangan test anda pada 01 January 1970 pukul \",\"url\":\"http:\\/\\/maganghub.my.id\\/perekrutan\\/detailpelamar\\/6\"}', NULL, '2021-06-11 14:24:04', '2021-06-11 14:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaans`
--

CREATE TABLE `perusahaans` (
  `perusahaan_id` bigint(20) UNSIGNED NOT NULL,
  `perusahaan_user_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_city_id` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_nib` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_nama` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_alamat` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_profile_pict` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_nib_path` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_verified` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `perusahaans`
--

INSERT INTO `perusahaans` (`perusahaan_id`, `perusahaan_user_email`, `perusahaan_city_id`, `perusahaan_nib`, `perusahaan_nama`, `perusahaan_alamat`, `perusahaan_profile_pict`, `perusahaan_nib_path`, `perusahaan_no_tlp`, `perusahaan_website`, `perusahaan_verified`, `created_at`, `updated_at`) VALUES
(1, 'admin@sejahtera.co.id', '3173', '0983743', 'Pt Sejahtera Abadi', 'Jl Jendral Sudirman No 10', '1.jpg', '1.png', '021874872947', 'sejahteraabadi.co.id', NULL, '2021-04-25 02:59:23', '2021-04-25 03:01:24'),
(2, 'hrd@abcd.com', '3173', '1234567', 'ASKRINDO', 'Graha Askrindo Jalan Angkasa Blok B No.9, No.Kav. 8, Jl. Kota Baru Bandar Kemayoran, RW.10', '2.png', '2.pdf', '098989898', 'www.askrindo.com', '2021-05-28', '2021-04-26 19:42:12', '2021-07-14 07:59:46'),
(3, 'hrd@coba.com', NULL, '198765', 'Pt. Coba Coba', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-28 21:06:52', '2021-04-28 21:06:52'),
(4, 'admin@lintasarta.co.id', '3173', '9086532', 'Pt Aplikanusa Lintasarta', 'Gedung Menara Thamrin, Lt. 12, Jl. M.H. Thamrin No.Kav. 3, RT.2/RW.1, Kb. Sirih, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10250', '4.png', '4.pdf', '0217503456', 'www.lintasarta.net', NULL, '2021-05-31 07:58:55', '2021-05-31 08:01:12'),
(9, 'mayoraindah001@gmail.com', '3174', '987497', 'Pt. Mayora Indah', 'Jl. Tomang Raya Kav 21 – 23, Jakarta Barat', '9.png', '9.png', '02180637704', 'www.mayoraindah.co.id', NULL, '2021-07-15 07:14:58', '2021-07-15 07:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `prodis`
--

CREATE TABLE `prodis` (
  `prodi_id` bigint(20) UNSIGNED NOT NULL,
  `prodi_univ_id` bigint(20) UNSIGNED NOT NULL,
  `prodi_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi_fakultas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_jenjang` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_akreditasi` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `prodis`
--

INSERT INTO `prodis` (`prodi_id`, `prodi_univ_id`, `prodi_nama`, `prodi_fakultas`, `prodi_jenjang`, `prodi_akreditasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sistem Informasi', 'Ilmu Komputer', 'S1', 'a', '2021-04-25 03:03:27', '2021-04-25 03:03:27'),
(2, 2, 'Marketing Komunikasi', 'Fakultas Komunikasi', 'S1', 'b', '2021-04-26 20:14:15', '2021-04-26 20:14:15'),
(3, 2, 'Broadcasting', 'Fakultas Komunikasi', 'S1', 'a', '2021-04-26 20:14:48', '2021-04-26 20:14:48'),
(4, 3, 'Sistem Informasi', 'Ilmu Komputer', 'S1', 'a', '2021-05-31 07:44:15', '2021-05-31 07:44:30'),
(5, 4, 'Sistem Informasi', 'Fakultas Ilmu Komputer', 'S1', 'b', '2021-06-02 00:54:20', '2021-06-02 00:54:20'),
(6, 4, 'Teknik Informatika', 'Fakultas Ilmu Komputer', 'S1', 'a', '2021-06-02 00:55:13', '2021-06-02 00:55:13'),
(7, 5, 'Sistem Informasi', 'Fakultas Ilmu Komputer', 'D3', 'b', '2021-06-08 09:32:10', '2021-06-08 09:32:10'),
(8, 5, 'Teknologi Informasi', 'Fasilkom', 'S1', 'a', '2021-06-08 09:32:34', '2021-06-08 09:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_id` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_nama` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `province_nama`) VALUES
('11', 'Aceh'),
('12', 'Sumatera Utara'),
('13', 'Sumatera Barat'),
('14', 'Riau'),
('15', 'Jambi'),
('16', 'Sumatera Selatan'),
('17', 'Bengkulu'),
('18', 'Lampung'),
('19', 'Kepulauan Bangka Belitung'),
('21', 'Kepulauan Riau'),
('31', 'Dki Jakarta'),
('32', 'Jawa Barat'),
('33', 'Jawa Tengah'),
('34', 'Di Yogyakarta'),
('35', 'Jawa Timur'),
('36', 'Banten'),
('51', 'Bali'),
('52', 'Nusa Tenggara Barat'),
('53', 'Nusa Tenggara Timur'),
('61', 'Kalimantan Barat'),
('62', 'Kalimantan Tengah'),
('63', 'Kalimantan Selatan'),
('64', 'Kalimantan Timur'),
('65', 'Kalimantan Utara'),
('71', 'Sulawesi Utara'),
('72', 'Sulawesi Tengah'),
('73', 'Sulawesi Selatan'),
('74', 'Sulawesi Tenggara'),
('75', 'Gorontalo'),
('76', 'Sulawesi Barat'),
('81', 'Maluku'),
('82', 'Maluku Utara'),
('91', 'Papua Barat'),
('94', 'Papua');

-- --------------------------------------------------------

--
-- Table structure for table `rekruts`
--

CREATE TABLE `rekruts` (
  `rekrut_id` bigint(20) UNSIGNED NOT NULL,
  `rekrut_lowongan_id` bigint(20) UNSIGNED NOT NULL,
  `rekrut_mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `rekrut_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rekrut_undangan_waktu` datetime DEFAULT NULL,
  `rekrut_undangan_alamat` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekrut_undangan_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekrut_rating` int(11) DEFAULT NULL,
  `rekrut_aspek_kedisiplinan` int(11) DEFAULT NULL,
  `rekrut_aspek_keterampilan` int(11) DEFAULT NULL,
  `rekrut_aspek_sikap` int(11) DEFAULT NULL,
  `rekrut_waktu_melamar` datetime NOT NULL,
  `rekrut_waktu_diundang` datetime DEFAULT NULL,
  `rekrut_waktu_konfirmundangan` datetime DEFAULT NULL,
  `rekrut_waktu_tolakundangan` datetime DEFAULT NULL,
  `rekrut_tolakundangan_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekrut_waktu_diterima` datetime DEFAULT NULL,
  `rekrut_waktu_konfirmditerima` datetime DEFAULT NULL,
  `rekrut_finish` datetime DEFAULT NULL,
  `rekrut_ratingto_mahasiswa` int(11) DEFAULT NULL,
  `rekrut_ratingto_perusahaan` int(11) DEFAULT NULL,
  `rekrut_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekrut_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rekruts`
--

INSERT INTO `rekruts` (`rekrut_id`, `rekrut_lowongan_id`, `rekrut_mahasiswa_id`, `rekrut_status`, `rekrut_undangan_waktu`, `rekrut_undangan_alamat`, `rekrut_undangan_desc`, `rekrut_rating`, `rekrut_aspek_kedisiplinan`, `rekrut_aspek_keterampilan`, `rekrut_aspek_sikap`, `rekrut_waktu_melamar`, `rekrut_waktu_diundang`, `rekrut_waktu_konfirmundangan`, `rekrut_waktu_tolakundangan`, `rekrut_tolakundangan_reason`, `rekrut_waktu_diterima`, `rekrut_waktu_konfirmditerima`, `rekrut_finish`, `rekrut_ratingto_mahasiswa`, `rekrut_ratingto_perusahaan`, `rekrut_key`, `rekrut_feedback`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'finish', '2021-05-06 14:30:00', 'Jakarta Barat', 'Ayok Datang&lt;br&gt;', NULL, NULL, NULL, NULL, '2021-04-26 13:24:59', '2021-05-02 10:14:21', '2021-05-02 10:14:54', '2021-04-29 14:10:26', 'Waktunya tidak sesuai', '2021-05-02 23:29:28', NULL, NULL, NULL, NULL, 'PaZ8DRhPPkXXDvu', 'Kinerja sudah bagus, semoga kedepannya bisa ditingkatkan kembali', '2021-04-26 06:24:59', '2021-07-14 07:10:01'),
(2, 3, 3, 'finish', '2021-04-30 09:00:00', 'jakarta', '&lt;p&gt;Dear&amp;nbsp;Jeannette Leyshon,&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Dengan ini kami mengunda anda untuk melakukan interview secara tatap muka di perusahaan kami. Dengan detail sebagai berikut:&lt;/p&gt;', NULL, NULL, NULL, NULL, '2021-04-28 11:18:33', '2021-04-28 11:50:30', '2021-04-28 13:18:03', NULL, NULL, '2021-04-28 13:18:33', NULL, NULL, NULL, 9, 'uZrLdsbJolhUiQ5', 'good job!', '2021-04-28 04:18:33', '2021-07-14 14:36:27'),
(3, 2, 2, 'magang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-03 15:23:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-03 08:23:50', '2021-05-28 03:04:32'),
(4, 3, 2, 'lulus', '2021-05-31 09:00:00', 'jakarta', 'test', NULL, NULL, NULL, NULL, '2021-05-03 15:24:28', '2021-05-28 10:03:41', '2021-05-28 10:04:09', NULL, NULL, '2021-05-28 10:04:32', NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-03 08:24:28', '2021-05-28 03:04:32'),
(5, 1, 6, 'lulus', '2021-05-20 14:30:00', 'Jakarta Barat', 'Mohon Untuk kehadirannya untuk melakukan psikotest', NULL, NULL, NULL, NULL, '2021-05-08 15:42:15', '2021-05-08 15:43:36', '2021-05-08 15:44:05', NULL, NULL, '2021-05-08 15:44:12', NULL, NULL, NULL, NULL, 'wiaoQ0RqPRP4bHG', NULL, '2021-05-08 08:42:15', '2021-06-22 08:11:53'),
(6, 1, 8, 'finish', '2021-06-12 19:30:00', 'jakarta barat', 'ayok test', NULL, 90, 80, 90, '2021-06-08 21:45:34', '2021-06-11 21:15:54', '2021-06-11 21:24:04', NULL, NULL, '2021-06-11 21:39:10', NULL, '2021-06-22 22:08:32', 9, 9, '7XiPH', 'Good Job!!', '2021-06-08 14:45:34', '2021-06-22 15:09:13'),
(7, 5, 8, 'magang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-08 21:51:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-08 14:51:33', '2021-06-11 14:39:10'),
(8, 2, 10, 'finish', '2021-06-11 09:30:00', 'online', 'Dear niken', NULL, NULL, NULL, NULL, '2021-06-08 23:50:23', '2021-06-08 23:53:34', '2021-06-08 23:54:31', NULL, NULL, '2021-06-08 23:58:22', NULL, NULL, NULL, NULL, NULL, 'goodjob', '2021-06-08 16:50:23', '2021-06-08 17:35:30'),
(9, 2, 5, 'melamar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-11 22:07:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-11 15:07:22', '2021-06-11 15:07:22'),
(10, 5, 11, 'melamar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-15 22:55:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-15 15:55:34', '2021-06-15 15:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `skill_mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `skill_nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_mahasiswa_id`, `skill_nama`, `created_at`, `updated_at`) VALUES
(3, 1, 'Administrasi', '2021-04-25 23:21:59', '2021-04-25 23:21:59'),
(4, 1, 'MS Office', '2021-04-25 23:22:04', '2021-04-25 23:22:04'),
(5, 3, 'Interpersonal', '2021-04-27 21:14:59', '2021-04-27 21:14:59'),
(6, 3, 'Ms. Office', '2021-04-27 21:15:11', '2021-04-27 21:15:11'),
(7, 2, 'Komunikasi', '2021-05-03 01:22:08', '2021-05-03 01:22:08'),
(8, 2, 'Photoshop', '2021-05-03 01:22:18', '2021-05-03 01:22:18'),
(9, 2, 'Ms. Words', '2021-05-03 01:22:31', '2021-05-03 01:22:31'),
(10, 6, 'Administrasi', '2021-05-08 01:29:43', '2021-05-08 01:29:43'),
(11, 6, 'MS Office', '2021-05-08 01:29:48', '2021-05-08 01:29:48'),
(12, 8, 'Administrasi', '2021-05-31 07:55:41', '2021-05-31 07:55:41'),
(13, 8, 'Ms Office', '2021-05-31 07:55:49', '2021-05-31 07:55:49'),
(14, 10, 'Ms Office', '2021-06-08 09:47:24', '2021-06-08 09:47:24'),
(15, 5, 'ps', '2021-06-11 08:06:02', '2021-06-11 08:06:02'),
(16, 11, 'Ms Office', '2021-06-15 08:54:36', '2021-06-15 08:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `univs`
--

CREATE TABLE `univs` (
  `univ_id` bigint(20) UNSIGNED NOT NULL,
  `univ_user_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `univ_nama` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `univ_npsn` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `univ_akreditasi` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_tgl_berdiri` date DEFAULT NULL,
  `univ_alamat` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_profile_pict` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_city_id` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `univ_verified` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `univs`
--

INSERT INTO `univs` (`univ_id`, `univ_user_email`, `univ_nama`, `univ_npsn`, `univ_akreditasi`, `univ_tgl_berdiri`, `univ_alamat`, `univ_no_tlp`, `univ_website`, `univ_profile_pict`, `univ_city_id`, `univ_verified`, `created_at`, `updated_at`) VALUES
(1, 'admin@ui.co.id', 'Universitas Indonesia', '20107900', 'a', '1849-08-24', 'Jl. Margonda Raya, Pondok Cina, Kecamatan Beji, Kota Depok, Jawa Barat', '02178364255', 'ui.ac.id', '1.png', '3173', '2021-05-08', '2021-04-24 10:06:46', '2021-05-16 00:12:10'),
(2, 'admin@esgul.com', 'Universitas Esa Unggul', '0987654', 'a', '1986-10-01', 'Jl. Arjuna Utara No.9, RT.1/RW.2, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat, DKI Jakarta 11510', '0215674223', 'esaunggul.ac.id', '2.jpg', '3174', '2021-06-02', '2021-04-26 19:49:29', '2021-06-02 00:46:06'),
(3, 'admin@unbraw.co.id', 'Universitas Brawijaya', '20541640', 'a', NULL, 'Jl. Veteran, Ketawanggede, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145', NULL, 'ub.ac.id', '3.png', '3507', '2021-06-08', '2021-05-31 07:31:55', '2021-06-08 07:58:06'),
(4, 'admin@mercu.com', 'Universitas Mercubuana', '20107909', 'a', '1985-10-22', 'Jl. Raya, RT.4/RW.1, Meruya Sel., Kec. Kembangan, Jakarta, Daerah Khusus Ibukota Jakarta 11650', '0215840816', 'mercubuana.ac.id', '4.png', '3174', '2021-06-02', '2021-06-02 00:47:13', '2021-06-02 01:18:41'),
(5, 'admin@pancasila.com', 'Universitas Pancasila', '190890', 'a', '2021-03-31', 'depok', '021909090', 'pancasila.ac.id', '5.png', '3276', '2021-06-08', '2021-06-08 09:25:16', '2021-07-14 06:41:49'),
(6, 'tedohac@gmail.com', 'Politeknik Manufaktur Astra', '20107927', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-07-14', '2021-06-17 05:28:40', '2021-07-14 08:10:58'),
(15, 'admin@binus.com', 'Universitas Bina Nusantara', '20107884', 'a', '1981-07-01', 'Jl. Kebon Jeruk Raya No. 27, Kebon Jeruk', '0215345830', 'binus.ac.id', '15.png', '3174', '2021-07-14', '2021-07-14 08:06:22', '2021-07-14 08:11:04'),
(16, 'admin@trisakti.ac.id', 'Universitas Trisakti', '20107922', 'a', '1965-11-26', 'Jl. Kyai Tapa No.1, RT.6/RW.16, Grogol, Kec. Grogol petamburan, Kota Jakarta Barat DKI Jakarta 11440', '0215674166', 'www.trisakti.ac.id', '16.png', '3174', '2021-07-14', '2021-07-14 08:06:42', '2021-07-14 08:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email_verified_at` timestamp NULL DEFAULT NULL,
  `user_verify_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forgetpass_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_email`, `user_password`, `user_role`, `user_status`, `user_email_verified_at`, `user_verify_token`, `forgetpass_token`, `remember_token`, `created_at`, `updated_at`) VALUES
('admin@admin.com', '$2y$10$nfh4uOkyCTjeKTgxW41JHOSKqeCLQIGE28w4x8iD9DsrR.r3ElC3C', 'superadmin', '1', '2020-12-14 08:15:15', NULL, NULL, NULL, NULL, NULL),
('admin@binus.com', '$2y$10$5Lvagbovr0H5WxiSG4IQOu/l76lp4tjwPvV01k1iPOfj4aDpFqolu', 'admin kampus', '1', '2021-07-14 08:06:58', NULL, NULL, NULL, '2021-07-14 08:06:22', '2021-07-14 08:11:04'),
('admin@esgul.com', '$2y$10$cbDpWWuTd.jz82vAXavdne9qwa.dncXrDwGeXAXvLkJlo1Fo80jze', 'admin kampus', '1', '2021-04-26 19:49:53', NULL, NULL, NULL, '2021-04-26 19:49:29', '2021-06-02 00:46:06'),
('admin@lintasarta.co.id', '$2y$10$c8WxqPNNgyL7u5ynCnyqIuEO2Hkd4Ymn8iR6bdxKRGlKMcgKQ6H1y', 'perusahaan', '1', '2021-05-31 07:59:07', NULL, NULL, NULL, '2021-05-31 07:58:55', '2021-05-31 07:59:07'),
('admin@mercu.com', '$2y$10$75cdGD7bjvT5470uPeE5yuZ.RTOhdy0fhIWtjllnk8KDA0UmrKRKi', 'admin kampus', '1', '2021-06-02 00:48:05', NULL, NULL, NULL, '2021-06-02 00:47:13', '2021-06-02 01:18:41'),
('admin@pancasila.com', '$2y$10$MEyHoB.ek730.JAeJvBqqOY6XS9wnibY4kPoPZn3kWS9KEnEFsmHS', 'admin kampus', '1', '2021-06-08 09:27:34', NULL, NULL, NULL, '2021-06-08 09:25:16', '2021-06-08 09:30:25'),
('admin@sejahtera.co.id', '$2y$10$wuWp0RdYX54E97NEUiwLfuItZFNZ80UeRg3NAw0D.Qm9.BT3mGUpG', 'perusahaan', '1', '2021-04-25 02:59:38', NULL, NULL, NULL, '2021-04-25 02:59:23', '2021-04-25 02:59:38'),
('admin@trisakti.ac.id', '$2y$10$MTOnJPxkYh/WVYwA4Eg3nOO3pNxDstmJLWIWhN/zpMaIyRGXQHUmG', 'admin kampus', '1', '2021-07-14 08:06:54', NULL, NULL, NULL, '2021-07-14 08:06:42', '2021-07-14 08:11:06'),
('admin@ui.co.id', '$2y$10$yLx6ICRRoMmOrT/SW/CXyOZkTplqvYujfv.taj.b5oBmwwraDaQzG', 'admin kampus', '1', '2021-04-24 10:06:58', NULL, NULL, NULL, '2021-04-24 10:06:46', '2021-05-08 09:08:27'),
('admin@unbraw.co.id', '$2y$10$kal2cJqRficS3Qh/jrMaxeRVYPMVgbw9jnjNVxHAC1..VsEL7M/D.', 'admin kampus', '1', '2021-05-31 07:32:54', NULL, NULL, NULL, '2021-05-31 07:31:55', '2021-06-08 07:58:06'),
('ari@ui.co.id', '$2y$10$re1.lsRCr6rROWuUh/Tb/emMDBUiGq.JATeUWsncmIE2VugGdCRba', 'mahasiswa', '1', '2021-04-25 23:14:50', NULL, NULL, NULL, '2021-04-25 03:05:53', '2021-04-25 23:15:20'),
('arif@unbraw.co.id', '$2y$10$B/eKVsinDf1iCfzVduzbXeh7slgvuZfasCw7VKil46DOtFmcDyYkW', 'dospem', '1', '2021-05-31 07:51:01', NULL, NULL, NULL, '2021-05-31 07:46:45', '2021-05-31 07:57:52'),
('bahri@esgul.com', '$2y$10$qZXiGXwVhqygjQ0p.0F5gODuAuD8vsHVzkrs1DbL1T.r8jdKbuy8O', 'dospem', '1', NULL, 'mAuK7YjHO4fAQgI5slwSY1iBAnRZfalM', NULL, NULL, '2021-04-26 20:29:49', '2021-04-26 20:29:49'),
('bambang@ui.co.id', '$2y$10$yTSPhYBhIv4uBJkOU7XUjuif8INK99y8yRSAvSU6qn5on7Qe0y7.W', 'dospem', '1', '2021-04-25 23:14:40', NULL, NULL, NULL, '2021-04-25 03:04:45', '2021-05-04 05:15:37'),
('bila@unbraw.co.id', '$2y$10$A2dsjHt1fG0yxkQvGK/25ORmuYMHFF0ykH9f.ehJoUV5nH2RJx.CK', 'mahasiswa', '1', '2021-05-31 07:51:07', NULL, NULL, NULL, '2021-05-31 07:50:44', '2021-05-31 07:57:11'),
('blane@esgul.com', '$2y$10$G2hTXwIR.to5tM74Nm1COuWHh7DwddcPX03gopEkKoblJ8GaLu9eC', 'mahasiswa', '1', NULL, 'nEEgvfEJow3BGaQ9RJ0h70wkZsT3Lmh3', NULL, NULL, '2021-04-27 20:54:14', '2021-04-27 20:54:14'),
('deti@ui.co.id', '$2y$10$.QzC3xzDq2J4dF4DldVghO3vhz1yhZt17HhvEBlsnSMjtNkxoCUni', 'mahasiswa', '1', '2021-05-10 01:12:22', NULL, NULL, NULL, '2021-05-10 01:12:01', '2021-05-10 01:13:43'),
('hrd@abcd.com', '$2y$10$yjbgnsJJd.BXKngVh2qerOO2Ndnaz3antAS64m/z2NtUvkqvhI3d6', 'perusahaan', '1', '2021-04-26 19:42:34', NULL, NULL, NULL, '2021-04-26 19:42:12', '2021-04-26 19:42:34'),
('hrd@coba.com', '$2y$10$NSSwU9eqFOceYA63QCAJFeJSx1igV.QNsrrcp5Uaj0gjACSAljy9K', 'perusahaan', '1', '2021-04-28 21:07:06', NULL, NULL, NULL, '2021-04-28 21:06:52', '2021-04-28 21:07:06'),
('ifan@pancasila.com', '$2y$10$SenQBGYYiOzNAKmioFXBC.i6huxVGN5M/rWoWvX8wJnsU2VZO8DB6', 'dospem', '1', '2021-06-08 09:56:50', NULL, NULL, NULL, '2021-06-08 09:35:58', '2021-06-08 09:56:50'),
('iwan@pancasila.com', '$2y$10$JcXzHNvzExKP6wjD4r0seusHPaf9ILqdp7VkkTJbm2HhXX.HiV4uW', 'dospem', '1', '2021-06-08 09:57:16', NULL, NULL, NULL, '2021-06-08 09:36:38', '2021-06-08 09:57:16'),
('jean@esgul.com', '$2y$10$fR5p1oKEQHJxdjGaq.Bqw.JzCWF0ZFQNZMI/oQCRR9IzQsP2Ht7RK', 'mahasiswa', '1', '2021-04-27 21:11:34', NULL, NULL, NULL, '2021-04-27 20:54:09', '2021-04-27 21:48:29'),
('john@esgul.com', '$2y$10$QJT9No/jjqFH3JuCDPopq.mNONfORfb.lSLo0z7kfhn/jRW/Djkvy', 'dospem', '1', '2021-04-27 23:23:41', NULL, NULL, NULL, '2021-04-26 20:27:28', '2021-04-27 23:23:41'),
('lega@ui.co.id', '$2y$10$gLlOGMkvcnjR.PeK9zjIRep5VwUiUzWynkD7Cdnlu582mCsomVtOy', 'mahasiswa', '1', '2021-05-08 01:28:06', NULL, NULL, NULL, '2021-05-08 01:26:39', '2021-05-08 01:31:41'),
('mayoraindah001@gmail.com', '$2y$10$GTWhK/JUQZBuroZY/k3qe.eMGP1EtpjONW2kyXcXzU67ujUrKKgxW', 'perusahaan', '1', '2021-07-15 07:17:03', NULL, NULL, NULL, '2021-07-15 07:14:58', '2021-07-15 07:17:03'),
('nate@esgul.com', '$2y$10$XcZC5CtlXq.cS0axhrtJB.l.13ihKZ4XNM6SiCxk1H1ilTSnmajiW', 'mahasiswa', '1', '2021-05-03 00:15:34', NULL, NULL, NULL, '2021-04-27 20:52:20', '2021-05-03 00:15:34'),
('niken@esgul.com', '$2y$10$WL2pEu3BafnWq4F9FavDs.kQeiPX4Um5nuAwjdN9b8RXY/02RcdBW', 'dospem', '1', NULL, 'qAgGLacXz2SpE2bIYWtfxNQv3pccqG94', NULL, NULL, '2021-04-26 20:28:07', '2021-04-26 20:28:07'),
('niken@pancasila.com', '$2y$10$SbZ8TZniORcCcl1Jx7GaNejkmnc5SdS.X3oYGRq5hnPqXnINXGmQS', 'mahasiswa', '1', '2021-06-08 09:43:48', NULL, NULL, NULL, '2021-06-08 09:43:01', '2021-06-08 09:43:48'),
('niken@unbraw.co.id', '$2y$10$1A83uR2bJHDimU3ohCEb7.NVOEQUh.Ed9HklsXrMSmUeOAUEcO0di', 'mahasiswa', '1', '2021-06-15 08:46:51', NULL, NULL, NULL, '2021-06-15 08:46:08', '2021-06-15 08:51:59'),
('salsabila@mercu.com', '$2y$10$grwTkZeryj.thETL8j18MOC77HGEbhzygkpfDE7dR6j7Mx.t5jWmm', 'dospem', '1', NULL, 'YvUFbrSJzrpc1sGh44D8DbfGRJUX9UJI', NULL, NULL, '2021-06-02 01:07:33', '2021-06-02 01:07:33'),
('sherline@esgul.com', '$2y$10$Fb9jsOh6n2dPbcRKDm0GYe2nNW.CpAhVLC6JWWnQHz3XOGN8am0fO', 'mahasiswa', '1', '2021-06-08 08:04:16', NULL, NULL, NULL, '2021-04-27 20:54:18', '2021-06-08 08:04:16'),
('tedo@pancasila.com', '$2y$10$e9MNq79KRdEnmrRfB6yWguhOwZTHSdDeqYjRI8XcjTziiLX6Cu9/u', 'mahasiswa', '1', NULL, '8BbBXe06cMITqkzvyEv0y835c6W2rO5C', NULL, NULL, '2021-06-08 09:42:26', '2021-06-08 09:42:26'),
('tedohac@gmail.com', '$2y$10$wLd3fWAwOxJ/kBlExo7ZbOi8no9JcNbWyk6IttnJ2XyfQeQcmSkxK', 'admin kampus', '1', NULL, '9KXPb7EjNJKU8F6hLyJJM7JB3BqaFKja', NULL, NULL, '2021-06-17 05:28:40', '2021-07-14 08:10:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `cities_city_province_id_foreign` (`city_province_id`);

--
-- Indexes for table `dospems`
--
ALTER TABLE `dospems`
  ADD PRIMARY KEY (`dospem_id`),
  ADD KEY `dospems_dospem_user_email_foreign` (`dospem_user_email`),
  ADD KEY `dospems_dospem_prodi_id_index` (`dospem_prodi_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fungsis`
--
ALTER TABLE `fungsis`
  ADD PRIMARY KEY (`fungsi_id`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`kegiatan_id`),
  ADD KEY `kegiatans_kegiatan_rekrut_id_index` (`kegiatan_rekrut_id`);

--
-- Indexes for table `lowongans`
--
ALTER TABLE `lowongans`
  ADD PRIMARY KEY (`lowongan_id`),
  ADD KEY `lowongans_lowongan_fungsi_id_foreign` (`lowongan_fungsi_id`),
  ADD KEY `lowongans_lowongan_city_id_foreign` (`lowongan_city_id`),
  ADD KEY `lowongans_lowongan_perusahaan_id_index` (`lowongan_perusahaan_id`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`mahasiswa_id`),
  ADD KEY `mahasiswas_mahasiswa_user_email_foreign` (`mahasiswa_user_email`),
  ADD KEY `mahasiswas_mahasiswa_city_id_foreign` (`mahasiswa_city_id`),
  ADD KEY `mahasiswas_mahasiswa_dospem_id_index` (`mahasiswa_dospem_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifications_notifiable_id_foreign` (`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD PRIMARY KEY (`perusahaan_id`),
  ADD UNIQUE KEY `perusahaans_perusahaan_nib_unique` (`perusahaan_nib`),
  ADD KEY `perusahaans_perusahaan_user_email_foreign` (`perusahaan_user_email`),
  ADD KEY `perusahaans_perusahaan_city_id_foreign` (`perusahaan_city_id`);

--
-- Indexes for table `prodis`
--
ALTER TABLE `prodis`
  ADD PRIMARY KEY (`prodi_id`),
  ADD KEY `prodis_prodi_univ_id_index` (`prodi_univ_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `rekruts`
--
ALTER TABLE `rekruts`
  ADD PRIMARY KEY (`rekrut_id`),
  ADD KEY `rekruts_rekrut_lowongan_id_index` (`rekrut_lowongan_id`),
  ADD KEY `rekruts_rekrut_mahasiswa_id_index` (`rekrut_mahasiswa_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `skills_skill_mahasiswa_id_index` (`skill_mahasiswa_id`);

--
-- Indexes for table `univs`
--
ALTER TABLE `univs`
  ADD PRIMARY KEY (`univ_id`),
  ADD UNIQUE KEY `univs_univ_npsn_unique` (`univ_npsn`),
  ADD KEY `univs_univ_user_email_foreign` (`univ_user_email`),
  ADD KEY `univs_univ_city_id_foreign` (`univ_city_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dospems`
--
ALTER TABLE `dospems`
  MODIFY `dospem_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `kegiatan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `lowongans`
--
ALTER TABLE `lowongans`
  MODIFY `lowongan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `mahasiswa_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `perusahaans`
--
ALTER TABLE `perusahaans`
  MODIFY `perusahaan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prodis`
--
ALTER TABLE `prodis`
  MODIFY `prodi_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rekruts`
--
ALTER TABLE `rekruts`
  MODIFY `rekrut_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `univs`
--
ALTER TABLE `univs`
  MODIFY `univ_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_city_province_id_foreign` FOREIGN KEY (`city_province_id`) REFERENCES `provinces` (`province_id`);

--
-- Constraints for table `dospems`
--
ALTER TABLE `dospems`
  ADD CONSTRAINT `dospems_dospem_prodi_id_foreign` FOREIGN KEY (`dospem_prodi_id`) REFERENCES `prodis` (`prodi_id`),
  ADD CONSTRAINT `dospems_dospem_user_email_foreign` FOREIGN KEY (`dospem_user_email`) REFERENCES `users` (`user_email`);

--
-- Constraints for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD CONSTRAINT `kegiatans_kegiatan_rekrut_id_foreign` FOREIGN KEY (`kegiatan_rekrut_id`) REFERENCES `rekruts` (`rekrut_id`);

--
-- Constraints for table `lowongans`
--
ALTER TABLE `lowongans`
  ADD CONSTRAINT `lowongans_lowongan_city_id_foreign` FOREIGN KEY (`lowongan_city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `lowongans_lowongan_fungsi_id_foreign` FOREIGN KEY (`lowongan_fungsi_id`) REFERENCES `fungsis` (`fungsi_id`),
  ADD CONSTRAINT `lowongans_lowongan_perusahaan_id_foreign` FOREIGN KEY (`lowongan_perusahaan_id`) REFERENCES `perusahaans` (`perusahaan_id`);

--
-- Constraints for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_mahasiswa_city_id_foreign` FOREIGN KEY (`mahasiswa_city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `mahasiswas_mahasiswa_dospem_id_foreign` FOREIGN KEY (`mahasiswa_dospem_id`) REFERENCES `dospems` (`dospem_id`),
  ADD CONSTRAINT `mahasiswas_mahasiswa_user_email_foreign` FOREIGN KEY (`mahasiswa_user_email`) REFERENCES `users` (`user_email`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_notifiable_id_foreign` FOREIGN KEY (`notifiable_id`) REFERENCES `users` (`user_email`);

--
-- Constraints for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD CONSTRAINT `perusahaans_perusahaan_city_id_foreign` FOREIGN KEY (`perusahaan_city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `perusahaans_perusahaan_user_email_foreign` FOREIGN KEY (`perusahaan_user_email`) REFERENCES `users` (`user_email`);

--
-- Constraints for table `prodis`
--
ALTER TABLE `prodis`
  ADD CONSTRAINT `prodis_prodi_univ_id_foreign` FOREIGN KEY (`prodi_univ_id`) REFERENCES `univs` (`univ_id`);

--
-- Constraints for table `rekruts`
--
ALTER TABLE `rekruts`
  ADD CONSTRAINT `rekruts_rekrut_lowongan_id_foreign` FOREIGN KEY (`rekrut_lowongan_id`) REFERENCES `lowongans` (`lowongan_id`),
  ADD CONSTRAINT `rekruts_rekrut_mahasiswa_id_foreign` FOREIGN KEY (`rekrut_mahasiswa_id`) REFERENCES `mahasiswas` (`mahasiswa_id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_skill_mahasiswa_id_foreign` FOREIGN KEY (`skill_mahasiswa_id`) REFERENCES `mahasiswas` (`mahasiswa_id`);

--
-- Constraints for table `univs`
--
ALTER TABLE `univs`
  ADD CONSTRAINT `univs_univ_city_id_foreign` FOREIGN KEY (`univ_city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `univs_univ_user_email_foreign` FOREIGN KEY (`univ_user_email`) REFERENCES `users` (`user_email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
