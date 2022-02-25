# this is for PHP Developer sample Project

CREATE TABLE `test`.`products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NULL,
  `qty` INT NULL,
  `price` DECIMAL(6,2) NULL,
  PRIMARY KEY (`id`));

INSERT INTO `test`.`products` (`name`, `qty`, `price`) VALUES ('Product A', '10', '100');
INSERT INTO `test`.`products` (`name`, `qty`, `price`) VALUES ('Product B', '20', '200');
INSERT INTO `test`.`products` (`name`, `qty`, `price`) VALUES ('Product C', '30', '300');

#install the db on local server
#change connection details inside sales.php under dbconnection function of class Sales
#run on local server
#access the sales.php page
- php -S localhost:8080 -t test/
