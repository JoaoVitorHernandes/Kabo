CREATE TABLE Usuario (
    Cod_Usuario INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    CPF CHAR(14) NOT NULL,
    Dt_Nascimento DATE,
    Senha CHAR(32) NOT NULL,
    Genero CHAR(1),
    Tipo_Usuario CHAR(1) NOT NULL,
    Imagem LONGBLOB,
    fk_Cod_Endereco INT,
    UNIQUE (Email, CPF)
);

CREATE TABLE Endereco (
    Cod_Endereco INT PRIMARY KEY AUTO_INCREMENT,
    CEP CHAR(9) NOT NULL,
    Logradouro VARCHAR(150) NOT NULL,
    Numero VARCHAR(5),
    Bairro VARCHAR(50) NOT NULL,
    Estado CHAR(2) NOT NULL,
    Cidade VARCHAR(50)NOT NULL
);

CREATE TABLE Cartao_pagamento (
    Cod_Cartao INT PRIMARY KEY AUTO_INCREMENT,
    fk_Cod_Usuario INT,
    Numero CHAR(16) UNIQUE NOT NULL,
    CVC CHAR(3) NOT NULL,
    Dt_Vencimento DATE NOT NULL,
    Nome_Titular VARCHAR(100) NOT NULL,
    CPF_Titular CHAR(14) NOT NULL
);

CREATE TABLE Pedido (
    Cod_Pedido INT PRIMARY KEY AUTO_INCREMENT,
	fk_Cod_Usuario INT,
    Dt_Pedido DATE,
    Forma_Pagamento VARCHAR(20),
    Status VARCHAR(20),
    Valor_total FLOAT
);

CREATE TABLE CPU (
    Cod_CPU INT PRIMARY KEY AUTO_INCREMENT,
    Soquete VARCHAR(10),
    Frequencia FLOAT,
    Nucleos INT,
    Threads INT,
    Tipo_Mem VARCHAR(4),
    Vel_Mem INT,
    GPUs VARCHAR(100),
    TDP INT
);

CREATE TABLE GPU (
    Cod_GPU INT PRIMARY KEY AUTO_INCREMENT,
    PCIe FLOAT,
    Nucleos INT,
    Tam_Memoria INT,
    Vel_Mem INT,
    TDP INT,
    Slot FLOAT,
    Tamanho VARCHAR(30),
    Tipo_Mem VARCHAR(10),
    Conector VARCHAR(20)
);

CREATE TABLE Placa_Mae (
    Cod_PlacaMae INT PRIMARY KEY AUTO_INCREMENT,
    Soquete VARCHAR(10),
    Tipo_Mem VARCHAR(4),
    Vel_Mem INT,
    PCIe FLOAT,
    M2 INT,
    SATA INT,
    Tamanho VARCHAR(10),
    Chipset VARCHAR(15)
);

CREATE TABLE Memoria_Ram (
    Cod_MemRAM INT PRIMARY KEY AUTO_INCREMENT,
    Tipo_Mem VARCHAR(10),
    Vel_Mem INT,
    Cap_Mem INT
);

CREATE TABLE Fonte (
    Cod_Fonte INT PRIMARY KEY AUTO_INCREMENT,
    Potencia INT,
	Voltagem INT,
    Corrente INT,
    Certificacao VARCHAR(20),
    Modular BOOLEAN,
    Tamanho VARCHAR(20)
);

CREATE TABLE Armazenamento (
    Cod_Armazenamento INT PRIMARY KEY AUTO_INCREMENT,
    Tipo VARCHAR(10),
    Capacidade VARCHAR(10),
    Velocidade INT,
    Conexao VARCHAR(10)
);

CREATE TABLE Gabinete (
    Cod_Gabinete INT PRIMARY KEY AUTO_INCREMENT,
    Tamanho VARCHAR(30),
    Tamanho_PM VARCHAR(10),
    Tamanho_FT VARCHAR(10),
    Tamanho_GPU VARCHAR(30),
    Slot_GPU FLOAT
);

CREATE TABLE Monitor (
    Cod_Monitor INT PRIMARY KEY AUTO_INCREMENT,
    Tamanho VARCHAR(20),
    Tipo_Painel VARCHAR(5),
    Resolucao VARCHAR(20),
    Proporcao VARCHAR(5),
    Taxa_Att INT,
    HDMI INT,
    DP INT,
    Tempo_Resposta FLOAT
);

CREATE TABLE Teclado (
    Cod_Teclado INT PRIMARY KEY AUTO_INCREMENT,
    Tipo VARCHAR(50),
    Layout VARCHAR(10),
    Tamanho VARCHAR(20),
    Formato VARCHAR(5),
    Switch VARCHAR(20),
    Cor VARCHAR(10),
    Iluminacao VARCHAR(10),
    Conexao VARCHAR(10),
    Tipo_Conexao VARCHAR(10)
);

CREATE TABLE Mouse (
    Cod_Mouse INT PRIMARY KEY AUTO_INCREMENT,
    DPI INT,
    Polling_Rate INT,
    Botoes INT,
    Cor VARCHAR(10),
    Iluminacao VARCHAR(10),
    Conexao VARCHAR(10),
    Tipo_Conexao VARCHAR(10)
);

CREATE TABLE Headset (
    Cod_Headset INT PRIMARY KEY AUTO_INCREMENT,
    Driver INT,
    Frequencia_Audio INT,
    Conexao VARCHAR(10),
    Tipo_Conexao VARCHAR(10),
    Cor VARCHAR(10),
    Frequencia_Mic INT,
    Padrao_Polar VARCHAR(20),
    Iluminacao VARCHAR(10)
);

CREATE TABLE Cupom (
    Cod_Cupom INT PRIMARY KEY AUTO_INCREMENT,
    fk_Cod_Usuario INT,
    fk_Cod_Pedido INT
);

CREATE TABLE Produto_Tipo (
    Cod_Produto INT PRIMARY KEY AUTO_INCREMENT,
    Descricao VARCHAR(100) NOT NULL,
    Preco FLOAT NOT NULL,
    Modelo VARCHAR(100) NOT NULL,
    Marca VARCHAR(100) NOT NULL,
    Qtd_estoque INT NOT NULL,
    Imagem BLOB NOT NULL,
    fk_Cod_PlacaMae INT,
    fk_Cod_GPU INT,
    fk_Cod_Fonte INT,
    fk_Cod_Gabinete INT,
    fk_Cod_Monitor INT,
    fk_Cod_Mouse INT,
    fk_Cod_Headset INT,
    fk_Cod_MemRAM INT,
    fk_Cod_Armazenamento INT,
    fk_Cod_Teclado INT,
    fk_Cod_CPU INT
);

CREATE TABLE Tem (
    fk_Cod_Pedido INT,
    fk_Cod_Produto_Tipo INT,
    Quantidade INT
);

CREATE TABLE AdicionaCarrinho (
    fk_Cod_Usuario INT,
    fk_Cod_Produto_Tipo INT,
    Quantidade INT
);
 
ALTER TABLE Usuario ADD CONSTRAINT FK_Endereco_2
    FOREIGN KEY (fk_Cod_Endereco)
    REFERENCES Endereco (Cod_Endereco)
    ON DELETE RESTRICT;
 
ALTER TABLE Cartao_pagamento ADD CONSTRAINT FK_Cartao_pagamento_2
    FOREIGN KEY (fk_Cod_Usuario)
    REFERENCES Usuario (Cod_Usuario)
    ON DELETE RESTRICT;
 
ALTER TABLE Pedido ADD CONSTRAINT FK_Pedido_2
    FOREIGN KEY (fk_Cod_Usuario)
    REFERENCES Usuario (Cod_Usuario)
    ON DELETE RESTRICT;
 
ALTER TABLE Cupom ADD CONSTRAINT FK_Cupom_2
    FOREIGN KEY (fk_Cod_Usuario)
    REFERENCES Usuario (Cod_Usuario)
    ON DELETE CASCADE;
 
ALTER TABLE Cupom ADD CONSTRAINT FK_Cupom_3
    FOREIGN KEY (fk_Cod_Pedido)
    REFERENCES Pedido (Cod_Pedido)
    ON DELETE CASCADE;
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_2
    FOREIGN KEY (fk_Cod_PlacaMae)
    REFERENCES Placa_Mae (Cod_PlacaMae);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_3
    FOREIGN KEY (fk_Cod_GPU)
    REFERENCES GPU (Cod_GPU);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_4
    FOREIGN KEY (fk_Cod_Fonte)
    REFERENCES Fonte (Cod_Fonte);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_5
    FOREIGN KEY (fk_Cod_Gabinete)
    REFERENCES Gabinete (Cod_Gabinete);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_6
    FOREIGN KEY (fk_Cod_Monitor)
    REFERENCES Monitor (Cod_Monitor);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_7
    FOREIGN KEY (fk_Cod_Mouse)
    REFERENCES Mouse (Cod_Mouse);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_8
    FOREIGN KEY (fk_Cod_Headset)
    REFERENCES Headset (Cod_Headset);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_9
    FOREIGN KEY (fk_Cod_MemRAM)
    REFERENCES Memoria_Ram (Cod_MemRAM);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_10
    FOREIGN KEY (fk_Cod_Armazenamento)
    REFERENCES Armazenamento (Cod_Armazenamento);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_11
    FOREIGN KEY (fk_Cod_Teclado)
    REFERENCES Teclado (Cod_Teclado);
 
ALTER TABLE Produto_Tipo ADD CONSTRAINT FK_Produto_Tipo_12
    FOREIGN KEY (fk_Cod_CPU)
    REFERENCES CPU (Cod_CPU);
 
ALTER TABLE Tem ADD CONSTRAINT FK_Tem_1
    FOREIGN KEY (fk_Cod_Pedido)
    REFERENCES Pedido (Cod_Pedido)
    ON DELETE RESTRICT;
 
ALTER TABLE Tem ADD CONSTRAINT FK_Tem_2
    FOREIGN KEY (fk_Cod_Produto_Tipo)
    REFERENCES Produto_Tipo (Cod_Produto)
    ON DELETE RESTRICT;
 
ALTER TABLE AdicionaCarrinho ADD CONSTRAINT FK_AdicionaCarrinho_1
    FOREIGN KEY (fk_Cod_Usuario)
    REFERENCES Usuario (Cod_Usuario)
    ON DELETE SET NULL;
 
ALTER TABLE AdicionaCarrinho ADD CONSTRAINT FK_AdicionaCarrinho_2
    FOREIGN KEY (fk_Cod_Produto_Tipo)
    REFERENCES Produto_Tipo (Cod_Produto)
    ON DELETE SET NULL;