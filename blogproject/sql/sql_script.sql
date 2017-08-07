CREATE DATABASE blog;
CREATE TABLE blog_post (
id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, 
title VARCHAR(60) NOT NULL, 
content TEXT NOT NULL, 
PRIMARY KEY (id)
);

GRANT SELECT ON blog.* TO 'normal_user'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON blog.* TO 'admin_user'@'localhost' IDENTIFIED BY 'securepassword';