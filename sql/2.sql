CREATE TABLE `sma_controle_image` (
  `id` int(11) NOT NULL,
  `id_controle` int (11) NULL,
  `image` varchar(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sma_controle_image` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);