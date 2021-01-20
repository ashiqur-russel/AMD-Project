PGDMP                          y            pizza    13.1    13.1 .    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24576    pizza    DATABASE     P   CREATE DATABASE pizza WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'C';
    DROP DATABASE pizza;
                ashiq    false            �            1255    24617 t   add_ingredient(character varying, character varying, double precision, double precision, character varying, boolean)    FUNCTION     �  CREATE FUNCTION public.add_ingredient(name character varying, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 

INSERT INTO ingredient(name, province, price, quantity, supplier, is_hidden) VALUES (name, province, price, quantity, supplier, is_hidden);

return 'success';

END;
$$;
 �   DROP FUNCTION public.add_ingredient(name character varying, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean);
       public          ashiq    false            �            1255    24602 �   add_order(character varying, integer, character varying, character varying, double precision, double precision, double precision)    FUNCTION     (  CREATE FUNCTION public.add_order(pizza_name character varying, pizza_size integer, ing_name character varying, ing_province character varying, pizza_price double precision, ing_price double precision, total_price double precision) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."order "(
	 pizza_name, pizza_size, ing_name, ing_province, pizza_price, ing_price, total_price)
	VALUES (pizza_name, pizza_size, ing_name, ing_province, pizza_price, ing_price, total_price);
	RETURN 'Order added successfully!';
END;
$$;
 �   DROP FUNCTION public.add_order(pizza_name character varying, pizza_size integer, ing_name character varying, ing_province character varying, pizza_price double precision, ing_price double precision, total_price double precision);
       public          ashiq    false            �            1255    24603 J   add_pizza(character varying, integer, double precision, character varying)    FUNCTION     N  CREATE FUNCTION public.add_pizza(name character varying, size integer, price double precision, add_ons character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."pizza"(
	 name, size, price, add_ons)
	VALUES (name, size, price, add_ons);
return 'New pizza added successfully!';	
	
END;
$$;
 y   DROP FUNCTION public.add_pizza(name character varying, size integer, price double precision, add_ons character varying);
       public          ashiq    false            �            1255    24604 ;   add_supplier(character varying, character varying, boolean)    FUNCTION     <  CREATE FUNCTION public.add_supplier(name character varying, address character varying, is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN 
INSERT INTO public."supplier"(
	 name, address, ishidden)
	VALUES (name, address, is_hidden);
return 'New supplier added successfully!';
END;
$$;
 i   DROP FUNCTION public.add_supplier(name character varying, address character varying, is_hidden boolean);
       public          ashiq    false            �            1255    24605    delete_ingredient(integer)    FUNCTION     �   CREATE FUNCTION public.delete_ingredient(ing_id integer) RETURNS character varying
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
       public          ashiq    false            �            1255    24606    delete_supplier(integer)    FUNCTION     �   CREATE FUNCTION public.delete_supplier(sid integer) RETURNS character varying
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
       public          ashiq    false            �            1255    24607    fetch_all_ingredient()    FUNCTION     7  CREATE FUNCTION public.fetch_all_ingredient() RETURNS TABLE(id integer, name character varying, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient;
end;
$$;
 -   DROP FUNCTION public.fetch_all_ingredient();
       public          ashiq    false            �            1255    24608    fetch_all_pizza()    FUNCTION     �   CREATE FUNCTION public.fetch_all_pizza() RETURNS TABLE(id integer, name character varying, size integer, price double precision, add_ons character varying)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from pizza;
end;
$$;
 (   DROP FUNCTION public.fetch_all_pizza();
       public          ashiq    false            �            1255    24609    fetch_all_supplier()    FUNCTION     �   CREATE FUNCTION public.fetch_all_supplier() RETURNS TABLE(id integer, name character varying, address character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier;
end;
$$;
 +   DROP FUNCTION public.fetch_all_supplier();
       public          ashiq    false            �            1255    24610    fetch_available_ingredient()    FUNCTION     |  CREATE FUNCTION public.fetch_available_ingredient() RETURNS TABLE(id integer, name character varying, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient where ingredient.quantity > 0 AND ingredient.is_hidden = false;
end;
$$;
 3   DROP FUNCTION public.fetch_available_ingredient();
       public          ashiq    false            �            1255    24611    fetch_available_supplier()    FUNCTION     
  CREATE FUNCTION public.fetch_available_supplier() RETURNS TABLE(id integer, name character varying, address character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from supplier where supplier.is_hidden = false;
end;
$$;
 1   DROP FUNCTION public.fetch_available_supplier();
       public          ashiq    false            �            1255    24612    fetch_ingredient(integer)    FUNCTION     ^  CREATE FUNCTION public.fetch_ingredient(ing_id integer) RETURNS TABLE(id integer, name character varying, province character varying, price double precision, quantity double precision, supplier character varying, is_hidden boolean)
    LANGUAGE plpgsql
    AS $$
begin
	return query 
		select * from ingredient where ingredient.id = ing_id;
end;
$$;
 7   DROP FUNCTION public.fetch_ingredient(ing_id integer);
       public          ashiq    false            �            1255    24613 �   update_ingredient(integer, character varying, character varying, double precision, double precision, character varying, boolean)    FUNCTION        CREATE FUNCTION public.update_ingredient(ing_id integer, ing_name character varying, ing_province character varying, ing_price double precision, ing_quantity double precision, ing_supplier character varying, ing_is_hidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE ingredient
  SET name = ing_name, province = ing_province, price = ing_price, quantity = ing_quantity, supplier = ing_supplier, is_hidden = ing_is_hidden
  WHERE ingredient.id = ing_id;
  RETURN 'Ingredient updated successfully!';
END;
$$;
 �   DROP FUNCTION public.update_ingredient(ing_id integer, ing_name character varying, ing_province character varying, ing_price double precision, ing_quantity double precision, ing_supplier character varying, ing_is_hidden boolean);
       public          ashiq    false            �            1255    24614 G   update_supplier(integer, character varying, character varying, boolean)    FUNCTION     s  CREATE FUNCTION public.update_supplier(sup_id integer, sup_name character varying, sup_address character varying, sup_ishidden boolean) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
BEGIN	
  UPDATE supplier
  SET name = sup_name, address = sup_address, is_hidden = sup_ishidden
  WHERE supplier.id = sup_id;
  RETURN 'Supplier updated successfully!';
END;
$$;
 �   DROP FUNCTION public.update_supplier(sup_id integer, sup_name character varying, sup_address character varying, sup_ishidden boolean);
       public          ashiq    false            �            1259    24620 
   ingredient    TABLE        CREATE TABLE public.ingredient (
    id integer NOT NULL,
    name character varying NOT NULL,
    province character varying NOT NULL,
    price double precision NOT NULL,
    quantity double precision NOT NULL,
    supplier character varying NOT NULL,
    is_hidden boolean NOT NULL
);
    DROP TABLE public.ingredient;
       public         heap    ashiq    false            �            1259    24618    ingredient_id_seq    SEQUENCE     �   CREATE SEQUENCE public.ingredient_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.ingredient_id_seq;
       public          ashiq    false    201            �           0    0    ingredient_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.ingredient_id_seq OWNED BY public.ingredient.id;
          public          ashiq    false    200            �            1259    24653    order    TABLE     Z  CREATE TABLE public."order" (
    id integer NOT NULL,
    pizza_name character varying NOT NULL,
    pizza_size integer NOT NULL,
    ing_name character varying NOT NULL,
    ing_province character varying NOT NULL,
    pizza_price double precision NOT NULL,
    ing_price double precision NOT NULL,
    total_price double precision NOT NULL
);
    DROP TABLE public."order";
       public         heap    ashiq    false            �            1259    24651    order_id_seq    SEQUENCE     �   CREATE SEQUENCE public.order_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.order_id_seq;
       public          ashiq    false    207            �           0    0    order_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.order_id_seq OWNED BY public."order".id;
          public          ashiq    false    206            �            1259    24642    pizza    TABLE     �   CREATE TABLE public.pizza (
    id integer NOT NULL,
    name character varying NOT NULL,
    size integer NOT NULL,
    price double precision NOT NULL,
    add_ons character varying NOT NULL
);
    DROP TABLE public.pizza;
       public         heap    ashiq    false            �            1259    24640    pizza_id_seq    SEQUENCE     �   CREATE SEQUENCE public.pizza_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.pizza_id_seq;
       public          ashiq    false    205            �           0    0    pizza_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.pizza_id_seq OWNED BY public.pizza.id;
          public          ashiq    false    204            �            1259    24631    supplier    TABLE     �   CREATE TABLE public.supplier (
    id integer NOT NULL,
    name character varying NOT NULL,
    address character varying NOT NULL,
    is_hidden boolean NOT NULL
);
    DROP TABLE public.supplier;
       public         heap    ashiq    false            �            1259    24629    supplier_id_seq    SEQUENCE     �   CREATE SEQUENCE public.supplier_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.supplier_id_seq;
       public          ashiq    false    203            �           0    0    supplier_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.supplier_id_seq OWNED BY public.supplier.id;
          public          ashiq    false    202            O           2604    24623    ingredient id    DEFAULT     n   ALTER TABLE ONLY public.ingredient ALTER COLUMN id SET DEFAULT nextval('public.ingredient_id_seq'::regclass);
 <   ALTER TABLE public.ingredient ALTER COLUMN id DROP DEFAULT;
       public          ashiq    false    200    201    201            R           2604    24656    order id    DEFAULT     f   ALTER TABLE ONLY public."order" ALTER COLUMN id SET DEFAULT nextval('public.order_id_seq'::regclass);
 9   ALTER TABLE public."order" ALTER COLUMN id DROP DEFAULT;
       public          ashiq    false    207    206    207            Q           2604    24645    pizza id    DEFAULT     d   ALTER TABLE ONLY public.pizza ALTER COLUMN id SET DEFAULT nextval('public.pizza_id_seq'::regclass);
 7   ALTER TABLE public.pizza ALTER COLUMN id DROP DEFAULT;
       public          ashiq    false    204    205    205            P           2604    24634    supplier id    DEFAULT     j   ALTER TABLE ONLY public.supplier ALTER COLUMN id SET DEFAULT nextval('public.supplier_id_seq'::regclass);
 :   ALTER TABLE public.supplier ALTER COLUMN id DROP DEFAULT;
       public          ashiq    false    202    203    203            �          0    24620 
   ingredient 
   TABLE DATA           ^   COPY public.ingredient (id, name, province, price, quantity, supplier, is_hidden) FROM stdin;
    public          ashiq    false    201   �C       �          0    24653    order 
   TABLE DATA           z   COPY public."order" (id, pizza_name, pizza_size, ing_name, ing_province, pizza_price, ing_price, total_price) FROM stdin;
    public          ashiq    false    207    D       �          0    24642    pizza 
   TABLE DATA           ?   COPY public.pizza (id, name, size, price, add_ons) FROM stdin;
    public          ashiq    false    205   D       �          0    24631    supplier 
   TABLE DATA           @   COPY public.supplier (id, name, address, is_hidden) FROM stdin;
    public          ashiq    false    203   kD       �           0    0    ingredient_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.ingredient_id_seq', 17, true);
          public          ashiq    false    200            �           0    0    order_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.order_id_seq', 1, false);
          public          ashiq    false    206            �           0    0    pizza_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.pizza_id_seq', 3, true);
          public          ashiq    false    204            �           0    0    supplier_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.supplier_id_seq', 1, false);
          public          ashiq    false    202            T           2606    24628    ingredient ingredient_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.ingredient
    ADD CONSTRAINT ingredient_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.ingredient DROP CONSTRAINT ingredient_pkey;
       public            ashiq    false    201            Z           2606    24661    order order_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public."order"
    ADD CONSTRAINT order_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public."order" DROP CONSTRAINT order_pkey;
       public            ashiq    false    207            X           2606    24650    pizza pizza_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.pizza
    ADD CONSTRAINT pizza_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.pizza DROP CONSTRAINT pizza_pkey;
       public            ashiq    false    205            V           2606    24639    supplier supplier_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.supplier
    ADD CONSTRAINT supplier_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.supplier DROP CONSTRAINT supplier_pkey;
       public            ashiq    false    203            �   ]   x�34�t�)�tO-�M̫�4��32R�JR�
�2�S9K����\\989�RKJ�9Ӹ�9�R�K�8�\8��L9������� I�      �      x������ � �      �   >   x�3�H-H,���TȬ�J�44�4��2�tJMMCqrs:gd&g��!��rr��qqq ���      �      x������ � �     