-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 20, 2026 at 07:40 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labo`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `F_Calcul`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `F_Calcul` (`P_qte_stock` DOUBLE, `P_besoin` DOUBLE) RETURNS DOUBLE  BEGIN
   
    IF P_qte_stock< P_besoin THEN
        RETURN P_besoin-P_qte_stock;
    ELSE
        RETURN 0;
    END IF;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `besoin`
--

DROP TABLE IF EXISTS `besoin`;
CREATE TABLE IF NOT EXISTS `besoin` (
  `N_Mois` tinyint UNSIGNED NOT NULL,
  `Reference_P` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Quantite` int NOT NULL,
  PRIMARY KEY (`N_Mois`,`Reference_P`),
  KEY `fk_besoin_med` (`Reference_P`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `besoin`
--

INSERT INTO `besoin` (`N_Mois`, `Reference_P`, `Quantite`) VALUES
(1, 'MED001', 2000),
(1, 'MED002', 1500),
(1, 'MED003', 5000),
(2, 'MED001', 2200),
(2, 'MED003', 4800),
(2, 'MED004', 800),
(3, 'MED001', 1800),
(3, 'MED002', 1200),
(3, 'MED005', 3000),
(4, 'MED003', 6000),
(4, 'MED006', 1000),
(4, 'MED002', 1400),
(5, 'MED001', 2500),
(5, 'MED003', 5500),
(5, 'MED004', 900),
(6, 'MED005', 3500),
(6, 'MED006', 1200),
(6, 'MED001', 2100);

-- --------------------------------------------------------

--
-- Table structure for table `matiere_premiere`
--

DROP TABLE IF EXISTS `matiere_premiere`;
CREATE TABLE IF NOT EXISTS `matiere_premiere` (
  `Code_M` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Intitule` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Provenance` enum('Local','Importe') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Local',
  PRIMARY KEY (`Code_M`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matiere_premiere`
--

INSERT INTO `matiere_premiere` (`Code_M`, `Intitule`, `Provenance`) VALUES
('MP001', 'Amoxicilline trihydrate', 'Importe'),
('MP002', 'Cellulose microcristalline', 'Local'),
('MP003', 'Ibuprofène poudre', 'Importe'),
('MP004', 'Saccharose', 'Local'),
('MP005', 'Paracétamol poudre', 'Importe'),
('MP006', 'Amidon de maïs', 'Local'),
('MP007', 'Diclofénac sodique', 'Importe'),
('MP008', 'Chlorure de sodium', 'Local'),
('MP009', 'Métronidazole poudre', 'Importe'),
('MP010', 'Stéarate de magnésium', 'Local');

-- --------------------------------------------------------

--
-- Table structure for table `medicament`
--

DROP TABLE IF EXISTS `medicament`;
CREATE TABLE IF NOT EXISTS `medicament` (
  `Reference_P` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Descriptif` text COLLATE utf8mb4_unicode_ci,
  `Forme` enum('Liquide','Pateux','Comprime','Poudre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPM` decimal(10,2) NOT NULL,
  `T_Lot` int NOT NULL DEFAULT '30',
  PRIMARY KEY (`Reference_P`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicament`
--

INSERT INTO `medicament` (`Reference_P`, `Designation`, `Descriptif`, `Forme`, `PPM`, `T_Lot`) VALUES
('MED001', 'Amoxicilline 500mg', 'Antibiotique à large spectre, utilisé contre les infections bactériennes', 'Comprime', 45.00, 50),
('MED002', 'Sirop Pédiatrique Ibuprofène', 'Anti-inflammatoire non stéroïdien pour enfants, soulage fièvre et douleur', 'Liquide', 38.50, 30),
('MED003', 'Paracétamol 1000mg', 'Analgésique et antipyrétique, traitement de la douleur modérée', 'Comprime', 22.00, 100),
('MED004', 'Gel Diclofénac 1%', 'Anti-inflammatoire topique pour douleurs articulaires et musculaires', 'Pateux', 67.00, 30),
('MED005', 'Poudre Réhydratation Orale', 'Solution de réhydratation en cas de diarrhée ou déshydratation', 'Poudre', 15.00, 200),
('MED006', 'Métronidazole 250mg', 'Antibiotique et antiparasitaire, traitement des infections anaérobies', 'Comprime', 30.00, 30);

-- --------------------------------------------------------

--
-- Table structure for table `mois`
--

DROP TABLE IF EXISTS `mois`;
CREATE TABLE IF NOT EXISTS `mois` (
  `N_Mois` tinyint UNSIGNED NOT NULL,
  PRIMARY KEY (`N_Mois`)
) ;

--
-- Dumping data for table `mois`
--

INSERT INTO `mois` (`N_Mois`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12);

-- --------------------------------------------------------

--
-- Table structure for table `nomenclature`
--

DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `Reference_P` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Code_M` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Dosage` decimal(10,4) NOT NULL,
  PRIMARY KEY (`Reference_P`,`Code_M`),
  KEY `fk_nom_mp` (`Code_M`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomenclature`
--

INSERT INTO `nomenclature` (`Reference_P`, `Code_M`, `Dosage`) VALUES
('MED001', 'MP001', 0.5000),
('MED001', 'MP002', 0.1500),
('MED001', 'MP010', 0.0050),
('MED002', 'MP003', 0.1000),
('MED002', 'MP004', 2.5000),
('MED002', 'MP008', 0.0200),
('MED003', 'MP005', 1.0000),
('MED003', 'MP006', 0.2000),
('MED003', 'MP010', 0.0050),
('MED004', 'MP007', 0.0100),
('MED004', 'MP002', 0.0500),
('MED005', 'MP008', 3.5000),
('MED005', 'MP004', 20.0000),
('MED006', 'MP009', 0.2500),
('MED006', 'MP006', 0.1000),
('MED006', 'MP010', 0.0030);

-- --------------------------------------------------------

--
-- Table structure for table `stocke_med`
--

DROP TABLE IF EXISTS `stocke_med`;
CREATE TABLE IF NOT EXISTS `stocke_med` (
  `Reference_P` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_Mois` tinyint UNSIGNED NOT NULL,
  `Quantite_Stock` int NOT NULL,
  PRIMARY KEY (`Reference_P`,`N_Mois`),
  KEY `fk_smed_mois` (`N_Mois`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocke_med`
--

INSERT INTO `stocke_med` (`Reference_P`, `N_Mois`, `Quantite_Stock`) VALUES
('MED001', 1, 3000),
('MED001', 2, 2500),
('MED001', 3, 2800),
('MED002', 1, 1800),
('MED002', 2, 1600),
('MED002', 3, 2000),
('MED003', 1, 6000),
('MED003', 2, 5500),
('MED003', 3, 6200),
('MED004', 1, 900),
('MED004', 2, 750),
('MED004', 3, 850),
('MED005', 1, 4000),
('MED005', 2, 3800),
('MED005', 3, 4200),
('MED006', 1, 1200),
('MED006', 2, 1100),
('MED006', 3, 1300);

-- --------------------------------------------------------

--
-- Table structure for table `stocke_mp`
--

DROP TABLE IF EXISTS `stocke_mp`;
CREATE TABLE IF NOT EXISTS `stocke_mp` (
  `Code_M` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `N_Mois` tinyint UNSIGNED NOT NULL,
  `Quantite_Stock` decimal(12,3) NOT NULL,
  PRIMARY KEY (`Code_M`,`N_Mois`),
  KEY `fk_smp_mois` (`N_Mois`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocke_mp`
--

INSERT INTO `stocke_mp` (`Code_M`, `N_Mois`, `Quantite_Stock`) VALUES
('MP001', 1, 5000.000),
('MP001', 2, 3800.000),
('MP001', 3, 4200.000),
('MP002', 1, 8000.000),
('MP002', 2, 7500.000),
('MP002', 3, 8200.000),
('MP003', 1, 3000.000),
('MP003', 2, 2500.000),
('MP003', 3, 3100.000),
('MP004', 1, 12000.000),
('MP004', 2, 11000.000),
('MP004', 3, 10500.000),
('MP005', 1, 9000.000),
('MP005', 2, 8000.000),
('MP005', 3, 9500.000),
('MP006', 1, 7000.000),
('MP006', 2, 6500.000),
('MP006', 3, 7200.000),
('MP007', 1, 2000.000),
('MP007', 2, 1800.000),
('MP007', 3, 2100.000),
('MP008', 1, 15000.000),
('MP008', 2, 14000.000),
('MP008', 3, 16000.000),
('MP009', 1, 4000.000),
('MP009', 2, 3500.000),
('MP009', 3, 4300.000),
('MP010', 1, 1500.000),
('MP010', 2, 1200.000),
('MP010', 3, 1600.000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`) VALUES
(9, 'dal.dakirallah@gmail.com', '$2y$10$lZ2X3AdScaaiRJPyWZmii.KZBWd/BTiQHJ9eF.890f4ZJOw2UhukW');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_besoin_brut_mp`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_besoin_brut_mp`;
CREATE TABLE IF NOT EXISTS `v_besoin_brut_mp` (
`code_M` varchar(10)
,`Dosage` decimal(10,4)
,`qte_mp_ref` decimal(40,4)
,`Quantite` bigint
,`Reference_P` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_besoin_med`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_besoin_med`;
CREATE TABLE IF NOT EXISTS `v_besoin_med` (
`N_Mois` tinyint unsigned
,`Qte_prod` bigint
,`Quantite` int
,`Reference_P` varchar(10)
,`T_Lot` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_besoin_net_mp`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_besoin_net_mp`;
CREATE TABLE IF NOT EXISTS `v_besoin_net_mp` (
`besoin_net` double
,`code_M` varchar(10)
,`Qte_stock` decimal(12,3)
,`S_besoin_brut` decimal(62,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sum_besoin_brut_mp`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_sum_besoin_brut_mp`;
CREATE TABLE IF NOT EXISTS `v_sum_besoin_brut_mp` (
`code_M` varchar(10)
,`S_besoin_brut` decimal(62,4)
);

-- --------------------------------------------------------

--
-- Structure for view `v_besoin_brut_mp`
--
DROP TABLE IF EXISTS `v_besoin_brut_mp`;

DROP VIEW IF EXISTS `v_besoin_brut_mp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_besoin_brut_mp` (`Reference_P`, `code_M`, `Dosage`, `Quantite`, `qte_mp_ref`) AS   select `nomenclature`.`Reference_P` AS `Reference_P`,`nomenclature`.`Code_M` AS `code_M`,`nomenclature`.`Dosage` AS `Dosage`,`v_besoin_med`.`Qte_prod` AS `qte_prod`,(`v_besoin_med`.`Qte_prod` * `nomenclature`.`Dosage`) AS `(qte_prod*dosage)` from (`nomenclature` join `v_besoin_med`) where (`nomenclature`.`Reference_P` = `v_besoin_med`.`Reference_P`)  ;

-- --------------------------------------------------------

--
-- Structure for view `v_besoin_med`
--
DROP TABLE IF EXISTS `v_besoin_med`;

DROP VIEW IF EXISTS `v_besoin_med`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_besoin_med`  AS SELECT `besoin`.`N_Mois` AS `N_Mois`, `besoin`.`Reference_P` AS `Reference_P`, `besoin`.`Quantite` AS `Quantite`, `medicament`.`T_Lot` AS `T_Lot`, (ceiling((`besoin`.`Quantite` / `medicament`.`T_Lot`)) * `medicament`.`T_Lot`) AS `Qte_prod` FROM (`besoin` join `medicament` on((`besoin`.`Reference_P` = `medicament`.`Reference_P`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_besoin_net_mp`
--
DROP TABLE IF EXISTS `v_besoin_net_mp`;

DROP VIEW IF EXISTS `v_besoin_net_mp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_besoin_net_mp`  AS SELECT `v_sum_besoin_brut_mp`.`code_M` AS `code_M`, `v_sum_besoin_brut_mp`.`S_besoin_brut` AS `S_besoin_brut`, `stocke_mp`.`Quantite_Stock` AS `Qte_stock`, `F_Calcul`(`stocke_mp`.`Quantite_Stock`,`v_sum_besoin_brut_mp`.`S_besoin_brut`) AS `besoin_net` FROM (`v_sum_besoin_brut_mp` join `stocke_mp` on((`v_sum_besoin_brut_mp`.`code_M` = `stocke_mp`.`Code_M`))) WHERE (`stocke_mp`.`N_Mois` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `v_sum_besoin_brut_mp`
--
DROP TABLE IF EXISTS `v_sum_besoin_brut_mp`;

DROP VIEW IF EXISTS `v_sum_besoin_brut_mp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_sum_besoin_brut_mp` (`code_M`, `S_besoin_brut`) AS   select `v_besoin_brut_mp`.`code_M` AS `code_M`,sum(`v_besoin_brut_mp`.`qte_mp_ref`) AS `sum(Qte_MP_Ref)` from `v_besoin_brut_mp` group by `v_besoin_brut_mp`.`code_M`  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
