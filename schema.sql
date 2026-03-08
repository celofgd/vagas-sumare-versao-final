-- ============================================================
-- Estrutura do banco de dados do projeto "Vagas em Sumaré"
-- Execute este arquivo no MySQL para criar o banco e as tabelas.
-- ============================================================

CREATE DATABASE IF NOT EXISTS vagasumareprd
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE vagasumareprd;

-- Tabela de usuários: quem pode logar no sistema (recrutador ou candidato)
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  papel ENUM('recruiter','candidate') NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de vagas: cada vaga pertence a um recrutador (criado_por)
CREATE TABLE IF NOT EXISTS vagas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(60) NOT NULL,
  empresa VARCHAR(30) NOT NULL,
  localizacao VARCHAR(255) NULL,
  rua VARCHAR(100) NULL,
  numero VARCHAR(10) NULL,
  bairro VARCHAR(60) NULL,
  cidade VARCHAR(100) NULL,
  cep VARCHAR(9) NULL,
  descricao TEXT NOT NULL,
  salario VARCHAR(100) NULL,
  regime ENUM('CLT','CNPJ','Freelance') NULL,
  escala_horario VARCHAR(255) NULL,
  dia_inicio VARCHAR(20) NULL,
  dia_fim VARCHAR(20) NULL,
  horario_inicio VARCHAR(5) NULL,
  horario_fim VARCHAR(5) NULL,
  beneficios TEXT NULL,
  meio_contato VARCHAR(500) NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  criado_por INT NULL,
  CONSTRAINT fk_vagas_criado_por FOREIGN KEY (criado_por) REFERENCES usuarios(id) ON DELETE SET NULL,
  INDEX idx_vagas_criado_por (criado_por)
);
