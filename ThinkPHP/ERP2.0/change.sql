CREATE TABLE erp_location (id SMALLINT (3) UNSIGNED AUTO_INCREMENT, name VARCHAR (255) NOT NULL, descr VARCHAR(255)  NOT NULL, PRIMARY KEY(id)) ;

CREATE TABLE erp_location_product (id INT UNSIGNED AUTO_INCREMENT, location_id SMALLINT UNSIGNED NOT NULL, product_id SMALLINT UNSIGNED NOT NULL, ori_quantity INT DEFAULT '0' NOT NULL, chg_quantity INT DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ;


ALTER TABLE erp_product_flow CHANGE source from_id SMALLINT NOT NULL;
ALTER TABLE erp_product_flow CHANGE destination to_id SMALLINT NOT NULL;
ALTER TABLE erp_product_flow ADD action VARCHAR(255)  NOT NULL AFTER product_id;