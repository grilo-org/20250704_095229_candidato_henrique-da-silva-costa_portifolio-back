-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/01/2025 às 16:37
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reservas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `barbearia`
--

CREATE TABLE `barbearia` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `logradouro` text NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `localidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `barbearia`
--

INSERT INTO `barbearia` (`id`, `nome`, `usuarios_id`, `cep`, `logradouro`, `bairro`, `localidade`, `estado`, `numero`, `telefone`) VALUES
(284, 'Marcelo cabelo-barba', 65, '69900-078', 'Avenida Brasil', 'Centro', 'Rio Branco', 'Acre', '697', '86-83838-3686'),
(285, 'Alfa men barber\'s', 65, '60762-475', 'Rua Amaro José Sousa', 'Mondubim', 'Fortaleza', 'Ceará', '500', '44-35564-4464'),
(286, 'Ostent Barber\'s', 65, '87205-048', 'Avenida Arthur M Thomas', 'Zona 06', 'Cianorte', 'Paraná', '112', '56-32889-8745');

-- --------------------------------------------------------

--
-- Estrutura para tabela `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `horario` time NOT NULL,
  `barbearia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `horarios`
--

INSERT INTO `horarios` (`id`, `horario`, `barbearia_id`) VALUES
(152, '08:00:00', 284),
(153, '09:00:00', 285),
(154, '11:00:00', 286),
(155, '08:00:00', 286),
(156, '16:00:00', 286),
(157, '18:00:00', 286),
(158, '13:30:00', 285),
(159, '10:00:00', 285),
(160, '17:00:00', 285),
(161, '10:00:00', 284),
(162, '12:00:00', 284),
(163, '13:30:00', 284);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `servico_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `barbearia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id`, `nome`, `data`, `hora`, `servico_id`, `usuarios_id`, `barbearia_id`) VALUES
(44, 'Juca bala', '2025-01-07', '12:00:00', 54, 66, 284),
(45, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(46, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(47, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(48, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(49, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(50, 'Joca', '2025-01-07', '16:00:00', 63, 67, 286),
(51, 'Juca bala', '2025-01-07', '12:00:00', 54, 66, 284),
(52, 'Juca bala', '2025-01-07', '12:00:00', 54, 66, 284),
(53, 'Juca bala', '2025-01-28', '12:00:00', 56, 66, 284);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `barbearia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `valor`, `barbearia_id`) VALUES
(54, 'Barba', 30.00, 284),
(55, 'Corte e barba', 60.00, 284),
(56, 'Degrade', 25.00, 284),
(57, 'Corte e Luzes', 45.00, 285),
(58, 'Corte', 20.00, 285),
(59, 'Corte e Barba', 30.00, 285),
(60, 'Barba na navalha', 58.00, 285),
(62, 'Corte', 25.00, 286),
(63, 'Corte e Barba', 50.00, 286),
(64, 'Corte americano', 20.00, 286);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `master` tinyint(1) NOT NULL DEFAULT 0,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `master`, `img`) VALUES
(65, 'Marcelo', 'marcelo@live.com', '$2y$10$QjpH1p4IoOoCTE9rpDibdetkzx8E7P6X5OBUUzcOAlAxQ/H5zjUPq', 1, '/storage/images/1736249208.jpg'),
(66, 'Juca bala', 'juca@live.com', '$2y$10$faSB9AgUmnlXFBtbxCS28uQzKk6ljtUQy3clg2o8SeRD2hOb1PQPG', 0, '/storage/images/1736255814.jpg'),
(67, 'Joca', 'joca@live.com', '$2y$10$OqiM6Eq6Pp/a8Fu0sJ3dcuLTYv5e32CEgJRErLVN6z5JJZykJ14fS', 0, '/storage/images/1736259236.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `barbearia`
--
ALTER TABLE `barbearia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barbearia_usuarios1_idx` (`usuarios_id`);

--
-- Índices de tabela `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horarios_barbearia1_idx` (`barbearia_id`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reserva_servico_idx` (`servico_id`),
  ADD KEY `fk_reserva_usuarios1_idx` (`usuarios_id`),
  ADD KEY `fk_reserva_barbearia1_idx` (`barbearia_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicos_barbearia1_idx` (`barbearia_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `barbearia`
--
ALTER TABLE `barbearia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT de tabela `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `barbearia`
--
ALTER TABLE `barbearia`
  ADD CONSTRAINT `fk_barbearia_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_barbearia1` FOREIGN KEY (`barbearia_id`) REFERENCES `barbearia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_barbearia1` FOREIGN KEY (`barbearia_id`) REFERENCES `barbearia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reserva_servico` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reserva_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servicos_barbearia1` FOREIGN KEY (`barbearia_id`) REFERENCES `barbearia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
