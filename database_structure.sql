-- CS2 Weapon Paints Database Structure
-- Database: cs2_weaponspaints

CREATE DATABASE IF NOT EXISTS `cs2_weaponspaints` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `cs2_weaponspaints`;

-- Main weapon skins table
CREATE TABLE `wp_player_skins` (
  `steamid` varchar(17) NOT NULL,
  `weapon_team` int(11) NOT NULL,
  `weapon_defindex` int(11) NOT NULL,
  `weapon_paint_id` int(11) NOT NULL,
  `weapon_wear` float NOT NULL,
  `weapon_seed` int(11) NOT NULL,
  `weapon_nametag` varchar(255) DEFAULT NULL,
  `weapon_stattrak` int(11) NOT NULL,
  `weapon_sticker_0` varchar(255) NOT NULL,
  `weapon_sticker_1` varchar(255) NOT NULL,
  `weapon_sticker_2` varchar(255) NOT NULL,
  `weapon_sticker_3` varchar(255) NOT NULL,
  `weapon_sticker_4` varchar(255) NOT NULL,
  `weapon_keychain` varchar(255) NOT NULL,
  PRIMARY KEY (`steamid`, `weapon_team`, `weapon_defindex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Gloves table
CREATE TABLE `wp_player_gloves` (
  `steamid` varchar(17) NOT NULL,
  `weapon_team` int(11) NOT NULL,
  `weapon_defindex` int(11) NOT NULL,
  PRIMARY KEY (`steamid`, `weapon_team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Knives table
CREATE TABLE `wp_player_knife` (
  `steamid` varchar(17) NOT NULL,
  `weapon_team` int(11) NOT NULL,
  `knife` varchar(255) NOT NULL,
  PRIMARY KEY (`steamid`, `weapon_team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Player agents table
CREATE TABLE `wp_player_agents` (
  `steamid` varchar(17) NOT NULL,
  `agent_t` varchar(255) DEFAULT NULL,
  `agent_ct` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`steamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MVP music table
CREATE TABLE `wp_player_music` (
  `steamid` varchar(17) NOT NULL,
  `weapon_team` int(11) NOT NULL,
  `music_id` int(11) NOT NULL,
  PRIMARY KEY (`steamid`, `weapon_team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
