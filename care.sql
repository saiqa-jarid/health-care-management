-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2026 at 01:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `care`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','approved','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `doctor_id`, `patient_id`, `appointment_date`, `appointment_time`, `status`) VALUES
(2, 5, 1, '2026-04-20', '10:00:00', 'approved'),
(3, 7, 1, '2026-04-28', '19:00:00', 'approved'),
(4, 5, 1, '2026-05-05', '11:00:00', 'approved'),
(5, 13, 2, '2026-05-06', '14:30:00', 'pending'),
(6, 6, 2, '2026-05-08', '17:00:00', 'pending'),
(7, 8, 2, '2026-05-31', '15:00:00', 'pending'),
(8, 12, 2, '2026-05-14', '11:00:00', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'Karachi'),
(2, 'Islamabad'),
(3, 'Lahore'),
(4, 'Peshawar'),
(6, 'Quetta');

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `disease_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `prevention` text DEFAULT NULL,
  `cure` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`disease_id`, `name`, `image`, `symptoms`, `prevention`, `cure`) VALUES
(1, 'Malaria', '1776366678_malaria.jfif', 'Fever, chills, sweating, headache, and fatigue.', 'Use mosquito nets, repellents, and avoid stagnant water.', 'Treated with antimalarial medicines prescribed by a doctor.'),
(2, 'Dengue', '1776366816_dengue.jfif', 'High fever, severe headache, joint pain, and skin rash.', 'Prevent mosquito bites and keep surroundings clean.', 'No specific cure; rest, fluids, and medical care help recovery.'),
(3, 'Eczema', '1776367059_eczema.jfif', 'Dry, itchy, scaly patches, often appearing in skin folds (elbows, knees), which may crack, turn red, or weep fluid.', 'Moisturize frequently, avoid harsh soaps, manage stress, and identify allergy triggers.', 'While chronic, it is managed with topical corticosteroids, calcineurin inhibitors, and phototherapy.'),
(4, 'Tuberculosis', '1776367148_tuberculosis.jfif', 'Persistent cough, chest pain, weight loss, and fever.', 'Vaccination (BCG) and avoiding close contact with infected people.', 'Long-term treatment with antibiotics under medical supervision.'),
(5, 'Asthma', '1777062396_asthma.jpg', 'Shortness of breath, wheezing, chest tightness, and frequent coughing', 'Avoid triggers like dust, smoke, pollen, and strong odors.', 'Managed with inhalers (relievers and controllers), medications, and lifestyle adjustments. Regular monitoring and avoiding triggers help control attacks effectively.'),
(6, 'Diabetes', '1777062718_diabetes.jpg', 'Frequent urination, excessive thirst, fatigue, blurred vision, and slow healing of wounds', 'Maintain a healthy diet, exercise regularly, control weight, and monitor blood sugar levels, especially if at risk.', 'Managed through lifestyle changes, blood sugar monitoring, medications, or insulin therapy depending on the type and severity.');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `experience` int(11) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `name`, `email`, `phone`, `specialization`, `city_id`, `experience`, `profile`, `image`) VALUES
(5, 3, 'Dr. Arshad Ali', 'arshad@mail.com', '03009876543', 'General Physician', 1, 5, 'MBBS, MD', '1776263327_doctor1.jpeg'),
(6, 4, 'Dr. Anum Baig', 'anum@mail.com', '03019876543', 'Dermatologist', 2, 3, 'MBBS, MD', '1776263441_doctor2.jpeg'),
(7, 5, 'Dr. Ahmed Sheikh', 'ahmed@mail.com', '03029876543', 'Diabetologist', 3, 7, 'MBBS, D.Diab', '1776263689_doctor3.jpeg'),
(8, 6, 'Dr. Laiba Anees', 'laiba@mail.com', '03039876543', 'General Physician', 2, 16, 'MBBS, MRCP', '1776263799_doctor4.jpeg'),
(12, 11, 'Dr. Masood Alam', 'masood@mail.com', '03099876543', 'Cardiologist', 4, 24, 'MBBS, FCPS', '1776886174_doctor7.jpeg'),
(13, 12, 'Dr. Tayyaba Muneer', 'tayyaba@mail.com', '03089876543', 'Pulmonologist', 6, 18, 'MBBS, MRCP', '1777070994_doctor8.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day` varchar(20) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `doctor_id`, `day`, `start_time`, `end_time`) VALUES
(1, 5, 'Monday', '09:00:00', '13:00:00'),
(2, 5, 'Tuesday', '09:00:00', '13:00:00'),
(3, 5, 'Wednesday', '09:00:00', '13:00:00'),
(4, 5, 'Thursday', '09:00:00', '13:00:00'),
(6, 5, 'Friday', '09:00:00', '11:00:00'),
(7, 7, 'Monday', '18:00:00', '21:00:00'),
(8, 7, 'Tuesday', '18:00:00', '21:00:00'),
(9, 7, 'Wednesday', '18:00:00', '21:00:00'),
(10, 7, 'Thursday', '18:00:00', '21:00:00'),
(11, 7, 'Friday', '18:00:00', '21:00:00'),
(12, 7, 'Saturday', '18:00:00', '21:00:00'),
(13, 8, 'Friday', '13:00:00', '17:00:00'),
(14, 8, 'Saturday', '13:00:00', '17:00:00'),
(15, 8, 'Sunday', '13:00:00', '17:00:00'),
(16, 8, 'Monday', '13:00:00', '17:00:00'),
(17, 6, 'Wednesday', '15:00:00', '18:00:00'),
(18, 6, 'Thursday', '15:00:00', '18:00:00'),
(19, 6, 'Friday', '15:00:00', '18:00:00'),
(20, 6, 'Saturday', '15:00:00', '18:00:00'),
(21, 6, 'Sunday', '15:00:00', '18:00:00'),
(22, 12, 'Monday', '08:00:00', '12:00:00'),
(23, 12, 'Tuesday', '08:00:00', '12:00:00'),
(24, 12, 'Wednesday', '08:00:00', '12:00:00'),
(25, 12, 'Thursday', '08:00:00', '12:00:00'),
(26, 13, 'Wednesday', '14:00:00', '16:00:00'),
(27, 13, 'Thursday', '14:00:00', '16:00:00'),
(28, 13, 'Friday', '14:00:00', '16:00:00'),
(29, 13, 'Saturday', '14:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `images` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `author`, `content`, `publish_date`, `images`) VALUES
(1, 'Beyond Genetics', 'Dr. Laiba Anees', 'Personalized medicine is expanding beyond genetic profiling to include pharmacogenomics and lifestyle data. This study highlights how tailoring cancer treatments based on an individual\'s unique biological makeup and real-time monitoring significantly improves long-term outcomes and reduces unnecessary treatment cycles.', '2026-04-19 20:08:07', '1776629287_news1.jpeg'),
(2, 'Reversing Obesity via Targeted Hormone Therapy', 'ScienceDaily Research Center', 'Researchers discovered that the natural hormone FGF21 can reverse obesity by targeting a newly identified brain circuit in the hindbrain. This approach shows potential to reduce weight by enhancing metabolism through a similar pathway to GLP-1 drugs like Ozempic, but targeting a different brain region. This study highlights a new frontier in obesity treatment focused on brain-metabolism connectivity.', '2026-04-20 12:34:46', '1776688486_news2.jpeg'),
(3, 'mRNA Vaccines for Chronic Virus Prevention ', 'ScienceDaily Research Center', 'Researchers have made significant progress in developing a vaccine targeting the Epstein-Barr virus, which is found in 95% of people and linked to diseases like multiple sclerosis and various cancers. The new mRNA approach aims to stop the infection, potentially preventing long-term chronic illnesses.', '2026-04-20 12:38:29', '1776688709_news3.jpeg'),
(4, 'AI Predicts Alzheimer’s Risk Years Early via Blood Test', 'Research Team at ScienceDaily', 'Scientists have identified a routine blood marker tied to inflammation that acts as an early warning system for Alzheimer\'s disease. Higher neutrophil levels—part of the body\'s primary immune response—were found to be strongly linked to a greater chance of developing dementia, potentially allowing intervention years before symptoms arise.', '2026-04-24 21:36:54', '1777066614_news4.jpeg'),
(5, 'Hidden Brain \"Switch\" Driving Skin Cancer Identified', 'Scientists at UC Irvine', 'A key protein, HOXD13, has been discovered acting as a \"master switch\" for melanoma, allowing tumors to grow by expanding blood supply and avoiding T-cell attacks. Disabling this protein effectively shrunk tumors in trials, opening a new pathway for immunotherapy.', '2026-04-24 22:12:55', '1777068775_news5.jpeg'),
(6, 'Engineered Plastic Film Destroys Viruses on Contact', 'Cornell University Researchers', 'Scientists developed a new, flexible plastic film covered in microscopic pillars that physically stretch viruses until they burst. This chemical-free material could be used on high-touch surfaces to act as a permanent defender against viruses.', '2026-04-24 22:15:20', '1777068920_news6.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `name`, `email`, `phone`, `address`, `age`, `gender`) VALUES
(1, 2, 'Jahangir Khan', 'jahangir@mail.com', '03031234567', 'House 123, ABC Street, XYZ Town, Karachi', 30, 'Male'),
(2, 13, 'Akbar Khan', 'akbar@mail.com', '03331234567', 'XYZ, Block k, MN Area, Y City', 44, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'aptech', 'aptech@mail.com', '$2y$10$Vp/WS0gVnnKR.WMl6s03dO8N.LQ/t940qM4ew4rcTHys2N42zcJaS', 'admin', '2026-04-09 17:11:13'),
(2, 'Jahangir Khan', 'jahangir@mail.com', '$2y$10$Nn4eV9iGmyAb7TCSisPTtuTn/HmIKUBM6HW9O6LknUe.DcjsHNj/y', 'patient', '2026-04-09 21:14:37'),
(3, 'Dr. Arshad Ali', 'arshad@mail.com', '$2y$10$PnNi.VkbyMnMfPasGAVer.664WfH6CfXucplQ3.v4.uvAuN5JgoM.', 'doctor', '2026-04-15 14:28:47'),
(4, 'Dr. Anum Baig', 'anum@mail.com', '$2y$10$FApuNzhDeM8C08z.eZodO.LX6xPPW7CccDOJ7fAyrQPp46gk34N.a', 'doctor', '2026-04-15 14:30:41'),
(5, 'Dr. Ahmed Sheikh', 'ahmed@mail.com', '$2y$10$ngTs7RpyfBwCVjsRDpWGK.LknZyB6lGNSkmpNftOMn34pTJjGE9He', 'doctor', '2026-04-15 14:34:49'),
(6, 'Dr. Laiba Anees', 'laiba@mail.com', '$2y$10$2/EGD5qR2zKjO9kLl3zROe9YDoR46OeNTQxxvCU35QQuvlt6AfH3.', 'doctor', '2026-04-15 14:36:39'),
(11, 'Dr. Masood Alam', 'masood@mail.com', '$2y$10$4LO9ujCWeEvyrzHkX7NVOeJHFx3BxUGZ5Ne.2kGnhnQ1qILVdVkEK', 'doctor', '2026-04-22 19:29:34'),
(12, 'Dr. Tayyaba Muneer', 'tayyaba@mail.com', '$2y$10$fI6Su09CRyWsEE435W1ghez8GRK/NkRp9quvJvoVDhA88Vkqy23dO', 'doctor', '2026-04-24 22:49:54'),
(13, 'Akbar Khan', 'akbar@mail.com', '$2y$10$ETCfDGki6eFd4iIjAlJbC.Nxj3Teczai3uQ6qSuOa4G5hJo/jGxda', 'patient', '2026-04-24 22:54:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`disease_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_doctor_city` (`city_id`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doctor_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON UPDATE CASCADE;

--
-- Constraints for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD CONSTRAINT `doctor_availability_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
