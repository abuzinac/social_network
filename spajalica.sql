#upload base
#c:\xampp\mysql\bin\mysql.exe -uspajalica -pspajalica --default_character_set=utf8 < C:\xampp\htdocs\social_network\spajalica.sql

DROP DATABASE IF EXISTS spajalica;
CREATE DATABASE spajalica
  CHARACTER SET utf8
  COLLATE utf8_croatian_ci;

USE spajalica;

CREATE TABLE user (
  id           INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
  first_name   VARCHAR(25)  NOT NULL,
  last_name    VARCHAR(25)  NOT NULL,
  user_name    VARCHAR(100) NOT NULL,
  email        VARCHAR(100) NOT NULL,
  password     VARCHAR(255) NOT NULL,
  signup_date  DATE         NOT NULL,
  profile_pic  VARCHAR(255) NOT NULL,
  num_post     INT          NOT NULL,
  num_likes    INT          NOT NULL,
  user_closed  VARCHAR(3)   NOT NULL,
  friend_array TEXT         NOT NULL
);

CREATE TABLE post (
  id          INT         NOT NULL PRIMARY KEY AUTO_INCREMENT,
  body        TEXT        NOT NULL,
  added_by    VARCHAR(60) NOT NULL,
  user_to     VARCHAR(60) NOT NULL,
  date_added  DATETIME    NOT NULL,
  user_closed VARCHAR(3)  NOT NULL,
  deleted     VARCHAR(3)  NOT NULL,
  likes       INT         NOT NULL
);

CREATE TABLE post_comment (
  id         INT         NOT NULL PRIMARY KEY AUTO_INCREMENT,
  post_body  TEXT        NOT NULL,
  posted_by  VARCHAR(60) NOT NULL,
  posted_to  VARCHAR(60) NOT NULL,
  date_added DATETIME    NOT NULL,
  removed    VARCHAR(3)  NOT NULL,
  post_id    INT         NOT NULL
);

CREATE TABLE likes (
  id        INT         NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(60) NOT NULL,
  post_id   INT         NOT NULL
);

CREATE TABLE friend_requests (
  id        INT         NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_to   VARCHAR(50) NOT NULL,
  user_from VARCHAR(50) NOT NULL
)


