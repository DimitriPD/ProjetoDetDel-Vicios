create database vicios_detdelunity;
use vicios_detdelunity;

create table tb_estados(
	cod_estado int primary key,
    sigla char(2) not null,
    nome_estado varchar(50) not null
);

create table tb_cidades(
	cod_cidade int primary key,
    nome_cidade varchar(50) not null,
    cod_estado int not null,
    foreign key (cod_estado) references tb_estados(cod_estado)
);

create table tb_especialidades(
	cod_especialidade int primary key,
    descricao_especialidade varchar(50) not null
);

create table tb_tipos_usuario(
	cod_tipo_usuario int primary key,
    descricao_tipo_usuario varchar(50) not null   
);

create table tb_usuarios(
	cod_usuario int primary key,
    nome_usuario varchar(100) not null,
    email varchar(100) not null,
    senha_hash varchar(100) not null,
    data_nascimento date not null,
    data_hora_cadastro datetime not null,
    cod_cidade int not null,
    cod_tipo_usuario int not null,
    foreign key (cod_cidade) references tb_cidades(cod_cidade),
    foreign key (cod_tipo_usuario) references tb_tipos_usuario(cod_tipo_usuario)
);

create table tb_usuario_especialidades(
	cod_usuario int,
	cod_especialidade int,
	primary key(cod_usuario, cod_especialidade),
	foreign key (cod_especialidade) references tb_especialidades(cod_especialidade),
	foreign key (cod_usuario) references tb_usuarios(cod_usuario)
);

create table tb_avaliacoes_site(
	cod_usuario int primary key,
    nota int not null,
    justificativa varchar(500),
    foreign key (cod_usuario) references tb_usuarios(cod_usuario)
);

create table tb_vicios(
	cod_vicio int primary key,
    descricao_vicio varchar(50) not null
);

create table tb_locais_atendimentos(
	cod_local int primary key,
    nome_local varchar(100) not null,
    email varchar(100) not null,
    rua varchar(100) not null,
    numero_endereco varchar(25) not null,
    bairro varchar(50) not null,
    cod_cidade int not null,
    foreign key (cod_cidade) references tb_cidades(cod_cidade)
);

create table tb_local_telefones(
	cod_local int,
	telefone char(15),
	ddd char(3),
	primary key (ddd, telefone, cod_local),
	foreign key (cod_local) references tb_locais_atendimentos(cod_local)
);

create table tb_local_vicios(
	cod_local int,
	cod_vicio int,
	primary key (cod_vicio, cod_local),
	foreign key (cod_local) references tb_locais_atendimentos(cod_local),
	foreign key (cod_vicio) references tb_vicios(cod_vicio)
);

create table tb_paginas(
	cod_pagina int primary key, 
    titulo varchar(100) not null,
    conteudo_pagina text not null,
    data_hora_criacao datetime not null,
    esta_ativa int not null,
    cod_usuario_criador int not null,
    foreign key (cod_usuario_criador) references tb_usuarios(cod_usuario)
);

create table tb_pagina_vicios(
	cod_vicio int,
	cod_pagina int,
	primary key (cod_vicio, cod_pagina),
	foreign key (cod_pagina) references tb_paginas(cod_pagina),
	foreign key (cod_vicio) references tb_vicios(cod_vicio)
);

create table tb_pagina_manipulacoes(
	cod_usuario int, 
	cod_pagina int,
	data_hora_manipulacao datetime,
	descricao_manipulacao varchar(500) not null,
	primary key (cod_usuario, cod_pagina, data_hora_manipulacao),
	foreign key (cod_pagina) references tb_paginas(cod_pagina),
	foreign key (cod_usuario) references tb_usuarios(cod_usuario)
);

create table tb_status_pergunta(
	cod_status_pergunta int primary key,
	descricao_status_perg varchar(30) not null
);

create table tb_perguntas(
	cod_pergunta int primary key,
	cod_usuario_pergunta int not null,
	conteudo_pegunta varchar(1000) not null,
	data_hora_envio datetime not null,
	cod_status_pergunta int not null,
	conteudo_resposta varchar(5000),
	data_hora_resposta datetime,
	cod_usuario_resposta int,
	cod_usuario_analise int,
	data_hora_analise datetime,
	descricao_analise varchar(1000),	
	foreign key (cod_status_pergunta) references tb_status_pergunta(cod_status_pergunta),
	foreign key (cod_usuario_pergunta) references tb_usuarios(cod_usuario),
	foreign key (cod_usuario_analise) references tb_usuarios(cod_usuario),
	foreign key (cod_usuario_resposta) references tb_usuarios(cod_usuario)
);

create table tb_pergunta_vicios(
	cod_pergunta int,
	cod_vicio int,
	primary key (cod_pergunta, cod_vicio),
	foreign key (cod_pergunta) references tb_perguntas(cod_pergunta),
	foreign key (cod_vicio) references tb_vicios(cod_vicio)
);

create table tb_pergunta_curtidas(
	cod_pergunta int,
	cod_usuario int,
	primary key (cod_pergunta, cod_usuario),
	foreign key (cod_pergunta) references tb_perguntas(cod_pergunta),
	foreign key (cod_usuario) references tb_usuarios(cod_usuario)
);

create table tb_identificacoes_relato(
	cod_identificacao_relato int primary key,
	descricao_identificacao varchar(50) not null
);

create table tb_relato_status(
	cod_status_relato int primary key,
	descricao_status_relato varchar(30) not null
);

create table tb_relatos(
	cod_relato int primary key,
	cod_usuario_relato int not null,
	conteudo_relato varchar(3000) not null,
	cod_identificacao_relato int not null,
	cod_status_relato int not null,
	esta_anonimo boolean not null,
	data_hora_envio datetime not null,
	cod_usuario_analise int,
	data_hora_analise datetime,
	descricao_analise varchar(1000),
	foreign key (cod_usuario_relato) references tb_usuarios(cod_usuario),
	foreign key (cod_usuario_analise) references tb_usuarios(cod_usuario),
	foreign key (cod_identificacao_relato) references tb_identificacoes_relato(cod_identificacao_relato),
	foreign key (cod_status_relato) references tb_relato_status(cod_status_relato)
);

create table tb_relato_curtidas(
	cod_usuario int,
	cod_relato int,
	primary key (cod_usuario, cod_relato),
	foreign key (cod_usuario) references tb_usuarios(cod_usuario),
    foreign key (cod_relato) references tb_relatos(cod_relato)
);

create table tb_relato_vicios(
    cod_relato int, 
    cod_vicio int,
    primary key (cod_relato , cod_vicio),
    foreign key (cod_relato) references tb_relatos(cod_relato),
    foreign key (cod_vicio) references tb_vicios(cod_vicio)
);

/*-------------------------------INSERÇÃO-------------------------------------------*/

-- Inserir registros em tb_estados
INSERT INTO tb_estados (cod_estado, sigla, nome_estado)
VALUES
    (1, 'SP', 'São Paulo'),
    (2, 'RJ', 'Rio de Janeiro'),
    (3, 'MG', 'Minas Gerais'),
    (4, 'RS', 'Rio Grande do Sul'),
    (5, 'PR', 'Paraná');

-- Inserir registros em tb_cidades
INSERT INTO tb_cidades (cod_cidade, nome_cidade, cod_estado)
VALUES
    (1, 'São Paulo', 1),
    (2, 'Rio de Janeiro', 2),
    (3, 'Belo Horizonte', 3),
    (4, 'Porto Alegre', 4),
    (5, 'Curitiba', 5);   

-- Inserir registros em tb_especialidades
INSERT INTO tb_especialidades (cod_especialidade, descricao_especialidade)
VALUES
    (1, 'Psiquiatria'),
    (2, 'Psicologia');

-- Inserir registros em tb_tipos_usuario
INSERT INTO tb_tipos_usuario (cod_tipo_usuario, descricao_tipo_usuario)
VALUES
	(1, 'Administrador Master'),
    (2, 'Administrador'),
    (3, 'Profissional de Saúde'),
    (4, 'Comum');

-- Inserir registros em tb_usuarios
INSERT INTO tb_usuarios (cod_usuario, nome_usuario, email, senha_hash, data_nascimento, data_hora_cadastro, cod_cidade, cod_tipo_usuario)
VALUES
    (1, 'João Silva', 'joao@example.com', 'senha123', '1990-05-15', now(), 1, 2),
    (2, 'Maria Santos', 'maria@example.com', 'senhamaria', '1985-08-22', now(), 2, 1),
    (3, 'Carlos Oliveira', 'carlos@example.com', 'senha321', '2000-03-10', now(), 1, 3),
    (4, 'Ana Pereira', 'ana@example.com', 'senhaana', '1995-11-28', now(), 3, 4),
    (5, 'José Almeida', 'jose@example.com', 'senha12345', '1982-07-03', now(), 2, 4),
    (6, 'Mariana Costa', 'mariana@example.com', 'senhamariana', '1998-02-14', now(), 4, 3),
    (7, 'Pedro Rocha', 'pedro@example.com', 'senhapedro', '1989-09-05', now(), 3, 3),
    (8, 'Sara Fernandes', 'sara@example.com', 'senha456', '1993-07-19', now(), 5, 3),
    (9, 'Antônio Santos', 'antonio@example.com', 'senhaantonio', '1987-11-01', now(), 4, 3),
    (10, 'Camila Delarosa', 'camila@example.com', 'senha123', '2001-03-01', now(), 5, 2),
    (11, 'Juliano Detiuk', 'juliano@example.com', 'senha123', '1995-09-12', now(), 5, 4),
    (12, 'Afonso Fonseca', 'afonso@example.com', 'senha123', '1998-05-22', now(), 5, 4),
    (13, 'Dimitri Delinski', 'dimitri@example.com', 'senha123', '2004-05-27', now(), 3, 3);


-- Inserir registros em tb_usuario_especialidades
INSERT INTO tb_usuario_especialidades (cod_usuario, cod_especialidade)
VALUES (3, 1),
       (6, 1),
       (7, 2),
       (8, 2),
       (9, 2),
       (13, 2);

-- Inserir registros em tb_avaliacoes_site
INSERT INTO tb_avaliacoes_site (cod_usuario, nota, justificativa)
VALUES
    (4, 9, 'Ótimo serviço, estou muito satisfeito!'),
    (5, 6, 'Bom site, mas poderia ter melhorias.');
   

-- Inserir registros em tb_vicios
INSERT INTO tb_vicios (cod_vicio, descricao_vicio)
VALUES
    (1, 'Alcoolismo'),
    (2, 'Tabagismo'),
    (3, 'Drogas Ilícitas'),
    (4, 'Compulsão Alimentar'),
    (5, 'Jogos Patológicos'),
    (6, 'Compras Compulsivas'),
    (7, 'Redes Sociais'),
    (8, 'Video Games'),
    (9, 'Sexo'),
    (10, 'Pornografia');
   
-- Inserir registros em tb_locais_atendimentos
INSERT INTO tb_locais_atendimentos (cod_local, nome_local, email, rua, numero_endereco, bairro, cod_cidade)
VALUES
    (1, 'Clínica Esperança', 'contato@clinicaesperanca.com', 'Rua da Paz', '123', 'Centro', 1),
    (2, 'Consultório Dr. Silva', 'drsilva@email.com', 'Avenida das Flores', '456', 'Jardins', 2),
    (3, 'Clínica Renascer', 'contato@clinicarenascer.com', 'Rua das Árvores', '789', 'Bela Vista', 3),
    (4, 'Consultório Dra. Santos', 'drasantos@email.com', 'Avenida Principal', '101', 'Novo Horizonte', 4),
    (5, 'Clínica Serenidade', 'contato@clinicaserenidade.com', 'Rua das Montanhas', '222', 'Tranquilidade', 5),
    (6, 'Consultório Zé Pequeno Carioquinha', 'carioquinhazexx@email.com', 'Rua Adalberto Castanho Primário', '037', 'Copacabana', 2);
    
   
-- Inserir registros em tb_local_telefones
INSERT INTO tb_local_telefones (cod_local, telefone, ddd)
VALUES
    (1, '1234-5678', '011'),
    (1, '9876-5432', '011'),
    (2, '5555-5555', '021'),
    (3, '1111-2222', '041'),
    (4, '3333-3333', '051'),
    (5, '7777-8888', '081'),
    (1, '4444-4444', '011'),
    (2, '6666-7777', '021'),
    (3, '9999-0000', '041'),
    (5, '1234-5678', '081');

-- Inserir registros em tb_local_vicios
INSERT INTO tb_local_vicios (cod_local,cod_vicio)
VALUES
	(3, 1),
	(1, 1),
	(1, 2),
	(2, 4),
	(3, 5),
	(3, 7),
	(3, 8),
	(4, 9),
	(4, 10),
	(5, 3),
	(5, 6);

-- Inserir registros em tb_paginas
INSERT INTO tb_paginas (cod_pagina, titulo, conteudo_pagina, data_hora_criacao, esta_ativa, cod_usuario_criador)
VALUES
    (1, 'Vício em Álcool', '<html><body><h1>Vício em Álcool</h1><p>O vício em álcool é uma condição...</p></body></html>', '2023-10-11 12:00:00', 1, 1),
    (2, 'Vício em Tabaco', '<html><body><h1>Vício em Tabaco</h1><p>O tabagismo é uma dependência...</p></body></html>', '2023-10-11 12:15:00', 1, 10),
    (3, 'Vício em Drogas Ilícitas', '<html><body><h1>Vício em Drogas Ilícitas</h1><p>O abuso de substâncias ilícitas...</p></body></html>', '2023-10-11 12:30:00', 1, 1),
    (4, 'Compulsão Alimentar', '<html><body><h1>Compulsão Alimentar</h1><p>A compulsão alimentar é um distúrbio...</p></body></html>', '2023-10-11 12:45:00', 0, 10),
    (5, 'Jogo Patológico', '<html><body><h1>Jogo Patológico</h1><p>O jogo patológico, ou ludomania...</p></body></html>', '2023-10-11 13:00:00', 1, 1);
    
-- Inserir registros em tb_pagina_vicios  
INSERT INTO tb_pagina_vicios (cod_vicio, cod_pagina)
VALUES
	(1,1),
	(2,2),
	(3,3),
	(4,4),
	(5,5);

-- Inserir registros em tb_pagina_manipulacoes  
INSERT INTO tb_pagina_manipulacoes (cod_usuario, cod_pagina, data_hora_manipulacao, descricao_manipulacao)
VALUES
	(10, 1, '2023-10-12 14:31:00', 'Correção de erros de português.'),
	(10, 5, '2023-10-12 20:41:00', 'Inserção de um novo jogo no texto.');

-- Inserir registros em tb_status_pergunta
INSERT INTO tb_status_pergunta (cod_status_pergunta, descricao_status_perg)
VALUES
	(1, 'EM ANÁLISE'),
	(2, 'REPROVADA'),
	(3, 'AGUARDANDO RESPOSTA'),
	(4, 'RESPONDIDA');
	
-- Inserir registros em tb_perguntas
INSERT INTO tb_perguntas (cod_pergunta, cod_usuario_pergunta, conteudo_pegunta, data_hora_envio, cod_status_pergunta, conteudo_resposta, data_hora_resposta, cod_usuario_resposta, cod_usuario_analise, data_hora_analise, descricao_analise)
VALUES
    (1, 4, 'Como posso superar meu vício em álcool?', '2023-10-11 14:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL),
    (2, 5, 'Quais são as melhores estratégias para deixar de fumar?', '2023-10-11 14:15:00', 1, NULL, NULL, NULL, NULL, NULL, NULL),
    (3, 4, 'O que devo fazer para ajudar alguém com vício em drogas?', '2023-10-11 14:30:00', 1, NULL, NULL, NULL, NULL, NULL, NULL),
    (4, 4, 'Como controlar a compulsão alimentar?', '2023-10-11 14:45:00', 1, NULL, NULL, NULL, NULL, NULL, NULL),
    (5, 11, 'Existe tratamento eficaz para o vício em jogos?', '2023-10-11 15:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL),
    (6, 11, 'Meu pai foi comprar cigarro e nunca mais voltou. Ele era um adicto? Responde logo, cacete.', '2023-10-11 15:00:00', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- Inserir registros em tb_pergunta_vicios
INSERT INTO tb_pergunta_vicios (cod_pergunta, cod_vicio)
VALUES (1,1),
       (2,2),
       (2,3),
       (4,4),
       (4,2),
       (3,3),
       (2,4),
       (5,4),
       (5,5);
	
-- Inserir registros em tb_identificacoes_relato
INSERT INTO tb_identificacoes_relato (cod_identificacao_relato, descricao_identificacao)
VALUES
	(1, 'Adicto'),
	(2, 'Ex adicto'),
	(3, 'Mãe/Pai de adicto'),
	(4, 'Filho de adicto'),
	(5, 'Outro parentesco de adicto'),
	(6, 'Amigo de adicto'),
	(7, 'Conhecido de adicto'),
	(8, 'Conjuge de Adicto'),
	(9, 'Voluntário em programas de recuperação'),
	(10, 'Interessado em ajudar pessoas com dependência');
	
 -- Inserir registros em tb_relato_status
INSERT INTO tb_relato_status (cod_status_relato, descricao_status_relato)
VALUES
	(1, 'EM ANÁLISE'),
	(2, 'REPROVADO'),
	(3, 'PUBLICADO');

 -- Inserir registros em tb_relatos
INSERT INTO tb_relatos (cod_relato, cod_usuario_relato, conteudo_relato, cod_identificacao_relato, cod_status_relato, esta_anonimo, data_hora_envio, cod_usuario_analise, data_hora_analise, descricao_analise)
VALUES
    (1, 4, 'Tive problemas com alcoolismo por muitos anos, mas agora estou sóbrio há 2 anos.', 2, 1, false, '2023-10-11 16:00:00', NULL, NULL, NULL),
    (2, 5, 'Meu irmão luta contra o vício em tabaco há anos e está tendo dificuldades para parar de fumar.', 1, 1, true, '2023-10-11 16:15:00', NULL, NULL, NULL),
    (3, 12, 'Meu melhor amigo está lutando contra o vício em jogos e isso afetou nossa amizade.', 6, 1, false, '2023-10-11 16:30:00', NULL, NULL, NULL),
    (4, 11, 'Sou o amigo daquele cara estava jogando e ele veio me atrapalhar.', 1, 1, false, '2023-10-11 16:45:00', NULL, NULL, NULL),
    (5, 4, 'Estou pesquisando sobre compulsão alimentar e gostaria de compartilhar minhas descobertas.', 1, 1, true, '2023-10-11 23:00:00', NULL, NULL, NULL),
    (6, 4, 'Fui comprar laranjas para o cheiro do cigarro não ficar na minha boca.', 1, 1, true, '2023-10-11 23:00:00', NULL, NULL, NULL),
    (7, 5, 'Estou vendendo maço de cigarro mais barato. Me chama no zap, 95263-2536.', 1, 1, true, '2023-10-13 02:00:00', NULL, NULL, NULL);
   
 -- Inserir registros em tb_relato_vicios
INSERT INTO tb_relato_vicios (cod_relato, cod_vicio)
VALUES
	(1,1),
	(2,2),
	(3,5),
	(4,5),
	(5,4);

/*-------------------------------ATUALIZAÇÕES-------------------------------------------*/

-- Aprovação para a Pergunta 1
UPDATE tb_perguntas
SET cod_usuario_analise = 10, 
	data_hora_analise = '2023-10-11 18:30:00',
	cod_status_pergunta = 3 -- Atualizando o status para "Aguandando resposta",
WHERE cod_pergunta = 1;
   
-- Resposta para a Pergunta 1
UPDATE tb_perguntas
SET conteudo_resposta = 'Superar o vício em álcool requer esforço, apoio e tratamento adequado. Você pode começar buscando ajuda de profissionais de saúde, participando de grupos de apoio e evitando ambientes que incentivem o consumo de álcool.',
    data_hora_resposta = '2023-10-12 19:35:00',
    cod_usuario_resposta = 13,
    cod_status_pergunta = 4 -- Atualizando o status para "Respondida"
WHERE cod_pergunta = 1;

-- Aprovação para a Pergunta 2
UPDATE tb_perguntas
SET cod_usuario_analise = 1, 
	data_hora_analise = '2023-10-11 15:58:00',
	cod_status_pergunta = 3 -- Atualizando o status para "Aguandando resposta",
WHERE cod_pergunta = 2;

-- Resposta para a Pergunta 2
UPDATE tb_perguntas
SET conteudo_resposta = 'Parar de fumar pode ser desafiador, mas é possível. Estratégias incluem definir uma data para parar, buscar ajuda de profissionais, usar terapias de reposição de nicotina e evitar gatilhos de fumar.',
    data_hora_resposta = '2023-10-12 19:05:00',
    cod_usuario_resposta = 13,
    cod_status_pergunta = 4 -- Atualizando o status para "Respondida"
WHERE cod_pergunta = 2;

-- Aprovação para a Pergunta 3
UPDATE tb_perguntas
SET cod_usuario_analise = 1, 
	data_hora_analise = '2023-10-11 19:58:00',
	cod_status_pergunta = 3 -- Atualizando o status para "Aguardando resposta",
WHERE cod_pergunta = 3;

-- Resposta para a Pergunta 3
UPDATE tb_perguntas
SET conteudo_resposta = 'Ajudar alguém com vício em drogas envolve apoio emocional, encorajamento para buscar tratamento, e estabelecer limites saudáveis. Você pode procurar orientação de especialistas em dependência química.',
    data_hora_resposta = '2023-10-12 15:00:00',
    cod_usuario_resposta = 6,
    cod_status_pergunta = 4 -- Atualizando o status para "Respondida"
WHERE cod_pergunta = 3;

-- Reprovação para a Pergunta 6
UPDATE tb_perguntas
SET cod_usuario_analise = 10, 
	data_hora_analise = '2023-10-12 17:30:00',
	cod_status_pergunta = 2, -- Atualizando o status para "Reprovado",
	descricao_analise = 'Pergunta sem fundamento e com linguajar inadequado.'
WHERE cod_pergunta = 6;   
   

-- Aprovação do Relato 1
UPDATE tb_relatos
SET cod_usuario_analise = 10, 
	data_hora_analise = '2023-10-11 18:30:00',
	cod_status_relato = 3 -- Atualizando o status para "PUBLICADO"
WHERE cod_relato = 1;

-- Aprovação do Relato 3
UPDATE tb_relatos
SET cod_usuario_analise = 1, 
	data_hora_analise = '2023-10-12 12:30:00',
	cod_status_relato = 3 -- Atualizando o status para "PUBLICADO"
WHERE cod_relato = 3;

-- Aprovação do Relato 5
UPDATE tb_relatos
SET cod_usuario_analise = 10, 
	data_hora_analise = '2023-10-12 7:03:00',
	cod_status_relato = 3 -- Atualizando o status para "PUBLICADO"
WHERE cod_relato = 5;

-- Reprovação do Relato 6
UPDATE tb_relatos
SET cod_usuario_analise = 1, 
	data_hora_analise = '2023-10-12 11:05:00',
	cod_status_relato = 2, -- Atualizando o status para "REPROVADO"
	descricao_analise = 'Relato que não agrega em nada a plataforma.'
WHERE cod_relato = 6;

-- Aprovação para o Relato 7
UPDATE tb_relatos
SET cod_usuario_analise = 10, 
	data_hora_analise = '2023-10-13 09:35:00',
	cod_status_relato = 2, -- Atualizando o status para "REPROVADO"
	descricao_analise = 'Tentativa de venda de mercadoria na plataforma.'
WHERE cod_relato = 7;

/*-------------------------------OUTRAS INSERÇÕES-------------------------------------------*/

-- Inserir registros em tb_pergunta_curtidas
-- Depois de ser aprovada, tem de estar em AGUARDANDO RESPOSTA ou RESPONDIDA
INSERT INTO tb_pergunta_curtidas (cod_pergunta, cod_usuario)
VALUES
	(1,11),
	(2,4),
	(3,5),
	(4,11),
	(1,5),
	(1,4),
	(4,5),
	(5,11),
	(5,5),
	(3,11);
	
-- Inserir registros em tb_pergunta_curtidas
-- Depois de ser aprovado, tem de estar em PUBLICADO
INSERT INTO tb_relato_curtidas (cod_relato, cod_usuario)
VALUES
	(3,11),
	(5,4),
	(5,5),
	(5,11),
	(1,5),
	(1,11);
    
-- POC

-- 1. Os 3 tipos de vícios mais mencionados nos relatos.

SELECT v.descricao_vicio as Vicio,
       count(*) as 'Quantidade'
FROM tb_relato_vicios rv,
     tb_vicios v
WHERE rv.cod_vicio = v.cod_vicio
GROUP BY v.descricao_vicio
ORDER BY count(*) DESC
LIMIT 3 ;

-- 2. Número de perguntas respondidas por cada usuário do tipo profissional de saúde.

SELECT u.nome_usuario as Usuario,
       count(*) as 'Quantidade'
FROM tb_perguntas p,
     tb_usuarios u
WHERE u.cod_usuario = p.cod_usuario_resposta
  AND u.cod_tipo_usuario = 3
GROUP BY u.nome_usuario
ORDER BY count(*) DESC ;

-- 3. Média da idade de pessoas que fizeram um relato sobre cada vício.

SELECT v.descricao_vicio as Vicio,
       FLOOR(AVG(YEAR(now()) - YEAR(u.data_nascimento))) as 'Media Idades'
FROM tb_relato_vicios rv,
     tb_vicios v,
     tb_relatos r,
     tb_usuarios u
WHERE rv.cod_vicio = v.cod_vicio
  AND r.cod_usuario_relato = u.cod_usuario
  AND rv.cod_relato = r.cod_relato
GROUP BY v.descricao_vicio ;

-- 4. Quantidades de relatos reprovados e aprovados pelos administradores.

SELECT u.nome_usuario as Usuario,
       SUM(CASE
               WHEN r.cod_status_relato = 3 THEN 1
               ELSE 0
           END) as 'Relatos Aprovados',
       SUM(CASE
               WHEN r.cod_status_relato = 2 THEN 1
               ELSE 0
           END) as 'Relatos Reprovados'
FROM tb_usuarios u,
     tb_relatos r
WHERE u.cod_usuario = r.cod_usuario_analise
  AND (u.cod_tipo_usuario = 1
       OR u.cod_tipo_usuario = 2)
GROUP BY u.nome_usuario ;

-- 5. Quantidade de usuário por cidade.

SELECT e.sigla as Estado,
       c.nome_cidade as Cidade,
       count(*) as 'Quantidade Usuarios'
FROM tb_estados e,
     tb_cidades c,
     tb_usuarios u
WHERE u.cod_cidade = c.cod_cidade
  AND e.cod_estado = c.cod_estado
GROUP BY c.nome_cidade,
         e.sigla ;

-- 6. Qual cidade tem mais local de atendimento cadastrados na plataforma.

SELECT e.sigla as Estado,
       c.nome_cidade as Cidade,
       count(*) as 'Quantidade Locais'
FROM tb_estados e,
     tb_cidades c,
     tb_locais_atendimentos a
WHERE c.cod_cidade = a.cod_cidade
  AND e.cod_estado = c.cod_estado
GROUP BY Estado,
         Cidade
ORDER BY count(*) DESC
LIMIT 1 ;

-- 7. Os 3 tipos de vícios mais associados a perguntas dirigidas a profissionais de saúde.
-- OBS: todas as perguntas são dirigidas a profissionais de saúde

SELECT v.descricao_vicio AS 'Vício',
       count(*) AS 'Quantidade'
FROM tb_pergunta_vicios pv,
     tb_vicios v
WHERE pv.cod_vicio = v.cod_vicio
GROUP BY v.cod_vicio
ORDER BY count(*) DESC
LIMIT 3;

-- 8 Histórico de status de relatos de um usuário específico.

SELECT u.nome_usuario as `Usuario`,
	SUM(CASE
			WHEN r.cod_status_relato = 3 THEN 1
			ELSE 0
		END) as `Aprovado`,
    SUM(CASE
			WHEN r.cod_status_relato = 2 THEN 1
			ELSE 0
		END) as `Reprovado`,
    SUM(CASE
			WHEN r.cod_status_relato = 1 THEN 1
			ELSE 0
		END) as `Em Análise`
FROM tb_usuarios u, tb_relatos r
WHERE u.cod_usuario = r.cod_usuario_relato 
	AND u.cod_usuario = 4
GROUP BY u.nome_usuario;

-- 9. Os conteúdos dos 3 relatos mais curtidos relacionados a Alcoolismo.

SELECT r.conteudo_relato
FROM tb_relatos r
INNER JOIN tb_relato_vicios rv ON rv.cod_relato = r.cod_relato
INNER JOIN tb_relato_curtidas rc ON rc.cod_relato = r.cod_relato
WHERE rv.cod_vicio = 1
GROUP BY rc.cod_relato
ORDER BY COUNT(rc.cod_relato) DESC
LIMIT 3;


-- 10. Qual o conteúdo da pergunta mais curtida do vício Alcoolismo.

SELECT p.conteudo_pegunta,
       count(pc.cod_pergunta) AS quant
FROM tb_perguntas p
INNER JOIN tb_pergunta_curtidas pc ON pc.cod_pergunta = p.cod_pergunta
INNER JOIN tb_pergunta_vicios pv ON pv.cod_pergunta = p.cod_pergunta
WHERE pv.cod_vicio = 1
GROUP BY pc.cod_pergunta
ORDER BY count(pc.cod_pergunta) DESC
LIMIT 1;


-- 11. Média mensal de 2023 da quantidade de perguntas recebidas.
-- Obs. Considerando o ano como um todo.
SELECT sum(quant) / 12 AS media
FROM
  (SELECT COUNT(*) AS quant
   FROM tb_perguntas p
   WHERE year(p.data_hora_envio) = 2023
   GROUP BY MONTH(p.data_hora_envio)) AS subquery;

-- 12. Feedback dos usuários sobre a plataforma com comentários e avaliações.
SELECT u.nome_usuario,
       a.nota,
       a.justificativa
FROM tb_avaliacoes_site a
INNER JOIN tb_usuarios u ON u.cod_usuario = a.cod_usuario;


-- 13. Duração média da aprovação/repovação de relatos pelos usuários administradores. 
-- OBS. Todas as análise são realizadas por usuários administradores
SELECT sec_to_time(avg(time_to_sec(timediff(r.data_hora_analise, r.data_hora_envio)))) as media
FROM tb_relatos r
WHERE r.data_hora_analise IS NOT NULL;


-- 14 Locais que um determinado vício é atendido.

SELECT v.descricao_vicio, la.nome_local, la.rua, la.numero_endereco, c.nome_cidade
FROM tb_vicios v, tb_locais_atendimentos la ,tb_local_vicios lv, tb_cidades c
WHERE v.cod_vicio = lv.cod_vicio
	AND la.cod_local = lv.cod_local 
    AND c.cod_cidade = la.cod_cidade
    AND v.cod_vicio = 8
ORDER BY la.nome_local;

-- 15. Tipo de identificação de usuário (familiar, adicto recuperado…) mais utilizada nos relatos.

SELECT i.descricao_identificacao,
       count(*) AS quant
FROM tb_identificacoes_relato i
INNER JOIN tb_relatos r ON r.cod_identificacao_relato = i.cod_identificacao_relato
GROUP BY r.cod_identificacao_relato
order by count(*) DESC
LIMIT 1;

-- 16 Quantidade de relatos publicados em anônimo.
-- Obs: Para um relato ser publicado o seu codigo de status tem que ser igual a 3
SELECT COUNT(r.esta_anonimo) AS `Relatos Publicados em Anonimo`
FROM tb_relatos r, tb_relato_status rs
WHERE r.cod_status_relato = rs.cod_status_relato 
	AND r.esta_anonimo = 1 
    AND r.cod_status_relato = 3;

-- 17 Quantidade de relatos publicados sem ser anônimo.
-- Obs: Para um relato ser publicado o seu codigo de status tem que ser igual a 3
SELECT COUNT(r.esta_anonimo) AS `Relatos Publicados Sem Ser Anonimo`
FROM tb_relatos r, tb_relato_status rs
WHERE r.cod_status_relato = rs.cod_status_relato 
	AND r.esta_anonimo = 0 
    AND r.cod_status_relato = 3;
    
-- 18. Mês de 2023 com a maior quantidade de perguntas respondidas pelos profissionais de saúdes.
-- OBS. Todas as respostas são realizadas por profissionais de saúde
SELECT month(p.data_hora_resposta) AS 'mês',
       count(*) AS quantidade
FROM tb_perguntas p
WHERE p.data_hora_resposta IS NOT NULL
  AND year(p.data_hora_resposta) = 2023
GROUP BY month(p.data_hora_resposta) 
ORDER BY count(*) DESC
LIMIT 1;
    
-- 19 Quantidades de relatos publicados com identificação de AMIGO DE ADICTO no mês Outubro de 2023. 
SELECT ir.descricao_identificacao as `Identificação`, COUNT(*) AS `Quantidade`
FROM tb_identificacoes_relato ir, tb_relatos r
WHERE ir.cod_identificacao_relato = r.cod_identificacao_relato 
	AND ir.cod_identificacao_relato = 6 
	AND MONTH(r.data_hora_envio) = 10
    AND YEAR(r.data_hora_envio) = 2023
GROUP BY ir.cod_identificacao_relato;

-- 20. Média de tempo que as perguntas são respondidas por profissionais de saúde após a aprovação.
-- OBS. Todas as respostas são realizadas por profissionais de saúde
SELECT sec_to_time(avg(time_to_sec(timediff(p.data_hora_resposta, p.data_hora_analise)))) AS media
FROM tb_perguntas p
WHERE p.data_hora_resposta IS NOT NULL;


-- 21 Quantidade de profissionais de saúde de cada especialidade.

SELECT e.descricao_especialidade as `Especialidade`, COUNT(*) as `Quantidade`
FROM tb_especialidades e, tb_usuarios u, tb_usuario_especialidades ue
WHERE e.cod_especialidade = ue.cod_especialidade 
	AND u.cod_usuario = ue.cod_usuario
GROUP BY e.cod_especialidade;
    
-- 22 Usuários do tipo profissionais de saúde que não responderam nenhuma pergunta.

SELECT u.nome_usuario
FROM tb_usuarios u, tb_tipos_usuario tu
WHERE u.cod_tipo_usuario = tu.cod_tipo_usuario 
	AND u.cod_tipo_usuario = 3
    AND u.cod_usuario NOT IN (
		SELECT p.cod_usuario_resposta
		FROM tb_perguntas p
		WHERE p.cod_usuario_resposta IS NOT NULL
	);
    
-- 23. Especialidade de profissionais de saúde que teve mais perguntas respondidas.
SELECT e.descricao_especialidade as 'Especialidade',
       count(*) AS 'Quantidade'
FROM tb_perguntas p
INNER JOIN tb_usuario_especialidades ue ON ue.cod_usuario = p.cod_usuario_resposta
INNER JOIN tb_especialidades e ON e.cod_especialidade = ue.cod_especialidade
WHERE p.data_hora_resposta IS NOT NULL
GROUP BY ue.cod_especialidade
order by count(*) DESC
LIMIT 1;