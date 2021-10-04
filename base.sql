-- -----------------------------------------------------
-- Table `teambuilder`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teambuilder`.`roles` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(10) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
    UNIQUE INDEX `slug_UNIQUE` (`slug` ASC) VISIBLE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `teambuilder`.`members`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teambuilder`.`members` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `password` VARCHAR(500) NOT NULL,
    `role_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
    INDEX `fk_members_roles_idx` (`role_id` ASC) VISIBLE,
    CONSTRAINT `fk_members_roles`
        FOREIGN KEY (`role_id`)
        REFERENCES `teambuilder`.`roles` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `teambuilder`.`states`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teambuilder`.`states` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(10) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
    UNIQUE INDEX `slug_UNIQUE` (`slug` ASC) VISIBLE)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `teambuilder`.`teams`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teambuilder`.`teams` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `state_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
    INDEX `fk_teams_states1_idx` (`state_id` ASC) VISIBLE,
    CONSTRAINT `fk_teams_states1`
    FOREIGN KEY (`state_id`)
    REFERENCES `teambuilder`.`states` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `teambuilder`.`team_member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teambuilder`.`team_member` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `member_id` INT NOT NULL,
    `team_id` INT NOT NULL,
    `membership_type` INT NOT NULL COMMENT '0 = inactive\n1 = active\n2 = invitation\n3 = request',
    `is_captain` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_membership` (`member_id` ASC, `team_id` ASC) VISIBLE,
    INDEX `fk_team_member_members1_idx` (`member_id` ASC) VISIBLE,
    INDEX `fk_team_member_teams1_idx` (`team_id` ASC) VISIBLE,
    CONSTRAINT `fk_team_member_members1`
        FOREIGN KEY (`member_id`)
        REFERENCES `teambuilder`.`members` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_team_member_teams1`
        FOREIGN KEY (`team_id`)
        REFERENCES `teambuilder`.`teams` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;