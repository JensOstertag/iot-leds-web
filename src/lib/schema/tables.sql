# User table
CREATE TABLE IF NOT EXISTS `User` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `emailVerified` TINYINT(1) NOT NULL DEFAULT 0,
    `permissionLevel` INT NOT NULL,
    `oneTimePassword` VARCHAR(255) NULL,
    `oneTimePasswordExpiration` DATETIME(3) NULL,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    UNIQUE KEY (`username`),
    UNIQUE KEY (`email`),
    UNIQUE KEY (`oneTimePassword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Animations table
CREATE TABLE IF NOT EXISTS `Animation` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `userId` INT NOT NULL,
    `name` VARCHAR(256) NOT NULL,
    `animationType` INT NOT NULL,
    `colors` VARCHAR(4096) NOT NULL,
    `durationPerColor` INT NOT NULL,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `User`(`id`),
    UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
