-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2019 at 12:05 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--
CREATE DATABASE IF NOT EXISTS `restaurantdb` DEFAULT CHARACTER SET utf32 COLLATE utf32_general_ci;
USE `restaurantdb`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `lid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `city` varchar(15) NOT NULL,
  `street` int(15) NOT NULL,
  `building` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`lid`, `cid`, `city`, `street`, `building`) VALUES
(2, 2, 'A\'ali', 13, 82),
(3, 3, 'manama', 54, 783),
(4, 4, 'Naim', 32, 19),
(5, 5, 'Arad', 78, 46),
(6, 6, 'Riffa', 571, 1002),
(7, 7, 'Hoora', 96, 1039),
(8, 8, 'Mahooz', 79, 561),
(9, 9, 'manama', 36, 2),
(11, 2, 'zije', 92, 1009),
(13, 11, 'Torino', 35, 45),
(14, 9, 'naim', 76, 23);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `qid` int(10) NOT NULL,
  `type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`qid`, `type`) VALUES
(1, 'Pasta'),
(2, 'Salad'),
(3, 'Baking'),
(4, 'Curry'),
(5, 'Vegetable'),
(6, 'Soup'),
(7, 'Appetizer'),
(9, 'Grill'),
(10, 'Stew'),
(12, 'Sandwiches'),
(13, 'Dessert'),
(17, 'Drinks'),
(19, 'Meatballs'),
(22, 'Seafood'),
(25, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cnt_id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cnt_id`, `cid`, `tel`) VALUES
(2, 2, 32065493),
(3, 3, 39265012),
(4, 4, 33263153),
(5, 5, 34063255),
(6, 6, 34026987),
(7, 7, 34781254),
(8, 8, 37960135),
(9, 9, 37546798),
(10, 9, 39728761);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `Fname` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `profile_pic` varchar(20) NOT NULL DEFAULT 'account-image.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `username`, `Fname`, `Lname`, `password`, `Email`, `profile_pic`) VALUES
(2, 'Farrah43', 'Farrah', ' Bostock', '', 'Farrah43@mail.com', 'account-image.jpg'),
(3, 'Ammaarah22', 'Ammaarah', 'Martin', '', 'Ammaarah25@gmail.com', 'account-image.jpg'),
(4, 'Nela78', 'Nela', 'Lowe', '', 'Nela78@mail.com', 'account-image.jpg'),
(5, 'Kaylie78', 'Kaylie', 'Vaughan', '', 'Kaylie78@mail.com', 'account-image.jpg'),
(6, 'Colette47', 'Vang', 'Colette', '', 'Colette47@mail.com', 'account-image.jpg'),
(7, 'Sara72', 'Sara', 'Vazqueze', '', 'Sara78@gmail.com', 'account-image.jpg'),
(8, 'Jim112', 'Jim', 'Schwartz', '', 'Jim112@mail.com', 'account-image.jpg'),
(9, 'ebrahim12', 'ebrahim', 'nooh', 'b59c67bf196a4758191e42f76670ceba', 'ebrahim1243@mail.com', '9.jpg'),
(11, 'test12', 'test', 'test', 'b59c67bf196a4758191e42f76670ceba', 'test@gmail.com', '11.png');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `did` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `ct_id` int(10) NOT NULL DEFAULT '25',
  `price` float DEFAULT NULL,
  `rate` int(1) NOT NULL DEFAULT '1',
  `pic` varchar(100) NOT NULL DEFAULT 'assets/images/dish_def.jpg',
  `fid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`did`, `name`, `description`, `ct_id`, `price`, `rate`, `pic`, `fid`) VALUES
(0, 'Beetroot curry', '“If you\'ve never tried beets in a curry before, you\'re in for something special. Beetroot\'s sweet, e', 4, 3.2, 3, 'Beetroot curry.webp', NULL),
(1, 'Oysters Rockefeller', '“This famous entreé, probably the most popular oyster dish, has many versions. ”', 7, 1.25, 4, 'Oysters Rockefeller.webp', 4),
(2, 'Roasted razor clams', '“Be sure to wash these beforehand, or just leave them in a bucket of water for a few hours to get ri', 7, 2, 3, 'Roastedrazorclams.webp', NULL),
(3, 'Roasted spring veg with watercress dip', '“This peppery dip is a great way to enjoy your Favorited veg. ”', 7, 1.5, 2, 'Roasted spring veg with watercress dip.webp', NULL),
(4, 'Sloe gin gravlax', '“Instead of buying small packets of smoked or cured salmon, it’s more cost efficient to do it yourse', 7, 3.2, 5, 'Sloe gin gravlax.webp', 5),
(5, 'Fried stuffed olives', '“These delicious little bites are totally worth the effort – the perfect canapé with drinks, you can', 7, 1.7, 3, 'Friedstuffedolives.webp', NULL),
(6, 'Vegan winter rolls', '“Giving an established recipe a bit of a tweak is a fun thing to do - switch your fillings to match ', 7, 2.9, 4, 'Vegan winter rolls.webp', NULL),
(7, 'Black & blushing Worcestershire fillet', '“This is the most delicious barbecued beef I think I’ve ever had (even if I say so myself). Trust me', 9, 4.5, 5, 'Black & blushing Worcestershire fillet.webp', NULL),
(8, 'Chichinga suya goat kebabs', '“Suya is a popular West African streetfood snack known in Ghana as chichinga! Cool name, right? Suya', 9, 4.2, 3, 'Chichinga suya goat kebabs.webp', 4),
(9, 'Chilli chicken with pinto beans', '“Take barbecued chicken to another level with this adobo-style recado – a gorgeous marinade of smoky', 9, 3.6, 3, 'Chilli chicken with pinto beans.webp', 6),
(10, 'Griddled vegetables & feta with tabbouleh', '“This is a great meat-free recipe. Barbecuing a whole block of feta is a really interesting way to u', 9, 2.3, 2, 'Griddled vegetables & feta with tabbouleh.webp', NULL),
(11, 'Salt & pepper tofu skewers', '“If you’re using wooden skewers, make sure you soak them in water first, for at least half an hour, ', 9, 1.6, 3, 'Salt & pepper tofu skewers.webp', NULL),
(12, 'Baked Camembert', '“These are loads of fun to make, look pretty, taste great and normally everyone’s got a Camembert or', 3, 1.4, 1, 'Baked Camembert.webp', NULL),
(13, 'Cardamom clementine morning buns', '“An indulgent croissant-cinnamon bun hybrid, spiced with the season’s most fragrant citrus. Make the', 3, 2.4, 3, 'Cardamom clementine morning buns.webp', 5),
(14, 'Challah bread', '“Traditionally challah is braided lengthways but we’ve done a lovely round version, which is typical', 3, 0.9, 2, 'Challah bread.webp', NULL),
(15, 'Fluffy coconut breads', '“With minimal ingredients, this recipe couldn’t be easier, and the results are unreal. Puffed up and', 3, 0.5, 3, 'Fluffy coconut breads.webp', NULL),
(16, 'Saffron & hazelnut wreath', '“In Nordic countries, saffron buns are a typical Advent treat, often made as a wreath. If you don’t ', 3, 1.2, 4, 'Saffron & hazelnut wreath.webp', 5),
(17, 'Stuffed braided bread', '“These plaited loaves may look tricky, but just a couple of simple twists will give you impressive r', 3, 1.3, 4, 'Stuffed braided bread.webp', NULL),
(18, 'Stuffed focaccia', '“To this day, focaccia is still one of my favourite breads to bake. By stuffing it we get more textu', 3, 1, 2, 'Stuffed focaccia.webp', 6),
(19, 'Anzac biscuits', '“Celebrate Anzac Day with these Anzac biscuits – crisp on the outside and deliciously chewy in the m', 13, 1.3, 3, 'Anzac biscuits.webp', NULL),
(20, 'Devil\'s double choc malt cookies', '“I was very young when the realisation of the joy of the cookie hit me. I’ve never really met anyone', 13, 1.6, 3, 'Devil\'s double choc malt cookies.webp', NULL),
(21, 'Jool\'s easy oaty fruit cookies', '“A really delicious, simple, comforting cookie – porridge oats are a high-fibre carbohydrate, which ', 13, 1.25, 2, 'Jool\'s easy oaty fruit cookies.webp', NULL),
(22, 'Aubergine & tomato rogan josh', 'Just a handful of ingredients is all it takes to rustle up the most beautiful vegetable curry. All y', 4, 2.6, 3, 'Aubergine & tomato rogan josh.webp', 6),
(23, 'Stephen Mangan\'s Sri Lankan fish curry', '“Cricket super-fan and actor Stephen Mangan’s love of the game has seen him journey to far-flung cor', 4, 2.3, 4, 'Stephen Mangan\'s Sri Lankan fish curry.webp', NULL),
(24, 'Harry Hill\'s vegetarian thali', '“If you can’t choose when it comes to curry, you’re going to love this gorgeous thali made up of thr', 4, 2.4, 5, 'Harry Hill\'s vegetarian thali.webp', NULL),
(25, 'Joanna Lumley\'s aubergine kuzi', '“Joanna has very fond memories of her childhood, much of which was spent travelling, as her father s', 4, 2.1, 3, 'Joanna Lumley\'s aubergine kuzi.webp', NULL),
(26, 'Jodie Whittaker\'s massaman curry', '“Inspired by her teenage travels to Thailand, Jodie’s rich, hearty aromatic beef curry is what weeke', 4, 2.8, 2, 'Jodie Whittaker\'s massaman curry.webp', NULL),
(27, 'Russell Howard\'s chicken & prawn curry', '“When comedian Russell Howard first ate this dish at Longrain restaurant in Sydney, it blew his mind', 4, 2.3, 1, 'Russell Howard\'s chicken & prawn curry.webp', NULL),
(28, 'smoothies & ice lollies', '“These are two of my favourite recipes, but feel free to have fun experimenting with different flavo', 17, 1, 4, 'smoothies & ice lollies.webp', NULL),
(29, 'Mango lassi', '“This Indian drink is like a mango milkshake and it’s delicious. Great for cooling your tongue when ', 17, 0.6, 2, 'Mango lassi.webp', NULL),
(30, 'Blood orange mimosa', '“A simple twist on that party classic – blood orange gives it a fantastic colour and deeper flavour ', 17, 1.2, 2, 'Blood orange mimosa.webp', NULL),
(31, 'Strawberry slushie', '“Give this super-simple and delicious slushie a try – without all the added sugar and junk of a shop', 17, 0.9, 3, 'Strawberry slushie.webp', NULL),
(32, 'Kiwi fruit, ginger and banana smoothie', '“Fruit smoothies make a really nutritious breakfast for kids and grown-ups alike ”\r\n', 17, 1.3, 5, 'Kiwi fruit, ginger and banana smoothie.webp', 9),
(33, 'The best hot chocolate', '“This classic way to make a mean hot chocolate is a totally delicious winter warmer ”\r\n', 17, 0.5, 5, 'The best hot chocolate.webp', NULL),
(34, 'Almond banana passion fruit smoothiee', 'Deliciously creamy, this quick and easy smoothie makes a delicious, fuss-free breakfast or snack\r\n', 17, 1.4, 4, 'Almond, banana & passion fruit smoothie.webp', NULL),
(35, 'Chilli con carne meatballs', '“Meatballs are fantastic! Making your own is not only easy, but it’s a great way of controlling what', 19, 3.3, 4, 'Chilli con carne meatballs.webp', NULL),
(36, 'Mega meatball sub', '“This gorgeous comfort food dish is super-easy to put together and delivers big on the flavour front', 19, 2.9, 5, 'Mega meatball sub.webp', NULL),
(37, 'Meatballs & pasta', '“This really easy beef and pork meatball recipe with simple tomato sauce delivers big on flavour – a', 19, 2.4, 3, 'Meatballs & pasta.webp', NULL),
(38, 'sausage meatballs', '“Using really good sausage and adding the peas at the last minute totally make these meatballs ”\r\n', 19, 4, 5, 'sausage meatballs.webp', NULL),
(39, 'Meatballs', '“These smashing beef and pork meatballs are easy to make and healthy, too. ”\r\n', 19, 2.3, 2, 'Meatballs.webp', NULL),
(40, 'Sicilian Meatballs Al Forno', '“Making meatballs from scratch is a great way of using under-loved, cheap cuts of meat, plus you kno', 19, 3.5, 1, 'Sicilian Meatballs Al Forno.webp', NULL),
(41, 'Butternut squash muffins with a frosty top', 'These muffins are a great way to get the kids eating squash and taste absolutely delicious \r\n', 13, 1.7, 4, 'Butternut squash muffins with a frosty top.webp', NULL),
(42, 'Dairy-free apple muffins', '“Whether it’s breakfast muffins you’re after, or an afternoon snack, this recipe is just the ticket.', 13, 1.8, 1, 'Dairy-free apple muffins.webp', NULL),
(43, 'Gluten-free cottage cheese muffins', '“Savoury muffins are amazing things, and this recipe is light and moreish, with that lovely sweet hi', 13, 2, 5, 'Gluten-free cottage cheese muffins.webp', NULL),
(44, 'Mother\'s Day rhubarb and ginger muffins', '“If you can resist gobbling up all these rhubarb muffins yourself, they make a great pressie ”\r\n', 13, 1.4, 3, 'Mother\'s Day rhubarb and ginger muffins.webp', NULL),
(45, 'Seafood risotto', '“Perfect for the weekend, this amazing risotto will blow everyone away. Slow-roasting the tomatoes t', 1, 2.4, 3, 'Seafood risotto.webp', NULL),
(46, 'Romesh Ranganathan\'s epic veg lasagne', '“I created this beautiful dish especially for Romesh Ranganathan to make all his lasagne dreams come', 1, 3.6, 5, 'Romesh Ranganathan\'s epic veg lasagne.webp', NULL),
(47, 'Danny Devito\'s family pasta', '“Simple, beautiful and rustic, this dish originates from San Fele in the Basilicata region of southe', 1, 1.6, 2, 'Danny Devito\'s family pasta.webp', NULL),
(48, 'Amazing ravioli', '“For me, this is both a pleasure to eat and a ritual to embrace – surrounding a wonderful filling wi', 1, 2.2, 1, 'Amazing ravioli.webp', 4),
(49, 'Summer veg lasagne', '“This is a brilliant dish for days when you want comfort food, but with a bit of zing. It’s packed w', 1, 3, 2, 'Summer veg lasagne.webp', NULL),
(55, 'Daisy\'s macaroni cheese', '“Macaroni cheese is a favourite comfort food for lots of people, and this version is inspired by Dai', 3, 3.7, 5, 'Daisy\'s macaroni cheese.webp', NULL),
(56, 'Carbonara cake', '“This is a delightfully simple, luxurious, yet slightly trashy meal that is sure to wow everyone. It', 3, 3.2, 4, 'Carbonara cake.webp', NULL),
(57, 'Sausage pasta bake', '“The beauty of this dish is you can freeze any leftovers, ready for another day when you’re short on', 3, 2.8, 4, 'Sausage pasta bake.webp', NULL),
(58, 'Veal ragu cannelloni', '“This is cannelloni, but not like you’ve seen it before! Good British rose veal is a really smart an', 3, 1.9, 3, 'Veal ragu cannelloni.webp', 11),
(59, 'Stephen Fry apple pie', '“Stephen Fry’s perfectly English nostalgic treat is a joy to make and eat, with the sweet, buttery s', 3, 2.1, 3, 'Stephen Fry apple pie.webp', NULL),
(60, 'Spinach & feta filo pie', '“This cheesy, flaky pie makes a cracking weekend lunch. Serve with a selection of salads and flatbre', 3, 2.6, 3, 'Spinach & feta filo pie.webp', NULL),
(61, 'Warwick Davis\' steak & Stilton pie', '“In my mind, a pie like this with melt-in-the mouth crumbly pastry on the top, sides and bottom imme', 3, 3.6, 5, 'Warwick Davis\' steak & Stilton pie.webp', NULL),
(62, 'Salmon en croute', '“I couldn’t resist the opportunity to go a bit retro and include my version of salmon en croûte her', 3, 2.9, 2, 'Salmon en croute.webp', NULL),
(63, 'Lindsay Lohan\'s chicken pot pie', '“Comforting and easy to knock together, this crowd-pleasing chicken pie is jam-packed full of flavou', 3, 1.9, 3, 'Lindsay Lohan\'s chicken pot pie.webp', NULL),
(64, 'Pizza fritta', '“Pizza fritta is one of the oldest forms of pizza, the classic street food of Naples, where it was e', 3, 1.7, 4, 'Pizza fritta.webp', NULL),
(65, 'Gluten-free Spring flatbread pizzas', '“Xantham gum is used to stop the pizza base from crumbling in this light, springtime gluten-free rec', 3, 2.6, 5, 'Gluten-free Spring flatbread pizzas.webp', NULL),
(66, 'Deep-pan pizza', '“This classic American recipe with a killer crusty base and beautiful meaty toppings makes the perfe', 3, 1.6, 3, 'Deep-pan pizza.webp', NULL),
(67, 'Gluten-free pizza', '“Thin, crisp and delicious – gluten-free pizza never tasted so good! ”\r\n', 3, 2.4, 5, 'Gluten-free pizza.webp', NULL),
(68, 'Wood-fired pizza', '“Homemade pizza dough makes all the difference – topped with sausage meatballs, broccoli and fennel,', 3, 1.3, 2, 'Wood-fired pizza.webp', NULL),
(69, 'Basic pizza', 'Trust me, once you see how simple and tasty this pizza dough recipe is you won\'t want takeaways \r\n', 3, 2.9, 3, 'Basic pizza.webp', NULL),
(70, 'Chocolate brownie', '“Who doesn’t love a beautiful, delicious chocolate brownie? This one is simply made with quality ing', 13, 2.4, 5, 'Chocolate brownie.webp', NULL),
(71, 'Chocolate clementine torte', '“It wouldn’t be Christmas without an amazing chocolate dessert and this one – inspired by the River ', 13, 1.2, 3, 'Chocolate clementine torte.webp', NULL),
(72, 'Grilled strawberries with Pimm\'s', '“Grilling fruit is a really easy way to bring out a wicked caramelly flavour, and it’s also a lovely', 13, 2.4, 2, 'Grilled strawberries with Pimm\'s.webp', NULL),
(73, 'Rolled cassata', '“The Arabic influence in Sicilian desserts really sings out in this cassata of silky smooth ricotta ', 13, 3.2, 5, 'Rolled cassata.webp', NULL),
(74, 'Tiramisu', '“This is my Christmas take on the undeniably decadent yet simple, classic Italian dessert of tiramis', 13, 3.4, 5, 'Tiramisu.webp', NULL),
(75, 'Toffee apple tart', '“This is a fantastic dessert that I love to make for friends and family as they can’t get enough of ', 13, 2.8, 3, 'Toffee apple tart.webp', NULL),
(76, 'Fillet of beef', '“In this wonderfully extravagant showstopper the earthy porcini go hand-in-hand with the garlic, thy', 9, 2.6, 4, 'Fillet of beef.webp', NULL),
(77, 'Roasted salmon & artichokes', '“I want to show you what an incredible showstopper whole sides of salmon can make. So, next time you', 9, 5.3, 5, 'Roasted salmon & artichokes.webp', NULL),
(78, 'Best roast potatoes', '“Simple as roast potatoes are, there’s a handful of tiny, but important, details – picked up through', 9, 4.3, 4, 'Best roast potatoes.webp', 9),
(79, 'Asian salmon and sweet potato traybake', 'ï¿½Bursting with fresh Asian flavours, this easy salmon traybake can be on the table in well under a', 9, 6.7, 3, 'Asian salmon & sweet potato traybake.webp', NULL),
(80, 'Gunpowder lamb', '“The small investment in time you make to blend the perfect combo for the gunpowder spice paste is t', 9, 3.6, 2, 'Gunpowder lamb.webp', NULL),
(81, 'perfect roast chicken', '“I cook this every week and I always try to do something different with it. Basically what I do is c', 9, 6.4, 5, 'perfect roast chicken.webp', NULL),
(82, 'Grilled chicken with charred pineapple salad', '“This super-healthy recipe heroes the gluten-free grain, quinoa, which is full of all-important prot', 2, 1.3, 5, 'Grilled chicken with charred pineapple salad.webp', NULL),
(83, 'Ultimate roast chicken Caesar salad', '“Take your chicken Caesar salad to the absolute next level by brining the chicken overnight in fresh', 2, 2.6, 5, 'Ultimate roast chicken Caesar salad.webp', NULL),
(84, 'Italian spring bean salad', '“I like to keep leftover cheese rinds in the fridge until I have enough to make a big batch of this ', 2, 1.4, 3, 'Italian spring bean salad.webp', NULL),
(85, 'Warm winter salad', '“This simple salad has lots of nuttiness and zing, plus it’s filling enough for lunch or dinner on a', 2, 1.9, 1, 'Warm winter salad.webp', NULL),
(86, 'Beetroot, carrot & orange salad', '“If you’re looking for a salad you can make all the time, this is the one. It’s great with everythin', 2, 1.4, 3, 'Beetroot, carrot & orange salad.webp', NULL),
(87, 'Hearts of palm & chicken chopped salad', '“This lovely salad layers up honey-glazed chicken breast with beautiful textures, such as crunchy to', 2, 1.2, 5, 'Hearts of palm & chicken chopped salad.webp', NULL),
(88, 'Simple green salad with lemon dressing', '“If you use lovely fresh leaves and dress them properly, even the most basic salad like this one wil', 2, 0.5, 1, 'Simple green salad with lemon dressing.webp', NULL),
(89, 'Mini super-fruit breakfast wraps', '“This brilliantly quick recipe is easy to make in the morning before school, and will fuel your body', 12, 1.6, 1, 'Mini super-fruit breakfast wraps.webp', NULL),
(90, 'Oyster po\'boy', '“A po’ boy is a classic New Orleans sandwich, traditionally deep-fried meat or seafood in a fresh, c', 12, 1.9, 5, 'Oyster po\'boy.webp', NULL),
(91, 'Spicy corn & chickpea burgers', '“Packed with spices, herbs and a hit of lemon zest, these vegan burgers ensure you get all the joy o', 12, 1.3, 3, 'Spicy corn & chickpea burgers.webp', NULL),
(92, 'Cracking chicken burrito', '“This chicken burrito recipe is a Mexican classic and a really tasty way of using up leftover rice, ', 12, 2.3, 5, 'Cracking chicken burrito.webp', NULL),
(93, 'Next-level steak & onion sandwich', '“Focusing on awesome, sweet onions seriously takes the joy of a steak sandwich up a notch. ”\r\n', 12, 1.5, 4, 'Next-level steak & onion sandwich.webp', NULL),
(94, 'Rainbow salad wrap', '“This is colourful, seriously tasty and fun to make. Feel free to use other firm fruit and vegetable', 12, 0.7, 1, 'Rainbow salad wrap.webp', NULL),
(95, 'Amba sauce', '“Take your kibbeh to the next level with this quick and easy sauce that I just love. It’s fresh and ', 7, 1, 3, 'Amba sauce.webp', NULL),
(96, 'Hero tomato sauce', '“By using top-quality tinned cherry tomatoes, which have a wonderful natural sweetness, you’re able ', 7, 0.5, 2, 'Hero tomato sauce.webp', NULL),
(97, 'Garlic aioli', '“It’s a joy to partake in the ritual of making a good aïoli. The process has broken many a cook – n', 7, 1.2, 4, 'Garlic aioli.webp', NULL),
(98, 'Coriander & mint chutney', '“This super-fresh chutney is really quick and easy to make and instantly adds flavour, colour and fr', 7, 1, 5, 'Coriander & mint chutney.webp', NULL),
(99, 'Sriracha', '“Commercial versions of this fiery chilli sauce are found on tables across Thailand. We like it with', 7, 0.4, 3, 'Sriracha.webp', NULL),
(100, 'Chicken & tofu noodle soup', '“Fragrant and colourful, this old favourite gets a reboot. If you have time, prepare it a day ahead ', 6, 1.6, 3, 'Chicken & tofu noodle soup.webp', NULL),
(101, 'Chicken & black bean chowder', '“Black beans are a staple of South American cuisine, whether cooked up with rice or in a feijoada (a', 6, 1.9, 4, 'Chicken & black bean chowder.webp', NULL),
(102, 'Miso soup with tofu & cabbage', '“Super-quick, healthy and full of flavour, this beautiful bowl of punchy broth will definitely warm ', 6, 1.3, 5, 'Miso soup with tofu & cabbage.webp', NULL),
(103, 'Tortellini in brodo', '“This is one of Emilia-Romagna’s typical dishes. It’s not the classic version (with pork loin, one e', 6, 1.7, 3, 'Tortellini in brodo.webp', NULL),
(104, 'Simple noodle soup', '“This easy-to-make dish is the ultimate midweek comfort food, and full of fragrant Asian flavours ”\r', 6, 1, 2, 'Simple noodle soup.webp', NULL),
(105, 'Fish in crazy water', '“I’m excited to share this fantastic method that shows just how easy it can be to cook whole fish, o', 22, 2.6, 3, 'Fish in crazy water.webp', NULL),
(106, 'Mushroom bourguignon', '“Beautiful meaty mushrooms make this a wonderful veggie alternative to a classic stew – it’s lovely ', 5, 2.3, 3, 'Mushroom bourguignon.webp', NULL),
(107, 'Simon Pegg\'s lamb tagine', '“Inspired by Simon\'s time spent on location in Marrakech, I’ve created this beautiful lamb tagine to', 10, 3.7, 2, 'Simon Pegg\'s lamb tagine.webp', NULL),
(108, 'Summer fish stew', '“A wonderfully luxurious meal, this colourful one-pot wonder celebrates fish and seafood with flavou', 22, 3.7, 5, 'Summer fish stew.webp', NULL),
(109, 'Spring chicken & citrus stew', '“This is a brilliant transitional dish. You’ve got the stew element, which is warming, comforting an', 10, 4.8, 5, 'Spring chicken & citrus stew.webp', NULL),
(110, 'Ham & peas', '“I love the combination of ham and peas. Ham hocks are fantastic value, and cooking them on the bone', 10, 3.9, 3, 'Ham & peas.webp', NULL),
(111, 'Chorizo & pear red cabbage', '“My darkly decadent red cabbage is truly delicious with bold flavours that people are going to go nu', 5, 3.4, 3, 'Chorizo & pear red cabbage.webp', NULL),
(112, 'Creamed spinach', '“Frozen spinach is not only cheap and convenient, it seems to work much better than fresh in this di', 5, 2.6, 5, 'Creamed spinach.webp', NULL),
(113, 'Parsnip beetroot gratin', '“A lovely side for a Sunday roast – veggies baked with fresh rosemary and garlic, and livened up wit', 5, 1.3, 2, 'Parsnip beetroot gratin.webp', NULL),
(114, 'Wilted spinach with yoghurt & raisins', '“This quick and easy side dish is a real delight. Frozen spinach is suggested here as it is more eco', 5, 1.4, 2, 'Wilted spinach with yoghurt & raisins.webp', NULL),
(115, 'Roasted root veg', '“We all have our favourite way to roast veg, but this method is a mega time and space saver. For max', 5, 1.7, 4, 'Roasted root veg.webp', NULL),
(120, 'test23', 'wd', 2, 234, 1, 'test23.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `fid` int(10) NOT NULL,
  `offer` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`fid`, `offer`) VALUES
(4, 50),
(5, 25),
(6, 65),
(9, 39),
(11, 15);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `oid` int(10) NOT NULL,
  `did` int(10) NOT NULL,
  `qty` int(10) DEFAULT NULL,
  `unitPrice` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`oid`, `did`, `qty`, `unitPrice`) VALUES
(22, 101, 2, 1.9),
(25, 56, 1, 3.2),
(26, 18, 1, 1),
(26, 95, 1, 1),
(27, 30, 1, 1.2),
(28, 4, 1, 2.4),
(30, 24, 3, 2.4),
(30, 100, 3, 1.6);

-- --------------------------------------------------------

--
-- Table structure for table `ordering`
--

CREATE TABLE `ordering` (
  `oid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `pid` int(10) NOT NULL,
  `total` float NOT NULL,
  `location` int(11) NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'C'
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `ordering`
--

INSERT INTO `ordering` (`oid`, `cid`, `date`, `pid`, `total`, `location`, `state`) VALUES
(22, 9, '2019-04-30 00:00:00', 1, 3.8, 9, 'F'),
(25, 9, '2019-04-30 00:00:00', 3, 3.2, 9, 'F'),
(26, 9, '2019-05-02 17:38:12', 1, 2, 9, 'D'),
(27, 9, '2019-05-05 22:14:11', 1, 1.2, 9, 'F'),
(28, 9, '2019-05-23 00:11:02', 2, 2.4, 9, 'F'),
(30, 9, '2019-05-24 19:16:39', 2, 12, 9, 'C'),
(33, 2, '2019-05-10 00:00:00', 1, 34, 2, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pid` int(10) NOT NULL,
  `type` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pid`, `type`) VALUES
(1, 'Cash'),
(2, 'Debit card'),
(3, 'Credit card');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rid` int(10) NOT NULL,
  `did` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `rate` int(1) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rid`, `did`, `cid`, `rate`, `comment`) VALUES
(1, 12, 8, 5, 'nice'),
(2, 9, 9, 2, 'good'),
(3, 12, 9, 3, 'vary nice i love it');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `R_id` int(10) NOT NULL,
  `rateID` int(10) NOT NULL,
  `reply` text NOT NULL,
  `sid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`R_id`, `rateID`, `reply`, `sid`) VALUES
(12, 1, 'good', 1),
(16, 1, 'wooow', 4);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `sid` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `Fname` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `type` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`sid`, `username`, `Fname`, `Lname`, `password`, `type`) VALUES
(1, 'ali1235', 'ali', 'nooh', '934b535800b1cba8f96a5d72f72f1611', 'C'),
(2, 'Helena78', 'Helena', 'Spence', '', 'C'),
(3, 'Mohammed475', 'Mohammed', 'Ali', '', 'D'),
(4, 'admin', 'Ebrahim', 'Nooh', '21232f297a57a5a743894a0e4a801fc3', 'A'),
(6, 'Lorraine319', 'Lorraine', 'Correa', '', 'C'),
(7, 'Ahmad462', 'Ahmed', 'Ali', '', 'A'),
(8, 'Oisin012', 'Oisin', 'Ochoa', '', 'C'),
(9, 'Amal364', 'Amal', 'Grant', '', 'C'),
(10, 'nooh12', 'Phillipa', 'Oneill', '2be9bd7a3434f7038ca27d1918de58bd', 'D'),
(11, 'Ahmad102', 'Ahmad', 'Hassan', '', 'A'),
(15, 'Noor32', 'Noor', 'Ali', '', 'C'),
(16, 'Adelina345', 'Adelina ', 'Morley', '', 'D'),
(18, 'Alexandria32', 'Alexandria', 'Meyers', '', 'C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`lid`,`cid`,`city`,`street`,`building`),
  ADD KEY `c_l_f` (`cid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cnt_id`),
  ADD KEY `cc_f` (`cid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`did`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `cat_f` (`ct_id`),
  ADD KEY `off_f` (`fid`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`oid`,`did`),
  ADD KEY `d_f` (`did`);

--
-- Indexes for table `ordering`
--
ALTER TABLE `ordering`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `pid_f` (`pid`),
  ADD KEY `cid_f` (`cid`),
  ADD KEY `loc_f` (`location`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `c_r_f` (`cid`),
  ADD KEY `d_r_f` (`did`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`R_id`),
  ADD KEY `s_re_f` (`sid`),
  ADD KEY `rate_f` (`rateID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `lid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `qid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cnt_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `did` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `fid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ordering`
--
ALTER TABLE `ordering`
  MODIFY `oid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `R_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `sid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `c_l_f` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `cc_f` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`);

--
-- Constraints for table `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `cat_f` FOREIGN KEY (`ct_id`) REFERENCES `category` (`qid`),
  ADD CONSTRAINT `off_f` FOREIGN KEY (`fid`) REFERENCES `offer` (`fid`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `d_f` FOREIGN KEY (`did`) REFERENCES `dish` (`did`),
  ADD CONSTRAINT `order_f` FOREIGN KEY (`oid`) REFERENCES `ordering` (`oid`);

--
-- Constraints for table `ordering`
--
ALTER TABLE `ordering`
  ADD CONSTRAINT `cid_f` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`),
  ADD CONSTRAINT `loc_f` FOREIGN KEY (`location`) REFERENCES `address` (`lid`),
  ADD CONSTRAINT `pid_f` FOREIGN KEY (`pid`) REFERENCES `payment` (`pid`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `c_r_f` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`),
  ADD CONSTRAINT `d_r_f` FOREIGN KEY (`did`) REFERENCES `dish` (`did`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `rate_f` FOREIGN KEY (`rateID`) REFERENCES `rate` (`rid`),
  ADD CONSTRAINT `s_re_f` FOREIGN KEY (`sid`) REFERENCES `staff` (`sid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
