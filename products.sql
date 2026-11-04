-- PEAK LINEUP - Products Export SQL
-- peaklineup.co database setup

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`id`, `name`, `category`, `price`, `description`) VALUES
(1, 'singlefin98', 'Boards', 1200.00, 'Classic 9''8 single fin noserider surfboard.'),
(2, 'noserider96', 'Boards', 1150.00, '9''6 performance noserider built for tip time.'),
(3, 'flexfin10', 'Fins', 95.00, '10.5-inch flex single fin template.'),
(4, 'travelbag2board', 'Accessories', 210.00, 'Custom padded travel bag designed for two boards.'),
(5, 'leash9ft', 'Accessories', 36.00, '9ft heavy duty ankle surf leash.'),
(6, 'boardwaxcold', 'Accessories', 4.50, 'Cold water sticky surf wax bar.'),
(7, 'boardwaxwarm', 'Accessories', 4.50, 'Warm water tropical surf wax bar.'),
(8, 'deckpadtail', 'Accessories', 38.00, 'High-traction foam tail deck pad.'),
(9, 'dronefilmingpack', 'Media', 450.00, 'Single session ocean drone videography package.'),
(10, 'surfphotopack', 'Media', 250.00, 'HD digital photo package for ocean sessions.'),
(11, 'rashguardl', 'Apparel', 48.00, 'UPF 50+ quick-dry long sleeve rashguard.'),
(12, 'sunscreenzinc', 'Accessories', 18.00, 'Mineral ocean-safe SPF 50 sunscreen stick.');