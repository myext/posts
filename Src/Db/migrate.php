<?php

include (__DIR__."/../boot.php");

$pdo = \Src\Db\DB::getPDO();


$query_posts = "
CREATE TABLE IF NOT EXISTS posts(
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `message` text,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ( id ),
  FOREIGN KEY (user_id)  REFERENCES users (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$query_users = "
CREATE TABLE IF NOT EXISTS users(
  `id` bigint NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `birthdate` date,
  `email` varchar(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ( id )) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$pdo->exec($query_users);
$pdo->exec($query_posts);

$query = "INSERT INTO users (id, fullname, birthdate) VALUES(1, 'jon doo', '1975-01-01')";
$pdo->exec($query);

$query = "INSERT INTO posts (user_id , message) VALUES(1, 'hello')";
$pdo->exec($query);


