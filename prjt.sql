-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prjt`
--

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'en attente',
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `utilisateur_id`, `date_commande`, `status`, `total`) VALUES
(4, 18, '2024-08-02 11:07:33', 'en attente', 167.94);

-- --------------------------------------------------------

--
-- Table structure for table `commande_produits`
--

CREATE TABLE `commande_produits` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `commande_id`, `produit_id`, `quantite`, `prix_unitaire`) VALUES
(5, 4, 1, 3, 19.99),
(6, 4, 18, 2, 45.99),
(7, 4, 33, 1, 15.99);

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `utilisateur_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`utilisateur_id`, `produit_id`, `quantite`) VALUES
(7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix_unitaire`, `image`, `categorie`, `quantite`) VALUES
(1, 'T-shirt de boxe Everlast', 'T-shirt de boxe Everlast en coton.', 19.99, 'everlast_tshirt.jpeg', 'Vêtements', 4),
(2, 'Short de boxe Adidas', 'Short de boxe Adidas en polyester.', 24.99, 'adidas_short.jpeg', 'Vêtements', 0),
(3, 'Sweat à capuche Venum', 'Sweat à capuche Venum en coton.', 39.99, 'venum_hoodie.jpeg', 'Vêtements', 0),
(4, 'Débardeur de boxe RDX', 'Débardeur de boxe RDX en polyester.', 18.99, 'rdx_tanktop.jpeg', 'Vêtements', 0),
(5, 'Pantalon de survêtement Everlast', 'Pantalon de survêtement Everlast en coton.', 29.99, 'everlast_pants.jpeg', 'Vêtements', 0),
(6, 'Veste de sport Title', 'Veste de sport Title en polyester.', 34.99, 'title_jacket.jpeg', 'Vêtements', 0),
(7, 'Short de boxe Ringside', 'Short de boxe Ringside en coton.', 22.99, 'ringside_short.jpeg', 'Vêtements', 0),
(8, 'T-shirt de boxe Hayabusa', 'T-shirt de boxe Hayabusa en coton.', 21.99, 'hayabusa_tshirt.jpeg', 'Vêtements', 0),
(9, 'Gants de boxe Everlast', 'Gants de boxe Everlast avec rembourrage en mousse.', 49.99, 'everlast_gloves.jpeg', 'Gants', 0),
(10, 'Gants de boxe Venum', 'Gants de boxe Venum avec rembourrage triple couche.', 59.99, 'venum_gloves.jpeg', 'Gants', 0),
(11, 'Gants de boxe Adidas', 'Gants de boxe Adidas avec rembourrage en mousse haute densité.', 55.99, 'adidas_gloves.jpeg', 'Gants', 0),
(12, 'Gants de boxe Fairtex', 'Gants de boxe Fairtex avec rembourrage en mousse multi-densité.', 65.99, 'fairtex_gloves.jpeg', 'Gants', 0),
(13, 'Gants de boxe Title', 'Gants de boxe Title pour entraînements intensifs.', 44.99, 'title_gloves.jpeg', 'Gants', 0),
(14, 'Gants de boxe Ringside', 'Gants de boxe Ringside avec ajustement ergonomique.', 50.99, 'ringside_gloves.jpeg', 'Gants', 0),
(15, 'Gants de boxe Hayabusa', 'Gants de boxe Hayabusa avec rembourrage à haute densité.', 60.99, 'hayabusa_gloves.jpeg', 'Gants', 0),
(16, 'Gants de boxe Cleto Reyes', 'Gants de boxe Cleto Reyes en cuir de qualité supérieure.', 70.99, 'cleto_reyes_gloves.jpeg', 'Gants', 0),
(17, 'Sac de sport Everlast', 'Sac de sport Everlast avec compartiments multiples.', 35.99, 'everlast_sport_bag.jpeg', 'Sacs de sport', 0),
(18, 'Sac de sport Venum', 'Sac de sport Venum en matériau résistant.', 45.99, 'venum_sport_bag.jpeg', 'Sacs de sport', 0),
(19, 'Sac de sport Adidas', 'Sac de sport Adidas avec poches latérales.', 42.99, 'adidas_sport_bag.jpeg', 'Sacs de sport', 0),
(20, 'Sac de sport RDX', 'Sac de sport RDX avec bandoulière réglable.', 38.99, 'rdx_sport_bag.jpeg', 'Sacs de sport', 0),
(21, 'Sac de sport Title', 'Sac de sport Title en polyester.', 39.99, 'title_sport_bag.jpeg', 'Sacs de sport', 0),
(22, 'Sac de sport Ringside', 'Sac de sport Ringside avec compartiment pour chaussures.', 36.99, 'ringside_sport_bag.jpeg', 'Sacs de sport', 0),
(23, 'Sac de sport Hayabusa', 'Sac de sport Hayabusa avec fermetures éclair robustes.', 44.99, 'hayabusa_sport_bag.jpeg', 'Sacs de sport', 0),
(24, 'Sac de sport Cleto Reyes', 'Sac de sport Cleto Reyes en cuir.', 50.99, 'cleto_reyes_sport_bag.jpeg', 'Sacs de sport', 0),
(25, 'Corde à sauter Everlast', 'Corde à sauter Everlast avec poignées ergonomiques.', 14.99, 'everlast_jump_rope.jpeg', 'Accessoires', 0),
(26, 'Pattes d’ours RDX', 'Pattes d’ours RDX pour l’entraînement intensif.', 29.99, 'rdx_pads.jpeg', 'Accessoires', 0),
(27, 'Corde à sauter RDX', 'Corde à sauter RDX pour l’entraînement cardio.', 12.99, 'rdx_jump_rope.jpeg', 'Accessoires', 0),
(28, 'Sac de sport Venum', 'Sac de sport Venum avec compartiments multiples.', 35.99, 'venum_sports_bag2.jpeg', 'Accessoires', 0),
(29, 'Gourde Everlast', 'Gourde Everlast en acier inoxydable.', 9.99, 'everlast_water_bottle.jpeg', 'Accessoires', 0),
(30, 'Sangle de boxe Adidas', 'Sangle de boxe Adidas en coton élastique.', 8.99, 'adidas_hand_wraps.jpeg', 'Accessoires', 0),
(31, 'Pattes d’ours Fairtex', 'Pattes d’ours Fairtex pour l’entraînement de précision.', 32.99, 'fairtex_pads.jpeg', 'Accessoires', 0),
(32, 'Corde à sauter Title', 'Corde à sauter Title avec câble en acier.', 13.99, 'title_jump_rope.jpeg', 'Accessoires', 0),
(33, 'Protège-dents Venum', 'Protège-dents Venum avec étui.', 15.99, 'venum_mouthguard.jpeg', 'Équipements de protection', 0),
(34, 'Casque de boxe Adidas', 'Casque de boxe Adidas en mousse EVA.', 39.99, 'adidas_headgear.jpeg', 'Équipements de protection', 0),
(35, 'Protège-tibias RDX', 'Protège-tibias RDX avec rembourrage en mousse épaisse.', 24.99, 'rdx_shinguards.jpeg', 'Équipements de protection', 0),
(36, 'Genouillères Venum', 'Genouillères Venum avec rembourrage épais.', 19.99, 'venum_kneepads.jpeg', 'Équipements de protection', 0),
(37, 'Protège-dents Shock Doctor', 'Protège-dents Shock Doctor avec protection maximale.', 19.99, 'shock_doctor_mouthguard.jpeg', 'Équipements de protection', 0),
(38, 'Casque de boxe Ringside', 'Casque de boxe Ringside avec ajustement facile.', 42.99, 'ringside_headgear.jpeg', 'Équipements de protection', 0),
(39, 'Protège-tibias Venum', 'Protège-tibias Venum avec protection renforcée.', 27.99, 'venum_shinguards.jpeg', 'Équipements de protection', 0),
(40, 'Casque de boxe Hayabusa', 'Casque de boxe Hayabusa avec rembourrage multicouche.', 44.99, 'hayabusa_headgear.jpeg', 'Équipements de protection', 0);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` text NOT NULL,
  `role` enum('client','admin') DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `prenom`, `adresse`, `role`) VALUES
(7, 'admin', 'admin@boxingzone.com', '$2y$10$EObucVeI2rVDrdqTbjhzGuqEvdVvE5aBR.NHhiKMEMOmnknx27iaC', 'admin', 'Adresse Admin', 'admin'),
(18, 'sohaib', 'ss@boxingzone.com', '$2y$10$LZYuC6aB6b5ofSbYr/V2s..E/EbqMDTCNtZw5BP7JXqz55WxZKCtm', 'elkettani', '2635 rue aylwin', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_ibfk_1` (`utilisateur_id`);

--
-- Indexes for table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`utilisateur_id`,`produit_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `commande_produits`
--
ALTER TABLE `commande_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `commande_produits_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
