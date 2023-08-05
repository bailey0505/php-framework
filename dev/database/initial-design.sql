

/* Admin user table */
CREATE TABLE admin_users (
    `Id_admin_users` int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(128),
    `password` varchar(255),
    `auth_level` int(11),
    `reset_password` TINYINT(1),
    `reset_token` varchar(128),
    `first_name` varchar(64),
    `last_name` varchar(64),
    `title` varchar(64),
    `profile_image` varchar(128),
    `site_theme` varchar(16)
);

INSERT INTO admin_users(`username`, `password`, `auth_level`, `first_name`, `last_name`, `title`) VALUES ('baileyrotellini1998@gmail.com', '$2y$12$MBaTGvxxlrq1FsDd/hcHEuvtQaQCybj7rVN5xXBcpWJxrvXYHeWJS', 0, 'Bailey', 'Rotellini', 'Developer');

CREATE TABLE user_level_settings (
    `Id_user_level_settings` int(11)  NOT NULL PRIMARY KEY,
    `display_name` varchar(32),
    `folder` varchar(32)
);

INSERT INTO user_level_settings(`Id_user_level_settings`, `display_name`, `folder`) VALUES (0, 'Administrator', 'admin');