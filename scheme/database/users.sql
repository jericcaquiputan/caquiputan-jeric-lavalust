CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(100),
    password VARCHAR(255)
);

INSERT INTO users 
(first_name,last_name,email,username,password)
VALUES
('Jeric','Caquiputan','jeric@gmail.com','jeric123','12345'),
('Juan','Dela Cruz','juan@gmail.com','juan123','12345'),
('Maria','Santos','maria@gmail.com','maria123','12345'),
('Pedro','Garcia','pedro@gmail.com','pedro123','12345'),
('Ana','Reyes','ana@gmail.com','ana123','12345'),
('John','Smith','john@gmail.com','john123','12345');