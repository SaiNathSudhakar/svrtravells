-- cPanel mysql backup
GRANT USAGE ON *.* TO 'svrtrave_user'@'192.185.12.45' IDENTIFIED BY PASSWORD '*C50D5AC73F907C53D5ABDC37A907B237F6A4F44C';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON `svrtrave\_maindb`.* TO 'svrtrave_user'@'192.185.12.45';
GRANT USAGE ON *.* TO 'svrtrave_user'@'localhost' IDENTIFIED BY PASSWORD '*C50D5AC73F907C53D5ABDC37A907B237F6A4F44C';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON `svrtrave\_maindb`.* TO 'svrtrave_user'@'localhost';
GRANT USAGE ON *.* TO 'svrtrave_user'@'prizm.websitewelcome.com' IDENTIFIED BY PASSWORD '*C50D5AC73F907C53D5ABDC37A907B237F6A4F44C';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON `svrtrave\_maindb`.* TO 'svrtrave_user'@'prizm.websitewelcome.com';
GRANT USAGE ON *.* TO 'svrtravelsindia'@'192.185.12.45' IDENTIFIED BY PASSWORD '*A9B97F63C8039E1D283717FF24BA148877F13553';
GRANT ALL PRIVILEGES ON `svrtrave\_maindb`.* TO 'svrtravelsindia'@'192.185.12.45';
GRANT USAGE ON *.* TO 'svrtravelsindia'@'localhost' IDENTIFIED BY PASSWORD '*A9B97F63C8039E1D283717FF24BA148877F13553';
GRANT ALL PRIVILEGES ON `svrtrave\_maindb`.* TO 'svrtravelsindia'@'localhost';
GRANT USAGE ON *.* TO 'svrtravelsindia'@'prizm.websitewelcome.com' IDENTIFIED BY PASSWORD '*A9B97F63C8039E1D283717FF24BA148877F13553';
GRANT ALL PRIVILEGES ON `svrtrave\_maindb`.* TO 'svrtravelsindia'@'prizm.websitewelcome.com';
