-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2026 at 08:13 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u414903541_greenedge`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `full_name`, `is_active`, `created_at`) VALUES
(1, 'greenedge', 'admin@greenedgeinfratech.com', '$2y$10$TD85kuE.pXKgSgaiLE5v5uzwmD3ZKhwf31EOs0190LgqX98IYQxQa', 'System Administrator', 1, '2025-10-17 19:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'PM Surya Ghar Yojana 2025: Solar Subsidy in Uttar Pradesh', 'Apply for PM Surya Ghar Yojana 2025 & get ₹1,08,000/- subsidy for rooftop solar in UP. Learn benefits, eligibility & step-by-step process to claim free electricity.\r\n\r\nThe Government of India has launched a landmark initiative called the PM Surya Ghar Muft Bijli Yojana to help common citizens switch to clean energy and reduce their electricity bills.\r\n\r\nThis scheme aims to provide 300 units of free electricity every month to over 1 crore households by installing rooftop solar panels. Let’s explore the benefits, the subsidy offered in Uttar Pradesh, and how you can avail this opportunity easily.\r\n\r\n What is PM Surya Ghar Yojana?\r\nPM Surya Ghar Muft Bijli Yojana, launched in 2024, aims to empower homeowners by enabling them to generate solar energy on their rooftops and get free electricity up to 300 units per month.\r\n\r\nIt is designed for middle-class families, small homeowners, and rural households, providing both financial and environmental benefits.\r\n\r\n ???? Key Benefits of PM Surya Ghar Scheme\r\n✅ Free Electricity up to 300 Units/Month\r\nHouseholds can save ₹1,500–₹2,000 every month on electricity bills.\r\n✅ Central Government Subsidy up to ₹78,000\r\nDirect financial support reduces the upfront cost of solar installation.\r\n✅ One-Time Investment, Lifetime Savings\r\nRooftop solar lasts 25+ years with minimal maintenance.\r\n✅ Net Metering Benefit\r\nExtra electricity produced can be sold to the grid and adjusted in your bill.\r\n✅ Increased Energy Independence\r\nReduced reliance on rising electricity tariffs and grid outages.\r\n✅ Easy Online Application Process\r\nTransparent and paperless application via pmsuryaghar.gov.in.\r\n✅ Environmental Impact\r\nContribute to reducing carbon footprint and promoting clean energy.\r\n✅ Property Value Appreciation\r\nSolar homes are more energy-efficient and attract higher resale value.\r\n✅ Government Support & Trust\r\nScheme is backed by the Ministry of New and Renewable Energy (MNRE).\r\n✅ Empowerment of Middle-Class & Poor Families\r\nSpecially aimed at helping economically weaker sections afford clean power.\r\nHappy Family with Solar Installation\r\nSolar Subsidy in Uttar Pradesh (UP)\r\nHere’s how much subsidy you can get in UP under the PM Surya Ghar scheme:\r\n\r\nSystem Size	Approx. Subsidy Amount\r\n1 kW	₹45,000\r\n2 kW	₹90,000\r\n3 kW	₹1,08,000\r\nAbove 3 kW (up to 10 kW)	₹1,08,000\r\n???? How to Apply for the PM Surya Ghar Scheme?\r\nFollow these simple steps:\r\n???? Register Online\r\nVisit the official portal: https://pmsuryaghar.gov.in\r\nChoose your state, DISCOM (like DVVNL for Aligarh), and enter your electricity account number.\r\n✅ Choose an Approved Installer\r\nSelect a MNRE-authorized vendor like Greenedge Infratech Private limited.\r\n???? Site Survey and Approval\r\nThe installer will visit your site to inspect the rooftop and create a solar system design for approval.\r\n???? Installation\r\nAfter approval, the solar system will be installed on your rooftop with safety and efficiency.\r\n⚡ Net Metering & Activation\r\nOnce installed, your system will be connected to the grid using a net meter.\r\n???? Subsidy Transfer\r\nAfter successful commissioning, the subsidy is credited directly to your bank account.\r\n???? Why Choose Greenedge Infratech?\r\nWe are a trusted MNRE-approved solar installer in Aligarh, providing end-to-end assistance for rooftop solar installations under government schemes.\r\n\r\nWith Greenedge Infratech, you get:\r\n\r\n✔️ Support in online registration and paperwork\r\n✔️ Free solar assessment using our Solar Calculator\r\n✔️ EMI options and bank financing help\r\n✔️ Local service team and fast installation\r\n✔️ Post-installation support and maintenance\r\n???? Get in Touch for a Free Consultation ?\r\nGreenedge Infratech Pvt. Ltd., Aligarh\r\n???? Address: Opp. BJP Office kayampur Aligarh.\r\n???? Phone: +91-9837067681\r\n???? Website: https://greenedgeinfratech.com', '1756835849_about-bg.png', '2025-09-02 17:57:29'),
(2, 'Top 5 Solar Panel Myths Busted – Greenedge Infratech', 'Think solar panels are too expensive or don’t work in clouds? Discover the truth behind the top 5 solar myths & why it’s time to switch to solar with Greenedge.\r\n\r\nAs the world shifts towards clean energy, more and more homeowners are considering solar panels to save money and reduce their carbon footprint. Yet despite the growing popularity, there are still many misconceptions and myths floating around that stop people from making the switch.At GreenEdge Infratech, we’re here to clear the air! Let’s bust the top 5 myths about solar panels so you can make an informed decision for your home or business.\r\n\r\n???? Myth 1: Solar Panels Don’t Work in Cloudy or Cold Weather\r\nFact: Solar panels generate power from sunlight, not heat. Even on cloudy days, they still capture diffused sunlight and produce electricity. Countries like Germany and the UK—known for cloudy weather—have thriving solar industries.\r\n\r\n✅ In winter or monsoon, output might be slightly lower, but solar still works efficiently year-round in most parts of India, including Aligarh.\r\n\r\n???? Myth 2: Solar Panels Are Too Expensive to Afford\r\nact: Thanks to the PM Surya Ghar Yojana and state-level solar subsidies, installing solar is more affordable than ever. With government incentives, you can get up to ₹78,000 or more in subsidy, plus EMI or financing options.\r\n\r\n✅ In most cases, you recover your investment in 3–5 years through reduced electricity bills—and enjoy free power for the next 20 years!\r\n\r\n???? Myth 3: Solar Panels Require a Lot of Maintenance\r\nFact: Solar panels are built to last and require minimal maintenance. A simple cleaning once every 15–30 days (to remove dust and bird droppings) is usually enough. Most systems have no moving parts, and inverters come with warranty of 5+ years.\r\n\r\n✅ We offer Annual Maintenance Contracts (AMC) and smart monitoring tools so you can stay worry-free.\r\n\r\n???? Myth 4: Solar Panels Will Damage My Roof\r\nFact: Solar panels are installed with precision using mounting structures that protect your roof. In fact, they can extend your roof’s life by shielding it from direct sun, rain, and heat.\r\n\r\n✅ At GreenEdge Infratech, we follow best practices and engineering standards to ensure safe and non-invasive installation.\r\n\r\n⚡ Myth 5: Solar Power Isn’t Reliable or Efficient\r\nFact: Today’s solar technology is highly efficient and reliable, with panels converting up to 22% of sunlight into electricity. With the right system size, inverter, and net metering setup, your solar system can power most—if not all—of your daily energy needs.\r\n\r\n✅ You can also use hybrid systems with battery backup for power during outages.\r\n\r\n✅ Don’t Let Myths Stop You From Going Solar\r\nSolar energy is clean, reliable, and financially smart. Whether you’re looking to reduce your electricity bills, support a greener planet, or simply make a wise investment—solar is a win-win!\r\n\r\n???? Still have questions?\r\nTry our Solar Calculator to estimate your savings and system size, or reach out to our team for a free consultation.\r\n\r\n???? Ready to bust these myths at your rooftop?\r\nCall us or WhatsApp at ???? 9837067681 or visit ???? www.greenedgeinfratech.com\r\n\r\n', '1756969736_commercial.jpg', '2025-09-04 07:08:56'),
(3, 'The Importance of Cleaning Solar Panels for Maximum Efficiency', 'Solar energy has become a cornerstone of sustainable living, and as more homes and businesses embrace this clean energy solution, maintaining the efficiency of solar panels becomes a priority. Greenedge Infratech, a leading name in solar installation in Aligarh, has been instrumental in driving this green revolution. However, one often-overlooked aspect of solar energy maintenance is the regular cleaning of solar panels. Let’s delve into why cleaning is essential and how it can ensure your solar panels perform at their peak.\r\n\r\nWhy Cleaning Solar Panels is Crucial\r\nSolar panels work by converting sunlight into electricity. However, their efficiency can significantly drop if the panels are covered with dirt, dust, bird droppings, or other debris. Over time, this accumulation creates a layer that blocks sunlight from reaching the photovoltaic cells. Here are a few reasons why cleaning your solar panels is critical:\r\n\r\nEnhanced Energy Output: Clean panels allow more sunlight to be absorbed, directly increasing energy generation. Studies have shown that dirty solar panels can lose 20-25% of their efficiency.\r\nProlonged Lifespan: Regular cleaning prevents the buildup of corrosive elements that might damage the panels over time. This ensures your investment lasts longer and performs reliably.\r\nCost-Effectiveness: Cleaner panels mean higher efficiency, reducing dependency on additional energy sources and lowering electricity bills.\r\nMaximizing Return on Investment: For solar installations by Greenedge Infratech, cleaning ensures that you get the maximum benefit from your high-quality system, making your investment worthwhile.\r\nWhen and How Often to Clean Solar Panels\r\nThe frequency of cleaning depends on several factors, such as the location of the panels, weather conditions, and surrounding environment. In Aligarh, where dust and pollution can be prevalent, it’s advisable to clean the panels at least twice a year or more frequently during dry, dusty seasons.\r\n\r\nSigns that your solar panels might need cleaning include:\r\n\r\nA noticeable drop in energy output.\r\nVisible dirt or debris on the panels.\r\nLocal weather events, like dust storms, which leave residue on surfaces.\r\nThe Right Way to Clean Solar Panels\r\nWhile cleaning solar panels might sound straightforward, it’s essential to do it correctly to avoid damage. Here are some tips:\r\n\r\nSafety First: Ensure the solar system is turned off before cleaning. If the panels are on a roof, take necessary precautions to prevent falls.\r\nUse the Right Tools: Avoid abrasive materials that could scratch the surface. Instead, use a soft sponge, microfiber cloth, or a specialized solar panel cleaning kit.\r\nAvoid Harsh Chemicals: Clean water or a mild soap solution works best. Harsh chemicals can damage the anti-reflective coating on the panels.\r\nClean in the Morning or Evening: Cleaning during cooler parts of the day prevents water spots caused by quick evaporation on hot panels.\r\nConsult Professionals: For extensive systems, it’s wise to hire experts. Greenedge Infratech offers maintenance services to ensure your panels are cleaned and inspected without hassle.\r\nGreenedge Infratech: A Trusted Partner in Solar Solutions\r\nGreenedge Infratech has established itself as a trusted name in Aligarh’s solar energy sector, offering top-notch solar panel installations and maintenance services. With their expertise, you can ensure that your solar system remains efficient and reliable for years to come.\r\n\r\nThe company emphasizes a holistic approach to solar energy, which includes educating customers about the importance of panel maintenance. Their team of skilled professionals is equipped to handle cleaning tasks, ensuring that your system operates at optimal levels.\r\n\r\nA Sustainable Future Starts with Care\r\nSolar panels are a significant investment in a sustainable future, and their maintenance is crucial to harnessing their full potential. Regular cleaning not only improves efficiency but also prolongs the lifespan of the system, saving money in the long run. If you’re in Aligarh and seeking expert guidance, Greenedge Infratech is your go-to partner for solar installation and maintenance.\r\n\r\nBy adopting these cleaning practices and leveraging Greenedge Infratech’s expertise, you can enjoy uninterrupted green energy while contributing to a cleaner planet. Remember, a little care goes a long way in ensuring the efficiency and longevity of your solar panels.', '1756969845_hero-solar.jpg', '2025-09-04 07:10:45'),
(4, 'Empowering Residential Societies through Solar Energy under PM Surya Ghar: Muft Bijli Yojna', '<p>India&rsquo;s energy landscape is rapidly transforming, and the PM Surya Ghar: Muft Bijli Yojna is a landmark initiative driving this change. Designed to promote rooftop solar adoption in residential sectors, the scheme offers substantial government subsidies that make solar energy not only affordable but also profitable for Residential Welfare Associations (RWAs), Housing Societies, and Group Housing Complexes. The Vision of PM Surya Ghar Yojna Launched by the Government of India, this scheme aims to install 10 million (1 crore) rooftop solar systems across households. The government provides direct subsidy transfers to residential consumers, reducing upfront installation costs and encouraging clean, self-reliant energy generation. Under this scheme: Homeowners and housing societies can install grid-connected rooftop solar systems. The Central Financial Assistance (CFA) is directly credited to the consumer&rsquo;s bank account. Consumers can offset their monthly electricity bills through net metering, where excess solar power is exported to the grid. Why Solar for Residential Societies Makes Perfect Sense Residential societies have large common areas &mdash; lifts, pumps, street lights, security cabins, and clubhouses &mdash; all consuming significant electricity. Shifting to solar power helps societies: Reduce common area electricity bills by 70&ndash;90% Increase property value Contribute to sustainability and net-zero goals Ensure energy independence for decades How Societies Benefit Beyond Savings Lower Maintenance Charges: Savings on electricity directly reduce monthly maintenance contributions by residents. Green Building Recognition: Solar installation helps the society achieve Green Housing Certification, enhancing reputation and resale value. Energy Security: Stable, predictable energy generation for decades with minimal maintenance. CSR and ESG Alignment: Builders and management committees can align projects with Sustainability &amp; CSR mandates. Greenedge Infratech &ndash; Your Solar Partner in Progress With extensive experience in residential and institutional solar installations across Uttar Pradesh, Greenedge Infratech specializes in: Designing and installing MNRE-approved, DISCOM-registered solar systems End-to-end project management &ndash; from subsidy registration to commissioning After-sales service and performance monitoring for maximum output We handle everything from subsidy documentation to net-metering and DISCOM coordination, ensuring a seamless experience for your society. Conclusion The PM Surya Ghar Yojna is not just a government scheme&mdash;it&rsquo;s a step towards a cleaner, self-sustaining future. For residential societies, the combination of high financial returns, low maintenance, and government support makes solar a practical and forward-looking investment. With trusted partners like Greenedge Infratech, your society can transition smoothly to solar energy&mdash;reducing bills, increasing property value, and leading the change toward a Green, Energy-Independent India. Contact Greenedge Infratech <a href=\"http://www.greenedgeinfratech.com\">www.greenedgeinfratech.com</a> +91 9837067681‬ greenedgeinfratech@gmail.com Aligarh,&nbsp;Uttar&nbsp;Pradesh</p>\r\n', '1760964311_Housing-society-solar-system.png', '2025-10-20 12:45:11'),
(5, 'मेरी बिजली खपत के हिसाब से सोलर सिस्टम कितना होना चाहिए?', '<p>अक्सर लोग पूछते हैं&mdash;&nbsp; &ldquo;कितने kW का सोलर लगवाएँ?&rdquo; इसका सही जवाब लोड प्रोफाइल (Load Profile) में छुपा होता है, सिर्फ छत के साइज में नहीं।&nbsp; &nbsp; &nbsp;</p>\r\n\r\n<p>सोलर सिस्टम साइज तय करने के 3 ज़रूरी आधार</p>\r\n\r\n<p>✔️ पिछले 12 महीनों का बिजली बिल</p>\r\n\r\n<p>➡️ औसत मासिक यूनिट (kWh) से सही kW का अनुमान</p>\r\n\r\n<p>✔️ दिन और रात की बिजली खपत का पैटर्न</p>\r\n\r\n<p>➡️ सोलर दिन में बिजली बनाता है, दिन की खपत ज़्यादा = ज़्यादा फ़ायदा</p>\r\n\r\n<p>✔️ भविष्य के लोड</p>\r\n\r\n<p>➡️ AC, कूलर, मोटर, EV चार्जर, नया फ़्लोर आज का सिस्टम = कल की ज़रूरत</p>\r\n\r\n<p>⚠️ गलत kW चुनने से क्या नुकसान? ❌ कम kW सिस्टम &ndash; पूरी खपत कवर नहीं होगी &ndash; बिजली बिल फिर भी आएगा ❌</p>\r\n\r\n<p>ज़्यादा kW सिस्टम &ndash; बेवजह ज़्यादा निवेश &ndash; नेट मीटरिंग में लिमिटेशन ???? सही साइज = अधिकतम बचत + सुरक्षित निवेश&nbsp;</p>\r\n\r\n<p>Greenedge Infratech की विशेषज्ञ सलाह &ldquo;सोलर सिस्टम छत देखकर नहीं, बिजली खपत समझकर लगवाना चाहिए।&rdquo; हम करते हैं:</p>\r\n\r\n<p>✔️ 12 महीने का बिल एनालिसिस</p>\r\n\r\n<p>✔️ डे&ndash;नाइट लोड प्रोफाइल स्टडी</p>\r\n\r\n<p>✔️ भविष्य के लोड को ध्यान में रखकर डिज़ाइन</p>\r\n\r\n<p><a href=\"https://greenedgeinfratech.com/calculator\"><span style=\"color:#3498db\">https://greenedgeinfratech.com/calculator</span></a></p>\r\n\r\n<p>#LoadProfiling #SolarSystemSize #RooftopSolar #GreenedgeInfratech #SolarTips #PM_SuryaGhar #CleanEnergy</p>\r\n', '1771066660_Sahi System.png', '2026-02-14 10:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `career_benefits`
--

CREATE TABLE `career_benefits` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `benefit_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_benefits`
--

INSERT INTO `career_benefits` (`id`, `opportunity_id`, `benefit_text`) VALUES
(2, 1, 'Real-world experience in the solar energy sector'),
(0, 0, 'Real-world experience in the solar energy sector');

-- --------------------------------------------------------

--
-- Table structure for table `career_opportunities`
--

CREATE TABLE `career_opportunities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('internship','volunteer','fulltime') DEFAULT 'internship',
  `location` varchar(255) DEFAULT NULL,
  `application_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_opportunities`
--

INSERT INTO `career_opportunities` (`id`, `title`, `description`, `type`, `location`, `application_email`, `created_at`) VALUES
(1, 'jvhjvbh', 'nbjb ', 'internship', 'punjab', 'greenedge@gmail.com', '2025-10-20 10:09:23'),
(0, 'gyghy', 'gvhbbh', 'internship', 'Jaipur,Rajastan', 'test@gmail.com', '2026-02-16 05:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `career_posters`
--

CREATE TABLE `career_posters` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_posters`
--

INSERT INTO `career_posters` (`id`, `opportunity_id`, `image_path`, `alt_text`) VALUES
(1, 1, '1760954963_Container.png', 'jhvhvh'),
(0, 0, '1771220398_photo-1556894769-b9a5dab851c0.avif', 'bhtu');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `property_type` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `first_name`, `last_name`, `email`, `phone`, `property_type`, `message`, `created_at`) VALUES
(1, 'CHINMAYA', 'BEHERA', 'cpbehera03@gmail.com', '+918599859807', 'Industrial Facility', 'test', '2026-02-16 07:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image_path`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Solar Inverters', 'solar-inverters', 'High-efficiency solar inverters for residential and commercial use', 'assets/image/solar-home-solution.webp', '<p class=\"text-gray-700 mb-4\">Solar inverters are an essential component of a solar power system. They convert the direct current (DC) generated by solar panels into alternating current (AC) that can be used to power homes and businesses or fed back into the grid. Solar inverters come in different sizes and types, depending on the size of the solar system and the specific needs of the user.</p>\n<p class=\"text-gray-700\">There are two main types of solar inverters</p>\n<ul class=\"list-disc pl-6 mt-4 text-gray-700\">\n<li>string inverters</li>\n<li>microinverters.</li>\n</ul>\n<p class=\"text-gray-700 mb-4\">Solar inverters are an essential component of a solar power system. They convert the direct current (DC) generated by solar panels into alternating current (AC) that can be used to power homes and businesses or fed back into the grid. Solar inverters come in different sizes and types, depending on the size of the solar system and the specific needs of the user.</p>\n<p class=\"text-gray-700 mb-4\">Microinverters, on the other hand, are designed to be connected to individual solar panels. They convert the DC power generated by each panel into AC power, which is then combined and fed back into the grid. Microinverters are generally more expensive than string inverters, but they offer several advantages, such as greater efficiency, flexibility, and monitoring capabilities.</p>\n<p class=\"text-gray-700 mb-4\">In addition to string and microinverters, there are also hybrid inverters, which are designed to work with both solar panels and a battery storage system. Hybrid inverters are becoming increasingly popular, as they allow users to store excess solar energy in batteries for use during times when solar power is not available.</p>\n<p class=\"text-gray-700 mb-4\">When choosing a solar inverter, it is important to consider factors such as efficiency, reliability, and monitoring capabilities. The efficiency of an inverter can have a significant impact on the overall performance of a solar power system, and higher efficiency inverters can help to maximize the amount of energy generated by the solar panels. Reliability is also important, as solar inverters are designed to last for many years and are a significant investment for most homeowners and businesses.</p>\n<p class=\"text-gray-700 mb-4\">Finally, monitoring capabilities are an important consideration, as they allow users to track the performance of their solar power system and ensure that it is operating at optimal levels. Many modern solar inverters come with monitoring capabilities built in, allowing users to track their energy production and consumption in real-time, and identify any issues that may arise.</p>\n<p class=\"text-gray-700 mb-4\">In conclusion, solar inverters are an essential component of a solar power system, converting the DC power generated by solar panels into AC power that can be used by homes and businesses or fed back into the grid. There are several types of solar inverters to choose from, each with their own advantages and disadvantages. When selecting a solar inverter, it is important to consider factors such as efficiency, reliability, and monitoring capabilities to ensure that the system operates at optimal levels and provides the greatest benefit to the user.</p>', 1, '2025-10-17 19:25:55', '2025-10-17 19:25:55'),
(2, 'Solar Pump', 'solar-pumps', 'Sustainable solar-powered water pumping solutions', 'assets/image/solar-micro-pump.webp', '<p class=\"text-gray-700 mb-4\">Solar pumps are an innovative and sustainable way to provide water for irrigation, livestock, and domestic use in areas where access to electricity is limited. Solar pumps use solar panels to generate electricity, which is used to power the pump and move water from a well, borehole, or other water source to the surface.</p>\n<p class=\"text-gray-700\">There are two main types of solar pumps</p>\n<ul class=\"list-disc pl-6 mt-4 text-gray-700 mb-4\">\n<li>surface pumps</li>\n<li>submersible pumps.</li>\n</ul>\n<p class=\"text-gray-700 mb-4\">Surface pumps are typically used for shallow wells and surface water sources, while submersible pumps are designed for deep wells and boreholes. Solar pumps can be used in a variety of applications, including agriculture, livestock, and rural water supply.</p>\n<p class=\"text-gray-700 mb-4\">One of the key advantages of solar pumps is their cost-effectiveness. Traditional pumps that run on electricity or diesel can be expensive to operate, especially in areas where fuel costs are high or access to electricity is limited. Solar pumps, on the other hand, rely on sunlight to generate electricity, which is free and abundant in many parts of the world.</p>\n<p class=\"text-gray-700 mb-4\">Another advantage of solar pumps is their reliability. Solar pumps are designed to be durable and long-lasting, and require minimal maintenance. They also operate silently and produce no emissions, making them an environmentally friendly option for water pumping.</p>\n<p class=\"text-gray-700 mb-4\">Solar pumps are also easy to install and operate. They typically come with a controller that ensures that the pump operates at optimal levels, and can be easily programmed to meet specific water flow requirements. In addition, many solar pumps come with monitoring capabilities that allow users to track the performance of the pump and ensure that it is operating at optimal levels.</p>\n<p class=\"text-gray-700 mb-4\">In conclusion, solar pumps are an innovative and sustainable way to provide water for irrigation, livestock, and domestic use in areas where access to electricity is limited. They are cost-effective, reliable, and easy to install and operate, making them an attractive option for farmers, ranchers, and rural communities. With the growing demand for sustainable and efficient water pumping solutions, solar pumps are becoming an increasingly popular choice for those seeking to reduce their reliance on fossil fuels and contribute to a more sustainable future.</p>', 1, '2025-10-17 19:25:55', '2025-10-17 19:25:55'),
(3, 'Photovoltaic Module Panels', 'photovoltaic-module-panels', 'High-quality PV modules for maximum energy generation', 'assets/image/solar-pv.jpg', '<p class=\"text-gray-700 mb-4\">PV modules, also known as solar panels, are the most recognizable and essential component of a solar power system. They are made up of multiple interconnected solar cells, which convert sunlight into direct current (DC) electricity.</p>\n<p class=\"text-gray-700 mb-4\">PV modules come in different sizes and shapes, and can be used in a variety of applications, from small residential systems to large commercial and utility-scale installations. They are typically mounted on rooftops or in open fields, and are designed to capture as much sunlight as possible in order to generate electricity.</p>\n<p class=\"text-gray-700 mb-4\">There are several types of PV modules, each with their own advantages and disadvantages. The most common type is crystalline silicon, which is made up of silicon wafers that are cut from a single crystal or cast from a molten silicon mixture. Crystalline silicon modules are highly efficient and reliable, and are the most widely used type of PV module.</p>\n<p class=\"text-gray-700 mb-4\">Another type of PV module is thin-film, which is made up of a thin layer of semiconductor material deposited on a substrate such as glass or plastic. Thin-film modules are less efficient than crystalline silicon modules, but they are lighter and more flexible, and can be used in a wider range of applications.</p>\n<p class=\"text-gray-700 mb-4\">PV modules also come in different efficiency levels, which refers to the amount of sunlight they are able to convert into electricity. Higher efficiency modules are more expensive, but they can generate more electricity per unit of surface area, making them a good choice for applications where space is limited.</p>\n<p class=\"text-gray-700 mb-4\">In addition to efficiency, PV modules are also rated according to their power output, which is measured in watts. This rating is based on the maximum power output the module can generate under standard test conditions.</p>\n<p class=\"text-gray-700 mb-4\">When choosing a PV module, it is important to consider factors such as efficiency, reliability, and cost. Higher efficiency modules are generally more expensive, but they can provide a greater return on investment over the lifetime of the system. Reliability is also important, as PV modules are designed to last for many years and are a significant investment for most homeowners and businesses.</p>\n<p class=\"text-gray-700 mb-4\">In conclusion, PV modules are an essential component of a solar power system, capturing sunlight and converting it into electricity. There are several types of PV modules to choose from, each with their own advantages and disadvantages. When selecting a PV module, it is important to consider factors such as efficiency, reliability, and cost to ensure that the system operates at optimal levels and provides the greatest benefit to the user.</p>', 1, '2025-10-17 19:25:55', '2025-10-17 19:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Solar System Installation', 'We are committed to helping our customers save money and reduce their carbon footprint through the power of solar energy. Contact us today to learn more about our services and to schedule a consultation with our team.<br><br>Solar panel installation is the process of mounting and connecting solar panels to a building or property in order to generate electricity from the sun. Our team of experts will work with you to design a customized solar power system for your property. This includes selecting the appropriate solar panels, designing the mounting system, and connecting the panels to your electrical system. During the installation process, our team will ensure that the panels are installed securely and that all wiring and connections are properly installed and grounded. We will also make sure that the panels are positioned to maximize exposure to the sun, which will help to increase energy production and efficiency.<br><br>At the end of the installation process, we will test the system to ensure that it is operating efficiently and effectively. We will also provide you with information on how to monitor your solar power system\'s performance, so you can track your energy production and savings. Our team is committed to providing a high-quality solar panel installation that meets your needs and budget.<br><br>At our solar system installation website, we offer high-quality solar panel installation services for residential and commercial properties. Our team of experienced professionals will work with you to determine the best location and angle for your solar panels, taking into account factors such as sun exposure, shading, and roof orientation.<br><br>We use only the highest quality solar panels from reputable manufacturers to ensure maximum efficiency and durability. Our team will handle all aspects of the installation process, including mounting the panels on your roof or on the ground, connecting them to your electrical system, and ensuring that the system is functioning properly.<br><br>By installing solar panels on your property, you can significantly reduce your reliance on traditional power sources and lower your energy bills. In addition, you can reduce your carbon footprint and contribute to a more sustainable future.<br><br>Contact us today to learn more about our solar panel installation services and to schedule a consultation with our team. We look forward to helping you harness the power of the sun and enjoy the many benefits of solar energy.', 'assets/solar-installation.jpg', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(2, 'Energy Storage Solutions', 'We offer energy storage solutions to help you make the most of your solar power system. Energy storage allows you to store excess energy generated by your solar panels during the day, so you can use it at night or during times of high energy demand.<br><br>Our team can help you choose the best energy storage solutions for your needs, such as batteries, which are the most common type of energy storage for solar systems. We use high-quality batteries from reputable manufacturers to ensure long-lasting performance and durability.<br><br>In addition, we can help you design an energy storage system that meets your specific needs and budget. We will take into account factors such as your energy usage patterns, the size of your solar system, and your overall energy goals.<br><br>With energy storage, you can maximize your use of solar power, reduce your reliance on traditional power sources, and lower your energy bills. Contact us today to learn more about our energy storage solutions and to schedule a consultation with our team. We look forward to helping you achieve a more sustainable and efficient energy future.', 'assets/energy-storage.jpg', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(3, 'Maintenance & Repairs', 'We offer ongoing maintenance and repair services to ensure that your solar power system continues to operate efficiently and effectively. Regular maintenance can help extend the lifespan of your solar panels and prevent potential issues from becoming major problems.<br><br>Our team of experienced professionals can provide a variety of maintenance services, such as:<br><br>1. Regular cleaning of your solar panels to remove dirt, debris, and other contaminants that can reduce their efficiency.<br>2. Inspection of your solar panels and other system components to identify any potential issues or areas for improvement.<br>3. Testing of your system to ensure that it is functioning properly and efficiently.<br>4. Replacement of any damaged or malfunctioning components, such as solar panels or inverters.<br><br>In addition to maintenance, we also offer repair services to address any issues that may arise with your solar power system. Our team can quickly diagnose and repair problems such as system malfunctions, wiring issues, or component failures.<br><br>By choosing our maintenance and repair services, you can ensure that your solar power system is always functioning at its best, providing you with the maximum amount of clean energy.<br><br>At our solar system installation website, we offer ongoing maintenance and repair services to ensure that your solar power system continues to operate efficiently and effectively. Regular maintenance is essential to ensure that your solar panels are operating at maximum efficiency, which can help you save money on your energy bills.<br><br>Our maintenance services include cleaning your solar panels to remove any dirt, debris, or other buildup that can decrease their efficiency. We also inspect your solar power system for any damage or issues that may need to be addressed.<br><br>If any repairs are needed, our team of experienced professionals will quickly and efficiently diagnose and fix the problem. We use only the highest quality replacement parts to ensure long-lasting performance and reliability.<br><br>By choosing our maintenance and repair services, you can enjoy peace of mind knowing that your solar power system is operating at maximum efficiency and that any issues will be quickly and efficiently addressed. Contact us today to learn more about our maintenance and repair services and to schedule a consultation with our team. We look forward to helping you make the most of your solar power system.', 'assets/maintenance.jpg', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(4, 'Financing Options', 'We understand that the upfront cost of a solar power system can be a significant investment for many homeowners and businesses. That\'s why we offer financing options to help make the transition to solar power more affordable and accessible.<br><br>We work with a variety of financing partners to offer flexible financing options that can fit your budget and financial goals. Our financing options may include low-interest loans, leases, and power purchase agreements (PPAs). We can help you determine which financing option is best suited to your needs and budget.<br><br>With our financing options, you can start enjoying the benefits of solar power right away, without having to make a large upfront investment. You can lower your energy bills, reduce your carbon footprint, and increase the value of your property.<br><br>Contact us today to learn more about our financing options and to schedule a consultation with our team. We look forward to helping you make the switch to solar power and achieve a more sustainable and affordable energy future.', 'assets/financing.webp', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(5, 'Customized Design', 'We understand that every property is unique, with its own set of energy needs and requirements. That\'s why we offer customized design services to ensure that your solar power system is tailored to meet your specific needs.<br><br>Our team of experienced professionals will work with you to understand your energy goals, budget, and property characteristics, such as roof orientation and shading, to design a solar power system that maximizes energy production and efficiency.<br><br>We use the latest technology and industry best practices to ensure that your solar power system is both effective and visually appealing. We can help you choose from a variety of solar panel options and designs to ensure that your system complements the architecture and aesthetics of your property.<br><br>With our customized design services, you can be confident that your solar power system is optimized for your energy needs and property characteristics. Contact us today to learn more about our customized design services and to schedule a consultation with our team. We look forward to helping you achieve a more sustainable and efficient energy future.', 'assets/custom-design.webp', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(6, 'Residential & Commercial Installation', 'We offer both residential and commercial solar power installation services. Whether you own a small residential property or a large commercial building, we can help you transition to solar power and start enjoying the many benefits of renewable energy.<br><br>For residential properties, we can design and install a solar power system that fits your energy needs and budget. We take into account your energy consumption patterns and your roof orientation and shading to optimize your system\'s energy production and efficiency.<br><br>For commercial properties, we can design and install a solar power system that meets your specific energy needs and requirements. We can help you reduce your energy bills, lower your carbon footprint, and increase the value of your property.<br><br>Our team of experienced professionals can handle all aspects of the installation process, including site evaluation, design, permitting, installation, and commissioning. We use only the highest quality solar panels and components to ensure maximum efficiency and durability.<br><br>With our residential and commercial solar power installation services, you can start enjoying the many benefits of renewable energy, such as lower energy bills, increased property value, and a reduced carbon footprint. Contact us today to learn more about our residential and commercial installation services and to schedule a consultation with our team. We look forward to helping you achieve a more sustainable and efficient energy future.<br><br>At our solar system installation website, we offer both residential and commercial solar power system installation services. Whether you are a homeowner looking to reduce your energy bills or a business owner looking to cut your energy costs and carbon footprint, we can design and install a solar power system that meets your needs.<br><br>For residential installations, we offer a range of solar panel options and designs to fit any budget and aesthetic preference. We can help you choose the best location and angle for your solar panels, and ensure that your system is safely and securely installed.<br><br>For commercial installations, we can design and install solar power systems of any size, from small-scale installations to large-scale commercial systems. Our team can handle all aspects of the installation process, from designing the system to connecting it to your electrical infrastructure.<br><br>By choosing our residential or commercial installation services, you can reduce your reliance on traditional power sources, lower your energy bills, and increase the value of your property. Contact us today to learn more about our residential and commercial installation services and to schedule a consultation with our team. We look forward to helping you achieve a more sustainable and efficient energy future', 'assets/commercial.jpg', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54'),
(7, 'Energy Efficiency Consulting', 'We understand that solar power is just one aspect of a comprehensive energy efficiency strategy. That\'s why we offer energy efficiency consulting services to help you optimize your energy use and reduce your energy costs.<br><br>Our team of experts can conduct a thorough analysis of your energy usage and identify opportunities to improve your energy efficiency, such as upgrading to more energy-efficient appliances or HVAC systems, improving insulation, or implementing energy-saving practices.<br><br>We can also help you develop an energy efficiency plan that fits your budget and energy goals, and provide guidance on available incentives and rebates to help offset the cost of energy-efficient upgrades.<br><br>By taking a comprehensive approach to energy efficiency, you can reduce your energy costs and carbon footprint, while improving the comfort and value of your property. Contact us today to learn more about our energy efficiency consulting services and to schedule a consultation with our team. We look forward to helping you achieve a more sustainable and efficient energy future', 'assets/consulting.avif', 1, '2025-10-21 21:40:54', '2025-10-21 21:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `solar_requests`
--

CREATE TABLE `solar_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `system_size` varchar(50) DEFAULT NULL,
  `estimated_cost` varchar(50) DEFAULT NULL,
  `monthly_generation` varchar(50) DEFAULT NULL,
  `payback_period` varchar(50) DEFAULT NULL,
  `annual_savings` varchar(50) DEFAULT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'residential',
  `area_required` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solar_requests`
--

INSERT INTO `solar_requests` (`id`, `name`, `city`, `phone`, `email`, `system_size`, `estimated_cost`, `monthly_generation`, `payback_period`, `annual_savings`, `category`, `area_required`, `unit_cost`, `created_at`) VALUES
(176, 'PRIYABRATA ARUK', 'Dhenkanal', '8599859807', 'cpbehera03@gmail.com', '2.0', '120000', '270.00', '6.2', '19440', 'residential', 200.00, 0.00, '2025-12-15 09:53:56'),
(177, 'abc', 'ALIGARH', '9837067681', 'gyanendrasimple@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2025-12-20 03:34:29'),
(178, 'ranjit ', 'aagra ', '9358448944', 'shakyranjit22@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2025-12-25 07:38:20'),
(179, 'satish yadav', 'ALIGARH', '08755510222', 'dhenuvedic@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2025-12-25 10:33:22'),
(180, 'satish yadav', 'ALIGARH', '08755510222', 'dhenuvedic@gmail.com', '3.0', '180000', '405.00', '5.3', '34020', 'residential', 300.00, 0.00, '2025-12-25 10:35:30'),
(181, 'satish yadav', 'ALIGARH', '08755510222', 'dhenuvedic@gmail.com', '6.0', '360000', '810.00', '5.3', '68040', 'residential', 600.00, 0.00, '2025-12-25 10:36:39'),
(182, 'satish yadav', 'ALIGARH', '08755510222', 'dhenuvedic@gmail.com', '54.0', '3240000', '7290.00', '5.3', '612360', 'residential', 5400.00, 0.00, '2025-12-25 10:37:13'),
(183, 'Sandesh kumar', 'Aligarh', '6395604375', 'sandeshreya2015@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2025-12-27 18:43:01'),
(184, 'Rahul kumar', 'Aligarh', '8433216427', 'rr8760904@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2026-01-12 03:56:34'),
(185, 'Rahul kumar', 'Aligarh', '8433216427', 'rr8760904@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2026-01-12 03:57:16'),
(186, 'Rohan Kumar', 'ALIGARH', '9286429750', 'rohankashyap0773@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-22 07:25:39'),
(187, 'Raj', 'Aligarh ', '7618594347', 'rajratan976045@gmail.com', '1.0', '60000', '135.00', '5.3', '11340', 'residential', 100.00, 0.00, '2026-01-22 07:34:12'),
(188, 'Arish malik ', 'Aligarh ', '6395850439', 'arish639585@gmail.com', '2.0', '120000', '270.00', '6.2', '19440', 'residential', 200.00, 0.00, '2026-01-22 07:34:35'),
(189, 'Shivankkumar', 'Aligarh ', '+91 952 8962091', 'shivankthakur44@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-22 07:36:10'),
(190, 'Gayatri devi', 'Aligarh', '7217473917', 'akshaypal04240@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-22 07:36:50'),
(191, 'Kishan ', 'Aligarh', '9536995602', 'kishanbhole0@gmail.com', '6.0', '360000', '810.00', '5.3', '68040', 'residential', 600.00, 0.00, '2026-01-22 07:37:20'),
(192, 'Pratik Rajput ', 'Aligarh ', '9675474701', 'pratikrajput5246@gmail.com', '1.0', '60000', '135.00', '5.3', '11340', 'residential', 100.00, 0.00, '2026-01-22 07:38:02'),
(193, 'Ajeet kumar', 'Aligarh', '7217473917', 'akshaypal04240@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-22 07:38:06'),
(194, 'Ajeet kumar', 'Aligarh', '7217473917', 'akshaypal04240@gmail.com', '3.0', '180000', '405.00', '5.3', '34020', 'residential', 300.00, 0.00, '2026-01-23 03:19:48'),
(195, 'Ajeet kumar', 'Aligarh', '7217473917', 'akshaypal04240@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-23 03:22:34'),
(196, 'Gungun upadhyay ', 'Aligarh ', '9012651169', 'gungunupadhyay202001@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:53:41'),
(197, 'Lata Saini ', 'Aligarh ', '8923429057', 'manojsaini19902@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:53:41'),
(198, 'Devki', 'Aligarh ', '9528159354', 'chunmunkumari403@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:53:42'),
(199, 'Sunita ', 'Aligarh ', '8057728477', 'sunitalodhi8057@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:53:54'),
(200, 'Suhana ', 'Aligarh ', '9627300364', 'chobsingchobsing@gmail.com', '1.0', '60000', '135.00', '5.3', '11340', 'residential', 100.00, 0.00, '2026-01-27 05:53:58'),
(201, 'Nisha ', 'Aligarh ', '9389129690', 'nishuraj1296@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:54:58'),
(202, 'SACHIN SINGH', 'Aligarh', '8791443646', 'singhsachin3646@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'commercial', 200.00, 0.00, '2026-01-27 05:57:39'),
(203, 'Sunita ', 'Aligarh ', '8057728477', 'sunitalodhi8057@gmail.com', '1.0', '60000', '135.00', '4.6', '12960', 'residential', 100.00, 0.00, '2026-01-27 05:58:04'),
(204, 'Swati kumari', 'Aligarh ', '7078024894', 'surendrakumar183258@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2026-01-27 13:08:45'),
(205, 'Swati kumari', 'Aligarh ', '7078024894', 'surendrakumar183258@gmail.com', '0.0', '0', '0.00', 'NaN', '0', 'residential', 0.00, 0.00, '2026-01-27 13:10:42'),
(206, 'Mithlesh devi', 'Aligarh ', '7078024894', 'surendrakumar183258@gmail.com', '1.0', '60000', '135.00', '5.3', '11340', 'residential', 100.00, 0.00, '2026-01-27 15:03:19'),
(207, 'Shivank thakur', 'Aligarh ', '9528962091', 'shivankthakur44@gmail.com', '2.0', '120000', '270.00', '5.3', '22680', 'residential', 200.00, 0.00, '2026-01-31 12:58:50'),
(208, 'Prashant saini ', 'Aligarh ', '8923429057', 'manojsaini19902@gmail.com', '6.0', '360000', '810.00', '18.5', '19440', 'residential', 600.00, 0.00, '2026-02-04 08:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `who_can_apply`
--

CREATE TABLE `who_can_apply` (
  `id` int(11) NOT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `criteria` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `who_can_apply`
--

INSERT INTO `who_can_apply` (`id`, `opportunity_id`, `criteria`) VALUES
(2, 1, 'Students & fresh graduates seeking industry exposure'),
(0, 0, 'Students & fresh graduates seeking industry exposure');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solar_requests`
--
ALTER TABLE `solar_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `solar_requests`
--
ALTER TABLE `solar_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
