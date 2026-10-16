--
-- PostgreSQL database dump
--

\restrict V2pAOpFgB7LCEHB093nEJBYyppyb8Mf9g2tTdW2OqU48NkxS9NfmZUXNVad4bzd

-- Dumped from database version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: carrinho; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrinho (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    produto_id integer NOT NULL,
    quantidade integer NOT NULL
);


ALTER TABLE public.carrinho OWNER TO postgres;

--
-- Name: carrinho_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrinho_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.carrinho_id_seq OWNER TO postgres;

--
-- Name: carrinho_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrinho_id_seq OWNED BY public.carrinho.id;


--
-- Name: itens_pedido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.itens_pedido (
    id integer NOT NULL,
    pedido_id integer NOT NULL,
    produto_id integer NOT NULL,
    quantidade integer NOT NULL,
    preco numeric(10,2) NOT NULL
);


ALTER TABLE public.itens_pedido OWNER TO postgres;

--
-- Name: itens_pedido_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.itens_pedido_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.itens_pedido_id_seq OWNER TO postgres;

--
-- Name: itens_pedido_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.itens_pedido_id_seq OWNED BY public.itens_pedido.id;


--
-- Name: pedidos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedidos (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    total numeric(10,2) NOT NULL
);


ALTER TABLE public.pedidos OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedidos_id_seq OWNER TO postgres;

--
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- Name: produtos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produtos (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    preco numeric(10,2) NOT NULL,
    imagem character varying(255)
);


ALTER TABLE public.produtos OWNER TO postgres;

--
-- Name: produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produtos_id_seq OWNER TO postgres;

--
-- Name: produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produtos_id_seq OWNED BY public.produtos.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL,
    tipo character varying(20)
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: carrinho id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho ALTER COLUMN id SET DEFAULT nextval('public.carrinho_id_seq'::regclass);


--
-- Name: itens_pedido id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_pedido ALTER COLUMN id SET DEFAULT nextval('public.itens_pedido_id_seq'::regclass);


--
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- Name: produtos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos ALTER COLUMN id SET DEFAULT nextval('public.produtos_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Data for Name: carrinho; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carrinho (id, usuario_id, produto_id, quantidade) FROM stdin;
17	10	1	1
19	10	4	1
\.


--
-- Data for Name: itens_pedido; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.itens_pedido (id, pedido_id, produto_id, quantidade, preco) FROM stdin;
1	1	4	1	22.90
2	1	5	1	10.00
3	2	4	1	22.90
4	3	11	1	14.00
5	4	5	1	10.00
6	4	5	1	10.00
7	5	4	1	22.90
8	6	6	1	8.90
9	6	7	1	9.50
\.


--
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedidos (id, usuario_id, total) FROM stdin;
1	6	32.90
2	6	22.90
3	6	14.00
4	6	20.00
5	6	22.90
6	24	18.40
\.


--
-- Data for Name: produtos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produtos (id, nome, preco, imagem) FROM stdin;
4	Torta de Morango	22.90	tortademorango.jpg
5	Brownie	10.00	brownie.jpg
6	Cupcake	8.90	cupcake.jpg
1	Cheesecake	17.90	cheesecake.jpg
7	macarons	9.50	macarons1.jpg
8	Cookie	7.00	cookie.jpg
10	Pavê de pote	10.00	pave.jpg
11	Bolo de morango	14.00	bolodemorango.jpg
13	Morango cravejado	13.00	morangocravejado.webp
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, nome, email, senha, tipo) FROM stdin;
6	cliente	cliente@gmail.com	$2y$12$ZRwTjzvKa2o5i.GOC/JvAeRh3AOISkjebQG1XM8CgeUJJNt3zpLPO	cliente
7	admin	admin@gmail.com	$2y$12$hkvYZapYZRmAqd8NoU41.O5t1mx1obdhoe9WBeDva6FQFTOyoSBQu	admin
8	Jorge	jorge@jorge.com	$2y$12$tIRd3jnjc5JW8egSdlIGletqbdjRCv7wJcsnEIJI7HGTjtv9MYKNe	cliente
9	Letícia Ribeiro da Silva	byleticia1@gmail.com	$2y$12$lGktwpLiTqwVI01gvxi8J.H0Lh.H43wqBV7zjbbncDohaTFwBUl7a	cliente
10	Beatriz Neves Bergamin	beatrizbergamin@gmail.com	$2y$12$KWjCIbbN6BkQm32uyZA88ePKP3OyxJfZJMguOhC7Lickk99XK1fiO	cliente
12	jorge	jorge@jorge.com.br	$2y$12$sRLpZlQx5nFt5x6ERWS3A.OgnWmZ9HJ5ye0bE2lmvo26vYpDLMDNK	cliente
13	Livia Simões	livia.simoes@edu.senai.br	$2y$12$zmx03fszV7WvSFMq8xERau0haetW8TGEZjTVyJuVvV7nt.h37OP5q	cliente
15	mirella	mirella@gmail.com	$2y$12$klDIZ.OnxBW7w7bitOwni.W9IjCaY4QPUdleS.tzcohMXl6hm3Xgu	cliente
16	davi uchiha	davi@fiot.com	$2y$12$EcmGkQStCjM6ntQmu6ibteCTIPPgL4js.v0oIGMKVVXrp5kqkTlhu	cliente
17	cliente	bla@gmail.com	$2y$12$dcdj7l5wktv5Vbe3WAP.PuGB5Vg.yLb0e7Y9Du5U1XCuRMZg4PlmK	cliente
18	Luna	luna@gmail.com	$2y$12$mbi8.Ro00nbQ3RNt5vkVGuFbqrvOqHBbrFMgWxxqM/1jvZxKWLcLi	cliente
19	Sophia	cancianifsophia@gmail.com	$2y$12$HlkUKFc499k20aNwBEbCEOHUkHXMnima5/ZdIYSxtSZZfgcFDUbyC	cliente
20	tiago	tiagogomescruz180@gmail.com	$2y$12$bsV5qPp8RAo9c3fmDJ7EU.xIZ2jfdFWjHWkjFdZgETHPHE9868u72	cliente
21	mirela lisboa	lisboamirela035@gmail.com	$2y$12$fs9Y860vASdPzUIaOGPebeKajO5NYm1KT1jKe/Jnp6RJPzNGsPA2.	cliente
22	Vitória	vitoria@gmail.com	$2y$12$KyThMdk8Zhw0lTjj6lma7.hwOmyoL12QncZmJXPThdTUpfU68vepi	cliente
23	tiago	tiagogomes@gmail.com	$2y$12$cg9lsBV82I40hwCBF0ITnuwj7xkIXBoSpZGdez5kKX8NSYmP87Qp6	cliente
24	Suzana Hellen Ribeiro	suzaninha@gmail.com	$2y$12$CPq4cYjPrk2ehJopra9PROwppTVsli2M0mynhzW2g1B4OS.IBeOvG	cliente
\.


--
-- Name: carrinho_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.carrinho_id_seq', 46, true);


--
-- Name: itens_pedido_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.itens_pedido_id_seq', 9, true);


--
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 6, true);


--
-- Name: produtos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produtos_id_seq', 13, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 24, true);


--
-- Name: carrinho carrinho_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT carrinho_pkey PRIMARY KEY (id);


--
-- Name: itens_pedido itens_pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_pedido
    ADD CONSTRAINT itens_pedido_pkey PRIMARY KEY (id);


--
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- Name: produtos produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: carrinho fk_carrinho_produto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT fk_carrinho_produto FOREIGN KEY (produto_id) REFERENCES public.produtos(id);


--
-- Name: carrinho fk_carrinho_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT fk_carrinho_usuario FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);


--
-- PostgreSQL database dump complete
--

\unrestrict V2pAOpFgB7LCEHB093nEJBYyppyb8Mf9g2tTdW2OqU48NkxS9NfmZUXNVad4bzd

