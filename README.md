# Senior-Superlatives
A web app for students to vote on senior superlatives such as "Best Dressed" and "Most Likely to Leave."

MySQL database tables:

```SQL
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
  `Worst Driver` int(11) NOT NULL,
  `Most Likely to be a Pro Athlete` int(11) NOT NULL,
  `Biggest Teddy Bear` int(11) NOT NULL,
  `Most Sarcastic` int(11) NOT NULL,
  `Most Likely to Host Their Own Talk Show` int(11) NOT NULL,
  `Most Likely to run for President` int(11) NOT NULL,
  `Fox Pride--Classmate with the best Character` int(11) NOT NULL,
  `Most Likely to be Staring at your Phone` int(11) NOT NULL,
  `Yorkville's Fashion Icon (Best Dressed)` int(11) NOT NULL,
  `The Next Picasso (Best Artist)` int(11) NOT NULL,
  `You can hear them from ANYWHERE (loudest)` int(11) NOT NULL,
  `They have the best Gossip` int(11) NOT NULL,
  `Least Likely to leave Yorkville` int(11) NOT NULL,
  `Most Likely to start their own Band (best musician)` int(11) NOT NULL,
  `Most Likely to Leave Yorkville and Never Come Back` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_rights` tinyint(1) NOT NULL,
  `Voted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id_ai` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id` (`id`,`username`,`password`(255),`salt`,`email`,`admin_rights`,`Voted`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id_ai`),
  ADD KEY `category` (`category`);

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `STUDENT$`
--
ALTER TABLE `STUDENT$`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id_ai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  ```
