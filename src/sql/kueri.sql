-- Active: 1699258939678@@127.0.0.1@5432@uas_lab@public#users
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username varchar(25) NOT NULL,
    email TEXT NOT NULL,
    password VARCHAR(50) NOT NULL    
);

