PGDMP                         y            pizza    9.6.20    9.6.20 E    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �           1262    16393    pizza    DATABASE     �   CREATE DATABASE pizza WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_Germany.1252' LC_CTYPE = 'English_Germany.1252';
    DROP DATABASE pizza;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    3                        3079    12387    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1            �            1255    16718 *   add_ingredient(character varying, boolean)    FUNCTION       CREATE FUNCTION public.add_ingredient(name character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 

INSERT INTO ingredient(name, is_hidden) VALUES (name, is_hidden);

return 'Ingredient added successfully!';

END;
$$;
 P   DROP FUNCTION public.add_ingredient(name character varying, is_hidden boolean);
       public       postgres    false    1    3            �            1255    16687 q   add_ingredient_detail(integer, character varying, double precision, double precision, character varying, boolean)    FUNCTION     �  CREATE FUNCTION public.add_ingredient_detail(ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean) RETURNS character varying
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
       public       postgres    false    1    3            �            1255    16749 [   add_order(integer, character varying, double precision, double precision, double precision)    FUNCTION     �  CREATE FUNCTION public.add_order(pizza_size integer, ingredients character varying, pizza_price double precision, ing_price double precision, total_price double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."order"(
	 pizza_size, ingredients, pizza_price, ing_price, total_price)
	VALUES (pizza_size, ingredients, pizza_price, ing_price, total_price);
return 'Ordered successfully!';	
	
END;
$$;
 �   DROP FUNCTION public.add_order(pizza_size integer, ingredients character varying, pizza_price double precision, ing_price double precision, total_price double precision);
       public       postgres    false    3    1            �            1255    16615 $   add_pizza(integer, double precision)    FUNCTION     �   CREATE FUNCTION public.add_pizza(size integer, price double precision) RETURNS character varying
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
       public       postgres    false    3    1            �            1255    16672 ;   add_supplier(character varying, character varying, boolean)    FUNCTION     H  CREATE FUNCTION public.add_supplier(name character varying, ingredients character varying, is_hidden boolean) RETURNS character varying
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
       public       postgres    false    1    3            �            1255    16697 $   delete_ing_detail_by_ing_id(integer)    FUNCTION     	  CREATE FUNCTION public.delete_ing_detail_by_ing_id(ingredient_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
DELETE FROM public.ingredient_detail
	WHERE ingredient_detail.ing_id = ingredient_id;
	return 'deleted successfully';
END;
$$;
 I   DROP FUNCTION public.delete_ing_detail_by_ing_id(ingredient_id integer);
       public       postgres    false    1    3            �            1255    16560    delete_ingredient(integer)    FUNCTION     �   CREATE FUNCTION public.delete_ingredient(ing_id integer) RETURNS character varying
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
       public       postgres    false    3    1            �            1255    16701 !   delete_ingredient_detail(integer)    FUNCTION       CREATE FUNCTION public.delete_ingredient_detail(ing_detail_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
DELETE FROM public.ingredient_detail
	WHERE ingredient_detail.id = ing_detail_id;
	return 'deleted successfully';
END;
$$;
 F   DROP FUNCTION public.delete_ingredient_detail(ing_detail_id integer);
       public       postgres    false    1    3            �            1255    16561    delete_supplier(integer)    FUNCTION     �   CREATE FUNCTION public.delete_supplier(sid integer) RETURNS character varying
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
       public       postgres    false    3    1            �            1255    16719    fetch_all_ingredient()    FUNCTION     �   CREATE FUNCTION public.fetch_all_ingredient() RETURNS TABLE(id integer, name character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient order by ingredient.id asc;
end;
$$;
 -   DROP FUNCTION public.fetch_all_ingredient();
       public       postgres    false    3    1            �            1255    16724    fetch_all_ingredient_detail()    FUNCTION     ^  CREATE FUNCTION public.fetch_all_ingredient_detail() RETURNS TABLE(id integer, ing_detail_id integer, name character varying, province character varying, price double precision)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		SELECT  ingredient.id ,  ingredient_detail.id as ing_detail_id, ingredient.name,   ingredient_detail.province,  ingredient_detail.price  FROM  ingredient_detail INNER JOIN ingredient  
on ingredient_detail.ing_id=ingredient.id where ingredient.is_hidden = false and ingredient_detail.is_hidden = false
and ingredient_detail.quantity > 0 order by ingredient.id asc;
end;
$$;
 4   DROP FUNCTION public.fetch_all_ingredient_detail();
       public       postgres    false    3    1            �            1255    16751    fetch_all_order()    FUNCTION     $  CREATE FUNCTION public.fetch_all_order() RETURNS TABLE(id integer, pizza_size integer, ingredients character varying, pizza_price double precision, ing_price double precision, total_price double precision)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from "order";
end;
$$;
 (   DROP FUNCTION public.fetch_all_order();
       public       postgres    false    3    1            �            1255    16617    fetch_all_pizza()    FUNCTION     �   CREATE FUNCTION public.fetch_all_pizza() RETURNS TABLE(id integer, size integer, price double precision)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from pizza;
end;
$$;
 (   DROP FUNCTION public.fetch_all_pizza();
       public       postgres    false    1    3            �            1255    16673    fetch_all_supplier()    FUNCTION     �   CREATE FUNCTION public.fetch_all_supplier() RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier order by supplier.id;
end;
$$;
 +   DROP FUNCTION public.fetch_all_supplier();
       public       postgres    false    1    3            �            1255    16722    fetch_available_ingredient()    FUNCTION       CREATE FUNCTION public.fetch_available_ingredient() RETURNS TABLE(id integer, name character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient where ingredient.is_hidden = false order by ingredient.id asc;
end;
$$;
 3   DROP FUNCTION public.fetch_available_ingredient();
       public       postgres    false    3    1            �            1255    16691 #   fetch_available_ingredient_detail()    FUNCTION     �  CREATE FUNCTION public.fetch_available_ingredient_detail() RETURNS TABLE(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN 
return query 
		select * from ingredient_detail where ingredient_detail.quantity > 0 AND ingredient_detail.is_hidden = false;
END;
$$;
 :   DROP FUNCTION public.fetch_available_ingredient_detail();
       public       postgres    false    1    3            �            1255    16674    fetch_available_supplier()    FUNCTION       CREATE FUNCTION public.fetch_available_supplier() RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier where supplier.is_hidden = false;
end;
$$;
 1   DROP FUNCTION public.fetch_available_supplier();
       public       postgres    false    3    1            �            1255    16720    fetch_ingredient(integer)    FUNCTION     �   CREATE FUNCTION public.fetch_ingredient(ing_id integer) RETURNS TABLE(id integer, name character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient where ingredient.id = ing_id;
end;
$$;
 7   DROP FUNCTION public.fetch_ingredient(ing_id integer);
       public       postgres    false    3    1            �            1255    16703 *   fetch_ingredient_detail_by_ing_id(integer)    FUNCTION     �  CREATE FUNCTION public.fetch_ingredient_detail_by_ing_id(ingd_id integer) RETURNS TABLE(id integer, ing_id integer, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
BEGIN 
return query 
		select * from ingredient_detail where ingredient_detail.ing_id = ingd_id order by ingredient_detail.id asc;
END;
$$;
 I   DROP FUNCTION public.fetch_ingredient_detail_by_ing_id(ingd_id integer);
       public       postgres    false    3    1            �            1255    16675    fetch_supplier(integer)    FUNCTION       CREATE FUNCTION public.fetch_supplier(sid integer) RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier where supplier.id = sid;
end;
$$;
 2   DROP FUNCTION public.fetch_supplier(sid integer);
       public       postgres    false    3    1            �            1255    16695 /   fetch_supplier_by_ingredient(character varying)    FUNCTION     P  CREATE FUNCTION public.fetch_supplier_by_ingredient(ingredient character varying) RETURNS TABLE(id integer, name character varying, ingredients character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		SELECT * FROM supplier WHERE UPPER(supplier.ingredients) LIKE UPPER('%'||ingredient||'%');
end;
$$;
 Q   DROP FUNCTION public.fetch_supplier_by_ingredient(ingredient character varying);
       public       postgres    false    1    3            �            1255    16699 7   restock_ingredient(integer, character varying, integer)    FUNCTION     Z  CREATE FUNCTION public.restock_ingredient(ing_detail_id integer, sup_name character varying, ing_quantity integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE ingredient_detail
  SET supplier = sup_name, quantity = ing_quantity
  WHERE ingredient_detail.id = ing_detail_id;
  RETURN 'INGREDIENT RESTOCKED!';
END;
$$;
 r   DROP FUNCTION public.restock_ingredient(ing_detail_id integer, sup_name character varying, ing_quantity integer);
       public       postgres    false    3    1            �            1255    16721 6   update_ingredient(integer, character varying, boolean)    FUNCTION     G  CREATE FUNCTION public.update_ingredient(ing_id integer, ing_name character varying, ing_is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE ingredient
  SET name = ing_name, is_hidden = ing_is_hidden
  WHERE ingredient.id = ing_id;
  RETURN 'Ingredient updated successfully!';
END;
$$;
 k   DROP FUNCTION public.update_ingredient(ing_id integer, ing_name character varying, ing_is_hidden boolean);
       public       postgres    false    1    3            �            1255    16713 <   update_ingredient_detail(integer, double precision, boolean)    FUNCTION     P  CREATE FUNCTION public.update_ingredient_detail(ing_detail_id integer, ing_price double precision, ing_is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
UPDATE public.ingredient_detail
	SET price = ing_price, is_hidden = ing_is_hidden
	WHERE id = ing_detail_id;
	return 'updated successfully';
END;
$$;
 y   DROP FUNCTION public.update_ingredient_detail(ing_detail_id integer, ing_price double precision, ing_is_hidden boolean);
       public       postgres    false    3    1            �            1255    16754 #   update_ingredient_quantity(integer)    FUNCTION       CREATE FUNCTION public.update_ingredient_quantity(ing_detail_id integer) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE ingredient_detail
  SET quantity = quantity -1
  WHERE id = ing_detail_id;
  RETURN 'INGREDIENT UPDATED!';
END;
$$;
 H   DROP FUNCTION public.update_ingredient_quantity(ing_detail_id integer);
       public       postgres    false    1    3            �            1255    16676 G   update_supplier(integer, character varying, character varying, boolean)    FUNCTION       CREATE FUNCTION public.update_supplier(sup_id integer, sup_name character varying, sup_ingredients character varying, sup_ishidden boolean) RETURNS character varying
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
       public       postgres    false    3    1            �            1259    16640 
   ingredient    TABLE     �   CREATE TABLE public.ingredient (
    id integer NOT NULL,
    name character varying NOT NULL,
    is_hidden boolean NOT NULL
);
    DROP TABLE public.ingredient;
       public         postgres    false    3            �            1259    16629    ingredient_detail    TABLE       CREATE TABLE public.ingredient_detail (
    id integer NOT NULL,
    ing_id integer NOT NULL,
    province character varying NOT NULL,
    price double precision NOT NULL,
    quantity double precision NOT NULL,
    supplier character varying NOT NULL,
    is_hidden boolean NOT NULL
);
 %   DROP TABLE public.ingredient_detail;
       public         postgres    false    3            �            1259    16627    ingredient_detail_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ingredient_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.ingredient_detail_id_seq;
       public       postgres    false    190    3            �           0    0    ingredient_detail_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.ingredient_detail_id_seq OWNED BY public.ingredient_detail.id;
            public       postgres    false    189            �            1259    16638    ingredient_id_seq    SEQUENCE     z   CREATE SEQUENCE public.ingredient_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.ingredient_id_seq;
       public       postgres    false    192    3            �           0    0    ingredient_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.ingredient_id_seq OWNED BY public.ingredient.id;
            public       postgres    false    191            �            1259    16739    order    TABLE       CREATE TABLE public."order" (
    id integer NOT NULL,
    pizza_size integer NOT NULL,
    ingredients character varying NOT NULL,
    pizza_price double precision NOT NULL,
    ing_price double precision NOT NULL,
    total_price double precision NOT NULL
);
    DROP TABLE public."order";
       public         postgres    false    3            �            1259    16737    order_id_seq    SEQUENCE     u   CREATE SEQUENCE public.order_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.order_id_seq;
       public       postgres    false    3    194            �           0    0    order_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.order_id_seq OWNED BY public."order".id;
            public       postgres    false    193            �            1259    16501    pizza    TABLE     w   CREATE TABLE public.pizza (
    id integer NOT NULL,
    size integer NOT NULL,
    price double precision NOT NULL
);
    DROP TABLE public.pizza;
       public         postgres    false    3            �            1259    16499    pizza_id_seq    SEQUENCE     u   CREATE SEQUENCE public.pizza_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.pizza_id_seq;
       public       postgres    false    3    186            �           0    0    pizza_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.pizza_id_seq OWNED BY public.pizza.id;
            public       postgres    false    185            �            1259    16529    supplier    TABLE     �   CREATE TABLE public.supplier (
    id integer NOT NULL,
    name character varying NOT NULL,
    ingredients character varying NOT NULL,
    is_hidden boolean NOT NULL
);
    DROP TABLE public.supplier;
       public         postgres    false    3            �            1259    16527    supplier_id_seq    SEQUENCE     x   CREATE SEQUENCE public.supplier_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.supplier_id_seq;
       public       postgres    false    3    188            �           0    0    supplier_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.supplier_id_seq OWNED BY public.supplier.id;
            public       postgres    false    187                       2604    16643    ingredient id    DEFAULT     n   ALTER TABLE ONLY public.ingredient ALTER COLUMN id SET DEFAULT nextval('public.ingredient_id_seq'::regclass);
 <   ALTER TABLE public.ingredient ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    191    192    192            
           2604    16632    ingredient_detail id    DEFAULT     |   ALTER TABLE ONLY public.ingredient_detail ALTER COLUMN id SET DEFAULT nextval('public.ingredient_detail_id_seq'::regclass);
 C   ALTER TABLE public.ingredient_detail ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    190    189    190                       2604    16742    order id    DEFAULT     f   ALTER TABLE ONLY public."order" ALTER COLUMN id SET DEFAULT nextval('public.order_id_seq'::regclass);
 9   ALTER TABLE public."order" ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    193    194    194                       2604    16504    pizza id    DEFAULT     d   ALTER TABLE ONLY public.pizza ALTER COLUMN id SET DEFAULT nextval('public.pizza_id_seq'::regclass);
 7   ALTER TABLE public.pizza ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    185    186    186            	           2604    16532    supplier id    DEFAULT     j   ALTER TABLE ONLY public.supplier ALTER COLUMN id SET DEFAULT nextval('public.supplier_id_seq'::regclass);
 :   ALTER TABLE public.supplier ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    187    188    188            �          0    16640 
   ingredient 
   TABLE DATA               9   COPY public.ingredient (id, name, is_hidden) FROM stdin;
    public       postgres    false    192   e       �          0    16629    ingredient_detail 
   TABLE DATA               g   COPY public.ingredient_detail (id, ing_id, province, price, quantity, supplier, is_hidden) FROM stdin;
    public       postgres    false    190   [e       �           0    0    ingredient_detail_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.ingredient_detail_id_seq', 30, true);
            public       postgres    false    189            �           0    0    ingredient_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.ingredient_id_seq', 8, true);
            public       postgres    false    191            �          0    16739    order 
   TABLE DATA               c   COPY public."order" (id, pizza_size, ingredients, pizza_price, ing_price, total_price) FROM stdin;
    public       postgres    false    194   �e       �           0    0    order_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.order_id_seq', 14, true);
            public       postgres    false    193            �          0    16501    pizza 
   TABLE DATA               0   COPY public.pizza (id, size, price) FROM stdin;
    public       postgres    false    186   �f       �           0    0    pizza_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.pizza_id_seq', 12, true);
            public       postgres    false    185            �          0    16529    supplier 
   TABLE DATA               D   COPY public.supplier (id, name, ingredients, is_hidden) FROM stdin;
    public       postgres    false    188   �f       �           0    0    supplier_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.supplier_id_seq', 24, true);
            public       postgres    false    187                       2606    16637 !   ingredient_detail ingredient_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.ingredient_detail
    ADD CONSTRAINT ingredient_pkey PRIMARY KEY (id);
 K   ALTER TABLE ONLY public.ingredient_detail DROP CONSTRAINT ingredient_pkey;
       public         postgres    false    190    190                       2606    16648    ingredient ingredient_pkey1 
   CONSTRAINT     Y   ALTER TABLE ONLY public.ingredient
    ADD CONSTRAINT ingredient_pkey1 PRIMARY KEY (id);
 E   ALTER TABLE ONLY public.ingredient DROP CONSTRAINT ingredient_pkey1;
       public         postgres    false    192    192                       2606    16747    order order_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public."order"
    ADD CONSTRAINT order_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public."order" DROP CONSTRAINT order_pkey;
       public         postgres    false    194    194                       2606    16509    pizza pizza_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.pizza
    ADD CONSTRAINT pizza_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.pizza DROP CONSTRAINT pizza_pkey;
       public         postgres    false    186    186                       2606    16537    supplier supplier_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.supplier
    ADD CONSTRAINT supplier_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.supplier DROP CONSTRAINT supplier_pkey;
       public         postgres    false    188    188            �   -   x�3�t�HM-N�L��tN,QH��Or̀��٩y@v� �B
�      �   a   x�36�4�t--�/H崴�b΀���<�4.#K��KjqF&��	���kJjv"H�(�Y��S�ilb�ih�����tO-�M̫�44��a���qqq �>\      �   �   x���M�0��3�`	�!L���Fc��7D1���KET�!�.ޢ�ޛ�� X'F���Q��$/���t�yv�o�$i��j�ˬ>��̓X�Ȗ���CK^Y�ڒ�@�aq��sf�ϪI�-ξO��lD��Aʫ�8v�ȷ�وI� &��j���C�[g�٬�ݑ������:ï㱎�#�U���$�[��č��w���       �   9   x�U��  ��d��=����DtD��$�eӿ%��y�����p5M=F���
�      �   l   x�-�;� ���X�'�X�9��5�gd���ؽdf��idP�3'6z���!��.ڔmh�bQ�?���FwN���d�_�p�f~>v���U����E^*��H�%�     