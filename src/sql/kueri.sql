-- Active: 1699258939678@@127.0.0.1@5432@uas_lab@public#users
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username varchar(25) NOT NULL,
    email TEXT NOT NULL,
    password VARCHAR(50) NOT NULL    
);

CREATE TABLE category(
    id SERIAL NOT NULL,
    category_type VARCHAR(25) NOT NULL,
);

ALTER TABLE category ADD CONSTRAINT primary_key PRIMARY KEY(id);

CREATE TABLE transaksi (
    id SERIAL NOT NULL,
    user_id SERIAL NOT NULL,
    amount BIGINT NOT NULL,
    transaction_date DATE NOT NULL,
    transaction_type VARCHAR(10) NOT NULL,
    description TEXT,
    category_id SERIAL NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT FK_user FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT FK_category FOREIGN KEY (category_id) REFERENCES category(id)
);
INSERT INTO category (id, category_type)
    VALUES (1, 'Food/Drink'),
        (2, 'Transportation'),
        (3, 'Clothing'),
        (4, 'Entertainment'),
        (5, 'Shopping'),
        (6, 'Health'),
        (7, 'Technology'),
        (8, 'Others');