--USE destinations;

CREATE TABLE `destinations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ',
  `title` VARCHAR(255) NOT NULL COMMENT 'Име на дестинацията',
  `description` TEXT NOT NULL COMMENT 'Подробно описание на дестинацията',
  `image` VARCHAR(255) NOT NULL COMMENT 'URL или път на изображението',
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Цена на човек за посещение',
  `location` VARCHAR(255) NOT NULL COMMENT 'Географска локация (град, държава)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Примерни данни за туристически дестинации
INSERT INTO `destinations` (`id`, `title`, `description`, `image`, `price`, `location`) VALUES
(1, 'Върха на изискаността - Париж', 'Изживейте магията на Париж с посещения на Айфеловата кула, Лувъра и круизи по река Сена.', 'paris.jpg', 1500.00, 'Франция'),
(2, 'Приключение в Бали', 'Тропически рай с невероятни плажове, културни храмове и водни приключения.', 'bali.jpg', 1800.00, 'Индонезия'),
(3, 'Ню Йорк - градът, който никога не спи!', 'Изследвайте улиците на Ню Йорк със спиращи дъха забележителности като Таймс Скуеър и Статуята на Свободата.', 'nyc.jpg', 1200.00, 'САЩ'),
(4, 'Токио и културата на Японкия дух', 'Потопете се в културата на Токио с уроци за приготвяне на суши, посещения на храмове и динамичното Шибуя.', 'tokyo.jpg', 2000.00, 'Япония'),
(5, 'Неапол - кулинарната столица на Италия и Апенините', 'Изживей необятните вкусове и оживени живот на Неапол от най-тесните улици до най-кътните ресторанти.', 'naples.jpg', 2500.00, 'Италия'),
(6, 'Рим - Вечният град', 'Изживейте историята на Рим с посещения на Колизеума, Римския форум и Ватикана.', 'rome.jpg', 1350.00, 'Италия'),
(7, 'Йоханесбург - приключение в Южна Африка', 'Потопете се в дивата природа на Южна Африка с сафари в националните паркове и наблюдение на диви животни.', 'johannesburg.jpg', 2200.00, 'Южна Африка'),
(8, 'Барселона - съвършенството на испанската архитектура', 'Открийте уникалната архитектура на Гауди и релаксирайте на плажовете на Барселона.', 'uploads/barcelona.jpg', 1400.00, 'Испания'),
(9, 'Кейп Таун - крайбрежни приключения и природа', 'Насладете се на спиращите дъха гледки към Столовата планина и плажовете на Кейп Таун.', 'capetown.jpg', 1800.00, 'Южна Африка'),
(10, 'Мачу Пикчу - Загадката на инките', 'Изкачете се до древния Мачу Пикчу и открийте мистиката на древната инкска цивилизация.', 'machu.jpg', 2100.00, 'Перу'),
(11, 'Петра - скритото чудо на Йордания', 'Разгледайте древния град Петра, изсечен в скалите, и се потопете в историята на Йордания.', 'petra.jpg', 1900.00, 'Йордания');

-- Таблица за users
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ',
  `names` VARCHAR(255) NOT NULL COMMENT 'Пълно име на потребителя',
  `email` VARCHAR(255) NOT NULL COMMENT 'Имейл адрес за влизане',
  `password` VARCHAR(255) NOT NULL COMMENT 'Хеширана парола за сигурност',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Примерни users
INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(1, 'Йон Доу', 'john.doe@example.com', '$argon2i$v=19$m=65536,t=4,p=1$QndnNTB3b0RmdUhTV2VVZQ$QfKHIMfaObI+KUoAMDhyxVKnxTQ3QvMBD+YYvy3Niks'),
(2, 'Жана Смит', 'jane.smith@example.com', '$argon2i$v=19$m=65536,t=4,p=1$YVVlU2x1b1dXVExaMmxiZQ$mlrDv6NwGJy10RN/uSLUjcko12TCTRg/Qvg0LaHVUSk');

-- Таблица за любими туристически дестинации (Връзка между users и дестинации)
CREATE TABLE `destinations_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ',
  `user_id` INT(11) NOT NULL COMMENT 'ID на потребителя',
  `destination_id` INT(11) NOT NULL COMMENT 'ID на любимата дестинация',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`destination_id`) REFERENCES `destinations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Добавяне на индекси и ограничения
ALTER TABLE `destinations`
  ADD INDEX `idx_location` (`location`);

ALTER TABLE `destinations_users`
  ADD INDEX `idx_user_destination` (`user_id`, `destination_id`);

-- Включване на auto-increment за таблиците
ALTER TABLE `destinations`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=5;

ALTER TABLE `destinations_users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Първичен ключ', AUTO_INCREMENT=3;

-- Добавяне на CONSTRAINT към fk за каскадно изтриване
ALTER TABLE destinations_users
ADD CONSTRAINT fk_destination_id
FOREIGN KEY (destination_id)
REFERENCES destinations(id)
ON DELETE CASCADE;
