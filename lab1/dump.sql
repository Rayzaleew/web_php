--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2 (Debian 15.2-1.pgdg110+1)
-- Dumped by pg_dump version 15.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
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
-- Name: computers; Type: TABLE; Schema: public; Owner: user105
--

CREATE TABLE public.computers (
    id integer NOT NULL,
    name text,
    ram integer,
    cpu_cores integer
);


ALTER TABLE public.computers OWNER TO user105;

--
-- Name: computers_id_seq; Type: SEQUENCE; Schema: public; Owner: user105
--

CREATE SEQUENCE public.computers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.computers_id_seq OWNER TO user105;

--
-- Name: computers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user105
--

ALTER SEQUENCE public.computers_id_seq OWNED BY public.computers.id;


--
-- Name: department; Type: TABLE; Schema: public; Owner: user105
--

CREATE TABLE public.department (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.department OWNER TO user105;

--
-- Name: department_id_seq; Type: SEQUENCE; Schema: public; Owner: user105
--

CREATE SEQUENCE public.department_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.department_id_seq OWNER TO user105;

--
-- Name: department_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user105
--

ALTER SEQUENCE public.department_id_seq OWNED BY public.department.id;


--
-- Name: room; Type: TABLE; Schema: public; Owner: user105
--

CREATE TABLE public.room (
    id integer NOT NULL,
    department_id integer
);


ALTER TABLE public.room OWNER TO user105;

--
-- Name: staff; Type: TABLE; Schema: public; Owner: user105
--

CREATE TABLE public.staff (
    id integer NOT NULL,
    last_name text,
    room_id integer,
    computer_id integer,
    username text NOT NULL,
    password text NOT NULL
);


ALTER TABLE public.staff OWNER TO user105;

--
-- Name: staff_id_seq; Type: SEQUENCE; Schema: public; Owner: user105
--

CREATE SEQUENCE public.staff_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.staff_id_seq OWNER TO user105;

--
-- Name: staff_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user105
--

ALTER SEQUENCE public.staff_id_seq OWNED BY public.staff.id;


--
-- Name: computers id; Type: DEFAULT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.computers ALTER COLUMN id SET DEFAULT nextval('public.computers_id_seq'::regclass);


--
-- Name: department id; Type: DEFAULT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.department ALTER COLUMN id SET DEFAULT nextval('public.department_id_seq'::regclass);


--
-- Name: staff id; Type: DEFAULT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.staff ALTER COLUMN id SET DEFAULT nextval('public.staff_id_seq'::regclass);


--
-- Data for Name: computers; Type: TABLE DATA; Schema: public; Owner: user105
--

COPY public.computers (id, name, ram, cpu_cores) FROM stdin;
1	iMac 2011	8	4
2	Macbook Pro 13	8	8
3	Macbook Pro 15	16	8
4	Macbook Pro 17	16	8
5	Macbook Air 13	8	4
6	Macbook Air 11	4	2
7	Macbook Pro 13	8	8
8	Macbook Pro 15	16	8
9	Macbook Pro 17	16	8
10	Macbook Air 13	8	4
11	Macbook Air 11	4	2
12	Macbook Pro 13	8	8
13	Macbook Pro 15	16	8
14	Macbook Pro 17	16	8
15	Macbook Air 13	8	4
16	Macbook Air 11	4	2
17	Acer Aspire 5	16	8
18	ASUS VivoBook 15	8	4
19	MSI Prestige 14	32	12
20	Lenovo IdeaPad 3	8	4
21	HP Pavilion 15	16	8
22	Dell Inspiron 15	8	4
23	Acer Aspire 5	16	8
24	ASUS VivoBook 15	8	4
25	MSI Prestige 14	32	12
26	Lenovo IdeaPad 3	8	4
27	HP Pavilion 15	16	8
28	Dell Inspiron 15	8	4
29	Acer Aspire 5	16	8
30	ASUS VivoBook 15	8	4
31	MSI Prestige 14	32	12
\.


--
-- Data for Name: department; Type: TABLE DATA; Schema: public; Owner: user105
--

COPY public.department (id, name) FROM stdin;
1	IT
2	HR
3	Sales
4	Marketing
\.


--
-- Data for Name: room; Type: TABLE DATA; Schema: public; Owner: user105
--

COPY public.room (id, department_id) FROM stdin;
1	1
2	1
3	2
4	2
5	3
6	3
7	4
8	4
\.


--
-- Data for Name: staff; Type: TABLE DATA; Schema: public; Owner: user105
--

COPY public.staff (id, last_name, room_id, computer_id, username, password) FROM stdin;
36	Федоров	4	12	fedorov	12345fedorov
34	Михайлов	4	10	mikhailov	12345mikhailov
30	Попов	2	6	popov	12345popov
31	Васильев	3	7	vasiliev	12345vasiliev
25	Иванов	1	1	ivanov	12345ivanov
38	Волков	5	14	volkov	12345volkov
39	Алексеев	5	15	alekseev	12345alekseev
27	Сидоров	1	3	sidorov	12345sidorov
29	Кузнецов	2	5	kuznetsov	12345kuznetsov
40	Лебедев	6	16	lebedev	12345lebedev
33	Соколов	3	9	sokolov	12345sokolov
32	Павлов	3	8	pavlov	12345pavlov
26	Петров	5	20	petrov	12345petrov
37	Морозов	5	13	morozov	12345morozov
\.


--
-- Name: computers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user105
--

SELECT pg_catalog.setval('public.computers_id_seq', 31, true);


--
-- Name: department_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user105
--

SELECT pg_catalog.setval('public.department_id_seq', 4, true);


--
-- Name: staff_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user105
--

SELECT pg_catalog.setval('public.staff_id_seq', 42, true);


--
-- Name: computers computers_pkey; Type: CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.computers
    ADD CONSTRAINT computers_pkey PRIMARY KEY (id);


--
-- Name: department department_pkey; Type: CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.department
    ADD CONSTRAINT department_pkey PRIMARY KEY (id);


--
-- Name: room room_pkey; Type: CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.room
    ADD CONSTRAINT room_pkey PRIMARY KEY (id);


--
-- Name: staff staff_pkey; Type: CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_pkey PRIMARY KEY (id);


--
-- Name: staff staff_username_key; Type: CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_username_key UNIQUE (username);


--
-- Name: room room_department_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.room
    ADD CONSTRAINT room_department_id_fkey FOREIGN KEY (department_id) REFERENCES public.department(id);


--
-- Name: staff staff_computer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_computer_id_fkey FOREIGN KEY (computer_id) REFERENCES public.computers(id);


--
-- Name: staff staff_room_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user105
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_room_id_fkey FOREIGN KEY (room_id) REFERENCES public.room(id);


--
-- PostgreSQL database dump complete
--

