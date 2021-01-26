PGDMP                          y            Pizza    9.6.20    9.6.20 ;    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �           1262    16450    Pizza    DATABASE     �   CREATE DATABASE "Pizza" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE "Pizza";
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    3                        3079    12387    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1            �            1255    16536 !   add_ingredient(character varying)    FUNCTION     �   CREATE FUNCTION public.add_ingredient(name character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 

INSERT INTO ingredient(name) VALUES (name);

return 'Ingredient added successfully!';

END;
$$;
 =   DROP FUNCTION public.add_ingredient(name character varying);
       public       postgres    false    3    1            �            1255    16537 q   add_ingredient_detail(integer, character varying, double precision, double precision, character varying, boolean)    FUNCTION     �  CREATE FUNCTION public.add_ingredient_detail(ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."ingredient_detail"(
	 ing_id, province, price, quantity, supplier, is_hidden)
	VALUES ( ing_id, province, price, quantity, supplier, is_hidden);
	return 'Added Successfully';
END;
$$;
 �   DROP FUNCTION public.add_ingredient_detail(ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean);
       public       postgres    false    1    3            �            1255    16538 $   add_pizza(integer, double precision)    FUNCTION     �   CREATE FUNCTION public.add_pizza(size integer, price double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."pizza"(
	 size, price)
	VALUES (size, price);
return 'New pizza added successfully!';	
	
END;
$$;
 F   DROP FUNCTION public.add_pizza(size integer, price double precision);
       public       postgres    false    1    3            �            1255    16539 ;   add_supplier(character varying, character varying, boolean)    FUNCTION     H  CREATE FUNCTION public.add_supplier(name character varying, ingredients character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."supplier"(
	 name, ingredients, is_hidden)
	VALUES (name,ingredients, is_hidden);
return 'New supplier added successfully!';
END;
$$;
 m   DROP FUNCTION public.add_supplier(name character varying, ingredients character varying, is_hidden boolean);
       public       postgres    false    3    1            �            1255    16540    delete_ingredient(integer)    FUNCTION     �   CREATE FUNCTION public.delete_ingredient(ing_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN
  DELETE
  FROM
  ingredient
  WHERE ingredient.id = ing_id;
  RETURN 'Ingredient removed successfully!';
END;
$$;
 8   DROP FUNCTION public.delete_ingredient(ing_id integer);
       public       postgres    false    1    3            �            1255    16541 !   delete_ingredient_detail(integer)    FUNCTION     �   CREATE FUNCTION public.delete_ingredient_detail(id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
DELETE FROM public.ingredient_detail
	WHERE ingredient_detail.id = id;
	return 'deleted successfully';
END;
$$;
 ;   DROP FUNCTION public.delete_ingredient_detail(id integer);
       public       postgres    false    1    3            �            1255    16542    delete_supplier(integer)    FUNCTION     �   CREATE FUNCTION public.delete_supplier(sid integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN
  DELETE
  FROM
  supplier
  WHERE supplier.id = sid;
  RETURN 'Supplier removed successfully!';
END;
$$;
 3   DROP FUNCTION public.delete_supplier(sid integer);
       public       postgres    false    3    1            �            1255    16543    fetch_all_ingredient()    FUNCTION     �   CREATE FUNCTION public.fetch_all_ingredient() RETURNS TABLE(id integer, name character varying)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient order by ingredient.id asc;
end;
$$;
 -   DROP FUNCTION public.fetch_all_ingredient();
       public       postgres    false    3    1            �            1255    16544    fetch_all_ingredient_detail()    FUNCTION     [  CREATE FUNCTION public.fetch_all_ingredient_detail() RETURNS TABLE(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient_detail order by ingredient_detail.id;
end;
$$;
 4   DROP FUNCTION public.fetch_all_ingredient_detail();
       public       postgres    false    3    1            �            1255    16545    fetch_all_pizza()    FUNCTION     �   CREATE FUNCTION public.fetch_all_pizza() RETURNS TABLE(id integer, size integer, price double precision)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from pizza;
end;
$$;
 (   DROP FUNCTION public.fetch_all_pizza();
       public       postgres    false    1    3            �            1255    16546    fetch_all_supplier()    FUNCTION     �   CREATE FUNCTION public.fetch_all_supplier() RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier order by supplier.id;
end;
$$;
 +   DROP FUNCTION public.fetch_all_supplier();
       public       postgres    false    3    1            �            1255    16547 #   fetch_available_ingredient_detail()    FUNCTION     �  CREATE FUNCTION public.fetch_available_ingredient_detail() RETURNS TABLE(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN 
return query 
		select * from ingredient_detail where ingredient_detail.quantity > 0 AND ingredient_detail.is_hidden = false;
END;
$$;
 :   DROP FUNCTION public.fetch_available_ingredient_detail();
       public       postgres    false    3    1            �            1255    16548    fetch_available_supplier()    FUNCTION       CREATE FUNCTION public.fetch_available_supplier() RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier where supplier.is_hidden = false;
end;
$$;
 1   DROP FUNCTION public.fetch_available_supplier();
       public       postgres    false    1    3            �            1255    16549    fetch_ingredient(integer)    FUNCTION     �   CREATE FUNCTION public.fetch_ingredient(ing_id integer) RETURNS TABLE(id integer, name character varying)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient where ingredient.id = ing_id;
end;
$$;
 7   DROP FUNCTION public.fetch_ingredient(ing_id integer);
       public       postgres    false    3    1            �            1255    16550     fetch_ingredient_detail(integer)    FUNCTION     q  CREATE FUNCTION public.fetch_ingredient_detail(ingd_id integer) RETURNS TABLE(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN 
return query 
		select * from ingredient_detail where ingredient_detail.ing_id = ingd_id;
END;
$$;
 ?   DROP FUNCTION public.fetch_ingredient_detail(ingd_id integer);
       public       postgres    false    3    1            �            1255    16551    fetch_supplier(integer)    FUNCTION       CREATE FUNCTION public.fetch_supplier(sid integer) RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier where supplier.id = sid;
end;
$$;
 2   DROP FUNCTION public.fetch_supplier(sid integer);
       public       postgres    false    1    3            �            1255    16552 /   fetch_supplier_by_ingredient(character varying)    FUNCTION     P  CREATE FUNCTION public.fetch_supplier_by_ingredient(ingredient character varying) RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		SELECT * FROM supplier WHERE UPPER(supplier.ingredients) LIKE UPPER('%'||ingredient||'%');
end;
$$;
 Q   DROP FUNCTION public.fetch_supplier_by_ingredient(ingredient character varying);
       public       postgres    false    1    3            �            1255    16553 -   update_ingredient(integer, character varying)    FUNCTION       CREATE FUNCTION public.update_ingredient(ing_id integer, ing_name character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE ingredient
  SET name = ing_name
  WHERE ingredient.id = ing_id;
  RETURN 'Ingredient updated successfully!';
END;
$$;
 T   DROP FUNCTION public.update_ingredient(ing_id integer, ing_name character varying);
       public       postgres    false    3    1            �            1255    16554 }   update_ingredient_detail(integer, integer, character varying, double precision, double precision, character varying, boolean)    FUNCTION     T  CREATE FUNCTION public.update_ingredient_detail(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
UPDATE public.ingredient_detail
	SET ingredient_detail.ing_id=ing_id , ingredient_detail.province=province, 
	ingredient_detail.price=price, ingredient_detail.quantity=quantity, 
	ingredient_detail.supplier=supplier, ingredient_detail.is_hidden=is_hidden
	WHERE ingredient_detail.id = id;
	return 'updated successfully';
END;
$$;
 �   DROP FUNCTION public.update_ingredient_detail(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean);
       public       postgres    false    1    3            �            1255    16555 G   update_supplier(integer, character varying, character varying, boolean)    FUNCTION       CREATE FUNCTION public.update_supplier(sup_id integer, sup_name character varying, sup_ingredients character varying, sup_ishidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE supplier
  SET name = sup_name, ingredients = sup_ingredients, is_hidden = sup_ishidden
  WHERE supplier.id = sup_id;
  RETURN 'Supplier updated successfully!';
END;
$$;
 �   DROP FUNCTION public.update_supplier(sup_id integer, sup_name character varying, sup_ingredients character varying, sup_ishidden boolean);
       public       postgres    false    3    1            �            1259    16556 
   ingredient    TABLE     a   CREATE TABLE public.ingredient (
    id integer NOT NULL,
    name character varying NOT NULL
);
    DROP TABLE public.ingredient;
       public         postgres    false    3            �            1259    16562    ingredient_detail    TABLE       CREATE TABLE public.ingredient_detail (
    id integer NOT NULL,
    ing_id integer NOT NULL,
    province character varying NOT NULL,
    price double precision NOT NULL,
    quantity double precision NOT NULL,
    supplier character varying NOT NULL,
    is_hidden boolean NOT NULL
);
 %   DROP TABLE public.ingredient_detail;
       public         postgres    false    3            �            1259    16568    ingredient_detail_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ingredient_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.ingredient_detail_id_seq;
       public       postgres    false    186    3            �           0    0    ingredient_detail_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.ingredient_detail_id_seq OWNED BY public.ingredient_detail.id;
            public       postgres    false    187            �            1259    16570    ingredient_id_seq    SEQUENCE     z   CREATE SEQUENCE public.ingredient_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.ingredient_id_seq;
       public       postgres    false    185    3            �           0    0    ingredient_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.ingredient_id_seq OWNED BY public.ingredient.id;
            public       postgres    false    188            �            1259    16572    order     TABLE        CREATE TABLE public."order " (
    id integer NOT NULL,
    pizza_size integer NOT NULL,
    ing_id character varying NOT NULL,
    quantity integer NOT NULL,
    pizza_price double precision NOT NULL,
    ing_price double precision NOT NULL,
    total_price double precision NOT NULL
);
    DROP TABLE public."order ";
       public         postgres    false    3            �            1259    16578    pizza    TABLE     w   CREATE TABLE public.pizza (
    id integer NOT NULL,
    size integer NOT NULL,
    price double precision NOT NULL
);
    DROP TABLE public.pizza;
       public         postgres    false    3            �            1259    16581    pizza_id_seq    SEQUENCE     u   CREATE SEQUENCE public.pizza_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.pizza_id_seq;
       public       postgres    false    3    190            �           0    0    pizza_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.pizza_id_seq OWNED BY public.pizza.id;
            public       postgres    false    191            �            1259    16583    supplier    TABLE     �   CREATE TABLE public.supplier (
    id integer NOT NULL,
    name character varying NOT NULL,
    ingredients character varying NOT NULL,
    is_hidden boolean NOT NULL
);
    DROP TABLE public.supplier;
       public         postgres    false    3            �            1259    16589    supplier_id_seq    SEQUENCE     x   CREATE SEQUENCE public.supplier_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.supplier_id_seq;
       public       postgres    false    192    3            �           0    0    supplier_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.supplier_id_seq OWNED BY public.supplier.id;
            public       postgres    false    193            �           2604    16591    ingredient id    DEFAULT     n   ALTER TABLE ONLY public.ingredient ALTER COLUMN id SET DEFAULT nextval('public.ingredient_id_seq'::regclass);
 <   ALTER TABLE public.ingredient ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    188    185                        2604    16592    ingredient_detail id    DEFAULT     |   ALTER TABLE ONLY public.ingredient_detail ALTER COLUMN id SET DEFAULT nextval('public.ingredient_detail_id_seq'::regclass);
 C   ALTER TABLE public.ingredient_detail ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    187    186                       2604    16593    pizza id    DEFAULT     d   ALTER TABLE ONLY public.pizza ALTER COLUMN id SET DEFAULT nextval('public.pizza_id_seq'::regclass);
 7   ALTER TABLE public.pizza ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    191    190                       2604    16594    supplier id    DEFAULT     j   ALTER TABLE ONLY public.supplier ALTER COLUMN id SET DEFAULT nextval('public.supplier_id_seq'::regclass);
 :   ALTER TABLE public.supplier ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    193    192            �          0    16556 
   ingredient 
   TABLE DATA               .   COPY public.ingredient (id, name) FROM stdin;
    public       postgres    false    185   S       �          0    16562    ingredient_detail 
   TABLE DATA               g   COPY public.ingredient_detail (id, ing_id, province, price, quantity, supplier, is_hidden) FROM stdin;
    public       postgres    false    186   HS       �           0    0    ingredient_detail_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.ingredient_detail_id_seq', 1, true);
            public       postgres    false    187            �           0    0    ingredient_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.ingredient_id_seq', 4, true);
            public       postgres    false    188            �          0    16572    order  
   TABLE DATA               i   COPY public."order " (id, pizza_size, ing_id, quantity, pizza_price, ing_price, total_price) FROM stdin;
    public       postgres    false    189   vS       �          0    16578    pizza 
   TABLE DATA               0   COPY public.pizza (id, size, price) FROM stdin;
    public       postgres    false    190   �S       �           0    0    pizza_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.pizza_id_seq', 12, true);
            public       postgres    false    191            �          0    16583    supplier 
   TABLE DATA               D   COPY public.supplier (id, name, ingredients, is_hidden) FROM stdin;
    public       postgres    false    192   �S       �           0    0    supplier_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.supplier_id_seq', 22, true);
            public       postgres    false    193                       2606    16596 !   ingredient_detail ingredient_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.ingredient_detail
    ADD CONSTRAINT ingredient_pkey PRIMARY KEY (id);
 K   ALTER TABLE ONLY public.ingredient_detail DROP CONSTRAINT ingredient_pkey;
       public         postgres    false    186    186                       2606    16598    ingredient ingredient_pkey1 
   CONSTRAINT     Y   ALTER TABLE ONLY public.ingredient
    ADD CONSTRAINT ingredient_pkey1 PRIMARY KEY (id);
 E   ALTER TABLE ONLY public.ingredient DROP CONSTRAINT ingredient_pkey1;
       public         postgres    false    185    185                       2606    16600    order  order _pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public."order "
    ADD CONSTRAINT "order _pkey" PRIMARY KEY (id);
 @   ALTER TABLE ONLY public."order " DROP CONSTRAINT "order _pkey";
       public         postgres    false    189    189            
           2606    16602    pizza pizza_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.pizza
    ADD CONSTRAINT pizza_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.pizza DROP CONSTRAINT pizza_pkey;
       public         postgres    false    190    190                       2606    16604    supplier supplier_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.supplier
    ADD CONSTRAINT supplier_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.supplier DROP CONSTRAINT supplier_pkey;
       public         postgres    false    192    192            �   %   x�3�t�HM-N�222��S�9�RSӸb���� ���      �      x�3�4�tr��~�%%��i\1z\\\ 8��      �      x������ � �      �   9   x�U��  ��d��=����DtD��$�eӿ%��y�����p5M=F���
�      �   &   x�32��K-)��t�HM-N�Q������L����� �a=     