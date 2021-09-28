-- -----------------------------------------------------
-- Table `roles` - Data
-- -----------------------------------------------------
INSERT INTO roles(roles.slug, roles.name)
VALUES ("MEM", "Member"),
       ("MOD", "Moderator");

-- -----------------------------------------------------
-- Table `states` - Data
-- -----------------------------------------------------
INSERT INTO `states` (`id`, `slug`, `name`)
VALUES (1, 'WAIT_CHANG', 'Attente de chagement'),
       (2, 'WAIT_VAL', 'Attente de validation'),
       (3, 'VALIDATED', 'Validé'),
       (4, 'COMMITTED', 'Engagée'),
       (5, 'RECRUTING', 'Recrutement');

-- -----------------------------------------------------
-- Table `teams` - Data
-- -----------------------------------------------------

INSERT INTO teambuilder.teams (name, state_id)
VALUES ("Suicide Squad", 1),
       ("Les Fâchés", 1),
       ("Les Semi-Croustillants", 1),
       ("Les Pécors", 1),
       ("Les Bouffons de Défi", 1),
       ("Les Mugiwaras", 1),
       ("La DreamTeam", 1),
       ("Les StormTrooper", 1),
       ("Les PoufSoufle", 1),
       ("Les X-Files", 1),
       ("Les Demi-Dieux", 1),
       ("Les Squeezos", 1),
       ("Les Chevaliers du Zodiaque", 1),
       ("No Name", 1),
       ("Black Lagoon", 1);

-- -----------------------------------------------------
-- Table `members` - Data
-- -----------------------------------------------------

insert into teambuilder.members (name, password, role_id)
values ('Anthony', 'Anthony''s_Pa$$w0rd', 1),
       ('Armand', 'Armand''s_Pa$$w0rd', 1),
       ('Cyril', 'Cyril''s_Pa$$w0rd', 1),
       ('Filipe', 'Filipe''s_Pa$$w0rd', 1),
       ('Helene', 'Helene''s_Pa$$w0rd', 1),
       ('Mario', 'Mario''s_Pa$$w0rd', 1),
       ('Mathieu', 'Mathieu''s_Pa$$w0rd', 1),
       ('Mauro', 'Mauro''s_Pa$$w0rd', 1),
       ('Melodie', 'Melodie''s_Pa$$w0rd', 1),
       ('Noah', 'Noah''s_Pa$$w0rd', 1),
       ('Robiel', 'Robiel''s_Pa$$w0rd', 1),
       ('Sou', 'Sou''s_Pa$$w0rd', 1),
       ('Theo', 'Theo''s_Pa$$w0rd', 1),
       ('Yannick', 'Yannick''s_Pa$$w0rd', 1),
       ('Xavier', 'Xavier''s_Pa$$w0rd', 2),
       ('Pascal', 'Pascal''s_Pa$$w0rd', 2),
       ('Nicolas', 'Nicolas''s_Pa$$w0rd', 2),
       ('Lèi', 'Lèi''s_Pa$$w0rd', 1),
       ('Marie-josée', 'Marie-josée''s_Pa$$w0rd', 1),
       ('Håkan', 'Håkan''s_Pa$$w0rd', 1),
       ('Cécile', 'Cécile''s_Pa$$w0rd', 1),
       ('Dà', 'Dà''s_Pa$$w0rd', 1),
       ('Néhémie', 'Néhémie''s_Pa$$w0rd', 1),
       ('Sòng', 'Sòng''s_Pa$$w0rd', 1),
       ('Audréanne', 'Audréanne''s_Pa$$w0rd', 1),
       ('Lucrèce', 'Lucrèce''s_Pa$$w0rd', 2),
       ('Göran', 'Göran''s_Pa$$w0rd', 1),
       ('Hélèna', 'Hélèna''s_Pa$$w0rd', 1),
       ('Åslög', 'Åslög''s_Pa$$w0rd', 1),
       ('Inès', 'Inès''s_Pa$$w0rd', 1),
       ('Agnès', 'Agnès''s_Pa$$w0rd', 1),
       ('Táng', 'Táng''s_Pa$$w0rd', 1),
       ('Yáo', 'Yáo''s_Pa$$w0rd', 1),
       ('Marlène', 'Marlène''s_Pa$$w0rd', 1),
       ('Eléa', 'Eléa''s_Pa$$w0rd', 1),
       ('Thérèse', 'Thérèse''s_Pa$$w0rd', 1),
       ('Pélagie', 'Pélagie''s_Pa$$w0rd', 1),
       ('Clélia', 'Clélia''s_Pa$$w0rd', 2),
       ('Anaé', 'Anaé''s_Pa$$w0rd', 1),
       ('Marie-noël', 'Marie-noël''s_Pa$$w0rd', 1),
       ('Andréanne', 'Andréanne''s_Pa$$w0rd', 1),
       ('Gérald', 'Gérald''s_Pa$$w0rd', 1),
       ('Bérénice', 'Bérénice''s_Pa$$w0rd', 1),
       ('Anaël', 'Anaël''s_Pa$$w0rd', 1),
       ('Mélissandre', 'Mélissandre''s_Pa$$w0rd', 1),
       ('Marie-hélène', 'Marie-hélène''s_Pa$$w0rd', 1),
       ('Desirée', 'Desirée''s_Pa$$w0rd', 1),
       ('Zhì', 'Zhì''s_Pa$$w0rd', 1),
       ('Lén', 'Lén''s_Pa$$w0rd', 1),
       ('Cinéma', 'Cinéma''s_Pa$$w0rd', 1),
       ('Marylène', 'Marylène''s_Pa$$w0rd', 1);

-- -----------------------------------------------------
-- Table `teambuilder` - Data
-- -----------------------------------------------------

INSERT INTO `teambuilder`.`team_member` (`member_id`, `team_id`, `membership_type`, `is_captain`)
VALUES ('27', '1', '1', '1'),
       ('2', '1', '2', '0'),
       ('22', '1', '1', '0'),
       ('4', '1', '1', '0'),
       ('1', '2', '1', '1'),
       ('20', '2', '3', '0'),
       ('37', '2', '1', '0'),
       ('31', '3', '1', '1'),
       ('2', '3', '2', '0'),
       ('3', '3', '2', '0'),
       ('32', '3', '1', '0'),
       ('5', '3', '1', '0'),
       ('6', '3', '2', '0'),
       ('4', '4', '1', '1'),
       ('33', '4', '1', '0'),
       ('20', '4', '3', '0'),
       ('7', '4', '3', '0'),
       ('5', '5', '1', '1'),
       ('6', '5', '1', '0'),
       ('7', '5', '2', '0'),
       ('28', '6', '1', '1'),
       ('36', '6', '1', '0'),
       ('34', '6', '2', '0'),
       ('10', '6', '1', '0'),
       ('21', '7', '1', '1'),
       ('38', '7', '3', '0'),
       ('10', '7', '1', '0'),
       ('8', '8', '1', '1'),
       ('25', '8', '3', '0'),
       ('10', '8', '1', '0'),
       ('11', '8', '2', '0'),
       ('12', '8', '1', '0'),
       ('13', '8', '1', '0'),
       ('39', '9', '1', '1'),
       ('12', '9', '1', '0'),
       ('13', '9', '0', '0'),
       ('21', '9', '1', '0'),
       ('40', '10', '1', '1'),
       ('14', '11', '1', '1'),
       ('14', '12', '1', '1'),
       ('35', '13', '1', '1'),
       ('18', '14', '1', '1'),
       ('19', '15', '1', '1');
INSERT INTO `teambuilder`.`team_member` (`member_id`, `team_id`, `membership_type`)
VALUES ('25', '10', '0'),
       ('13', '10', '1'),
       ('15', '11', '1'),
       ('16', '11', '2'),
       ('29', '11', '3'),
       ('15', '12', '1'),
       ('16', '12', '0'),
       ('26', '12', '1'),
       ('18', '12', '2'),
       ('16', '13', '1'),
       ('17', '13', '3'),
       ('23', '13', '1'),
       ('19', '13', '2'),
       ('20', '13', '1'),
       ('27', '14', '0'),
       ('30', '14', '1'),
       ('20', '15', '2'),
       ('21', '15', '1'),
       ('24', '15', '3');
