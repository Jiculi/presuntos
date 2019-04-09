--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `salary` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`id`, `name`, `age`, `salary`) VALUES
(1, 'Jone Thomas', 25, 320800),
(2, 'Tim Cook', 31, 170750),
(3, 'Martha Welington', 32, 86000),
(4, 'Kevin Julius', 33, 433060),
(5, 'Kim Holinshade', 34, 162700),
(6, 'Helen Margrate', 35, 372000),
(7, 'Greata Aurther', 36, 137500),
(104, 'Linda Karoline', 45, 200000),
(103, 'Evita Benjamin', 23, 100000),
(102, 'Mike Rosario', 45, 200000),
(101, 'Jelinda Joel', 23, 100000);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
COMMIT;
