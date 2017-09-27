-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22/09/2017 às 02:12
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
-- Fazendo dump de dados para tabela `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `company_fantasy`, `company_cnpj`, `company_addr_street`, `company_addr_number`, `company_addr_complement`, `company_addr_district`, `company_addr_city`, `company_addr_state`, `company_addr_cep`, `company_phone`, `company_mobile`, `company_brand_logo`, `created_at`, `updated_at`, `company_status`) VALUES
(1, 'EDVAN OLIVEIRA FARIAS - ME', 'SEARA CONTABILIDADE', '13.803.621/0001-55', 'RUA AFONSO LOPES', '862', 'ALTOS', 'PARQUE DOIS IRMAOS', 'FORTALEZA', 'CE', '60.743-218', '(85) 3493-4647', '(85) 98813-3053', '1501807071_SBOH0O0v9u.png', '2017-08-04 00:30:58', '2017-08-14 13:11:12', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
