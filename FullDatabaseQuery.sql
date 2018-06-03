CREATE TABLE category (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
    agegap varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE club (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
	foundationdate date,
    logoname varchar(255),
	president int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE club_person (
    club_id int NOT NULL,
    person_id int NOT NULL,
    PRIMARY KEY (club_id, person_id)
);

CREATE TABLE competition (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
    description varchar(255),
	results varchar(255),
	startlists varchar(255),
	organizer int NOT NULL,
	country int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE competition_category (
    competition_id int NOT NULL,
    category_id int NOT NULL,
    PRIMARY KEY (competition_id, category_id)
);

CREATE TABLE country (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE course (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
    courselength int,
	climbing int,
	estwintime int,
	competition int,
    PRIMARY KEY (id)
);

CREATE TABLE course_category (
    course_id int NOT NULL,
    category_id int NOT NULL,
    PRIMARY KEY (course_id, category_id)
);

CREATE TABLE document (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    title varchar(255) NOT NULL,
    filename varchar(255) NOT NULL,
	competition int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE participation (
    person_id int NOT NULL,
    competition_id int NOT NULL,
    category int NOT NULL,
    PRIMARY KEY (person_id, competition_id)
);

CREATE TABLE person (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	firstname varchar(255) NOT NULL,
	lastname varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	validated bit NOT NULL,
	country int NOT NULL,
	role int NOT NULL,
	category int,
	activeclub int,
    PRIMARY KEY (id)
);

CREATE TABLE post (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    title varchar(255) NOT NULL,
    description varchar(255),
	author int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE post_image (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    imagename varchar(255) NOT NULL,
    post int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE role (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE category_audit(
	id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
    agegap varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE club_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
	foundationdate date,
    logoname varchar(255),
	president int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE competition_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
    description varchar(255),
	results varchar(255),
	startlists varchar(255),
	organizer int NOT NULL,
	country int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE country_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE course_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
    courselength int,
	climbing int,
	estwintime int,
	competition int,
    PRIMARY KEY (id)
);

CREATE TABLE document_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    title varchar(255) NOT NULL,
    filename varchar(255) NOT NULL,
	competition int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE person_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
	firstname varchar(255) NOT NULL,
	lastname varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	validated bit NOT NULL,
	country int NOT NULL,
	role int NOT NULL,
	category int,
	activeclub int,
    PRIMARY KEY (id)
);

CREATE TABLE post_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    title varchar(255) NOT NULL,
    description varchar(255),
	author int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE post_image_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    imagename varchar(255) NOT NULL,
    post int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE role_audit (
    id int NOT NULL,
	created_on TIMESTAMP NOT NULL DEFAULT NOW(),
	modified_on TIMESTAMP NOT NULL DEFAULT NOW(),
	deleted_on TIMESTAMP,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE `category`
ENGINE = INNODB;

ALTER TABLE `club`
ENGINE = INNODB;

ALTER TABLE `club_person`
ENGINE = INNODB;

ALTER TABLE `competition`
ENGINE = INNODB;

ALTER TABLE `competition_category`
ENGINE = INNODB;

ALTER TABLE `country`
ENGINE = INNODB;

ALTER TABLE `course`
ENGINE = INNODB;

ALTER TABLE `course_category`
ENGINE = INNODB;

ALTER TABLE `document`
ENGINE = INNODB;

ALTER TABLE `participation`
ENGINE = INNODB;

ALTER TABLE `person`
ENGINE = INNODB;

ALTER TABLE `post`
ENGINE = INNODB;

ALTER TABLE `post_image`
ENGINE = INNODB;

ALTER TABLE `role`
ENGINE = INNODB;

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `competition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `post_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `club` ADD CONSTRAINT `FK_Club_Person` FOREIGN KEY (`president`) REFERENCES `person`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `club_person` ADD CONSTRAINT `FK_ClubPerson_Club` FOREIGN KEY (`club_id`) REFERENCES `club`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `club_person` ADD CONSTRAINT `FK_ClubPerson_Person` FOREIGN KEY (`person_id`) REFERENCES `person`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `competition` ADD CONSTRAINT `FK_Competition_Club` FOREIGN KEY (`organizer`) REFERENCES `club`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `competition` ADD CONSTRAINT `FK_Competition_Country` FOREIGN KEY (`country`) REFERENCES `country`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `competition_category` ADD CONSTRAINT `FK_CompetitionCategory_Competition` FOREIGN KEY (`competition_id`) REFERENCES `competition`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `competition_category` ADD CONSTRAINT `FK_CompetitionCategory_Category` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `course` ADD CONSTRAINT `FK_Course_Competition` FOREIGN KEY (`competition`) REFERENCES `competition`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `course_category` ADD CONSTRAINT `FK_CourseCategory_Course` FOREIGN KEY (`course_id`) REFERENCES `course`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `course_category` ADD CONSTRAINT `FK_CourseCategory_Category` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `document` ADD CONSTRAINT `FK_Document_Competiton` FOREIGN KEY (`competition`) REFERENCES `competition`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `participation` ADD CONSTRAINT `FK_Participation_Person` FOREIGN KEY (`person_id`) REFERENCES `person`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `participation` ADD CONSTRAINT `FK_Participation_Competition` FOREIGN KEY (`competition_id`) REFERENCES `competition`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `participation` ADD CONSTRAINT `FK_Participation_Category` FOREIGN KEY (`category`) REFERENCES `category`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `person` ADD CONSTRAINT `FK_Person_Country` FOREIGN KEY (`country`) REFERENCES `country`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `person` ADD CONSTRAINT `FK_Person_Role` FOREIGN KEY (`role`) REFERENCES `role`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `person` ADD CONSTRAINT `FK_Person_Category` FOREIGN KEY (`category`) REFERENCES `category`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `person` ADD CONSTRAINT `FK_Person_Club` FOREIGN KEY (`activeclub`) REFERENCES `club`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `post` ADD CONSTRAINT `FK_Post_Person` FOREIGN KEY (`author`) REFERENCES `person`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `post_image` ADD CONSTRAINT `FK_PostImage_Post` FOREIGN KEY (`post`) REFERENCES `post`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- Triggers for 'category' table

CREATE TRIGGER trigger_before_insert_category
BEFORE INSERT ON category
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_category
BEFORE UPDATE ON category
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_category
AFTER DELETE ON category
FOR EACH ROW INSERT INTO category_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name, OLD.agegap);

-- Triggers for 'club' table

CREATE TRIGGER trigger_before_insert_club
BEFORE INSERT ON club
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_club
BEFORE UPDATE ON club
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_club
AFTER DELETE ON club
FOR EACH ROW INSERT INTO club_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name, OLD.foundationdate, OLD.logoname, OLD.president);
	
-- Triggers for 'competition' table

CREATE TRIGGER trigger_before_insert_competition
BEFORE INSERT ON competition
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_competition
BEFORE UPDATE ON competition
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_competition
AFTER DELETE ON competition
FOR EACH ROW INSERT INTO competition_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name, OLD.description, OLD.results, OLD.startlists, OLD.organizer, OLD.country);

-- Triggers for 'country' table

CREATE TRIGGER trigger_before_insert_country
BEFORE INSERT ON country
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_country
BEFORE UPDATE ON country
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_country
AFTER DELETE ON country
FOR EACH ROW INSERT INTO country_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name);

-- Triggers for 'course' table

CREATE TRIGGER trigger_before_insert_course
BEFORE INSERT ON course
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_course
BEFORE UPDATE ON course
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_course
AFTER DELETE ON course
FOR EACH ROW INSERT INTO course_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name, OLD.courselength, OLD.climbing, OLD.estwintime, OLD.competition);

-- Triggers for 'document' table

CREATE TRIGGER trigger_before_insert_document
BEFORE INSERT ON document
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_document
BEFORE UPDATE ON document
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_document
AFTER DELETE ON document
FOR EACH ROW INSERT INTO document_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.title, OLD.filename, OLD.competition);

-- Triggers for 'person' table

CREATE TRIGGER trigger_before_insert_person
BEFORE INSERT ON person
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_person
BEFORE UPDATE ON person
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_person
AFTER DELETE ON person
FOR EACH ROW INSERT INTO person_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.firstname, OLD.lastname, OLD.username, OLD.password, OLD.email, OLD.validated, OLD.country, OLD.role, OLD.category, OLD.activeclub);

-- Triggers for 'post' table

CREATE TRIGGER trigger_before_insert_post
BEFORE INSERT ON post
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_post
BEFORE UPDATE ON post
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_post
AFTER DELETE ON post
FOR EACH ROW INSERT INTO post_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.title, OLD.description, OLD.author);

-- Triggers for 'post_image' table

CREATE TRIGGER trigger_before_insert_post_image
BEFORE INSERT ON post_image
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_post_image
BEFORE UPDATE ON post_image
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_post_image
AFTER DELETE ON post_image
FOR EACH ROW INSERT INTO post_image_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.imagename, OLD.post);

-- Triggers for 'role' table

CREATE TRIGGER trigger_before_insert_role
BEFORE INSERT ON role
FOR EACH ROW SET NEW.created_on = NOW(), NEW.modified_on = NOW();

CREATE TRIGGER trigger_before_update_role
BEFORE UPDATE ON role
FOR EACH ROW SET NEW.created_on = OLD.created_on, NEW.modified_on = NOW();

CREATE TRIGGER trigger_after_delete_role
AFTER DELETE ON role
FOR EACH ROW INSERT INTO role_audit
    VALUES  (OLD.id, OLD.created_on, NOW(), NOW(), OLD.name);

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Athlete'),
(3, 'Coach'),
(4, 'Fan');

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'Argentina'),
(2, 'Australia'),
(3, 'Austria'),
(4, 'Azerbaijan'),
(5, 'Barbados'),
(6, 'Belgium'),
(7, 'Belarus'),
(8, 'Brazil'),
(9, 'Bulgaria'),
(10, 'Canada'),
(11, 'Chile'),
(12, 'China'),
(13, 'Cameroun'),
(14, 'Columbia'),
(15, 'Croatia'),
(16, 'Cuba'),
(17, 'Czech Republic'),
(18, 'Cyprus'),
(19, 'Denmark'),
(20, 'Dominican Republic'),
(21, 'Ecuador'),
(22, 'Egypt'),
(23, 'Spain'),
(24, 'Estonia'),
(25, 'Finland'),
(26, 'France'),
(27, 'Great Britain'),
(28, 'Georgia'),
(29, 'Hong Kong'),
(30, 'Hungary'),
(31, 'Indonesia'),
(32, 'India'),
(33, 'Iran'),
(34, 'Ireland'),
(35, 'Israel'),
(36, 'Italia'),
(37, 'Japan'),
(38, 'Kazakhstan'),
(39, 'Kyrgyzstan'),
(40, 'Korea'),
(41, 'Latvia'),
(42, 'Liechtenstein'),
(43, 'Lithuania'),
(44, 'Malaysia'),
(45, 'Macedonia'),
(46, 'Montenegro'),
(47, 'Mozambique'),
(48, 'Netherlands'),
(49, 'Nepal'),
(50, 'Norway'),
(51, 'New Zealand'),
(52, 'Poland'),
(53, 'Portugal'),
(54, 'Romania'),
(55, 'Republic of Moldova'),
(56, 'Republic of South Africa'),
(57, 'Russia'),
(58, 'Serbia'),
(59, 'Singapore'),
(60, 'Slovenia'),
(61, 'Switzerland'),
(62, 'Slovakia'),
(63, 'Sweden'),
(64, 'Taipei'),
(65, 'Turkey'),
(66, 'Uganda'),
(67, 'Ukraine'),
(68, 'Uruguay'),
(69, 'United States of America');

INSERT INTO `category` (`id`, `name`, `agegap`) VALUES
(1, 'M10', 'Inferior or equal to 10 years old.'),
(2, 'W10', 'Inferior or equal to 10 years old.'),
(3, 'M12', 'Inferior or equal to 12 years old.'),
(4, 'W12', 'Inferior or equal to 12 years old.'),
(5, 'M14', 'Between 12 and 14 years old.'),
(6, 'W14', 'Between 12 and 14 years old.'),
(7, 'M16', 'Between 14 and 16 years old.'),
(8, 'W16', 'Between 14 and 16 years old.'),
(9, 'M18', 'Between 16 and 18 years old.'),
(10, 'W18', 'Between 16 and 18 years old.'),
(11, 'M20', 'Between 18 and 20 years old.'),
(12, 'W20', 'Between 18 and 20 years old.'),
(13, 'M21E', 'Between 21 and 34 years old.'),
(14, 'W21E', 'Between 21 and 34 years old.'),
(15, 'M21A', 'Between 21 and 34 years old.'),
(16, 'W21A', 'Between 21 and 34 years old.'),
(17, 'M21B', 'Between 21 and 34 years old.'),
(18, 'W21B', 'Between 21 and 34 years old.'),
(19, 'M35', 'Between 35 and 39 years old.'),
(20, 'W35', 'Between 35 and 39 years old.'),
(21, 'M40', 'Between 40 and 44 years old.'),
(22, 'W40', 'Between 40 and 44 years old.'),
(23, 'M45', 'Between 45 and 49 years old.'),
(24, 'W45', 'Between 45 and 49 years old.'),
(25, 'M50', 'Between 50 and 54 years old.'),
(26, 'W50', 'Between 50 and 54 years old.'),
(27, 'M55', 'Between 55 and 59 years old.'),
(28, 'W55', 'Between 55 and 59 years old.'),
(29, 'M60', 'Between 60 and 64 years old.'),
(30, 'W60', 'Between 60 and 64 years old.'),
(31, 'M65', 'Between 65 and 69 years old.'),
(32, 'W65', 'Between 65 and 69 years old.'),
(33, 'M70', 'Between 70 and 74 years old.'),
(34, 'W70', 'Between 70 and 74 years old.'),
(35, 'M75', 'Between 75 and 79 years old.'),
(36, 'W75', 'Between 75 and 79 years old.'),
(37, 'M80', 'Between 80 and 84 years old.'),
(38, 'W80', 'Between 80 and 84 years old.'),
(39, 'M85', 'Between 85 and 89 years old.'),
(40, 'W85', 'Between 85 and 89 years old.'),
(41, 'M90', 'Between 90 and 94 years old.'),
(42, 'W90', 'Between 90 and 94 years old.'),
(43, 'M95', 'Between 95 and 99 years old.'),
(44, 'W95', 'Between 95 and 99 years old.'),
(45, 'M100+', 'Over 100 years old.'),
(46, 'W100+', 'Over 100 years old.'),
(47, 'Open', 'No age gap.'),
(48, 'Open Tehnic', 'No age gap.'),
(49, 'Open-Men', 'No age gap.'),
(50, 'Open-Women', 'No age gap.'),
(51, 'Open Family', 'No age gap.');

INSERT INTO `person` (`id`, `created_on`, `modified_on`, `firstname`, `lastname`, `username`, `password`, `email`, `validated`, `country`, `role`, `category`, `activeclub`) VALUES
(1, '2018-05-28 00:25:12', '2018-05-29 15:19:37', '-', '-', 'admin', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'admin@theorienteeringhub.com', b'1', 54, 1, NULL, NULL),
(2, '2018-05-28 18:51:11', '2018-05-28 18:51:11', 'Stefan-Dragos', 'Copetchi', 'kopezaur', '$2y$13$Gf9GlRV0EAEHSWFnGjSb/eLJEyIp7QEDs2e6rTDpXk7qzKEXkwSD.', 'kopezaur@gmail.com', b'0', 54, 2, 13, NULL);
