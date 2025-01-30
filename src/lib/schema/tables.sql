# User table
CREATE TABLE IF NOT EXISTS `User` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(256) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
    `email` VARCHAR(256) NOT NULL,
    `emailVerified` TINYINT(1) NOT NULL DEFAULT 0,
    `permissionLevel` INT NOT NULL,
    `oneTimePassword` VARCHAR(256) NULL,
    `oneTimePasswordExpiration` DATETIME(3) NULL,
    `personalUid` VARCHAR(256) NOT NULL,
    `personalApiKey` VARCHAR(256) NOT NULL,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    UNIQUE KEY (`username`),
    UNIQUE KEY (`email`),
    UNIQUE KEY (`oneTimePassword`),
    UNIQUE KEY (`personalUid`),
    UNIQUE KEY (`personalApiKey`)
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

# Devices table
CREATE TABLE IF NOT EXISTS `Device` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `userId` INT NOT NULL,
    `name` VARCHAR(256) NOT NULL,
    `deviceUid` VARCHAR(256) NOT NULL,
    `deviceApiKey` VARCHAR(256) NOT NULL,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `User`(`id`),
    UNIQUE KEY (`deviceUid`),
    UNIQUE KEY (`deviceApiKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# Device animations table
CREATE TABLE IF NOT EXISTS `DeviceAnimation` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `deviceId` INT NOT NULL,
    `animationId` INT NULL,
    `power` TINYINT(1) NOT NULL DEFAULT 0,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`deviceId`) REFERENCES `Device`(`id`),
    FOREIGN KEY (`animationId`) REFERENCES `Animation`(`id`),
    UNIQUE KEY (`deviceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

# System setting table
CREATE TABLE IF NOT EXISTS `SystemSetting` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(256) NOT NULL,
    `value` VARCHAR(512) NOT NULL,
    `created` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3),
    PRIMARY KEY (`id`),
    UNIQUE KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO SystemSetting VALUE (NULL, 'registrationEnabled', 'true', NOW(), NOW());
