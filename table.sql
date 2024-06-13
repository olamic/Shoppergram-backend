CREATE TABLE users
(
    id                 INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username           VARCHAR(255) NOT NULL,
    password           VARCHAR(255) NOT NULL,
    email              VARCHAR(255) NOT NULL,
    phone_number       VARCHAR(255) NOT NULL,
    reset_token        VARCHAR(255) NULL,
    reset_token_expiry DATETIME NULL
);