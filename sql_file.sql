-- Table structure for table `tblcontactusinfo`

CREATE TABLE `tblcontactusinfo` (
  `id` int(11) NOT NULL,
  `Address` tinytext,
  `EmailId` varchar(255) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `tblcontactusinfo`

INSERT INTO `tblcontactusinfo` (`id`, `Address`, `EmailId`, `ContactNo`) VALUES
(1, 'New Asgard', 'john@gmail.com', '7525724672');

-- Table structure for table `tblcontactusquery`

CREATE TABLE `tblcontactusquery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `ContactNumber` char(11) DEFAULT NULL,
  `Message` longtext,
  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `tblpages`

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table `tblpages`

INSERT INTO `tblpages` (`id`, `PageName`, `type`, `detail`) VALUES
(1, 'Terms and Conditions', 'terms', ''),
(2, 'Privacy Policy', 'privacy', ''),
(3, 'About Us', 'aboutus', 'Hello World'),
(4, 'FAQs', 'faqs', 'Hello World');

-- Table structure for table `admin`

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `admin`

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'adminpasswordhash');

-- Table structure for table `tblbooking`

CREATE TABLE `tblbooking` (
  `id` int(11),
  `userEmail` varchar(100),
  `VehicleId` int(11),
  `FromDate` varchar(20),
  `ToDate` varchar(20),
  `message` varchar(255),
  `Status` int(11),
  `PostingDate` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `tblbrands`

CREATE TABLE `tblbrands` (
  `id` int(11),
  `BrandName` varchar(120),
  `CreationDate` timestamp DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `tblsubscribers`
--

CREATE TABLE `tblsubscribers` (
  `id` int(11) NOT NULL,
  `SubscriberEmail` varchar(120) DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `tbltestimonial`
--

CREATE TABLE `tbltestimonial` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `Testimonial` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `ContactNo` char(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indexes for dumped tables

-- Indexes for table `tblcontactusinfo`
ALTER TABLE `tblcontactusinfo`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tblcontactusquery`
ALTER TABLE `tblcontactusquery`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tblpages`
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `admin`
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tblbooking`
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tblbrands`
ALTER TABLE `tblbrands`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tblsubscribers`

ALTER TABLE `tblsubscribers`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `tbltestimonial`

ALTER TABLE `tbltestimonial`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `tblusers`

ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `tblcontactusinfo`
ALTER TABLE `tblcontactusinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT for table `tblcontactusquery`
ALTER TABLE `tblcontactusquery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `tblpages`
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

-- AUTO_INCREMENT for table `admin`
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT for table `tblbooking`
ALTER TABLE `tblbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `tblbrands`
ALTER TABLE `tblbrands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `tblsubscribers`
ALTER TABLE `tblsubscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `tbltestimonial`
ALTER TABLE `tbltestimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `tblusers`
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
