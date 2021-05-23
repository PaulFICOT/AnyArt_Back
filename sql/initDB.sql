DROP DATABASE anyart;
CREATE DATABASE IF NOT EXISTS anyart;
USE anyart;

CREATE TABLE countries(
   country_id INT NOT NULL AUTO_INCREMENT,
   country VARCHAR(63) NOT NULL,
   PRIMARY KEY(country_id),
   FULLTEXT coutries_idx(country)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE payment_method(
   payment_method_id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   PRIMARY KEY(payment_method_id)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE categories(
   category_id INT NOT NULL AUTO_INCREMENT,
   category VARCHAR(100) NOT NULL,
   PRIMARY KEY(category_id),
   FULLTEXT categories_idx(category)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE users(
   user_id INT NOT NULL AUTO_INCREMENT,
   lastname VARCHAR(100) NOT NULL,
   firstname VARCHAR(100) NOT NULL,
   mail VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   birth_date DATE NOT NULL,
   username VARCHAR(100) NOT NULL,
   crea_date DATETIME NOT NULL,
   upd_date DATETIME NOT NULL,
   is_verified BOOLEAN NOT NULL,
   is_active BOOLEAN NOT NULL,
   is_banned BOOLEAN NOT NULL,
   profile_desc VARCHAR(255) NOT NULL,
   type VARCHAR(20) NOT NULL,
   job_function VARCHAR(100),
   open_to_work BOOLEAN NOT NULL,
   country_id INT NOT NULL,
   token VARCHAR(255),
   donation_link VARCHAR(255),
   PRIMARY KEY(user_id),
   UNIQUE(mail),
   FOREIGN KEY(country_id) REFERENCES countries(country_id),
   FULLTEXT users_idx(username, job_function)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE users_follower(
   follower_id INT NOT NULL AUTO_INCREMENT,
   crea_date DATETIME NOT NULL,
   follower_user_id INT NOT NULL,
   followed_user_id INT NOT NULL,
   PRIMARY KEY(follower_id),
   FOREIGN KEY(follower_user_id) REFERENCES users(user_id),
   FOREIGN KEY(followed_user_id) REFERENCES users(user_id)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE users_message(
   message_id INT NOT NULL AUTO_INCREMENT,
   message VARCHAR(255),
   is_deleted BOOLEAN NOT NULL,
   sender_id INT NOT NULL,
   receiver_id INT NOT NULL,
   PRIMARY KEY(message_id),
   FOREIGN KEY(sender_id) REFERENCES users(user_id),
   FOREIGN KEY(receiver_id) REFERENCES users(user_id)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE users_donation(
   donation_id INT NOT NULL AUTO_INCREMENT,
   crea_date DATETIME NOT NULL,
   message VARCHAR(255),
   donator_id INT NOT NULL,
   receiver_id INT NOT NULL,
   payment_method_id INT NOT NULL,
   PRIMARY KEY(donation_id),
   FOREIGN KEY(donator_id) REFERENCES users(user_id),
   FOREIGN KEY(receiver_id) REFERENCES users(user_id),
   FOREIGN KEY(payment_method_id) REFERENCES payment_method(payment_method_id)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts(
   post_id INT NOT NULL AUTO_INCREMENT,
   title VARCHAR(255) NOT NULL,
   content VARCHAR(255),
   crea_date DATETIME NOT NULL,
   upd_date DATETIME NOT NULL,
   user_id INT NOT NULL,
   PRIMARY KEY(post_id),
   FOREIGN KEY (user_id) REFERENCES users(user_id),
   FULLTEXT posts_idx(title, content)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts_comment(
   comment_id INT NOT NULL AUTO_INCREMENT,
   content VARCHAR(255) NOT NULL,
   crea_date DATETIME NOT NULL,
   reply_to INT,
   user_id INT NOT NULL,
   post_id INT NOT NULL,
   PRIMARY KEY(comment_id),
   FOREIGN KEY(reply_to) REFERENCES posts_comment(comment_id),
   FOREIGN KEY(user_id) REFERENCES users(user_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts_like(
   like_id INT NOT NULL AUTO_INCREMENT,
   is_like BOOLEAN NOT NULL,
   crea_date DATETIME NOT NULL,
   user_id INT NOT NULL,
   post_id INT NOT NULL,
   PRIMARY KEY(user_id, post_id),
   UNIQUE(like_id),
   FOREIGN KEY(user_id) REFERENCES users(user_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts_tag(
   tag_id INT NOT NULL AUTO_INCREMENT,
   tag VARCHAR(80) NOT NULL,
   post_id INT NOT NULL,
   PRIMARY KEY(tag_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE,
   FULLTEXT tags_idx(tag)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts_view(
   viewcount_id INT NOT NULL AUTO_INCREMENT,
   view_count INT,
   post_id INT NOT NULL,
   PRIMARY KEY(viewcount_id),
   UNIQUE(post_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE notifications(
   id_notification INT NOT NULL AUTO_INCREMENT,
   text VARCHAR(255) NOT NULL,
   is_read BOOLEAN NOT NULL,
   crea_date DATETIME NOT NULL,
   user_id INT NOT NULL,
   post_id INT NOT NULL,
   PRIMARY KEY(id_notification),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE,
   FOREIGN KEY(user_id) REFERENCES users(user_id)

)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE picture(
   picture_id INT NOT NULL AUTO_INCREMENT,
   url VARCHAR(255) NOT NULL,
   is_thumbnail BOOLEAN NOT NULL,
   user_id INT NOT NULL,
   post_id INT,
   PRIMARY KEY(picture_id),
   UNIQUE(url),
   FOREIGN KEY(user_id) REFERENCES users(user_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE posts_category_list(
   post_id INT,
   category_id INT,
   PRIMARY KEY(post_id, category_id),
   FOREIGN KEY(post_id) REFERENCES posts(post_id)
   ON DELETE CASCADE,
   FOREIGN KEY(category_id) REFERENCES categories(category_id)
)
ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;