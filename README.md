# Senior-Superlatives
Program for seniors to vote on senior superlatives such as "Best Dressed" and "Most Likely to Move Away"

```SQL
--
-- Database: `yhscs_seniors`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question` varchar(255) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `STUDENT$`
--

CREATE TABLE `STUDENT$` (
  `ID` int(11) NOT NULL,
  `student_ID` varchar(7) NOT NULL,
  `name` text NOT NULL,
  `Most Athletic` int(11) NOT NULL,
  `Best Dressed` int(11) NOT NULL,
  `Most Likely to Star on Broadway` int(11) NOT NULL,
  `Most School Spirit` int(11) NOT NULL,
  `Most Likely to Leave and Never Come Back` int(11) NOT NULL,
  `Best Smile` int(11) NOT NULL,
  `Best Artist` int(11) NOT NULL,
  `Most Changed` int(11) NOT NULL,
  `Least Changed` int(11) NOT NULL,
  `Biggest Flirt` int(11) NOT NULL,
  `Class Clown` int(11) NOT NULL,
  `Most Likely to Cure a Disease` int(11) NOT NULL,
  `Best Musician` int(11) NOT NULL,
  `Best Hair` int(11) NOT NULL,
  `Super Snoozer` int(11) NOT NULL,
  `Most Likely to be Late to Graduation` int(11) NOT NULL,
  `Worst Driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_rights` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `STUDENT$`
--
ALTER TABLE `STUDENT$`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);
  ```
