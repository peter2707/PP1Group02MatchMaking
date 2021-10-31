-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2021 at 04:47 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobmatch`
--
DROP DATABASE IF EXISTS jobmatch;
CREATE DATABASE jobmatch;
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`) VALUES
(1, 'Zak', 'Brown', 'admin', 'admin', '2021-09-14', 1231231, 'admin@gmail.com', 'Admin'),
(6, 'Barry', 'Allen', 'Barry001', 'Barry001', '2021-10-06', 123456789, 'barry001@gmail.com', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `position` text NOT NULL,
  `company` text NOT NULL,
  `experience` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `institution` text NOT NULL,
  `degree` text NOT NULL,
  `graduation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL,
  `location` text NOT NULL,
  `rating` double(2,1) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `location`, `rating`, `image`) VALUES
(5, 'Jane', 'Doe', 'JaneDoe123', 'JaneDoe123', '2021-10-06', '1231231', 'janedoe123@gmail.com', 'CEO', 'Queensland', NULL, NULL),
(7, 'Mark', 'Zuckerberg', 'Mark123', 'Mark123', '2021-10-06', '123123123', 'mark123@gmail.com', 'CEO Facebook', 'South Australia', NULL, NULL),
(8, 'Elon', 'Musk', 'Elonmusk123', 'Elonmusk123', '2021-09-29', '123123123', 'elonmusk123@gmail.com', 'CEO Tesla', 'New South Wales', NULL, NULL),
(9, 'Bill', 'Gates', 'Billgate123', 'Billgate123', '2021-10-14', '1231231', 'billgate123@gmail.com', 'CEO Microsoft', 'Australian Capital Territory', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobmatch`
--

CREATE TABLE `jobmatch` (
  `id` int(11) NOT NULL,
  `employer` text NOT NULL,
  `jobSeeker` text NOT NULL,
  `jobPostID` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobmatch`
--

INSERT INTO `jobmatch` (`id`, `employer`, `jobSeeker`, `jobPostID`, `percentage`, `rating`, `feedback`, `date`) VALUES
(20, 'JaneDoe123', 'Peter2707', 9, 75, NULL, NULL, '2021-10-31 02:22:26'),
(25, 'JaneDoe123', 'Sokleng123', 9, 75, NULL, NULL, '2021-10-31 02:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `id` int(11) NOT NULL,
  `position` text NOT NULL,
  `field` text NOT NULL,
  `salary` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` text NOT NULL,
  `employer` text NOT NULL,
  `contact` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobpost`
--

INSERT INTO `jobpost` (`id`, `position`, `field`, `salary`, `type`, `description`, `requirements`, `location`, `employer`, `contact`, `date`) VALUES
(8, 'Accountant', 'Accounting', '$40-$45/hr', 'Part Time', '<p>JaneDoe123</p>', '<p>JaneDoe123</p>', 'Queensland', 'JaneDoe123', 'JaneDoe123@gmail.com', '2021-10-28 10:02:11'),
(9, 'Data Analyst', 'Accounting', '$25-$30/hr', 'Full Time', '<p><strong>About Us</strong></p><p>LaunchVic is Victoria&rsquo;s startup agency. We were established by the Victorian Government in March 2016 as an independent agency responsible for growing the State&rsquo;s startup ecosystem to strengthen our economy and create the jobs of the future.</p><p>Through our work we are driving improvements in the startup investment landscape; developing the angel investor and early-stage venture capital market in Victoria; supporting programs that build founder, investor, and talent capabilities; and increasing understanding and awareness of Victoria&rsquo;s startup ecosystem.</p><p><strong>About the role</strong></p><p>Reporting to the Marketing Campaign Manager, the Data Analyst will coordinate LaunchVic&rsquo;s data and analytics activities as part of our marketing and events program.&nbsp;</p><p>The Data Analyst will administer our all data platforms and database, and provide the right analysis and insights to inform and influence key stakeholders (e.g. &nbsp;founders, investors, startup talent, government, board, etc).</p><p>This role is hands-on with daily collaboration across all parts of LaunchVic.</p>', '<p><strong>Key Responsibilities&nbsp;</strong></p><ul><li>Assist in the development and implementation of a business-wide CRM strategy to support marketing outcomes.</li><li>Administer LaunchVic&rsquo;s existing data platforms, including Salesforce CRM, Dealroom and Google Analytics.</li><li>Ensure LaunchVic&rsquo;s data taxonomy and architecture is configured for accurate data capture and reporting.</li><li>Build and test data segmentations to activate marketing campaigns.</li><li>Maintain data integrity, cleanliness, and completeness across all data platforms.</li><li>Support business planning and strategy through analysis of marketing data, campaign insights and industry metrics for internal and external reports.</li><li>Coordinate database management for direct marketing campaigns and marketing automation.</li><li>Measure and report on campaign performance in Google Analytics.</li><li>Collaborate closely with all business units at LaunchVic for all CRM activities.</li><li>Use Salesforce and DataStudio reports to improve business intelligence and reporting.</li><li>Supporting the Marketing Campaign Manager to select and curate marketing target lists.</li><li>Maintain and develop all technical documents.</li><li>Producing post campaign analysis and ongoing reporting of marketing activity.</li></ul><p><strong>Skills and&nbsp;Qualifications&nbsp;&nbsp;</strong></p><ul><li>Relevant experience administering CRM systems (for example, Salesforce Service Cloud, Microsoft Dynamics CRM, HubSpot etc)</li><li>Relevant experience administering Google Analytics.</li><li>Influential communication and presentation skills.</li><li>Demonstrated experience delivering data-related projects with multiple internal and external stakeholders, vendors, and agencies.</li><li>Experience delivering accurate and timely reports, both manual and automated.</li><li>Developing analytics reports using advanced data skills including Excel, SQL, Salesforce reporting suite or DataStudio.</li><li>Experience supporting automated email marketing programs and platforms (for example, Salesforce Marketing Cloud, Klaviyo. Emarsys etc)</li><li>Familiarity with content management systems (CMS).</li><li>Basic HTML skills.</li></ul>', 'Victoria', 'JaneDoe123', 'janedoe@gmail.com', '2021-10-31 01:32:40'),
(10, 'Finance Manager', 'Administration', '$25-$30/hr', 'Casual', '<p><strong>About us</strong></p><p>Investigator College is a world-class ELC to Year 12 co-educational Anglican College, located in beautiful Victor Harbor, south of Adelaide. Currently with approximately 700 students, the College has a reputation for academic excellence, outstanding wellbeing and service programs, broad subject offerings and strong community engagement. The College also boasts an Eco Sustainability Trade Skills Centre on the banks of Currency Creek.</p><p>Applications close at 9:00am on Monday 15 November</p><p>Applications must&nbsp;include the names and contact details of a minimum of two&nbsp;professional referees.</p>', '<p><strong>Your Responsibilities</strong><br /><br />The Finance Manager is responsible for providing high quality finance support to the College.&nbsp;</p><ul><li>This includes the management and oversight of the College&rsquo;s daily accounting functions, end of month processes and annual reporting requirements.</li><li>Responsibility for the Finance, Payroll, Student Services &amp; Property/Grounds functions</li></ul><p><strong>Key personal attributes</strong></p><ul><li>Strong interpersonal skills, including an open and friendly disposition, the ability to listen effectively and the ability to relate to a range of sensitive issues and maintain confidentiality</li><li>High levels of written skills and accuracy, with an ability to write and/or develop presentations, reports, policies and procedures</li><li>Superior organisational ability and demonstrated self-motivation and initiative in setting goals, prioritising work, managing multiple tasks and attention to detail</li><li>The ability to manage high workload levels, multi-task and meet deadlines within specified time frames</li><li>Demonstrated ability to develop positive working relationships&nbsp;</li></ul><p>You will require a Working with children check or be willing to obtain one if successful.</p><p>A Position Description is available on the College website&nbsp; investigator.sa.edu.au/the-college/employment/</p><p>Please contact Business Manager Mark McLaren via email at&nbsp;<a href=\"mailto:mmclaren@investigator.sa.edu.au\">mmclaren@investigator.sa.edu.au</a>&nbsp;for further information.</p><p>Please also ensure that all applications are submitted through the SEEK &lsquo;Apply now&rsquo; process.</p>', 'Australian Capital Territory', 'JaneDoe123', 'janedoe@gmail.com', '2021-10-31 01:33:38'),
(11, 'General Manager - Clinical Services', 'Banking & Financial Services', '$25-$30/hr', 'Contract', '<p>Now here is a career defining and multi-faceted opportunity.&nbsp;</p><p><strong>An opportunity</strong>&nbsp;to join the leadership team of this world-class sports, Physiotherapy &amp; Exercise&nbsp;Medicine&nbsp;Clinic. &nbsp;</p><p><strong>An opportunity</strong>&nbsp;to be a trusted advisor and strategic thought partner to the Clinic Director and Executive Team</p><p><strong>An opportunity</strong>&nbsp;to be accountable for a culture of outstanding client service and&nbsp;the strategic, operational, financial, marketing, human and physical resources.&nbsp;&nbsp;</p><p><strong>An opportunity</strong>&nbsp;to blend daily leadership and influence, and business collaboration and growth</p><p><strong>An opportunity</strong>&nbsp;to bring fresh eyes to this icon and proud legacy.&nbsp;</p><p><strong>An opportunity</strong>&nbsp;to develop and grow a team aligned with your objectives.</p><p><strong>About the role:&nbsp;</strong></p><p>Working closely with the Clinic Director and a tight knit team:</p><ul><li><strong>Lead&nbsp;</strong>overall service levels, staff management and engagement, business development, financial performance and marketing strategies.</li><li><strong>Develop</strong>&nbsp;constructive, collaborative relationships within the Executive, Business Management and Practice Management Teams.</li><li><strong>Support</strong>&nbsp;operational systems, processes and policies in support of Clinic&rsquo;s strategic direction.&nbsp;</li><li><strong>Develop</strong>&nbsp;a culture of compliance with systems, policies, processes and procedures.</li><li><strong>Control</strong>&nbsp;the management and oversight of budgets to drive profitability and achieve financial targets</li><li>&nbsp;<strong>Develop</strong>&nbsp;people and culture strategies so that they create a high-performance culture aligned to the strategic vision.</li></ul>', '<p><strong>About the candidate&nbsp;</strong></p><p>Given the commitment to the highest service standards (and the highly regulated medical&nbsp; environment), this leadership position is best suited to a proactive individual who can work in a &ldquo;hands-on&rdquo; manner.&nbsp;</p><p>As a result, we will looking for a:&nbsp;</p><ul><li><strong>naturally confident</strong>&nbsp;candidate who is comfortable with a high level of responsibility, autonomy and accountability.</li><li>proven operations manager /Practice Manager, or similar</li><li><strong>self-motivated</strong>&nbsp;person, with a strong understanding of business systems (ideally in general practice or professional service firms)&nbsp;</li><li>an individual who can achieve optimum&nbsp;<strong>service quality&nbsp;</strong>along with cost and productivity targets</li><li>someone who is able to demonstrate a leadership style that creates an opportunity for staff to follow,<strong>&nbsp;flourish and excel</strong></li><li>person who is proud of their track record of effectively interacting and developing strong working&nbsp;<strong>relationships</strong></li><li>a leader able to show strong decision making,&nbsp;<strong>analytical, problem solving</strong>&nbsp;and conflict resolutions skills.</li></ul><p>If this sounds like you, an attractive remuneration package reflecting the importance of this role will be offered. It is based on the city fringe and will offer hybrid (remote work) flexibilities&nbsp;</p><p><strong>Greg Halse &ndash; Mazars HR</strong>&nbsp;, has been retained to assist with this executive recruitment process.&nbsp;&nbsp;</p><p>To make an application, please click &#39;apply&#39; and upload a resume and cover letter.&nbsp;</p><p>Initial enquiries can be made directly to Greg Halse on&nbsp;<strong><a href=\"tel:0412 022 874\">0412 022 874</a></strong>.</p>', 'Queensland', 'JaneDoe123', 'janedoe@gmail.com', '2021-10-31 01:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `jobseeker`
--

CREATE TABLE `jobseeker` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `field` text NOT NULL,
  `location` text NOT NULL,
  `image` mediumblob DEFAULT NULL,
  `resume` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobseeker`
--

INSERT INTO `jobseeker` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `field`, `location`, `image`, `resume`) VALUES
(6, 'Lewis', 'Hamilton', 'Lewis444', 'Lewis444', '2021-10-20', '111111111', 'awd@gmail.com', 'Accounting', 'New South Wales', NULL, NULL),
(7, 'Monkolsophearith', 'Prum', 'Peter2707', 'Peter2707', '2021-10-14', '123123123', 'prummonkolsophearith@gmail.com', 'Accounting', 'Victoria', NULL, NULL),
(9, 'Sokleng', 'Lim', 'Sokleng123', 'Sokleng123', '2021-10-13', '123123123', 'soklenglim11@yahoo.com', 'Banking & Financial Services', 'New South Wales', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `token` text NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `expDate`) VALUES
(5, 'prummonkolsophearith@gmail.com', 'de2a4614d87dc520867f7a2e9f3e8fe3', '2021-11-01 03:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `type` text NOT NULL,
  `matchID` int(11) NOT NULL,
  `reason` text NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `username`, `type`, `matchID`, `reason`, `comment`, `date`) VALUES
(3, 'Votey123', 'jobseeker', 41, 'Offensive', 'You can report a match if you think it is suspicious or something is wrong with the post.You can report a match if you think it is suspicious or something is wrong with the post.', '2021-10-31 03:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `skill` text NOT NULL,
  `experience` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE `social` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `linkedin` text NOT NULL,
  `github` text NOT NULL,
  `twitter` text NOT NULL,
  `instagram` text NOT NULL,
  `facebook` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobmatch`
--
ALTER TABLE `jobmatch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobpost`
--
ALTER TABLE `jobpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobseeker`
--
ALTER TABLE `jobseeker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobmatch`
--
ALTER TABLE `jobmatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `jobpost`
--
ALTER TABLE `jobpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobseeker`
--
ALTER TABLE `jobseeker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `social`
--
ALTER TABLE `social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
