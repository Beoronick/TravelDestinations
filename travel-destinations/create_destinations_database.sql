CREATE DATABASE destinations;
CREATE USER 'destinations_user'@'localhost' IDENTIFIED BY '98765';
GRANT ALL PRIVILEGES ON destinations.* TO 'destinations_user'@'localhost';
FLUSH PRIVILEGES;