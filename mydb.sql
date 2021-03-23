-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 23 2021 г., 20:58
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mydb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `ID` int NOT NULL,
  `Customer_id` int NOT NULL COMMENT 'Заказчик',
  `Work_list` text COMMENT 'Список работ',
  `Date_from` datetime NOT NULL COMMENT 'Дата начала работ',
  `Date_to` datetime DEFAULT NULL COMMENT 'Дата окончания работ',
  `Price` decimal(12,2) DEFAULT NULL COMMENT 'Стоимость работ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Заказы';

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`ID`, `Customer_id`, `Work_list`, `Date_from`, `Date_to`, `Price`) VALUES
(1, 2, 'Демонтаж стен', '2020-01-31 00:00:00', '2020-02-05 00:00:00', '5245.64'),
(2, 2, 'Покраска потолка (красный)', '2020-02-01 00:00:00', '2020-04-01 00:00:00', '1000.00'),
(3, 2, 'Установка сантехники, демонтаж и вынос старой кухни', '2020-11-30 00:00:00', NULL, '80000.00'),
(4, 2, 'Переделка пола (ламинат на паркет)', '2021-01-13 12:00:00', '2021-01-13 20:00:00', NULL),
(5, 2, 'Монтаж окон', '2021-02-02 00:00:00', NULL, '5155.55'),
(6, 3, 'Монтаж кухни', '2020-02-04 13:00:00', '2020-02-05 06:00:00', '14235.50'),
(7, 3, 'Вынос строительного мусора', '2020-02-05 00:00:00', '2020-02-06 00:00:00', '100.00'),
(8, 3, 'Поклейка обоев (5 стен)', '2021-01-01 15:33:10', '2021-01-14 20:15:00', '71233.00'),
(9, 3, 'Снос пристройки', '2021-01-30 00:00:00', NULL, '213123.00'),
(10, 2, 'Установка дверей входных (металл)', '2021-04-01 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `performer`
--

CREATE TABLE `performer` (
  `ID` int NOT NULL,
  `Order_id` int NOT NULL COMMENT 'Заказ',
  `Performer_id` int NOT NULL COMMENT 'Пользователь-исполнитель',
  `Appointment_date` datetime NOT NULL COMMENT 'Дата назначения исполнителя',
  `Cause` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Причина'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `ID` int NOT NULL,
  `Name` varchar(255) NOT NULL COMMENT 'Машинное имя роли',
  `Title` varchar(255) NOT NULL COMMENT 'Наименование роли'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Роли';

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`ID`, `Name`, `Title`) VALUES
(1, 'admin', 'Администратор'),
(2, 'customer', 'Заказчик'),
(3, 'contractor', 'Исполнитель');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `ID` int NOT NULL,
  `Fullname` varchar(1024) NOT NULL COMMENT 'ФИО',
  `Role_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи';

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`ID`, `Fullname`, `Role_id`) VALUES
(1, 'Админ', 1),
(2, 'Андреев Алексей Александрович', 2),
(3, 'Боев Борис Борисович', 2),
(4, 'Волейнов Владимир Владиславович', 3),
(5, 'Голубь Геннадий Григорьевич', 3),
(6, 'Долгих Денис Дмитриевич', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-Order-customer_id_idx` (`Customer_id`);

--
-- Индексы таблицы `performer`
--
ALTER TABLE `performer`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-User-role_id_idx` (`Role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `performer`
--
ALTER TABLE `performer`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk-Order-customer_id` FOREIGN KEY (`Customer_id`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk-User-role_id` FOREIGN KEY (`Role_id`) REFERENCES `role` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
