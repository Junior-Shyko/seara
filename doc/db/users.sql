-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22/09/2017 às 02:08
-- Versão do servidor: 10.1.25-MariaDB
-- Versão do PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u884778313_seara`
--

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_phone`, `password`, `user_position`, `user_id_company`, `user_id_profile`, `user_birth`, `user_sex`, `user_cpf`, `user_addr_street`, `user_addr_number`, `user_addr_complement`, `user_addr_district`, `user_addr_city`, `user_addr_state`, `user_addr_cep`, `remember_token`, `created_at`, `updated_at`, `users_avatar`) VALUES
(1, 'Edvan Farias', 'searacontabilidade@hotmail.com', '85988133053', '$2y$10$WMTyyp.9FZLmmj87WY5jeu8Qa61akwhbh8OMIb9XZCIlT.HMKsJ56', 'Presidente', 1, 1, '1964-11-29', 'Masculino', '16586441315', 'Rua Afonso Lopes', '862', '', 'Parque Dois Irmãos', 'Fortaleza', 'CE', '60743218', 'ro4wZ7VzaqTRvjLyTrhmWukjWVBUlIn72mmSzw9wfRwNAZU9O5tQpCTVIoNi', '2017-08-04 00:30:58', '2017-08-04 00:30:58', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
