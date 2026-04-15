-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 04:08 PM
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
-- Database: `blueloto`
--

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` char(36) NOT NULL,
  `agent_id` char(36) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `balance_after` decimal(12,2) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` char(36) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
('ADMIN1', 'Main Admin', 'admin1@test.com', 'pass', '2026-03-20 12:25:27'),
('ADMIN2', 'Second Admin', 'admin2@test.com', 'pass', '2026-03-20 12:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` char(36) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `suspendAgent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `email`, `phone`, `suspendAgent`, `created_at`) VALUES
('AG5693', 'demo', 'demo@gmail.com', '322222222222', 0, '2026-03-25 19:10:27'),
('AG8929', 'simon', 'iamthecodemonk@gmail.com', '32323232', 0, '2026-03-24 16:06:14'),
('AGENT2', 'Jane Smith', 'jane@test.com', '08022222222', 0, '2026-03-20 12:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE `bets` (
  `id` char(36) NOT NULL,
  `agent_id` char(36) DEFAULT NULL,
  `game_id` char(36) DEFAULT NULL,
  `bet_type_id` char(36) DEFAULT NULL,
  `mode` enum('lotto','cashback') DEFAULT NULL,
  `stake_amount` decimal(10,2) DEFAULT NULL,
  `total_games_played` int(11) DEFAULT 1,
  `cashback_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','won','lost') DEFAULT 'pending',
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bets`
--

INSERT INTO `bets` (`id`, `agent_id`, `game_id`, `bet_type_id`, `mode`, `stake_amount`, `total_games_played`, `cashback_id`, `status`, `placed_at`) VALUES
('TKT-5WLKNPB5-087NV', 'AG5693', 'GAME-BAC65367', 'BT-A2FF114F', 'lotto', 34.00, 1, NULL, 'pending', '2026-03-26 12:00:18'),
('TKT-671IDR4D-3UPOR', 'AG5693', 'GAME2', 'BT-CC0637CD', 'lotto', 32.00, 1, NULL, 'pending', '2026-03-26 12:00:18'),
('TKT-96E8ZQMK-1VWQL', 'AG5693', 'GAME1', 'BT2', 'cashback', 32.00, 1, 'CB-AHPR3J-49IQ', 'pending', '2026-03-26 12:52:10'),
('TKT-NZADDMZ7-UAWFC', 'AG5693', 'GAME2', 'BT-CC0637CD', 'lotto', 99.00, 1, NULL, 'pending', '2026-03-26 11:45:03'),
('TKT-RHYX3X3R-OJ8SA', 'AG5693', 'GAME-BAC65367', 'BT-A2FF114F', 'lotto', 666.00, 1, NULL, 'pending', '2026-03-26 11:45:03'),
('TKT-XO6W7GIZ-EVIGI', 'AG5693', 'GAME-BAC65367', 'BT-A2FF114F', 'lotto', 3.00, 2, NULL, 'pending', '2026-03-26 12:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `bet_numbers`
--

CREATE TABLE `bet_numbers` (
  `id` char(36) NOT NULL,
  `bet_id` char(36) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `game_type_id` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bet_numbers`
--

INSERT INTO `bet_numbers` (`id`, `bet_id`, `number`, `game_type_id`) VALUES
('021eddd7-3052-cafd-e060-bb8d41cb6916', 'TKT-RHYX3X3R-OJ8SA', 32, '141b8dc7-2bb3-11f1-87d2-0068eb6923ff'),
('059a70eb-e017-c015-8a07-b8edad3bf42a', 'TKT-XO6W7GIZ-EVIGI', 4, '141b8dc7-2bb3-11f1-87d2-0068eb6923ff'),
('07acbfcc-e4e4-e408-bd7e-8f5247f762e3', 'TKT-5WLKNPB5-087NV', 32, '141b5ecd-2bb3-11f1-87d2-0068eb6923ff'),
('0e31ce36-26d0-c1bb-58ec-5d98d6ad8634', 'TKT-671IDR4D-3UPOR', 57, '141b8faf-2bb3-11f1-87d2-0068eb6923ff'),
('0f72ef60-96ab-ee18-bc0a-47ebaa0f2368', 'TKT-5WLKNPB5-087NV', 40, '141b5ecd-2bb3-11f1-87d2-0068eb6923ff'),
('13bc6ce9-9a58-2962-7341-d796fe859938', 'TKT-96E8ZQMK-1VWQL', 34, '141b8faf-2bb3-11f1-87d2-0068eb6923ff'),
('1430c96a-4875-7c2d-4af0-b85046c3ab2c', 'TKT-NZADDMZ7-UAWFC', 12, '141b9100-2bb3-11f1-87d2-0068eb6923ff'),
('16c0029e-4d1d-ca64-e51a-de47798f7ffe', 'TKT-96E8ZQMK-1VWQL', 30, '141b9100-2bb3-11f1-87d2-0068eb6923ff'),
('1886f777-d49e-be14-15c6-d9ee0fb1f0ef', 'TKT-671IDR4D-3UPOR', 75, NULL),
('1afb193c-7544-c346-9ed4-1f4ae4d7bcbd', 'TKT-RHYX3X3R-OJ8SA', 7, NULL),
('20508519-f5ce-98f4-c854-0fdee8253e2c', 'TKT-XO6W7GIZ-EVIGI', 51, NULL),
('223a557b-de16-fc85-c217-c7b5ebd24443', 'TKT-671IDR4D-3UPOR', 40, NULL),
('272c5925-244f-41ed-d46d-62ecb1ba7abe', 'TKT-NZADDMZ7-UAWFC', 23, NULL),
('28408347-df60-45d4-9bed-0b078e75568c', 'TKT-RHYX3X3R-OJ8SA', 40, NULL),
('28781603-7082-4ddf-ccfa-68174825f3bd', 'TKT-671IDR4D-3UPOR', 32, NULL),
('2b986d1f-9bbc-138a-1664-85f71e181ddc', 'TKT-NZADDMZ7-UAWFC', 6, NULL),
('32b63713-5839-d80d-ac84-9aab808bcc2a', 'TKT-RHYX3X3R-OJ8SA', 24, NULL),
('332b36d0-3abf-8431-55ed-15c6c004b205', 'TKT-XO6W7GIZ-EVIGI', 49, NULL),
('35514ebc-c5fb-e3d6-29df-ab93b447e754', 'TKT-671IDR4D-3UPOR', 48, NULL),
('37dd4e35-0e34-9852-5afc-f311ad448543', 'TKT-5WLKNPB5-087NV', 12, NULL),
('3a452808-99aa-e057-d6f9-5bd1c5c1771b', 'TKT-NZADDMZ7-UAWFC', 14, NULL),
('3c22ff9b-9b0f-2ebf-6f31-de40c552e20f', 'TKT-96E8ZQMK-1VWQL', 19, NULL),
('3f56b8ad-5756-c8dc-d316-77671c295fce', 'TKT-NZADDMZ7-UAWFC', 24, NULL),
('4200f984-c374-c0e0-d8b7-c83f9fb31e94', 'TKT-671IDR4D-3UPOR', 33, NULL),
('496d3ac4-0abd-add8-95ae-b9a29f6ebbbf', 'TKT-RHYX3X3R-OJ8SA', 14, NULL),
('4a2827b9-d5ce-d851-1199-36d9564aa614', 'TKT-NZADDMZ7-UAWFC', 15, NULL),
('4a519a75-2ded-8702-f9f1-426b6652c882', 'TKT-XO6W7GIZ-EVIGI', 60, NULL),
('4ab174a0-8d54-bc7a-617b-32861c9fbac7', 'TKT-5WLKNPB5-087NV', 22, NULL),
('4ac0afe6-2e13-fbb5-f5f0-a3690be97197', 'TKT-NZADDMZ7-UAWFC', 41, NULL),
('4f1a2f17-bb6c-160e-e6c5-b145b91bdcfe', 'TKT-96E8ZQMK-1VWQL', 25, NULL),
('4f956624-e675-327c-5c52-f4aa0a552f28', 'TKT-96E8ZQMK-1VWQL', 31, NULL),
('4fa706ac-2e0f-8b9d-3182-0fdcdf81742c', 'TKT-XO6W7GIZ-EVIGI', 24, NULL),
('51e2923c-2af3-ff4e-a278-82bb14cbfe2a', 'TKT-96E8ZQMK-1VWQL', 5, NULL),
('534af352-5307-9787-3dbf-3ca5d40d4590', 'TKT-96E8ZQMK-1VWQL', 15, NULL),
('539cc0ee-e8d1-391d-79ec-1fce97ffc6b0', 'TKT-RHYX3X3R-OJ8SA', 48, NULL),
('5425f82a-fb0d-2d79-2c29-af1e21285ea8', 'TKT-RHYX3X3R-OJ8SA', 6, NULL),
('5450fb11-b26c-0f21-e06c-b2a681ca25a8', 'TKT-5WLKNPB5-087NV', 20, NULL),
('545de8ac-eca2-e2b6-c4ed-19df2571c45a', 'TKT-5WLKNPB5-087NV', 14, NULL),
('56696f4f-9148-13d7-95d8-ca4104679eed', 'TKT-5WLKNPB5-087NV', 58, NULL),
('58e39551-31f3-ba55-573e-29cb06506701', 'TKT-XO6W7GIZ-EVIGI', 22, NULL),
('59b2a5d4-1de4-1540-08b8-806ca5d53ef0', 'TKT-671IDR4D-3UPOR', 41, NULL),
('5c853d4a-170f-c451-1f0b-be9624fa05ad', 'TKT-XO6W7GIZ-EVIGI', 40, NULL),
('5df7610e-0ce5-af9f-5657-e13761969393', 'TKT-NZADDMZ7-UAWFC', 5, NULL),
('5e9dcdf4-49af-2ea0-ab51-c82fb9b9c7d8', 'TKT-671IDR4D-3UPOR', 51, NULL),
('5eb6af5e-07a4-060e-0138-66b3da6660f2', 'TKT-XO6W7GIZ-EVIGI', 32, NULL),
('5fe6851d-8312-837c-a2e6-ea9ad86e48a7', 'TKT-NZADDMZ7-UAWFC', 4, '141b91b4-2bb3-11f1-87d2-0068eb6923ff'),
('615571d8-2a15-c852-1dc9-7dbecace28fb', 'TKT-96E8ZQMK-1VWQL', 41, NULL),
('6175942c-d347-1a78-125d-4fc8b6b6166b', 'TKT-RHYX3X3R-OJ8SA', 5, NULL),
('6268a660-fa88-d9d0-f3a8-5aef7773ffa4', 'TKT-XO6W7GIZ-EVIGI', 5, NULL),
('6445024a-fdc9-d11d-e95b-3fe99975dc3e', 'TKT-96E8ZQMK-1VWQL', 4, '141b91b4-2bb3-11f1-87d2-0068eb6923ff'),
('65e748d6-4fec-4647-c1de-38a52a50ef33', 'TKT-XO6W7GIZ-EVIGI', 50, NULL),
('662185b5-240c-8dd3-0f29-c55778de425a', 'TKT-XO6W7GIZ-EVIGI', 39, NULL),
('67bb8b6a-c662-eaf3-a33b-fccff380bc18', 'TKT-5WLKNPB5-087NV', 39, NULL),
('691df59d-26a1-94e9-587e-1bbbeb72abba', 'TKT-NZADDMZ7-UAWFC', 57, NULL),
('6ab6bacd-31ce-7bc6-2d31-d1473bd351a9', 'TKT-96E8ZQMK-1VWQL', 39, NULL),
('6b74db8e-0eb5-a562-2035-aa8da9f874be', 'TKT-XO6W7GIZ-EVIGI', 52, NULL),
('6d81bbab-2c14-c558-089e-a1986515ae42', 'TKT-671IDR4D-3UPOR', 76, NULL),
('717f3d5e-688b-9883-4b2f-67e2e400613f', 'TKT-671IDR4D-3UPOR', 49, NULL),
('75b50bc4-fa64-5a4f-e455-f464a32aa3aa', 'TKT-RHYX3X3R-OJ8SA', 22, NULL),
('78b37c2d-4ec7-52bb-fa2d-d6715c631e56', 'TKT-XO6W7GIZ-EVIGI', 25, NULL),
('86ff9a41-10e9-e96b-c26d-671ee5eedaa5', 'TKT-5WLKNPB5-087NV', 30, NULL),
('8a347064-023f-c05e-ab82-85fca9ae068a', 'TKT-RHYX3X3R-OJ8SA', 15, NULL),
('8abe1140-7d81-46d5-8950-d806746e7224', 'TKT-XO6W7GIZ-EVIGI', 16, NULL),
('8ad225a7-69be-d09f-d3cc-c33e931bab52', 'TKT-5WLKNPB5-087NV', 11, NULL),
('8e2dc622-473f-eedd-6cb2-94c78274851c', 'TKT-671IDR4D-3UPOR', 43, NULL),
('8fb73a05-1ff9-00b2-976a-e0a44e2189e4', 'TKT-RHYX3X3R-OJ8SA', 30, NULL),
('900a96e6-9a6f-b5bb-2610-aec1e098df90', 'TKT-5WLKNPB5-087NV', 31, NULL),
('914f2714-3359-0e70-5331-3b5ea0d6dec4', 'TKT-XO6W7GIZ-EVIGI', 13, NULL),
('91af2f73-3349-f4d3-3bd6-33ffb3ce96db', 'TKT-96E8ZQMK-1VWQL', 11, NULL),
('95c7377b-04f6-271a-ced2-b9150b9ae343', 'TKT-5WLKNPB5-087NV', 23, NULL),
('99fde843-7c32-8ce6-091d-d1c8b05ac8af', 'TKT-RHYX3X3R-OJ8SA', 78, NULL),
('a1748223-cec4-ee79-b830-3190ac6dc580', 'TKT-RHYX3X3R-OJ8SA', 23, NULL),
('a37a5688-50c9-498d-8821-337769f7e67b', 'TKT-5WLKNPB5-087NV', 21, NULL),
('a3d7436b-c6a5-7eea-a2d2-89fd0d6b481e', 'TKT-671IDR4D-3UPOR', 24, NULL),
('a4a80656-c2e7-41e5-4e0c-0f45e4b3e909', 'TKT-96E8ZQMK-1VWQL', 42, NULL),
('a7652e77-0b04-d652-7da2-13256bfd8d5b', 'TKT-RHYX3X3R-OJ8SA', 87, NULL),
('ac932cd6-e472-3790-cda2-cb024faed7a1', 'TKT-671IDR4D-3UPOR', 5, NULL),
('ad426b77-d924-6a38-6d89-02e60b716f85', 'TKT-5WLKNPB5-087NV', 68, NULL),
('adf36b55-0b04-a361-9402-73e833cf1912', 'TKT-96E8ZQMK-1VWQL', 12, NULL),
('af05dc2e-7f0d-c1ee-5c0f-e4e8af7e639d', 'TKT-RHYX3X3R-OJ8SA', 39, NULL),
('af35e348-0ecc-b1a1-4861-1d06869dd2a0', 'TKT-NZADDMZ7-UAWFC', 21, NULL),
('b01b01f2-6e45-7349-bbb2-09efc579f9e8', 'TKT-NZADDMZ7-UAWFC', 42, NULL),
('b204d645-cd76-6bef-1ee0-4f5119fa47f9', 'TKT-96E8ZQMK-1VWQL', 10, NULL),
('b2beaf05-a750-bed1-31a6-099d5e902225', 'TKT-96E8ZQMK-1VWQL', 29, NULL),
('b673e9d3-bbee-2c32-204b-de997f16dcf6', 'TKT-96E8ZQMK-1VWQL', 6, NULL),
('b7c06664-8f24-be1b-6c1c-62d62c77fb80', 'TKT-671IDR4D-3UPOR', 31, NULL),
('b8a65c5f-17d2-69ac-4415-652483559189', 'TKT-NZADDMZ7-UAWFC', 66, NULL),
('b92013b7-bc38-125d-9700-bf9b64a8e337', 'TKT-NZADDMZ7-UAWFC', 32, NULL),
('c152a0c4-d61e-6199-fcd4-baaa82ffde23', 'TKT-96E8ZQMK-1VWQL', 33, NULL),
('c2254be0-3613-c24d-81b5-a9bef8023fcc', 'TKT-671IDR4D-3UPOR', 23, NULL),
('c4a5ead5-db64-5fdf-ea38-01f2597e6beb', 'TKT-5WLKNPB5-087NV', 13, NULL),
('c53a9c39-57d7-0b07-676f-b263899bdb5a', 'TKT-671IDR4D-3UPOR', 15, NULL),
('c5cdc079-e3d5-fec8-d8a8-8723879f905e', 'TKT-671IDR4D-3UPOR', 35, NULL),
('c918e156-4108-7408-7978-dade08595b30', 'TKT-5WLKNPB5-087NV', 59, NULL),
('cc70959d-bbff-626a-0d0e-5e982fd4c0c4', 'TKT-XO6W7GIZ-EVIGI', 43, NULL),
('cd941bef-ba97-62a5-bc70-91f84e9fcd93', 'TKT-671IDR4D-3UPOR', 6, NULL),
('d10676ab-566e-0e2a-5821-44f4fd039ae2', 'TKT-NZADDMZ7-UAWFC', 30, NULL),
('d2eb2b3a-fca9-a38c-e637-543d08513238', 'TKT-671IDR4D-3UPOR', 52, NULL),
('d59faeb3-281b-8dcf-2ec5-d202dce9ca37', 'TKT-RHYX3X3R-OJ8SA', 13, NULL),
('d5a9df98-0264-6360-d960-270b69b2e186', 'TKT-RHYX3X3R-OJ8SA', 31, NULL),
('d7643aa3-98d0-0f10-ad8c-18bf56984e6f', 'TKT-XO6W7GIZ-EVIGI', 15, NULL),
('dac63f2c-5369-9668-1ec7-5ede8eef251c', 'TKT-5WLKNPB5-087NV', 85, NULL),
('dbc78618-a79d-1fbb-2e3e-9559247b13ca', 'TKT-5WLKNPB5-087NV', 15, NULL),
('dd64ee90-4b5e-41d6-1117-d21c60b8027d', 'TKT-NZADDMZ7-UAWFC', 33, NULL),
('de561bc9-0098-491b-067d-9f580c870143', 'TKT-RHYX3X3R-OJ8SA', 33, NULL),
('e064308d-ce00-073d-c72b-e1426641dc4e', 'TKT-5WLKNPB5-087NV', 50, NULL),
('e1c9db30-0cb1-3ea8-c4f7-9497229cfc1d', 'TKT-XO6W7GIZ-EVIGI', 6, NULL),
('e2fd84f2-b69b-d6b9-f47b-879325037b69', 'TKT-96E8ZQMK-1VWQL', 32, NULL),
('e5b9087f-fce8-6687-38d8-1a4e3da06deb', 'TKT-NZADDMZ7-UAWFC', 39, NULL),
('e8fa9e95-3502-d9c6-c93e-331c82061d7d', 'TKT-RHYX3X3R-OJ8SA', 25, NULL),
('ef070843-86ce-d35e-b774-26e33ca0723d', 'TKT-5WLKNPB5-087NV', 41, NULL),
('efab72e8-1717-f51b-3085-5977743a7150', 'TKT-NZADDMZ7-UAWFC', 48, NULL),
('f16871f0-8beb-006d-2e9b-0cde8a439154', 'TKT-NZADDMZ7-UAWFC', 31, NULL),
('f2f1dcb8-6de3-ed23-8da8-6e770d8eb27a', 'TKT-XO6W7GIZ-EVIGI', 31, NULL),
('f2fa2cfb-81b5-59d5-6fec-19e66f917fc2', 'TKT-RHYX3X3R-OJ8SA', 16, NULL),
('f4516faf-93bc-e834-4bb7-acc98794d36c', 'TKT-96E8ZQMK-1VWQL', 20, NULL),
('f7543df6-9acb-ae85-6073-5681f5199f9a', 'TKT-96E8ZQMK-1VWQL', 37, NULL),
('f8143503-97c3-8532-e462-7ab6edcb4844', 'TKT-XO6W7GIZ-EVIGI', 59, NULL),
('fb55e413-0bdf-209c-6d2e-f3374778b6c2', 'TKT-671IDR4D-3UPOR', 56, NULL),
('fe42792e-e1d3-9fee-780c-0feb212093e1', 'TKT-NZADDMZ7-UAWFC', 40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bet_types`
--

CREATE TABLE `bet_types` (
  `id` char(36) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` enum('lotto','cashback') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bet_types`
--

INSERT INTO `bet_types` (`id`, `name`, `category`, `created_at`) VALUES
('BT-A2FF114F', 'Codes', 'lotto', '2026-03-25 20:00:32'),
('BT-CC0637CD', 'PERM', 'lotto', '2026-03-26 11:15:08'),
('BT1', 'Direct 5', 'lotto', '2026-03-20 12:25:27'),
('BT2', '2 Sure', 'cashback', '2026-03-20 12:25:27'),
('BT3', '3 Combo', 'cashback', '2026-03-20 12:25:27'),
('BT4', 'Cashback Basic', 'cashback', '2026-03-20 12:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` char(36) NOT NULL,
  `game_name` varchar(100) DEFAULT NULL,
  `category` enum('lotto','cashback') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `cutoff_time` timestamp NULL DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game_name`, `category`, `status`, `cutoff_time`, `created_by`, `created_at`) VALUES
('GAME-BAC65367', 'demo', 'lotto', 'inactive', '0000-00-00 00:00:00', 'ADMIN1', '2026-03-24 14:23:48'),
('GAME1', 'Lucky 5 Morning', 'cashback', 'active', NULL, 'ADMIN1', '2026-03-20 12:25:27'),
('GAME2', 'Lucky 5 Evening', 'lotto', 'active', NULL, 'ADMIN1', '2026-03-20 12:25:27'),
('GAME3', 'Cash Boost Daily', 'cashback', 'active', NULL, 'ADMIN2', '2026-03-20 12:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `game_types`
--

CREATE TABLE `game_types` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_types`
--

INSERT INTO `game_types` (`id`, `name`, `created_at`) VALUES
('141b5ecd-2bb3-11f1-87d2-0068eb6923ff', 'Baba Blue', '2026-03-29 21:04:59'),
('141b8dc7-2bb3-11f1-87d2-0068eb6923ff', 'Trex', '2026-03-29 21:04:59'),
('141b8faf-2bb3-11f1-87d2-0068eb6923ff', 'Dragon', '2026-03-29 21:04:59'),
('141b9100-2bb3-11f1-87d2-0068eb6923ff', 'Lion', '2026-03-29 21:04:59'),
('141b91b4-2bb3-11f1-87d2-0068eb6923ff', 'Tiger', '2026-03-29 21:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` char(36) NOT NULL,
  `game_id` char(36) DEFAULT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `game_id`, `published_at`) VALUES
('R1', 'GAME1', '2026-03-24 09:42:32'),
('RES-6C01F500', 'GAME-BAC65367', '2026-03-24 14:41:59'),
('RES-F8FD03D3', 'GAME1', '2026-03-24 14:47:09'),
('RESULT1', 'GAME1', '2026-03-29 21:09:45'),
('RESULT2', 'GAME1', '2026-03-29 21:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `result_details`
--

CREATE TABLE `result_details` (
  `id` char(36) NOT NULL,
  `result_id` char(36) NOT NULL,
  `game_id` char(36) NOT NULL,
  `winning_number` int(11) NOT NULL,
  `machine_number` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result_details`
--

INSERT INTO `result_details` (`id`, `result_id`, `game_id`, `winning_number`, `machine_number`, `created_at`) VALUES
('0c14ca03-2bb4-11f1-87d2-0068eb6923ff', 'RESULT1', 'GAME1', 3, 7, '2026-03-29 21:11:55'),
('0c14de4c-2bb4-11f1-87d2-0068eb6923ff', 'RESULT1', 'GAME2', 2, 5, '2026-03-29 21:11:55'),
('0c14e0be-2bb4-11f1-87d2-0068eb6923ff', 'RESULT1', 'GAME3', 9, 1, '2026-03-29 21:11:55'),
('0c14e3a4-2bb4-11f1-87d2-0068eb6923ff', 'RESULT1', 'GAME1', 4, 6, '2026-03-29 21:11:55'),
('0c14e580-2bb4-11f1-87d2-0068eb6923ff', 'RESULT1', 'GAME2', 8, 0, '2026-03-29 21:11:55'),
('0c256f65-2bb4-11f1-87d2-0068eb6923ff', 'RESULT2', 'GAME1', 5, 2, '2026-03-29 21:11:55'),
('0c26743b-2bb4-11f1-87d2-0068eb6923ff', 'RESULT2', 'GAME2', 1, 9, '2026-03-29 21:11:55'),
('0c267885-2bb4-11f1-87d2-0068eb6923ff', 'RESULT2', 'GAME3', 7, 3, '2026-03-29 21:11:55'),
('0c267bc8-2bb4-11f1-87d2-0068eb6923ff', 'RESULT2', 'GAME1', 6, 4, '2026-03-29 21:11:55'),
('0c267ebb-2bb4-11f1-87d2-0068eb6923ff', 'RESULT2', 'GAME2', 0, 8, '2026-03-29 21:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `result_numbers`
--

CREATE TABLE `result_numbers` (
  `id` char(36) NOT NULL,
  `result_id` char(36) NOT NULL,
  `game_type_id` char(36) NOT NULL,
  `number` int(11) NOT NULL,
  `type` enum('winning','machine') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result_numbers_old`
--

CREATE TABLE `result_numbers_old` (
  `id` char(36) NOT NULL,
  `result_id` char(36) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `type` enum('winning','machine') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result_numbers_old`
--

INSERT INTO `result_numbers_old` (`id`, `result_id`, `number`, `type`) VALUES
('RN-021C283B', 'RES-F8FD03D3', 22, 'machine'),
('RN-05B91DAE', 'RES-6C01F500', 44, 'machine'),
('RN-11092C5C', 'RES-6C01F500', 33, 'machine'),
('RN-147562DF', 'RES-6C01F500', 45, 'machine'),
('RN-1C379299', 'RES-F8FD03D3', 87, 'machine'),
('RN-2509650E', 'RES-F8FD03D3', 55, 'winning'),
('RN-3D445D27', 'RES-6C01F500', 44, 'winning'),
('RN-4484F639', 'RES-F8FD03D3', 33, 'winning'),
('RN-4C78B7E3', 'RES-6C01F500', 11, 'winning'),
('RN-5396AF85', 'RES-6C01F500', 55, 'winning'),
('RN-6803A784', 'RES-6C01F500', 22, 'winning'),
('RN-6861939F', 'RES-F8FD03D3', 22, 'machine'),
('RN-8482803F', 'RES-6C01F500', 33, 'machine'),
('RN-8853A19E', 'RES-F8FD03D3', 0, 'winning'),
('RN-8EFB2FC2', 'RES-F8FD03D3', 11, 'winning'),
('RN-B3877247', 'RES-F8FD03D3', 23, 'machine'),
('RN-C3EDFC08', 'RES-6C01F500', 33, 'winning'),
('RN-DB3EEC20', 'RES-F8FD03D3', 66, 'winning'),
('RN-E20F4E69', 'RES-6C01F500', 44, 'machine'),
('RN-F7D26022', 'RES-F8FD03D3', 45, 'machine'),
('RN1', 'R1', 12, 'winning'),
('RN10', 'R1', 800, 'machine'),
('RN2', 'R1', 45, 'winning'),
('RN3', 'R1', 78, 'winning'),
('RN4', 'R1', 90, 'winning'),
('RN5', 'R1', 11, 'winning'),
('RN6', 'R1', 22, 'machine'),
('RN7', 'R1', 33, 'machine'),
('RN8', 'R1', 44, 'machine'),
('RN9', 'R1', 55, 'machine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cashback_play` (`cashback_id`,`mode`),
  ADD KEY `bet_type_id` (`bet_type_id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `mode` (`mode`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `bet_numbers`
--
ALTER TABLE `bet_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bet_id` (`bet_id`),
  ADD KEY `idx_bet_game_number` (`game_type_id`,`number`);

--
-- Indexes for table `bet_types`
--
ALTER TABLE `bet_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `category` (`category`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `game_types`
--
ALTER TABLE `game_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result_details`
--
ALTER TABLE `result_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_result_game` (`result_id`,`game_id`),
  ADD KEY `idx_result_lookup` (`game_id`,`winning_number`);

--
-- Indexes for table `result_numbers_old`
--
ALTER TABLE `result_numbers_old`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `bets_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `bets_ibfk_3` FOREIGN KEY (`bet_type_id`) REFERENCES `bet_types` (`id`);

--
-- Constraints for table `bet_numbers`
--
ALTER TABLE `bet_numbers`
  ADD CONSTRAINT `bet_numbers_ibfk_1` FOREIGN KEY (`bet_id`) REFERENCES `bets` (`id`),
  ADD CONSTRAINT `fk_bet_game_type` FOREIGN KEY (`game_type_id`) REFERENCES `game_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `result_details`
--
ALTER TABLE `result_details`
  ADD CONSTRAINT `fk_result_details_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_result_details_result` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE;

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `type` (`type`);

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
