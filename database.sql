-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/01/2026 às 17:48
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
-- Banco de dados: `turismo_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `nome`, `email`, `senha`, `created_at`) VALUES
(1, 'Seu Sogro', 'admin@agencia.com', '$2y$10$cg5IsN7TOtDhSJeQ7.YnXembnm5b8i9BvbvR3NWXmK/xjHTU8RISK', '2026-01-14 11:35:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos_passeio`
--

CREATE TABLE `fotos_passeio` (
  `id` int(11) NOT NULL,
  `passeio_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `fotos_passeio`
--

INSERT INTO `fotos_passeio` (`id`, `passeio_id`, `imagem`, `created_at`) VALUES
(2, 5, '69679797336b3-1.jpeg', '2026-01-14 13:18:15'),
(3, 5, '6967979733e57-2.jpg', '2026-01-14 13:18:15'),
(4, 5, '69679797349f4-3.jpg', '2026-01-14 13:18:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `passeios`
--

CREATE TABLE `passeios` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `roteiro` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `passeios`
--

INSERT INTO `passeios` (`id`, `titulo`, `descricao`, `roteiro`, `preco`, `imagem`, `ativo`, `created_at`) VALUES
(3, 'Praia de Maragogi', 'Praia de Maragogi é um local repleto de belezas naturais com seus corais que protegem a costa da praia e assim permitindo a natureza a revelar piscinas naturais e um caminho que se abre parte do oceano, venha desfrutar desse passeio maravilhoso.', NULL, 150.00, '69678d7547cb9.jpeg', 1, '2026-01-14 12:35:01'),
(4, 'São Miguel dos Milagres', 'bla blabl alblalbalbalblablal ablallb albalbalbla', NULL, 100.00, '69678f3c87eff.jpg', 1, '2026-01-14 12:42:36'),
(5, 'Praia do Gunga', 'Blablablablalbablablabla blablabla bla bla bla ', NULL, 75.00, '696790301d968.jpg', 1, '2026-01-14 12:46:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `site_config`
--

CREATE TABLE `site_config` (
  `id` int(11) NOT NULL DEFAULT 1,
  `nome_site` varchar(100) DEFAULT 'É de Maceió Turismo',
  `whatsapp` varchar(20) DEFAULT '5582999999999',
  `instagram` varchar(255) DEFAULT '#',
  `facebook` varchar(255) DEFAULT '#',
  `email_contato` varchar(100) DEFAULT 'contato@edemaceio.com.br',
  `endereco` text DEFAULT 'Maceió, Alagoas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `site_config`
--

INSERT INTO `site_config` (`id`, `nome_site`, `whatsapp`, `instagram`, `facebook`, `email_contato`, `endereco`) VALUES
(1, 'É de Maceió', '5582999999999', '#', '#', 'contato@edemaceio.com.br', 'Maceió, Alagoas');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `fotos_passeio`
--
ALTER TABLE `fotos_passeio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passeio_id` (`passeio_id`);

--
-- Índices de tabela `passeios`
--
ALTER TABLE `passeios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `site_config`
--
ALTER TABLE `site_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fotos_passeio`
--
ALTER TABLE `fotos_passeio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `passeios`
--
ALTER TABLE `passeios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `fotos_passeio`
--
ALTER TABLE `fotos_passeio`
  ADD CONSTRAINT `fotos_passeio_ibfk_1` FOREIGN KEY (`passeio_id`) REFERENCES `passeios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
