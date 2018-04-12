DROP TABLE IF EXISTS account;

--This is a table to hold user accounts
CREATE TABLE account (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    hashedpass VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO account (username, hashedpass) VALUES ('npranger', '$2a$12$jniGwaCaR9FcS3cGH0aDuui9peYQpPkjEuvBPx4QYM5lf7DzdKdWm');