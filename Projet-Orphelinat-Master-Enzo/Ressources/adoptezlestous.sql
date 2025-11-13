-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 29 oct. 2025 à 15:21
-- Version du serveur : 8.0.43-0ubuntu0.24.04.2
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adoptezlestous`
--

-- --------------------------------------------------------

--
-- Structure de la table `owned_pokemon`
--

CREATE TABLE `owned_pokemon` (
  `id` int UNSIGNED NOT NULL,
  `pokedex_id` int UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `surnom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type1` varchar(50) NOT NULL,
  `type2` varchar(50) DEFAULT NULL,
  `niveau` int NOT NULL,
  `taille` int UNSIGNED NOT NULL,
  `poids` decimal(5,2) NOT NULL,
  `objet_equiper` varchar(255) DEFAULT NULL,
  `ownedBy` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `owned_pokemon`
--

INSERT INTO `owned_pokemon` (`id`, `pokedex_id`, `nom`, `surnom`, `type1`, `type2`, `niveau`, `taille`, `poids`, `objet_equiper`, `ownedBy`) VALUES
(11, 62, 'Tartard', NULL, 'Eau', 'Combat', 64, 1, 55.00, NULL, 8);

-- --------------------------------------------------------

--
-- Structure de la table `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int UNSIGNED NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surnom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `taille` int UNSIGNED NOT NULL,
  `poids` decimal(5,2) NOT NULL,
  `type1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `niveau` int NOT NULL,
  `objet_equiper` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zone_elevage_id` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pokemons`
--

INSERT INTO `pokemons` (`id`, `nom`, `surnom`, `taille`, `poids`, `type1`, `type2`, `niveau`, `objet_equiper`, `zone_elevage_id`, `created_at`) VALUES
(2, 'Aéromite', 'eeeeeee', 5, 45.00, 'feu', 'eau', 2, NULL, NULL, '2025-10-28 10:42:11'),
(3, 'Abra', 'eee', 6, 7.00, 'plante', 'eau', 2, NULL, NULL, '2025-10-28 10:43:42'),
(4, 'Abra', 'eee', 6, 7.00, 'plante', 'eau', 2, NULL, NULL, '2025-10-28 10:44:32'),
(5, 'Alakazam', 'eee', 5, 5.00, 'feu', 'electrik', 12, NULL, NULL, '2025-10-28 10:44:52'),
(6, 'Amonistar', 'eeeee', 42, 25.00, 'feu', 'combat', 2, NULL, NULL, '2025-10-28 10:46:57'),
(7, 'Amonistar', 'eeee', 2, 56.00, 'electrik', NULL, 56, NULL, NULL, '2025-10-28 10:47:45'),
(8, 'Arcanin', 'eeeee', 85, 6.00, 'feu', NULL, 5, NULL, NULL, '2025-10-28 10:54:33'),
(9, '65', 'Siman', 185, 120.00, 'Psy', NULL, 89, NULL, NULL, '2025-10-28 14:09:35'),
(10, '138', 'ddd', 5, 5.00, 'Roche', 'Eau', 5, NULL, NULL, '2025-10-28 14:10:17'),
(11, '23', 'eeee', 6, 6.00, 'Poison', NULL, 3, NULL, NULL, '2025-10-28 14:13:33'),
(12, '138', 'eeeeeee', 32, 32.00, 'Roche', 'Eau', 32, NULL, NULL, '2025-10-28 14:18:07'),
(13, '65', 'DDD', 32, 32.00, 'Psy', NULL, 32, NULL, NULL, '2025-10-28 14:19:01'),
(14, '134', 'zee', 25, 52.00, 'Eau', NULL, 52, NULL, NULL, '2025-10-28 14:19:52'),
(15, '23', 'reee', 43, 34.00, 'Poison', NULL, 43, NULL, NULL, '2025-10-28 14:20:18'),
(16, '23', 'EEEE', 43, 43.00, 'Poison', NULL, 43, NULL, NULL, '2025-10-28 14:20:27'),
(17, '55', 'eeee', 23, 32.00, 'Eau', NULL, 32, NULL, NULL, '2025-10-28 14:22:50'),
(18, 'Aéromite', 'eee', 32, 23.00, 'Introuvable', NULL, 2, NULL, NULL, '2025-10-28 14:23:04'),
(19, 'Amonistar', 'eeeee', 232, 23.00, 'Plante', 'Poison', 23, NULL, NULL, '2025-10-28 14:26:45');

-- --------------------------------------------------------

--
-- Structure de la table `pokemon_gen1`
--

CREATE TABLE `pokemon_gen1` (
  `id` int UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type1` varchar(20) NOT NULL,
  `type2` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pokemon_gen1`
--

INSERT INTO `pokemon_gen1` (`id`, `nom`, `type1`, `type2`) VALUES
(1, 'Bulbizarre', 'Plante', 'Poison'),
(2, 'Herbizarre', 'Plante', 'Poison'),
(3, 'Florizarre', 'Plante', 'Poison'),
(4, 'Salamèche', 'Feu', NULL),
(5, 'Reptincel', 'Feu', NULL),
(6, 'Dracaufeu', 'Feu', 'Vol'),
(7, 'Carapuce', 'Eau', NULL),
(8, 'Carabaffe', 'Eau', NULL),
(9, 'Tortank', 'Eau', NULL),
(10, 'Chenipan', 'Insecte', NULL),
(11, 'Chrysacier', 'Insecte', NULL),
(12, 'Papilusion', 'Insecte', 'Vol'),
(13, 'Aspicot', 'Insecte', 'Poison'),
(14, 'Coconfort', 'Insecte', 'Poison'),
(15, 'Dardargnan', 'Insecte', 'Poison'),
(16, 'Roucool', 'Normal', 'Vol'),
(17, 'Roucoups', 'Normal', 'Vol'),
(18, 'Roucarnage', 'Normal', 'Vol'),
(19, 'Rattata', 'Normal', NULL),
(20, 'Rattatac', 'Normal', NULL),
(21, 'Piafabec', 'Normal', 'Vol'),
(22, 'Rapasdepic', 'Normal', 'Vol'),
(23, 'Abo', 'Poison', NULL),
(24, 'Arbok', 'Poison', NULL),
(25, 'Pikachu', 'Électrik', NULL),
(26, 'Raichu', 'Électrik', NULL),
(27, 'Sabelette', 'Sol', NULL),
(28, 'Sablaireau', 'Sol', NULL),
(29, 'Nidoran♀', 'Poison', NULL),
(30, 'Nidorina', 'Poison', NULL),
(31, 'Nidoqueen', 'Poison', 'Sol'),
(32, 'Nidoran♂', 'Poison', NULL),
(33, 'Nidorino', 'Poison', NULL),
(34, 'Nidoking', 'Poison', 'Sol'),
(35, 'Mélofée', 'Fée', NULL),
(36, 'Mélodelfe', 'Fée', NULL),
(37, 'Goupix', 'Feu', NULL),
(38, 'Feunard', 'Feu', NULL),
(39, 'Rondoudou', 'Normal', 'Fée'),
(40, 'Grodoudou', 'Normal', 'Fée'),
(41, 'Nosferapti', 'Poison', 'Vol'),
(42, 'Nosferalto', 'Poison', 'Vol'),
(43, 'Mystherbe', 'Plante', 'Poison'),
(44, 'Ortide', 'Plante', 'Poison'),
(45, 'Rafflesia', 'Plante', 'Poison'),
(46, 'Paras', 'Insecte', 'Plante'),
(47, 'Parasect', 'Insecte', 'Plante'),
(48, 'Mimitoss', 'Insecte', 'Poison'),
(49, 'Aéromite', 'Insecte', 'Poison'),
(50, 'Taupiqueur', 'Sol', NULL),
(51, 'Triopikeur', 'Sol', NULL),
(52, 'Miaouss', 'Normal', NULL),
(53, 'Persian', 'Normal', NULL),
(54, 'Psykokwak', 'Eau', NULL),
(55, 'Akwakwak', 'Eau', NULL),
(56, 'Férosinge', 'Combat', NULL),
(57, 'Colossinge', 'Combat', NULL),
(58, 'Caninos', 'Feu', NULL),
(59, 'Arcanin', 'Feu', NULL),
(60, 'Ptitard', 'Eau', NULL),
(61, 'Têtarte', 'Eau', NULL),
(62, 'Tartard', 'Eau', 'Combat'),
(63, 'Abra', 'Psy', NULL),
(64, 'Kadabra', 'Psy', NULL),
(65, 'Alakazam', 'Psy', NULL),
(66, 'Machoc', 'Combat', NULL),
(67, 'Machopeur', 'Combat', NULL),
(68, 'Mackogneur', 'Combat', NULL),
(69, 'Chétiflor', 'Plante', 'Poison'),
(70, 'Boustiflor', 'Plante', 'Poison'),
(71, 'Empiflor', 'Plante', 'Poison'),
(72, 'Tentacool', 'Eau', 'Poison'),
(73, 'Tentacruel', 'Eau', 'Poison'),
(74, 'Racaillou', 'Roche', 'Sol'),
(75, 'Gravalanch', 'Roche', 'Sol'),
(76, 'Grolem', 'Roche', 'Sol'),
(77, 'Ponyta', 'Feu', NULL),
(78, 'Galopa', 'Feu', NULL),
(79, 'Ramoloss', 'Eau', 'Psy'),
(80, 'Flagadoss', 'Eau', 'Psy'),
(81, 'Magnéti', 'Électrik', 'Acier'),
(82, 'Magnéton', 'Électrik', 'Acier'),
(83, 'Canarticho', 'Normal', 'Vol'),
(84, 'Doduo', 'Normal', 'Vol'),
(85, 'Dodrio', 'Normal', 'Vol'),
(86, 'Otaria', 'Eau', NULL),
(87, 'Lamantine', 'Eau', 'Glace'),
(88, 'Tadmorv', 'Poison', NULL),
(89, 'Grotadmorv', 'Poison', NULL),
(90, 'Kokiyas', 'Eau', NULL),
(91, 'Crustabri', 'Eau', 'Glace'),
(92, 'Fantominus', 'Spectre', 'Poison'),
(93, 'Spectrum', 'Spectre', 'Poison'),
(94, 'Ectoplasma', 'Spectre', 'Poison'),
(95, 'Onix', 'Roche', 'Sol'),
(96, 'Soporifik', 'Psy', NULL),
(97, 'Hypnomade', 'Psy', NULL),
(98, 'Krabby', 'Eau', NULL),
(99, 'Krabboss', 'Eau', NULL),
(100, 'Voltorbe', 'Électrik', NULL),
(101, 'Électrode', 'Électrik', NULL),
(102, 'Noeunoeuf', 'Plante', 'Psy'),
(103, 'Noadkoko', 'Plante', 'Psy'),
(104, 'Osselait', 'Sol', NULL),
(105, 'Ossatueur', 'Sol', NULL),
(106, 'Kicklee', 'Combat', NULL),
(107, 'Tygnon', 'Combat', NULL),
(108, 'Excelangue', 'Normal', NULL),
(109, 'Smogo', 'Poison', NULL),
(110, 'Smogogo', 'Poison', NULL),
(111, 'Rhinocorne', 'Sol', 'Roche'),
(112, 'Rhinoféros', 'Sol', 'Roche'),
(113, 'Leveinard', 'Normal', NULL),
(114, 'Saquedeneu', 'Plante', NULL),
(115, 'Kangourex', 'Normal', NULL),
(116, 'Hypotrempe', 'Eau', NULL),
(117, 'Hypocéan', 'Eau', NULL),
(118, 'Poissirène', 'Eau', NULL),
(119, 'Poissoroy', 'Eau', NULL),
(120, 'Stari', 'Eau', NULL),
(122, 'M. Mime', 'Psy', 'Fée'),
(123, 'Insécateur', 'Insecte', 'Vol'),
(124, 'Lippoutou', 'Glace', 'Psy'),
(125, 'Élektek', 'Électrik', NULL),
(126, 'Magmar', 'Feu', NULL),
(127, 'Scarabrute', 'Insecte', NULL),
(128, 'Tauros', 'Normal', NULL),
(129, 'Magicarpe', 'Eau', NULL),
(130, 'Léviator', 'Eau', 'Vol'),
(131, 'Lokhlass', 'Eau', 'Glace'),
(132, 'Métamorph', 'Normal', NULL),
(133, 'Évoli', 'Normal', NULL),
(134, 'Aquali', 'Eau', NULL),
(135, 'Voltali', 'Électrik', NULL),
(136, 'Pyroli', 'Feu', NULL),
(137, 'Porygon', 'Normal', NULL),
(138, 'Amonita', 'Roche', 'Eau'),
(139, 'Amonistar', 'Roche', 'Eau'),
(140, 'Kabuto', 'Roche', 'Eau'),
(141, 'Kabutops', 'Roche', 'Eau'),
(142, 'Ptéra', 'Roche', 'Vol'),
(143, 'Ronflex', 'Normal', NULL),
(144, 'Artikodin', 'Glace', 'Vol'),
(145, 'Électhor', 'Électrik', 'Vol'),
(146, 'Sulfura', 'Feu', 'Vol'),
(147, 'Minidraco', 'Dragon', NULL),
(148, 'Draco', 'Dragon', NULL),
(149, 'Dracolosse', 'Dragon', 'Vol'),
(150, 'Mewtwo', 'Psy', NULL),
(151, 'Mew', 'Psy', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `role`, `created_at`) VALUES
(5, 'user', 'user@mail', '$2y$10$/DdazC9m56Zc6ryH0WXoUevp8p2LNsNJzWIWgmnaf0BQ1pO.duGmm', 'user', '2025-10-29 15:02:30'),
(7, 'root', 'root@mail', '$2y$10$uJh1vVMXDHsyZfSBHoAvwer4O0d/znstGj2dHLc/yNCKHayHv/oSe', 'admin', '2025-10-29 15:03:50'),
(8, 'connarddu22', 'x@x', '$2y$10$0TcOulx/YU7MZ87T.xGq0Oot2VmxxW88fXXl0/vLTEw7LmoascGy6', 'user', '2025-10-29 15:06:43');

-- --------------------------------------------------------

--
-- Structure de la table `zone_elevage`
--

CREATE TABLE `zone_elevage` (
  `id` int UNSIGNED NOT NULL,
  `zone` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codePostal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `owned_pokemon`
--
ALTER TABLE `owned_pokemon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownedBy` (`ownedBy`),
  ADD KEY `pokedex_id` (`pokedex_id`);

--
-- Index pour la table `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemon_gen1`
--
ALTER TABLE `pokemon_gen1`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `zone_elevage`
--
ALTER TABLE `zone_elevage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `owned_pokemon`
--
ALTER TABLE `owned_pokemon`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `zone_elevage`
--
ALTER TABLE `zone_elevage`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `owned_pokemon`
--
ALTER TABLE `owned_pokemon`
  ADD CONSTRAINT `owned_pokemon_ibfk_1` FOREIGN KEY (`ownedBy`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `owned_pokemon_ibfk_2` FOREIGN KEY (`pokedex_id`) REFERENCES `pokemon_gen1` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
