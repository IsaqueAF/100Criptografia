CREATE TABLE IF NOT EXISTS conta_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS token_lembrete (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_conta_usuario INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_expiracao TIMESTAMP NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_token_lembrete_conta_usuario
        FOREIGN KEY (id_conta_usuario) 
        REFERENCES conta_usuario(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS recuperar_senha (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_conta_usuario INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_expiracao TIMESTAMP NOT NULL,
    CONSTRAINT fk_recuperar_senha_conta_usuario
        FOREIGN KEY (id_conta_usuario) 
        REFERENCES conta_usuario(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS preset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_conta_usuario INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    estrutura JSON NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_preset_conta_usuario
        FOREIGN KEY (id_conta_usuario) 
        REFERENCES conta_usuario(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_conta_usuario INT NOT NULL,
    entrada TEXT,
    saida TEXT,
    estrutura JSON,
    data_execucao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_historico_conta_usuario
        FOREIGN KEY (id_conta_usuario) 
        REFERENCES conta_usuario(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);