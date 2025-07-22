-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Jul-2025 às 19:47
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `recipe_app_dump`
--
CREATE DATABASE IF NOT EXISTS `recipe_app_dump` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `recipe_app_dump`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `ID` int(11) NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`ID`, `nome`) VALUES
(1, 'Sobremesa'),
(2, 'Vegetariana');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
CREATE TABLE `ingrediente` (
  `ID` int(11) NOT NULL,
  `Ingredientes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ingrediente`
--

INSERT INTO `ingrediente` (`ID`, `Ingredientes`) VALUES
(1, 'Farinha de trigo'),
(2, 'Açúcar'),
(3, 'Ovos'),
(4, 'Leite'),
(5, 'Fermento em pó'),
(6, 'Oleo'),
(7, 'Cenoura'),
(8, 'wrap'),
(9, 'alface'),
(10, 'Frango'),
(11, 'maionese');

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

DROP TABLE IF EXISTS `receita`;
CREATE TABLE `receita` (
  `ID` int(11) NOT NULL,
  `nome_receita` text NOT NULL,
  `modo_preparo` text NOT NULL,
  `tempo_preparo` int(11) NOT NULL,
  `doses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`ID`, `nome_receita`, `modo_preparo`, `tempo_preparo`, `doses`) VALUES
(1, 'Bolo de Cenoura', 'Misture os ingredientes e asse por 40 minutos.', 40, 10),
(2, 'Wrap de Frango', 'Cozinhe e tempere o frango, passe maionese no wrap, recheie com o frango e alface.', 10, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita_categoria`
--

DROP TABLE IF EXISTS `receita_categoria`;
CREATE TABLE `receita_categoria` (
  `ID` int(11) NOT NULL,
  `ID_categoria` int(11) NOT NULL,
  `ID_receita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `receita_categoria`
--

INSERT INTO `receita_categoria` (`ID`, `ID_categoria`, `ID_receita`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita_ingrediente`
--

DROP TABLE IF EXISTS `receita_ingrediente`;
CREATE TABLE `receita_ingrediente` (
  `ID` int(11) NOT NULL,
  `ID_receita` int(11) NOT NULL,
  `ID_ingrediente` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `unidade_medida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `receita_ingrediente`
--

INSERT INTO `receita_ingrediente` (`ID`, `ID_receita`, `ID_ingrediente`, `quantidade`, `unidade_medida`) VALUES
(1, 1, 1, 2, 0),
(2, 1, 2, 1, 0),
(3, 1, 3, 3, 0),
(4, 1, 4, 1, 0),
(5, 1, 5, 4, 0),
(6, 1, 6, 3, 0),
(7, 1, 7, 2, 0),
(8, 1, 1, 2, 0),
(9, 1, 2, 1, 0),
(10, 1, 3, 3, 0),
(11, 1, 4, 1, 0),
(12, 1, 5, 4, 0),
(13, 1, 6, 1, 0),
(14, 1, 7, 2, 0),
(15, 2, 1, 1, 0),
(16, 2, 1, 1, 0),
(17, 2, 1, 1, 0),
(18, 2, 2, 2, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `receita_categoria`
--
ALTER TABLE `receita_categoria`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_receita` (`ID_receita`),
  ADD KEY `ID_categoria` (`ID_categoria`);

--
-- Índices para tabela `receita_ingrediente`
--
ALTER TABLE `receita_ingrediente`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_receita` (`ID_receita`),
  ADD KEY `ID_ingrediente` (`ID_ingrediente`),
  ADD KEY `unidade_medida` (`unidade_medida`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `receita_ingrediente`
--
ALTER TABLE `receita_ingrediente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
