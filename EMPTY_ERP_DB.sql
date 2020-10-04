-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2020 at 03:09 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_request`
--

CREATE TABLE `access_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_category`
--

CREATE TABLE `account_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_category`
--

INSERT INTO `account_category` (`id`, `category_name`, `status`) VALUES
(1, 'Account Receivable (A/R)', 1),
(2, 'Current Assets', 1),
(3, 'Bank', 1),
(4, 'Fixed Assets', 1),
(5, 'Other Assets', 1),
(6, 'Account Payable (A/P)', 1),
(7, 'Credit Card', 1),
(8, 'Other Current Liabilities', 1),
(9, 'Long Term Liabilites', 1),
(10, 'Equity', 1),
(11, 'Income', 1),
(12, 'Other Income', 1),
(13, 'Cost of Goods Sold', 1),
(14, 'Expenses', 1),
(15, 'Other Expense', 1);

-- --------------------------------------------------------

--
-- Table structure for table `account_chart`
--

CREATE TABLE `account_chart` (
  `id` int(11) NOT NULL,
  `acct_cat_id` int(11) NOT NULL,
  `detail_id` int(11) DEFAULT NULL,
  `acct_no` varchar(50) DEFAULT NULL,
  `acct_name` varchar(255) NOT NULL,
  `curr_id` int(11) DEFAULT NULL,
  `virtual_balance` varchar(20) DEFAULT NULL,
  `virtual_balance_trans` varchar(20) DEFAULT NULL,
  `original_cost` varchar(20) DEFAULT NULL,
  `bank_balance` varchar(20) DEFAULT NULL,
  `defualt_account` tinyint(1) NOT NULL DEFAULT '0',
  `active_status` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_chart`
--

INSERT INTO `account_chart` (`id`, `acct_cat_id`, `detail_id`, `acct_no`, `acct_name`, `curr_id`, `virtual_balance`, `virtual_balance_trans`, `original_cost`, `bank_balance`, `defualt_account`, `active_status`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 10, 51, NULL, 'Default Opening Balance Equity', 108, '500.00', '500.00', NULL, NULL, 1, 1, 1, 0, '1', '2018-02-23 12:21:18', '2020-08-25 19:04:46'),
(7, 3, 17, '88765443', 'Default Bank', 29, '3.13', '842.95', NULL, NULL, 1, 1, 1, 0, '0', '2018-10-24 17:40:31', '2020-08-27 01:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `account_journal`
--

CREATE TABLE `account_journal` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `extension_id` int(11) DEFAULT NULL,
  `acct_cat_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `chart_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `fin_year` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `bom_details` longtext,
  `trans_desc` varchar(255) DEFAULT NULL,
  `units` varchar(225) DEFAULT NULL,
  `quantity` varchar(15) DEFAULT NULL,
  `unit_measurement` varchar(100) DEFAULT NULL,
  `unit_cost` varchar(225) DEFAULT NULL,
  `unit_cost_trans` varchar(100) DEFAULT NULL,
  `extended_amount` varchar(225) NOT NULL,
  `extended_amount_trans` varchar(50) DEFAULT NULL,
  `total` varchar(225) NOT NULL,
  `trans_total` varchar(50) DEFAULT NULL,
  `tax_amount` varchar(15) DEFAULT NULL,
  `tax_amount_trans` varchar(15) DEFAULT NULL,
  `discount_amount` varchar(15) DEFAULT NULL,
  `discount_amount_trans` varchar(15) DEFAULT NULL,
  `discount_perct` int(11) DEFAULT NULL,
  `trans_date` date NOT NULL,
  `depreciation_status` varchar(50) DEFAULT NULL,
  `debit_credit` varchar(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_perct` varchar(5) DEFAULT NULL,
  `ex_rate` longtext,
  `curr_date` datetime DEFAULT NULL,
  `default_curr` varchar(160) NOT NULL,
  `trans_curr` varchar(160) NOT NULL,
  `main_trans` int(11) DEFAULT NULL,
  `vendor_customer` int(11) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `foreign_id` int(11) DEFAULT NULL,
  `transaction_type` int(11) DEFAULT NULL,
  `cash_status` tinyint(4) DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` varchar(160) NOT NULL,
  `updated_by` varchar(160) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `reconcile_id` int(11) DEFAULT NULL,
  `reconcile_status` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_status`
--

CREATE TABLE `account_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_status`
--

INSERT INTO `account_status` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Open', 1, '2020-03-19 16:07:30', '2020-03-19 16:07:30'),
(2, 'Closed', 1, '2020-03-19 16:07:30', '2020-03-19 16:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `admin_approval_dept`
--

CREATE TABLE `admin_approval_dept` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept` int(11) NOT NULL,
  `approval_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_approval_sys`
--

CREATE TABLE `admin_approval_sys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `approval_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_users` longtext COLLATE utf8mb4_unicode_ci,
  `levels` longtext COLLATE utf8mb4_unicode_ci,
  `users` longtext COLLATE utf8mb4_unicode_ci,
  `json_display` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_category`
--

CREATE TABLE `admin_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_requisition`
--

CREATE TABLE `admin_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `req_cat` int(11) NOT NULL,
  `req_type` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `req_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit_request` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_json` longtext COLLATE utf8mb4_unicode_ci,
  `approval_level` longtext COLLATE utf8mb4_unicode_ci,
  `approval_user` longtext COLLATE utf8mb4_unicode_ci,
  `approved_users` longtext COLLATE utf8mb4_unicode_ci,
  `approval_date` datetime DEFAULT NULL,
  `approval_id` int(11) NOT NULL,
  `approval_status` int(11) DEFAULT NULL,
  `request_user` int(11) NOT NULL,
  `dept_req_user` int(11) NOT NULL,
  `deny_user` int(11) NOT NULL,
  `complete_status` int(11) NOT NULL,
  `attachment` longtext COLLATE utf8mb4_unicode_ci,
  `views` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `proj_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_supervision`
--

CREATE TABLE `appraisal_supervision` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(225) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `approval_system`
--

CREATE TABLE `approval_system` (
  `id` int(11) NOT NULL,
  `approval_name` varchar(255) NOT NULL,
  `level_users` longtext NOT NULL,
  `levels` longtext NOT NULL,
  `users` longtext NOT NULL,
  `json_display` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assump_constraints`
--

CREATE TABLE `assump_constraints` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assump_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assump_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assump_constraints_comments`
--

CREATE TABLE `assump_constraints_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `assump_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temp_user` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_reconciliation`
--

CREATE TABLE `bank_reconciliation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `acct_cat_id` int(11) NOT NULL,
  `begining_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `begining_balance` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ending_balance` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deposits_cleared` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payments_cleared` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uncleared_deposits` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uncleared_payments` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_balance` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_balance` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_cleared_payments` int(11) DEFAULT NULL,
  `count_cleared_deposits` int(11) DEFAULT NULL,
  `count_uncleared_payments` int(11) DEFAULT NULL,
  `count_uncleared_deposits` int(11) DEFAULT NULL,
  `difference` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cleared_balance` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reconcile_date` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `behav_comp`
--

CREATE TABLE `behav_comp` (
  `id` int(11) NOT NULL,
  `indi_goal_id` int(11) NOT NULL,
  `core_behav_comp` varchar(225) NOT NULL,
  `element_behav_comp` longtext NOT NULL,
  `level` varchar(22) DEFAULT NULL,
  `reviewer_rating` varchar(225) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_method`
--

CREATE TABLE `bill_method` (
  `id` int(11) NOT NULL,
  `bill_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_method`
--

INSERT INTO `bill_method` (`id`, `bill_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Based on Project', 1, '0000-00-00', '0000-00-00'),
(2, 'Based on Staff Hours', 1, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `bin`
--

CREATE TABLE `bin` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `bin_desc` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bin_type`
--

CREATE TABLE `bin_type` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `bin_desc` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `budget_id` int(11) NOT NULL,
  `fin_year_id` int(11) NOT NULL,
  `request_cat_id` int(11) DEFAULT NULL,
  `acct_id` int(11) DEFAULT NULL,
  `acct_cat_id` int(11) DEFAULT NULL,
  `acct_detail_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `dimension` int(11) DEFAULT NULL,
  `jan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feb` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `march` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_quarter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `april` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `may` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `june` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_quarter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `july` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `august` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sept` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third_quarter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nov` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dec` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourth_quarter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cat_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_request_tracking`
--

CREATE TABLE `budget_request_tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budget_request_tracking`
--

INSERT INTO `budget_request_tracking` (`id`, `name`, `active_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', 0, 1, '2020-01-22 17:30:17', '2020-01-22 17:30:17'),
(2, 'Quarterly', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(3, 'Half Year', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(4, 'Yearly', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(5, 'Monthly Category', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(6, 'Quarterly Category', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(7, 'Half Year Category', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18'),
(8, 'Yearly Category', 0, 1, '2020-01-22 17:30:18', '2020-01-22 17:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `budget_summary`
--

CREATE TABLE `budget_summary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fin_year_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `approval_display` int(11) DEFAULT NULL,
  `budget_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approval_status` int(11) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `reviewer_comment` text COLLATE utf8mb4_unicode_ci,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `budget_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_logs`
--

CREATE TABLE `change_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `change_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_log_comments`
--

CREATE TABLE `change_log_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `change_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temp_user` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closing_books`
--

CREATE TABLE `closing_books` (
  `id` int(11) NOT NULL,
  `closing_date` date NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `active_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` int(11) NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competency_assess`
--

CREATE TABLE `competency_assess` (
  `id` int(11) NOT NULL,
  `indi_goal_id` int(11) NOT NULL,
  `core_comp` longtext NOT NULL,
  `capability` longtext,
  `level` varchar(22) DEFAULT NULL,
  `reviewer_rating` varchar(22) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_framework`
--

CREATE TABLE `competency_framework` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `comp_category` int(11) NOT NULL,
  `sub_comp_cat` int(11) NOT NULL DEFAULT '0',
  `comp_level` varchar(22) DEFAULT NULL,
  `item_desc` longtext,
  `min_aca_qual` varchar(225) DEFAULT NULL,
  `cog_exp` varchar(22) DEFAULT NULL,
  `pro_qual` longtext,
  `yr_post_cert` varchar(22) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_map`
--

CREATE TABLE `competency_map` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position_id` int(11) DEFAULT NULL,
  `comp_category` int(11) DEFAULT NULL,
  `sub_comp_cat` int(11) DEFAULT NULL,
  `comp_level` varchar(30) DEFAULT NULL,
  `item_desc` longtext,
  `mini_aca_qual` varchar(250) DEFAULT NULL,
  `cog_experience` varchar(225) DEFAULT NULL,
  `pro_qual` varchar(225) DEFAULT NULL,
  `yr_post_cert` varchar(225) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(5) NOT NULL,
  `countryCode` char(2) NOT NULL DEFAULT '',
  `countryName` varchar(45) NOT NULL DEFAULT '',
  `currencyCode` char(3) DEFAULT NULL,
  `population` varchar(20) DEFAULT NULL,
  `isoNumeric` char(4) DEFAULT NULL,
  `north` varchar(30) DEFAULT NULL,
  `south` varchar(30) DEFAULT NULL,
  `east` varchar(30) DEFAULT NULL,
  `west` varchar(30) DEFAULT NULL,
  `capital` varchar(30) DEFAULT NULL,
  `continentName` varchar(15) DEFAULT NULL,
  `continent` char(2) DEFAULT NULL,
  `areaInSqKm` varchar(20) DEFAULT NULL,
  `languages` varchar(100) DEFAULT NULL,
  `isoAlpha3` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `countryCode`, `countryName`, `currencyCode`, `population`, `isoNumeric`, `north`, `south`, `east`, `west`, `capital`, `continentName`, `continent`, `areaInSqKm`, `languages`, `isoAlpha3`) VALUES
(1, 'AF', 'Afghanistan', 'AFN', '29121286', '004', '38.4907920755748', '29.3770645357176', '74.8894511481168', '60.4720833972263', 'Kabul', 'Asia', 'AS', '647500.0', 'fa-AF,ps,uz-AF,tk', 'AFG'),
(2, 'AL', 'Albania', 'ALL', '2986952', '008', '42.6611669383269', '39.6448624829142', '21.0574334835312', '19.2639112711741', 'Tirana', 'Europe', 'EU', '28748.0', 'sq,el', 'ALB'),
(3, 'DZ', 'Algeria', 'DZD', '34586184', '012', '37.089801381', '18.968147', '11.9984999060001', '-8.66761116299995', 'Algiers', 'Africa', 'AF', '2381740.0', 'ar-DZ', 'DZA'),
(4, 'AS', 'American Samoa', 'USD', '57881', '016', '-11.0497', '-14.382478', '-169.416077', '-171.091888', 'Pago Pago', 'Oceania', 'OC', '199.0', 'en-AS,sm,to', 'ASM'),
(5, 'AD', 'Andorra', 'EUR', '84000', '020', '42.65576500000003', '42.42874300100004', '1.786576000000025', '1.413760001000071', 'Andorra la Vella', 'Europe', 'EU', '468.0', 'ca', 'AND'),
(6, 'AO', 'Angola', 'AOA', '13068161', '024', '-4.376826', '-18.042076', '24.082119', '11.679219', 'Luanda', 'Africa', 'AF', '1246700.0', 'pt-AO', 'AGO'),
(7, 'AI', 'Anguilla', 'XCD', '13254', '660', '18.276901971658063', '18.160292974311673', '-62.96655544577948', '-63.16808989603879', 'The Valley', 'North America', 'NA', '102.0', 'en-AI', 'AIA'),
(8, 'AQ', 'Antarctica', '', '0', '010', '-60.515533', '-89.9999', '179.9999', '-179.9999', '', 'Antarctica', 'AN', '1.4E7', '', 'ATA'),
(9, 'AG', 'Antigua and Barbuda', 'XCD', '86754', '028', '17.729387', '16.996979', '-61.672421', '-61.906425', 'St. John\'s', 'North America', 'NA', '443.0', 'en-AG', 'ATG'),
(10, 'AR', 'Argentina', 'ARS', '41343201', '032', '-21.777951173', '-55.0576984539999', '-53.637962552', '-73.566302817', 'Buenos Aires', 'South America', 'SA', '2766890.0', 'es-AR,en,it,de,fr,gn', 'ARG'),
(11, 'AM', 'Armenia', 'AMD', '2968000', '051', '41.301834', '38.841972', '46.6289052796227', '43.44978000000003', 'Yerevan', 'Asia', 'AS', '29800.0', 'hy', 'ARM'),
(12, 'AW', 'Aruba', 'AWG', '71566', '533', '12.623718127152924', '12.411707706190716', '-69.86575120104982', '-70.0644737196045', 'Oranjestad', 'North America', 'NA', '193.0', 'nl-AW,pap,es,en', 'ABW'),
(13, 'AU', 'Australia', 'AUD', '21515754', '036', '-10.062805', '-43.64397', '153.639252', '112.911057', 'Canberra', 'Oceania', 'OC', '7686850.0', 'en-AU', 'AUS'),
(14, 'AT', 'Austria', 'EUR', '8205000', '040', '49.0211627691393', '46.3726520216244', '17.1620685652599', '9.53095237240833', 'Vienna', 'Europe', 'EU', '83858.0', 'de-AT,hr,hu,sl', 'AUT'),
(15, 'AZ', 'Azerbaijan', 'AZN', '8303512', '031', '41.90564', '38.38915252685547', '50.370083', '44.774113', 'Baku', 'Asia', 'AS', '86600.0', 'az,ru,hy', 'AZE'),
(16, 'BS', 'Bahamas', 'BSD', '301790', '044', '26.919243', '22.852743', '-74.423874', '-78.995911', 'Nassau', 'North America', 'NA', '13940.0', 'en-BS', 'BHS'),
(17, 'BH', 'Bahrain', 'BHD', '738004', '048', '26.3308150010001', '25.790910001', '50.720622', '50.3158550000001', 'Manama', 'Asia', 'AS', '665.0', 'ar-BH,en,fa,ur', 'BHR'),
(18, 'BD', 'Bangladesh', 'BDT', '156118464', '050', '26.631945', '20.743334', '92.673668', '88.028336', 'Dhaka', 'Asia', 'AS', '144000.0', 'bn-BD,en', 'BGD'),
(19, 'BB', 'Barbados', 'BBD', '285653', '052', '13.3358612060001', '13.0448331850001', '-59.420749664', '-59.6526374819999', 'Bridgetown', 'North America', 'NA', '431.0', 'en-BB', 'BRB'),
(20, 'BY', 'Belarus', 'BYN', '9685000', '112', '56.1724940010001', '51.262011', '32.776820001', '23.1781980010001', 'Minsk', 'Europe', 'EU', '207600.0', 'be,ru', 'BLR'),
(21, 'BE', 'Belgium', 'EUR', '10403000', '056', '51.5051118897455', '49.496968483036', '6.40793743953125', '2.54132898439873', 'Brussels', 'Europe', 'EU', '30510.0', 'nl-BE,fr-BE,de-BE', 'BEL'),
(22, 'BZ', 'Belize', 'BZD', '314522', '084', '18.496557', '15.8893', '-87.776985', '-89.224815', 'Belmopan', 'North America', 'NA', '22966.0', 'en-BZ,es', 'BLZ'),
(23, 'BJ', 'Benin', 'XOF', '9056010', '204', '12.4086110000001', '6.23477794100006', '3.84306303800003', '0.775412326000037', 'Porto-Novo', 'Africa', 'AF', '112620.0', 'fr-BJ', 'BEN'),
(24, 'BM', 'Bermuda', 'BMD', '65365', '060', '32.39122351646162', '32.247551', '-64.64718648144531', '-64.88723800000002', 'Hamilton', 'North America', 'NA', '53.0', 'en-BM,pt', 'BMU'),
(25, 'BT', 'Bhutan', 'BTN', '699847', '064', '28.246987001', '26.702020985', '92.12523192', '88.7455215570001', 'Thimphu', 'Asia', 'AS', '47000.0', 'dz', 'BTN'),
(26, 'BO', 'Bolivia', 'BOB', '9947418', '068', '-9.66932299899997', '-22.89809', '-57.4538029999999', '-69.644939573', 'Sucre', 'South America', 'SA', '1098580.0', 'es-BO,qu,ay', 'BOL'),
(27, 'BQ', 'Bonaire', 'USD', '18012', '535', '12.304535', '12.017149', '-68.192307', '-68.416458', 'Kralendijk', 'North America', 'NA', '328.0', 'nl,pap,en', 'BES'),
(28, 'BA', 'Bosnia and Herzegovina', 'BAM', '4590000', '070', '45.276539649', '42.555473846', '19.6237016800001', '15.728732108', 'Sarajevo', 'Europe', 'EU', '51129.0', 'bs,hr-BA,sr-BA', 'BIH'),
(29, 'BW', 'Botswana', 'BWP', '2029307', '072', '-17.778136999', '-26.907545', '29.375304', '19.998903', 'Gaborone', 'Africa', 'AF', '600370.0', 'en-BW,tn-BW', 'BWA'),
(30, 'BV', 'Bouvet Island', 'NOK', '0', '074', '-54.3887383509872', '-54.4507993522734', '3.434845577758324', '3.286776428037342', '', 'Antarctica', 'AN', '49.0', '', 'BVT'),
(31, 'BR', 'Brazil', 'BRL', '201103330', '076', '5.264877', '-33.750706', '-32.392998', '-73.985535', 'Brasília', 'South America', 'SA', '8511965.0', 'pt-BR,es,en,fr', 'BRA'),
(32, 'IO', 'British Indian Ocean Territory', 'USD', '4000', '086', '-5.268333', '-7.438028', '72.493164', '71.259972', '', 'Asia', 'AS', '60.0', 'en-IO', 'IOT'),
(33, 'VG', 'British Virgin Islands', 'USD', '21730', '092', '18.757221', '18.383710898211305', '-64.268768', '-64.71312752730364', 'Road Town', 'North America', 'NA', '153.0', 'en-VG', 'VGB'),
(34, 'BN', 'Brunei', 'BND', '395027', '096', '5.04571171901151', '4.00264384400003', '115.364671704', '114.075926291', 'Bandar Seri Begawan', 'Asia', 'AS', '5770.0', 'ms-BN,en-BN', 'BRN'),
(35, 'BG', 'Bulgaria', 'BGN', '7148785', '100', '44.215451', '41.2353414930001', '28.6102771760001', '22.357156753', 'Sofia', 'Europe', 'EU', '110910.0', 'bg,tr-BG,rom', 'BGR'),
(36, 'BF', 'Burkina Faso', 'XOF', '16241811', '854', '15.084033447', '9.41047177500008', '2.40435976900005', '-5.51324157299996', 'Ouagadougou', 'Africa', 'AF', '274200.0', 'fr-BF,mos', 'BFA'),
(37, 'BI', 'Burundi', 'BIF', '9863117', '108', '-2.30973016299993', '-4.46932899899997', '30.84954', '29.0009680000001', 'Bujumbura', 'Africa', 'AF', '27830.0', 'fr-BI,rn', 'BDI'),
(38, 'KH', 'Cambodia', 'KHR', '14453680', '116', '14.686417', '10.409083', '107.627724', '102.339996', 'Phnom Penh', 'Asia', 'AS', '181040.0', 'km,fr,en', 'KHM'),
(39, 'CM', 'Cameroon', 'XAF', '19294149', '120', '13.083334', '1.65590000000003', '16.1944080000001', '8.49843402900007', 'Yaoundé', 'Africa', 'AF', '475440.0', 'en-CM,fr-CM', 'CMR'),
(40, 'CA', 'Canada', 'CAD', '33679000', '124', '83.110626', '41.67598', '-52.636291', '-141', 'Ottawa', 'North America', 'NA', '9984670.0', 'en-CA,fr-CA,iu', 'CAN'),
(41, 'CV', 'Cape Verde', 'CVE', '508659', '132', '17.197178', '14.808022', '-22.669443', '-25.358747', 'Praia', 'Africa', 'AF', '4033.0', 'pt-CV', 'CPV'),
(42, 'KY', 'Cayman Islands', 'KYD', '44270', '136', '19.7617', '19.263029', '-79.727272', '-81.432777', 'George Town', 'North America', 'NA', '262.0', 'en-KY', 'CYM'),
(43, 'CF', 'Central African Republic', 'XAF', '4844927', '140', '11.017957', '2.22305300000005', '27.4583050000001', '14.4150980000001', 'Bangui', 'Africa', 'AF', '622984.0', 'fr-CF,sg,ln,kg', 'CAF'),
(44, 'TD', 'Chad', 'XAF', '10543464', '148', '23.4523611160001', '7.44297500000005', '24.0000000000001', '13.47', 'N\'Djamena', 'Africa', 'AF', '1284000.0', 'fr-TD,ar-TD,sre', 'TCD'),
(45, 'CL', 'Chile', 'CLP', '16746491', '152', '-17.4977759459999', '-55.909795409', '-66.416152278', '-80.8370287079999', 'Santiago', 'South America', 'SA', '756950.0', 'es-CL', 'CHL'),
(46, 'CN', 'China', 'CNY', '1330044000', '156', '53.56086', '15.775416', '134.773911', '73.557693', 'Beijing', 'Asia', 'AS', '9596960.0', 'zh-CN,yue,wuu,dta,ug,za', 'CHN'),
(47, 'CX', 'Christmas Island', 'AUD', '1500', '162', '-10.412356007', '-10.5704829995', '105.712596992', '105.533276992', 'Flying Fish Cove', 'Oceania', 'OC', '135.0', 'en,zh,ms-CC', 'CXR'),
(48, 'CC', 'Cocos [Keeling] Islands', 'AUD', '628', '166', '-12.072459094', '-12.208725839', '96.929489344', '96.816941408', 'West Island', 'Asia', 'AS', '14.0', 'ms-CC,en', 'CCK'),
(49, 'CO', 'Colombia', 'COP', '47790000', '170', '13.38600323', '-4.22839224299997', '-66.8472153989999', '-81.735775648', 'Bogotá', 'South America', 'SA', '1138910.0', 'es-CO', 'COL'),
(50, 'KM', 'Comoros', 'KMF', '773407', '174', '-11.362381', '-12.387857', '44.538223', '43.21579', 'Moroni', 'Africa', 'AF', '2170.0', 'ar,fr-KM', 'COM'),
(51, 'CK', 'Cook Islands', 'NZD', '21388', '184', '-10.023114', '-21.944164', '-157.312134', '-161.093658', 'Avarua', 'Oceania', 'OC', '240.0', 'en-CK,mi', 'COK'),
(52, 'CR', 'Costa Rica', 'CRC', '4516220', '188', '11.2197589122308', '8.03962731803416', '-82.552318987959', '-85.9502523586265', 'San José', 'North America', 'NA', '51100.0', 'es-CR,en', 'CRI'),
(53, 'HR', 'Croatia', 'HRK', '4284889', '191', '46.5549629558487', '42.43589', '19.427389', '13.493222', 'Zagreb', 'Europe', 'EU', '56542.0', 'hr-HR,sr', 'HRV'),
(54, 'CU', 'Cuba', 'CUP', '11423000', '192', '23.226042', '19.828083', '-74.131775', '-84.957428', 'Havana', 'North America', 'NA', '110860.0', 'es-CU,pap', 'CUB'),
(55, 'CW', 'Curacao', 'ANG', '141766', '531', '12.385672', '12.032745', '-68.733948', '-69.157204', 'Willemstad', 'North America', 'NA', '444.0', 'nl,pap', 'CUW'),
(56, 'CY', 'Cyprus', 'EUR', '1102677', '196', '35.701527', '34.6332846722908', '34.59791599999994', '32.27308300000004', 'Nicosia', 'Europe', 'EU', '9250.0', 'el-CY,tr-CY,en', 'CYP'),
(57, 'CZ', 'Czechia', 'CZK', '10476000', '203', '51.055384001', '48.5519105430001', '18.859266', '12.091575', 'Prague', 'Europe', 'EU', '78866.0', 'cs,sk', 'CZE'),
(58, 'CD', 'Democratic Republic of the Congo', 'CDF', '70916439', '180', '5.39200300000005', '-13.459034999', '31.3146120000001', '12.202361491', 'Kinshasa', 'Africa', 'AF', '2345410.0', 'fr-CD,ln,ktu,kg,sw,lua', 'COD'),
(59, 'DK', 'Denmark', 'DKK', '5484000', '208', '57.748417', '54.562389', '15.158834', '8.075611', 'Copenhagen', 'Europe', 'EU', '43094.0', 'da-DK,en,fo,de-DK', 'DNK'),
(60, 'DJ', 'Djibouti', 'DJF', '740528', '262', '12.7136967920001', '10.9129530000001', '43.4175099920001', '41.7708460000001', 'Djibouti', 'Africa', 'AF', '23000.0', 'fr-DJ,ar,so-DJ,aa', 'DJI'),
(61, 'DM', 'Dominica', 'XCD', '72813', '212', '15.639901700674933', '15.206540651392563', '-61.241630129651185', '-61.4808292002466', 'Roseau', 'North America', 'NA', '754.0', 'en-DM', 'DMA'),
(62, 'DO', 'Dominican Republic', 'DOP', '9823821', '214', '19.9321257501267', '17.5395066830409', '-68.3229591969468', '-72.0114723981787', 'Santo Domingo', 'North America', 'NA', '48730.0', 'es-DO', 'DOM'),
(63, 'TL', 'East Timor', 'USD', '1154625', '626', '-8.12687015533447', '-9.504650115966796', '127.34211730957031', '124.04464721679687', 'Dili', 'Oceania', 'OC', '15007.0', 'tet,pt-TL,id,en', 'TLS'),
(64, 'EC', 'Ecuador', 'USD', '14790608', '218', '1.43523516349953', '-5.01615732302488', '-75.1871465547501', '-81.0836838953894', 'Quito', 'South America', 'SA', '283560.0', 'es-EC', 'ECU'),
(65, 'EG', 'Egypt', 'EGP', '80471869', '818', '31.6709930000001', '21.724952', '35.7935441020001', '24.6967750000001', 'Cairo', 'Africa', 'AF', '1001450.0', 'ar-EG,en,fr', 'EGY'),
(66, 'SV', 'El Salvador', 'USD', '6052064', '222', '14.450557001', '13.153004391', '-87.692162', '-90.134654476', 'San Salvador', 'North America', 'NA', '21040.0', 'es-SV', 'SLV'),
(67, 'GQ', 'Equatorial Guinea', 'XAF', '1014999', '226', '2.346989', '0.92086', '11.335724', '9.346865', 'Malabo', 'Africa', 'AF', '28051.0', 'es-GQ,fr', 'GNQ'),
(68, 'ER', 'Eritrea', 'ERN', '5792984', '232', '18.003084', '12.359555', '43.13464', '36.438778', 'Asmara', 'Africa', 'AF', '121320.0', 'aa-ER,ar,tig,kun,ti-ER', 'ERI'),
(69, 'EE', 'Estonia', 'EUR', '1291170', '233', '59.6753143130129', '57.5093097920079', '28.2090381531431', '21.8285886498081', 'Tallinn', 'Europe', 'EU', '45226.0', 'et,ru', 'EST'),
(70, 'ET', 'Ethiopia', 'ETB', '88013491', '231', '14.894214', '3.40413700100004', '48.0010560010001', '32.997734001', 'Addis Ababa', 'Africa', 'AF', '1127127.0', 'am,en-ET,om-ET,ti-ET,so-ET,sid', 'ETH'),
(71, 'FK', 'Falkland Islands', 'FKP', '2638', '238', '-51.2331394719999', '-52.383984175', '-57.718087652', '-61.3474566739999', 'Stanley', 'South America', 'SA', '12173.0', 'en-FK', 'FLK'),
(72, 'FO', 'Faroe Islands', 'DKK', '48228', '234', '62.3938884414274', '61.3910302656013', '-6.25655957192113', '-7.688191677774624', 'Tórshavn', 'Europe', 'EU', '1399.0', 'fo,da-FO', 'FRO'),
(73, 'FJ', 'Fiji', 'FJD', '875983', '242', '-12.479632058714331', '-20.67597', '-178.424438', '177.14038537647912', 'Suva', 'Oceania', 'OC', '18270.0', 'en-FJ,fj', 'FJI'),
(74, 'FI', 'Finland', 'EUR', '5244000', '246', '70.096054', '59.808777', '31.580944', '20.556944', 'Helsinki', 'Europe', 'EU', '337030.0', 'fi-FI,sv-FI,smn', 'FIN'),
(75, 'FR', 'France', 'EUR', '64768389', '250', '51.0890012279322', '41.3658213299999', '9.5596148665824', '-5.1389964684508', 'Paris', 'Europe', 'EU', '547030.0', 'fr-FR,frp,br,co,ca,eu,oc', 'FRA'),
(76, 'GF', 'French Guiana', 'EUR', '195506', '254', '5.776496', '2.127094', '-51.613949', '-54.542511', 'Cayenne', 'South America', 'SA', '91000.0', 'fr-GF', 'GUF'),
(77, 'PF', 'French Polynesia', 'XPF', '270485', '258', '-7.903573', '-27.653572', '-134.929825', '-152.877167', 'Papeete', 'Oceania', 'OC', '4167.0', 'fr-PF,ty', 'PYF'),
(78, 'TF', 'French Southern Territories', 'EUR', '140', '260', '-37.790722', '-49.735184', '77.598808', '50.170258', 'Port-aux-Français', 'Antarctica', 'AN', '7829.0', 'fr', 'ATF'),
(79, 'GA', 'Gabon', 'XAF', '1545255', '266', '2.31810900100004', '-3.96180775999994', '14.5269230000001', '8.69940944700005', 'Libreville', 'Africa', 'AF', '267667.0', 'fr-GA', 'GAB'),
(80, 'GM', 'Gambia', 'GMD', '1593256', '270', '13.825058106', '13.063718062', '-13.791386179', '-16.8136100139999', 'Bathurst', 'Africa', 'AF', '11300.0', 'en-GM,mnk,wof,wo,ff', 'GMB'),
(81, 'GE', 'Georgia', 'GEL', '4630000', '268', '43.5866270000001', '41.054942', '46.736119', '40.006604', 'Tbilisi', 'Asia', 'AS', '69700.0', 'ka,ru,hy,az', 'GEO'),
(82, 'DE', 'Germany', 'EUR', '81802257', '276', '55.0583836008072', '47.2701236047002', '15.0418156516163', '5.8663152683722', 'Berlin', 'Europe', 'EU', '357021.0', 'de', 'DEU'),
(83, 'GH', 'Ghana', 'GHS', '24339838', '288', '11.174952907', '4.73894544800004', '1.19948138100006', '-3.26078599999994', 'Accra', 'Africa', 'AF', '239460.0', 'en-GH,ak,ee,tw', 'GHA'),
(84, 'GI', 'Gibraltar', 'GIP', '27884', '292', '36.155439135670726', '36.10903070140248', '-5.338285164001491', '-5.36626149743654', 'Gibraltar', 'Europe', 'EU', '6.5', 'en-GI,es,it,pt', 'GIB'),
(85, 'GR', 'Greece', 'EUR', '11000000', '300', '41.7484999849641', '34.8020663391466', '28.2470831714347', '19.3736035624134', 'Athens', 'Europe', 'EU', '131940.0', 'el-GR,en,fr', 'GRC'),
(86, 'GL', 'Greenland', 'DKK', '56375', '304', '83.627357', '59.777401', '-11.312319', '-73.04203', 'Nuuk', 'North America', 'NA', '2166086.0', 'kl,da-GL,en', 'GRL'),
(87, 'GD', 'Grenada', 'XCD', '107818', '308', '12.318283928171299', '11.986893', '-61.57676970108031', '-61.802344', 'St. George\'s', 'North America', 'NA', '344.0', 'en-GD', 'GRD'),
(88, 'GP', 'Guadeloupe', 'EUR', '443000', '312', '16.516848', '15.867565', '-61', '-61.544765', 'Basse-Terre', 'North America', 'NA', '1780.0', 'fr-GP', 'GLP'),
(89, 'GU', 'Guam', 'USD', '159358', '316', '13.654402', '13.23376', '144.956894', '144.61806', 'Hagåtña', 'Oceania', 'OC', '549.0', 'en-GU,ch-GU', 'GUM'),
(90, 'GT', 'Guatemala', 'GTQ', '13550440', '320', '17.815695169', '13.7400210010001', '-88.233001934', '-92.231143101', 'Guatemala City', 'North America', 'NA', '108890.0', 'es-GT', 'GTM'),
(91, 'GG', 'Guernsey', 'GBP', '65228', '831', '49.731727816705415', '49.40764156876899', '-2.1577152112246267', '-2.673194593476069', 'St Peter Port', 'Europe', 'EU', '78.0', 'en,nrf', 'GGY'),
(92, 'GN', 'Guinea', 'GNF', '10324025', '324', '12.67622', '7.193553', '-7.641071', '-14.926619', 'Conakry', 'Africa', 'AF', '245857.0', 'fr-GN', 'GIN'),
(93, 'GW', 'Guinea-Bissau', 'XOF', '1565126', '624', '12.680789', '10.924265', '-13.636522', '-16.717535', 'Bissau', 'Africa', 'AF', '36120.0', 'pt-GW,pov', 'GNB'),
(94, 'GY', 'Guyana', 'GYD', '748486', '328', '8.557567', '1.17508', '-56.480251', '-61.384762', 'Georgetown', 'South America', 'SA', '214970.0', 'en-GY', 'GUY'),
(95, 'HT', 'Haiti', 'HTG', '9648924', '332', '20.08782', '18.021032', '-71.613358', '-74.478584', 'Port-au-Prince', 'North America', 'NA', '27750.0', 'ht,fr-HT', 'HTI'),
(96, 'HM', 'Heard Island and McDonald Islands', 'AUD', '0', '334', '-52.909416', '-53.192001', '73.859146', '72.596535', '', 'Antarctica', 'AN', '412.0', '', 'HMD'),
(97, 'HN', 'Honduras', 'HNL', '7989415', '340', '16.510256', '12.982411', '-83.155403', '-89.350792', 'Tegucigalpa', 'North America', 'NA', '112090.0', 'es-HN,cab,miq', 'HND'),
(98, 'HK', 'Hong Kong', 'HKD', '6898686', '344', '22.559778', '22.15325', '114.434753', '113.837753', 'Hong Kong', 'Asia', 'AS', '1092.0', 'zh-HK,yue,zh,en', 'HKG'),
(99, 'HU', 'Hungary', 'HUF', '9982000', '348', '48.585336', '45.7370495590001', '22.896564336', '16.113795', 'Budapest', 'Europe', 'EU', '93030.0', 'hu-HU', 'HUN'),
(100, 'IS', 'Iceland', 'ISK', '308910', '352', '66.5377933098397', '63.394392778588', '-13.4946206239501', '-24.5326753866625', 'Reykjavik', 'Europe', 'EU', '103000.0', 'is,en,de,da,sv,no', 'ISL'),
(101, 'IN', 'India', 'INR', '1173108018', '356', '35.524548272882', '6.7559528993543', '97.4152926679075', '68.4840183183648', 'New Delhi', 'Asia', 'AS', '3287590.0', 'en-IN,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,bh,sat,ks,ne,sd,kok,doi,mni,sit,sa,fr,lus,inc', 'IND'),
(102, 'ID', 'Indonesia', 'IDR', '242968342', '360', '5.904417', '-10.941861', '141.021805', '95.009331', 'Jakarta', 'Asia', 'AS', '1919440.0', 'id,en,nl,jv', 'IDN'),
(103, 'IR', 'Iran', 'IRR', '76923300', '364', '39.777222', '25.064083', '63.317471', '44.047279', 'Tehran', 'Asia', 'AS', '1648000.0', 'fa-IR,ku', 'IRN'),
(104, 'IQ', 'Iraq', 'IQD', '29671605', '368', '37.380746001', '29.0612080000001', '48.6117360000001', '38.7936740000001', 'Baghdad', 'Asia', 'AS', '437072.0', 'ar-IQ,ku,hy', 'IRQ'),
(105, 'IE', 'Ireland', 'EUR', '4622917', '372', '55.3829431564742', '51.4475491577615', '-5.99804990172185', '-10.4800035816853', 'Dublin', 'Europe', 'EU', '70280.0', 'en-IE,ga-IE', 'IRL'),
(106, 'IM', 'Isle of Man', 'GBP', '75049', '833', '54.419724', '54.055916', '-4.3115', '-4.798722', 'Douglas', 'Europe', 'EU', '572.0', 'en,gv', 'IMN'),
(107, 'IL', 'Israel', 'ILS', '7353985', '376', '33.2908350000001', '29.490654862', '35.67033', '34.267257', '', 'Asia', 'AS', '20770.0', 'he,ar-IL,en-IL,', 'ISR'),
(108, 'IT', 'Italy', 'EUR', '60340328', '380', '47.0917837415439', '36.6440816661648', '18.5203814091888', '6.62662135986088', 'Rome', 'Europe', 'EU', '301230.0', 'it-IT,de-IT,fr-IT,sc,ca,co,sl', 'ITA'),
(109, 'CI', 'Ivory Coast', 'XOF', '21058798', '384', '10.740015', '4.36035248000007', '-2.49303099999997', '-8.60205899999994', 'Yamoussoukro', 'Africa', 'AF', '322460.0', 'fr-CI', 'CIV'),
(110, 'JM', 'Jamaica', 'JMD', '2847232', '388', '18.524766185516', '17.7059966193696', '-76.1830989848426', '-78.3690062954957', 'Kingston', 'North America', 'NA', '10991.0', 'en-JM', 'JAM'),
(111, 'JP', 'Japan', 'JPY', '127288000', '392', '45.52295736', '24.255169441', '145.817458885', '122.933653061', 'Tokyo', 'Asia', 'AS', '377835.0', 'ja', 'JPN'),
(112, 'JE', 'Jersey', 'GBP', '90812', '832', '49.265057', '49.169834', '-2.022083', '-2.260028', 'Saint Helier', 'Europe', 'EU', '116.0', 'en,fr,nrf', 'JEY'),
(113, 'JO', 'Jordan', 'JOD', '6407085', '400', '33.374735', '29.1850360010001', '39.3011540000001', '34.955471039', 'Amman', 'Asia', 'AS', '92300.0', 'ar-JO,en', 'JOR'),
(114, 'KZ', 'Kazakhstan', 'KZT', '15340000', '398', '55.441984001', '40.5686884990001', '87.3154150010001', '46.4936720000001', 'Astana', 'Asia', 'AS', '2717300.0', 'kk,ru', 'KAZ'),
(115, 'KE', 'Kenya', 'KES', '40046566', '404', '5.03342100100002', '-4.67989449199996', '41.9069450000001', '33.9098210000001', 'Nairobi', 'Africa', 'AF', '582650.0', 'en-KE,sw-KE', 'KEN'),
(116, 'KI', 'Kiribati', 'AUD', '92533', '296', '4.71957', '-11.446881150186856', '-150.215347', '169.556137', 'Tarawa', 'Oceania', 'OC', '811.0', 'en-KI,gil', 'KIR'),
(117, 'XK', 'Kosovo', 'EUR', '1800000', '0', '43.2676851730001', '41.857641001', '21.7898670000001', '20.014284', 'Pristina', 'Europe', 'EU', '10908.0', 'sq,sr', 'XKX'),
(118, 'KW', 'Kuwait', 'KWD', '2789132', '414', '30.095945', '28.524611', '48.431473', '46.555557', 'Kuwait City', 'Asia', 'AS', '17820.0', 'ar-KW,en', 'KWT'),
(119, 'KG', 'Kyrgyzstan', 'KGS', '5776500', '417', '43.238224', '39.172832', '80.283165', '69.276611', 'Bishkek', 'Asia', 'AS', '198500.0', 'ky,uz,ru', 'KGZ'),
(120, 'LA', 'Laos', 'LAK', '6368162', '418', '22.50904495', '13.909720001', '107.635093936', '100.083872', 'Vientiane', 'Asia', 'AS', '236800.0', 'lo,fr,en', 'LAO'),
(121, 'LV', 'Latvia', 'EUR', '2217969', '428', '58.085568788', '55.6746669350001', '28.241403', '20.9691104890001', 'Riga', 'Europe', 'EU', '64589.0', 'lv,ru,lt', 'LVA'),
(122, 'LB', 'Lebanon', 'LBP', '4125247', '422', '34.6920900000001', '33.0550260000001', '36.62372', '35.103668213', 'Beirut', 'Asia', 'AS', '10400.0', 'ar-LB,fr-LB,en,hy', 'LBN'),
(123, 'LS', 'Lesotho', 'LSL', '1919552', '426', '-28.5708', '-30.6755750029999', '29.4557099420001', '27.011229998', 'Maseru', 'Africa', 'AF', '30355.0', 'en-LS,st,zu,xh', 'LSO'),
(124, 'LR', 'Liberia', 'LRD', '3685076', '430', '8.55198600000006', '4.35326143300006', '-7.36925499999995', '-11.4993114059999', 'Monrovia', 'Africa', 'AF', '111370.0', 'en-LR', 'LBR'),
(125, 'LY', 'Libya', 'LYD', '6461454', '434', '33.168999', '19.508045', '25.150612', '9.38702', 'Tripoli', 'Africa', 'AF', '1759540.0', 'ar-LY,it,en', 'LBY'),
(126, 'LI', 'Liechtenstein', 'CHF', '35000', '438', '47.2706251386959', '47.0484284123471', '9.63564281136796', '9.47167359782014', 'Vaduz', 'Europe', 'EU', '160.0', 'de-LI', 'LIE'),
(127, 'LT', 'Lithuania', 'EUR', '2944459', '440', '56.4504065100001', '53.89679499', '26.8355231', '20.941528', 'Vilnius', 'Europe', 'EU', '65200.0', 'lt,ru,pl', 'LTU'),
(128, 'LU', 'Luxembourg', 'EUR', '497538', '442', '50.182772453796446', '49.447858677765716', '6.5308980672559524', '5.735698938390786', 'Luxembourg', 'Europe', 'EU', '2586.0', 'lb,de-LU,fr-LU', 'LUX'),
(129, 'MO', 'Macao', 'MOP', '449198', '446', '22.2170590110001', '22.179927465', '113.56087212', '113.528563856', 'Macao', 'Asia', 'AS', '254.0', 'zh,zh-MO,pt', 'MAC'),
(130, 'MK', 'Macedonia', 'MKD', '2062294', '807', '42.3736460000001', '40.8539489400001', '23.0340440310001', '20.4524230000001', 'Skopje', 'Europe', 'EU', '25333.0', 'mk,sq,tr,rmm,sr', 'MKD'),
(131, 'MG', 'Madagascar', 'MGA', '21281844', '450', '-11.945433', '-25.608952', '50.48378', '43.224876', 'Antananarivo', 'Africa', 'AF', '587040.0', 'fr-MG,mg', 'MDG'),
(132, 'MW', 'Malawi', 'MWK', '15447500', '454', '-9.36722739199996', '-17.1295217059999', '35.9185731040001', '32.6725205490001', 'Lilongwe', 'Africa', 'AF', '118480.0', 'ny,yao,tum,swk', 'MWI'),
(133, 'MY', 'Malaysia', 'MYR', '28274729', '458', '7.363417', '0.855222', '119.267502', '99.643448', 'Kuala Lumpur', 'Asia', 'AS', '329750.0', 'ms-MY,en,zh,ta,te,ml,pa,th', 'MYS'),
(134, 'MV', 'Maldives', 'MVR', '395650', '462', '7.091587495414767', '-0.692694', '73.637276', '72.693222', 'Malé', 'Asia', 'AS', '300.0', 'dv,en', 'MDV'),
(135, 'ML', 'Mali', 'XOF', '13796354', '466', '25.001084', '10.147811', '4.26666786900006', '-12.240344643', 'Bamako', 'Africa', 'AF', '1240000.0', 'fr-ML,bm', 'MLI'),
(136, 'MT', 'Malta', 'EUR', '403000', '470', '36.0821530995456', '35.8061835000002', '14.5764915000002', '14.1834251000001', 'Valletta', 'Europe', 'EU', '316.0', 'mt,en-MT', 'MLT'),
(137, 'MH', 'Marshall Islands', 'USD', '65859', '584', '14.62', '5.587639', '171.931808', '165.524918', 'Majuro', 'Oceania', 'OC', '181.3', 'mh,en-MH', 'MHL'),
(138, 'MQ', 'Martinique', 'EUR', '432900', '474', '14.8793869227087', '14.3948095793821', '-60.80971372311262', '-61.22906667943528', 'Fort-de-France', 'North America', 'NA', '1100.0', 'fr-MQ', 'MTQ'),
(139, 'MR', 'Mauritania', 'MRO', '3205060', '478', '27.298073', '14.715547', '-4.827674', '-17.066521', 'Nouakchott', 'Africa', 'AF', '1030700.0', 'ar-MR,fuc,snk,fr,mey,wo', 'MRT'),
(140, 'MU', 'Mauritius', 'MUR', '1294104', '480', '-10.319255', '-20.525717', '63.500179', '56.512718', 'Port Louis', 'Africa', 'AF', '2040.0', 'en-MU,bho,fr', 'MUS'),
(141, 'YT', 'Mayotte', 'EUR', '159042', '175', '-12.648891', '-13.000132', '45.29295', '45.03796', 'Mamoudzou', 'Africa', 'AF', '374.0', 'fr-YT', 'MYT'),
(142, 'MX', 'Mexico', 'MXN', '112468855', '484', '32.716759', '14.532866', '-86.703392', '-118.453949', 'Mexico City', 'North America', 'NA', '1972550.0', 'es-MX', 'MEX'),
(143, 'FM', 'Micronesia', 'USD', '107708', '583', '10.08904', '1.02629', '163.03717', '137.33648', 'Palikir', 'Oceania', 'OC', '702.0', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', 'FSM'),
(144, 'MD', 'Moldova', 'MDL', '4324000', '498', '48.492029003', '45.4674379630001', '30.1635900000001', '26.6164249990001', 'Chişinău', 'Europe', 'EU', '33843.0', 'ro,ru,gag,tr', 'MDA'),
(145, 'MC', 'Monaco', 'EUR', '32965', '492', '43.75196717037228', '43.72472839869377', '7.439939260482788', '7.408962249755859', 'Monaco', 'Europe', 'EU', '1.95', 'fr-MC,en,it', 'MCO'),
(146, 'MN', 'Mongolia', 'MNT', '3086918', '496', '52.1483550020001', '41.5818330000001', '119.931509803', '87.7344790560001', 'Ulan Bator', 'Asia', 'AS', '1565000.0', 'mn,ru', 'MNG'),
(147, 'ME', 'Montenegro', 'EUR', '666730', '499', '43.558230232', '41.868751527', '20.352926', '18.4335595800001', 'Podgorica', 'Europe', 'EU', '14026.0', 'sr,hu,bs,sq,hr,rom', 'MNE'),
(148, 'MS', 'Montserrat', 'XCD', '9341', '500', '16.824060205313184', '16.674768935441555', '-62.144100129608205', '-62.24138237036129', 'Plymouth', 'North America', 'NA', '102.0', 'en-MS', 'MSR'),
(149, 'MA', 'Morocco', 'MAD', '33848242', '504', '35.922341095', '27.6672694750001', '-0.996975780999946', '-13.1722970399999', 'Rabat', 'Africa', 'AF', '446550.0', 'ar-MA,ber,fr', 'MAR'),
(150, 'MZ', 'Mozambique', 'MZN', '22061451', '508', '-10.4731756319999', '-26.868162', '40.838104211', '30.2155500000001', 'Maputo', 'Africa', 'AF', '801590.0', 'pt-MZ,vmw', 'MOZ'),
(151, 'MM', 'Myanmar [Burma]', 'MMK', '53414374', '104', '28.543249', '9.784583', '101.176781', '92.189278', 'Naypyitaw', 'Asia', 'AS', '678500.0', 'my', 'MMR'),
(152, 'NA', 'Namibia', 'NAD', '2128471', '516', '-16.963488173', '-28.9706389999999', '25.2617520000001', '11.737502061', 'Windhoek', 'Africa', 'AF', '825418.0', 'en-NA,af,de,hz,naq', 'NAM'),
(153, 'NR', 'Nauru', 'AUD', '10065', '520', '-0.504306', '-0.552333', '166.945282', '166.899033', 'Yaren', 'Oceania', 'OC', '21.0', 'na,en-NR', 'NRU'),
(154, 'NP', 'Nepal', 'NPR', '28951852', '524', '30.447389748', '26.3479660710001', '88.2015257450001', '80.058450824', 'Kathmandu', 'Asia', 'AS', '140800.0', 'ne,en', 'NPL'),
(155, 'NL', 'Netherlands', 'EUR', '16645000', '528', '53.5157125645109', '50.7503674993741', '7.22749859212922', '3.35837827202', 'Amsterdam', 'Europe', 'EU', '41526.0', 'nl-NL,fy-NL', 'NLD'),
(156, 'NC', 'New Caledonia', 'XPF', '216494', '540', '-19.549778', '-22.698', '168.129135', '163.564667', 'Noumea', 'Oceania', 'OC', '19060.0', 'fr-NC', 'NCL'),
(157, 'NZ', 'New Zealand', 'NZD', '4252277', '554', '-34.389668', '-47.286026', '-180', '166.7155', 'Wellington', 'Oceania', 'OC', '268680.0', 'en-NZ,mi', 'NZL'),
(158, 'NI', 'Nicaragua', 'NIO', '5995928', '558', '15.025909', '10.707543', '-82.738289', '-87.690308', 'Managua', 'North America', 'NA', '129494.0', 'es-NI,en', 'NIC'),
(159, 'NE', 'Niger', 'XOF', '15878271', '562', '23.5149999920001', '11.6937560000001', '15.9990340000001', '0.162193643000023', 'Niamey', 'Africa', 'AF', '1267000.0', 'fr-NE,ha,kr,dje', 'NER'),
(160, 'NG', 'Nigeria', 'NGN', '154000000', '566', '13.892007', '4.277144', '14.680073', '2.668432', 'Abuja', 'Africa', 'AF', '923768.0', 'en-NG,ha,yo,ig,ff', 'NGA'),
(161, 'NU', 'Niue', 'NZD', '2166', '570', '-18.951069', '-19.152193', '-169.775177', '-169.951004', 'Alofi', 'Oceania', 'OC', '260.0', 'niu,en-NU', 'NIU'),
(162, 'NF', 'Norfolk Island', 'AUD', '1828', '574', '-28.995170686948427', '-29.063076742954734', '167.99773740209957', '167.91543230151365', 'Kingston', 'Oceania', 'OC', '34.6', 'en-NF', 'NFK'),
(163, 'KP', 'North Korea', 'KPW', '22912177', '408', '43.006054', '37.673332', '130.674866', '124.315887', 'Pyongyang', 'Asia', 'AS', '120540.0', 'ko-KP', 'PRK'),
(164, 'MP', 'Northern Mariana Islands', 'USD', '53883', '580', '20.55344', '14.11023', '146.06528', '144.88626', 'Saipan', 'Oceania', 'OC', '477.0', 'fil,tl,zh,ch-MP,en-MP', 'MNP'),
(165, 'NO', 'Norway', 'NOK', '5009150', '578', '71.1854764998959', '57.97987783489344', '31.063740342248376', '4.64182374183584', 'Oslo', 'Europe', 'EU', '324220.0', 'no,nb,nn,se,fi', 'NOR'),
(166, 'OM', 'Oman', 'OMR', '2967717', '512', '26.3863334660001', '16.6500835430001', '59.8379173280001', '52.0000000000001', 'Muscat', 'Asia', 'AS', '212460.0', 'ar-OM,en,bal,ur', 'OMN'),
(167, 'PK', 'Pakistan', 'PKR', '184404791', '586', '37.0841070010001', '23.769527435', '77.0132974640001', '60.8729720000001', 'Islamabad', 'Asia', 'AS', '803940.0', 'ur-PK,en-PK,pa,sd,ps,brh', 'PAK'),
(168, 'PW', 'Palau', 'USD', '19907', '585', '8.46966', '2.8036', '134.72307', '131.11788', 'Melekeok', 'Oceania', 'OC', '458.0', 'pau,sov,en-PW,tox,ja,fil,zh', 'PLW'),
(169, 'PS', 'Palestine', 'ILS', '3800000', '275', '32.5520881030001', '31.2200520000001', '35.5740520000001', '34.2186994300001', '', 'Asia', 'AS', '5970.0', 'ar-PS', 'PSE'),
(170, 'PA', 'Panama', 'PAB', '3410676', '591', '9.6474132494631', '7.20236920646422', '-77.1563637579897', '-83.0523988577088', 'Panama City', 'North America', 'NA', '78200.0', 'es-PA,en', 'PAN'),
(171, 'PG', 'Papua New Guinea', 'PGK', '6064515', '598', '-1.318639', '-11.657861', '155.96344', '140.842865', 'Port Moresby', 'Oceania', 'OC', '462840.0', 'en-PG,ho,meu,tpi', 'PNG'),
(172, 'PY', 'Paraguay', 'PYG', '6375830', '600', '-19.2896000004762', '-27.5918335646318', '-54.2589239104835', '-62.6446174378624', 'Asunción', 'South America', 'SA', '406750.0', 'es-PY,gn', 'PRY'),
(173, 'PE', 'Peru', 'PEN', '29907003', '604', '-0.0386059686681167', '-18.3509277356587', '-68.6522791042853', '-81.3281953622301', 'Lima', 'South America', 'SA', '1285220.0', 'es-PE,qu,ay', 'PER'),
(174, 'PH', 'Philippines', 'PHP', '99900177', '608', '21.1218854788318', '4.64209796365014', '126.60497402182328', '116.9288644959', 'Manila', 'Asia', 'AS', '300000.0', 'tl,en-PH,fil,ceb,tgl,ilo,hil,war,pam,bik,bcl,pag,mrw,tsg,mdh,cbk,krj,sgd,msb,akl,ibg,yka,mta,abx', 'PHL'),
(175, 'PN', 'Pitcairn Islands', 'NZD', '46', '612', '-24.3299386198549', '-24.672565', '-124.77285', '-128.35699011119425', 'Adamstown', 'Oceania', 'OC', '47.0', 'en-PN', 'PCN'),
(176, 'PL', 'Poland', 'PLN', '38500000', '616', '54.8357886595169', '49.0020465193443', '24.1457828491313', '14.1228850233809', 'Warsaw', 'Europe', 'EU', '312685.0', 'pl', 'POL'),
(177, 'PT', 'Portugal', 'EUR', '10676000', '620', '42.154311127408', '36.96125', '-6.18915930748288', '-9.50052660716588', 'Lisbon', 'Europe', 'EU', '92391.0', 'pt-PT,mwl', 'PRT'),
(178, 'PR', 'Puerto Rico', 'USD', '3916632', '630', '18.520166', '17.926405', '-65.2430816766763', '-67.942726', 'San Juan', 'North America', 'NA', '9104.0', 'en-PR,es-PR', 'PRI'),
(179, 'QA', 'Qatar', 'QAR', '840926', '634', '26.1578818880001', '24.4711111230001', '51.6315537500001', '50.750030995', 'Doha', 'Asia', 'AS', '11437.0', 'ar-QA,es', 'QAT'),
(180, 'CG', 'Republic of the Congo', 'XAF', '3039126', '178', '3.70779100000004', '-5.04072158799994', '18.65042119', '11.1520760600001', 'Brazzaville', 'Africa', 'AF', '342000.0', 'fr-CG,kg,ln-CG', 'COG'),
(181, 'RO', 'Romania', 'RON', '21959278', '642', '48.2653912058468', '43.6190166499833', '29.7152986907701', '20.2619949052262', 'Bucharest', 'Europe', 'EU', '237500.0', 'ro,hu,rom', 'ROU'),
(182, 'RU', 'Russia', 'RUB', '140702000', '643', '81.8616409300001', '41.1853530000001', '-169.05', '19.25', 'Moscow', 'Europe', 'EU', '1.71E7', 'ru,tt,xal,cau,ady,kv,ce,tyv,cv,udm,tut,mns,bua,myv,mdf,chm,ba,inh,tut,kbd,krc,av,sah,nog', 'RUS'),
(183, 'RW', 'Rwanda', 'RWF', '11055976', '646', '-1.04716670707785', '-2.84023010213747', '30.8997466415943', '28.8617308206209', 'Kigali', 'Africa', 'AF', '26338.0', 'rw,en-RW,fr-RW,sw', 'RWA'),
(184, 'RE', 'Réunion', 'EUR', '776948', '638', '-20.8717861179999', '-21.389228821', '55.836700439', '55.21648407', 'Saint-Denis', 'Africa', 'AF', '2517.0', 'fr-RE', 'REU'),
(185, 'BL', 'Saint Barthélemy', 'EUR', '8450', '652', '17.928808791949283', '17.878183227405575', '-62.788983372985854', '-62.8739118253784', 'Gustavia', 'North America', 'NA', '21.0', 'fr', 'BLM'),
(186, 'SH', 'Saint Helena', 'SHP', '7460', '654', '-7.887815', '-16.019543', '-5.638753', '-14.42123', 'Jamestown', 'Africa', 'AF', '410.0', 'en-SH', 'SHN'),
(187, 'KN', 'Saint Kitts and Nevis', 'XCD', '51134', '659', '17.420118', '17.095343', '-62.543266', '-62.86956', 'Basseterre', 'North America', 'NA', '261.0', 'en-KN', 'KNA'),
(188, 'LC', 'Saint Lucia', 'XCD', '160922', '662', '14.110317287646', '13.7072692224982', '-60.8732306422271', '-61.07995730159752', 'Castries', 'North America', 'NA', '616.0', 'en-LC', 'LCA'),
(189, 'MF', 'Saint Martin', 'EUR', '35925', '663', '18.125295191246206', '18.04717219103021', '-63.01059106320133', '-63.15036103890611', 'Marigot', 'North America', 'NA', '53.0', 'fr', 'MAF'),
(190, 'PM', 'Saint Pierre and Miquelon', 'EUR', '7012', '666', '47.14376802942701', '46.78264970849848', '-56.1253298443454', '-56.40709223087083', 'Saint-Pierre', 'North America', 'NA', '242.0', 'fr-PM', 'SPM'),
(191, 'VC', 'Saint Vincent and the Grenadines', 'XCD', '104217', '670', '13.377834', '12.583984810969036', '-61.11388', '-61.46090317727658', 'Kingstown', 'North America', 'NA', '389.0', 'en-VC,fr', 'VCT'),
(192, 'WS', 'Samoa', 'WST', '192001', '882', '-13.432207', '-14.040939', '-171.415741', '-172.798599', 'Apia', 'Oceania', 'OC', '2944.0', 'sm,en-WS', 'WSM'),
(193, 'SM', 'San Marino', 'EUR', '31477', '674', '43.9920929668161', '43.8937002210188', '12.5158490454421', '12.403605260165', 'San Marino', 'Europe', 'EU', '61.2', 'it-SM', 'SMR'),
(194, 'SA', 'Saudi Arabia', 'SAR', '25731776', '682', '32.158333', '16.3795000261256', '55.66658400000006', '34.495693', 'Riyadh', 'Asia', 'AS', '1960582.0', 'ar-SA', 'SAU'),
(195, 'SN', 'Senegal', 'XOF', '12323252', '686', '16.6929572170001', '12.307289079', '-11.345768371', '-17.529520035', 'Dakar', 'Africa', 'AF', '196190.0', 'fr-SN,wo,fuc,mnk', 'SEN'),
(196, 'RS', 'Serbia', 'RSD', '7344847', '688', '46.189446', '42.2315030010001', '23.0063870060001', '18.838044043', 'Belgrade', 'Europe', 'EU', '88361.0', 'sr,hu,bs,rom', 'SRB'),
(197, 'SC', 'Seychelles', 'SCR', '88340', '690', '-4.283717', '-9.753867', '56.29770287937299', '46.204769', 'Victoria', 'Africa', 'AF', '455.0', 'en-SC,fr-SC', 'SYC'),
(198, 'SL', 'Sierra Leone', 'SLL', '5245695', '694', '9.99997300000007', '6.92343700100002', '-10.2716829999999', '-13.302128077', 'Freetown', 'Africa', 'AF', '71740.0', 'en-SL,men,tem', 'SLE'),
(199, 'SG', 'Singapore', 'SGD', '4701069', '702', '1.47064236100005', '1.21460286400003', '104.035820313', '103.605527887', 'Singapore', 'Asia', 'AS', '692.7', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', 'SGP'),
(200, 'SX', 'Sint Maarten', 'ANG', '37429', '534', '18.0641148010001', '18.00509989712575', '-63.01365933767215', '-63.13916381600001', 'Philipsburg', 'North America', 'NA', '21.0', 'nl,en', 'SXM'),
(201, 'SK', 'Slovakia', 'EUR', '5455000', '703', '49.6137360000001', '47.7313590000001', '22.5657383340001', '16.8334234020001', 'Bratislava', 'Europe', 'EU', '48845.0', 'sk,hu', 'SVK'),
(202, 'SI', 'Slovenia', 'EUR', '2007000', '705', '46.8766275518195', '45.421812998164', '16.6106311807', '13.3753342064709', 'Ljubljana', 'Europe', 'EU', '20273.0', 'sl,sh', 'SVN'),
(203, 'SB', 'Solomon Islands', 'SBD', '559198', '090', '-6.589611', '-11.850555', '166.980865', '155.508606', 'Honiara', 'Oceania', 'OC', '28450.0', 'en-SB,tpi', 'SLB'),
(204, 'SO', 'Somalia', 'SOS', '10112453', '706', '11.9887353730001', '-1.66203236399997', '51.4150313960001', '40.9943730000001', 'Mogadishu', 'Africa', 'AF', '637657.0', 'so-SO,ar-SO,it,en-SO', 'SOM'),
(205, 'ZA', 'South Africa', 'ZAR', '49000000', '710', '-22.1250300579999', '-34.8341700029999', '32.944984945', '16.45189', 'Pretoria', 'Africa', 'AF', '1219912.0', 'zu,xh,af,nso,en-ZA,tn,st,ts,ss,ve,nr', 'ZAF'),
(206, 'GS', 'South Georgia and the South Sandwich Islands', 'GBP', '30', '239', '-53.980896636', '-59.46319341', '-26.252069712', '-38.0479509639999', 'Grytviken', 'Antarctica', 'AN', '3903.0', 'en', 'SGS'),
(207, 'KR', 'South Korea', 'KRW', '48422644', '410', '38.5933891092225', '33.1954102977009', '129.583016157998', '125.887442375577', 'Seoul', 'Asia', 'AS', '98480.0', 'ko-KR,en', 'KOR'),
(208, 'SS', 'South Sudan', 'SSP', '8260490', '728', '12.236389', '3.48898000000003', '35.9489970000001', '23.4408490000001', 'Juba', 'Africa', 'AF', '644329.0', 'en', 'SSD'),
(209, 'ES', 'Spain', 'EUR', '46505963', '724', '43.7913565913767', '36.0001044260548', '4.32778473043961', '-9.30151567231899', 'Madrid', 'Europe', 'EU', '504782.0', 'es-ES,ca,gl,eu,oc', 'ESP'),
(210, 'LK', 'Sri Lanka', 'LKR', '21513990', '144', '9.831361', '5.916833', '81.881279', '79.652916', 'Colombo', 'Asia', 'AS', '65610.0', 'si,ta,en', 'LKA'),
(211, 'SD', 'Sudan', 'SDG', '35000000', '729', '23.1464092140001', '9.48888700000003', '38.5822502880001', '21.8146345210001', 'Khartoum', 'Africa', 'AF', '1861484.0', 'ar-SD,en,fia', 'SDN'),
(212, 'SR', 'Suriname', 'SRD', '492829', '740', '6.01550458300005', '1.83730600000007', '-53.978763', '-58.070505999', 'Paramaribo', 'South America', 'SA', '163270.0', 'nl-SR,en,srn,hns,jv', 'SUR'),
(213, 'SJ', 'Svalbard and Jan Mayen', 'NOK', '2550', '744', '80.762085', '79.220306', '33.287334', '17.699389', 'Longyearbyen', 'Europe', 'EU', '62049.0', 'no,ru', 'SJM'),
(214, 'SZ', 'Swaziland', 'SZL', '1354051', '748', '-25.7179199999999', '-27.317402', '32.1349066610001', '30.7906400000001', 'Mbabane', 'Africa', 'AF', '17363.0', 'en-SZ,ss-SZ', 'SWZ'),
(215, 'SE', 'Sweden', 'SEK', '9828655', '752', '69.0599672666879', '55.3374438220002', '24.155245238099', '11.109499387126', 'Stockholm', 'Europe', 'EU', '449964.0', 'sv-SE,se,sma,fi-SE', 'SWE'),
(216, 'CH', 'Switzerland', 'CHF', '7581000', '756', '47.8098679329775', '45.8191539516188', '10.4934735095497', '5.95661377423453', 'Bern', 'Europe', 'EU', '41290.0', 'de-CH,fr-CH,it-CH,rm', 'CHE'),
(217, 'SY', 'Syria', 'SYP', '22198110', '760', '37.3205689060001', '32.311136', '42.376309', '35.587211', 'Damascus', 'Asia', 'AS', '185180.0', 'ar-SY,ku,hy,arc,fr,en', 'SYR'),
(218, 'ST', 'São Tomé and Príncipe', 'STD', '175808', '678', '1.701323', '0.024766', '7.466374', '6.47017', 'São Tomé', 'Africa', 'AF', '1001.0', 'pt-ST', 'STP'),
(219, 'TW', 'Taiwan', 'TWD', '22894384', '158', '25.3002899036181', '21.896606934717', '122.006739823315', '119.534691', 'Taipei', 'Asia', 'AS', '35980.0', 'zh-TW,zh,nan,hak', 'TWN'),
(220, 'TJ', 'Tajikistan', 'TJS', '7487489', '762', '41.0443670000001', '36.672037001', '75.1539560000001', '67.3420120000001', 'Dushanbe', 'Asia', 'AS', '143100.0', 'tg,ru', 'TJK'),
(221, 'TZ', 'Tanzania', 'TZS', '41892895', '834', '-0.984396999999944', '-11.761254', '40.4448279960001', '29.34', 'Dodoma', 'Africa', 'AF', '945087.0', 'sw-TZ,en,ar', 'TZA'),
(222, 'TH', 'Thailand', 'THB', '67089500', '764', '20.463194', '5.61', '105.639389', '97.345642', 'Bangkok', 'Asia', 'AS', '514000.0', 'th,en', 'THA'),
(223, 'TG', 'Togo', 'XOF', '6587239', '768', '11.1394984250001', '6.11225958700004', '1.80890722900006', '-0.144041999999956', 'Lomé', 'Africa', 'AF', '56785.0', 'fr-TG,ee,hna,kbp,dag,ha', 'TGO'),
(224, 'TK', 'Tokelau', 'NZD', '1466', '772', '-8.553613662719726', '-9.381111145019531', '-171.21142578125', '-172.50033569335937', '', 'Oceania', 'OC', '10.0', 'tkl,en-TK', 'TKL'),
(225, 'TO', 'Tonga', 'TOP', '122580', '776', '-15.562988', '-21.455057', '-173.907578', '-175.682266', 'Nuku\'alofa', 'Oceania', 'OC', '748.0', 'to,en-TO', 'TON'),
(226, 'TT', 'Trinidad and Tobago', 'TTD', '1328019', '780', '11.338342', '10.036105', '-60.517933', '-61.923771', 'Port of Spain', 'North America', 'NA', '5128.0', 'en-TT,hns,fr,es,zh', 'TTO'),
(227, 'TN', 'Tunisia', 'TND', '10589025', '788', '37.543915', '30.240417', '11.598278', '7.524833', 'Tunis', 'Africa', 'AF', '163610.0', 'ar-TN,fr', 'TUN'),
(228, 'TR', 'Turkey', 'TRY', '77804122', '792', '42.107613', '35.815418', '44.834999', '25.668501', 'Ankara', 'Asia', 'AS', '780580.0', 'tr-TR,ku,diq,az,av', 'TUR'),
(229, 'TM', 'Turkmenistan', 'TMT', '4940916', '795', '42.7982617260001', '35.1290930000001', '66.7073530000001', '52.4455780650001', 'Ashgabat', 'Asia', 'AS', '488100.0', 'tk,ru,uz', 'TKM'),
(230, 'TC', 'Turks and Caicos Islands', 'USD', '20556', '796', '21.961878', '21.422626', '-71.123642', '-72.483871', 'Cockburn Town', 'North America', 'NA', '430.0', 'en-TC', 'TCA'),
(231, 'TV', 'Tuvalu', 'AUD', '10472', '798', '-5.641972', '-10.801169', '179.863281', '176.064865', 'Funafuti', 'Oceania', 'OC', '26.0', 'tvl,en,sm,gil', 'TUV'),
(232, 'UM', 'U.S. Minor Outlying Islands', 'USD', '0', '581', '28.219814', '-0.389006', '166.654526', '-177.392029', '', 'Oceania', 'OC', '0.0', 'en-UM', 'UMI'),
(233, 'VI', 'U.S. Virgin Islands', 'USD', '108708', '850', '18.415382', '17.673931', '-64.565193', '-65.101333', 'Charlotte Amalie', 'North America', 'NA', '352.0', 'en-VI', 'VIR'),
(234, 'UG', 'Uganda', 'UGX', '33398682', '800', '4.23136926690327', '-1.48153052848838', '35.0010535324228', '29.573465338129', 'Kampala', 'Africa', 'AF', '236040.0', 'en-UG,lg,sw,ar', 'UGA'),
(235, 'UA', 'Ukraine', 'UAH', '45415596', '804', '52.3793713250001', '44.3820571900001', '40.22048033', '22.137078', 'Kiev', 'Europe', 'EU', '603700.0', 'uk,ru-UA,rom,pl,hu', 'UKR'),
(236, 'AE', 'United Arab Emirates', 'AED', '4975593', '784', '26.0693916660001', '22.631513764', '56.381564568', '51.572410727', 'Abu Dhabi', 'Asia', 'AS', '82880.0', 'ar-AE,fa,en,hi,ur', 'ARE'),
(237, 'GB', 'United Kingdom', 'GBP', '62348447', '826', '59.3607741849963', '49.9028622252397', '1.7689121033873', '-8.61772077108559', 'London', 'Europe', 'EU', '244820.0', 'en-GB,cy-GB,gd', 'GBR'),
(238, 'US', 'United States', 'USD', '310232863', '840', '49.384358', '24.544245', '-66.949607', '-124.733692', 'Washington', 'North America', 'NA', '9629091.0', 'en-US,es-US,haw,fr', 'USA'),
(239, 'UY', 'Uruguay', 'UYU', '3477000', '858', '-30.0855024328825', '-34.9740543027064', '-53.1810509360802', '-58.4393489790361', 'Montevideo', 'South America', 'SA', '176220.0', 'es-UY', 'URY'),
(240, 'UZ', 'Uzbekistan', 'UZS', '27865738', '860', '45.5900750010001', '37.172269828', '73.1489460000001', '55.9982180000001', 'Tashkent', 'Asia', 'AS', '447400.0', 'uz,ru,tg', 'UZB'),
(241, 'VU', 'Vanuatu', 'VUV', '221552', '548', '-13.073444', '-20.248945', '169.904785', '166.524979', 'Port Vila', 'Oceania', 'OC', '12200.0', 'bi,en-VU,fr-VU', 'VUT'),
(242, 'VA', 'Vatican City', 'EUR', '921', '336', '41.90743830885576', '41.90027960306854', '12.45837546629481', '12.44570678169205', 'Vatican City', 'Europe', 'EU', '0.44', 'la,it,fr', 'VAT'),
(243, 'VE', 'Venezuela', 'VEF', '27223228', '862', '12.201903', '0.626311', '-59.80378', '-73.354073', 'Caracas', 'South America', 'SA', '912050.0', 'es-VE', 'VEN'),
(244, 'VN', 'Vietnam', 'VND', '89571130', '704', '23.388834', '8.559611', '109.464638', '102.148224', 'Hanoi', 'Asia', 'AS', '329560.0', 'vi,en,fr,zh,km', 'VNM'),
(245, 'WF', 'Wallis and Futuna', 'XPF', '16025', '876', '-13.216758181061443', '-14.314559989820843', '-176.16174317718253', '-178.1848112896414', 'Mata-Utu', 'Oceania', 'OC', '274.0', 'wls,fud,fr-WF', 'WLF'),
(246, 'EH', 'Western Sahara', 'MAD', '273008', '732', '27.669674', '20.774158', '-8.670276', '-17.103182', 'Laâyoune / El Aaiún', 'Africa', 'AF', '266000.0', 'ar,mey', 'ESH'),
(247, 'YE', 'Yemen', 'YER', '23495361', '887', '18.9999989031009', '12.1110910264462', '54.5305388163283', '42.5325394314234', 'Sanaa', 'Asia', 'AS', '527970.0', 'ar-YE', 'YEM'),
(248, 'ZM', 'Zambia', 'ZMW', '13460305', '894', '-8.20328399999994', '-18.077418', '33.7090304810001', '21.999350925', 'Lusaka', 'Africa', 'AF', '752614.0', 'en-ZM,bem,loz,lun,lue,ny,toi', 'ZMB'),
(249, 'ZW', 'Zimbabwe', 'ZWL', '13061000', '716', '-15.609318999', '-22.421998999', '33.0682360000001', '25.2373680000001', 'Harare', 'Africa', 'AF', '390580.0', 'en-ZW,sn,nr,nd', 'ZWE'),
(250, 'AX', 'Åland', 'EUR', '26711', '248', '60.488861', '59.90675', '21.011862', '19.317694', 'Mariehamn', 'Europe', 'EU', '1580.0', 'sv-AX', 'ALA');

-- --------------------------------------------------------

--
-- Table structure for table `crm_activity`
--

CREATE TABLE `crm_activity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `activity_type` int(11) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `due_date` date DEFAULT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_status` int(11) DEFAULT NULL,
  `response_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_activity_types`
--

CREATE TABLE `crm_activity_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_lead`
--

CREATE TABLE `crm_lead` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_notes`
--

CREATE TABLE `crm_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `opportunity_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_opportunity`
--

CREATE TABLE `crm_opportunity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_id` int(11) NOT NULL,
  `opportunity_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_revenue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  `sales_cycle_id` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `sales_team_id` int(11) DEFAULT NULL,
  `opportunity_status` int(11) DEFAULT NULL,
  `lost_reason` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_sales_cycle`
--

CREATE TABLE `crm_sales_cycle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_sales_team`
--

CREATE TABLE `crm_sales_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_stages`
--

CREATE TABLE `crm_stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `probability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `default_currency` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `active_status` int(11) NOT NULL DEFAULT '0',
  `default_curr_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `code`, `currency`, `symbol`, `default_currency`, `date`, `active_status`, `default_curr_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AED', 'United Arab Emirates Dirham', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:46:19', '0000-00-00 00:00:00'),
(2, 'AFN', 'Afghan Afghani', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2019-03-27 15:38:44', '0000-00-00 00:00:00'),
(4, 'ALL', 'Albanian Lek', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(5, 'AMD', 'Armenian Dram', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(6, 'ANG', 'Netherlands Antillean Guilder', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(7, 'AOA', 'Angolan Kwanza', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(8, 'ARS', 'Argentine Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(9, 'AUD', 'Australian Dollar', '$', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-10-24 17:48:11', '0000-00-00 00:00:00'),
(10, 'AWG', 'Aruban Florin', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(11, 'AZN', 'Azerbaijani Manat', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 11:49:38', '0000-00-00 00:00:00'),
(13, 'BAM', 'Bosnia-Herzegovina Convertible Mark', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(14, 'BBD', 'Barbadian Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(15, 'BDT', 'Bangladeshi Taka', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(16, 'BGN', 'Bulgarian Lev', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(17, 'BHD', 'Bahraini Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(18, 'BIF', 'Burundian Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(19, 'BMD', 'Bermudan Dollar', '$', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-10-24 17:48:25', '0000-00-00 00:00:00'),
(20, 'BND', 'Brunei Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(21, 'BOB', 'Bolivian Boliviano', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(22, 'BRL', 'Brazilian Real', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(23, 'BSD', 'Bahamian Dollar', '$', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-10-24 17:48:31', '0000-00-00 00:00:00'),
(24, 'BTC', 'Bitcoin', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(25, 'BTN', 'Bhutanese Ngultrum', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(26, 'BWP', 'Botswanan Pula', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:00:57', '0000-00-00 00:00:00'),
(27, 'BYR', 'Belarusian Ruble', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(28, 'BZD', 'Belize Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(29, 'CAD', 'Canadian Dollar', '$', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-10-24 17:48:46', '0000-00-00 00:00:00'),
(30, 'CDF', 'Congolese Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(31, 'CHF', 'Swiss Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(32, 'CLF', 'Chilean Unit of Account (UF)', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(33, 'CLP', 'Chilean Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(34, 'CNY', 'Chinese Yuan', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(35, 'COP', 'Colombian Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(36, 'CRC', 'Costa Rican Colón', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(37, 'CUC', 'Cuban Convertible Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(38, 'CUP', 'Cuban Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(39, 'CVE', 'Cape Verdean Escudo', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(40, 'CZK', 'Czech Republic Koruna', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(41, 'DJF', 'Djiboutian Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(42, 'DKK', 'Danish Krone', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(43, 'DOP', 'Dominican Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(44, 'DZD', 'Algerian Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:09:05', '0000-00-00 00:00:00'),
(45, 'EGP', 'Egyptian Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(46, 'ERN', 'Eritrean Nakfa', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(47, 'ETB', 'Ethiopian Birr', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(48, 'EUR', 'Euro', '€', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-03-16 08:31:03', '0000-00-00 00:00:00'),
(49, 'FJD', 'Fijian Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(50, 'FKP', 'Falkland Islands Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(51, 'GBP', 'British Pound Sterling', '£', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-03-16 08:31:35', '0000-00-00 00:00:00'),
(52, 'GEL', 'Georgian Lari', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(53, 'GGP', 'Guernsey Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(54, 'GHS', 'Ghanaian Cedi', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(55, 'GIP', 'Gibraltar Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(56, 'GMD', 'Gambian Dalasi', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(57, 'GNF', 'Guinean Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(58, 'GTQ', 'Guatemalan Quetzal', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(59, 'GYD', 'Guyanaese Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(60, 'HKD', 'Hong Kong Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(61, 'HNL', 'Honduran Lempira', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(62, 'HRK', 'Croatian Kuna', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(63, 'HTG', 'Haitian Gourde', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 12:49:35', '0000-00-00 00:00:00'),
(64, 'HUF', '\r\nHungarian Forint', '', '100', '0000-00-00 00:00:00', 0, 1, 1, '2020-03-12 20:33:15', '2020-03-12 19:33:15'),
(65, 'IDR', 'Indonesian Rupiah', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(66, 'ILS', 'Israeli New Sheqel', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(67, 'IMP', 'Manx pound', '', '', '2018-02-20 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(68, 'INR', 'Indian Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(69, 'IQD', 'Iraqi Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(70, 'IRR', 'Iranian Rial', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(71, 'ISK', 'Icelandic Króna', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(72, 'JEP', 'Jersey Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(73, 'JMD', 'Jamaican Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(74, 'JOD', 'Jordanian Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(75, 'JPY', 'Japanese Yen', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(76, 'KES', 'Kenyan Shilling', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(77, 'KGS', 'Kyrgystani Som', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(78, 'KHR', 'Cambodian Riel', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(79, 'KMF', 'Comorian Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(80, 'KPW', 'North Korean Won', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(81, 'KRW', 'South Korean Won', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(82, 'KWD', 'Kuwaiti Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(83, 'KYD', 'Cayman Islands Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(84, 'KZT', 'Kazakhstani Tenge', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(85, 'LAK', 'Laotian Kip', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(86, 'LBP', 'Lebanese Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(87, 'LKR', 'Sri Lankan Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(88, 'LRD', 'Liberian Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(89, 'LSL', 'Lesotho Loti', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(90, 'LTL', 'Lithuanian Litas', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(91, 'LVL', 'Latvian Lats', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(92, 'LYD', 'Libyan Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(93, 'MAD', 'Moroccan Dirham', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(94, 'MDL', 'Moldovan Leu', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(95, 'MGA', 'Malagasy Ariary', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(96, 'MKD', 'Macedonian Denar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(97, 'MMK', 'Myanma Kyat', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(98, 'MINT', 'Mongolian Tugrik', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(99, 'MOP', 'Macanese Pataca', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(100, 'MRO', 'Mauritanian Ouguiya', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(101, 'MUR', 'Mauritian Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(102, 'MVR', 'Maldivian Rufiyaa', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(103, 'MWK', 'Malawian Kwacha', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(104, 'MXN', 'Mexican Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:07:06', '0000-00-00 00:00:00'),
(105, 'MYR', 'Malaysian Ringgit', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(106, 'MZN', 'Mozambican Metical', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(107, 'NAD', 'Namibian Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-04-25 12:57:24', '0000-00-00 00:00:00'),
(108, 'NGN', 'Nigerian Naira', 'N', '1.00', '0000-00-00 00:00:00', 1, 1, 1, '2020-08-27 00:13:20', '2020-08-26 23:13:20'),
(109, 'NIO', 'Nicaraguan Córdoba', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(110, 'NOK', 'Norwegian Krone', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(111, 'NPR', 'Nepalese Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(112, 'NZD', 'New Zealand Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(113, 'OMR', 'Omani Rial', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(114, 'PAB', 'Panamanian Balboa', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(115, 'PEN', 'Peruvian Nuevo Sol', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(116, 'PGK', 'Papua New Guinean Kina', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(117, 'PHP', 'Philippine Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(118, 'PKR', 'Pakistani Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(119, 'PLN', 'Polish Zloty', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(120, 'PYG', 'Paraguayan Guarani', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(121, 'QAR', 'Qatari Rial', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(122, 'RON', 'Romanian Leu', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(123, 'RSD', 'Serbian Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(124, 'RUB', 'Russian Ruble', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(125, 'RWF', 'Rwandan Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(126, 'SAR', 'Saudi Riyal', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(127, 'SBD', 'Solomon Islands Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(128, 'SCR', 'Seychellois Rupee', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(129, 'SDG', 'Sudanese Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(130, 'SEK', 'Swedish Krona', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(131, 'SGD', 'Singapore Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(132, 'SHP', 'Saint Helena Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(133, 'SLL', 'Sierra Leonean Leone', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(134, 'SOS', 'Somali Shilling', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(135, 'SRD', 'Surinamese Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(136, 'STD', 'São Tomé and Príncipe Dobra', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(137, 'SVC', 'Salvadoran Colón', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(138, 'SYP', 'Syrian Pound', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(139, 'SZL', 'Swazi Lilangeni', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(140, 'THB', 'Thai Baht', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(141, 'TJS', 'Tajikistani Somoni', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(142, 'TOP', 'Turkmenistani Manat', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(143, 'TND', 'Tunisian Dinar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(144, 'TOP', 'Tongan Pa?anga', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:43:31', '0000-00-00 00:00:00'),
(145, 'TRY', 'Turkish Lira', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(146, 'TTD', 'Trinidad and Tobago Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(147, 'TWD', 'New Taiwan Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(148, 'TZS', 'Tanzanian Shilling', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(149, 'UAH', 'Ukrainian Hryvnia', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(150, 'UGX', 'Ugandan Shilling', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(151, 'USD', 'United States Dollar', '$', '366', '0000-00-00 00:00:00', 0, 1, 1, '2020-07-15 14:58:04', '2020-07-15 13:58:04'),
(152, 'UYU', 'Uruguayan Peso', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(153, 'UZS', 'Uzbekistan Som', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(154, 'VEF', 'Venezuelan Bolívar Fuerte', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(155, 'VND', 'Vietnamese Dong', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(156, 'VUV', 'Vanuatu Vatu', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(157, 'WST', 'Samoan Tala', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(158, 'XAF', 'CFA Franc BEAC', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(159, 'XAG', 'Silver (troy ounce)', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:50:48', '0000-00-00 00:00:00'),
(160, 'XAU', 'Gold (troy ounce)', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:56:40', '0000-00-00 00:00:00'),
(161, 'XCD', 'East Caribbean Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:56:40', '0000-00-00 00:00:00'),
(162, 'XOF', 'CFA Franc BCEAO', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:56:40', '0000-00-00 00:00:00'),
(163, 'XPF', 'CFP Franc', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 13:56:40', '0000-00-00 00:00:00'),
(164, 'YER', 'Yemeni Rial', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-12 14:00:23', '0000-00-00 00:00:00'),
(165, 'ZAR', 'South African Rand', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-15 11:09:37', '0000-00-00 00:00:00'),
(166, 'ZMK', 'Zambian Kwacha (pre-2013)', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-15 11:14:13', '0000-00-00 00:00:00'),
(167, 'ZMW', 'Zambian Kwacha', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-15 10:47:31', '0000-00-00 00:00:00'),
(168, 'ZWL', 'Zimbabwean Dollar', '', '', '0000-00-00 00:00:00', 0, 0, 1, '2018-02-15 11:21:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `debit_credit`
--

CREATE TABLE `debit_credit` (
  `id` int(11) NOT NULL,
  `trans_name` varchar(50) NOT NULL,
  `trans_desc` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debit_credit`
--

INSERT INTO `debit_credit` (`id`, `trans_name`, `trans_desc`, `status`) VALUES
(1, 'credit', NULL, 1),
(2, 'debit', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `decisions`
--

CREATE TABLE `decisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `decision_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decision_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `decision_comments`
--

CREATE TABLE `decision_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `decision_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temp_user` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliverables`
--

CREATE TABLE `deliverables` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `del_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliverable_comments`
--

CREATE TABLE `deliverable_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `del_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `temp_user` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(10) UNSIGNED NOT NULL,
  `dept_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_hod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dept_approvals`
--

CREATE TABLE `dept_approvals` (
  `id` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `dept_head` int(11) NOT NULL,
  `approval_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_type`
--

CREATE TABLE `detail_type` (
  `id` int(11) NOT NULL,
  `acct_cat_id` int(11) NOT NULL,
  `detail_type` varchar(160) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_type`
--

INSERT INTO `detail_type` (`id`, `acct_cat_id`, `detail_type`, `status`) VALUES
(1, 1, 'Account Receivable (A/R)', 1),
(2, 2, 'Allowance Bad Debts', 1),
(3, 2, 'Development Costs', 1),
(4, 2, 'Employee Cash Advances', 1),
(5, 2, 'Inventory', 1),
(6, 2, 'Investment - Mortgage/Real Estate Loans', 1),
(7, 2, 'Investment - Tax Exempt Securities', 1),
(8, 2, 'Investment - Other', 1),
(9, 2, 'Loans to Officers', 1),
(10, 2, 'Loans to Others', 1),
(11, 2, 'Loans to Stockholders', 1),
(12, 2, 'Other Current Assets', 1),
(13, 2, 'Prepaid Expenses', 1),
(14, 2, 'Retainage', 1),
(15, 2, 'Undeposited Funds', 1),
(16, 3, 'Cash on Hand', 1),
(17, 3, 'Checking', 1),
(18, 3, 'Money Market', 1),
(19, 3, 'Rent Held in Trust', 1),
(20, 3, 'Savings', 1),
(21, 3, 'Trust Account', 1),
(22, 4, 'Accumulated Amortization', 1),
(23, 4, 'Accumulated Depletion', 1),
(24, 4, 'Accumulated Depreciation', 1),
(25, 4, 'Buildings', 1),
(26, 4, 'Depletable Assets', 1),
(27, 4, 'Furniture and Fixtures', 1),
(28, 4, 'Intagible Assets', 1),
(29, 4, 'Land', 1),
(30, 4, 'Leasehold Improvements', 1),
(31, 4, 'Machinery and Equipment', 1),
(32, 4, 'Other Fixed Assets', 1),
(33, 4, 'Vehicles', 1),
(34, 6, 'Account Payable (A/P)', 1),
(35, 7, 'Credit Card', 1),
(36, 8, 'Federal Income Tax Payable', 1),
(37, 8, 'Insurance Payable', 1),
(38, 8, 'Line of Credit Loan Payable', 1),
(39, 8, 'Other Current Liabilities', 1),
(40, 8, 'Payroll Clearing', 1),
(41, 8, 'Payroll Tax Payable', 1),
(42, 8, 'Prepaid Expenses Payable', 1),
(43, 8, 'Rent in Trust Liablility', 1),
(44, 8, 'Sales Tax Payable', 1),
(45, 8, 'Sales/Local Income Tax Payable', 1),
(46, 9, 'Notes Payable', 1),
(47, 9, 'Other Long Term Liabilities', 1),
(48, 9, 'Shareholder Notes Payable', 1),
(49, 10, 'Accumulated Adjustment', 1),
(50, 10, 'Common Stock', 1),
(51, 10, 'Opening Balance Equity', 1),
(52, 10, 'Owners Equity', 1),
(53, 10, 'Paid-in Capital/Surplus', 1),
(54, 10, 'Partner Contributions', 1),
(55, 10, 'Partners Equity', 1),
(56, 10, 'Preferred Stock', 1),
(57, 10, 'Retained Earnings', 1),
(58, 10, 'Treasury Stock', 1),
(59, 11, 'Discounts/Refunds Given', 1),
(60, 11, 'Non-Profit Income', 1),
(61, 11, 'Sales of Product Income', 1),
(62, 11, 'Service Fee Income', 1),
(63, 11, 'Unapplied Payment Income', 1),
(64, 11, 'Other Primary Income', 1),
(65, 14, 'Advertising/Promotional', 1),
(66, 14, 'Auto', 1),
(67, 14, 'Bad Debts', 1),
(68, 14, 'Bank Charges', 1),
(69, 14, 'Cost of Labour', 1),
(70, 14, 'Dues and Subscription', 1),
(71, 14, 'Entertainment', 1),
(72, 14, 'Entertainment Meals', 1),
(73, 14, 'Equipment Rental', 1),
(74, 14, 'Finance Costs', 1),
(75, 14, 'Insurance', 1),
(76, 14, 'Interest Paid', 1),
(77, 14, 'Legal and Professional Fees', 1),
(78, 14, 'Office General and Legislative Expenses', 1),
(79, 14, 'Other Miscellaneous Service Cost', 1),
(80, 14, 'Payroll Expenses', 1),
(81, 14, 'Promotional Meals', 1),
(82, 14, 'Rent or Lease of Buildings', 1),
(83, 14, 'Repair and Maintenance', 1),
(84, 13, 'Cost of Labour - COS', 1),
(85, 13, 'Equipment Rental - COS', 1),
(86, 13, 'Other Cost of Services - COS', 1),
(87, 13, 'Shipping Freight & Delivery - COS', 1),
(88, 13, 'Supplies & Materials - COGS', 1),
(89, 14, 'Taxes Paid', 1),
(90, 14, 'Travel', 1),
(91, 14, 'Unapplied Cash Bill Payment Expense', 1),
(92, 14, 'Utilities', 1),
(93, 15, 'Other Expense', 1),
(94, 12, 'Other Income', 1),
(95, 5, 'Other Assets', 1);

-- --------------------------------------------------------

--
-- Table structure for table `discuss`
--

CREATE TABLE `discuss` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `departments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessible_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discuss_comments`
--

CREATE TABLE `discuss_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discuss_id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `doc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_desc` text COLLATE utf8mb4_unicode_ci,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `departments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessible_users` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `category_id`, `doc_name`, `doc_desc`, `docs`, `departments`, `accessible_users`, `tags`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Chevron files for OB3', '', '{\"1\":\"1567433759_9007711771.jpeg\",\"2\":\"1567434902_7177999711.docx\"}', '[\"9\",\"8\"]', '[\"19\",\"16\"]', '9,8', 1, 1, 1, '2019-08-31 23:00:00', '2019-11-14 13:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `document_category`
--

CREATE TABLE `document_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_comments`
--

CREATE TABLE `document_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `event_desc` text COLLATE utf8mb4_unicode_ci,
  `event_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rate`
--

CREATE TABLE `exchange_rate` (
  `id` int(11) NOT NULL,
  `rates` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `default_curr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exchange_rate`
--

INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(751, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1559913245,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.978973,\"USDALL\":107.980221,\"USDAMD\":479.610358,\"USDANG\":1.874499,\"USDAOA\":333.781501,\"USDARS\":44.847003,\"USDAUD\":1.429304,\"USDAWG\":1.8,\"USDAZN\":1.704992,\"USDBAM\":1.73605,\"USDBBD\":1.9911,\"USDBDT\":84.527976,\"USDBGN\":1.727897,\"USDBHD\":0.37712,\"USDBIF\":1834.75,\"USDBMD\":1,\"USDBND\":1.350499,\"USDBOB\":6.90825,\"USDBRL\":3.86335,\"USDBSD\":0.99985,\"USDBTC\":0.000126,\"USDBTN\":69.473686,\"USDBWP\":10.962992,\"USDBYN\":2.09075,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.33065,\"USDCDF\":1661.000111,\"USDCHF\":0.986695,\"USDCLF\":0.025112,\"USDCLP\":692.697165,\"USDCNY\":6.909701,\"USDCOP\":3284,\"USDCRC\":591.844983,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.876498,\"USDCZK\":22.630991,\"USDDJF\":177.719801,\"USDDKK\":6.595891,\"USDDOP\":50.230106,\"USDDZD\":119.139997,\"USDEGP\":16.745997,\"USDERN\":15.000111,\"USDETB\":28.847999,\"USDEUR\":0.88328,\"USDFJD\":2.14985,\"USDFKP\":0.786445,\"USDGBP\":0.78515,\"USDGEL\":2.735018,\"USDGGP\":0.785075,\"USDGHS\":5.358495,\"USDGIP\":0.78641,\"USDGMD\":49.195007,\"USDGNF\":9132.749955,\"USDGTQ\":7.70795,\"USDGYD\":209.40496,\"USDHKD\":7.84145,\"USDHNL\":24.466994,\"USDHRK\":6.549503,\"USDHTG\":92.2265,\"USDHUF\":283.584044,\"USDIDR\":14219,\"USDILS\":3.58673,\"USDIMP\":0.785075,\"USDINR\":69.372502,\"USDIQD\":1192.9,\"USDIRR\":42104.999836,\"USDISK\":123.029772,\"USDJEP\":0.785075,\"USDJMD\":130.660119,\"USDJOD\":0.708977,\"USDJPY\":107.962017,\"USDKES\":101.210142,\"USDKGS\":69.7568,\"USDKHR\":4065.000141,\"USDKMF\":436.749934,\"USDKPW\":900.033948,\"USDKRW\":1181.88034,\"USDKWD\":0.30394,\"USDKYD\":0.833155,\"USDKZT\":383.139659,\"USDLAK\":8700.316576,\"USDLBP\":1511.649697,\"USDLKR\":176.439897,\"USDLRD\":193.750298,\"USDLSL\":15.009705,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39955,\"USDMAD\":9.622403,\"USDMDL\":18.095502,\"USDMGA\":3659.000223,\"USDMKD\":54.364996,\"USDMMK\":1523.149988,\"USDMNT\":2648.5231,\"USDMOP\":8.07435,\"USDMRO\":356.999784,\"USDMUR\":35.350501,\"USDMVR\":15.411953,\"USDMWK\":745.385,\"USDMXN\":19.73529,\"USDMYR\":4.15535,\"USDMZN\":62.239931,\"USDNAD\":15.009431,\"USDNGN\":306.449765,\"USDNIO\":32.9415,\"USDNOK\":8.65281,\"USDNPR\":111.120228,\"USDNZD\":1.501815,\"USDOMR\":0.385015,\"USDPAB\":0.99985,\"USDPEN\":3.34385,\"USDPGK\":3.37395,\"USDPHP\":51.937053,\"USDPKR\":146.919751,\"USDPLN\":3.77023,\"USDPYG\":6286.299493,\"USDQAR\":3.64125,\"USDRON\":4.16925,\"USDRSD\":104.169768,\"USDRUB\":64.923017,\"USDRWF\":909.03,\"USDSAR\":3.749402,\"USDSBD\":8.22605,\"USDSCR\":13.680498,\"USDSDG\":45.092502,\"USDSEK\":9.40762,\"USDSGD\":1.363435,\"USDSHP\":1.320899,\"USDSLL\":8900.000082,\"USDSOS\":584.000204,\"USDSRD\":7.458038,\"USDSTD\":21050.59961,\"USDSVC\":8.74775,\"USDSYP\":515.000187,\"USDSZL\":15.096505,\"USDTHB\":31.283498,\"USDTJS\":9.42735,\"USDTMT\":3.51,\"USDTND\":2.95685,\"USDTOP\":2.28395,\"USDTRY\":5.809202,\"USDTTD\":6.77115,\"USDTWD\":31.395033,\"USDTZS\":2298.200729,\"USDUAH\":26.535003,\"USDUGX\":3763.950246,\"USDUSD\":1,\"USDUYU\":35.065501,\"USDUZS\":8491.749667,\"USDVEF\":9.987497,\"USDVND\":23396,\"USDVUV\":115.500446,\"USDWST\":2.624693,\"USDXAF\":582.260085,\"USDXAG\":0.066569,\"USDXAU\":0.000744,\"USDXCD\":2.70255,\"USDXDR\":0.721717,\"USDXOF\":582.239602,\"USDXPF\":105.859598,\"USDYER\":250.35013,\"USDZAR\":15.01805,\"USDZMK\":9001.188836,\"USDZMW\":13.241961,\"USDZWL\":322.355011}}', 1, '2019-06-07 13:14:05', '2019-06-07 14:14:04', '2019-06-07 14:14:04', 'USD'),
(752, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1559919844,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.324973,\"USDALL\":108.298676,\"USDAMD\":479.610238,\"USDANG\":1.874497,\"USDAOA\":333.781505,\"USDARS\":44.867002,\"USDAUD\":1.42555,\"USDAWG\":1.8,\"USDAZN\":1.704991,\"USDBAM\":1.73605,\"USDBBD\":1.9911,\"USDBDT\":84.528017,\"USDBGN\":1.72495,\"USDBHD\":0.37705,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.350501,\"USDBOB\":6.90825,\"USDBRL\":3.8554,\"USDBSD\":0.99985,\"USDBTC\":0.000126,\"USDBTN\":69.374556,\"USDBWP\":10.963003,\"USDBYN\":2.09075,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.328405,\"USDCDF\":1660.999787,\"USDCHF\":0.986805,\"USDCLF\":0.025064,\"USDCLP\":691.693708,\"USDCNY\":6.909703,\"USDCOP\":3290,\"USDCRC\":591.844956,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.729501,\"USDCZK\":22.574973,\"USDDJF\":177.720185,\"USDDKK\":6.58497,\"USDDOP\":50.999853,\"USDDZD\":119.402922,\"USDEGP\":16.751501,\"USDERN\":14.999993,\"USDETB\":29.097886,\"USDEUR\":0.881855,\"USDFJD\":2.14925,\"USDFKP\":0.786455,\"USDGBP\":0.783865,\"USDGEL\":2.735011,\"USDGGP\":0.783809,\"USDGHS\":5.350439,\"USDGIP\":0.78642,\"USDGMD\":49.224992,\"USDGNF\":9239.999676,\"USDGTQ\":7.70795,\"USDGYD\":209.405022,\"USDHKD\":7.84095,\"USDHNL\":24.750246,\"USDHRK\":6.541305,\"USDHTG\":92.226496,\"USDHUF\":282.302989,\"USDIDR\":14206.5,\"USDILS\":3.575195,\"USDIMP\":0.783809,\"USDINR\":69.294982,\"USDIQD\":1190,\"USDIRR\":42105.000372,\"USDISK\":123.200244,\"USDJEP\":0.783809,\"USDJMD\":130.660061,\"USDJOD\":0.709024,\"USDJPY\":108.023965,\"USDKES\":101.203502,\"USDKGS\":69.756803,\"USDKHR\":4065.000094,\"USDKMF\":436.749971,\"USDKPW\":900.037537,\"USDKRW\":1180.119769,\"USDKWD\":0.303899,\"USDKYD\":0.833155,\"USDKZT\":383.140199,\"USDLAK\":8659.999923,\"USDLBP\":1506.150086,\"USDLKR\":176.439908,\"USDLRD\":193.749967,\"USDLSL\":15.010056,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.397339,\"USDMAD\":9.610794,\"USDMDL\":18.095499,\"USDMGA\":3622.502808,\"USDMKD\":54.360502,\"USDMMK\":1523.149955,\"USDMNT\":2647.432562,\"USDMOP\":8.07435,\"USDMRO\":356.999675,\"USDMUR\":35.352501,\"USDMVR\":15.395565,\"USDMWK\":745.349926,\"USDMXN\":19.63091,\"USDMYR\":4.148306,\"USDMZN\":62.240164,\"USDNAD\":15.009802,\"USDNGN\":306.449887,\"USDNIO\":33.395031,\"USDNOK\":8.61651,\"USDNPR\":111.120404,\"USDNZD\":1.49799,\"USDOMR\":0.38497,\"USDPAB\":0.99985,\"USDPEN\":3.338597,\"USDPGK\":3.376499,\"USDPHP\":51.914998,\"USDPKR\":150.769783,\"USDPLN\":3.75799,\"USDPYG\":6286.30246,\"USDQAR\":3.641249,\"USDRON\":4.161502,\"USDRSD\":104.0803,\"USDRUB\":64.803501,\"USDRWF\":905,\"USDSAR\":3.7505,\"USDSBD\":8.22605,\"USDSCR\":13.692014,\"USDSDG\":45.092502,\"USDSEK\":9.386005,\"USDSGD\":1.36136,\"USDSHP\":1.3209,\"USDSLL\":8899.999735,\"USDSOS\":583.999782,\"USDSRD\":7.457998,\"USDSTD\":21050.59961,\"USDSVC\":8.74775,\"USDSYP\":514.999714,\"USDSZL\":15.009877,\"USDTHB\":31.261981,\"USDTJS\":9.42735,\"USDTMT\":3.51,\"USDTND\":2.95335,\"USDTOP\":2.28395,\"USDTRY\":5.788845,\"USDTTD\":6.77115,\"USDTWD\":31.371504,\"USDTZS\":2297.803496,\"USDUAH\":26.534984,\"USDUGX\":3763.949901,\"USDUSD\":1,\"USDUYU\":35.065501,\"USDUZS\":8510.000058,\"USDVEF\":9.987496,\"USDVND\":23396,\"USDVUV\":115.403604,\"USDWST\":2.627559,\"USDXAF\":582.259973,\"USDXAG\":0.066236,\"USDXAU\":0.000744,\"USDXCD\":2.70255,\"USDXDR\":0.72125,\"USDXOF\":586.493009,\"USDXPF\":106.301415,\"USDYER\":250.349798,\"USDZAR\":14.917098,\"USDZMK\":9001.204736,\"USDZMW\":13.242015,\"USDZWL\":322.355011}}', 1, '2019-06-07 15:04:04', '2019-06-07 15:14:06', '2019-06-07 15:14:06', 'USD'),
(753, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1559923144,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":79.324945,\"USDALL\":107.895715,\"USDAMD\":479.610056,\"USDANG\":1.874498,\"USDAOA\":336.676034,\"USDARS\":44.875002,\"USDAUD\":1.428199,\"USDAWG\":1.8,\"USDAZN\":1.705009,\"USDBAM\":1.73605,\"USDBBD\":1.9911,\"USDBDT\":84.528036,\"USDBGN\":1.726751,\"USDBHD\":0.37705,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.90825,\"USDBRL\":3.86135,\"USDBSD\":0.99985,\"USDBTC\":0.000126,\"USDBTN\":69.341187,\"USDBWP\":10.963048,\"USDBYN\":2.09075,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.32872,\"USDCDF\":1660.999713,\"USDCHF\":0.987815,\"USDCLF\":0.025101,\"USDCLP\":692.549924,\"USDCNY\":6.909699,\"USDCOP\":3270.8,\"USDCRC\":591.844984,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.579503,\"USDCZK\":22.609015,\"USDDJF\":177.720543,\"USDDKK\":6.59395,\"USDDOP\":51.149733,\"USDDZD\":118.99043,\"USDEGP\":16.751959,\"USDERN\":14.999908,\"USDETB\":29.102952,\"USDEUR\":0.883025,\"USDFJD\":2.14905,\"USDFKP\":0.78642,\"USDGBP\":0.784999,\"USDGEL\":2.734993,\"USDGGP\":0.784899,\"USDGHS\":5.359677,\"USDGIP\":0.786425,\"USDGMD\":49.284982,\"USDGNF\":9245.000051,\"USDGTQ\":7.70795,\"USDGYD\":209.40498,\"USDHKD\":7.84165,\"USDHNL\":24.750044,\"USDHRK\":6.548956,\"USDHTG\":92.226495,\"USDHUF\":282.785992,\"USDIDR\":14217,\"USDILS\":3.575203,\"USDIMP\":0.784899,\"USDINR\":69.362498,\"USDIQD\":1190,\"USDIRR\":42104.999797,\"USDISK\":123.719955,\"USDJEP\":0.784899,\"USDJMD\":130.660172,\"USDJOD\":0.70902,\"USDJPY\":108.16997,\"USDKES\":101.142006,\"USDKGS\":69.756797,\"USDKHR\":4063.999875,\"USDKMF\":434.425009,\"USDKPW\":900.02924,\"USDKRW\":1181.402134,\"USDKWD\":0.303902,\"USDKYD\":0.833155,\"USDKZT\":383.139979,\"USDLAK\":8662.501853,\"USDLBP\":1507.950459,\"USDLKR\":176.439771,\"USDLRD\":193.999919,\"USDLSL\":14.970284,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.402424,\"USDMAD\":9.617299,\"USDMDL\":18.095498,\"USDMGA\":3622.504652,\"USDMKD\":54.355503,\"USDMMK\":1523.150317,\"USDMNT\":2658.893263,\"USDMOP\":8.07435,\"USDMRO\":357.00023,\"USDMUR\":35.349503,\"USDMVR\":15.394684,\"USDMWK\":745.470239,\"USDMXN\":19.65914,\"USDMYR\":4.148014,\"USDMZN\":62.239618,\"USDNAD\":14.970165,\"USDNGN\":306.449429,\"USDNIO\":33.395033,\"USDNOK\":8.62918,\"USDNPR\":111.119624,\"USDNZD\":1.500825,\"USDOMR\":0.384975,\"USDPAB\":0.99985,\"USDPEN\":3.33755,\"USDPGK\":3.376496,\"USDPHP\":51.949786,\"USDPKR\":150.769936,\"USDPLN\":3.76255,\"USDPYG\":6286.301156,\"USDQAR\":3.64125,\"USDRON\":4.165905,\"USDRSD\":104.219706,\"USDRUB\":64.856011,\"USDRWF\":905,\"USDSAR\":3.7505,\"USDSBD\":8.22605,\"USDSCR\":13.679843,\"USDSDG\":45.092502,\"USDSEK\":9.40371,\"USDSGD\":1.362555,\"USDSHP\":1.320899,\"USDSLL\":8899.999852,\"USDSOS\":583.999808,\"USDSRD\":7.457949,\"USDSTD\":21050.59961,\"USDSVC\":8.74775,\"USDSYP\":515.00021,\"USDSZL\":14.97041,\"USDTHB\":31.258499,\"USDTJS\":9.42735,\"USDTMT\":3.5,\"USDTND\":2.95445,\"USDTOP\":2.283951,\"USDTRY\":5.81861,\"USDTTD\":6.77115,\"USDTWD\":31.365018,\"USDTZS\":2297.149823,\"USDUAH\":26.535043,\"USDUGX\":3763.950117,\"USDUSD\":1,\"USDUYU\":35.070027,\"USDUZS\":8510.000431,\"USDVEF\":9.9875,\"USDVND\":23396,\"USDVUV\":115.50035,\"USDWST\":2.624735,\"USDXAF\":582.260357,\"USDXAG\":0.06658,\"USDXAU\":0.000746,\"USDXCD\":2.70255,\"USDXDR\":0.72075,\"USDXOF\":586.504144,\"USDXPF\":106.301759,\"USDYER\":250.418493,\"USDZAR\":14.98695,\"USDZMK\":9001.196414,\"USDZMW\":13.24196,\"USDZWL\":322.355011}}', 1, '2019-06-07 15:59:04', '2019-06-07 16:57:06', '2019-06-07 16:57:06', 'USD'),
(754, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1559933046,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673204,\"USDAFN\":79.325041,\"USDALL\":107.850403,\"USDAMD\":479.610403,\"USDANG\":1.874504,\"USDAOA\":336.676041,\"USDARS\":44.848504,\"USDAUD\":1.42797,\"USDAWG\":1.8,\"USDAZN\":1.705041,\"USDBAM\":1.73605,\"USDBBD\":1.9911,\"USDBDT\":84.528041,\"USDBGN\":1.725904,\"USDBHD\":0.377045,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.90825,\"USDBRL\":3.868504,\"USDBSD\":0.99985,\"USDBTC\":0.000123,\"USDBTN\":69.354456,\"USDBWP\":10.963041,\"USDBYN\":2.09075,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.32725,\"USDCDF\":1661.000362,\"USDCHF\":0.98727,\"USDCLF\":0.025101,\"USDCLP\":692.603912,\"USDCNY\":6.909804,\"USDCOP\":3275.1,\"USDCRC\":591.845041,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.580504,\"USDCZK\":22.58304,\"USDDJF\":177.720394,\"USDDKK\":6.587704,\"USDDOP\":51.07504,\"USDDZD\":119.090393,\"USDEGP\":16.75704,\"USDERN\":15.000358,\"USDETB\":29.120392,\"USDEUR\":0.88222,\"USDFJD\":2.15415,\"USDFKP\":0.786415,\"USDGBP\":0.78519,\"USDGEL\":2.730391,\"USDGGP\":0.785027,\"USDGHS\":5.36039,\"USDGIP\":0.786415,\"USDGMD\":49.27504,\"USDGNF\":9245.000355,\"USDGTQ\":7.70795,\"USDGYD\":209.40504,\"USDHKD\":7.84208,\"USDHNL\":24.770389,\"USDHRK\":6.543304,\"USDHTG\":92.226504,\"USDHUF\":282.29804,\"USDIDR\":14207.5,\"USDILS\":3.575204,\"USDIMP\":0.785027,\"USDINR\":69.357504,\"USDIQD\":1190,\"USDIRR\":42105.000352,\"USDISK\":123.570386,\"USDJEP\":0.785027,\"USDJMD\":130.660386,\"USDJOD\":0.70904,\"USDJPY\":108.247504,\"USDKES\":101.203804,\"USDKGS\":69.756804,\"USDKHR\":4064.000351,\"USDKMF\":434.550384,\"USDKPW\":900.033555,\"USDKRW\":1181.110384,\"USDKWD\":0.303904,\"USDKYD\":0.833155,\"USDKZT\":383.140383,\"USDLAK\":8650.000349,\"USDLBP\":1507.950382,\"USDLKR\":176.440382,\"USDLRD\":194.000348,\"USDLSL\":14.970382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.403765,\"USDMAD\":9.619039,\"USDMDL\":18.095504,\"USDMGA\":3617.503758,\"USDMKD\":54.36038,\"USDMMK\":1523.15038,\"USDMNT\":2658.858913,\"USDMOP\":8.07435,\"USDMRO\":357.000346,\"USDMUR\":35.343504,\"USDMVR\":15.450378,\"USDMWK\":745.515039,\"USDMXN\":19.587704,\"USDMYR\":4.148039,\"USDMZN\":62.240377,\"USDNAD\":14.970377,\"USDNGN\":306.450377,\"USDNIO\":33.403725,\"USDNOK\":8.61727,\"USDNPR\":111.120376,\"USDNZD\":1.500985,\"USDOMR\":0.385005,\"USDPAB\":0.99985,\"USDPEN\":3.33705,\"USDPGK\":3.375039,\"USDPHP\":51.915504,\"USDPKR\":149.540375,\"USDPLN\":3.75788,\"USDPYG\":6286.303699,\"USDQAR\":3.641038,\"USDRON\":4.163204,\"USDRSD\":104.120373,\"USDRUB\":64.854304,\"USDRWF\":906,\"USDSAR\":3.749804,\"USDSBD\":8.192304,\"USDSCR\":13.680504,\"USDSDG\":45.092504,\"USDSEK\":9.39122,\"USDSGD\":1.36214,\"USDSHP\":1.320904,\"USDSLL\":8910.000339,\"USDSOS\":585.000338,\"USDSRD\":7.458038,\"USDSTD\":21050.59961,\"USDSVC\":8.74775,\"USDSYP\":515.000338,\"USDSZL\":14.97037,\"USDTHB\":31.27037,\"USDTJS\":9.42735,\"USDTMT\":3.5,\"USDTND\":2.95445,\"USDTOP\":2.28395,\"USDTRY\":5.826504,\"USDTTD\":6.77115,\"USDTWD\":31.344504,\"USDTZS\":2297.303635,\"USDUAH\":26.535038,\"USDUGX\":3763.950367,\"USDUSD\":1,\"USDUYU\":35.070367,\"USDUZS\":8510.000335,\"USDVEF\":9.987504,\"USDVND\":23397,\"USDVUV\":115.500615,\"USDWST\":2.62489,\"USDXAF\":582.260365,\"USDXAG\":0.06668,\"USDXAU\":0.000747,\"USDXCD\":2.70255,\"USDXDR\":0.720763,\"USDXOF\":584.000332,\"USDXPF\":105.550364,\"USDYER\":250.403597,\"USDZAR\":14.95485,\"USDZMK\":9001.203593,\"USDZMW\":13.242037,\"USDZWL\":322.355011}}', 1, '2019-06-07 18:44:06', '2019-06-07 18:58:50', '2019-06-07 18:58:50', 'USD'),
(755, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560183845,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673097,\"USDAFN\":79.299134,\"USDALL\":107.809757,\"USDAMD\":479.520133,\"USDANG\":1.874796,\"USDAOA\":338.983499,\"USDARS\":44.939501,\"USDAUD\":1.43595,\"USDAWG\":1.8,\"USDAZN\":1.70498,\"USDBAM\":1.72945,\"USDBBD\":2.00145,\"USDBDT\":84.312001,\"USDBGN\":1.73095,\"USDBHD\":0.377018,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.3507,\"USDBOB\":6.87615,\"USDBRL\":3.872203,\"USDBSD\":0.99765,\"USDBTC\":0.000126,\"USDBTN\":69.511815,\"USDBWP\":10.906941,\"USDBYN\":2.077295,\"USDBYR\":19600,\"USDBZD\":2.015499,\"USDCAD\":1.32641,\"USDCDF\":1660.000196,\"USDCHF\":0.989701,\"USDCLF\":0.025275,\"USDCLP\":697.494983,\"USDCNY\":6.931032,\"USDCOP\":3251.9,\"USDCRC\":591.689712,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.721499,\"USDCZK\":22.649102,\"USDDJF\":177.720096,\"USDDKK\":6.601301,\"USDDOP\":51.105011,\"USDDZD\":118.950343,\"USDEGP\":16.7397,\"USDERN\":15.000056,\"USDETB\":29.099688,\"USDEUR\":0.883895,\"USDFJD\":2.13865,\"USDFKP\":0.7889,\"USDGBP\":0.78827,\"USDGEL\":2.735025,\"USDGGP\":0.788332,\"USDGHS\":5.395028,\"USDGIP\":0.788865,\"USDGMD\":49.215033,\"USDGNF\":9235.000319,\"USDGTQ\":7.70285,\"USDGYD\":209.775019,\"USDHKD\":7.843297,\"USDHNL\":24.749886,\"USDHRK\":6.5557,\"USDHTG\":92.574498,\"USDHUF\":282.900075,\"USDIDR\":14238.5,\"USDILS\":3.5799,\"USDIMP\":0.788332,\"USDINR\":69.497499,\"USDIQD\":1190,\"USDIRR\":42105.000174,\"USDISK\":123.850228,\"USDJEP\":0.788332,\"USDJMD\":130.29006,\"USDJOD\":0.709023,\"USDJPY\":108.538504,\"USDKES\":101.289949,\"USDKGS\":69.729703,\"USDKHR\":4074.999731,\"USDKMF\":435.374999,\"USDKPW\":900.031422,\"USDKRW\":1183.869807,\"USDKWD\":0.3039,\"USDKYD\":0.833245,\"USDKZT\":383.509538,\"USDLAK\":8649.999619,\"USDLBP\":1507.549921,\"USDLKR\":176.449865,\"USDLRD\":193.796572,\"USDLSL\":15.009934,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395009,\"USDMAD\":9.627992,\"USDMDL\":18.049503,\"USDMGA\":3622.527064,\"USDMKD\":54.470208,\"USDMMK\":1527.398368,\"USDMNT\":2658.902504,\"USDMOP\":8.07765,\"USDMRO\":357.000389,\"USDMUR\":35.547497,\"USDMVR\":15.449705,\"USDMWK\":745.495011,\"USDMXN\":19.17325,\"USDMYR\":4.160603,\"USDMZN\":62.22004,\"USDNAD\":14.402368,\"USDNGN\":360.000329,\"USDNIO\":33.39501,\"USDNOK\":8.649402,\"USDNPR\":111.402876,\"USDNZD\":1.511395,\"USDOMR\":0.38495,\"USDPAB\":0.99765,\"USDPEN\":3.334903,\"USDPGK\":3.386904,\"USDPHP\":52.092014,\"USDPKR\":151.250362,\"USDPLN\":3.76805,\"USDPYG\":6269.549829,\"USDQAR\":3.64125,\"USDRON\":4.170202,\"USDRSD\":104.270035,\"USDRUB\":64.708104,\"USDRWF\":906,\"USDSAR\":3.7513,\"USDSBD\":8.22605,\"USDSCR\":13.680501,\"USDSDG\":45.10799,\"USDSEK\":9.413899,\"USDSGD\":1.365775,\"USDSHP\":1.320898,\"USDSLL\":8874.999759,\"USDSOS\":585.00015,\"USDSRD\":7.458009,\"USDSTD\":21050.59961,\"USDSVC\":8.749851,\"USDSYP\":515.000448,\"USDSZL\":14.92977,\"USDTHB\":31.349603,\"USDTJS\":9.43985,\"USDTMT\":3.5,\"USDTND\":2.94845,\"USDTOP\":2.279303,\"USDTRY\":5.775496,\"USDTTD\":6.74715,\"USDTWD\":31.3775,\"USDTZS\":2298.298647,\"USDUAH\":26.313962,\"USDUGX\":3759.780379,\"USDUSD\":1,\"USDUYU\":35.370249,\"USDUZS\":8509.999703,\"USDVEF\":9.987504,\"USDVND\":23365,\"USDVUV\":115.210513,\"USDWST\":2.627189,\"USDXAF\":580.049647,\"USDXAG\":0.068101,\"USDXAU\":0.000753,\"USDXCD\":2.70255,\"USDXDR\":0.721949,\"USDXOF\":586.496617,\"USDXPF\":105.874959,\"USDYER\":250.350277,\"USDZAR\":14.80595,\"USDZMK\":9001.196617,\"USDZMW\":13.234019,\"USDZWL\":322.355011}}', 1, '2019-06-10 16:24:05', '2019-06-10 17:27:54', '2019-06-10 17:27:54', 'USD'),
(756, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560249845,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.507009,\"USDALL\":107.679751,\"USDAMD\":479.164995,\"USDANG\":1.873205,\"USDAOA\":338.983505,\"USDARS\":44.868958,\"USDAUD\":1.43775,\"USDAWG\":1.8,\"USDAZN\":1.705032,\"USDBAM\":1.728029,\"USDBBD\":1.99975,\"USDBDT\":84.417494,\"USDBGN\":1.728402,\"USDBHD\":0.37705,\"USDBIF\":1837.05,\"USDBMD\":1,\"USDBND\":1.350397,\"USDBOB\":6.917897,\"USDBRL\":3.886024,\"USDBSD\":0.999095,\"USDBTC\":0.000128,\"USDBTN\":69.439288,\"USDBWP\":10.889502,\"USDBYN\":2.07545,\"USDBYR\":19600,\"USDBZD\":2.013801,\"USDCAD\":1.32584,\"USDCDF\":1660.000312,\"USDCHF\":0.991802,\"USDCLF\":0.025376,\"USDCLP\":700.198858,\"USDCNY\":6.911899,\"USDCOP\":3265.75,\"USDCRC\":591.180247,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.425993,\"USDCZK\":22.670596,\"USDDJF\":177.720091,\"USDDKK\":6.60046,\"USDDOP\":50.558007,\"USDDZD\":119.08968,\"USDEGP\":16.761798,\"USDERN\":15.000238,\"USDETB\":28.693023,\"USDEUR\":0.88368,\"USDFJD\":2.146901,\"USDFKP\":0.78849,\"USDGBP\":0.78624,\"USDGEL\":3.229739,\"USDGGP\":0.786191,\"USDGHS\":5.355032,\"USDGIP\":0.78849,\"USDGMD\":49.215003,\"USDGNF\":9166.398764,\"USDGTQ\":7.69635,\"USDGYD\":209.575024,\"USDHKD\":7.835398,\"USDHNL\":24.492498,\"USDHRK\":6.5494,\"USDHTG\":92.499505,\"USDHUF\":283.51602,\"USDIDR\":14223.5,\"USDILS\":3.581298,\"USDIMP\":0.786191,\"USDINR\":69.434947,\"USDIQD\":1186.6,\"USDIRR\":42105.000101,\"USDISK\":124.160025,\"USDJEP\":0.786191,\"USDJMD\":130.415004,\"USDJOD\":0.708979,\"USDJPY\":108.695985,\"USDKES\":101.409753,\"USDKGS\":69.729698,\"USDKHR\":4068.396418,\"USDKMF\":435.375037,\"USDKPW\":900.050526,\"USDKRW\":1181.330014,\"USDKWD\":0.303901,\"USDKYD\":0.83255,\"USDKZT\":383.180128,\"USDLAK\":8697.000285,\"USDLBP\":1510.799774,\"USDLKR\":176.46033,\"USDLRD\":193.800572,\"USDLSL\":15.00985,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.3986,\"USDMAD\":9.60835,\"USDMDL\":18.032992,\"USDMGA\":3638.550118,\"USDMKD\":54.340108,\"USDMMK\":1526.049924,\"USDMNT\":2658.585767,\"USDMOP\":8.070497,\"USDMRO\":356.999846,\"USDMUR\":35.549017,\"USDMVR\":15.450065,\"USDMWK\":745.349983,\"USDMXN\":19.167601,\"USDMYR\":4.162099,\"USDMZN\":62.22056,\"USDNAD\":14.396166,\"USDNGN\":306.749594,\"USDNIO\":33.373504,\"USDNOK\":8.64413,\"USDNPR\":111.30498,\"USDNZD\":1.51897,\"USDOMR\":0.385025,\"USDPAB\":0.9991,\"USDPEN\":3.33415,\"USDPGK\":3.386902,\"USDPHP\":51.920124,\"USDPKR\":152.000218,\"USDPLN\":3.77145,\"USDPYG\":6264.149686,\"USDQAR\":3.64125,\"USDRON\":4.1752,\"USDRSD\":104.279665,\"USDRUB\":64.521498,\"USDRWF\":894.12,\"USDSAR\":3.75025,\"USDSBD\":8.20555,\"USDSCR\":13.680496,\"USDSDG\":45.068941,\"USDSEK\":9.43877,\"USDSGD\":1.364895,\"USDSHP\":1.320899,\"USDSLL\":8874.999904,\"USDSOS\":584.999673,\"USDSRD\":7.458013,\"USDSTD\":21050.59961,\"USDSVC\":8.74255,\"USDSYP\":514.999945,\"USDSZL\":14.892497,\"USDTHB\":31.297294,\"USDTJS\":9.43155,\"USDTMT\":3.5,\"USDTND\":2.955401,\"USDTOP\":2.28555,\"USDTRY\":5.797815,\"USDTTD\":6.74875,\"USDTWD\":31.382497,\"USDTZS\":2297.791204,\"USDUAH\":26.291026,\"USDUGX\":3756.549708,\"USDUSD\":1,\"USDUYU\":35.342502,\"USDUZS\":8510.85016,\"USDVEF\":9.987505,\"USDVND\":23340,\"USDVUV\":115.640066,\"USDWST\":2.635566,\"USDXAF\":579.550511,\"USDXAG\":0.068011,\"USDXAU\":0.000756,\"USDXCD\":2.70255,\"USDXDR\":0.7216,\"USDXOF\":579.55044,\"USDXPF\":105.369717,\"USDYER\":250.350124,\"USDZAR\":14.76585,\"USDZMK\":9001.205659,\"USDZMW\":13.223054,\"USDZWL\":322.355011}}', 1, '2019-06-11 10:44:05', '2019-06-11 10:57:05', '2019-06-11 10:57:05', 'USD'),
(757, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560253145,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.168502,\"USDALL\":107.750238,\"USDAMD\":478.815056,\"USDANG\":1.87425,\"USDAOA\":338.9835,\"USDARS\":44.865801,\"USDAUD\":1.4375,\"USDAWG\":1.8,\"USDAZN\":1.705029,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.461502,\"USDBGN\":1.729098,\"USDBHD\":0.37695,\"USDBIF\":1834.95,\"USDBMD\":0.999975,\"USDBND\":1.35065,\"USDBOB\":6.907298,\"USDBRL\":3.885894,\"USDBSD\":0.9996,\"USDBTC\":0.000129,\"USDBTN\":69.447514,\"USDBWP\":10.853497,\"USDBYN\":2.068794,\"USDBYR\":19600,\"USDBZD\":2.014898,\"USDCAD\":1.325645,\"USDCDF\":1660.000214,\"USDCHF\":0.991297,\"USDCLF\":0.025356,\"USDCLP\":699.650186,\"USDCNY\":6.9121,\"USDCOP\":3258.25,\"USDCRC\":590.520194,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.422988,\"USDCZK\":22.674015,\"USDDJF\":177.720145,\"USDDKK\":6.60185,\"USDDOP\":51.402706,\"USDDZD\":119.124975,\"USDEGP\":16.764984,\"USDERN\":15.000216,\"USDETB\":28.8445,\"USDEUR\":0.88393,\"USDFJD\":2.146902,\"USDFKP\":0.788495,\"USDGBP\":0.78751,\"USDGEL\":3.229928,\"USDGGP\":0.78755,\"USDGHS\":5.372903,\"USDGIP\":0.788495,\"USDGMD\":49.357497,\"USDGNF\":9131.900781,\"USDGTQ\":7.697007,\"USDGYD\":208.695015,\"USDHKD\":7.83535,\"USDHNL\":24.465973,\"USDHRK\":6.556798,\"USDHTG\":92.3695,\"USDHUF\":283.40138,\"USDIDR\":14225.5,\"USDILS\":3.58097,\"USDIMP\":0.78755,\"USDINR\":69.454503,\"USDIQD\":1192.7,\"USDIRR\":42104.999757,\"USDISK\":124.210436,\"USDJEP\":0.78755,\"USDJMD\":130.170049,\"USDJOD\":0.710102,\"USDJPY\":108.719495,\"USDKES\":101.389965,\"USDKGS\":69.729703,\"USDKHR\":4070.350135,\"USDKMF\":435.374992,\"USDKPW\":900.052981,\"USDKRW\":1181.569944,\"USDKWD\":0.303897,\"USDKYD\":0.83296,\"USDKZT\":383.969865,\"USDLAK\":8714.101156,\"USDLBP\":1512.603533,\"USDLKR\":176.504996,\"USDLRD\":193.802742,\"USDLSL\":15.010301,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.399398,\"USDMAD\":9.616698,\"USDMDL\":18.117969,\"USDMGA\":3657.601466,\"USDMKD\":54.375031,\"USDMMK\":1526.449748,\"USDMNT\":2658.954338,\"USDMOP\":8.067303,\"USDMRO\":356.999738,\"USDMUR\":35.440268,\"USDMVR\":15.450316,\"USDMWK\":745.444985,\"USDMXN\":19.1835,\"USDMYR\":4.16301,\"USDMZN\":62.219911,\"USDNAD\":14.409895,\"USDNGN\":360.360402,\"USDNIO\":32.937019,\"USDNOK\":8.63822,\"USDNPR\":111.064993,\"USDNZD\":1.518797,\"USDOMR\":0.384986,\"USDPAB\":0.9996,\"USDPEN\":3.3359,\"USDPGK\":3.37355,\"USDPHP\":51.94699,\"USDPKR\":151.99016,\"USDPLN\":3.77198,\"USDPYG\":6255.04988,\"USDQAR\":3.641601,\"USDRON\":4.176894,\"USDRSD\":104.297209,\"USDRUB\":64.538502,\"USDRWF\":909.12,\"USDSAR\":3.751022,\"USDSBD\":8.20555,\"USDSCR\":13.680183,\"USDSDG\":45.088502,\"USDSEK\":9.43782,\"USDSGD\":1.364775,\"USDSHP\":1.320899,\"USDSLL\":8874.999947,\"USDSOS\":585.000366,\"USDSRD\":7.458044,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":515.000358,\"USDSZL\":14.781501,\"USDTHB\":31.280343,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.943201,\"USDTOP\":2.28555,\"USDTRY\":5.80913,\"USDTTD\":6.77115,\"USDTWD\":31.386997,\"USDTZS\":2298.082747,\"USDUAH\":26.350992,\"USDUGX\":3750.550019,\"USDUSD\":1,\"USDUYU\":35.420083,\"USDUZS\":8512.84988,\"USDVEF\":9.987501,\"USDVND\":23370,\"USDVUV\":115.641005,\"USDWST\":2.63737,\"USDXAF\":579.540219,\"USDXAG\":0.068171,\"USDXAU\":0.000757,\"USDXCD\":2.709799,\"USDXDR\":0.72175,\"USDXOF\":579.539465,\"USDXPF\":105.370129,\"USDYER\":250.350058,\"USDZAR\":14.776901,\"USDZMK\":9001.202945,\"USDZMW\":13.145036,\"USDZWL\":322.355011}}', 1, '2019-06-11 11:39:05', '2019-06-11 11:57:03', '2019-06-11 11:57:03', 'USD'),
(758, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560256445,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.168497,\"USDALL\":107.70389,\"USDAMD\":479.360134,\"USDANG\":1.87425,\"USDAOA\":338.983499,\"USDARS\":44.871601,\"USDAUD\":1.43865,\"USDAWG\":1.8,\"USDAZN\":1.705008,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.4615,\"USDBGN\":1.730303,\"USDBHD\":0.37685,\"USDBIF\":1834.95,\"USDBMD\":0.999975,\"USDBND\":1.350699,\"USDBOB\":6.907303,\"USDBRL\":3.8787,\"USDBSD\":0.9996,\"USDBTC\":0.000128,\"USDBTN\":69.457091,\"USDBWP\":10.853498,\"USDBYN\":2.0688,\"USDBYR\":19600,\"USDBZD\":2.014902,\"USDCAD\":1.32575,\"USDCDF\":1660.000065,\"USDCHF\":0.993305,\"USDCLF\":0.025256,\"USDCLP\":696.794587,\"USDCNY\":6.912705,\"USDCOP\":3258.25,\"USDCRC\":590.520355,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.422983,\"USDCZK\":22.676992,\"USDDJF\":177.719896,\"USDDKK\":6.60623,\"USDDOP\":51.39843,\"USDDZD\":119.044966,\"USDEGP\":16.7715,\"USDERN\":15.000375,\"USDETB\":28.8445,\"USDEUR\":0.884475,\"USDFJD\":2.146905,\"USDFKP\":0.787205,\"USDGBP\":0.787599,\"USDGEL\":3.229655,\"USDGGP\":0.787693,\"USDGHS\":5.372899,\"USDGIP\":0.787305,\"USDGMD\":49.357503,\"USDGNF\":9131.900773,\"USDGTQ\":7.696976,\"USDGYD\":208.694989,\"USDHKD\":7.83535,\"USDHNL\":24.46601,\"USDHRK\":6.555897,\"USDHTG\":92.3695,\"USDHUF\":283.589656,\"USDIDR\":14228,\"USDILS\":3.583299,\"USDIMP\":0.787693,\"USDINR\":69.451049,\"USDIQD\":1192.7,\"USDIRR\":42104.999832,\"USDISK\":124.269914,\"USDJEP\":0.787693,\"USDJMD\":130.169742,\"USDJOD\":0.710103,\"USDJPY\":108.798503,\"USDKES\":101.399763,\"USDKGS\":69.771097,\"USDKHR\":4070.349598,\"USDKMF\":435.375021,\"USDKPW\":900.061232,\"USDKRW\":1180.839567,\"USDKWD\":0.3039,\"USDKYD\":0.83296,\"USDKZT\":383.970041,\"USDLAK\":8714.084889,\"USDLBP\":1512.60046,\"USDLKR\":176.504995,\"USDLRD\":193.80203,\"USDLSL\":15.010022,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.399402,\"USDMAD\":9.616198,\"USDMDL\":18.117995,\"USDMGA\":3657.583987,\"USDMKD\":54.369842,\"USDMMK\":1526.450122,\"USDMNT\":2658.753828,\"USDMOP\":8.0673,\"USDMRO\":357.00014,\"USDMUR\":35.353496,\"USDMVR\":15.45036,\"USDMWK\":745.494987,\"USDMXN\":19.161102,\"USDMYR\":4.161099,\"USDMZN\":62.21992,\"USDNAD\":14.410286,\"USDNGN\":360.360233,\"USDNIO\":32.937,\"USDNOK\":8.63996,\"USDNPR\":111.064987,\"USDNZD\":1.52175,\"USDOMR\":0.385015,\"USDPAB\":0.9996,\"USDPEN\":3.33615,\"USDPGK\":3.37355,\"USDPHP\":51.946998,\"USDPKR\":151.989618,\"USDPLN\":3.77436,\"USDPYG\":6255.049898,\"USDQAR\":3.641597,\"USDRON\":4.17905,\"USDRSD\":104.359504,\"USDRUB\":64.520966,\"USDRWF\":909.12,\"USDSAR\":3.750498,\"USDSBD\":8.20555,\"USDSCR\":13.678001,\"USDSDG\":45.088503,\"USDSEK\":9.44722,\"USDSGD\":1.365095,\"USDSHP\":1.320897,\"USDSLL\":8875.000097,\"USDSOS\":584.999745,\"USDSRD\":7.457953,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":515.000305,\"USDSZL\":14.781498,\"USDTHB\":31.293029,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.95685,\"USDTOP\":2.28555,\"USDTRY\":5.81737,\"USDTTD\":6.77115,\"USDTWD\":31.395504,\"USDTZS\":2297.196786,\"USDUAH\":26.350999,\"USDUGX\":3750.55044,\"USDUSD\":1,\"USDUYU\":35.420325,\"USDUZS\":8512.849708,\"USDVEF\":9.987498,\"USDVND\":23370,\"USDVUV\":115.640049,\"USDWST\":2.633883,\"USDXAF\":579.539502,\"USDXAG\":0.068129,\"USDXAU\":0.000757,\"USDXCD\":2.709795,\"USDXDR\":0.72195,\"USDXOF\":579.540212,\"USDXPF\":105.37032,\"USDYER\":250.349753,\"USDZAR\":14.77235,\"USDZMK\":9001.195264,\"USDZMW\":13.144973,\"USDZWL\":322.355011}}', 1, '2019-06-11 12:34:05', '2019-06-11 12:57:05', '2019-06-11 12:57:05', 'USD'),
(759, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560259744,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.450097,\"USDALL\":107.75043,\"USDAMD\":479.359922,\"USDANG\":1.874251,\"USDAOA\":338.983495,\"USDARS\":44.857697,\"USDAUD\":1.43655,\"USDAWG\":1.8,\"USDAZN\":1.705023,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.461501,\"USDBGN\":1.727502,\"USDBHD\":0.37695,\"USDBIF\":1860,\"USDBMD\":0.999975,\"USDBND\":1.35055,\"USDBOB\":6.907299,\"USDBRL\":3.865102,\"USDBSD\":0.9996,\"USDBTC\":0.000128,\"USDBTN\":69.390584,\"USDBWP\":10.853498,\"USDBYN\":2.068801,\"USDBYR\":19600,\"USDBZD\":2.014898,\"USDCAD\":1.32583,\"USDCDF\":1660.999982,\"USDCHF\":0.992297,\"USDCLF\":0.025135,\"USDCLP\":693.500532,\"USDCNY\":6.911201,\"USDCOP\":3247.5,\"USDCRC\":590.519987,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.900501,\"USDCZK\":22.629611,\"USDDJF\":177.720211,\"USDDKK\":6.59632,\"USDDOP\":51.034963,\"USDDZD\":119.08989,\"USDEGP\":16.730978,\"USDERN\":14.999865,\"USDETB\":29.05987,\"USDEUR\":0.883195,\"USDFJD\":2.1469,\"USDFKP\":0.787285,\"USDGBP\":0.78636,\"USDGEL\":2.729901,\"USDGGP\":0.786493,\"USDGHS\":5.394958,\"USDGIP\":0.78729,\"USDGMD\":49.745012,\"USDGNF\":9235.000163,\"USDGTQ\":7.697036,\"USDGYD\":208.69498,\"USDHKD\":7.83555,\"USDHNL\":25.24994,\"USDHRK\":6.547898,\"USDHTG\":92.369498,\"USDHUF\":283.219721,\"USDIDR\":14204.5,\"USDILS\":3.580304,\"USDIMP\":0.786493,\"USDINR\":69.396993,\"USDIQD\":1190,\"USDIRR\":42104.999615,\"USDISK\":124.080238,\"USDJEP\":0.786493,\"USDJMD\":130.169893,\"USDJOD\":0.710098,\"USDJPY\":108.671985,\"USDKES\":101.439716,\"USDKGS\":69.771101,\"USDKHR\":4075.00017,\"USDKMF\":435.375046,\"USDKPW\":900.057833,\"USDKRW\":1179.000069,\"USDKWD\":0.303898,\"USDKYD\":0.83296,\"USDKZT\":383.970011,\"USDLAK\":8649.999867,\"USDLBP\":1507.649968,\"USDLKR\":176.450058,\"USDLRD\":193.798647,\"USDLSL\":14.789842,\"USDLTL\":2.95274,\"USDLVL\":0.604889,\"USDLYD\":1.39498,\"USDMAD\":9.612301,\"USDMDL\":18.117975,\"USDMGA\":3649.999893,\"USDMKD\":54.345014,\"USDMMK\":1526.450111,\"USDMNT\":2658.708676,\"USDMOP\":8.067301,\"USDMRO\":356.999956,\"USDMUR\":35.550502,\"USDMVR\":15.450275,\"USDMWK\":745.405006,\"USDMXN\":19.143898,\"USDMYR\":4.15955,\"USDMZN\":62.220503,\"USDNAD\":14.789838,\"USDNGN\":359.999915,\"USDNIO\":16.89876,\"USDNOK\":8.62287,\"USDNPR\":111.065037,\"USDNZD\":1.51844,\"USDOMR\":0.384925,\"USDPAB\":0.9996,\"USDPEN\":3.33555,\"USDPGK\":3.374961,\"USDPHP\":51.888979,\"USDPKR\":151.909715,\"USDPLN\":3.76815,\"USDPYG\":6255.050081,\"USDQAR\":3.64103,\"USDRON\":4.172198,\"USDRSD\":104.189653,\"USDRUB\":64.48101,\"USDRWF\":906,\"USDSAR\":3.75115,\"USDSBD\":8.20555,\"USDSCR\":13.678954,\"USDSDG\":45.088497,\"USDSEK\":9.43052,\"USDSGD\":1.363755,\"USDSHP\":1.320896,\"USDSLL\":8874.999407,\"USDSOS\":584.999996,\"USDSRD\":7.458057,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":514.999961,\"USDSZL\":14.789977,\"USDTHB\":31.269823,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.955503,\"USDTOP\":2.28555,\"USDTRY\":5.820965,\"USDTTD\":6.77115,\"USDTWD\":31.373498,\"USDTZS\":2298.000123,\"USDUAH\":26.351019,\"USDUGX\":3750.54968,\"USDUSD\":1,\"USDUYU\":35.420035,\"USDUZS\":8511.497113,\"USDVEF\":9.987503,\"USDVND\":23365,\"USDVUV\":115.640804,\"USDWST\":2.640817,\"USDXAF\":579.540631,\"USDXAG\":0.06799,\"USDXAU\":0.000755,\"USDXCD\":2.709803,\"USDXDR\":0.72155,\"USDXOF\":581.501928,\"USDXPF\":105.875045,\"USDYER\":250.35037,\"USDZAR\":14.73455,\"USDZMK\":9001.20203,\"USDZMW\":13.144998,\"USDZWL\":322.355011}}', 1, '2019-06-11 13:29:04', '2019-06-11 13:57:05', '2019-06-11 13:57:05', 'USD'),
(760, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560263045,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.450265,\"USDALL\":107.703933,\"USDAMD\":479.36007,\"USDANG\":1.87425,\"USDAOA\":338.983503,\"USDARS\":44.765503,\"USDAUD\":1.4383,\"USDAWG\":1.8,\"USDAZN\":1.705018,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.461504,\"USDBGN\":1.728397,\"USDBHD\":0.37705,\"USDBIF\":1860,\"USDBMD\":0.999975,\"USDBND\":1.350497,\"USDBOB\":6.907302,\"USDBRL\":3.863301,\"USDBSD\":0.9996,\"USDBTC\":0.000128,\"USDBTN\":69.392406,\"USDBWP\":10.8535,\"USDBYN\":2.068799,\"USDBYR\":19600,\"USDBZD\":2.014902,\"USDCAD\":1.32704,\"USDCDF\":1661.000578,\"USDCHF\":0.99291,\"USDCLF\":0.025137,\"USDCLP\":693.700554,\"USDCNY\":6.911302,\"USDCOP\":3242.9,\"USDCRC\":590.52006,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.900498,\"USDCZK\":22.641966,\"USDDJF\":177.719853,\"USDDKK\":6.60021,\"USDDOP\":51.035021,\"USDDZD\":119.097429,\"USDEGP\":16.747011,\"USDERN\":15.000072,\"USDETB\":29.06016,\"USDEUR\":0.883705,\"USDFJD\":2.146899,\"USDFKP\":0.787302,\"USDGBP\":0.78657,\"USDGEL\":2.730132,\"USDGGP\":0.786582,\"USDGHS\":5.394978,\"USDGIP\":0.78727,\"USDGMD\":49.744977,\"USDGNF\":9234.999657,\"USDGTQ\":7.697004,\"USDGYD\":208.69496,\"USDHKD\":7.83555,\"USDHNL\":25.249948,\"USDHRK\":6.5552,\"USDHTG\":92.369504,\"USDHUF\":283.669001,\"USDIDR\":14211.5,\"USDILS\":3.580595,\"USDIMP\":0.786582,\"USDINR\":69.39725,\"USDIQD\":1190,\"USDIRR\":42104.99999,\"USDISK\":124.160172,\"USDJEP\":0.786582,\"USDJMD\":130.169855,\"USDJOD\":0.7101,\"USDJPY\":108.66899,\"USDKES\":101.396194,\"USDKGS\":69.7711,\"USDKHR\":4075.000262,\"USDKMF\":435.37502,\"USDKPW\":900.057837,\"USDKRW\":1179.149854,\"USDKWD\":0.303841,\"USDKYD\":0.83296,\"USDKZT\":383.970289,\"USDLAK\":8649.99982,\"USDLBP\":1507.650157,\"USDLKR\":176.450387,\"USDLRD\":193.801292,\"USDLSL\":14.79023,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.394973,\"USDMAD\":9.616297,\"USDMDL\":18.118007,\"USDMGA\":3650.000326,\"USDMKD\":54.350189,\"USDMMK\":1526.44987,\"USDMNT\":2658.688322,\"USDMOP\":8.067298,\"USDMRO\":356.999844,\"USDMUR\":35.549496,\"USDMVR\":15.45004,\"USDMWK\":745.36949,\"USDMXN\":19.141501,\"USDMYR\":4.15955,\"USDMZN\":62.219856,\"USDNAD\":14.789734,\"USDNGN\":359.999922,\"USDNIO\":33.394975,\"USDNOK\":8.631759,\"USDNPR\":111.064981,\"USDNZD\":1.51994,\"USDOMR\":0.385005,\"USDPAB\":0.9996,\"USDPEN\":3.334897,\"USDPGK\":3.375025,\"USDPHP\":51.925005,\"USDPKR\":151.909938,\"USDPLN\":3.770104,\"USDPYG\":6255.049782,\"USDQAR\":3.64096,\"USDRON\":4.173098,\"USDRSD\":104.250025,\"USDRUB\":64.493497,\"USDRWF\":906,\"USDSAR\":3.750301,\"USDSBD\":8.20555,\"USDSCR\":13.680031,\"USDSDG\":45.088497,\"USDSEK\":9.442603,\"USDSGD\":1.364235,\"USDSHP\":1.320901,\"USDSLL\":8874.999579,\"USDSOS\":584.999897,\"USDSRD\":7.458014,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":515.000462,\"USDSZL\":14.789532,\"USDTHB\":31.289942,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.942049,\"USDTOP\":2.28555,\"USDTRY\":5.82835,\"USDTTD\":6.77115,\"USDTWD\":31.3805,\"USDTZS\":2297.902571,\"USDUAH\":26.351,\"USDUGX\":3750.550061,\"USDUSD\":1,\"USDUYU\":35.420004,\"USDUZS\":8511.497588,\"USDVEF\":9.987496,\"USDVND\":23365,\"USDVUV\":115.640827,\"USDWST\":2.627769,\"USDXAF\":579.539812,\"USDXAG\":0.067914,\"USDXAU\":0.000755,\"USDXCD\":2.709802,\"USDXDR\":0.72155,\"USDXOF\":581.514716,\"USDXPF\":105.875016,\"USDYER\":250.349653,\"USDZAR\":14.67315,\"USDZMK\":9001.195844,\"USDZMW\":13.14505,\"USDZWL\":322.355011}}', 1, '2019-06-11 14:24:05', '2019-06-11 14:57:04', '2019-06-11 14:57:04', 'USD'),
(761, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560266344,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":79.450274,\"USDALL\":107.698083,\"USDAMD\":479.359705,\"USDANG\":1.87425,\"USDAOA\":338.983505,\"USDARS\":44.709301,\"USDAUD\":1.43832,\"USDAWG\":1.8,\"USDAZN\":1.705009,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.461502,\"USDBGN\":1.72865,\"USDBHD\":0.37708,\"USDBIF\":1860,\"USDBMD\":0.999975,\"USDBND\":1.350701,\"USDBOB\":6.907299,\"USDBRL\":3.86075,\"USDBSD\":0.9996,\"USDBTC\":0.000128,\"USDBTN\":69.415123,\"USDBWP\":10.853503,\"USDBYN\":2.068802,\"USDBYR\":19600,\"USDBZD\":2.014897,\"USDCAD\":1.32861,\"USDCDF\":1660.999793,\"USDCHF\":0.993015,\"USDCLF\":0.025127,\"USDCLP\":693.19768,\"USDCNY\":6.911402,\"USDCOP\":3247.2,\"USDCRC\":590.519822,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.9005,\"USDCZK\":22.637994,\"USDDJF\":177.720231,\"USDDKK\":6.601298,\"USDDOP\":51.034979,\"USDDZD\":119.115015,\"USDEGP\":16.750699,\"USDERN\":15.000261,\"USDETB\":29.060089,\"USDEUR\":0.883845,\"USDFJD\":2.146904,\"USDFKP\":0.787295,\"USDGBP\":0.786195,\"USDGEL\":2.729863,\"USDGGP\":0.786282,\"USDGHS\":5.395032,\"USDGIP\":0.78724,\"USDGMD\":49.744974,\"USDGNF\":9235.00008,\"USDGTQ\":7.697005,\"USDGYD\":208.694971,\"USDHKD\":7.83676,\"USDHNL\":25.249696,\"USDHRK\":6.555962,\"USDHTG\":92.369503,\"USDHUF\":283.756021,\"USDIDR\":14219,\"USDILS\":3.581503,\"USDIMP\":0.786282,\"USDINR\":69.422497,\"USDIQD\":1190,\"USDIRR\":42105.00039,\"USDISK\":124.37054,\"USDJEP\":0.786282,\"USDJMD\":130.170113,\"USDJOD\":0.710099,\"USDJPY\":108.56992,\"USDKES\":101.359713,\"USDKGS\":69.771097,\"USDKHR\":4075.000065,\"USDKMF\":435.375018,\"USDKPW\":900.063023,\"USDKRW\":1179.110166,\"USDKWD\":0.303795,\"USDKYD\":0.83296,\"USDKZT\":383.97045,\"USDLAK\":8649.999512,\"USDLBP\":1507.649955,\"USDLKR\":176.450032,\"USDLRD\":193.807696,\"USDLSL\":14.789842,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395019,\"USDMAD\":9.608501,\"USDMDL\":18.118028,\"USDMGA\":3650.000262,\"USDMKD\":54.365019,\"USDMMK\":1526.450638,\"USDMNT\":2658.466467,\"USDMOP\":8.067303,\"USDMRO\":356.999838,\"USDMUR\":35.553495,\"USDMVR\":15.450148,\"USDMWK\":745.485018,\"USDMXN\":19.119805,\"USDMYR\":4.159502,\"USDMZN\":62.22024,\"USDNAD\":14.790051,\"USDNGN\":360.00033,\"USDNIO\":33.394981,\"USDNOK\":8.63215,\"USDNPR\":111.065049,\"USDNZD\":1.52017,\"USDOMR\":0.385055,\"USDPAB\":0.9996,\"USDPEN\":3.33405,\"USDPGK\":3.375048,\"USDPHP\":51.950464,\"USDPKR\":151.910101,\"USDPLN\":3.76987,\"USDPYG\":6255.049966,\"USDQAR\":3.640969,\"USDRON\":4.173649,\"USDRSD\":104.29023,\"USDRUB\":64.546703,\"USDRWF\":906,\"USDSAR\":3.75045,\"USDSBD\":8.20555,\"USDSCR\":13.678505,\"USDSDG\":45.0885,\"USDSEK\":9.44244,\"USDSGD\":1.364235,\"USDSHP\":1.320899,\"USDSLL\":8874.99974,\"USDSOS\":585.000234,\"USDSRD\":7.457997,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":515.000312,\"USDSZL\":14.79027,\"USDTHB\":31.287497,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.95655,\"USDTOP\":2.28555,\"USDTRY\":5.829145,\"USDTTD\":6.77115,\"USDTWD\":31.385978,\"USDTZS\":2298.298566,\"USDUAH\":26.351012,\"USDUGX\":3750.549974,\"USDUSD\":1,\"USDUYU\":35.420461,\"USDUZS\":8511.4971,\"USDVEF\":9.987499,\"USDVND\":23365,\"USDVUV\":115.640067,\"USDWST\":2.631778,\"USDXAF\":579.540266,\"USDXAG\":0.06776,\"USDXAU\":0.000754,\"USDXCD\":2.7098,\"USDXDR\":0.72155,\"USDXOF\":581.508683,\"USDXPF\":105.874976,\"USDYER\":250.350285,\"USDZAR\":14.692001,\"USDZMK\":9001.20232,\"USDZMW\":13.145009,\"USDZWL\":322.355011}}', 1, '2019-06-11 15:19:04', '2019-06-11 15:57:05', '2019-06-11 15:57:05', 'USD'),
(762, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560269645,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673105,\"USDAFN\":79.450201,\"USDALL\":107.749636,\"USDAMD\":479.359905,\"USDANG\":1.87425,\"USDAOA\":338.983502,\"USDARS\":44.720102,\"USDAUD\":1.43764,\"USDAWG\":1.8,\"USDAZN\":1.705043,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.461024,\"USDBGN\":1.730302,\"USDBHD\":0.37701,\"USDBIF\":1860,\"USDBMD\":0.999975,\"USDBND\":1.35055,\"USDBOB\":6.90735,\"USDBRL\":3.858397,\"USDBSD\":0.99965,\"USDBTC\":0.000129,\"USDBTN\":69.418944,\"USDBWP\":10.853974,\"USDBYN\":2.068798,\"USDBYR\":19600,\"USDBZD\":2.014899,\"USDCAD\":1.330125,\"USDCDF\":1660.99994,\"USDCHF\":0.992495,\"USDCLF\":0.025112,\"USDCLP\":692.906089,\"USDCNY\":6.911401,\"USDCOP\":3246.7,\"USDCRC\":590.519501,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.900504,\"USDCZK\":22.629503,\"USDDJF\":177.720215,\"USDDKK\":6.597735,\"USDDOP\":51.024987,\"USDDZD\":119.120176,\"USDEGP\":16.738798,\"USDERN\":14.999636,\"USDETB\":29.059793,\"USDEUR\":0.88345,\"USDFJD\":2.1469,\"USDFKP\":0.78729,\"USDGBP\":0.7858,\"USDGEL\":2.730315,\"USDGGP\":0.785813,\"USDGHS\":5.394965,\"USDGIP\":0.78732,\"USDGMD\":49.744956,\"USDGNF\":9235.000228,\"USDGTQ\":7.697001,\"USDGYD\":208.695018,\"USDHKD\":7.837265,\"USDHNL\":25.250103,\"USDHRK\":6.550597,\"USDHTG\":92.369499,\"USDHUF\":283.801316,\"USDIDR\":14299,\"USDILS\":3.581497,\"USDIMP\":0.785813,\"USDINR\":69.4175,\"USDIQD\":1190,\"USDIRR\":42105.000158,\"USDISK\":124.302084,\"USDJEP\":0.785813,\"USDJMD\":130.169967,\"USDJOD\":0.710097,\"USDJPY\":108.507031,\"USDKES\":101.353502,\"USDKGS\":69.7711,\"USDKHR\":4075.000208,\"USDKMF\":435.375027,\"USDKPW\":900.058126,\"USDKRW\":1180.509874,\"USDKWD\":0.303898,\"USDKYD\":0.83296,\"USDKZT\":383.969952,\"USDLAK\":8650.000211,\"USDLBP\":1507.850304,\"USDLKR\":176.450469,\"USDLRD\":193.802513,\"USDLSL\":14.790025,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395016,\"USDMAD\":9.607977,\"USDMDL\":18.118009,\"USDMGA\":3650.000329,\"USDMKD\":54.366503,\"USDMMK\":1526.45043,\"USDMNT\":2658.669202,\"USDMOP\":8.0673,\"USDMRO\":357.000395,\"USDMUR\":35.552504,\"USDMVR\":15.449455,\"USDMWK\":745.389954,\"USDMXN\":19.130675,\"USDMYR\":4.153603,\"USDMZN\":62.220416,\"USDNAD\":14.404121,\"USDNGN\":359.999882,\"USDNIO\":33.395003,\"USDNOK\":8.634715,\"USDNPR\":111.065023,\"USDNZD\":1.51994,\"USDOMR\":0.385015,\"USDPAB\":0.99895,\"USDPEN\":3.333397,\"USDPGK\":3.3869,\"USDPHP\":51.954021,\"USDPKR\":151.902348,\"USDPLN\":3.766986,\"USDPYG\":6255.050195,\"USDQAR\":3.64125,\"USDRON\":4.170964,\"USDRSD\":104.290216,\"USDRUB\":64.52967,\"USDRWF\":906,\"USDSAR\":3.75095,\"USDSBD\":8.20555,\"USDSCR\":13.680498,\"USDSDG\":45.088502,\"USDSEK\":9.44332,\"USDSGD\":1.364135,\"USDSHP\":1.320895,\"USDSLL\":8875.000398,\"USDSOS\":584.999891,\"USDSRD\":7.457995,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":515.000472,\"USDSZL\":14.79019,\"USDTHB\":31.289003,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.95695,\"USDTOP\":2.28555,\"USDTRY\":5.81794,\"USDTTD\":6.771049,\"USDTWD\":31.392982,\"USDTZS\":2298.206283,\"USDUAH\":26.351021,\"USDUGX\":3750.550235,\"USDUSD\":1,\"USDUYU\":35.420042,\"USDUZS\":8511.50406,\"USDVEF\":9.987497,\"USDVND\":23365,\"USDVUV\":115.640945,\"USDWST\":2.637197,\"USDXAF\":579.539836,\"USDXAG\":0.0677,\"USDXAU\":0.000754,\"USDXCD\":2.70975,\"USDXDR\":0.721476,\"USDXOF\":581.498349,\"USDXPF\":105.874996,\"USDYER\":250.350338,\"USDZAR\":14.717598,\"USDZMK\":9001.203759,\"USDZMW\":13.144975,\"USDZWL\":322.355011}}', 1, '2019-06-11 16:14:05', '2019-06-11 16:57:04', '2019-06-11 16:57:04', 'USD'),
(763, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560272945,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672901,\"USDAFN\":79.450276,\"USDALL\":107.749822,\"USDAMD\":479.36008,\"USDANG\":1.87425,\"USDAOA\":338.983499,\"USDARS\":44.718904,\"USDAUD\":1.43695,\"USDAWG\":1.8,\"USDAZN\":1.704937,\"USDBAM\":1.72795,\"USDBBD\":1.9908,\"USDBDT\":84.46103,\"USDBGN\":1.738401,\"USDBHD\":0.377018,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.90735,\"USDBRL\":3.852024,\"USDBSD\":0.99965,\"USDBTC\":0.000127,\"USDBTN\":69.420504,\"USDBWP\":10.854023,\"USDBYN\":2.068797,\"USDBYR\":19600,\"USDBZD\":2.014898,\"USDCAD\":1.32941,\"USDCDF\":1660.999946,\"USDCHF\":0.991915,\"USDCLF\":0.025104,\"USDCLP\":692.795715,\"USDCNY\":6.911403,\"USDCOP\":3246.7,\"USDCRC\":590.519543,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.900503,\"USDCZK\":22.609802,\"USDDJF\":177.719468,\"USDDKK\":6.59267,\"USDDOP\":51.024986,\"USDDZD\":119.080236,\"USDEGP\":16.760016,\"USDERN\":15.000183,\"USDETB\":29.05984,\"USDEUR\":0.8828,\"USDFJD\":2.146902,\"USDFKP\":0.787295,\"USDGBP\":0.78591,\"USDGEL\":2.730186,\"USDGGP\":0.785835,\"USDGHS\":5.395012,\"USDGIP\":0.787295,\"USDGMD\":49.744994,\"USDGNF\":9235.000307,\"USDGTQ\":7.697023,\"USDGYD\":208.695042,\"USDHKD\":7.83695,\"USDHNL\":25.250461,\"USDHRK\":6.543597,\"USDHTG\":92.369504,\"USDHUF\":283.609957,\"USDIDR\":14223.5,\"USDILS\":3.581497,\"USDIMP\":0.785835,\"USDINR\":69.414989,\"USDIQD\":1190,\"USDIRR\":42105.000033,\"USDISK\":124.203861,\"USDJEP\":0.785835,\"USDJMD\":130.169964,\"USDJOD\":0.710102,\"USDJPY\":108.460958,\"USDKES\":101.359724,\"USDKGS\":69.771096,\"USDKHR\":4075.00032,\"USDKMF\":435.375002,\"USDKPW\":900.057403,\"USDKRW\":1180.089897,\"USDKWD\":0.303903,\"USDKYD\":0.83296,\"USDKZT\":383.970122,\"USDLAK\":8650.000272,\"USDLBP\":1507.850023,\"USDLKR\":176.450125,\"USDLRD\":193.800226,\"USDLSL\":14.789666,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39501,\"USDMAD\":9.6109,\"USDMDL\":18.117965,\"USDMGA\":3650.000366,\"USDMKD\":54.369,\"USDMMK\":1526.450004,\"USDMNT\":2658.86267,\"USDMOP\":8.067301,\"USDMRO\":356.999891,\"USDMUR\":35.560317,\"USDMVR\":15.450173,\"USDMWK\":745.404998,\"USDMXN\":19.105012,\"USDMYR\":4.1536,\"USDMZN\":62.22027,\"USDNAD\":14.400119,\"USDNGN\":359.999573,\"USDNIO\":33.394967,\"USDNOK\":8.627385,\"USDNPR\":111.065017,\"USDNZD\":1.51863,\"USDOMR\":0.385025,\"USDPAB\":0.99895,\"USDPEN\":3.33335,\"USDPGK\":3.386898,\"USDPHP\":51.954971,\"USDPKR\":151.902561,\"USDPLN\":3.76315,\"USDPYG\":6255.04948,\"USDQAR\":3.64125,\"USDRON\":4.167202,\"USDRSD\":104.205819,\"USDRUB\":64.5413,\"USDRWF\":906,\"USDSAR\":3.75085,\"USDSBD\":8.20555,\"USDSCR\":13.682006,\"USDSDG\":45.088504,\"USDSEK\":9.44203,\"USDSGD\":1.36363,\"USDSHP\":1.320898,\"USDSLL\":8874.999429,\"USDSOS\":585.000117,\"USDSRD\":7.45798,\"USDSTD\":21050.59961,\"USDSVC\":8.74665,\"USDSYP\":514.999726,\"USDSZL\":14.789634,\"USDTHB\":31.279968,\"USDTJS\":9.42605,\"USDTMT\":3.5,\"USDTND\":2.95695,\"USDTOP\":2.28555,\"USDTRY\":5.805225,\"USDTTD\":6.77105,\"USDTWD\":31.393047,\"USDTZS\":2298.000214,\"USDUAH\":26.351017,\"USDUGX\":3750.550285,\"USDUSD\":1,\"USDUYU\":35.419622,\"USDUZS\":8511.503622,\"USDVEF\":9.9875,\"USDVND\":23365,\"USDVUV\":115.639386,\"USDWST\":2.6323,\"USDXAF\":579.540363,\"USDXAG\":0.067671,\"USDXAU\":0.000753,\"USDXCD\":2.70255,\"USDXDR\":0.72145,\"USDXOF\":581.498985,\"USDXPF\":105.875047,\"USDYER\":250.34977,\"USDZAR\":14.69125,\"USDZMK\":9001.196955,\"USDZMW\":13.145005,\"USDZWL\":322.355011}}', 1, '2019-06-11 17:09:05', '2019-06-11 17:57:04', '2019-06-11 17:57:04', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(764, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560428044,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.033982,\"USDALL\":108.180399,\"USDAMD\":478.230046,\"USDANG\":1.87495,\"USDAOA\":338.983495,\"USDARS\":43.66399,\"USDAUD\":1.44715,\"USDAWG\":1.779375,\"USDAZN\":1.705022,\"USDBAM\":1.73265,\"USDBBD\":2.00155,\"USDBDT\":84.582009,\"USDBGN\":1.732501,\"USDBHD\":0.37685,\"USDBIF\":1836,\"USDBMD\":1,\"USDBND\":1.350502,\"USDBOB\":6.918349,\"USDBRL\":3.85055,\"USDBSD\":1.0012,\"USDBTC\":0.000123,\"USDBTN\":69.505321,\"USDBWP\":10.874024,\"USDBYN\":2.0694,\"USDBYR\":19600,\"USDBZD\":2.015597,\"USDCAD\":1.33046,\"USDCDF\":1659.999549,\"USDCHF\":0.992599,\"USDCLF\":0.025198,\"USDCLP\":695.290321,\"USDCNY\":6.922301,\"USDCOP\":3268.1,\"USDCRC\":586.749741,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.667497,\"USDCZK\":22.657499,\"USDDJF\":177.71988,\"USDDKK\":6.61497,\"USDDOP\":51.478014,\"USDDZD\":119.190245,\"USDEGP\":16.757979,\"USDERN\":14.999692,\"USDETB\":28.928496,\"USDEUR\":0.885795,\"USDFJD\":2.152903,\"USDFKP\":0.78761,\"USDGBP\":0.78775,\"USDGEL\":2.72009,\"USDGGP\":0.788058,\"USDGHS\":5.379994,\"USDGIP\":0.78761,\"USDGMD\":49.78497,\"USDGNF\":9135.211502,\"USDGTQ\":7.684702,\"USDGYD\":209.210262,\"USDHKD\":7.82825,\"USDHNL\":24.477989,\"USDHRK\":6.566702,\"USDHTG\":92.436503,\"USDHUF\":285.334992,\"USDIDR\":14284.75,\"USDILS\":3.5903,\"USDIMP\":0.788058,\"USDINR\":69.508498,\"USDIQD\":1193.15,\"USDIRR\":42104.999872,\"USDISK\":125.33971,\"USDJEP\":0.788058,\"USDJMD\":129.705011,\"USDJOD\":0.708989,\"USDJPY\":108.450967,\"USDKES\":101.660153,\"USDKGS\":69.8466,\"USDKHR\":4077.349949,\"USDKMF\":435.225039,\"USDKPW\":900.062761,\"USDKRW\":1183.150121,\"USDKWD\":0.303898,\"USDKYD\":0.83338,\"USDKZT\":385.270051,\"USDLAK\":8712.549786,\"USDLBP\":1511.796504,\"USDLKR\":176.610016,\"USDLRD\":193.999833,\"USDLSL\":14.669713,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39285,\"USDMAD\":9.619498,\"USDMDL\":18.1895,\"USDMGA\":3651.395771,\"USDMKD\":54.499915,\"USDMMK\":1526.60124,\"USDMNT\":2659.318918,\"USDMOP\":8.06295,\"USDMRO\":357.000026,\"USDMUR\":35.498831,\"USDMVR\":15.449874,\"USDMWK\":745.365037,\"USDMXN\":19.17324,\"USDMYR\":4.169399,\"USDMZN\":62.119739,\"USDNAD\":14.395873,\"USDNGN\":360.000171,\"USDNIO\":32.958936,\"USDNOK\":8.65659,\"USDNPR\":111.254982,\"USDNZD\":1.523899,\"USDOMR\":0.38502,\"USDPAB\":1.0012,\"USDPEN\":3.339101,\"USDPGK\":3.37485,\"USDPHP\":51.867983,\"USDPKR\":153.125042,\"USDPLN\":3.77145,\"USDPYG\":6250.849857,\"USDQAR\":3.64125,\"USDRON\":4.183197,\"USDRSD\":104.459782,\"USDRUB\":64.611502,\"USDRWF\":909.57,\"USDSAR\":3.74995,\"USDSBD\":8.24175,\"USDSCR\":13.682044,\"USDSDG\":45.111028,\"USDSEK\":9.47678,\"USDSGD\":1.366245,\"USDSHP\":1.320896,\"USDSLL\":8899.999765,\"USDSOS\":582.999908,\"USDSRD\":7.457964,\"USDSTD\":21050.59961,\"USDSVC\":8.750203,\"USDSYP\":514.999891,\"USDSZL\":14.835496,\"USDTHB\":31.227499,\"USDTJS\":9.42955,\"USDTMT\":3.5,\"USDTND\":2.94865,\"USDTOP\":2.290804,\"USDTRY\":5.877565,\"USDTTD\":6.78955,\"USDTWD\":31.472499,\"USDTZS\":2299.850118,\"USDUAH\":26.460117,\"USDUGX\":3744.850164,\"USDUSD\":1,\"USDUYU\":35.369655,\"USDUZS\":8515.749605,\"USDVEF\":9.987504,\"USDVND\":23313.4,\"USDVUV\":115.931475,\"USDWST\":2.635727,\"USDXAF\":581.159635,\"USDXAG\":0.067479,\"USDXAU\":0.000748,\"USDXCD\":2.70255,\"USDXDR\":0.7224,\"USDXOF\":581.130233,\"USDXPF\":105.630106,\"USDYER\":250.392558,\"USDZAR\":14.86755,\"USDZMK\":9001.204112,\"USDZMW\":13.101507,\"USDZWL\":322.355011}}', 1, '2019-06-13 12:14:04', '2019-06-13 12:27:01', '2019-06-13 12:27:01', 'USD'),
(765, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560431344,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673251,\"USDAFN\":79.549955,\"USDALL\":108.229807,\"USDAMD\":478.540204,\"USDANG\":1.87495,\"USDAOA\":338.983501,\"USDARS\":43.474297,\"USDAUD\":1.446395,\"USDAWG\":1.8,\"USDAZN\":1.705021,\"USDBAM\":1.73265,\"USDBBD\":2.00155,\"USDBDT\":84.582029,\"USDBGN\":1.73385,\"USDBHD\":0.37695,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91835,\"USDBRL\":3.83735,\"USDBSD\":1.0012,\"USDBTC\":0.000123,\"USDBTN\":69.540333,\"USDBWP\":10.873988,\"USDBYN\":2.069402,\"USDBYR\":19600,\"USDBZD\":2.015602,\"USDCAD\":1.33164,\"USDCDF\":1661.000487,\"USDCHF\":0.993115,\"USDCLF\":0.025177,\"USDCLP\":694.711333,\"USDCNY\":6.922497,\"USDCOP\":3267.5,\"USDCRC\":586.750017,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.875499,\"USDCZK\":22.6649,\"USDDJF\":177.71974,\"USDDKK\":6.618397,\"USDDOP\":51.08498,\"USDDZD\":119.265018,\"USDEGP\":16.750184,\"USDERN\":14.999956,\"USDETB\":29.120037,\"USDEUR\":0.886225,\"USDFJD\":2.15385,\"USDFKP\":0.787585,\"USDGBP\":0.787575,\"USDGEL\":2.719904,\"USDGGP\":0.787647,\"USDGHS\":5.379664,\"USDGIP\":0.78757,\"USDGMD\":49.764974,\"USDGNF\":9235.000306,\"USDGTQ\":7.684696,\"USDGYD\":209.210254,\"USDHKD\":7.82806,\"USDHNL\":24.649807,\"USDHRK\":6.571101,\"USDHTG\":92.436502,\"USDHUF\":285.380229,\"USDIDR\":14298,\"USDILS\":3.593497,\"USDIMP\":0.787647,\"USDINR\":69.544013,\"USDIQD\":1190,\"USDIRR\":42104.999869,\"USDISK\":125.409758,\"USDJEP\":0.787647,\"USDJMD\":129.705014,\"USDJOD\":0.708951,\"USDJPY\":108.482502,\"USDKES\":101.5804,\"USDKGS\":69.8466,\"USDKHR\":4070.999694,\"USDKMF\":435.225032,\"USDKPW\":900.058719,\"USDKRW\":1183.289966,\"USDKWD\":0.303798,\"USDKYD\":0.83338,\"USDKZT\":385.269799,\"USDLAK\":8652.497294,\"USDLBP\":1508.050265,\"USDLKR\":176.609444,\"USDLRD\":194.000197,\"USDLSL\":14.840119,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395003,\"USDMAD\":9.622899,\"USDMDL\":18.189499,\"USDMGA\":3625.000292,\"USDMKD\":54.544948,\"USDMMK\":1526.595264,\"USDMNT\":2659.280102,\"USDMOP\":8.06295,\"USDMRO\":357.000289,\"USDMUR\":35.540233,\"USDMVR\":15.449783,\"USDMWK\":745.375025,\"USDMXN\":19.188802,\"USDMYR\":4.157497,\"USDMZN\":62.119955,\"USDNAD\":14.840108,\"USDNGN\":359.999789,\"USDNIO\":33.374981,\"USDNOK\":8.6593,\"USDNPR\":111.254976,\"USDNZD\":1.524139,\"USDOMR\":0.38504,\"USDPAB\":1.0012,\"USDPEN\":3.33635,\"USDPGK\":3.380442,\"USDPHP\":51.927502,\"USDPKR\":153.125003,\"USDPLN\":3.772401,\"USDPYG\":6250.849802,\"USDQAR\":3.64125,\"USDRON\":4.184028,\"USDRSD\":104.519835,\"USDRUB\":64.591006,\"USDRWF\":905,\"USDSAR\":3.750402,\"USDSBD\":8.24175,\"USDSCR\":13.681498,\"USDSDG\":45.110967,\"USDSEK\":9.48073,\"USDSGD\":1.36644,\"USDSHP\":1.320903,\"USDSLL\":8900.000087,\"USDSOS\":583.000246,\"USDSRD\":7.458037,\"USDSTD\":21050.59961,\"USDSVC\":8.750201,\"USDSYP\":514.999961,\"USDSZL\":14.84021,\"USDTHB\":31.199729,\"USDTJS\":9.42955,\"USDTMT\":3.5,\"USDTND\":2.95025,\"USDTOP\":2.290803,\"USDTRY\":5.884295,\"USDTTD\":6.78955,\"USDTWD\":31.480504,\"USDTZS\":2300.000263,\"USDUAH\":26.460395,\"USDUGX\":3744.849758,\"USDUSD\":1,\"USDUYU\":35.370348,\"USDUZS\":8520.000037,\"USDVEF\":9.987501,\"USDVND\":23313.4,\"USDVUV\":115.93006,\"USDWST\":2.636114,\"USDXAF\":581.160079,\"USDXAG\":0.067595,\"USDXAU\":0.000749,\"USDXCD\":2.70255,\"USDXDR\":0.722286,\"USDXOF\":581.502114,\"USDXPF\":105.924984,\"USDYER\":250.400902,\"USDZAR\":14.864297,\"USDZMK\":9001.201827,\"USDZMW\":13.098032,\"USDZWL\":322.355011}}', 1, '2019-06-13 13:09:04', '2019-06-13 13:26:55', '2019-06-13 13:26:55', 'USD'),
(766, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560434645,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.549744,\"USDALL\":108.095576,\"USDAMD\":478.539625,\"USDANG\":1.87495,\"USDAOA\":338.983497,\"USDARS\":43.66303,\"USDAUD\":1.44615,\"USDAWG\":1.8,\"USDAZN\":1.705029,\"USDBAM\":1.73265,\"USDBBD\":2.00155,\"USDBDT\":84.582007,\"USDBGN\":1.7346,\"USDBHD\":0.37701,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91835,\"USDBRL\":3.840498,\"USDBSD\":1.0012,\"USDBTC\":0.000123,\"USDBTN\":69.541167,\"USDBWP\":10.874012,\"USDBYN\":2.0694,\"USDBYR\":19600,\"USDBZD\":2.015599,\"USDCAD\":1.33205,\"USDCDF\":1661.000154,\"USDCHF\":0.993545,\"USDCLF\":0.025206,\"USDCLP\":695.455027,\"USDCNY\":6.922402,\"USDCOP\":3267.5,\"USDCRC\":586.750283,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.041497,\"USDCZK\":22.674701,\"USDDJF\":177.720198,\"USDDKK\":6.62118,\"USDDOP\":51.124962,\"USDDZD\":119.289687,\"USDEGP\":16.776972,\"USDERN\":15.000293,\"USDETB\":29.119951,\"USDEUR\":0.886629,\"USDFJD\":2.15385,\"USDFKP\":0.787602,\"USDGBP\":0.78775,\"USDGEL\":2.720141,\"USDGGP\":0.787883,\"USDGHS\":5.424997,\"USDGIP\":0.787595,\"USDGMD\":49.78496,\"USDGNF\":9240.000462,\"USDGTQ\":7.684704,\"USDGYD\":209.209686,\"USDHKD\":7.828598,\"USDHNL\":24.649759,\"USDHRK\":6.573697,\"USDHTG\":92.4365,\"USDHUF\":285.449577,\"USDIDR\":14295,\"USDILS\":3.596399,\"USDIMP\":0.787883,\"USDINR\":69.548501,\"USDIQD\":1190,\"USDIRR\":42104.999966,\"USDISK\":125.502883,\"USDJEP\":0.787883,\"USDJMD\":129.70502,\"USDJOD\":0.709007,\"USDJPY\":108.474028,\"USDKES\":101.640274,\"USDKGS\":69.846603,\"USDKHR\":4069.999696,\"USDKMF\":436.749916,\"USDKPW\":900.057916,\"USDKRW\":1182.606691,\"USDKWD\":0.3039,\"USDKYD\":0.83338,\"USDKZT\":385.269975,\"USDLAK\":8654.495264,\"USDLBP\":1507.750162,\"USDLKR\":176.609484,\"USDLRD\":194.000187,\"USDLSL\":14.889951,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.402223,\"USDMAD\":9.629397,\"USDMDL\":18.189501,\"USDMGA\":3625.000274,\"USDMKD\":54.530968,\"USDMMK\":1526.596085,\"USDMNT\":2659.651878,\"USDMOP\":8.06295,\"USDMRO\":357.000251,\"USDMUR\":35.53971,\"USDMVR\":15.450103,\"USDMWK\":745.339593,\"USDMXN\":19.15645,\"USDMYR\":4.168599,\"USDMZN\":62.120453,\"USDNAD\":14.889945,\"USDNGN\":360.000039,\"USDNIO\":33.375003,\"USDNOK\":8.66643,\"USDNPR\":111.255016,\"USDNZD\":1.523027,\"USDOMR\":0.38501,\"USDPAB\":1.0012,\"USDPEN\":3.33625,\"USDPGK\":3.379662,\"USDPHP\":51.933963,\"USDPKR\":151.59681,\"USDPLN\":3.77535,\"USDPYG\":6250.850045,\"USDQAR\":3.641005,\"USDRON\":4.18644,\"USDRSD\":104.559785,\"USDRUB\":64.577991,\"USDRWF\":907.5,\"USDSAR\":3.75045,\"USDSBD\":8.24175,\"USDSCR\":13.685984,\"USDSDG\":45.11102,\"USDSEK\":9.48653,\"USDSGD\":1.366635,\"USDSHP\":1.320902,\"USDSLL\":8910.000278,\"USDSOS\":582.48613,\"USDSRD\":7.45794,\"USDSTD\":21050.59961,\"USDSVC\":8.7502,\"USDSYP\":515.000324,\"USDSZL\":14.890105,\"USDTHB\":31.201503,\"USDTJS\":9.42955,\"USDTMT\":3.51,\"USDTND\":2.95175,\"USDTOP\":2.290802,\"USDTRY\":5.874497,\"USDTTD\":6.78955,\"USDTWD\":31.483497,\"USDTZS\":2299.826049,\"USDUAH\":26.460056,\"USDUGX\":3744.849914,\"USDUSD\":1,\"USDUYU\":35.369744,\"USDUZS\":8519.999972,\"USDVEF\":9.987498,\"USDVND\":23313.4,\"USDVUV\":115.931317,\"USDWST\":2.635728,\"USDXAF\":581.16015,\"USDXAG\":0.067467,\"USDXAU\":0.000748,\"USDXCD\":2.70255,\"USDXDR\":0.72245,\"USDXOF\":581.504736,\"USDXPF\":106.250286,\"USDYER\":250.349622,\"USDZAR\":14.876017,\"USDZMK\":9001.205703,\"USDZMW\":13.09797,\"USDZWL\":322.355011}}', 1, '2019-06-13 14:04:05', '2019-06-13 14:26:55', '2019-06-13 14:26:55', 'USD'),
(767, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560500645,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.092498,\"USDALL\":108.101522,\"USDAMD\":478.599323,\"USDANG\":1.87635,\"USDAOA\":338.983495,\"USDARS\":43.51399,\"USDAUD\":1.44982,\"USDAWG\":1.78,\"USDAZN\":1.704992,\"USDBAM\":1.734018,\"USDBBD\":2.003,\"USDBDT\":84.556018,\"USDBGN\":1.733203,\"USDBHD\":0.37695,\"USDBIF\":1837.3,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91495,\"USDBRL\":3.849399,\"USDBSD\":1.00055,\"USDBTC\":0.000121,\"USDBTN\":69.623531,\"USDBWP\":10.883962,\"USDBYN\":2.07095,\"USDBYR\":19600,\"USDBZD\":2.0171,\"USDCAD\":1.33404,\"USDCDF\":1659.999411,\"USDCHF\":0.994045,\"USDCLF\":0.025233,\"USDCLP\":696.200358,\"USDCNY\":6.923701,\"USDCOP\":3268.5,\"USDCRC\":587.179982,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.7635,\"USDCZK\":22.645896,\"USDDJF\":177.720276,\"USDDKK\":6.617497,\"USDDOP\":51.525009,\"USDDZD\":119.230341,\"USDEGP\":16.762985,\"USDERN\":14.99994,\"USDETB\":28.950107,\"USDEUR\":0.886197,\"USDFJD\":2.15895,\"USDFKP\":0.789105,\"USDGBP\":0.78964,\"USDGEL\":2.73501,\"USDGGP\":0.789554,\"USDGHS\":5.383901,\"USDGIP\":0.789125,\"USDGMD\":49.805262,\"USDGNF\":9141.896565,\"USDGTQ\":7.690501,\"USDGYD\":209.364988,\"USDHKD\":7.824965,\"USDHNL\":24.495503,\"USDHRK\":6.566899,\"USDHTG\":92.504497,\"USDHUF\":285.309856,\"USDIDR\":14338,\"USDILS\":3.59921,\"USDIMP\":0.789554,\"USDINR\":69.624996,\"USDIQD\":1194,\"USDIRR\":42104.999792,\"USDISK\":125.379519,\"USDJEP\":0.789554,\"USDJMD\":129.79714,\"USDJOD\":0.709019,\"USDJPY\":108.202941,\"USDKES\":101.689872,\"USDKGS\":69.846598,\"USDKHR\":4081.297502,\"USDKMF\":436.62498,\"USDKPW\":900.061199,\"USDKRW\":1185.359543,\"USDKWD\":0.303701,\"USDKYD\":0.83399,\"USDKZT\":384.439973,\"USDLAK\":8721.049981,\"USDLBP\":1511.250006,\"USDLKR\":176.759984,\"USDLRD\":194.125044,\"USDLSL\":14.860275,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.393898,\"USDMAD\":9.61935,\"USDMDL\":18.202958,\"USDMGA\":3654.049619,\"USDMKD\":54.549497,\"USDMMK\":1528.111164,\"USDMNT\":2659.024747,\"USDMOP\":8.068702,\"USDMRO\":356.999843,\"USDMUR\":35.580372,\"USDMVR\":15.449787,\"USDMWK\":745.415031,\"USDMXN\":19.222465,\"USDMYR\":4.168498,\"USDMZN\":62.120098,\"USDNAD\":14.860134,\"USDNGN\":360.000011,\"USDNIO\":32.983001,\"USDNOK\":8.66815,\"USDNPR\":111.359995,\"USDNZD\":1.52905,\"USDOMR\":0.38502,\"USDPAB\":1.00065,\"USDPEN\":3.33575,\"USDPGK\":3.377198,\"USDPHP\":52.040141,\"USDPKR\":153.125019,\"USDPLN\":3.77075,\"USDPYG\":6255.449565,\"USDQAR\":3.64125,\"USDRON\":4.184398,\"USDRSD\":104.449917,\"USDRUB\":64.430599,\"USDRWF\":910.235,\"USDSAR\":3.75115,\"USDSBD\":8.22815,\"USDSCR\":13.671986,\"USDSDG\":45.14397,\"USDSEK\":9.432665,\"USDSGD\":1.367255,\"USDSHP\":1.320898,\"USDSLL\":8914.999741,\"USDSOS\":583.999593,\"USDSRD\":7.457999,\"USDSTD\":21050.59961,\"USDSVC\":8.756604,\"USDSYP\":514.999717,\"USDSZL\":14.846495,\"USDTHB\":31.165496,\"USDTJS\":9.436598,\"USDTMT\":3.5,\"USDTND\":2.955599,\"USDTOP\":2.29235,\"USDTRY\":5.916198,\"USDTTD\":6.78545,\"USDTWD\":31.503502,\"USDTZS\":2298.050179,\"USDUAH\":26.480335,\"USDUGX\":3747.698421,\"USDUSD\":1,\"USDUYU\":35.390297,\"USDUZS\":8522.349757,\"USDVEF\":9.987503,\"USDVND\":23327.5,\"USDVUV\":115.96439,\"USDWST\":2.639339,\"USDXAF\":581.549666,\"USDXAG\":0.066509,\"USDXAU\":0.000738,\"USDXCD\":2.70255,\"USDXDR\":0.72225,\"USDXOF\":581.549707,\"USDXPF\":105.729474,\"USDYER\":250.349627,\"USDZAR\":14.84006,\"USDZMK\":9001.194249,\"USDZMW\":13.109025,\"USDZWL\":322.355011}}', 1, '2019-06-14 08:24:05', '2019-06-14 08:47:58', '2019-06-14 08:47:58', 'USD'),
(768, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560517144,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":79.650223,\"USDALL\":108.49969,\"USDAMD\":478.397717,\"USDANG\":1.876497,\"USDAOA\":338.983499,\"USDARS\":43.514975,\"USDAUD\":1.452255,\"USDAWG\":1.801,\"USDAZN\":1.705032,\"USDBAM\":1.737598,\"USDBBD\":2.00315,\"USDBDT\":84.600974,\"USDBGN\":1.74055,\"USDBHD\":0.37695,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.3506,\"USDBOB\":6.91535,\"USDBRL\":3.875098,\"USDBSD\":1.00075,\"USDBTC\":0.00012,\"USDBTN\":69.782579,\"USDBWP\":10.884495,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.017196,\"USDCAD\":1.33483,\"USDCDF\":1660.999772,\"USDCHF\":0.997705,\"USDCLF\":0.025289,\"USDCLP\":697.904941,\"USDCNY\":6.923798,\"USDCOP\":3267.5,\"USDCRC\":586.225018,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.499501,\"USDCZK\":22.720596,\"USDDJF\":177.719811,\"USDDKK\":6.645196,\"USDDOP\":51.560247,\"USDDZD\":119.310048,\"USDEGP\":16.763018,\"USDERN\":14.999994,\"USDETB\":29.103195,\"USDEUR\":0.889925,\"USDFJD\":2.15595,\"USDFKP\":0.7911,\"USDGBP\":0.79216,\"USDGEL\":2.735036,\"USDGGP\":0.791992,\"USDGHS\":5.414973,\"USDGIP\":0.79111,\"USDGMD\":49.798113,\"USDGNF\":9235.000427,\"USDGTQ\":7.691061,\"USDGYD\":208.94498,\"USDHKD\":7.82785,\"USDHNL\":24.689897,\"USDHRK\":6.595602,\"USDHTG\":92.851996,\"USDHUF\":286.184013,\"USDIDR\":14322,\"USDILS\":3.59825,\"USDIMP\":0.791992,\"USDINR\":69.772502,\"USDIQD\":1190,\"USDIRR\":42105.000135,\"USDISK\":125.909996,\"USDJEP\":0.791992,\"USDJMD\":129.749479,\"USDJOD\":0.708976,\"USDJPY\":108.442499,\"USDKES\":101.91004,\"USDKGS\":69.850313,\"USDKHR\":4068.000073,\"USDKMF\":436.62498,\"USDKPW\":900.066356,\"USDKRW\":1185.000217,\"USDKWD\":0.304102,\"USDKYD\":0.83398,\"USDKZT\":384.279723,\"USDLAK\":8654.999813,\"USDLBP\":1507.949838,\"USDLKR\":176.710014,\"USDLRD\":194.125048,\"USDLSL\":14.859856,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39847,\"USDMAD\":9.65115,\"USDMDL\":18.214497,\"USDMGA\":3651.350122,\"USDMKD\":54.549004,\"USDMMK\":1527.150034,\"USDMNT\":2659.872412,\"USDMOP\":8.068901,\"USDMRO\":357.000233,\"USDMUR\":35.770469,\"USDMVR\":15.450247,\"USDMWK\":745.429843,\"USDMXN\":19.191203,\"USDMYR\":4.170499,\"USDMZN\":62.020045,\"USDNAD\":14.860258,\"USDNGN\":360.000119,\"USDNIO\":32.985501,\"USDNOK\":8.69777,\"USDNPR\":111.720223,\"USDNZD\":1.535597,\"USDOMR\":0.385005,\"USDPAB\":1.0007,\"USDPEN\":3.33495,\"USDPGK\":3.382251,\"USDPHP\":52.029501,\"USDPKR\":155.999843,\"USDPLN\":3.78665,\"USDPYG\":6247.291881,\"USDQAR\":3.640966,\"USDRON\":4.203301,\"USDRSD\":105.01017,\"USDRUB\":64.324497,\"USDRWF\":905,\"USDSAR\":3.75085,\"USDSBD\":8.22815,\"USDSCR\":13.659008,\"USDSDG\":45.146502,\"USDSEK\":9.46625,\"USDSGD\":1.36917,\"USDSHP\":1.3209,\"USDSLL\":8914.999966,\"USDSOS\":584.000284,\"USDSRD\":7.457991,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":514.999919,\"USDSZL\":14.859677,\"USDTHB\":31.191986,\"USDTJS\":9.44215,\"USDTMT\":3.5,\"USDTND\":2.95685,\"USDTOP\":2.29235,\"USDTRY\":5.893275,\"USDTTD\":6.78605,\"USDTWD\":31.50599,\"USDTZS\":2298.599929,\"USDUAH\":26.468008,\"USDUGX\":3747.901538,\"USDUSD\":1,\"USDUYU\":35.340493,\"USDUZS\":8514.999748,\"USDVEF\":9.987501,\"USDVND\":23325,\"USDVUV\":116.061569,\"USDWST\":2.636423,\"USDXAF\":582.789682,\"USDXAG\":0.066627,\"USDXAU\":0.000741,\"USDXCD\":2.70255,\"USDXDR\":0.72285,\"USDXOF\":579.502227,\"USDXPF\":106.196556,\"USDYER\":250.349988,\"USDZAR\":14.80775,\"USDZMK\":9001.196375,\"USDZMW\":13.086009,\"USDZWL\":322.355011}}', 1, '2019-06-14 12:59:04', '2019-06-14 13:09:27', '2019-06-14 13:09:27', 'USD'),
(769, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560520444,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.650052,\"USDALL\":108.349692,\"USDAMD\":478.402571,\"USDANG\":1.876498,\"USDAOA\":338.983498,\"USDARS\":43.733989,\"USDAUD\":1.45265,\"USDAWG\":1.801,\"USDAZN\":1.705003,\"USDBAM\":1.737602,\"USDBBD\":2.00315,\"USDBDT\":84.601043,\"USDBGN\":1.740104,\"USDBHD\":0.37699,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35085,\"USDBOB\":6.91535,\"USDBRL\":3.88075,\"USDBSD\":1.00075,\"USDBTC\":0.000118,\"USDBTN\":69.716639,\"USDBWP\":10.884498,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.017199,\"USDCAD\":1.336995,\"USDCDF\":1660.999887,\"USDCHF\":0.99665,\"USDCLF\":0.025293,\"USDCLP\":697.879869,\"USDCNY\":6.923897,\"USDCOP\":3276.7,\"USDCRC\":586.224969,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.4995,\"USDCZK\":22.711961,\"USDDJF\":177.72004,\"USDDKK\":6.64258,\"USDDOP\":51.154972,\"USDDZD\":119.430057,\"USDEGP\":16.756977,\"USDERN\":15.000266,\"USDETB\":29.100451,\"USDEUR\":0.88953,\"USDFJD\":2.15595,\"USDFKP\":0.791115,\"USDGBP\":0.792305,\"USDGEL\":2.735017,\"USDGGP\":0.792216,\"USDGHS\":5.394249,\"USDGIP\":0.79111,\"USDGMD\":49.765005,\"USDGNF\":9224.999403,\"USDGTQ\":7.690983,\"USDGYD\":208.944992,\"USDHKD\":7.82715,\"USDHNL\":24.689946,\"USDHRK\":6.592036,\"USDHTG\":92.851988,\"USDHUF\":286.324942,\"USDIDR\":14331,\"USDILS\":3.59716,\"USDIMP\":0.792216,\"USDINR\":69.69026,\"USDIQD\":1190,\"USDIRR\":42105.000073,\"USDISK\":125.880237,\"USDJEP\":0.792216,\"USDJMD\":129.750137,\"USDJOD\":0.708962,\"USDJPY\":108.385999,\"USDKES\":101.900507,\"USDKGS\":69.850283,\"USDKHR\":4064.999835,\"USDKMF\":438.250228,\"USDKPW\":900.064829,\"USDKRW\":1184.449572,\"USDKWD\":0.303976,\"USDKYD\":0.83398,\"USDKZT\":384.280117,\"USDLAK\":8654.999857,\"USDLBP\":1508.050173,\"USDLKR\":176.710169,\"USDLRD\":194.000173,\"USDLSL\":14.810069,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.450744,\"USDMAD\":9.65025,\"USDMDL\":18.2145,\"USDMGA\":3651.349759,\"USDMKD\":54.544502,\"USDMMK\":1527.15012,\"USDMNT\":2659.800298,\"USDMOP\":8.068899,\"USDMRO\":357.00025,\"USDMUR\":35.770496,\"USDMVR\":15.449474,\"USDMWK\":745.554981,\"USDMXN\":19.15138,\"USDMYR\":4.168496,\"USDMZN\":62.02022,\"USDNAD\":14.810191,\"USDNGN\":359.999973,\"USDNIO\":32.985502,\"USDNOK\":8.69905,\"USDNPR\":111.720193,\"USDNZD\":1.534699,\"USDOMR\":0.384985,\"USDPAB\":1.0007,\"USDPEN\":3.33475,\"USDPGK\":3.38225,\"USDPHP\":52.001502,\"USDPKR\":156.0004,\"USDPLN\":3.78565,\"USDPYG\":6247.298678,\"USDQAR\":3.641015,\"USDRON\":4.20135,\"USDRSD\":104.830372,\"USDRUB\":64.307994,\"USDRWF\":906,\"USDSAR\":3.75055,\"USDSBD\":8.22815,\"USDSCR\":13.659501,\"USDSDG\":45.146494,\"USDSEK\":9.46704,\"USDSGD\":1.369575,\"USDSHP\":1.320903,\"USDSLL\":8919.999749,\"USDSOS\":582.503061,\"USDSRD\":7.457951,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":515.000395,\"USDSZL\":14.810092,\"USDTHB\":31.202499,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.95765,\"USDTOP\":2.29235,\"USDTRY\":5.889675,\"USDTTD\":6.78605,\"USDTWD\":31.483992,\"USDTZS\":2299.098421,\"USDUAH\":26.467975,\"USDUGX\":3747.892106,\"USDUSD\":1,\"USDUYU\":35.339895,\"USDUZS\":8514.99976,\"USDVEF\":9.987501,\"USDVND\":23335,\"USDVUV\":116.013176,\"USDWST\":2.636426,\"USDXAF\":582.790305,\"USDXAG\":0.066754,\"USDXAU\":0.00074,\"USDXCD\":2.70255,\"USDXDR\":0.723649,\"USDXOF\":579.503383,\"USDXPF\":106.592332,\"USDYER\":250.303227,\"USDZAR\":14.786996,\"USDZMK\":9001.199504,\"USDZMW\":13.086023,\"USDZWL\":322.355011}}', 1, '2019-06-14 13:54:04', '2019-06-14 14:09:16', '2019-06-14 14:09:16', 'USD'),
(770, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560523744,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":79.650273,\"USDALL\":108.630371,\"USDAMD\":478.397705,\"USDANG\":1.876497,\"USDAOA\":338.983503,\"USDARS\":43.813977,\"USDAUD\":1.454455,\"USDAWG\":1.801,\"USDAZN\":1.705005,\"USDBAM\":1.7376,\"USDBBD\":2.00315,\"USDBDT\":84.601026,\"USDBGN\":1.74175,\"USDBHD\":0.37697,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.350651,\"USDBOB\":6.91535,\"USDBRL\":3.88375,\"USDBSD\":1.00075,\"USDBTC\":0.000119,\"USDBTN\":69.782181,\"USDBWP\":10.884499,\"USDBYN\":2.065449,\"USDBYR\":19600,\"USDBZD\":2.017203,\"USDCAD\":1.33734,\"USDCDF\":1660.999894,\"USDCHF\":0.997415,\"USDCLF\":0.025309,\"USDCLP\":698.398562,\"USDCNY\":6.924196,\"USDCOP\":3270.6,\"USDCRC\":586.224955,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.499498,\"USDCZK\":22.738969,\"USDDJF\":177.720014,\"USDDKK\":6.64969,\"USDDOP\":51.154979,\"USDDZD\":119.455023,\"USDEGP\":16.764501,\"USDERN\":14.99979,\"USDETB\":29.09913,\"USDEUR\":0.89049,\"USDFJD\":2.15595,\"USDFKP\":0.79111,\"USDGBP\":0.79325,\"USDGEL\":2.734979,\"USDGGP\":0.793084,\"USDGHS\":5.399053,\"USDGIP\":0.79108,\"USDGMD\":49.765015,\"USDGNF\":9225.000297,\"USDGTQ\":7.690983,\"USDGYD\":208.944997,\"USDHKD\":7.8271,\"USDHNL\":24.690107,\"USDHRK\":6.592803,\"USDHTG\":92.852024,\"USDHUF\":286.842007,\"USDIDR\":14340,\"USDILS\":3.598034,\"USDIMP\":0.793084,\"USDINR\":69.760094,\"USDIQD\":1190,\"USDIRR\":42104.999888,\"USDISK\":126.020312,\"USDJEP\":0.793084,\"USDJMD\":129.750231,\"USDJOD\":0.708971,\"USDJPY\":108.429979,\"USDKES\":101.860145,\"USDKGS\":69.850191,\"USDKHR\":4064.999991,\"USDKMF\":438.249949,\"USDKPW\":900.071011,\"USDKRW\":1186.185024,\"USDKWD\":0.304099,\"USDKYD\":0.83398,\"USDKZT\":384.280006,\"USDLAK\":8655.000014,\"USDLBP\":1515.750259,\"USDLKR\":176.710305,\"USDLRD\":193.999865,\"USDLSL\":14.809941,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.396354,\"USDMAD\":9.65495,\"USDMDL\":18.214503,\"USDMGA\":3651.350332,\"USDMKD\":54.551971,\"USDMMK\":1527.149675,\"USDMNT\":2659.905785,\"USDMOP\":8.068901,\"USDMRO\":356.999867,\"USDMUR\":35.7735,\"USDMVR\":15.450276,\"USDMWK\":745.464989,\"USDMXN\":19.14325,\"USDMYR\":4.166803,\"USDMZN\":62.02009,\"USDNAD\":14.809693,\"USDNGN\":360.000212,\"USDNIO\":32.985498,\"USDNOK\":8.70293,\"USDNPR\":111.720274,\"USDNZD\":1.537301,\"USDOMR\":0.38501,\"USDPAB\":1.0007,\"USDPEN\":3.334603,\"USDPGK\":3.38225,\"USDPHP\":52.053496,\"USDPKR\":155.999773,\"USDPLN\":3.79105,\"USDPYG\":6247.299353,\"USDQAR\":3.640949,\"USDRON\":4.205601,\"USDRSD\":104.979908,\"USDRUB\":64.329499,\"USDRWF\":906,\"USDSAR\":3.750703,\"USDSBD\":8.22815,\"USDSCR\":13.658976,\"USDSDG\":45.146501,\"USDSEK\":9.46456,\"USDSGD\":1.370395,\"USDSHP\":1.320896,\"USDSLL\":8919.999558,\"USDSOS\":582.497294,\"USDSRD\":7.457972,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":515.000154,\"USDSZL\":14.80984,\"USDTHB\":31.209494,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.95855,\"USDTOP\":2.29235,\"USDTRY\":5.87836,\"USDTTD\":6.78605,\"USDTWD\":31.506503,\"USDTZS\":2298.750216,\"USDUAH\":26.46798,\"USDUGX\":3747.919283,\"USDUSD\":1,\"USDUYU\":35.340334,\"USDUZS\":8514.999961,\"USDVEF\":9.987499,\"USDVND\":23335,\"USDVUV\":116.06219,\"USDWST\":2.636423,\"USDXAF\":582.790062,\"USDXAG\":0.067076,\"USDXAU\":0.000742,\"USDXCD\":2.70255,\"USDXDR\":0.72345,\"USDXOF\":579.460758,\"USDXPF\":106.596617,\"USDYER\":250.305548,\"USDZAR\":14.7799,\"USDZMK\":9001.20203,\"USDZMW\":13.086035,\"USDZWL\":322.355011}}', 1, '2019-06-14 14:49:04', '2019-06-14 15:09:24', '2019-06-14 15:09:24', 'USD'),
(771, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560527045,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":79.650527,\"USDALL\":108.729988,\"USDAMD\":478.392896,\"USDANG\":1.876498,\"USDAOA\":338.983504,\"USDARS\":43.780968,\"USDAUD\":1.45475,\"USDAWG\":1.801,\"USDAZN\":1.704999,\"USDBAM\":1.737602,\"USDBBD\":2.00315,\"USDBDT\":84.601033,\"USDBGN\":1.74325,\"USDBHD\":0.376985,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91535,\"USDBRL\":3.894698,\"USDBSD\":1.00075,\"USDBTC\":0.000118,\"USDBTN\":69.799914,\"USDBWP\":10.884501,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.017198,\"USDCAD\":1.33847,\"USDCDF\":1660.999916,\"USDCHF\":0.998905,\"USDCLF\":0.025329,\"USDCLP\":698.901015,\"USDCNY\":6.925399,\"USDCOP\":3267.8,\"USDCRC\":586.224968,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.499496,\"USDCZK\":22.759202,\"USDDJF\":177.719628,\"USDDKK\":6.655304,\"USDDOP\":51.154958,\"USDDZD\":119.504977,\"USDEGP\":16.76198,\"USDERN\":15.000366,\"USDETB\":29.120043,\"USDEUR\":0.89123,\"USDFJD\":2.15665,\"USDFKP\":0.791125,\"USDGBP\":0.79349,\"USDGEL\":2.740042,\"USDGGP\":0.793503,\"USDGHS\":5.425034,\"USDGIP\":0.79112,\"USDGMD\":49.764994,\"USDGNF\":9225.000219,\"USDGTQ\":7.691001,\"USDGYD\":208.944987,\"USDHKD\":7.826701,\"USDHNL\":24.750051,\"USDHRK\":6.59296,\"USDHTG\":92.851984,\"USDHUF\":287.033987,\"USDIDR\":14339.5,\"USDILS\":3.600603,\"USDIMP\":0.793503,\"USDINR\":69.825014,\"USDIQD\":1190,\"USDIRR\":42105.000192,\"USDISK\":126.110089,\"USDJEP\":0.793503,\"USDJMD\":129.750173,\"USDJOD\":0.708985,\"USDJPY\":108.429497,\"USDKES\":101.860284,\"USDKGS\":69.849826,\"USDKHR\":4065.000115,\"USDKMF\":438.249769,\"USDKPW\":900.065066,\"USDKRW\":1184.99994,\"USDKWD\":0.304099,\"USDKYD\":0.83398,\"USDKZT\":384.280261,\"USDLAK\":8655.000159,\"USDLBP\":1515.749805,\"USDLKR\":176.709625,\"USDLRD\":193.99967,\"USDLSL\":14.809974,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.406991,\"USDMAD\":9.660497,\"USDMDL\":18.214501,\"USDMGA\":3603.000467,\"USDMKD\":54.553033,\"USDMMK\":1527.149956,\"USDMNT\":2659.920014,\"USDMOP\":8.0689,\"USDMRO\":357.000204,\"USDMUR\":35.774501,\"USDMVR\":15.450266,\"USDMWK\":745.404991,\"USDMXN\":19.130983,\"USDMYR\":4.166597,\"USDMZN\":62.020011,\"USDNAD\":14.80973,\"USDNGN\":359.999763,\"USDNIO\":33.410284,\"USDNOK\":8.714205,\"USDNPR\":111.720276,\"USDNZD\":1.537825,\"USDOMR\":0.38502,\"USDPAB\":1.00065,\"USDPEN\":3.334701,\"USDPGK\":3.380165,\"USDPHP\":52.045007,\"USDPKR\":156.000308,\"USDPLN\":3.79355,\"USDPYG\":6247.297632,\"USDQAR\":3.641022,\"USDRON\":4.2095,\"USDRSD\":105.079905,\"USDRUB\":64.338023,\"USDRWF\":906,\"USDSAR\":3.75045,\"USDSBD\":8.24175,\"USDSCR\":13.695995,\"USDSDG\":45.146499,\"USDSEK\":9.482696,\"USDSGD\":1.370585,\"USDSHP\":1.320896,\"USDSLL\":8920.000226,\"USDSOS\":582.498155,\"USDSRD\":7.458024,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":515.000074,\"USDSZL\":14.809496,\"USDTHB\":31.216984,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.96025,\"USDTOP\":2.29235,\"USDTRY\":5.881275,\"USDTTD\":6.78605,\"USDTWD\":31.495997,\"USDTZS\":2298.49766,\"USDUAH\":26.467975,\"USDUGX\":3747.895602,\"USDUSD\":1,\"USDUYU\":35.339804,\"USDUZS\":8512.999748,\"USDVEF\":9.987503,\"USDVND\":23335,\"USDVUV\":116.061536,\"USDWST\":2.636736,\"USDXAF\":582.790101,\"USDXAG\":0.066995,\"USDXAU\":0.00074,\"USDXCD\":2.70255,\"USDXDR\":0.723833,\"USDXOF\":585.000203,\"USDXPF\":106.598067,\"USDYER\":250.313532,\"USDZAR\":14.794039,\"USDZMK\":9001.19885,\"USDZMW\":13.085963,\"USDZWL\":322.355011}}', 1, '2019-06-14 15:44:05', '2019-06-14 16:09:16', '2019-06-14 16:09:16', 'USD'),
(772, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560530344,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673101,\"USDAFN\":79.650201,\"USDALL\":108.749935,\"USDAMD\":478.400451,\"USDANG\":1.8765,\"USDAOA\":338.983496,\"USDARS\":43.809813,\"USDAUD\":1.45665,\"USDAWG\":1.801,\"USDAZN\":1.705011,\"USDBAM\":1.737601,\"USDBBD\":2.00315,\"USDBDT\":84.60103,\"USDBGN\":1.748396,\"USDBHD\":0.377035,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.3508,\"USDBOB\":6.91535,\"USDBRL\":3.901896,\"USDBSD\":1.00075,\"USDBTC\":0.000119,\"USDBTN\":69.804393,\"USDBWP\":10.884023,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.017203,\"USDCAD\":1.33923,\"USDCDF\":1661.000376,\"USDCHF\":0.999019,\"USDCLF\":0.025348,\"USDCLP\":699.505007,\"USDCNY\":6.925402,\"USDCOP\":3270.95,\"USDCRC\":586.224973,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.500497,\"USDCZK\":22.784032,\"USDDJF\":177.720074,\"USDDKK\":6.661296,\"USDDOP\":51.154972,\"USDDZD\":119.530264,\"USDEGP\":16.757981,\"USDERN\":14.999774,\"USDETB\":29.120017,\"USDEUR\":0.89195,\"USDFJD\":2.15665,\"USDFKP\":0.791097,\"USDGBP\":0.79357,\"USDGEL\":2.739747,\"USDGGP\":0.793419,\"USDGHS\":5.412855,\"USDGIP\":0.791104,\"USDGMD\":49.765026,\"USDGNF\":9224.999749,\"USDGTQ\":7.691014,\"USDGYD\":208.945034,\"USDHKD\":7.82605,\"USDHNL\":24.750193,\"USDHRK\":6.592901,\"USDHTG\":92.851997,\"USDHUF\":287.570521,\"USDIDR\":14349,\"USDILS\":3.6006,\"USDIMP\":0.793419,\"USDINR\":69.830155,\"USDIQD\":1190,\"USDIRR\":42104.999612,\"USDISK\":126.230135,\"USDJEP\":0.793419,\"USDJMD\":129.750228,\"USDJOD\":0.709097,\"USDJPY\":108.54405,\"USDKES\":101.859862,\"USDKGS\":69.850213,\"USDKHR\":4064.999577,\"USDKMF\":438.249725,\"USDKPW\":900.059605,\"USDKRW\":1187.590033,\"USDKWD\":0.30407,\"USDKYD\":0.83398,\"USDKZT\":384.280442,\"USDLAK\":8654.99982,\"USDLBP\":1515.74979,\"USDLKR\":176.710249,\"USDLRD\":194.000032,\"USDLSL\":14.810209,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.401063,\"USDMAD\":9.662796,\"USDMDL\":18.2145,\"USDMGA\":3603.000398,\"USDMKD\":54.551496,\"USDMMK\":1527.149833,\"USDMNT\":2659.051561,\"USDMOP\":8.0689,\"USDMRO\":357.000059,\"USDMUR\":35.767031,\"USDMVR\":15.450059,\"USDMWK\":745.539823,\"USDMXN\":19.141033,\"USDMYR\":4.167503,\"USDMZN\":62.020372,\"USDNAD\":14.402654,\"USDNGN\":360.000443,\"USDNIO\":33.394211,\"USDNOK\":8.716655,\"USDNPR\":111.719923,\"USDNZD\":1.538898,\"USDOMR\":0.385005,\"USDPAB\":1.00065,\"USDPEN\":3.3355,\"USDPGK\":3.380332,\"USDPHP\":52.060188,\"USDPKR\":156.00022,\"USDPLN\":3.79695,\"USDPYG\":6247.306202,\"USDQAR\":3.64125,\"USDRON\":4.213602,\"USDRSD\":105.159816,\"USDRUB\":64.382986,\"USDRWF\":906,\"USDSAR\":3.75135,\"USDSBD\":8.24175,\"USDSCR\":13.671975,\"USDSDG\":45.1465,\"USDSEK\":9.490802,\"USDSGD\":1.371285,\"USDSHP\":1.320903,\"USDSLL\":8920.000275,\"USDSOS\":582.498184,\"USDSRD\":7.457972,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":514.999809,\"USDSZL\":14.810207,\"USDTHB\":31.215498,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.96025,\"USDTOP\":2.292349,\"USDTRY\":5.88737,\"USDTTD\":6.78605,\"USDTWD\":31.504017,\"USDTZS\":2299.093708,\"USDUAH\":26.468017,\"USDUGX\":3747.900304,\"USDUSD\":1,\"USDUYU\":35.339829,\"USDUZS\":8513.000207,\"USDVEF\":9.987501,\"USDVND\":23335,\"USDVUV\":115.973387,\"USDWST\":2.643664,\"USDXAF\":582.789858,\"USDXAG\":0.067148,\"USDXAU\":0.000742,\"USDXCD\":2.70265,\"USDXDR\":0.723999,\"USDXOF\":584.999627,\"USDXPF\":106.603487,\"USDYER\":250.304172,\"USDZAR\":14.810504,\"USDZMK\":9001.195898,\"USDZMW\":13.08598,\"USDZWL\":322.355011}}', 1, '2019-06-14 16:39:04', '2019-06-14 17:09:16', '2019-06-14 17:09:16', 'USD'),
(773, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560533645,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673197,\"USDAFN\":79.64975,\"USDALL\":108.749962,\"USDAMD\":478.397825,\"USDANG\":1.876506,\"USDAOA\":338.983499,\"USDARS\":43.870504,\"USDAUD\":1.45665,\"USDAWG\":1.801,\"USDAZN\":1.705016,\"USDBAM\":1.737601,\"USDBBD\":2.00315,\"USDBDT\":84.600998,\"USDBGN\":1.745037,\"USDBHD\":0.37703,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.91535,\"USDBRL\":3.8949,\"USDBSD\":1.00075,\"USDBTC\":0.000119,\"USDBTN\":69.828185,\"USDBWP\":10.883971,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.0172,\"USDCAD\":1.34035,\"USDCDF\":1660.999705,\"USDCHF\":0.998976,\"USDCLF\":0.025358,\"USDCLP\":699.695026,\"USDCNY\":6.925398,\"USDCOP\":3270.95,\"USDCRC\":586.225001,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.500501,\"USDCZK\":22.783498,\"USDDJF\":177.71969,\"USDDKK\":6.66167,\"USDDOP\":51.154998,\"USDDZD\":119.54969,\"USDEGP\":16.759793,\"USDERN\":14.999808,\"USDETB\":29.120429,\"USDEUR\":0.892101,\"USDFJD\":2.15665,\"USDFKP\":0.79109,\"USDGBP\":0.793885,\"USDGEL\":2.740258,\"USDGGP\":0.793897,\"USDGHS\":5.388904,\"USDGIP\":0.79109,\"USDGMD\":49.765034,\"USDGNF\":9224.999944,\"USDGTQ\":7.691014,\"USDGYD\":208.944999,\"USDHKD\":7.826575,\"USDHNL\":24.749791,\"USDHRK\":6.59295,\"USDHTG\":92.85201,\"USDHUF\":287.509752,\"USDIDR\":14340.45,\"USDILS\":3.600598,\"USDIMP\":0.793897,\"USDINR\":69.854943,\"USDIQD\":1190,\"USDIRR\":42104.99994,\"USDISK\":126.259946,\"USDJEP\":0.793897,\"USDJMD\":129.749854,\"USDJOD\":0.709097,\"USDJPY\":108.52295,\"USDKES\":101.849851,\"USDKGS\":69.850445,\"USDKHR\":4065.000318,\"USDKMF\":438.250071,\"USDKPW\":900.065184,\"USDKRW\":1187.190483,\"USDKWD\":0.30407,\"USDKYD\":0.83398,\"USDKZT\":384.279896,\"USDLAK\":8654.999915,\"USDLBP\":1515.749943,\"USDLKR\":176.709709,\"USDLRD\":193.999702,\"USDLSL\":14.810198,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.391108,\"USDMAD\":9.662799,\"USDMDL\":18.214494,\"USDMGA\":3603.000085,\"USDMKD\":54.551502,\"USDMMK\":1527.149986,\"USDMNT\":2660.006128,\"USDMOP\":8.068897,\"USDMRO\":356.999955,\"USDMUR\":35.773504,\"USDMVR\":15.44971,\"USDMWK\":745.519954,\"USDMXN\":19.144992,\"USDMYR\":4.167501,\"USDMZN\":62.020409,\"USDNAD\":14.400406,\"USDNGN\":360.000105,\"USDNIO\":33.400913,\"USDNOK\":8.716165,\"USDNPR\":111.719756,\"USDNZD\":1.540245,\"USDOMR\":0.385015,\"USDPAB\":1.00065,\"USDPEN\":3.33545,\"USDPGK\":3.380276,\"USDPHP\":52.059811,\"USDPKR\":156.000034,\"USDPLN\":3.79785,\"USDPYG\":6247.298555,\"USDQAR\":3.64125,\"USDRON\":4.213896,\"USDRSD\":105.189789,\"USDRUB\":64.380796,\"USDRWF\":906,\"USDSAR\":3.750501,\"USDSBD\":8.24175,\"USDSCR\":13.65999,\"USDSDG\":45.146499,\"USDSEK\":9.48758,\"USDSGD\":1.371425,\"USDSHP\":1.3209,\"USDSLL\":8919.99974,\"USDSOS\":582.498534,\"USDSRD\":7.457969,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":515.000181,\"USDSZL\":14.809894,\"USDTHB\":31.220026,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.96025,\"USDTOP\":2.29235,\"USDTRY\":5.887979,\"USDTTD\":6.78605,\"USDTWD\":31.505998,\"USDTZS\":2298.896429,\"USDUAH\":26.468034,\"USDUGX\":3747.900738,\"USDUSD\":1,\"USDUYU\":35.339924,\"USDUZS\":8512.999599,\"USDVEF\":9.987502,\"USDVND\":23335,\"USDVUV\":116.061462,\"USDWST\":2.636426,\"USDXAF\":582.789818,\"USDXAG\":0.06754,\"USDXAU\":0.000747,\"USDXCD\":2.70255,\"USDXDR\":0.724395,\"USDXOF\":585.00025,\"USDXPF\":106.600135,\"USDYER\":250.29797,\"USDZAR\":14.8213,\"USDZMK\":9001.193234,\"USDZMW\":13.086011,\"USDZWL\":322.355011}}', 1, '2019-06-14 17:34:05', '2019-06-14 18:09:16', '2019-06-14 18:09:16', 'USD'),
(774, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1560536945,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673204,\"USDAFN\":79.650404,\"USDALL\":108.750403,\"USDAMD\":478.403986,\"USDANG\":1.876504,\"USDAOA\":338.983504,\"USDARS\":43.995804,\"USDAUD\":1.456904,\"USDAWG\":1.801,\"USDAZN\":1.705041,\"USDBAM\":1.737604,\"USDBBD\":2.00315,\"USDBDT\":84.601041,\"USDBGN\":1.744604,\"USDBHD\":0.37687,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.91535,\"USDBRL\":3.909604,\"USDBSD\":1.00075,\"USDBTC\":0.000119,\"USDBTN\":69.838018,\"USDBWP\":10.884041,\"USDBYN\":2.06545,\"USDBYR\":19600,\"USDBZD\":2.017204,\"USDCAD\":1.34156,\"USDCDF\":1661.000362,\"USDCHF\":0.999135,\"USDCLF\":0.025358,\"USDCLP\":699.705041,\"USDCNY\":6.925404,\"USDCOP\":3270.95,\"USDCRC\":586.225041,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.500504,\"USDCZK\":22.78804,\"USDDJF\":177.720394,\"USDDKK\":6.66144,\"USDDOP\":51.15504,\"USDDZD\":119.203884,\"USDEGP\":16.761504,\"USDERN\":15.000358,\"USDETB\":29.120392,\"USDEUR\":0.89206,\"USDFJD\":2.15665,\"USDFKP\":0.79109,\"USDGBP\":0.794355,\"USDGEL\":2.740391,\"USDGGP\":0.794331,\"USDGHS\":5.403858,\"USDGIP\":0.79109,\"USDGMD\":49.76504,\"USDGNF\":9225.000355,\"USDGTQ\":7.69104,\"USDGYD\":208.94504,\"USDHKD\":7.826265,\"USDHNL\":24.750389,\"USDHRK\":6.592504,\"USDHTG\":92.85204,\"USDHUF\":287.60804,\"USDIDR\":14345.5,\"USDILS\":3.600604,\"USDIMP\":0.794331,\"USDINR\":69.877504,\"USDIQD\":1190,\"USDIRR\":42105.000352,\"USDISK\":126.260386,\"USDJEP\":0.794331,\"USDJMD\":129.750386,\"USDJOD\":0.709104,\"USDJPY\":108.55904,\"USDKES\":101.84504,\"USDKGS\":69.850385,\"USDKHR\":4065.000351,\"USDKMF\":438.250384,\"USDKPW\":900.066033,\"USDKRW\":1187.735039,\"USDKWD\":0.30407,\"USDKYD\":0.83398,\"USDKZT\":384.280383,\"USDLAK\":8655.000349,\"USDLBP\":1515.750382,\"USDLKR\":176.710382,\"USDLRD\":194.000348,\"USDLSL\":14.810382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.403765,\"USDMAD\":9.670381,\"USDMDL\":18.214504,\"USDMGA\":3603.000347,\"USDMKD\":54.548504,\"USDMMK\":1527.15038,\"USDMNT\":2659.310636,\"USDMOP\":8.068904,\"USDMRO\":357.000346,\"USDMUR\":35.769039,\"USDMVR\":15.450378,\"USDMWK\":745.520378,\"USDMXN\":19.14975,\"USDMYR\":4.167504,\"USDMZN\":62.020377,\"USDNAD\":14.403729,\"USDNGN\":360.000344,\"USDNIO\":33.403725,\"USDNOK\":8.716915,\"USDNPR\":111.720376,\"USDNZD\":1.540505,\"USDOMR\":0.38499,\"USDPAB\":1.00065,\"USDPEN\":3.33545,\"USDPGK\":3.380375,\"USDPHP\":52.065039,\"USDPKR\":156.000342,\"USDPLN\":3.79739,\"USDPYG\":6247.303699,\"USDQAR\":3.64125,\"USDRON\":4.213704,\"USDRSD\":105.170373,\"USDRUB\":64.369504,\"USDRWF\":906,\"USDSAR\":3.75035,\"USDSBD\":8.24175,\"USDSCR\":13.659038,\"USDSDG\":45.146504,\"USDSEK\":9.48905,\"USDSGD\":1.371595,\"USDSHP\":1.320904,\"USDSLL\":8920.000339,\"USDSOS\":582.503667,\"USDSRD\":7.458038,\"USDSTD\":21050.59961,\"USDSVC\":8.75655,\"USDSYP\":515.000338,\"USDSZL\":14.81037,\"USDTHB\":31.23037,\"USDTJS\":9.44215,\"USDTMT\":3.51,\"USDTND\":2.96025,\"USDTOP\":2.29235,\"USDTRY\":5.88335,\"USDTTD\":6.78605,\"USDTWD\":31.509038,\"USDTZS\":2298.903635,\"USDUAH\":26.468038,\"USDUGX\":3747.903631,\"USDUSD\":1,\"USDUYU\":35.340367,\"USDUZS\":8513.000335,\"USDVEF\":9.987504,\"USDVND\":23335,\"USDVUV\":115.971144,\"USDWST\":2.639752,\"USDXAF\":582.790365,\"USDXAG\":0.067408,\"USDXAU\":0.000746,\"USDXCD\":2.70255,\"USDXDR\":0.72435,\"USDXOF\":585.000332,\"USDXPF\":106.6036,\"USDYER\":250.303597,\"USDZAR\":14.825037,\"USDZMK\":9001.203593,\"USDZMW\":13.086037,\"USDZWL\":322.355011}}', 1, '2019-06-14 18:29:05', '2019-06-14 19:09:16', '2019-06-14 19:09:16', 'USD'),
(775, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561371845,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":80.323018,\"USDALL\":107.029759,\"USDAMD\":473.985026,\"USDANG\":1.862101,\"USDAOA\":340.271973,\"USDARS\":42.785801,\"USDAUD\":1.439295,\"USDAWG\":1.801,\"USDAZN\":1.705003,\"USDBAM\":1.71765,\"USDBBD\":1.97795,\"USDBDT\":83.9205,\"USDBGN\":1.7174,\"USDBHD\":0.37705,\"USDBIF\":1824.2,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.87755,\"USDBRL\":3.8221,\"USDBSD\":0.993105,\"USDBTC\":0.000091246829,\"USDBTN\":69.446511,\"USDBWP\":10.622501,\"USDBYN\":2.025297,\"USDBYR\":19600,\"USDBZD\":2.00185,\"USDCAD\":1.31835,\"USDCDF\":1661.000154,\"USDCHF\":0.97541,\"USDCLF\":0.024847,\"USDCLP\":685.597816,\"USDCNY\":6.879906,\"USDCOP\":3172.1,\"USDCRC\":580.864984,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.842967,\"USDCZK\":22.476303,\"USDDJF\":177.719654,\"USDDKK\":6.555297,\"USDDOP\":50.272502,\"USDDZD\":118.750075,\"USDEGP\":16.711399,\"USDERN\":14.999777,\"USDETB\":28.657498,\"USDEUR\":0.878015,\"USDFJD\":2.146901,\"USDFKP\":0.78459,\"USDGBP\":0.78457,\"USDGEL\":2.770087,\"USDGGP\":0.784208,\"USDGHS\":5.36305,\"USDGIP\":0.78463,\"USDGMD\":49.596843,\"USDGNF\":9099.050093,\"USDGTQ\":7.65225,\"USDGYD\":207.370162,\"USDHKD\":7.811806,\"USDHNL\":24.313976,\"USDHRK\":6.494603,\"USDHTG\":92.671053,\"USDHUF\":284.360109,\"USDIDR\":14148,\"USDILS\":3.603702,\"USDIMP\":0.784208,\"USDINR\":69.444989,\"USDIQD\":1185,\"USDIRR\":42105.000279,\"USDISK\":124.250037,\"USDJEP\":0.784208,\"USDJMD\":128.698512,\"USDJOD\":0.708992,\"USDJPY\":107.350239,\"USDKES\":101.954978,\"USDKGS\":69.6445,\"USDKHR\":4047.999729,\"USDKMF\":434.750015,\"USDKPW\":900.068636,\"USDKRW\":1156.30406,\"USDKWD\":0.303503,\"USDKYD\":0.827645,\"USDKZT\":376.10501,\"USDLAK\":8655.249709,\"USDLBP\":1501.850218,\"USDLKR\":176.540261,\"USDLRD\":194.999933,\"USDLSL\":14.329613,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38375,\"USDMAD\":9.514989,\"USDMDL\":18.100501,\"USDMGA\":3629.870907,\"USDMKD\":54.004986,\"USDMMK\":1509.050314,\"USDMNT\":2661.20099,\"USDMOP\":7.99125,\"USDMRO\":357.000094,\"USDMUR\":35.549698,\"USDMVR\":15.500677,\"USDMWK\":760.055002,\"USDMXN\":19.12997,\"USDMYR\":4.141305,\"USDMZN\":62.019982,\"USDNAD\":14.330275,\"USDNGN\":358.029559,\"USDNIO\":32.734014,\"USDNOK\":8.472979,\"USDNPR\":110.550165,\"USDNZD\":1.51285,\"USDOMR\":0.38506,\"USDPAB\":0.99317,\"USDPEN\":3.30435,\"USDPGK\":3.363105,\"USDPHP\":51.379609,\"USDPKR\":156.174999,\"USDPLN\":3.73465,\"USDPYG\":6191.800758,\"USDQAR\":3.641004,\"USDRON\":4.146703,\"USDRSD\":103.502706,\"USDRUB\":62.897503,\"USDRWF\":904.755,\"USDSAR\":3.750941,\"USDSBD\":8.24175,\"USDSCR\":13.660171,\"USDSDG\":44.800955,\"USDSEK\":9.31734,\"USDSGD\":1.353903,\"USDSHP\":1.320896,\"USDSLL\":8900.000415,\"USDSOS\":579.999693,\"USDSRD\":7.458027,\"USDSTD\":21050.59961,\"USDSVC\":8.690097,\"USDSYP\":514.999857,\"USDSZL\":14.22903,\"USDTHB\":30.771502,\"USDTJS\":9.365496,\"USDTMT\":3.5,\"USDTND\":2.888014,\"USDTOP\":2.28815,\"USDTRY\":5.768575,\"USDTTD\":6.7262,\"USDTWD\":30.995041,\"USDTZS\":2300.197591,\"USDUAH\":26.029497,\"USDUGX\":3659.799269,\"USDUSD\":1,\"USDUYU\":35.092035,\"USDUZS\":8474.750069,\"USDVEF\":9.987503,\"USDVND\":23290.9,\"USDVUV\":116.06061,\"USDWST\":2.635008,\"USDXAF\":576.090055,\"USDXAG\":0.06502,\"USDXAU\":0.000711,\"USDXCD\":2.70255,\"USDXDR\":0.718651,\"USDXOF\":576.090212,\"USDXPF\":104.739489,\"USDYER\":250.350207,\"USDZAR\":14.34215,\"USDZMK\":9001.19606,\"USDZMW\":12.835949,\"USDZWL\":322.355011}}', 1, '2019-06-24 10:24:05', '2019-06-24 10:26:14', '2019-06-24 10:26:14', 'USD'),
(776, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561378446,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.942499,\"USDALL\":106.750247,\"USDAMD\":476.825026,\"USDANG\":1.874401,\"USDAOA\":340.271985,\"USDARS\":42.782032,\"USDAUD\":1.438101,\"USDAWG\":1.801,\"USDAZN\":1.705006,\"USDBAM\":1.716303,\"USDBBD\":1.99095,\"USDBDT\":84.462503,\"USDBGN\":1.71655,\"USDBHD\":0.37685,\"USDBIF\":1836.2,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.912698,\"USDBRL\":3.82355,\"USDBSD\":0.999645,\"USDBTC\":0.00009158534,\"USDBTN\":69.413133,\"USDBWP\":10.668497,\"USDBYN\":2.034501,\"USDBYR\":19600,\"USDBZD\":2.015016,\"USDCAD\":1.31912,\"USDCDF\":1661.000233,\"USDCHF\":0.974935,\"USDCLF\":0.024785,\"USDCLP\":683.897918,\"USDCNY\":6.877001,\"USDCOP\":3202.05,\"USDCRC\":584.675055,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.827498,\"USDCZK\":22.46855,\"USDDJF\":177.720244,\"USDDKK\":6.552565,\"USDDOP\":50.252998,\"USDDZD\":118.725011,\"USDEGP\":16.710412,\"USDERN\":14.999781,\"USDETB\":28.6505,\"USDEUR\":0.87762,\"USDFJD\":2.1469,\"USDFKP\":0.784915,\"USDGBP\":0.784185,\"USDGEL\":2.770101,\"USDGGP\":0.784072,\"USDGHS\":5.378197,\"USDGIP\":0.784915,\"USDGMD\":49.601917,\"USDGNF\":9158.789964,\"USDGTQ\":7.702396,\"USDGYD\":208.704998,\"USDHKD\":7.81108,\"USDHNL\":24.473499,\"USDHRK\":6.490698,\"USDHTG\":93.302502,\"USDHUF\":284.644996,\"USDIDR\":14146,\"USDILS\":3.600702,\"USDIMP\":0.784072,\"USDINR\":69.38975,\"USDIQD\":1192.8,\"USDIRR\":42104.999717,\"USDISK\":124.189755,\"USDJEP\":0.784072,\"USDJMD\":129.820301,\"USDJOD\":0.708965,\"USDJPY\":107.297503,\"USDKES\":101.890414,\"USDKGS\":69.488402,\"USDKHR\":4046.44979,\"USDKMF\":434.75047,\"USDKPW\":900.08091,\"USDKRW\":1156.530202,\"USDKWD\":0.303504,\"USDKYD\":0.833075,\"USDKZT\":378.529849,\"USDLAK\":8713.504172,\"USDLBP\":1511.697455,\"USDLKR\":176.520274,\"USDLRD\":194.999807,\"USDLSL\":14.329666,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38905,\"USDMAD\":9.512101,\"USDMDL\":18.166022,\"USDMGA\":3651.301894,\"USDMKD\":53.973025,\"USDMMK\":1519.900423,\"USDMNT\":2660.937752,\"USDMOP\":8.04365,\"USDMRO\":357.000338,\"USDMUR\":35.549015,\"USDMVR\":15.492558,\"USDMWK\":760.130165,\"USDMXN\":19.151665,\"USDMYR\":4.142962,\"USDMZN\":62.019994,\"USDNAD\":14.33052,\"USDNGN\":360.369937,\"USDNIO\":32.949019,\"USDNOK\":8.480965,\"USDNPR\":111.004969,\"USDNZD\":1.51355,\"USDOMR\":0.385005,\"USDPAB\":0.99965,\"USDPEN\":3.304017,\"USDPGK\":3.385005,\"USDPHP\":51.374967,\"USDPKR\":157.313983,\"USDPLN\":3.73385,\"USDPYG\":6197.705896,\"USDQAR\":3.640989,\"USDRON\":4.141205,\"USDRSD\":103.449904,\"USDRUB\":62.93825,\"USDRWF\":910.8,\"USDSAR\":3.750801,\"USDSBD\":8.24175,\"USDSCR\":13.658008,\"USDSDG\":45.096499,\"USDSEK\":9.30854,\"USDSGD\":1.354005,\"USDSHP\":1.320897,\"USDSLL\":8899.999934,\"USDSOS\":579.999835,\"USDSRD\":7.458027,\"USDSTD\":21050.59961,\"USDSVC\":8.746701,\"USDSYP\":515.000264,\"USDSZL\":14.320973,\"USDTHB\":30.730012,\"USDTJS\":9.426402,\"USDTMT\":3.5,\"USDTND\":2.894699,\"USDTOP\":2.28815,\"USDTRY\":5.794597,\"USDTTD\":6.76895,\"USDTWD\":30.975974,\"USDTZS\":2299.199662,\"USDUAH\":26.182503,\"USDUGX\":3685.711367,\"USDUSD\":1,\"USDUYU\":35.222501,\"USDUZS\":8543.500541,\"USDVEF\":9.9875,\"USDVND\":23290.9,\"USDVUV\":116.061342,\"USDWST\":2.635094,\"USDXAF\":575.619991,\"USDXAG\":0.065155,\"USDXAU\":0.00071,\"USDXCD\":2.70255,\"USDXDR\":0.718653,\"USDXOF\":575.580231,\"USDXPF\":104.650192,\"USDYER\":250.34957,\"USDZAR\":14.33435,\"USDZMK\":9001.198289,\"USDZMW\":13.021018,\"USDZWL\":322.355011}}', 1, '2019-06-24 12:14:06', '2019-06-24 12:48:01', '2019-06-24 12:48:01', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(777, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561381744,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.942497,\"USDALL\":107.070066,\"USDAMD\":476.824978,\"USDANG\":1.874399,\"USDAOA\":340.271967,\"USDARS\":42.898695,\"USDAUD\":1.438201,\"USDAWG\":1.801,\"USDAZN\":1.70499,\"USDBAM\":1.716299,\"USDBBD\":1.99095,\"USDBDT\":84.462499,\"USDBGN\":1.717699,\"USDBHD\":0.376875,\"USDBIF\":1836.2,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.9127,\"USDBRL\":3.824497,\"USDBSD\":0.999645,\"USDBTC\":0.000091978314,\"USDBTN\":69.422453,\"USDBWP\":10.6685,\"USDBYN\":2.034499,\"USDBYR\":19600,\"USDBZD\":2.014953,\"USDCAD\":1.319915,\"USDCDF\":1661.000243,\"USDCHF\":0.974935,\"USDCLF\":0.024726,\"USDCLP\":682.260203,\"USDCNY\":6.877799,\"USDCOP\":3203.5,\"USDCRC\":584.675042,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.827498,\"USDCZK\":22.48202,\"USDDJF\":177.720091,\"USDDKK\":6.556496,\"USDDOP\":50.253024,\"USDDZD\":118.759758,\"USDEGP\":16.710798,\"USDERN\":15.000179,\"USDETB\":28.650502,\"USDEUR\":0.878155,\"USDFJD\":2.146904,\"USDFKP\":0.784915,\"USDGBP\":0.78621,\"USDGEL\":2.770253,\"USDGGP\":0.785721,\"USDGHS\":5.378201,\"USDGIP\":0.784915,\"USDGMD\":49.601894,\"USDGNF\":9158.795038,\"USDGTQ\":7.7024,\"USDGYD\":208.704947,\"USDHKD\":7.81065,\"USDHNL\":24.473498,\"USDHRK\":6.500896,\"USDHTG\":93.302504,\"USDHUF\":284.519878,\"USDIDR\":14161.5,\"USDILS\":3.603594,\"USDIMP\":0.785721,\"USDINR\":69.432203,\"USDIQD\":1192.8,\"USDIRR\":42105.000304,\"USDISK\":124.279896,\"USDJEP\":0.785721,\"USDJMD\":129.820003,\"USDJOD\":0.708797,\"USDJPY\":107.409821,\"USDKES\":101.959741,\"USDKGS\":69.4884,\"USDKHR\":4046.449686,\"USDKMF\":434.749805,\"USDKPW\":900.08078,\"USDKRW\":1156.339726,\"USDKWD\":0.303501,\"USDKYD\":0.833075,\"USDKZT\":378.529802,\"USDLAK\":8713.496139,\"USDLBP\":1511.694813,\"USDLKR\":176.520021,\"USDLRD\":195.000228,\"USDLSL\":14.330003,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38905,\"USDMAD\":9.512602,\"USDMDL\":18.165998,\"USDMGA\":3651.30433,\"USDMKD\":54.009841,\"USDMMK\":1519.90421,\"USDMNT\":2661.413526,\"USDMOP\":8.04365,\"USDMRO\":356.999727,\"USDMUR\":35.528502,\"USDMVR\":15.502122,\"USDMWK\":760.11019,\"USDMXN\":19.154982,\"USDMYR\":4.143801,\"USDMZN\":62.01987,\"USDNAD\":14.329775,\"USDNGN\":360.369996,\"USDNIO\":32.948994,\"USDNOK\":8.490375,\"USDNPR\":111.004968,\"USDNZD\":1.514595,\"USDOMR\":0.385075,\"USDPAB\":0.99965,\"USDPEN\":3.30335,\"USDPGK\":3.384994,\"USDPHP\":51.384992,\"USDPKR\":157.249665,\"USDPLN\":3.73717,\"USDPYG\":6197.708602,\"USDQAR\":3.64175,\"USDRON\":4.146025,\"USDRSD\":103.450236,\"USDRUB\":62.9475,\"USDRWF\":910.8,\"USDSAR\":3.7513,\"USDSBD\":8.24175,\"USDSCR\":13.660155,\"USDSDG\":45.096498,\"USDSEK\":9.306995,\"USDSGD\":1.354302,\"USDSHP\":1.320902,\"USDSLL\":8900.000033,\"USDSOS\":579.999753,\"USDSRD\":7.457986,\"USDSTD\":21050.59961,\"USDSVC\":8.7467,\"USDSYP\":514.999753,\"USDSZL\":14.321042,\"USDTHB\":30.730501,\"USDTJS\":9.426402,\"USDTMT\":3.5,\"USDTND\":2.88915,\"USDTOP\":2.28815,\"USDTRY\":5.810025,\"USDTTD\":6.76895,\"USDTWD\":31.007007,\"USDTZS\":2299.200977,\"USDUAH\":26.182498,\"USDUGX\":3685.697906,\"USDUSD\":1,\"USDUYU\":35.222498,\"USDUZS\":8543.496617,\"USDVEF\":9.987502,\"USDVND\":23290.9,\"USDVUV\":116.061524,\"USDWST\":2.635039,\"USDXAF\":575.619788,\"USDXAG\":0.065278,\"USDXAU\":0.000711,\"USDXCD\":2.70255,\"USDXDR\":0.718852,\"USDXOF\":575.579974,\"USDXPF\":104.649867,\"USDYER\":250.349784,\"USDZAR\":14.35659,\"USDZMK\":9001.199881,\"USDZMW\":13.021012,\"USDZWL\":322.355011}}', 1, '2019-06-24 13:09:04', '2019-06-24 13:48:01', '2019-06-24 13:48:01', 'USD'),
(778, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561385045,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":80.649616,\"USDALL\":106.84046,\"USDAMD\":477.810349,\"USDANG\":1.874397,\"USDAOA\":340.272025,\"USDARS\":42.813399,\"USDAUD\":1.43885,\"USDAWG\":1.801,\"USDAZN\":1.705005,\"USDBAM\":1.716297,\"USDBBD\":1.99095,\"USDBDT\":84.461956,\"USDBGN\":1.71865,\"USDBHD\":0.37705,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350649,\"USDBOB\":6.91265,\"USDBRL\":3.825603,\"USDBSD\":0.99955,\"USDBTC\":0.000091982172,\"USDBTN\":69.42596,\"USDBWP\":10.667993,\"USDBYN\":2.034502,\"USDBYR\":19600,\"USDBZD\":2.015021,\"USDCAD\":1.321065,\"USDCDF\":1661.00059,\"USDCHF\":0.975404,\"USDCLF\":0.024807,\"USDCLP\":684.501874,\"USDCNY\":6.878397,\"USDCOP\":3191.5,\"USDCRC\":584.674992,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.476503,\"USDCZK\":22.498102,\"USDDJF\":177.720211,\"USDDKK\":6.560203,\"USDDOP\":51.004972,\"USDDZD\":118.77503,\"USDEGP\":16.645873,\"USDERN\":15.000194,\"USDETB\":29.040218,\"USDEUR\":0.87867,\"USDFJD\":2.16225,\"USDFKP\":0.78492,\"USDGBP\":0.78632,\"USDGEL\":2.76954,\"USDGGP\":0.786245,\"USDGHS\":5.434971,\"USDGIP\":0.78491,\"USDGMD\":49.604793,\"USDGNF\":9229.999973,\"USDGTQ\":7.702402,\"USDGYD\":208.704982,\"USDHKD\":7.81015,\"USDHNL\":24.825016,\"USDHRK\":6.501596,\"USDHTG\":93.302501,\"USDHUF\":284.721004,\"USDIDR\":14168,\"USDILS\":3.603599,\"USDIMP\":0.786245,\"USDINR\":69.413503,\"USDIQD\":1190,\"USDIRR\":42105.000178,\"USDISK\":124.330505,\"USDJEP\":0.786245,\"USDJMD\":129.820294,\"USDJOD\":0.7089,\"USDJPY\":107.505953,\"USDKES\":101.950186,\"USDKGS\":69.488398,\"USDKHR\":4077.494813,\"USDKMF\":435.949598,\"USDKPW\":900.080687,\"USDKRW\":1157.898743,\"USDKWD\":0.303404,\"USDKYD\":0.833075,\"USDKZT\":378.529659,\"USDLAK\":8660.00006,\"USDLBP\":1508.495264,\"USDLKR\":176.519972,\"USDLRD\":194.87501,\"USDLSL\":14.295989,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.396854,\"USDMAD\":9.514597,\"USDMDL\":18.16603,\"USDMGA\":3604.999574,\"USDMKD\":54.011983,\"USDMMK\":1519.899754,\"USDMNT\":2661.395371,\"USDMOP\":8.04365,\"USDMRO\":356.999921,\"USDMUR\":35.489498,\"USDMVR\":15.506089,\"USDMWK\":760.075027,\"USDMXN\":19.162987,\"USDMYR\":4.143906,\"USDMZN\":62.019901,\"USDNAD\":14.292461,\"USDNGN\":359.999875,\"USDNIO\":33.402312,\"USDNOK\":8.50679,\"USDNPR\":111.005027,\"USDNZD\":1.513815,\"USDOMR\":0.38507,\"USDPAB\":0.99955,\"USDPEN\":3.30315,\"USDPGK\":3.375049,\"USDPHP\":51.380499,\"USDPKR\":157.00026,\"USDPLN\":3.73845,\"USDPYG\":6197.70123,\"USDQAR\":3.641013,\"USDRON\":4.147904,\"USDRSD\":103.579823,\"USDRUB\":62.982502,\"USDRWF\":906,\"USDSAR\":3.75065,\"USDSBD\":8.22815,\"USDSCR\":13.66006,\"USDSDG\":45.096501,\"USDSEK\":9.32171,\"USDSGD\":1.35443,\"USDSHP\":1.320902,\"USDSLL\":8919.999965,\"USDSOS\":581.000267,\"USDSRD\":7.458023,\"USDSTD\":21050.59961,\"USDSVC\":8.7467,\"USDSYP\":515.000268,\"USDSZL\":14.299912,\"USDTHB\":30.71944,\"USDTJS\":9.426403,\"USDTMT\":3.51,\"USDTND\":2.91265,\"USDTOP\":2.28815,\"USDTRY\":5.814445,\"USDTTD\":6.76895,\"USDTWD\":31.025979,\"USDTZS\":2298.796253,\"USDUAH\":26.182498,\"USDUGX\":3685.699323,\"USDUSD\":1,\"USDUYU\":35.222503,\"USDUZS\":8525.000566,\"USDVEF\":9.987499,\"USDVND\":23300,\"USDVUV\":116.054091,\"USDWST\":2.637522,\"USDXAF\":575.62051,\"USDXAG\":0.065149,\"USDXAU\":0.000711,\"USDXCD\":2.70255,\"USDXDR\":0.71895,\"USDXOF\":583.999679,\"USDXPF\":106.000092,\"USDYER\":250.299259,\"USDZAR\":14.390299,\"USDZMK\":9001.199323,\"USDZMW\":13.020975,\"USDZWL\":322.355011}}', 1, '2019-06-24 14:04:05', '2019-06-24 14:48:03', '2019-06-24 14:48:03', 'USD'),
(779, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561388347,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":80.649622,\"USDALL\":106.950188,\"USDAMD\":477.810017,\"USDANG\":1.874402,\"USDAOA\":340.271986,\"USDARS\":42.669398,\"USDAUD\":1.43762,\"USDAWG\":1.801,\"USDAZN\":1.705029,\"USDBAM\":1.7163,\"USDBBD\":1.99095,\"USDBDT\":84.461959,\"USDBGN\":1.71715,\"USDBHD\":0.37695,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91265,\"USDBRL\":3.8207,\"USDBSD\":0.99955,\"USDBTC\":0.000091658734,\"USDBTN\":69.411391,\"USDBWP\":10.667974,\"USDBYN\":2.0345,\"USDBYR\":19600,\"USDBZD\":2.015021,\"USDCAD\":1.32061,\"USDCDF\":1661.000278,\"USDCHF\":0.971655,\"USDCLF\":0.024759,\"USDCLP\":683.205666,\"USDCNY\":6.877032,\"USDCOP\":3190,\"USDCRC\":584.675061,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.476499,\"USDCZK\":22.462201,\"USDDJF\":177.720023,\"USDDKK\":6.55555,\"USDDOP\":50.994957,\"USDDZD\":118.75037,\"USDEGP\":16.704698,\"USDERN\":15.000218,\"USDETB\":29.039635,\"USDEUR\":0.87793,\"USDFJD\":2.16225,\"USDFKP\":0.78492,\"USDGBP\":0.785775,\"USDGEL\":2.770241,\"USDGGP\":0.78583,\"USDGHS\":5.452495,\"USDGIP\":0.784855,\"USDGMD\":49.749889,\"USDGNF\":9224.999546,\"USDGTQ\":7.702398,\"USDGYD\":208.704968,\"USDHKD\":7.81017,\"USDHNL\":24.825013,\"USDHRK\":6.494198,\"USDHTG\":93.302503,\"USDHUF\":284.249994,\"USDIDR\":14168,\"USDILS\":3.601102,\"USDIMP\":0.78583,\"USDINR\":69.407019,\"USDIQD\":1190,\"USDIRR\":42104.999956,\"USDISK\":124.249776,\"USDJEP\":0.78583,\"USDJMD\":129.819545,\"USDJOD\":0.708903,\"USDJPY\":107.365046,\"USDKES\":101.899549,\"USDKGS\":69.488397,\"USDKHR\":4077.499915,\"USDKMF\":432.32503,\"USDKPW\":900.081377,\"USDKRW\":1156.869911,\"USDKWD\":0.30343,\"USDKYD\":0.833075,\"USDKZT\":378.530296,\"USDLAK\":8662.520974,\"USDLBP\":1507.50415,\"USDLKR\":176.519858,\"USDLRD\":195.049997,\"USDLSL\":14.294317,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.396327,\"USDMAD\":9.50991,\"USDMDL\":18.166013,\"USDMGA\":3605.000312,\"USDMKD\":54.006993,\"USDMMK\":1519.898985,\"USDMNT\":2659.93882,\"USDMOP\":8.04365,\"USDMRO\":357.000243,\"USDMUR\":35.484501,\"USDMVR\":15.503146,\"USDMWK\":759.995013,\"USDMXN\":19.20066,\"USDMYR\":4.143495,\"USDMZN\":62.020214,\"USDNAD\":14.299729,\"USDNGN\":360.000176,\"USDNIO\":33.398945,\"USDNOK\":8.49117,\"USDNPR\":111.005047,\"USDNZD\":1.511985,\"USDOMR\":0.385035,\"USDPAB\":0.99955,\"USDPEN\":3.302199,\"USDPGK\":3.374965,\"USDPHP\":51.372498,\"USDPKR\":157.250272,\"USDPLN\":3.73379,\"USDPYG\":6197.701184,\"USDQAR\":3.640975,\"USDRON\":4.145298,\"USDRSD\":103.46999,\"USDRUB\":62.881603,\"USDRWF\":906,\"USDSAR\":3.750698,\"USDSBD\":8.22815,\"USDSCR\":13.658978,\"USDSDG\":45.096503,\"USDSEK\":9.30424,\"USDSGD\":1.35392,\"USDSHP\":1.320901,\"USDSLL\":8920.000038,\"USDSOS\":580.999993,\"USDSRD\":7.457982,\"USDSTD\":21050.59961,\"USDSVC\":8.746702,\"USDSYP\":514.999337,\"USDSZL\":14.301978,\"USDTHB\":30.709834,\"USDTJS\":9.426398,\"USDTMT\":3.51,\"USDTND\":2.910596,\"USDTOP\":2.28815,\"USDTRY\":5.801015,\"USDTTD\":6.76895,\"USDTWD\":31.036989,\"USDTZS\":2303.999452,\"USDUAH\":26.182502,\"USDUGX\":3685.70866,\"USDUSD\":1,\"USDUYU\":35.222501,\"USDUZS\":8524.999896,\"USDVEF\":9.987505,\"USDVND\":23300,\"USDVUV\":116.029531,\"USDWST\":2.636911,\"USDXAF\":575.620396,\"USDXAG\":0.065009,\"USDXAU\":0.00071,\"USDXCD\":2.70255,\"USDXDR\":0.71905,\"USDXOF\":584.000638,\"USDXPF\":105.999748,\"USDYER\":250.296321,\"USDZAR\":14.36615,\"USDZMK\":9001.197895,\"USDZMW\":13.021015,\"USDZWL\":322.355011}}', 1, '2019-06-24 14:59:07', '2019-06-24 15:48:00', '2019-06-24 15:48:00', 'USD'),
(780, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561391646,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":80.650311,\"USDALL\":106.929914,\"USDAMD\":477.810184,\"USDANG\":1.874398,\"USDAOA\":340.272002,\"USDARS\":42.46604,\"USDAUD\":1.43572,\"USDAWG\":1.801,\"USDAZN\":1.704961,\"USDBAM\":1.716298,\"USDBBD\":1.99095,\"USDBDT\":84.461952,\"USDBGN\":1.71625,\"USDBHD\":0.37687,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350403,\"USDBOB\":6.912649,\"USDBRL\":3.823801,\"USDBSD\":0.99955,\"USDBTC\":0.000091582497,\"USDBTN\":69.3474,\"USDBWP\":10.668008,\"USDBYN\":2.034497,\"USDBYR\":19600,\"USDBZD\":2.014982,\"USDCAD\":1.319825,\"USDCDF\":1661.000313,\"USDCHF\":0.971605,\"USDCLF\":0.024687,\"USDCLP\":681.145025,\"USDCNY\":6.877021,\"USDCOP\":3201.7,\"USDCRC\":584.675008,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.475503,\"USDCZK\":22.448017,\"USDDJF\":177.719792,\"USDDKK\":6.55236,\"USDDOP\":50.994998,\"USDDZD\":118.744978,\"USDEGP\":16.698702,\"USDERN\":15.000331,\"USDETB\":29.039615,\"USDEUR\":0.87758,\"USDFJD\":2.16265,\"USDFKP\":0.784898,\"USDGBP\":0.785395,\"USDGEL\":2.769886,\"USDGGP\":0.785349,\"USDGHS\":5.452502,\"USDGIP\":0.784905,\"USDGMD\":49.749996,\"USDGNF\":9225.00007,\"USDGTQ\":7.702395,\"USDGYD\":208.704979,\"USDHKD\":7.80885,\"USDHNL\":24.824963,\"USDHRK\":6.491599,\"USDHTG\":93.302497,\"USDHUF\":283.904956,\"USDIDR\":14147.25,\"USDILS\":3.601198,\"USDIMP\":0.785349,\"USDINR\":69.342502,\"USDIQD\":1190,\"USDIRR\":42104.999952,\"USDISK\":124.170036,\"USDJEP\":0.785349,\"USDJMD\":129.819781,\"USDJOD\":0.708896,\"USDJPY\":107.333976,\"USDKES\":101.890107,\"USDKGS\":69.488398,\"USDKHR\":4077.500989,\"USDKMF\":432.324977,\"USDKPW\":900.081191,\"USDKRW\":1156.139907,\"USDKWD\":0.3034,\"USDKYD\":0.833075,\"USDKZT\":378.53023,\"USDLAK\":8662.500572,\"USDLBP\":1508.250342,\"USDLKR\":176.520013,\"USDLRD\":195.050135,\"USDLSL\":14.300885,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.400451,\"USDMAD\":9.50905,\"USDMDL\":18.166017,\"USDMGA\":3605.000215,\"USDMKD\":54.005955,\"USDMMK\":1519.901095,\"USDMNT\":2661.504696,\"USDMOP\":8.04365,\"USDMRO\":357.000088,\"USDMUR\":35.480042,\"USDMVR\":15.450247,\"USDMWK\":759.924983,\"USDMXN\":19.18853,\"USDMYR\":4.142297,\"USDMZN\":62.0201,\"USDNAD\":14.360238,\"USDNGN\":359.999867,\"USDNIO\":33.396888,\"USDNOK\":8.48893,\"USDNPR\":111.005028,\"USDNZD\":1.510685,\"USDOMR\":0.385008,\"USDPAB\":0.99955,\"USDPEN\":3.30135,\"USDPGK\":3.374963,\"USDPHP\":51.340076,\"USDPKR\":157.250267,\"USDPLN\":3.73253,\"USDPYG\":6197.696532,\"USDQAR\":3.641749,\"USDRON\":4.144301,\"USDRSD\":103.379723,\"USDRUB\":62.759912,\"USDRWF\":909,\"USDSAR\":3.74995,\"USDSBD\":8.22815,\"USDSCR\":13.659601,\"USDSDG\":45.096499,\"USDSEK\":9.294651,\"USDSGD\":1.35355,\"USDSHP\":1.320896,\"USDSLL\":8901.999913,\"USDSOS\":579.999756,\"USDSRD\":7.458056,\"USDSTD\":21050.59961,\"USDSVC\":8.746703,\"USDSYP\":514.999972,\"USDSZL\":14.359909,\"USDTHB\":30.66703,\"USDTJS\":9.426401,\"USDTMT\":3.5,\"USDTND\":2.891297,\"USDTOP\":2.28815,\"USDTRY\":5.801705,\"USDTTD\":6.76895,\"USDTWD\":30.96197,\"USDTZS\":2303.79913,\"USDUAH\":26.1825,\"USDUGX\":3685.697914,\"USDUSD\":1,\"USDUYU\":35.21005,\"USDUZS\":8525.00032,\"USDVEF\":9.987499,\"USDVND\":23297.5,\"USDVUV\":116.061992,\"USDWST\":2.635033,\"USDXAF\":575.620032,\"USDXAG\":0.064939,\"USDXAU\":0.000707,\"USDXCD\":2.70255,\"USDXDR\":0.71885,\"USDXOF\":583.999744,\"USDXPF\":105.095129,\"USDYER\":250.349567,\"USDZAR\":14.365991,\"USDZMK\":9001.199323,\"USDZMW\":13.021014,\"USDZWL\":322.355011}}', 1, '2019-06-24 15:54:06', '2019-06-24 16:48:00', '2019-06-24 16:48:00', 'USD'),
(781, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561467544,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.694888,\"USDALL\":107.049783,\"USDAMD\":477.069928,\"USDANG\":1.875904,\"USDAOA\":340.271994,\"USDARS\":42.428801,\"USDAUD\":1.435103,\"USDAWG\":1.80125,\"USDAZN\":1.704988,\"USDBAM\":1.71865,\"USDBBD\":2.02005,\"USDBDT\":84.53401,\"USDBGN\":1.71685,\"USDBHD\":0.37696,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.91325,\"USDBRL\":3.83375,\"USDBSD\":1.0004,\"USDBTC\":0.000089360825,\"USDBTN\":69.351602,\"USDBWP\":10.666048,\"USDBYN\":2.038399,\"USDBYR\":19600,\"USDBZD\":2.016605,\"USDCAD\":1.315956,\"USDCDF\":1661.000226,\"USDCHF\":0.974796,\"USDCLF\":0.024564,\"USDCLP\":677.839763,\"USDCNY\":6.881502,\"USDCOP\":3188,\"USDCRC\":584.995036,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.902497,\"USDCZK\":22.422902,\"USDDJF\":177.720439,\"USDDKK\":6.552298,\"USDDOP\":50.259857,\"USDDZD\":118.724969,\"USDEGP\":16.712039,\"USDERN\":15.000267,\"USDETB\":28.662979,\"USDEUR\":0.87767,\"USDFJD\":2.143549,\"USDFKP\":0.78401,\"USDGBP\":0.785855,\"USDGEL\":2.785011,\"USDGGP\":0.785646,\"USDGHS\":5.4575,\"USDGIP\":0.78401,\"USDGMD\":49.595018,\"USDGNF\":9166.702436,\"USDGTQ\":7.70855,\"USDGYD\":208.920291,\"USDHKD\":7.80795,\"USDHNL\":24.492503,\"USDHRK\":6.492496,\"USDHTG\":93.536014,\"USDHUF\":284.729809,\"USDIDR\":14164,\"USDILS\":3.600894,\"USDIMP\":0.785646,\"USDINR\":69.329888,\"USDIQD\":1193.8,\"USDIRR\":42104.999897,\"USDISK\":124.201015,\"USDJEP\":0.785646,\"USDJMD\":129.659753,\"USDJOD\":0.708995,\"USDJPY\":107.075987,\"USDKES\":102.249877,\"USDKGS\":69.5117,\"USDKHR\":4071.849805,\"USDKMF\":432.325003,\"USDKPW\":900.078543,\"USDKRW\":1154.010099,\"USDKWD\":0.30323,\"USDKYD\":0.833775,\"USDKZT\":379.029726,\"USDLAK\":8723.999651,\"USDLBP\":1512.849943,\"USDLKR\":176.49779,\"USDLRD\":195.049993,\"USDLSL\":14.286468,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38945,\"USDMAD\":9.51405,\"USDMDL\":18.182999,\"USDMGA\":3653.249813,\"USDMKD\":53.994989,\"USDMMK\":1514.750385,\"USDMNT\":2660.944822,\"USDMOP\":8.04445,\"USDMRO\":357.000181,\"USDMUR\":35.360432,\"USDMVR\":15.450305,\"USDMWK\":760.044979,\"USDMXN\":19.224101,\"USDMYR\":4.137603,\"USDMZN\":62.020517,\"USDNAD\":14.446685,\"USDNGN\":360.669938,\"USDNIO\":32.975005,\"USDNOK\":8.512974,\"USDNPR\":111.100107,\"USDNZD\":1.504395,\"USDOMR\":0.385045,\"USDPAB\":1.00035,\"USDPEN\":3.30085,\"USDPGK\":3.387795,\"USDPHP\":51.362497,\"USDPKR\":157.350321,\"USDPLN\":3.73565,\"USDPYG\":6205.850178,\"USDQAR\":3.64125,\"USDRON\":4.141898,\"USDRSD\":103.469943,\"USDRUB\":62.767502,\"USDRWF\":911.52,\"USDSAR\":3.75045,\"USDSBD\":8.217251,\"USDSCR\":13.6605,\"USDSDG\":45.133987,\"USDSEK\":9.25635,\"USDSGD\":1.35353,\"USDSHP\":1.320905,\"USDSLL\":8901.999985,\"USDSOS\":580.000186,\"USDSRD\":7.458015,\"USDSTD\":21050.59961,\"USDSVC\":8.754299,\"USDSYP\":515.00025,\"USDSZL\":14.286498,\"USDTHB\":30.710422,\"USDTJS\":9.43445,\"USDTMT\":3.5,\"USDTND\":2.85675,\"USDTOP\":2.28445,\"USDTRY\":5.778655,\"USDTTD\":6.776749,\"USDTWD\":31.055019,\"USDTZS\":2300.190721,\"USDUAH\":26.155984,\"USDUGX\":3711.750332,\"USDUSD\":1,\"USDUYU\":35.221031,\"USDUZS\":8563.549928,\"USDVEF\":9.987499,\"USDVND\":23307.6,\"USDVUV\":116.0618,\"USDWST\":2.626037,\"USDXAF\":576.439752,\"USDXAG\":0.065007,\"USDXAU\":0.000701,\"USDXCD\":2.70255,\"USDXDR\":0.71885,\"USDXOF\":576.439867,\"USDXPF\":104.796063,\"USDYER\":250.350429,\"USDZAR\":14.313902,\"USDZMK\":9001.202255,\"USDZMW\":12.980985,\"USDZWL\":322.355011}}', 1, '2019-06-25 12:59:04', '2019-06-25 13:13:41', '2019-06-25 13:13:41', 'USD'),
(782, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561470845,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.69797,\"USDALL\":107.080318,\"USDAMD\":477.069933,\"USDANG\":1.875905,\"USDAOA\":340.272026,\"USDARS\":42.450903,\"USDAUD\":1.43445,\"USDAWG\":1.80125,\"USDAZN\":1.704977,\"USDBAM\":1.71865,\"USDBBD\":2.02005,\"USDBDT\":84.534044,\"USDBGN\":1.716451,\"USDBHD\":0.37675,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35035,\"USDBOB\":6.91325,\"USDBRL\":3.836096,\"USDBSD\":1.0004,\"USDBTC\":0.000088550045,\"USDBTN\":69.316183,\"USDBWP\":10.666013,\"USDBYN\":2.038399,\"USDBYR\":19600,\"USDBZD\":2.016602,\"USDCAD\":1.316685,\"USDCDF\":1660.99993,\"USDCHF\":0.972975,\"USDCLF\":0.024546,\"USDCLP\":677.301691,\"USDCNY\":6.880699,\"USDCOP\":3188,\"USDCRC\":584.995001,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.902503,\"USDCZK\":22.42145,\"USDDJF\":177.719909,\"USDDKK\":6.55374,\"USDDOP\":50.25982,\"USDDZD\":118.724986,\"USDEGP\":16.699401,\"USDERN\":14.999778,\"USDETB\":28.663006,\"USDEUR\":0.877845,\"USDFJD\":2.14355,\"USDFKP\":0.78397,\"USDGBP\":0.78598,\"USDGEL\":2.785025,\"USDGGP\":0.785807,\"USDGHS\":5.457501,\"USDGIP\":0.78404,\"USDGMD\":49.594969,\"USDGNF\":9166.703383,\"USDGTQ\":7.70855,\"USDGYD\":208.919888,\"USDHKD\":7.81014,\"USDHNL\":24.492501,\"USDHRK\":6.495298,\"USDHTG\":93.535973,\"USDHUF\":283.969033,\"USDIDR\":14157.5,\"USDILS\":3.597702,\"USDIMP\":0.785807,\"USDINR\":69.348502,\"USDIQD\":1193.8,\"USDIRR\":42104.999741,\"USDISK\":124.220543,\"USDJEP\":0.785807,\"USDJMD\":129.659897,\"USDJOD\":0.708987,\"USDJPY\":107.021997,\"USDKES\":102.179686,\"USDKGS\":69.511702,\"USDKHR\":4071.849818,\"USDKMF\":432.324976,\"USDKPW\":900.078332,\"USDKRW\":1153.75031,\"USDKWD\":0.3032,\"USDKYD\":0.833775,\"USDKZT\":379.03008,\"USDLAK\":8723.999931,\"USDLBP\":1512.849988,\"USDLKR\":176.497058,\"USDLRD\":195.050184,\"USDLSL\":14.302353,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38945,\"USDMAD\":9.522398,\"USDMDL\":18.182995,\"USDMGA\":3653.24992,\"USDMKD\":54.014979,\"USDMMK\":1514.750161,\"USDMNT\":2661.268186,\"USDMOP\":8.04445,\"USDMRO\":356.999765,\"USDMUR\":35.398478,\"USDMVR\":15.450286,\"USDMWK\":759.889785,\"USDMXN\":19.213098,\"USDMYR\":4.135499,\"USDMZN\":62.019453,\"USDNAD\":14.402471,\"USDNGN\":360.670193,\"USDNIO\":32.974985,\"USDNOK\":8.507955,\"USDNPR\":111.097792,\"USDNZD\":1.504395,\"USDOMR\":0.38496,\"USDPAB\":1.00035,\"USDPEN\":3.300198,\"USDPGK\":3.387799,\"USDPHP\":51.358502,\"USDPKR\":157.349576,\"USDPLN\":3.73543,\"USDPYG\":6205.84976,\"USDQAR\":3.64125,\"USDRON\":4.143195,\"USDRSD\":103.532476,\"USDRUB\":62.836502,\"USDRWF\":911.52,\"USDSAR\":3.748797,\"USDSBD\":8.21725,\"USDSCR\":13.658008,\"USDSDG\":45.133992,\"USDSEK\":9.25925,\"USDSGD\":1.353265,\"USDSHP\":1.320896,\"USDSLL\":8901.999855,\"USDSOS\":580.000173,\"USDSRD\":7.457978,\"USDSTD\":21050.59961,\"USDSVC\":8.754299,\"USDSYP\":514.999771,\"USDSZL\":14.286504,\"USDTHB\":30.692502,\"USDTJS\":9.43445,\"USDTMT\":3.5,\"USDTND\":2.84695,\"USDTOP\":2.28445,\"USDTRY\":5.771115,\"USDTTD\":6.77675,\"USDTWD\":31.047991,\"USDTZS\":2298.707555,\"USDUAH\":26.156035,\"USDUGX\":3711.749797,\"USDUSD\":1,\"USDUYU\":35.221042,\"USDUZS\":8563.550032,\"USDVEF\":9.987502,\"USDVND\":23307.6,\"USDVUV\":116.060656,\"USDWST\":2.626046,\"USDXAF\":576.439913,\"USDXAG\":0.064779,\"USDXAU\":0.000698,\"USDXCD\":2.70255,\"USDXDR\":0.71865,\"USDXOF\":576.43999,\"USDXPF\":104.798051,\"USDYER\":250.350334,\"USDZAR\":14.306201,\"USDZMK\":9001.200778,\"USDZMW\":12.981012,\"USDZWL\":322.355011}}', 1, '2019-06-25 13:54:05', '2019-06-25 14:34:51', '2019-06-25 14:34:51', 'USD'),
(783, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561474145,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":80.692388,\"USDALL\":107.079942,\"USDAMD\":477.070039,\"USDANG\":1.875906,\"USDAOA\":340.271971,\"USDARS\":42.309903,\"USDAUD\":1.43505,\"USDAWG\":1.80125,\"USDAZN\":1.705041,\"USDBAM\":1.71865,\"USDBBD\":2.02005,\"USDBDT\":84.534,\"USDBGN\":1.71745,\"USDBHD\":0.37695,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350499,\"USDBOB\":6.91325,\"USDBRL\":3.8325,\"USDBSD\":1.0004,\"USDBTC\":0.000088386531,\"USDBTN\":69.246027,\"USDBWP\":10.666048,\"USDBYN\":2.038396,\"USDBYR\":19600,\"USDBZD\":2.016601,\"USDCAD\":1.31749,\"USDCDF\":1660.999758,\"USDCHF\":0.97235,\"USDCLF\":0.024551,\"USDCLP\":677.598816,\"USDCNY\":6.8791,\"USDCOP\":3187.9,\"USDCRC\":584.995024,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":96.902506,\"USDCZK\":22.410297,\"USDDJF\":177.72014,\"USDDKK\":6.55462,\"USDDOP\":50.259776,\"USDDZD\":118.735002,\"USDEGP\":16.691801,\"USDERN\":14.999837,\"USDETB\":28.662964,\"USDEUR\":0.87802,\"USDFJD\":2.14355,\"USDFKP\":0.783985,\"USDGBP\":0.78588,\"USDGEL\":2.785036,\"USDGGP\":0.786037,\"USDGHS\":5.457501,\"USDGIP\":0.784015,\"USDGMD\":49.594977,\"USDGNF\":9166.69471,\"USDGTQ\":7.70855,\"USDGYD\":208.919974,\"USDHKD\":7.81075,\"USDHNL\":24.492495,\"USDHRK\":6.492704,\"USDHTG\":93.535977,\"USDHUF\":283.855967,\"USDIDR\":14154,\"USDILS\":3.59299,\"USDIMP\":0.786037,\"USDINR\":69.245801,\"USDIQD\":1193.8,\"USDIRR\":42105.000131,\"USDISK\":124.240142,\"USDJEP\":0.786037,\"USDJMD\":129.659653,\"USDJOD\":0.708963,\"USDJPY\":106.9235,\"USDKES\":102.154974,\"USDKGS\":69.511697,\"USDKHR\":4071.85046,\"USDKMF\":432.324991,\"USDKPW\":900.076385,\"USDKRW\":1154.090216,\"USDKWD\":0.303201,\"USDKYD\":0.833775,\"USDKZT\":379.029797,\"USDLAK\":8723.999863,\"USDLBP\":1512.849684,\"USDLKR\":176.490528,\"USDLRD\":195.050022,\"USDLSL\":14.292473,\"USDLTL\":2.95274,\"USDLVL\":0.604891,\"USDLYD\":1.38945,\"USDMAD\":9.5244,\"USDMDL\":18.182989,\"USDMGA\":3653.249772,\"USDMKD\":54.039723,\"USDMMK\":1514.750087,\"USDMNT\":2661.326833,\"USDMOP\":8.04445,\"USDMRO\":356.999677,\"USDMUR\":35.349719,\"USDMVR\":15.449565,\"USDMWK\":759.970129,\"USDMXN\":19.225798,\"USDMYR\":4.132989,\"USDMZN\":62.01979,\"USDNAD\":14.400296,\"USDNGN\":360.670218,\"USDNIO\":32.974996,\"USDNOK\":8.516939,\"USDNPR\":111.101294,\"USDNZD\":1.503605,\"USDOMR\":0.384974,\"USDPAB\":1.00035,\"USDPEN\":3.29865,\"USDPGK\":3.387802,\"USDPHP\":51.402238,\"USDPKR\":157.349787,\"USDPLN\":3.73565,\"USDPYG\":6205.84967,\"USDQAR\":3.64125,\"USDRON\":4.14195,\"USDRSD\":103.520332,\"USDRUB\":62.8853,\"USDRWF\":911.52,\"USDSAR\":3.750804,\"USDSBD\":8.21725,\"USDSCR\":13.660524,\"USDSDG\":45.134026,\"USDSEK\":9.26294,\"USDSGD\":1.352981,\"USDSHP\":1.320899,\"USDSLL\":8901.999943,\"USDSOS\":579.999987,\"USDSRD\":7.457998,\"USDSTD\":21050.59961,\"USDSVC\":8.7543,\"USDSYP\":515.000051,\"USDSZL\":14.286501,\"USDTHB\":30.714498,\"USDTJS\":9.43445,\"USDTMT\":3.5,\"USDTND\":2.847451,\"USDTOP\":2.28445,\"USDTRY\":5.7622,\"USDTTD\":6.77675,\"USDTWD\":31.08496,\"USDTZS\":2298.402544,\"USDUAH\":26.156057,\"USDUGX\":3711.750083,\"USDUSD\":1,\"USDUYU\":35.22097,\"USDUZS\":8563.549535,\"USDVEF\":9.9875,\"USDVND\":23307.6,\"USDVUV\":116.058514,\"USDWST\":2.625918,\"USDXAF\":576.440254,\"USDXAG\":0.064779,\"USDXAU\":0.000699,\"USDXCD\":2.70255,\"USDXDR\":0.718534,\"USDXOF\":576.440529,\"USDXPF\":104.799932,\"USDYER\":250.349694,\"USDZAR\":14.29703,\"USDZMK\":9001.20702,\"USDZMW\":12.981015,\"USDZWL\":322.355011}}', 1, '2019-06-25 14:49:05', '2019-06-25 15:34:51', '2019-06-25 15:34:51', 'USD'),
(784, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1561572846,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673007,\"USDAFN\":81.100677,\"USDALL\":107.049688,\"USDAMD\":476.784998,\"USDANG\":1.875201,\"USDAOA\":340.272021,\"USDARS\":42.711503,\"USDAUD\":1.43101,\"USDAWG\":1.8,\"USDAZN\":1.704969,\"USDBAM\":1.720798,\"USDBBD\":2.0193,\"USDBDT\":84.502039,\"USDBGN\":1.719601,\"USDBHD\":0.37697,\"USDBIF\":1837.35,\"USDBMD\":1,\"USDBND\":1.350701,\"USDBOB\":6.91055,\"USDBRL\":3.848967,\"USDBSD\":1.00015,\"USDBTC\":0.000074616397,\"USDBTN\":69.179808,\"USDBWP\":10.680112,\"USDBYN\":2.043697,\"USDBYR\":19600,\"USDBZD\":2.015903,\"USDCAD\":1.31194,\"USDCDF\":1661.000007,\"USDCHF\":0.97758,\"USDCLF\":0.024641,\"USDCLP\":679.910214,\"USDCNY\":6.880106,\"USDCOP\":3171.7,\"USDCRC\":583.924975,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.017503,\"USDCZK\":22.346007,\"USDDJF\":177.720147,\"USDDKK\":6.56258,\"USDDOP\":50.995012,\"USDDZD\":118.665018,\"USDEGP\":16.701978,\"USDERN\":14.999871,\"USDETB\":29.069799,\"USDEUR\":0.879125,\"USDFJD\":2.147498,\"USDFKP\":0.788025,\"USDGBP\":0.78769,\"USDGEL\":2.860101,\"USDGGP\":0.787571,\"USDGHS\":5.449694,\"USDGIP\":0.788025,\"USDGMD\":49.697869,\"USDGNF\":9225.000116,\"USDGTQ\":7.70555,\"USDGYD\":208.949985,\"USDHKD\":7.80667,\"USDHNL\":24.650074,\"USDHRK\":6.501502,\"USDHTG\":93.781977,\"USDHUF\":284.296981,\"USDIDR\":14156,\"USDILS\":3.588697,\"USDIMP\":0.787571,\"USDINR\":69.189028,\"USDIQD\":1190,\"USDIRR\":42104.999932,\"USDISK\":124.579965,\"USDJEP\":0.787571,\"USDJMD\":130.939436,\"USDJOD\":0.708977,\"USDJPY\":107.785498,\"USDKES\":102.155023,\"USDKGS\":69.5988,\"USDKHR\":4069.999737,\"USDKMF\":432.649861,\"USDKPW\":900.067915,\"USDKRW\":1154.429693,\"USDKWD\":0.303403,\"USDKYD\":0.83347,\"USDKZT\":379.81015,\"USDLAK\":8665.999581,\"USDLBP\":1507.850212,\"USDLKR\":176.570326,\"USDLRD\":195.249828,\"USDLSL\":14.290383,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.397294,\"USDMAD\":9.55497,\"USDMDL\":18.151967,\"USDMGA\":3630.000173,\"USDMKD\":54.175502,\"USDMMK\":1518.149859,\"USDMNT\":2661.250307,\"USDMOP\":8.04305,\"USDMRO\":357.0002,\"USDMUR\":35.551989,\"USDMVR\":15.450311,\"USDMWK\":761.229855,\"USDMXN\":19.138501,\"USDMYR\":4.138298,\"USDMZN\":62.035025,\"USDNAD\":14.402383,\"USDNGN\":360.510105,\"USDNIO\":33.400088,\"USDNOK\":8.493625,\"USDNPR\":110.674984,\"USDNZD\":1.49635,\"USDOMR\":0.38501,\"USDPAB\":1.00015,\"USDPEN\":3.30245,\"USDPGK\":3.374973,\"USDPHP\":51.355501,\"USDPKR\":156.897745,\"USDPLN\":3.74559,\"USDPYG\":6213.305048,\"USDQAR\":3.641006,\"USDRON\":4.148705,\"USDRSD\":103.650262,\"USDRUB\":62.973503,\"USDRWF\":911,\"USDSAR\":3.750502,\"USDSBD\":8.24175,\"USDSCR\":13.659501,\"USDSDG\":45.115968,\"USDSEK\":9.26303,\"USDSGD\":1.35327,\"USDSHP\":1.320901,\"USDSLL\":8949.999905,\"USDSOS\":583.000308,\"USDSRD\":7.45801,\"USDSTD\":21050.59961,\"USDSVC\":8.75085,\"USDSYP\":515.00015,\"USDSZL\":14.290062,\"USDTHB\":30.740059,\"USDTJS\":9.43625,\"USDTMT\":3.5,\"USDTND\":2.86695,\"USDTOP\":2.282403,\"USDTRY\":5.775099,\"USDTTD\":6.78055,\"USDTWD\":31.056499,\"USDTZS\":2299.196467,\"USDUAH\":26.181023,\"USDUGX\":3705.273275,\"USDUSD\":1,\"USDUYU\":35.169792,\"USDUZS\":8555.000502,\"USDVEF\":9.987499,\"USDVND\":23305,\"USDVUV\":116.061744,\"USDWST\":2.623279,\"USDXAF\":577.140262,\"USDXAG\":0.065321,\"USDXAU\":0.000709,\"USDXCD\":2.70265,\"USDXDR\":0.719528,\"USDXOF\":577.000362,\"USDXPF\":105.24994,\"USDYER\":250.350161,\"USDZAR\":14.221401,\"USDZMK\":9001.20116,\"USDZMW\":12.875966,\"USDZWL\":322.355011}}', 1, '2019-06-26 18:14:06', '2019-06-26 18:45:55', '2019-06-26 18:45:55', 'USD'),
(785, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1562068925,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":81.353061,\"USDALL\":108.2804,\"USDAMD\":476.509782,\"USDANG\":1.87505,\"USDAOA\":343.840977,\"USDARS\":42.344985,\"USDAUD\":1.42997,\"USDAWG\":1.8,\"USDAZN\":1.705008,\"USDBAM\":1.73095,\"USDBBD\":2.01915,\"USDBDT\":84.496947,\"USDBGN\":1.73125,\"USDBHD\":0.37685,\"USDBIF\":1837.35,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91015,\"USDBRL\":3.84115,\"USDBSD\":0.99995,\"USDBTC\":0.000101,\"USDBTN\":68.952929,\"USDBWP\":10.639935,\"USDBYN\":2.04595,\"USDBYR\":19600,\"USDBZD\":2.01575,\"USDCAD\":1.31165,\"USDCDF\":1660.000199,\"USDCHF\":0.988095,\"USDCLF\":0.024637,\"USDCLP\":679.784946,\"USDCNY\":6.876498,\"USDCOP\":3206.15,\"USDCRC\":579.410361,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.593501,\"USDCZK\":22.529725,\"USDDJF\":177.720005,\"USDDKK\":6.606403,\"USDDOP\":50.790175,\"USDDZD\":119.004978,\"USDEGP\":16.610555,\"USDERN\":15.000243,\"USDETB\":29.140977,\"USDEUR\":0.885125,\"USDFJD\":2.13955,\"USDFKP\":0.792125,\"USDGBP\":0.79193,\"USDGEL\":2.82499,\"USDGGP\":0.791801,\"USDGHS\":5.36765,\"USDGIP\":0.79212,\"USDGMD\":49.695035,\"USDGNF\":9165.24968,\"USDGTQ\":7.705199,\"USDGYD\":208.789938,\"USDHKD\":7.80405,\"USDHNL\":24.4795,\"USDHRK\":6.545902,\"USDHTG\":93.850235,\"USDHUF\":285.954999,\"USDIDR\":14139.5,\"USDILS\":3.575798,\"USDIMP\":0.791801,\"USDINR\":68.955028,\"USDIQD\":1193.25,\"USDIRR\":42104.999647,\"USDISK\":125.429407,\"USDJEP\":0.791801,\"USDJMD\":130.840478,\"USDJOD\":0.708985,\"USDJPY\":108.277501,\"USDKES\":103.010116,\"USDKGS\":69.366099,\"USDKHR\":4107.598792,\"USDKMF\":434.35034,\"USDKPW\":900.064569,\"USDKRW\":1166.497632,\"USDKWD\":0.303977,\"USDKYD\":0.83336,\"USDKZT\":382.510186,\"USDLAK\":8720.250115,\"USDLBP\":1512.299211,\"USDLKR\":176.359922,\"USDLRD\":196.249516,\"USDLSL\":14.079865,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39215,\"USDMAD\":9.609701,\"USDMDL\":18.025501,\"USDMGA\":3653.150264,\"USDMKD\":54.197503,\"USDMMK\":1514.549762,\"USDMNT\":2662.124655,\"USDMOP\":8.036303,\"USDMRO\":357.000484,\"USDMUR\":35.730502,\"USDMVR\":15.502866,\"USDMWK\":760.405021,\"USDMXN\":19.077599,\"USDMYR\":4.137599,\"USDMZN\":62.204978,\"USDNAD\":14.39793,\"USDNGN\":360.509892,\"USDNIO\":32.951498,\"USDNOK\":8.56022,\"USDNPR\":110.394998,\"USDNZD\":1.50075,\"USDOMR\":0.385015,\"USDPAB\":1.00005,\"USDPEN\":3.291598,\"USDPGK\":3.386397,\"USDPHP\":51.13604,\"USDPKR\":156.330019,\"USDPLN\":3.75805,\"USDPYG\":6191.64995,\"USDQAR\":3.64125,\"USDRON\":4.1895,\"USDRSD\":104.329759,\"USDRUB\":63.266495,\"USDRWF\":913.455,\"USDSAR\":3.75085,\"USDSBD\":8.22815,\"USDSCR\":13.65903,\"USDSDG\":45.107014,\"USDSEK\":9.34431,\"USDSGD\":1.355755,\"USDSHP\":1.320898,\"USDSLL\":8925.000267,\"USDSOS\":584.999916,\"USDSRD\":7.457969,\"USDSTD\":21560.79,\"USDSVC\":8.75045,\"USDSYP\":514.999865,\"USDSZL\":14.148971,\"USDTHB\":30.659893,\"USDTJS\":9.43015,\"USDTMT\":3.51,\"USDTND\":2.878703,\"USDTOP\":2.279294,\"USDTRY\":5.660665,\"USDTTD\":6.77185,\"USDTWD\":31.026048,\"USDTZS\":2299.902084,\"USDUAH\":26.180139,\"USDUGX\":3705.049991,\"USDUSD\":1,\"USDUYU\":35.195986,\"USDUZS\":8572.45036,\"USDVEF\":9.987498,\"USDVND\":23240,\"USDVUV\":115.460847,\"USDWST\":2.620532,\"USDXAF\":580.550164,\"USDXAG\":0.066028,\"USDXAU\":0.000718,\"USDXCD\":2.70255,\"USDXDR\":0.721643,\"USDXOF\":580.549851,\"USDXPF\":105.550262,\"USDYER\":250.350042,\"USDZAR\":14.13435,\"USDZMK\":9001.199288,\"USDZMW\":12.836051,\"USDZWL\":322.000001}}', 1, '2019-07-02 12:02:05', '2019-07-02 13:38:39', '2019-07-02 13:38:39', 'USD'),
(786, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1562155326,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67315,\"USDAFN\":81.08503,\"USDALL\":108.050283,\"USDAMD\":476.465027,\"USDANG\":1.87495,\"USDAOA\":343.840979,\"USDARS\":42.161026,\"USDAUD\":1.42461,\"USDAWG\":1.8,\"USDAZN\":1.705015,\"USDBAM\":1.73105,\"USDBBD\":2.01905,\"USDBDT\":84.490967,\"USDBGN\":1.732197,\"USDBHD\":0.37695,\"USDBIF\":1837.7,\"USDBMD\":1,\"USDBND\":1.350605,\"USDBOB\":6.914751,\"USDBRL\":3.856705,\"USDBSD\":0.99995,\"USDBTC\":0.000089279305,\"USDBTN\":68.863202,\"USDBWP\":10.615499,\"USDBYN\":2.04995,\"USDBYR\":19600,\"USDBZD\":2.01555,\"USDCAD\":1.30974,\"USDCDF\":1661.000199,\"USDCHF\":0.98426,\"USDCLF\":0.024619,\"USDCLP\":679.802706,\"USDCNY\":6.880602,\"USDCOP\":3210.85,\"USDCRC\":578.360055,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.627497,\"USDCZK\":22.540338,\"USDDJF\":177.720088,\"USDDKK\":6.61015,\"USDDOP\":50.804997,\"USDDZD\":119.125031,\"USDEGP\":16.6165,\"USDERN\":14.999702,\"USDETB\":28.853501,\"USDEUR\":0.885596,\"USDFJD\":2.137299,\"USDFKP\":0.795535,\"USDGBP\":0.79498,\"USDGEL\":2.814985,\"USDGGP\":0.795062,\"USDGHS\":5.3716,\"USDGIP\":0.795535,\"USDGMD\":49.695022,\"USDGNF\":9165.349931,\"USDGTQ\":7.704502,\"USDGYD\":208.819884,\"USDHKD\":7.79714,\"USDHNL\":24.476502,\"USDHRK\":6.549602,\"USDHTG\":93.89199,\"USDHUF\":285.640389,\"USDIDR\":14141,\"USDILS\":3.571198,\"USDIMP\":0.795062,\"USDINR\":68.86775,\"USDIQD\":1193.15,\"USDIRR\":42104.999934,\"USDISK\":125.509582,\"USDJEP\":0.795062,\"USDJMD\":131.189908,\"USDJOD\":0.70901,\"USDJPY\":107.674977,\"USDKES\":102.310141,\"USDKGS\":69.472503,\"USDKHR\":4070.804102,\"USDKMF\":435.850217,\"USDKPW\":900.061798,\"USDKRW\":1169.13023,\"USDKWD\":0.303898,\"USDKYD\":0.833245,\"USDKZT\":384.604983,\"USDLAK\":8719.598384,\"USDLBP\":1511.949561,\"USDLKR\":176.05978,\"USDLRD\":196.825005,\"USDLSL\":14.098454,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39415,\"USDMAD\":9.57485,\"USDMDL\":17.973498,\"USDMGA\":3654.749781,\"USDMKD\":54.201503,\"USDMMK\":1511.398196,\"USDMNT\":2660.985506,\"USDMOP\":8.03015,\"USDMRO\":356.99991,\"USDMUR\":35.8985,\"USDMVR\":15.490753,\"USDMWK\":761.09968,\"USDMXN\":19.026503,\"USDMYR\":4.142502,\"USDMZN\":62.219618,\"USDNAD\":14.096786,\"USDNGN\":360.740121,\"USDNIO\":32.947502,\"USDNOK\":8.551299,\"USDNPR\":110.075008,\"USDNZD\":1.49475,\"USDOMR\":0.38501,\"USDPAB\":0.9998,\"USDPEN\":3.294902,\"USDPGK\":3.386103,\"USDPHP\":51.178011,\"USDPKR\":156.050032,\"USDPLN\":3.75768,\"USDPYG\":6202.150255,\"USDQAR\":3.64125,\"USDRON\":4.193398,\"USDRSD\":104.249855,\"USDRUB\":63.598501,\"USDRWF\":913.42,\"USDSAR\":3.75075,\"USDSBD\":8.24175,\"USDSCR\":13.659501,\"USDSDG\":45.108,\"USDSEK\":9.30723,\"USDSGD\":1.356165,\"USDSHP\":1.320897,\"USDSLL\":8900.000242,\"USDSOS\":582.496305,\"USDSRD\":7.457997,\"USDSTD\":21560.79,\"USDSVC\":8.749202,\"USDSYP\":514.99995,\"USDSZL\":14.084986,\"USDTHB\":30.57198,\"USDTJS\":9.44045,\"USDTMT\":3.5,\"USDTND\":2.88085,\"USDTOP\":2.279299,\"USDTRY\":5.64093,\"USDTTD\":6.77105,\"USDTWD\":31.093046,\"USDTZS\":2300.000264,\"USDUAH\":26.0145,\"USDUGX\":3699.79767,\"USDUSD\":1,\"USDUYU\":35.103503,\"USDUZS\":8571.697294,\"USDVEF\":9.987503,\"USDVND\":23249.25,\"USDVUV\":115.460698,\"USDWST\":2.618474,\"USDXAF\":580.604424,\"USDXAG\":0.065671,\"USDXAU\":0.000705,\"USDXCD\":2.70255,\"USDXDR\":0.72165,\"USDXOF\":580.589594,\"USDXPF\":105.559817,\"USDYER\":250.300773,\"USDZAR\":14.11125,\"USDZMK\":9001.208699,\"USDZMW\":12.844997,\"USDZWL\":322.000001}}', 1, '2019-07-03 12:02:06', '2019-07-03 14:11:42', '2019-07-03 14:11:42', 'USD'),
(787, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1562760124,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67297,\"USDAFN\":81.020499,\"USDALL\":108.67499,\"USDAMD\":476.995016,\"USDANG\":1.780238,\"USDAOA\":345.928504,\"USDARS\":41.803995,\"USDAUD\":1.444935,\"USDAWG\":1.801,\"USDAZN\":1.705019,\"USDBAM\":1.743602,\"USDBBD\":2.0191,\"USDBDT\":84.493498,\"USDBGN\":1.744002,\"USDBHD\":0.376855,\"USDBIF\":1837.95,\"USDBMD\":1,\"USDBND\":1.36125,\"USDBOB\":6.909902,\"USDBRL\":3.80425,\"USDBSD\":0.99998,\"USDBTC\":0.000076853076,\"USDBTN\":68.595407,\"USDBWP\":10.672496,\"USDBYN\":2.04395,\"USDBYR\":19600,\"USDBZD\":2.015698,\"USDCAD\":1.31183,\"USDCDF\":1664.999834,\"USDCHF\":0.992099,\"USDCLF\":0.024919,\"USDCLP\":687.590164,\"USDCNY\":6.883102,\"USDCOP\":3218,\"USDCRC\":581.719749,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.306977,\"USDCZK\":22.795955,\"USDDJF\":177.72002,\"USDDKK\":6.655401,\"USDDOP\":50.783997,\"USDDZD\":119.41499,\"USDEGP\":16.640081,\"USDERN\":14.99972,\"USDETB\":28.854499,\"USDEUR\":0.89166,\"USDFJD\":2.14875,\"USDFKP\":0.79698,\"USDGBP\":0.801745,\"USDGEL\":2.845023,\"USDGGP\":0.80181,\"USDGHS\":5.399901,\"USDGIP\":0.79698,\"USDGMD\":49.919972,\"USDGNF\":9167.849852,\"USDGTQ\":7.679896,\"USDGYD\":209.114974,\"USDHKD\":7.81575,\"USDHNL\":24.466495,\"USDHRK\":6.594029,\"USDHTG\":93.911503,\"USDHUF\":290.720025,\"USDIDR\":14140,\"USDILS\":3.57295,\"USDIMP\":0.80181,\"USDINR\":68.607503,\"USDIQD\":1193.15,\"USDIRR\":42104.999924,\"USDISK\":126.503338,\"USDJEP\":0.80181,\"USDJMD\":133.32501,\"USDJOD\":0.709007,\"USDJPY\":108.931995,\"USDKES\":102.822102,\"USDKGS\":69.844297,\"USDKHR\":4076.950016,\"USDKMF\":439.612404,\"USDKPW\":900.068836,\"USDKRW\":1181.409805,\"USDKWD\":0.30448,\"USDKYD\":0.83338,\"USDKZT\":384.364962,\"USDLAK\":8733.849909,\"USDLBP\":1512.000176,\"USDLKR\":175.611637,\"USDLRD\":198.750087,\"USDLSL\":14.180348,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39965,\"USDMAD\":9.580097,\"USDMDL\":17.874499,\"USDMGA\":3662.950582,\"USDMKD\":54.969952,\"USDMMK\":1512.449768,\"USDMNT\":2661.251799,\"USDMOP\":8.050397,\"USDMRO\":357.000076,\"USDMUR\":35.950215,\"USDMVR\":15.450089,\"USDMWK\":775.405011,\"USDMXN\":19.16924,\"USDMYR\":4.138503,\"USDMZN\":62.165039,\"USDNAD\":14.179781,\"USDNGN\":360.00018,\"USDNIO\":32.95905,\"USDNOK\":8.64233,\"USDNPR\":109.704961,\"USDNZD\":1.515605,\"USDOMR\":0.385005,\"USDPAB\":1.00001,\"USDPEN\":3.29395,\"USDPGK\":3.386204,\"USDPHP\":51.470497,\"USDPKR\":158.37496,\"USDPLN\":3.81025,\"USDPYG\":6106.899903,\"USDQAR\":3.640984,\"USDRON\":4.220898,\"USDRSD\":104.970378,\"USDRUB\":63.587017,\"USDRWF\":913.795,\"USDSAR\":3.75035,\"USDSBD\":8.20785,\"USDSCR\":13.660503,\"USDSDG\":45.1125,\"USDSEK\":9.46334,\"USDSGD\":1.361401,\"USDSHP\":1.3209,\"USDSLL\":8899.999787,\"USDSOS\":582.504144,\"USDSRD\":7.457986,\"USDSTD\":21560.79,\"USDSVC\":8.75015,\"USDSYP\":515.00007,\"USDSZL\":14.184499,\"USDTHB\":30.839947,\"USDTJS\":9.42955,\"USDTMT\":3.51,\"USDTND\":2.895499,\"USDTOP\":2.287098,\"USDTRY\":5.749898,\"USDTTD\":6.784103,\"USDTWD\":31.096496,\"USDTZS\":2298.99988,\"USDUAH\":25.832497,\"USDUGX\":3686.882409,\"USDUSD\":1,\"USDUYU\":35.174497,\"USDUZS\":8575.700833,\"USDVEF\":9.9875,\"USDVND\":23219.3,\"USDVUV\":115.0202,\"USDWST\":2.631613,\"USDXAF\":584.790056,\"USDXAG\":0.066205,\"USDXAU\":0.000717,\"USDXCD\":2.70255,\"USDXDR\":0.724451,\"USDXOF\":584.797727,\"USDXPF\":106.309687,\"USDYER\":249.903673,\"USDZAR\":14.17809,\"USDZMK\":9001.204962,\"USDZMW\":12.549499,\"USDZWL\":322.000001}}', 1, '2019-07-10 12:02:04', '2019-07-10 12:24:32', '2019-07-10 12:24:32', 'USD'),
(788, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1562846524,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67294,\"USDAFN\":80.8445,\"USDALL\":108.239861,\"USDAMD\":476.839517,\"USDANG\":1.77935,\"USDAOA\":345.928501,\"USDARS\":41.846984,\"USDAUD\":1.43152,\"USDAWG\":1.801,\"USDAZN\":1.705047,\"USDBAM\":1.73455,\"USDBBD\":2.01835,\"USDBDT\":84.463017,\"USDBGN\":1.735003,\"USDBHD\":0.37703,\"USDBIF\":1837.25,\"USDBMD\":1,\"USDBND\":1.35515,\"USDBOB\":6.90735,\"USDBRL\":3.780202,\"USDBSD\":0.99967,\"USDBTC\":0.000086126027,\"USDBTN\":68.395068,\"USDBWP\":10.55598,\"USDBYN\":2.03265,\"USDBYR\":19600,\"USDBZD\":2.01485,\"USDCAD\":1.305605,\"USDCDF\":1664.99974,\"USDCHF\":0.985701,\"USDCLF\":0.024818,\"USDCLP\":684.795022,\"USDCNY\":6.865901,\"USDCOP\":3204.75,\"USDCRC\":581.47504,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.793987,\"USDCZK\":22.706798,\"USDDJF\":177.719916,\"USDDKK\":6.6202,\"USDDOP\":50.785498,\"USDDZD\":119.175033,\"USDEGP\":16.600403,\"USDERN\":15.000054,\"USDETB\":28.844503,\"USDEUR\":0.886585,\"USDFJD\":2.14275,\"USDFKP\":0.79468,\"USDGBP\":0.796395,\"USDGEL\":2.855006,\"USDGGP\":0.796206,\"USDGHS\":5.36795,\"USDGIP\":0.79468,\"USDGMD\":49.724979,\"USDGNF\":9163.049942,\"USDGTQ\":7.674501,\"USDGYD\":208.84977,\"USDHKD\":7.82165,\"USDHNL\":24.460503,\"USDHRK\":6.555999,\"USDHTG\":93.890074,\"USDHUF\":288.901026,\"USDIDR\":14053.5,\"USDILS\":3.550402,\"USDIMP\":0.796206,\"USDINR\":68.390305,\"USDIQD\":1192.8,\"USDIRR\":42105.000119,\"USDISK\":125.840193,\"USDJEP\":0.796206,\"USDJMD\":133.035052,\"USDJOD\":0.708991,\"USDJPY\":108.093014,\"USDKES\":103.02002,\"USDKGS\":69.707898,\"USDKHR\":4075.449608,\"USDKMF\":439.600622,\"USDKPW\":900.072544,\"USDKRW\":1173.539699,\"USDKWD\":0.30424,\"USDKYD\":0.83301,\"USDKZT\":383.194987,\"USDLAK\":8730.717366,\"USDLBP\":1511.649672,\"USDLKR\":175.32503,\"USDLRD\":198.749709,\"USDLSL\":14.180115,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.399802,\"USDMAD\":9.565096,\"USDMDL\":17.794032,\"USDMGA\":3661.550162,\"USDMKD\":54.663499,\"USDMMK\":1511.904939,\"USDMNT\":2658.429161,\"USDMOP\":8.05315,\"USDMRO\":356.999667,\"USDMUR\":35.793403,\"USDMVR\":15.45024,\"USDMWK\":775.015025,\"USDMXN\":19.14353,\"USDMYR\":4.115497,\"USDMZN\":62.189653,\"USDNAD\":14.397857,\"USDNGN\":359.859797,\"USDNIO\":32.946501,\"USDNOK\":8.53658,\"USDNPR\":109.320284,\"USDNZD\":1.49772,\"USDOMR\":0.385071,\"USDPAB\":0.999635,\"USDPEN\":3.28575,\"USDPGK\":3.38495,\"USDPHP\":51.225503,\"USDPKR\":158.74003,\"USDPLN\":3.78461,\"USDPYG\":6051.204905,\"USDQAR\":3.64175,\"USDRON\":4.19712,\"USDRSD\":104.369991,\"USDRUB\":62.972603,\"USDRWF\":913.57,\"USDSAR\":3.750494,\"USDSBD\":8.24175,\"USDSCR\":13.6615,\"USDSDG\":45.096498,\"USDSEK\":9.37645,\"USDSGD\":1.35519,\"USDSHP\":1.3209,\"USDSLL\":8900.00031,\"USDSOS\":582.50406,\"USDSRD\":7.458014,\"USDSTD\":21560.79,\"USDSVC\":8.74685,\"USDSYP\":515.000317,\"USDSZL\":13.893498,\"USDTHB\":30.608497,\"USDTJS\":9.43215,\"USDTMT\":3.5,\"USDTND\":2.895502,\"USDTOP\":2.282904,\"USDTRY\":5.67134,\"USDTTD\":6.7754,\"USDTWD\":31.023021,\"USDTZS\":2297.050259,\"USDUAH\":25.804978,\"USDUGX\":3691.497158,\"USDUSD\":1,\"USDUYU\":35.201505,\"USDUZS\":8572.949866,\"USDVEF\":9.987498,\"USDVND\":23193.6,\"USDVUV\":115.02068,\"USDWST\":2.62397,\"USDXAF\":581.729684,\"USDXAG\":0.065432,\"USDXAU\":0.000704,\"USDXCD\":2.70255,\"USDXDR\":0.72225,\"USDXOF\":581.729967,\"USDXPF\":105.759906,\"USDYER\":249.897933,\"USDZAR\":13.90325,\"USDZMK\":9001.195038,\"USDZMW\":12.497645,\"USDZWL\":322.000001}}', 1, '2019-07-11 12:02:04', '2019-07-11 15:52:09', '2019-07-11 15:52:09', 'USD'),
(789, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1562932925,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67294,\"USDAFN\":80.864972,\"USDALL\":108.3303,\"USDAMD\":476.919885,\"USDANG\":1.780097,\"USDAOA\":345.928501,\"USDARS\":41.706027,\"USDAUD\":1.43136,\"USDAWG\":1.801,\"USDAZN\":1.704973,\"USDBAM\":1.73735,\"USDBBD\":2.0192,\"USDBDT\":84.498004,\"USDBGN\":1.737597,\"USDBHD\":0.376955,\"USDBIF\":1838.1,\"USDBMD\":1,\"USDBND\":1.360129,\"USDBOB\":6.91025,\"USDBRL\":3.762402,\"USDBSD\":1.00007,\"USDBTC\":0.000085420403,\"USDBTN\":68.629131,\"USDBWP\":10.582498,\"USDBYN\":2.03545,\"USDBYR\":19600,\"USDBZD\":2.01575,\"USDCAD\":1.303435,\"USDCDF\":1667.00018,\"USDCHF\":0.98603,\"USDCLF\":0.024699,\"USDCLP\":682.000301,\"USDCNY\":6.881099,\"USDCOP\":3199.4,\"USDCRC\":580.345013,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.953993,\"USDCZK\":22.726501,\"USDDJF\":177.720025,\"USDDKK\":6.63803,\"USDDOP\":50.811972,\"USDDZD\":119.284956,\"USDEGP\":16.620497,\"USDERN\":14.999847,\"USDETB\":28.711974,\"USDEUR\":0.88894,\"USDFJD\":2.14005,\"USDFKP\":0.79501,\"USDGBP\":0.79787,\"USDGEL\":2.850093,\"USDGGP\":0.797789,\"USDGHS\":5.332703,\"USDGIP\":0.79501,\"USDGMD\":49.72502,\"USDGNF\":9166.849893,\"USDGTQ\":7.677699,\"USDGYD\":209.225025,\"USDHKD\":7.82325,\"USDHNL\":24.466497,\"USDHRK\":6.572599,\"USDHTG\":93.929503,\"USDHUF\":289.624973,\"USDIDR\":14038.05,\"USDILS\":3.55085,\"USDIMP\":0.797789,\"USDINR\":68.638029,\"USDIQD\":1193.25,\"USDIRR\":42104.999748,\"USDISK\":126.110354,\"USDJEP\":0.797789,\"USDJMD\":135.73044,\"USDJOD\":0.709026,\"USDJPY\":108.295013,\"USDKES\":102.950316,\"USDKGS\":69.5733,\"USDKHR\":4076.398706,\"USDKMF\":437.500254,\"USDKPW\":900.080167,\"USDKRW\":1178.909934,\"USDKWD\":0.30435,\"USDKYD\":0.833409,\"USDKZT\":383.624948,\"USDLAK\":8732.649812,\"USDLBP\":1512.249761,\"USDLKR\":175.470054,\"USDLRD\":199.000005,\"USDLSL\":13.970268,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39605,\"USDMAD\":9.573701,\"USDMDL\":17.725495,\"USDMGA\":3663.095264,\"USDMKD\":54.653499,\"USDMMK\":1510.750052,\"USDMNT\":2658.375722,\"USDMOP\":8.05765,\"USDMRO\":356.999831,\"USDMUR\":35.950539,\"USDMVR\":15.399644,\"USDMWK\":772.614989,\"USDMXN\":19.10245,\"USDMYR\":4.112968,\"USDMZN\":62.175062,\"USDNAD\":13.969768,\"USDNGN\":360.719958,\"USDNIO\":32.961504,\"USDNOK\":8.5503,\"USDNPR\":109.530193,\"USDNZD\":1.500555,\"USDOMR\":0.385015,\"USDPAB\":1.000075,\"USDPEN\":3.286297,\"USDPGK\":3.38645,\"USDPHP\":51.149898,\"USDPKR\":159.098512,\"USDPLN\":3.79015,\"USDPYG\":6040.150159,\"USDQAR\":3.64075,\"USDRON\":4.207202,\"USDRSD\":104.589699,\"USDRUB\":63.075502,\"USDRWF\":914.075,\"USDSAR\":3.75055,\"USDSBD\":8.23935,\"USDSCR\":13.659738,\"USDSDG\":45.113022,\"USDSEK\":9.380196,\"USDSGD\":1.360201,\"USDSHP\":1.320898,\"USDSLL\":8925.000095,\"USDSOS\":584.000269,\"USDSRD\":7.458032,\"USDSTD\":21560.79,\"USDSVC\":8.7507,\"USDSYP\":515.00052,\"USDSZL\":13.958018,\"USDTHB\":30.921991,\"USDTJS\":9.43005,\"USDTMT\":3.51,\"USDTND\":2.885008,\"USDTOP\":2.280303,\"USDTRY\":5.721305,\"USDTTD\":6.78125,\"USDTWD\":31.080966,\"USDTZS\":2300.099858,\"USDUAH\":25.7785,\"USDUGX\":3695.100062,\"USDUSD\":1,\"USDUYU\":35.11699,\"USDUZS\":8559.250031,\"USDVEF\":9.9875,\"USDVND\":23201.75,\"USDVUV\":115.45998,\"USDWST\":2.619846,\"USDXAF\":582.700271,\"USDXAG\":0.066107,\"USDXAU\":0.000711,\"USDXCD\":2.702551,\"USDXDR\":0.72295,\"USDXOF\":582.698228,\"USDXPF\":105.919714,\"USDYER\":250.350372,\"USDZAR\":13.970897,\"USDZMK\":9001.201677,\"USDZMW\":12.475501,\"USDZWL\":322.000001}}', 1, '2019-07-12 12:02:05', '2019-07-12 12:51:39', '2019-07-12 12:51:39', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(790, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563192126,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673102,\"USDAFN\":80.984503,\"USDALL\":108.219775,\"USDAMD\":476.964989,\"USDANG\":1.780198,\"USDAOA\":345.928498,\"USDARS\":41.570966,\"USDAUD\":1.422799,\"USDAWG\":1.8,\"USDAZN\":1.705017,\"USDBAM\":1.73445,\"USDBBD\":2.01935,\"USDBDT\":84.507033,\"USDBGN\":1.734697,\"USDBHD\":0.37698,\"USDBIF\":1838.3,\"USDBMD\":1,\"USDBND\":1.356402,\"USDBOB\":6.91095,\"USDBRL\":3.73065,\"USDBSD\":1.000175,\"USDBTC\":0.00009695896,\"USDBTN\":68.541588,\"USDBWP\":10.583497,\"USDBYN\":2.026987,\"USDBYR\":19600,\"USDBZD\":2.016026,\"USDCAD\":1.303498,\"USDCDF\":1664.999996,\"USDCHF\":0.982795,\"USDCLF\":0.02462,\"USDCLP\":679.349783,\"USDCNY\":6.875802,\"USDCOP\":3193.15,\"USDCRC\":579.924971,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.790131,\"USDCZK\":22.705995,\"USDDJF\":177.720273,\"USDDKK\":6.62876,\"USDDOP\":50.757499,\"USDDZD\":119.124993,\"USDEGP\":16.6285,\"USDERN\":14.999837,\"USDETB\":29.159501,\"USDEUR\":0.88774,\"USDFJD\":2.133597,\"USDFKP\":0.79541,\"USDGBP\":0.79753,\"USDGEL\":2.839752,\"USDGGP\":0.79746,\"USDGHS\":5.363201,\"USDGIP\":0.79541,\"USDGMD\":49.724985,\"USDGNF\":9167.798924,\"USDGTQ\":7.67855,\"USDGYD\":209.244997,\"USDHKD\":7.827025,\"USDHNL\":24.473503,\"USDHRK\":6.563498,\"USDHTG\":93.940982,\"USDHUF\":289.165026,\"USDIDR\":13944.5,\"USDILS\":3.538499,\"USDIMP\":0.79746,\"USDINR\":68.519021,\"USDIQD\":1193.4,\"USDIRR\":42104.999977,\"USDISK\":125.809838,\"USDJEP\":0.79746,\"USDJMD\":135.320237,\"USDJOD\":0.708978,\"USDJPY\":107.953504,\"USDKES\":103.097333,\"USDKGS\":69.567015,\"USDKHR\":4072.55039,\"USDKMF\":437.950176,\"USDKPW\":900.077626,\"USDKRW\":1179.76498,\"USDKWD\":0.30435,\"USDKYD\":0.833435,\"USDKZT\":382.980064,\"USDLAK\":8735.197781,\"USDLBP\":1512.401767,\"USDLKR\":175.724973,\"USDLRD\":199.74933,\"USDLSL\":14.00027,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39585,\"USDMAD\":9.545897,\"USDMDL\":17.694997,\"USDMGA\":3652.949996,\"USDMKD\":54.605047,\"USDMMK\":1511.203172,\"USDMNT\":2658.11202,\"USDMOP\":8.06255,\"USDMRO\":357.000346,\"USDMUR\":35.849712,\"USDMVR\":15.449729,\"USDMWK\":773.589766,\"USDMXN\":18.94261,\"USDMYR\":4.109501,\"USDMZN\":62.125025,\"USDNAD\":14.000616,\"USDNGN\":360.049977,\"USDNIO\":32.964498,\"USDNOK\":8.54159,\"USDNPR\":109.620209,\"USDNZD\":1.48734,\"USDOMR\":0.38498,\"USDPAB\":1.00014,\"USDPEN\":3.28495,\"USDPGK\":3.38675,\"USDPHP\":51.035033,\"USDPKR\":159.549549,\"USDPLN\":3.78324,\"USDPYG\":6010.910014,\"USDQAR\":3.64175,\"USDRON\":4.20212,\"USDRSD\":104.505037,\"USDRUB\":62.633017,\"USDRWF\":914.31,\"USDSAR\":3.750497,\"USDSBD\":8.2735,\"USDSCR\":13.659498,\"USDSDG\":45.1185,\"USDSEK\":9.37165,\"USDSGD\":1.356395,\"USDSHP\":1.320901,\"USDSLL\":8950.000041,\"USDSOS\":584.495628,\"USDSRD\":7.457978,\"USDSTD\":21560.79,\"USDSVC\":8.75115,\"USDSYP\":514.999634,\"USDSZL\":13.884983,\"USDTHB\":30.900501,\"USDTJS\":9.43665,\"USDTMT\":3.5,\"USDTND\":2.886978,\"USDTOP\":2.277198,\"USDTRY\":5.702455,\"USDTTD\":6.783202,\"USDTWD\":31.062019,\"USDTZS\":2300.39651,\"USDUAH\":25.767996,\"USDUGX\":3693.501476,\"USDUSD\":1,\"USDUYU\":35.14994,\"USDUZS\":8580.050383,\"USDVEF\":9.987495,\"USDVND\":23204.55,\"USDVUV\":115.460674,\"USDWST\":2.614367,\"USDXAF\":581.720157,\"USDXAG\":0.065338,\"USDXAU\":0.000707,\"USDXCD\":2.70255,\"USDXDR\":0.72215,\"USDXOF\":581.720555,\"USDXPF\":105.759911,\"USDYER\":250.301965,\"USDZAR\":13.86635,\"USDZMK\":9001.204263,\"USDZMW\":12.506499,\"USDZWL\":322.000001}}', 1, '2019-07-15 12:02:06', '2019-07-15 17:17:14', '2019-07-15 17:17:14', 'USD'),
(791, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563278525,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":81.041039,\"USDALL\":108.779869,\"USDAMD\":476.584976,\"USDANG\":1.78025,\"USDAOA\":345.928505,\"USDARS\":42.385007,\"USDAUD\":1.42245,\"USDAWG\":1.801,\"USDAZN\":1.705028,\"USDBAM\":1.74295,\"USDBBD\":2.0195,\"USDBDT\":84.476981,\"USDBGN\":1.74295,\"USDBHD\":0.37695,\"USDBIF\":1839.25,\"USDBMD\":1,\"USDBND\":1.35098,\"USDBOB\":6.90875,\"USDBRL\":3.75255,\"USDBSD\":1.00017,\"USDBTC\":0.000093290065,\"USDBTN\":68.691238,\"USDBWP\":10.583998,\"USDBYN\":2.03295,\"USDBYR\":19600,\"USDBZD\":2.01615,\"USDCAD\":1.30522,\"USDCDF\":1665.999974,\"USDCHF\":0.98724,\"USDCLF\":0.024619,\"USDCLP\":679.310166,\"USDCNY\":6.8774,\"USDCOP\":3190.95,\"USDCRC\":576.115006,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.268023,\"USDCZK\":22.793029,\"USDDJF\":177.719831,\"USDDKK\":6.65593,\"USDDOP\":50.774999,\"USDDZD\":119.279668,\"USDEGP\":16.597498,\"USDERN\":15.000389,\"USDETB\":28.857016,\"USDEUR\":0.891057,\"USDFJD\":2.13455,\"USDFKP\":0.79917,\"USDGBP\":0.804615,\"USDGEL\":2.845025,\"USDGGP\":0.804583,\"USDGHS\":5.350993,\"USDGIP\":0.80537,\"USDGMD\":49.814989,\"USDGNF\":9168.302544,\"USDGTQ\":7.67905,\"USDGYD\":208.975062,\"USDHKD\":7.81763,\"USDHNL\":24.475504,\"USDHRK\":6.58485,\"USDHTG\":94.06103,\"USDHUF\":290.365959,\"USDIDR\":13934,\"USDILS\":3.54651,\"USDIMP\":0.804583,\"USDINR\":68.692023,\"USDIQD\":1193.45,\"USDIRR\":42104.999615,\"USDISK\":126.270257,\"USDJEP\":0.804583,\"USDJMD\":135.059815,\"USDJOD\":0.709028,\"USDJPY\":107.983023,\"USDKES\":103.1101,\"USDKGS\":69.566301,\"USDKHR\":4079.802238,\"USDKMF\":436.999799,\"USDKPW\":900.082162,\"USDKRW\":1178.349932,\"USDKWD\":0.304495,\"USDKYD\":0.833505,\"USDKZT\":383.440013,\"USDLAK\":8735.295856,\"USDLBP\":1512.449971,\"USDLKR\":175.749849,\"USDLRD\":200.999982,\"USDLSL\":13.880089,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395902,\"USDMAD\":9.561602,\"USDMDL\":17.685975,\"USDMGA\":3654.749455,\"USDMKD\":54.666007,\"USDMMK\":1511.249683,\"USDMNT\":2661.576406,\"USDMOP\":8.05355,\"USDMRO\":357.000346,\"USDMUR\":35.852499,\"USDMVR\":15.292558,\"USDMWK\":765.707217,\"USDMXN\":18.970697,\"USDMYR\":4.104902,\"USDMZN\":62.060509,\"USDNAD\":13.89594,\"USDNGN\":361.809629,\"USDNIO\":32.966499,\"USDNOK\":8.55577,\"USDNPR\":109.725005,\"USDNZD\":1.487197,\"USDOMR\":0.384985,\"USDPAB\":0.9999,\"USDPEN\":3.28615,\"USDPGK\":3.398297,\"USDPHP\":50.9115,\"USDPKR\":159.519945,\"USDPLN\":3.79415,\"USDPYG\":5999.450048,\"USDQAR\":3.641029,\"USDRON\":4.216697,\"USDRSD\":104.830163,\"USDRUB\":62.774026,\"USDRWF\":914.355,\"USDSAR\":3.750602,\"USDSBD\":8.244504,\"USDSCR\":13.66007,\"USDSDG\":45.120505,\"USDSEK\":9.39704,\"USDSGD\":1.35757,\"USDSHP\":1.320898,\"USDSLL\":8950.000344,\"USDSOS\":584.000279,\"USDSRD\":7.457957,\"USDSTD\":21560.79,\"USDSVC\":8.752299,\"USDSYP\":515.000143,\"USDSZL\":13.872984,\"USDTHB\":30.900494,\"USDTJS\":9.432101,\"USDTMT\":3.51,\"USDTND\":2.87095,\"USDTOP\":2.27255,\"USDTRY\":5.704602,\"USDTTD\":6.779399,\"USDTWD\":31.074499,\"USDTZS\":2299.703684,\"USDUAH\":25.9415,\"USDUGX\":3690.795264,\"USDUSD\":1,\"USDUYU\":35.110231,\"USDUZS\":8583.504811,\"USDVEF\":9.987501,\"USDVND\":23204.85,\"USDVUV\":114.880049,\"USDWST\":2.60891,\"USDXAF\":584.570395,\"USDXAG\":0.06474,\"USDXAU\":0.000707,\"USDXCD\":2.70255,\"USDXDR\":0.72385,\"USDXOF\":584.55999,\"USDXPF\":106.280307,\"USDYER\":250.350075,\"USDZAR\":13.86905,\"USDZMK\":9001.201595,\"USDZMW\":12.517978,\"USDZWL\":322.000001}}', 1, '2019-07-16 12:02:05', '2019-07-17 12:00:10', '2019-07-17 12:00:10', 'USD'),
(792, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563364926,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.983504,\"USDALL\":108.849859,\"USDAMD\":476.105017,\"USDANG\":1.78025,\"USDAOA\":345.928498,\"USDARS\":42.658988,\"USDAUD\":1.427699,\"USDAWG\":1.801,\"USDAZN\":1.70498,\"USDBAM\":1.743396,\"USDBBD\":2.01945,\"USDBDT\":84.520184,\"USDBGN\":1.743901,\"USDBHD\":0.37685,\"USDBIF\":1839.1,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91225,\"USDBRL\":3.766196,\"USDBSD\":1.0003,\"USDBTC\":0.000109,\"USDBTN\":68.845389,\"USDBWP\":10.580198,\"USDBYN\":2.02975,\"USDBYR\":19600,\"USDBZD\":2.01595,\"USDCAD\":1.30625,\"USDCDF\":1666.000151,\"USDCHF\":0.989125,\"USDCLF\":0.024689,\"USDCLP\":681.25504,\"USDCNY\":6.877298,\"USDCOP\":3200.95,\"USDCRC\":574.154983,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.292989,\"USDCZK\":22.823501,\"USDDJF\":177.720405,\"USDDKK\":6.65742,\"USDDOP\":50.815023,\"USDDZD\":119.419772,\"USDEGP\":16.635029,\"USDERN\":14.999689,\"USDETB\":28.855972,\"USDEUR\":0.891396,\"USDFJD\":2.13935,\"USDFKP\":0.806195,\"USDGBP\":0.80565,\"USDGEL\":2.845012,\"USDGGP\":0.805798,\"USDGHS\":5.355297,\"USDGIP\":0.80621,\"USDGMD\":49.855028,\"USDGNF\":9122.103834,\"USDGTQ\":7.666103,\"USDGYD\":208.804955,\"USDHKD\":7.814855,\"USDHNL\":24.475502,\"USDHRK\":6.5901,\"USDHTG\":94.099499,\"USDHUF\":291.259934,\"USDIDR\":13975,\"USDILS\":3.54155,\"USDIMP\":0.805798,\"USDINR\":68.853202,\"USDIQD\":1193.35,\"USDIRR\":42104.999356,\"USDISK\":126.169884,\"USDJEP\":0.805798,\"USDJMD\":134.940121,\"USDJOD\":0.709014,\"USDJPY\":108.275003,\"USDKES\":103.079711,\"USDKGS\":69.631198,\"USDKHR\":4080.549822,\"USDKMF\":437.000237,\"USDKPW\":900.080223,\"USDKRW\":1181.050102,\"USDKWD\":0.304597,\"USDKYD\":0.83339,\"USDKZT\":383.929781,\"USDLAK\":8735.207104,\"USDLBP\":1512.350106,\"USDLKR\":175.690373,\"USDLRD\":201.000263,\"USDLSL\":13.879589,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39665,\"USDMAD\":9.562297,\"USDMDL\":17.622501,\"USDMGA\":3655.049667,\"USDMKD\":54.664974,\"USDMMK\":1514.650322,\"USDMNT\":2662.834829,\"USDMOP\":8.049903,\"USDMRO\":357.000346,\"USDMUR\":35.889809,\"USDMVR\":15.301353,\"USDMWK\":765.475025,\"USDMXN\":19.08035,\"USDMYR\":4.116301,\"USDMZN\":61.984991,\"USDNAD\":13.904424,\"USDNGN\":360.510222,\"USDNIO\":32.9945,\"USDNOK\":8.57835,\"USDNPR\":110.205029,\"USDNZD\":1.48739,\"USDOMR\":0.385005,\"USDPAB\":1.0003,\"USDPEN\":3.29015,\"USDPGK\":3.398203,\"USDPHP\":51.120242,\"USDPKR\":159.449679,\"USDPLN\":3.80135,\"USDPYG\":5979.797733,\"USDQAR\":3.640986,\"USDRON\":4.219402,\"USDRSD\":104.893121,\"USDRUB\":62.807985,\"USDRWF\":915.27,\"USDSAR\":3.75125,\"USDSBD\":8.244504,\"USDSCR\":13.660213,\"USDSDG\":45.11302,\"USDSEK\":9.374202,\"USDSGD\":1.361451,\"USDSHP\":1.320897,\"USDSLL\":8989.999987,\"USDSOS\":579.999822,\"USDSRD\":7.458016,\"USDSTD\":21560.79,\"USDSVC\":8.75105,\"USDSYP\":515.000359,\"USDSZL\":13.955502,\"USDTHB\":30.945014,\"USDTJS\":9.42995,\"USDTMT\":3.5,\"USDTND\":2.869202,\"USDTOP\":2.274601,\"USDTRY\":5.688465,\"USDTTD\":6.78105,\"USDTWD\":31.084061,\"USDTZS\":2300.197294,\"USDUAH\":25.8635,\"USDUGX\":3691.999944,\"USDUSD\":1,\"USDUYU\":35.119781,\"USDUZS\":8572.198022,\"USDVEF\":9.987499,\"USDVND\":23205.7,\"USDVUV\":114.880163,\"USDWST\":2.613,\"USDXAF\":584.789932,\"USDXAG\":0.063894,\"USDXAU\":0.000712,\"USDXCD\":2.70255,\"USDXDR\":0.72425,\"USDXOF\":584.709727,\"USDXPF\":106.319673,\"USDYER\":250.349804,\"USDZAR\":13.96755,\"USDZMK\":9001.200356,\"USDZMW\":12.595987,\"USDZWL\":322.000001}}', 1, '2019-07-17 12:02:06', '2019-07-17 15:06:50', '2019-07-17 15:06:50', 'USD'),
(793, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563451326,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67325,\"USDAFN\":80.969746,\"USDALL\":108.949919,\"USDAMD\":476.29499,\"USDANG\":1.779802,\"USDAOA\":346.555498,\"USDARS\":42.502978,\"USDAUD\":1.42149,\"USDAWG\":1.8,\"USDAZN\":1.704946,\"USDBAM\":1.74425,\"USDBBD\":2.0189,\"USDBDT\":84.495202,\"USDBGN\":1.743602,\"USDBHD\":0.37685,\"USDBIF\":1838.95,\"USDBMD\":1,\"USDBND\":1.350703,\"USDBOB\":6.91055,\"USDBRL\":3.762499,\"USDBSD\":1.00005,\"USDBTC\":0.000102,\"USDBTN\":68.929887,\"USDBWP\":10.584001,\"USDBYN\":2.03335,\"USDBYR\":19600,\"USDBZD\":2.015498,\"USDCAD\":1.30635,\"USDCDF\":1664.999544,\"USDCHF\":0.986899,\"USDCLF\":0.02472,\"USDCLP\":681.994979,\"USDCNY\":6.880303,\"USDCOP\":3183.9,\"USDCRC\":574.064977,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.087502,\"USDCZK\":22.805015,\"USDDJF\":177.720178,\"USDDKK\":6.656303,\"USDDOP\":50.885499,\"USDDZD\":119.324972,\"USDEGP\":16.643965,\"USDERN\":15.000228,\"USDETB\":28.992987,\"USDEUR\":0.89141,\"USDFJD\":2.13135,\"USDFKP\":0.80151,\"USDGBP\":0.80085,\"USDGEL\":2.859789,\"USDGGP\":0.800807,\"USDGHS\":5.345403,\"USDGIP\":0.80152,\"USDGMD\":49.884967,\"USDGNF\":9129.049561,\"USDGTQ\":7.66925,\"USDGYD\":209.005016,\"USDHKD\":7.81481,\"USDHNL\":24.471968,\"USDHRK\":6.584401,\"USDHTG\":94.105498,\"USDHUF\":290.946972,\"USDIDR\":13972,\"USDILS\":3.542896,\"USDIMP\":0.800807,\"USDINR\":68.916497,\"USDIQD\":1193.15,\"USDIRR\":42104.999643,\"USDISK\":125.769915,\"USDJEP\":0.800807,\"USDJMD\":133.824966,\"USDJOD\":0.708995,\"USDJPY\":107.819503,\"USDKES\":103.049814,\"USDKGS\":69.650309,\"USDKHR\":4079.650127,\"USDKMF\":438.449768,\"USDKPW\":900.082732,\"USDKRW\":1177.698557,\"USDKWD\":0.304397,\"USDKYD\":0.833245,\"USDKZT\":383.540118,\"USDLAK\":8733.197685,\"USDLBP\":1512.049789,\"USDLKR\":175.740076,\"USDLRD\":201.000045,\"USDLSL\":13.969743,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39985,\"USDMAD\":9.57655,\"USDMDL\":17.575499,\"USDMGA\":3653.649742,\"USDMKD\":54.668028,\"USDMMK\":1516.850027,\"USDMNT\":2662.768089,\"USDMOP\":8.04805,\"USDMRO\":357.000346,\"USDMUR\":36.106498,\"USDMVR\":15.409359,\"USDMWK\":763.774972,\"USDMXN\":19.059103,\"USDMYR\":4.114906,\"USDMZN\":61.904372,\"USDNAD\":13.970388,\"USDNGN\":360.180323,\"USDNIO\":32.987015,\"USDNOK\":8.597075,\"USDNPR\":109.985016,\"USDNZD\":1.48333,\"USDOMR\":0.385025,\"USDPAB\":1.00005,\"USDPEN\":3.28465,\"USDPGK\":3.39745,\"USDPHP\":51.120257,\"USDPKR\":159.739764,\"USDPLN\":3.79725,\"USDPYG\":6021.949848,\"USDQAR\":3.640997,\"USDRON\":4.218396,\"USDRSD\":104.920273,\"USDRUB\":62.983973,\"USDRWF\":915.375,\"USDSAR\":3.75175,\"USDSBD\":8.30575,\"USDSCR\":13.66018,\"USDSDG\":45.112498,\"USDSEK\":9.365802,\"USDSGD\":1.36055,\"USDSHP\":1.320898,\"USDSLL\":9000.000122,\"USDSOS\":581.000067,\"USDSRD\":7.457981,\"USDSTD\":21560.79,\"USDSVC\":8.748894,\"USDSYP\":514.999593,\"USDSZL\":14.014499,\"USDTHB\":30.887019,\"USDTJS\":9.430197,\"USDTMT\":3.5,\"USDTND\":2.859302,\"USDTOP\":2.27305,\"USDTRY\":5.69776,\"USDTTD\":6.77775,\"USDTWD\":31.067021,\"USDTZS\":2299.297355,\"USDUAH\":26.067496,\"USDUGX\":3694.64965,\"USDUSD\":1,\"USDUYU\":35.169887,\"USDUZS\":8565.698178,\"USDVEF\":9.987497,\"USDVND\":23216.1,\"USDVUV\":115.080402,\"USDWST\":2.613,\"USDXAF\":584.949786,\"USDXAG\":0.062004,\"USDXAU\":0.000704,\"USDXCD\":2.70255,\"USDXDR\":0.72385,\"USDXOF\":584.999832,\"USDXPF\":106.349646,\"USDYER\":250.249964,\"USDZAR\":13.992498,\"USDZMK\":9001.197321,\"USDZMW\":12.724503,\"USDZWL\":322.000001}}', 1, '2019-07-18 12:02:06', '2019-07-18 13:23:31', '2019-07-18 13:23:31', 'USD'),
(794, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563466506,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673103,\"USDAFN\":80.149879,\"USDALL\":108.893911,\"USDAMD\":476.410403,\"USDANG\":1.779797,\"USDAOA\":346.555504,\"USDARS\":42.383017,\"USDAUD\":1.42016,\"USDAWG\":1.801,\"USDAZN\":1.705024,\"USDBAM\":1.74425,\"USDBBD\":2.0189,\"USDBDT\":84.497943,\"USDBGN\":1.747005,\"USDBHD\":0.376885,\"USDBIF\":1850,\"USDBMD\":1,\"USDBND\":1.350704,\"USDBOB\":6.91055,\"USDBRL\":3.744991,\"USDBSD\":1.00005,\"USDBTC\":0.000094489995,\"USDBTN\":68.861582,\"USDBWP\":10.58396,\"USDBYN\":2.03335,\"USDBYR\":19600,\"USDBZD\":2.015498,\"USDCAD\":1.30823,\"USDCDF\":1666.999907,\"USDCHF\":0.986597,\"USDCLF\":0.02476,\"USDCLP\":683.198872,\"USDCNY\":6.880102,\"USDCOP\":3185.3,\"USDCRC\":574.065042,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.095502,\"USDCZK\":22.774896,\"USDDJF\":177.720256,\"USDDKK\":6.65241,\"USDDOP\":50.810468,\"USDDZD\":119.390012,\"USDEGP\":16.619881,\"USDERN\":14.999662,\"USDETB\":29.000214,\"USDEUR\":0.890799,\"USDFJD\":2.13905,\"USDFKP\":0.80155,\"USDGBP\":0.80057,\"USDGEL\":2.860012,\"USDGGP\":0.800398,\"USDGHS\":5.346501,\"USDGIP\":0.801545,\"USDGMD\":49.884966,\"USDGNF\":9237.501234,\"USDGTQ\":7.66925,\"USDGYD\":209.004975,\"USDHKD\":7.816735,\"USDHNL\":24.730181,\"USDHRK\":6.5854,\"USDHTG\":94.105497,\"USDHUF\":290.393017,\"USDIDR\":13957,\"USDILS\":3.542098,\"USDIMP\":0.800398,\"USDINR\":68.860976,\"USDIQD\":1190,\"USDIRR\":42104.999881,\"USDISK\":125.33977,\"USDJEP\":0.800398,\"USDJMD\":134.439571,\"USDJOD\":0.708598,\"USDJPY\":107.778998,\"USDKES\":103.049868,\"USDKGS\":69.650368,\"USDKHR\":4079.999698,\"USDKMF\":439.125049,\"USDKPW\":900.083895,\"USDKRW\":1175.999669,\"USDKWD\":0.30435,\"USDKYD\":0.833245,\"USDKZT\":383.550318,\"USDLAK\":8681.999684,\"USDLBP\":1510.250122,\"USDLKR\":175.740089,\"USDLRD\":201.249773,\"USDLSL\":13.920146,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.352639,\"USDMAD\":9.574597,\"USDMDL\":17.575496,\"USDMGA\":3619.999679,\"USDMKD\":54.664007,\"USDMMK\":1516.849702,\"USDMNT\":2662.795114,\"USDMOP\":8.04805,\"USDMRO\":357.000346,\"USDMUR\":35.8605,\"USDMVR\":15.449886,\"USDMWK\":760.080218,\"USDMXN\":19.003398,\"USDMYR\":4.112899,\"USDMZN\":61.898349,\"USDNAD\":13.920414,\"USDNGN\":360.000085,\"USDNIO\":33.529761,\"USDNOK\":8.591125,\"USDNPR\":109.984975,\"USDNZD\":1.480385,\"USDOMR\":0.384985,\"USDPAB\":1.00005,\"USDPEN\":3.28698,\"USDPGK\":3.397799,\"USDPHP\":51.065978,\"USDPKR\":159.739961,\"USDPLN\":3.79415,\"USDPYG\":6021.949997,\"USDQAR\":3.64075,\"USDRON\":4.215798,\"USDRSD\":104.909702,\"USDRUB\":63.04615,\"USDRWF\":916,\"USDSAR\":3.75075,\"USDSBD\":8.30575,\"USDSCR\":13.659935,\"USDSDG\":45.112498,\"USDSEK\":9.35426,\"USDSGD\":1.3607,\"USDSHP\":1.320902,\"USDSLL\":9100.000077,\"USDSOS\":579.999954,\"USDSRD\":7.457996,\"USDSTD\":21560.79,\"USDSVC\":8.748902,\"USDSYP\":515.000096,\"USDSZL\":13.920216,\"USDTHB\":30.816498,\"USDTJS\":9.430197,\"USDTMT\":3.51,\"USDTND\":2.86375,\"USDTOP\":2.27305,\"USDTRY\":5.68444,\"USDTTD\":6.77775,\"USDTWD\":31.045031,\"USDTZS\":2300.200953,\"USDUAH\":25.958971,\"USDUGX\":3694.650177,\"USDUSD\":1,\"USDUYU\":35.169972,\"USDUZS\":8604.999465,\"USDVEF\":9.987498,\"USDVND\":23214.8,\"USDVUV\":115.079362,\"USDWST\":2.613287,\"USDXAF\":584.949822,\"USDXAG\":0.061786,\"USDXAU\":0.0007,\"USDXCD\":2.70255,\"USDXDR\":0.723459,\"USDXOF\":591.500902,\"USDXPF\":106.696569,\"USDYER\":250.249882,\"USDZAR\":13.879628,\"USDZMK\":9001.202255,\"USDZMW\":12.7245,\"USDZWL\":322.000001}}', 1, '2019-07-18 16:15:06', '2019-07-18 16:23:34', '2019-07-18 16:23:34', 'USD'),
(795, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563812107,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673102,\"USDAFN\":79.850278,\"USDALL\":108.87015,\"USDAMD\":476.180076,\"USDANG\":1.78505,\"USDAOA\":346.555499,\"USDARS\":42.460981,\"USDAUD\":1.420498,\"USDAWG\":1.79975,\"USDAZN\":1.705022,\"USDBAM\":1.742903,\"USDBBD\":2.01975,\"USDBDT\":84.513007,\"USDBGN\":1.744295,\"USDBHD\":0.377033,\"USDBIF\":1851,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91285,\"USDBRL\":3.736403,\"USDBSD\":1.00025,\"USDBTC\":0.000097426821,\"USDBTN\":68.914096,\"USDBWP\":10.577991,\"USDBYN\":2.017401,\"USDBYR\":19600,\"USDBZD\":2.01575,\"USDCAD\":1.31175,\"USDCDF\":1665.501438,\"USDCHF\":0.981695,\"USDCLF\":0.024959,\"USDCLP\":688.601415,\"USDCNY\":6.880984,\"USDCOP\":3174.15,\"USDCRC\":574.735041,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.2225,\"USDCZK\":22.777983,\"USDDJF\":177.719732,\"USDDKK\":6.65835,\"USDDOP\":51.044952,\"USDDZD\":119.425029,\"USDEGP\":16.611036,\"USDERN\":14.999632,\"USDETB\":29.005019,\"USDEUR\":0.891765,\"USDFJD\":2.12195,\"USDFKP\":0.800805,\"USDGBP\":0.801702,\"USDGEL\":2.875,\"USDGGP\":0.801643,\"USDGHS\":5.389402,\"USDGIP\":0.800805,\"USDGMD\":49.96494,\"USDGNF\":9237.50529,\"USDGTQ\":7.66535,\"USDGYD\":208.824996,\"USDHKD\":7.81025,\"USDHNL\":24.649688,\"USDHRK\":6.587399,\"USDHTG\":94.0615,\"USDHUF\":290.067997,\"USDIDR\":13938,\"USDILS\":3.527504,\"USDIMP\":0.801643,\"USDINR\":68.922497,\"USDIQD\":1190,\"USDIRR\":42104.999767,\"USDISK\":124.74986,\"USDJEP\":0.801643,\"USDJMD\":134.620006,\"USDJOD\":0.707695,\"USDJPY\":107.892498,\"USDKES\":103.58965,\"USDKGS\":69.647987,\"USDKHR\":4083.000157,\"USDKMF\":438.825034,\"USDKPW\":900.063955,\"USDKRW\":1176.000169,\"USDKWD\":0.3043,\"USDKYD\":0.833405,\"USDKZT\":385.740314,\"USDLAK\":8685.000304,\"USDLBP\":1507.949971,\"USDLKR\":175.87028,\"USDLRD\":201.624972,\"USDLSL\":13.84002,\"USDLTL\":2.952741,\"USDLVL\":0.60489,\"USDLYD\":1.404975,\"USDMAD\":9.59335,\"USDMDL\":17.525503,\"USDMGA\":3607.529093,\"USDMKD\":54.660489,\"USDMMK\":1518.103721,\"USDMNT\":2664.490574,\"USDMOP\":8.04445,\"USDMRO\":357.000346,\"USDMUR\":35.919714,\"USDMVR\":15.450255,\"USDMWK\":759.935024,\"USDMXN\":19.06545,\"USDMYR\":4.111973,\"USDMZN\":61.814974,\"USDNAD\":13.840303,\"USDNGN\":359.999783,\"USDNIO\":33.496149,\"USDNOK\":8.60639,\"USDNPR\":110.245032,\"USDNZD\":1.47605,\"USDOMR\":0.384962,\"USDPAB\":1.00025,\"USDPEN\":3.28495,\"USDPGK\":3.389929,\"USDPHP\":51.131984,\"USDPKR\":159.897773,\"USDPLN\":3.78825,\"USDPYG\":5977.550349,\"USDQAR\":3.64175,\"USDRON\":4.209098,\"USDRSD\":105.009683,\"USDRUB\":63.102903,\"USDRWF\":910,\"USDSAR\":3.750604,\"USDSBD\":8.27135,\"USDSCR\":13.743019,\"USDSDG\":45.114494,\"USDSEK\":9.40942,\"USDSGD\":1.360703,\"USDSHP\":1.320897,\"USDSLL\":9249.999993,\"USDSOS\":580.000015,\"USDSRD\":7.457987,\"USDSTD\":21560.79,\"USDSVC\":8.75025,\"USDSYP\":515.000086,\"USDSZL\":13.840272,\"USDTHB\":30.87022,\"USDTJS\":9.430199,\"USDTMT\":3.5,\"USDTND\":2.86375,\"USDTOP\":2.267896,\"USDTRY\":5.687296,\"USDTTD\":6.77465,\"USDTWD\":31.049788,\"USDTZS\":2299.698844,\"USDUAH\":25.783984,\"USDUGX\":3695.198022,\"USDUSD\":1,\"USDUYU\":35.129727,\"USDUZS\":8629.999832,\"USDVEF\":9.987503,\"USDVND\":23230.6,\"USDVUV\":114.780027,\"USDWST\":2.602797,\"USDXAF\":584.559721,\"USDXAG\":0.061031,\"USDXAU\":0.000701,\"USDXCD\":2.70255,\"USDXDR\":0.723833,\"USDXOF\":591.500088,\"USDXPF\":106.698863,\"USDYER\":250.303594,\"USDZAR\":13.877903,\"USDZMK\":9001.195989,\"USDZMW\":12.825504,\"USDZWL\":322.000001}}', 1, '2019-07-22 16:15:07', '2019-07-23 12:12:38', '2019-07-23 12:12:38', 'USD'),
(796, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563898505,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673098,\"USDAFN\":79.905501,\"USDALL\":109.470052,\"USDAMD\":475.797801,\"USDANG\":1.785102,\"USDAOA\":347.656956,\"USDARS\":42.678031,\"USDAUD\":1.42856,\"USDAWG\":1.8,\"USDAZN\":1.704962,\"USDBAM\":1.74925,\"USDBBD\":2.0192,\"USDBDT\":84.501967,\"USDBGN\":1.753599,\"USDBHD\":0.376964,\"USDBIF\":1850,\"USDBMD\":1,\"USDBND\":1.350698,\"USDBOB\":6.915751,\"USDBRL\":3.768797,\"USDBSD\":1.00005,\"USDBTC\":0.000101,\"USDBTN\":68.914104,\"USDBWP\":10.571993,\"USDBYN\":2.02335,\"USDBYR\":19600,\"USDBZD\":2.015798,\"USDCAD\":1.313595,\"USDCDF\":1664.999657,\"USDCHF\":0.985105,\"USDCLF\":0.025101,\"USDCLP\":692.599098,\"USDCNY\":6.879197,\"USDCOP\":3186.6,\"USDCRC\":573.406879,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.617498,\"USDCZK\":22.903498,\"USDDJF\":177.719788,\"USDDKK\":6.692202,\"USDDOP\":51.065025,\"USDDZD\":119.495571,\"USDEGP\":16.617501,\"USDERN\":15.000656,\"USDETB\":29.00502,\"USDEUR\":0.89646,\"USDFJD\":2.13095,\"USDFKP\":0.802485,\"USDGBP\":0.803501,\"USDGEL\":2.87499,\"USDGGP\":0.80329,\"USDGHS\":5.388503,\"USDGIP\":0.802495,\"USDGMD\":49.965019,\"USDGNF\":9219.999972,\"USDGTQ\":7.652902,\"USDGYD\":208.939923,\"USDHKD\":7.81085,\"USDHNL\":24.649967,\"USDHRK\":6.6235,\"USDHTG\":94.224497,\"USDHUF\":292.112985,\"USDIDR\":13984.5,\"USDILS\":3.53925,\"USDIMP\":0.80329,\"USDINR\":69.008974,\"USDIQD\":1190,\"USDIRR\":42104.999992,\"USDISK\":123.140094,\"USDJEP\":0.80329,\"USDJMD\":134.01041,\"USDJOD\":0.708034,\"USDJPY\":108.099501,\"USDKES\":103.799517,\"USDKGS\":69.665904,\"USDKHR\":4081.250187,\"USDKMF\":438.797591,\"USDKPW\":900.073816,\"USDKRW\":1179.394926,\"USDKWD\":0.304502,\"USDKYD\":0.833398,\"USDKZT\":384.889867,\"USDLAK\":8734.999774,\"USDLBP\":1512.45023,\"USDLKR\":176.050163,\"USDLRD\":201.624988,\"USDLSL\":13.840206,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39865,\"USDMAD\":9.622397,\"USDMDL\":17.527967,\"USDMGA\":3607.50203,\"USDMKD\":54.665502,\"USDMMK\":1510.550143,\"USDMNT\":2664.712491,\"USDMOP\":8.045795,\"USDMRO\":357.000346,\"USDMUR\":36.158498,\"USDMVR\":15.449525,\"USDMWK\":760.110124,\"USDMXN\":19.123402,\"USDMYR\":4.116599,\"USDMZN\":61.834989,\"USDNAD\":13.839418,\"USDNGN\":360.510376,\"USDNIO\":33.503778,\"USDNOK\":8.684899,\"USDNPR\":110.289883,\"USDNZD\":1.49095,\"USDOMR\":0.38505,\"USDPAB\":1.00005,\"USDPEN\":3.289503,\"USDPGK\":3.397797,\"USDPHP\":51.187551,\"USDPKR\":159.97028,\"USDPLN\":3.8156,\"USDPYG\":5980.550236,\"USDQAR\":3.64075,\"USDRON\":4.232598,\"USDRSD\":105.580271,\"USDRUB\":63.273999,\"USDRWF\":915,\"USDSAR\":3.75065,\"USDSBD\":8.27135,\"USDSCR\":13.982022,\"USDSDG\":45.113034,\"USDSEK\":9.46495,\"USDSGD\":1.365101,\"USDSHP\":1.320901,\"USDSLL\":9249.999735,\"USDSOS\":579.999909,\"USDSRD\":7.458008,\"USDSTD\":21560.79,\"USDSVC\":8.75075,\"USDSYP\":514.999903,\"USDSZL\":13.83971,\"USDTHB\":30.897323,\"USDTJS\":9.439801,\"USDTMT\":3.5,\"USDTND\":2.87145,\"USDTOP\":2.268904,\"USDTRY\":5.712915,\"USDTTD\":6.75185,\"USDTWD\":31.09901,\"USDTZS\":2299.297688,\"USDUAH\":25.637057,\"USDUGX\":3695.149959,\"USDUSD\":1,\"USDUYU\":35.040268,\"USDUZS\":8629.999576,\"USDVEF\":9.987497,\"USDVND\":23210,\"USDVUV\":114.844846,\"USDWST\":2.606782,\"USDXAF\":586.689819,\"USDXAG\":0.060808,\"USDXAU\":0.000703,\"USDXCD\":2.70255,\"USDXDR\":0.725216,\"USDXOF\":591.565629,\"USDXPF\":106.698647,\"USDYER\":250.299737,\"USDZAR\":13.892018,\"USDZMK\":9001.207273,\"USDZMW\":12.974981,\"USDZWL\":322.000001}}', 1, '2019-07-23 16:15:05', '2019-07-23 16:44:45', '2019-07-23 16:44:45', 'USD'),
(797, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1563984905,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672966,\"USDAFN\":79.950447,\"USDALL\":109.360496,\"USDAMD\":475.979802,\"USDANG\":1.785449,\"USDAOA\":347.656996,\"USDARS\":42.892016,\"USDAUD\":1.433203,\"USDAWG\":1.801,\"USDAZN\":1.705011,\"USDBAM\":1.75385,\"USDBBD\":2.01955,\"USDBDT\":84.514011,\"USDBGN\":1.755902,\"USDBHD\":0.377031,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91155,\"USDBRL\":3.760903,\"USDBSD\":1.00025,\"USDBTC\":0.000102,\"USDBTN\":68.914101,\"USDBWP\":10.592989,\"USDBYN\":2.026751,\"USDBYR\":19600,\"USDBZD\":2.01615,\"USDCAD\":1.313935,\"USDCDF\":1665.999562,\"USDCHF\":0.985225,\"USDCLF\":0.025054,\"USDCLP\":691.402706,\"USDCNY\":6.872399,\"USDCOP\":3205.3,\"USDCRC\":574.30499,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.259502,\"USDCZK\":22.894901,\"USDDJF\":177.720241,\"USDDKK\":6.69972,\"USDDOP\":51.044967,\"USDDZD\":119.665023,\"USDEGP\":16.612496,\"USDERN\":14.999756,\"USDETB\":28.999776,\"USDEUR\":0.897503,\"USDFJD\":2.14255,\"USDFKP\":0.798605,\"USDGBP\":0.800255,\"USDGEL\":2.909992,\"USDGGP\":0.800283,\"USDGHS\":5.389985,\"USDGIP\":0.798695,\"USDGMD\":49.97499,\"USDGNF\":9237.501353,\"USDGTQ\":7.65175,\"USDGYD\":208.702307,\"USDHKD\":7.81355,\"USDHNL\":24.650141,\"USDHRK\":6.628199,\"USDHTG\":94.140286,\"USDHUF\":291.998973,\"USDIDR\":13979,\"USDILS\":3.523702,\"USDIMP\":0.800283,\"USDINR\":68.958199,\"USDIQD\":1190,\"USDIRR\":42104.999781,\"USDISK\":121.970005,\"USDJEP\":0.800283,\"USDJMD\":133.929682,\"USDJOD\":0.70898,\"USDJPY\":108.112039,\"USDKES\":103.999928,\"USDKGS\":69.723099,\"USDKHR\":4080.999588,\"USDKMF\":441.625005,\"USDKPW\":900.076681,\"USDKRW\":1177.929792,\"USDKWD\":0.304401,\"USDKYD\":0.83352,\"USDKZT\":384.509558,\"USDLAK\":8690.000102,\"USDLBP\":1514.45024,\"USDLKR\":176.209697,\"USDLRD\":201.874985,\"USDLSL\":13.929737,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.414885,\"USDMAD\":9.59965,\"USDMDL\":17.55897,\"USDMGA\":3614.999721,\"USDMKD\":54.662504,\"USDMMK\":1512.349738,\"USDMNT\":2664.895814,\"USDMOP\":8.05075,\"USDMRO\":357.000346,\"USDMUR\":36.248503,\"USDMVR\":15.450119,\"USDMWK\":754.405037,\"USDMXN\":19.093702,\"USDMYR\":4.115103,\"USDMZN\":61.839783,\"USDNAD\":13.929723,\"USDNGN\":361.839804,\"USDNIO\":33.550311,\"USDNOK\":8.63684,\"USDNPR\":110.364978,\"USDNZD\":1.490206,\"USDOMR\":0.385005,\"USDPAB\":1.00025,\"USDPEN\":3.29265,\"USDPGK\":3.3984,\"USDPHP\":51.129841,\"USDPKR\":160.99991,\"USDPLN\":3.81837,\"USDPYG\":5987.900541,\"USDQAR\":3.64075,\"USDRON\":4.2353,\"USDRSD\":105.798401,\"USDRUB\":63.146597,\"USDRWF\":912.5,\"USDSAR\":3.75065,\"USDSBD\":8.257704,\"USDSCR\":13.675989,\"USDSDG\":45.123009,\"USDSEK\":9.42245,\"USDSGD\":1.36384,\"USDSHP\":1.320899,\"USDSLL\":9250.000283,\"USDSOS\":580.999941,\"USDSRD\":7.458049,\"USDSTD\":21560.79,\"USDSVC\":8.752199,\"USDSYP\":515.000134,\"USDSZL\":13.930129,\"USDTHB\":30.903019,\"USDTJS\":9.432102,\"USDTMT\":3.5,\"USDTND\":2.875498,\"USDTOP\":2.275101,\"USDTRY\":5.697165,\"USDTTD\":6.77675,\"USDTWD\":31.083022,\"USDTZS\":2302.496537,\"USDUAH\":25.637003,\"USDUGX\":3695.849717,\"USDUSD\":1,\"USDUYU\":34.829846,\"USDUZS\":8675.000479,\"USDVEF\":9.987505,\"USDVND\":23210,\"USDVUV\":114.869734,\"USDWST\":2.613683,\"USDXAF\":588.230089,\"USDXAG\":0.060299,\"USDXAU\":0.000703,\"USDXCD\":2.70255,\"USDXDR\":0.725243,\"USDXOF\":591.999863,\"USDXPF\":107.50044,\"USDYER\":250.35037,\"USDZAR\":13.8665,\"USDZMK\":9001.198647,\"USDZMW\":12.908017,\"USDZWL\":322.000001}}', 1, '2019-07-24 16:15:05', '2019-07-25 13:49:59', '2019-07-25 13:49:59', 'USD'),
(798, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564071306,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673034,\"USDAFN\":79.950207,\"USDALL\":109.09969,\"USDAMD\":475.939776,\"USDANG\":1.785016,\"USDAOA\":347.657005,\"USDARS\":43.2348,\"USDAUD\":1.43853,\"USDAWG\":1.8,\"USDAZN\":1.705019,\"USDBAM\":1.755651,\"USDBBD\":2.0191,\"USDBDT\":84.493989,\"USDBGN\":1.755301,\"USDBHD\":0.37698,\"USDBIF\":1850,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91005,\"USDBRL\":3.788397,\"USDBSD\":1.00005,\"USDBTC\":0.0001,\"USDBTN\":68.914102,\"USDBWP\":10.593019,\"USDBYN\":2.026035,\"USDBYR\":19600,\"USDBZD\":2.015697,\"USDCAD\":1.314995,\"USDCDF\":1664.999696,\"USDCHF\":0.990555,\"USDCLF\":0.025209,\"USDCLP\":695.404955,\"USDCNY\":6.872603,\"USDCOP\":3215.1,\"USDCRC\":573.789611,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.419502,\"USDCZK\":22.907968,\"USDDJF\":177.719954,\"USDDKK\":6.69637,\"USDDOP\":51.06502,\"USDDZD\":119.669919,\"USDEGP\":16.574985,\"USDERN\":15.000176,\"USDETB\":29.000092,\"USDEUR\":0.89685,\"USDFJD\":2.15205,\"USDFKP\":0.800302,\"USDGBP\":0.802501,\"USDGEL\":2.905001,\"USDGGP\":0.802648,\"USDGHS\":5.390699,\"USDGIP\":0.800303,\"USDGMD\":50.000124,\"USDGNF\":9229.999959,\"USDGTQ\":7.64985,\"USDGYD\":208.654972,\"USDHKD\":7.81445,\"USDHNL\":24.640204,\"USDHRK\":6.614099,\"USDHTG\":94.191502,\"USDHUF\":292.496008,\"USDIDR\":13997,\"USDILS\":3.524404,\"USDIMP\":0.802648,\"USDINR\":69.067967,\"USDIQD\":1190,\"USDIRR\":42104.999669,\"USDISK\":121.689746,\"USDJEP\":0.802648,\"USDJMD\":133.859659,\"USDJOD\":0.70897,\"USDJPY\":108.651984,\"USDKES\":103.749832,\"USDKGS\":69.752964,\"USDKHR\":4081.999654,\"USDKMF\":441.352097,\"USDKPW\":900.075282,\"USDKRW\":1180.909713,\"USDKWD\":0.304305,\"USDKYD\":0.833295,\"USDKZT\":384.810418,\"USDLAK\":8691.999956,\"USDLBP\":1508.049884,\"USDLKR\":176.179989,\"USDLRD\":201.249899,\"USDLSL\":13.869847,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.402706,\"USDMAD\":9.588596,\"USDMDL\":17.594944,\"USDMGA\":3609.999891,\"USDMKD\":55.2085,\"USDMMK\":1512.050175,\"USDMNT\":2664.842171,\"USDMOP\":8.04855,\"USDMRO\":357.000346,\"USDMUR\":36.280495,\"USDMVR\":15.450136,\"USDMWK\":748.949736,\"USDMXN\":19.06455,\"USDMYR\":4.117596,\"USDMZN\":61.819682,\"USDNAD\":13.869795,\"USDNGN\":359.999654,\"USDNIO\":33.504105,\"USDNOK\":8.671395,\"USDNPR\":110.304984,\"USDNZD\":1.500765,\"USDOMR\":0.38502,\"USDPAB\":0.99995,\"USDPEN\":3.29525,\"USDPGK\":3.396199,\"USDPHP\":51.205244,\"USDPKR\":160.919743,\"USDPLN\":3.81966,\"USDPYG\":6021.849798,\"USDQAR\":3.64075,\"USDRON\":4.2342,\"USDRSD\":105.640336,\"USDRUB\":63.242897,\"USDRWF\":915,\"USDSAR\":3.75155,\"USDSBD\":8.26455,\"USDSCR\":13.672017,\"USDSDG\":45.111979,\"USDSEK\":9.440535,\"USDSGD\":1.36689,\"USDSHP\":1.320901,\"USDSLL\":9150.000493,\"USDSOS\":580.000021,\"USDSRD\":7.458004,\"USDSTD\":21560.79,\"USDSVC\":8.75035,\"USDSYP\":514.999671,\"USDSZL\":13.870451,\"USDTHB\":30.928016,\"USDTJS\":9.429902,\"USDTMT\":3.51,\"USDTND\":2.865604,\"USDTOP\":2.277702,\"USDTRY\":5.696197,\"USDTTD\":6.77495,\"USDTWD\":31.086501,\"USDTZS\":2299.795565,\"USDUAH\":25.438969,\"USDUGX\":3694.903473,\"USDUSD\":1,\"USDUYU\":34.389899,\"USDUZS\":8620.000484,\"USDVEF\":9.9875,\"USDVND\":23210.1,\"USDVUV\":115.460582,\"USDWST\":2.615734,\"USDXAF\":588.829922,\"USDXAG\":0.060707,\"USDXAU\":0.000706,\"USDXCD\":2.70255,\"USDXDR\":0.725236,\"USDXOF\":594.502835,\"USDXPF\":107.500677,\"USDYER\":250.397333,\"USDZAR\":14.09285,\"USDZMK\":9001.197688,\"USDZMW\":12.894979,\"USDZWL\":322.000001}}', 1, '2019-07-25 16:15:06', '2019-07-25 16:49:59', '2019-07-25 16:49:59', 'USD'),
(799, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564157706,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672976,\"USDAFN\":80.050399,\"USDALL\":109.549544,\"USDAMD\":475.970218,\"USDANG\":1.784701,\"USDAOA\":347.65698,\"USDARS\":43.350393,\"USDAUD\":1.448025,\"USDAWG\":1.8,\"USDAZN\":1.705013,\"USDBAM\":1.7567,\"USDBBD\":2.0188,\"USDBDT\":84.446001,\"USDBGN\":1.75895,\"USDBHD\":0.377021,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.3506,\"USDBOB\":6.90885,\"USDBRL\":3.760798,\"USDBSD\":0.99985,\"USDBTC\":0.000102,\"USDBTN\":68.914103,\"USDBWP\":10.682987,\"USDBYN\":2.027498,\"USDBYR\":19600,\"USDBZD\":2.01535,\"USDCAD\":1.31865,\"USDCDF\":1664.999676,\"USDCHF\":0.99369,\"USDCLF\":0.025206,\"USDCLP\":695.497187,\"USDCNY\":6.879203,\"USDCOP\":3236.6,\"USDCRC\":573.704953,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.041503,\"USDCZK\":22.998014,\"USDDJF\":177.720024,\"USDDKK\":6.71755,\"USDDOP\":50.985031,\"USDDZD\":119.685019,\"USDEGP\":16.594967,\"USDERN\":14.999728,\"USDETB\":28.950014,\"USDEUR\":0.899496,\"USDFJD\":2.14855,\"USDFKP\":0.804596,\"USDGBP\":0.807465,\"USDGEL\":2.920147,\"USDGGP\":0.807351,\"USDGHS\":5.392297,\"USDGIP\":0.804603,\"USDGMD\":49.974997,\"USDGNF\":9225.000142,\"USDGTQ\":7.66865,\"USDGYD\":208.619954,\"USDHKD\":7.81865,\"USDHNL\":24.660123,\"USDHRK\":6.642599,\"USDHTG\":94.382013,\"USDHUF\":294.029898,\"USDIDR\":13993.5,\"USDILS\":3.52175,\"USDIMP\":0.807351,\"USDINR\":68.889861,\"USDIQD\":1190,\"USDIRR\":42104.99972,\"USDISK\":122.070319,\"USDJEP\":0.807351,\"USDJMD\":135.080484,\"USDJOD\":0.709034,\"USDJPY\":108.706018,\"USDKES\":103.795037,\"USDKGS\":69.7521,\"USDKHR\":4082.494249,\"USDKMF\":441.674952,\"USDKPW\":900.076896,\"USDKRW\":1184.399642,\"USDKWD\":0.304501,\"USDKYD\":0.83325,\"USDKZT\":385.010234,\"USDLAK\":8690.000213,\"USDLBP\":1510.849972,\"USDLKR\":176.190176,\"USDLRD\":201.749968,\"USDLSL\":14.084992,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.38931,\"USDMAD\":9.60915,\"USDMDL\":17.6215,\"USDMGA\":3609.999818,\"USDMKD\":55.239024,\"USDMMK\":1509.849933,\"USDMNT\":2665.036194,\"USDMOP\":8.05215,\"USDMRO\":357.000346,\"USDMUR\":35.9455,\"USDMVR\":15.450298,\"USDMWK\":755.109933,\"USDMXN\":19.07764,\"USDMYR\":4.124975,\"USDMZN\":61.745055,\"USDNAD\":14.090005,\"USDNGN\":361.229978,\"USDNIO\":32.984036,\"USDNOK\":8.722835,\"USDNPR\":110.195002,\"USDNZD\":1.508225,\"USDOMR\":0.38503,\"USDPAB\":0.99995,\"USDPEN\":3.29845,\"USDPGK\":3.397805,\"USDPHP\":51.014985,\"USDPKR\":161.010334,\"USDPLN\":3.84445,\"USDPYG\":6011.949834,\"USDQAR\":3.64175,\"USDRON\":4.249098,\"USDRSD\":105.898403,\"USDRUB\":63.453019,\"USDRWF\":915,\"USDSAR\":3.75055,\"USDSBD\":8.238499,\"USDSCR\":13.664019,\"USDSDG\":45.103499,\"USDSEK\":9.50138,\"USDSGD\":1.369798,\"USDSHP\":1.320901,\"USDSLL\":9124.999764,\"USDSOS\":580.000056,\"USDSRD\":7.457954,\"USDSTD\":21560.79,\"USDSVC\":8.74925,\"USDSYP\":515.000132,\"USDSZL\":14.090197,\"USDTHB\":30.87401,\"USDTJS\":9.440017,\"USDTMT\":3.5,\"USDTND\":2.88015,\"USDTOP\":2.282897,\"USDTRY\":5.67141,\"USDTTD\":6.77395,\"USDTWD\":31.096957,\"USDTZS\":2299.99964,\"USDUAH\":25.382971,\"USDUGX\":3694.349868,\"USDUSD\":1,\"USDUYU\":33.839815,\"USDUZS\":8620.000188,\"USDVEF\":9.987498,\"USDVND\":23211.5,\"USDVUV\":115.711502,\"USDWST\":2.623282,\"USDXAF\":589.209832,\"USDXAG\":0.06105,\"USDXAU\":0.000705,\"USDXCD\":2.70255,\"USDXDR\":0.726544,\"USDXOF\":588.999614,\"USDXPF\":107.496617,\"USDYER\":250.398917,\"USDZAR\":14.28028,\"USDZMK\":9001.202353,\"USDZMW\":12.902978,\"USDZWL\":322.000001}}', 1, '2019-07-26 16:15:06', '2019-07-26 18:45:34', '2019-07-26 18:45:34', 'USD'),
(800, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564416485,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672898,\"USDAFN\":79.624978,\"USDALL\":109.239835,\"USDAMD\":476.120019,\"USDANG\":1.78595,\"USDAOA\":347.656977,\"USDARS\":43.839044,\"USDAUD\":1.448535,\"USDAWG\":1.7975,\"USDAZN\":1.704997,\"USDBAM\":1.75905,\"USDBBD\":2.02015,\"USDBDT\":84.504989,\"USDBGN\":1.756099,\"USDBHD\":0.377052,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91475,\"USDBRL\":3.788599,\"USDBSD\":1.00025,\"USDBTC\":0.000104,\"USDBTN\":68.914098,\"USDBWP\":10.702449,\"USDBYN\":2.037979,\"USDBYR\":19600,\"USDBZD\":2.01675,\"USDCAD\":1.315375,\"USDCDF\":1664.999824,\"USDCHF\":0.991904,\"USDCLF\":0.025256,\"USDCLP\":696.867862,\"USDCNY\":6.893403,\"USDCOP\":3273.3,\"USDCRC\":573.775018,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.134501,\"USDCZK\":23.028981,\"USDDJF\":177.72021,\"USDDKK\":6.70199,\"USDDOP\":51.009591,\"USDDZD\":119.680011,\"USDEGP\":16.565016,\"USDERN\":14.999744,\"USDETB\":29.04995,\"USDEUR\":0.897597,\"USDFJD\":2.14815,\"USDFKP\":0.811702,\"USDGBP\":0.81755,\"USDGEL\":2.930214,\"USDGGP\":0.817474,\"USDGHS\":5.400996,\"USDGIP\":0.811703,\"USDGMD\":50.005,\"USDGNF\":9225.000261,\"USDGTQ\":7.68395,\"USDGYD\":208.680446,\"USDHKD\":7.81965,\"USDHNL\":24.660036,\"USDHRK\":6.629202,\"USDHTG\":94.518497,\"USDHUF\":294.231001,\"USDIDR\":14033.5,\"USDILS\":3.524502,\"USDIMP\":0.817474,\"USDINR\":68.772501,\"USDIQD\":1190,\"USDIRR\":42104.999699,\"USDISK\":121.629961,\"USDJEP\":0.817474,\"USDJMD\":135.690137,\"USDJOD\":0.709026,\"USDJPY\":108.86503,\"USDKES\":104.090432,\"USDKGS\":69.747796,\"USDKHR\":4085.000253,\"USDKMF\":442.674977,\"USDKPW\":900.063323,\"USDKRW\":1183.802214,\"USDKWD\":0.304398,\"USDKYD\":0.833835,\"USDKZT\":385.27031,\"USDLAK\":8691.999617,\"USDLBP\":1512.850008,\"USDLKR\":176.200716,\"USDLRD\":202.375015,\"USDLSL\":14.220064,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.40499,\"USDMAD\":9.604797,\"USDMDL\":17.7245,\"USDMGA\":3617.999725,\"USDMKD\":54.664982,\"USDMMK\":1508.349615,\"USDMNT\":2660.947896,\"USDMOP\":8.057799,\"USDMRO\":357.000346,\"USDMUR\":35.950501,\"USDMVR\":15.450292,\"USDMWK\":752.489976,\"USDMXN\":19.08058,\"USDMYR\":4.120902,\"USDMZN\":61.649717,\"USDNAD\":14.220191,\"USDNGN\":359.999834,\"USDNIO\":33.4682,\"USDNOK\":8.702085,\"USDNPR\":110.139803,\"USDNZD\":1.509045,\"USDOMR\":0.385021,\"USDPAB\":1.00045,\"USDPEN\":3.300601,\"USDPGK\":3.397798,\"USDPHP\":51.015501,\"USDPKR\":161.124979,\"USDPLN\":3.849932,\"USDPYG\":5998.095699,\"USDQAR\":3.64075,\"USDRON\":4.245797,\"USDRSD\":105.700254,\"USDRUB\":63.461993,\"USDRWF\":912.5,\"USDSAR\":3.75065,\"USDSBD\":8.238501,\"USDSCR\":13.667985,\"USDSDG\":45.135977,\"USDSEK\":9.485899,\"USDSGD\":1.370406,\"USDSHP\":1.320904,\"USDSLL\":9100.000127,\"USDSOS\":579.99982,\"USDSRD\":7.458,\"USDSTD\":21560.79,\"USDSVC\":8.75475,\"USDSYP\":515.000107,\"USDSZL\":14.220553,\"USDTHB\":30.860076,\"USDTJS\":9.440104,\"USDTMT\":3.51,\"USDTND\":2.883503,\"USDTOP\":2.28525,\"USDTRY\":5.618565,\"USDTTD\":6.77735,\"USDTWD\":31.101982,\"USDTZS\":2298.999711,\"USDUAH\":25.390483,\"USDUGX\":3701.949962,\"USDUSD\":1,\"USDUYU\":34.160314,\"USDUZS\":8670.000205,\"USDVEF\":9.9875,\"USDVND\":23210,\"USDVUV\":116.11159,\"USDWST\":2.628824,\"USDXAF\":589.979838,\"USDXAG\":0.06095,\"USDXAU\":0.000704,\"USDXCD\":2.70245,\"USDXDR\":0.72725,\"USDXOF\":590.00028,\"USDXPF\":107.649814,\"USDYER\":250.401015,\"USDZAR\":14.199729,\"USDZMK\":9001.201218,\"USDZMW\":12.905986,\"USDZWL\":322.000001}}', 1, '2019-07-29 16:08:05', '2019-07-29 16:38:08', '2019-07-29 16:38:08', 'USD'),
(801, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564502886,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673032,\"USDAFN\":80.149652,\"USDALL\":109.180302,\"USDAMD\":475.819933,\"USDANG\":1.77985,\"USDAOA\":349.573501,\"USDARS\":43.804975,\"USDAUD\":1.454785,\"USDAWG\":1.8,\"USDAZN\":1.704951,\"USDBAM\":1.7546,\"USDBBD\":2.0189,\"USDBDT\":84.464018,\"USDBGN\":1.754197,\"USDBHD\":0.376996,\"USDBIF\":1846,\"USDBMD\":1,\"USDBND\":1.350497,\"USDBOB\":6.91185,\"USDBRL\":3.786099,\"USDBSD\":0.9998,\"USDBTC\":0.000103,\"USDBTN\":68.914097,\"USDBWP\":10.697976,\"USDBYN\":2.033981,\"USDBYR\":19600,\"USDBZD\":2.01545,\"USDCAD\":1.316575,\"USDCDF\":1665.99978,\"USDCHF\":0.99043,\"USDCLF\":0.025383,\"USDCLP\":700.39917,\"USDCNY\":6.8845,\"USDCOP\":3299.7,\"USDCRC\":571.950404,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.043498,\"USDCZK\":23.015198,\"USDDJF\":177.719775,\"USDDKK\":6.69712,\"USDDOP\":51.225028,\"USDDZD\":119.780098,\"USDEGP\":16.560201,\"USDERN\":14.999927,\"USDETB\":29.04947,\"USDEUR\":0.89681,\"USDFJD\":2.15585,\"USDFKP\":0.82179,\"USDGBP\":0.822105,\"USDGEL\":2.934999,\"USDGGP\":0.822824,\"USDGHS\":5.38497,\"USDGIP\":0.82179,\"USDGMD\":49.984992,\"USDGNF\":9230.00011,\"USDGTQ\":7.69435,\"USDGYD\":208.484979,\"USDHKD\":7.82435,\"USDHNL\":24.650578,\"USDHRK\":6.6178,\"USDHTG\":94.44103,\"USDHUF\":293.675964,\"USDIDR\":14030.7,\"USDILS\":3.4944,\"USDIMP\":0.822824,\"USDINR\":68.848503,\"USDIQD\":1190,\"USDIRR\":42104.999924,\"USDISK\":120.799154,\"USDJEP\":0.822824,\"USDJMD\":136.03988,\"USDJOD\":0.707597,\"USDJPY\":108.635993,\"USDKES\":104.101286,\"USDKGS\":69.750402,\"USDKHR\":4084.999815,\"USDKMF\":441.639996,\"USDKPW\":900.066272,\"USDKRW\":1182.040023,\"USDKWD\":0.3045,\"USDKYD\":0.833255,\"USDKZT\":384.840596,\"USDLAK\":8692.49822,\"USDLBP\":1509.698252,\"USDLKR\":176.250275,\"USDLRD\":202.249731,\"USDLSL\":14.170256,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404983,\"USDMAD\":9.5983,\"USDMDL\":17.762972,\"USDMGA\":3625.000338,\"USDMKD\":55.154504,\"USDMMK\":1508.350115,\"USDMNT\":2665.560727,\"USDMOP\":8.05705,\"USDMRO\":357.000346,\"USDMUR\":36.252505,\"USDMVR\":15.449901,\"USDMWK\":752.48006,\"USDMXN\":19.080899,\"USDMYR\":4.125041,\"USDMZN\":61.570162,\"USDNAD\":14.169804,\"USDNGN\":360.000204,\"USDNIO\":33.520159,\"USDNOK\":8.75445,\"USDNPR\":110.174998,\"USDNZD\":1.512355,\"USDOMR\":0.384974,\"USDPAB\":0.99985,\"USDPEN\":3.29175,\"USDPGK\":3.397802,\"USDPHP\":50.82981,\"USDPKR\":160.625009,\"USDPLN\":3.854699,\"USDPYG\":6015.449703,\"USDQAR\":3.64175,\"USDRON\":4.244098,\"USDRSD\":105.559769,\"USDRUB\":63.622102,\"USDRWF\":910,\"USDSAR\":3.75075,\"USDSBD\":8.22855,\"USDSCR\":13.657979,\"USDSDG\":45.108498,\"USDSEK\":9.565125,\"USDSGD\":1.371015,\"USDSHP\":1.320899,\"USDSLL\":9250.000226,\"USDSOS\":580.499436,\"USDSRD\":7.458027,\"USDSTD\":21560.79,\"USDSVC\":8.748802,\"USDSYP\":514.999869,\"USDSZL\":14.170081,\"USDTHB\":30.797214,\"USDTJS\":9.42885,\"USDTMT\":3.5,\"USDTND\":2.87615,\"USDTOP\":2.287101,\"USDTRY\":5.55716,\"USDTTD\":6.77455,\"USDTWD\":31.096499,\"USDTZS\":2298.898722,\"USDUAH\":25.38982,\"USDUGX\":3704.700536,\"USDUSD\":1,\"USDUYU\":34.08971,\"USDUZS\":8670.999577,\"USDVEF\":9.987497,\"USDVND\":23205,\"USDVUV\":116.112063,\"USDWST\":2.630879,\"USDXAF\":588.48023,\"USDXAG\":0.060504,\"USDXAU\":0.0007,\"USDXCD\":2.70265,\"USDXDR\":0.72735,\"USDXOF\":589.999944,\"USDXPF\":107.450221,\"USDYER\":250.349544,\"USDZAR\":14.195701,\"USDZMK\":9001.199023,\"USDZMW\":12.878019,\"USDZWL\":322.000001}}', 1, '2019-07-30 16:08:06', '2019-07-30 16:33:38', '2019-07-30 16:33:38', 'USD'),
(802, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564589289,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67302,\"USDAFN\":80.050202,\"USDALL\":109.202991,\"USDAMD\":475.810239,\"USDANG\":1.78015,\"USDAOA\":349.573496,\"USDARS\":43.886948,\"USDAUD\":1.4525,\"USDAWG\":1.8,\"USDAZN\":1.704984,\"USDBAM\":1.754804,\"USDBBD\":2.0193,\"USDBDT\":84.455983,\"USDBGN\":1.758201,\"USDBHD\":0.376995,\"USDBIF\":1846,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.91185,\"USDBRL\":3.758402,\"USDBSD\":0.99965,\"USDBTC\":0.000099543672,\"USDBTN\":68.9141,\"USDBWP\":10.698001,\"USDBYN\":2.03355,\"USDBYR\":19600,\"USDBZD\":2.01585,\"USDCAD\":1.314515,\"USDCDF\":1666.000147,\"USDCHF\":0.990465,\"USDCLF\":0.025405,\"USDCLP\":700.995056,\"USDCNY\":6.884297,\"USDCOP\":3291.8,\"USDCRC\":572.115022,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.001503,\"USDCZK\":23.089695,\"USDDJF\":177.719664,\"USDDKK\":6.711397,\"USDDOP\":51.204981,\"USDDZD\":119.809934,\"USDEGP\":16.5503,\"USDERN\":14.999378,\"USDETB\":29.050255,\"USDEUR\":0.89874,\"USDFJD\":2.15945,\"USDFKP\":0.822014,\"USDGBP\":0.819099,\"USDGEL\":2.979603,\"USDGGP\":0.818965,\"USDGHS\":5.390269,\"USDGIP\":0.821985,\"USDGMD\":49.954964,\"USDGNF\":9225.000403,\"USDGTQ\":7.69585,\"USDGYD\":208.539728,\"USDHKD\":7.82784,\"USDHNL\":24.691978,\"USDHRK\":6.636496,\"USDHTG\":94.540502,\"USDHUF\":292.670447,\"USDIDR\":14025.3,\"USDILS\":3.49635,\"USDIMP\":0.818965,\"USDINR\":68.862035,\"USDIQD\":1190,\"USDIRR\":42104.999905,\"USDISK\":121.419982,\"USDJEP\":0.818965,\"USDJMD\":136.019672,\"USDJOD\":0.709101,\"USDJPY\":108.586965,\"USDKES\":104.149903,\"USDKGS\":69.753596,\"USDKHR\":4083.000419,\"USDKMF\":442.301071,\"USDKPW\":900.078641,\"USDKRW\":1182.906089,\"USDKWD\":0.3044,\"USDKYD\":0.83343,\"USDKZT\":384.46997,\"USDLAK\":8694.999881,\"USDLBP\":1507.550166,\"USDLKR\":176.310029,\"USDLRD\":202.774965,\"USDLSL\":14.210097,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.403992,\"USDMAD\":9.61495,\"USDMDL\":17.801979,\"USDMGA\":3665.000493,\"USDMKD\":55.179028,\"USDMMK\":1508.394877,\"USDMNT\":2665.855827,\"USDMOP\":8.061701,\"USDMRO\":357.000346,\"USDMUR\":36.197614,\"USDMVR\":15.396907,\"USDMWK\":741.585055,\"USDMXN\":18.993802,\"USDMYR\":4.120603,\"USDMZN\":61.470181,\"USDNAD\":14.210028,\"USDNGN\":360.000345,\"USDNIO\":33.550273,\"USDNOK\":8.789075,\"USDNPR\":110.085008,\"USDNZD\":1.516485,\"USDOMR\":0.385027,\"USDPAB\":0.99965,\"USDPEN\":3.295403,\"USDPGK\":3.397799,\"USDPHP\":50.847966,\"USDPKR\":160.570172,\"USDPLN\":3.85055,\"USDPYG\":6007.101748,\"USDQAR\":3.64075,\"USDRON\":4.251402,\"USDRSD\":105.749915,\"USDRUB\":63.428502,\"USDRWF\":917.5,\"USDSAR\":3.75095,\"USDSBD\":8.17585,\"USDSCR\":13.703976,\"USDSDG\":45.117979,\"USDSEK\":9.598102,\"USDSGD\":1.36903,\"USDSHP\":1.320901,\"USDSLL\":9199.999907,\"USDSOS\":580.000319,\"USDSRD\":7.45804,\"USDSTD\":21560.79,\"USDSVC\":8.751502,\"USDSYP\":515.000232,\"USDSZL\":14.209942,\"USDTHB\":30.690064,\"USDTJS\":9.43605,\"USDTMT\":3.51,\"USDTND\":2.877703,\"USDTOP\":2.292598,\"USDTRY\":5.546335,\"USDTTD\":6.77505,\"USDTWD\":31.101522,\"USDTZS\":2298.999625,\"USDUAH\":25.099014,\"USDUGX\":3700.401218,\"USDUSD\":1,\"USDUYU\":34.199432,\"USDUZS\":8659.999821,\"USDVEF\":9.9875,\"USDVND\":23208.5,\"USDVUV\":116.381924,\"USDWST\":2.634339,\"USDXAF\":588.440232,\"USDXAG\":0.06093,\"USDXAU\":0.0007,\"USDXCD\":2.70265,\"USDXDR\":0.727124,\"USDXOF\":592.49611,\"USDXPF\":107.550052,\"USDYER\":250.350112,\"USDZAR\":14.16165,\"USDZMK\":9001.199675,\"USDZMW\":12.876022,\"USDZWL\":322.000001}}', 1, '2019-07-31 16:08:09', '2019-07-31 16:22:44', '2019-07-31 16:22:44', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(803, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564675685,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672905,\"USDAFN\":80.050292,\"USDALL\":109.860115,\"USDAMD\":475.910138,\"USDANG\":1.785301,\"USDAOA\":351.876033,\"USDARS\":44.349901,\"USDAUD\":1.458335,\"USDAWG\":1.8,\"USDAZN\":1.704993,\"USDBAM\":1.7729,\"USDBBD\":2.01945,\"USDBDT\":84.511958,\"USDBGN\":1.768499,\"USDBHD\":0.377011,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350503,\"USDBOB\":6.91615,\"USDBRL\":3.836301,\"USDBSD\":1.00025,\"USDBTC\":0.000099822954,\"USDBTN\":68.914096,\"USDBWP\":10.801976,\"USDBYN\":2.04655,\"USDBYR\":19600,\"USDBZD\":2.016102,\"USDCAD\":1.320365,\"USDCDF\":1664.999991,\"USDCHF\":0.993655,\"USDCLF\":0.025554,\"USDCLP\":705.208989,\"USDCNY\":6.898699,\"USDCOP\":3326.15,\"USDCRC\":571.809539,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.299503,\"USDCZK\":23.291001,\"USDDJF\":177.719969,\"USDDKK\":6.75081,\"USDDOP\":51.195002,\"USDDZD\":120.109772,\"USDEGP\":16.545021,\"USDERN\":14.999873,\"USDETB\":29.02992,\"USDEUR\":0.904115,\"USDFJD\":2.16385,\"USDFKP\":0.826203,\"USDGBP\":0.823902,\"USDGEL\":2.970139,\"USDGGP\":0.823647,\"USDGHS\":5.394963,\"USDGIP\":0.82619,\"USDGMD\":49.985011,\"USDGNF\":9224.99995,\"USDGTQ\":7.681397,\"USDGYD\":208.65497,\"USDHKD\":7.827016,\"USDHNL\":24.598512,\"USDHRK\":6.674985,\"USDHTG\":94.717499,\"USDHUF\":295.758003,\"USDIDR\":14127.3,\"USDILS\":3.510097,\"USDIMP\":0.823647,\"USDINR\":68.959912,\"USDIQD\":1190,\"USDIRR\":42104.999872,\"USDISK\":123.220274,\"USDJEP\":0.823647,\"USDJMD\":135.630296,\"USDJOD\":0.709047,\"USDJPY\":108.256496,\"USDKES\":103.249748,\"USDKGS\":69.763802,\"USDKHR\":4083.000302,\"USDKMF\":442.299262,\"USDKPW\":900.066052,\"USDKRW\":1187.029827,\"USDKWD\":0.304696,\"USDKYD\":0.83351,\"USDKZT\":385.280246,\"USDLAK\":8705.000203,\"USDLBP\":1507.549924,\"USDLKR\":176.510015,\"USDLRD\":202.850112,\"USDLSL\":14.209743,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404987,\"USDMAD\":9.646502,\"USDMDL\":17.858506,\"USDMGA\":3653.999951,\"USDMKD\":55.748497,\"USDMMK\":1512.850114,\"USDMNT\":2665.896845,\"USDMOP\":8.061302,\"USDMRO\":357.000346,\"USDMUR\":36.254502,\"USDMVR\":15.405751,\"USDMWK\":743.974984,\"USDMXN\":19.17633,\"USDMYR\":4.145505,\"USDMZN\":61.314992,\"USDNAD\":14.209604,\"USDNGN\":360.00044,\"USDNIO\":33.503087,\"USDNOK\":8.87157,\"USDNPR\":110.540242,\"USDNZD\":1.523896,\"USDOMR\":0.38498,\"USDPAB\":1.00025,\"USDPEN\":3.31485,\"USDPGK\":3.397799,\"USDPHP\":51.090429,\"USDPKR\":160.496907,\"USDPLN\":3.89185,\"USDPYG\":5993.650222,\"USDQAR\":3.64075,\"USDRON\":4.2775,\"USDRSD\":106.420313,\"USDRUB\":63.898099,\"USDRWF\":915,\"USDSAR\":3.75135,\"USDSBD\":8.20555,\"USDSCR\":13.684028,\"USDSDG\":45.12096,\"USDSEK\":9.64888,\"USDSGD\":1.37213,\"USDSHP\":1.320899,\"USDSLL\":9224.99978,\"USDSOS\":579.999831,\"USDSRD\":7.458001,\"USDSTD\":21560.79,\"USDSVC\":8.75205,\"USDSYP\":514.999859,\"USDSZL\":14.209986,\"USDTHB\":30.839852,\"USDTJS\":9.431897,\"USDTMT\":3.51,\"USDTND\":2.89075,\"USDTOP\":2.29785,\"USDTRY\":5.56901,\"USDTTD\":6.76965,\"USDTWD\":31.153497,\"USDTZS\":2298.901894,\"USDUAH\":25.398011,\"USDUGX\":3700.701643,\"USDUSD\":1,\"USDUYU\":34.33953,\"USDUZS\":8655.000225,\"USDVEF\":9.987498,\"USDVND\":23208.5,\"USDVUV\":116.381775,\"USDWST\":2.641996,\"USDXAF\":594.640215,\"USDXAG\":0.061968,\"USDXAU\":0.000706,\"USDXCD\":2.70265,\"USDXDR\":0.72895,\"USDXOF\":593.999803,\"USDXPF\":108.550331,\"USDYER\":250.350213,\"USDZAR\":14.52759,\"USDZMK\":9001.200376,\"USDZMW\":12.878036,\"USDZWL\":322.000001}}', 1, '2019-08-01 16:08:05', '2019-08-01 16:54:03', '2019-08-01 16:54:03', 'USD'),
(804, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564762085,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672973,\"USDAFN\":78.498339,\"USDALL\":109.398562,\"USDAMD\":475.896922,\"USDANG\":1.78355,\"USDAOA\":351.876013,\"USDARS\":44.73703,\"USDAUD\":1.469535,\"USDAWG\":1.801,\"USDAZN\":1.705019,\"USDBAM\":1.761202,\"USDBBD\":2.0174,\"USDBDT\":84.490373,\"USDBGN\":1.760196,\"USDBHD\":0.377024,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350696,\"USDBOB\":6.90425,\"USDBRL\":3.881097,\"USDBSD\":0.99925,\"USDBTC\":0.00009399278,\"USDBTN\":68.914102,\"USDBWP\":10.860977,\"USDBYN\":2.057702,\"USDBYR\":19600,\"USDBZD\":2.014096,\"USDCAD\":1.321635,\"USDCDF\":1664.999605,\"USDCHF\":0.98196,\"USDCLF\":0.025771,\"USDCLP\":711.19996,\"USDCNY\":6.940298,\"USDCOP\":3373.2,\"USDCRC\":571.074982,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.635497,\"USDCZK\":23.176014,\"USDDJF\":177.720022,\"USDDKK\":6.719499,\"USDDOP\":51.214973,\"USDDZD\":119.890257,\"USDEGP\":16.579499,\"USDERN\":14.999522,\"USDETB\":29.049672,\"USDEUR\":0.904736,\"USDFJD\":2.16105,\"USDFKP\":0.826103,\"USDGBP\":0.824175,\"USDGEL\":2.93002,\"USDGGP\":0.824463,\"USDGHS\":5.395014,\"USDGIP\":0.82611,\"USDGMD\":49.895014,\"USDGNF\":9244.999934,\"USDGTQ\":7.668699,\"USDGYD\":208.764983,\"USDHKD\":7.82897,\"USDHNL\":24.660168,\"USDHRK\":6.64345,\"USDHTG\":94.778503,\"USDHUF\":294.510132,\"USDIDR\":14223.9,\"USDILS\":3.49055,\"USDIMP\":0.824463,\"USDINR\":69.662988,\"USDIQD\":1190,\"USDIRR\":42105.000241,\"USDISK\":122.670311,\"USDJEP\":0.824463,\"USDJMD\":135.240143,\"USDJOD\":0.7081,\"USDJPY\":106.604992,\"USDKES\":103.05009,\"USDKGS\":69.787497,\"USDKHR\":4081.999962,\"USDKMF\":444.249965,\"USDKPW\":900.073726,\"USDKRW\":1203.797914,\"USDKWD\":0.304498,\"USDKYD\":0.83261,\"USDKZT\":385.859754,\"USDLAK\":8704.999891,\"USDLBP\":1507.750241,\"USDLKR\":176.660272,\"USDLRD\":203.000275,\"USDLSL\":14.732476,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395129,\"USDMAD\":9.608399,\"USDMDL\":17.811984,\"USDMGA\":3653.999665,\"USDMKD\":55.381501,\"USDMMK\":1512.250082,\"USDMNT\":2665.774805,\"USDMOP\":8.053021,\"USDMRO\":357.000346,\"USDMUR\":36.093498,\"USDMVR\":15.399684,\"USDMWK\":747.609858,\"USDMXN\":19.32542,\"USDMYR\":4.181597,\"USDMZN\":61.255002,\"USDNAD\":14.497594,\"USDNGN\":360.009983,\"USDNIO\":33.520044,\"USDNOK\":8.91462,\"USDNPR\":110.660464,\"USDNZD\":1.527696,\"USDOMR\":0.385029,\"USDPAB\":0.99905,\"USDPEN\":3.34955,\"USDPGK\":3.397804,\"USDPHP\":51.630105,\"USDPKR\":158.210021,\"USDPLN\":3.87545,\"USDPYG\":6041.949858,\"USDQAR\":3.64075,\"USDRON\":4.256599,\"USDRSD\":105.949872,\"USDRUB\":65.133495,\"USDRWF\":915,\"USDSAR\":3.751199,\"USDSBD\":8.20785,\"USDSCR\":13.741984,\"USDSDG\":45.069006,\"USDSEK\":9.64226,\"USDSGD\":1.375465,\"USDSHP\":1.320903,\"USDSLL\":9200.000083,\"USDSOS\":580.000284,\"USDSRD\":7.457975,\"USDSTD\":21560.79,\"USDSVC\":8.74215,\"USDSYP\":515.000058,\"USDSZL\":14.699699,\"USDTHB\":30.710028,\"USDTJS\":9.43195,\"USDTMT\":3.5,\"USDTND\":2.8842,\"USDTOP\":2.300502,\"USDTRY\":5.554803,\"USDTTD\":6.76285,\"USDTWD\":31.445498,\"USDTZS\":2299.300203,\"USDUAH\":25.397998,\"USDUGX\":3694.000203,\"USDUSD\":1,\"USDUYU\":34.330062,\"USDUZS\":8654.999889,\"USDVEF\":9.987498,\"USDVND\":23208.5,\"USDVUV\":117.142176,\"USDWST\":2.64689,\"USDXAF\":590.719723,\"USDXAG\":0.06131,\"USDXAU\":0.000691,\"USDXCD\":2.70265,\"USDXDR\":0.72805,\"USDXOF\":594.999918,\"USDXPF\":107.761434,\"USDYER\":250.3503,\"USDZAR\":14.680103,\"USDZMK\":9001.197673,\"USDZMW\":12.913951,\"USDZWL\":322.000001}}', 1, '2019-08-02 16:08:05', '2019-08-02 16:21:24', '2019-08-02 16:21:24', 'USD'),
(805, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1564934885,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672904,\"USDAFN\":80.050404,\"USDALL\":109.403989,\"USDAMD\":475.903986,\"USDANG\":1.78355,\"USDAOA\":351.876041,\"USDARS\":44.504041,\"USDAUD\":1.470204,\"USDAWG\":1.8,\"USDAZN\":1.705041,\"USDBAM\":1.761204,\"USDBBD\":2.0174,\"USDBDT\":84.490401,\"USDBGN\":1.761204,\"USDBHD\":0.37694,\"USDBIF\":1846,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.90425,\"USDBRL\":3.887304,\"USDBSD\":0.99925,\"USDBTC\":0.000095836324,\"USDBTN\":68.914104,\"USDBWP\":10.861041,\"USDBYN\":2.057704,\"USDBYR\":19600,\"USDBZD\":2.014104,\"USDCAD\":1.32295,\"USDCDF\":1666.000362,\"USDCHF\":0.982235,\"USDCLF\":0.025844,\"USDCLP\":713.105041,\"USDCNY\":6.940204,\"USDCOP\":3384.5,\"USDCRC\":571.075041,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.603897,\"USDCZK\":23.179604,\"USDDJF\":177.720394,\"USDDKK\":6.721104,\"USDDOP\":51.203886,\"USDDZD\":120.030393,\"USDEGP\":16.544504,\"USDERN\":15.000358,\"USDETB\":29.040392,\"USDEUR\":0.89851,\"USDFJD\":2.180392,\"USDFKP\":0.82608,\"USDGBP\":0.822435,\"USDGEL\":2.930391,\"USDGGP\":0.822359,\"USDGHS\":5.43039,\"USDGIP\":0.82608,\"USDGMD\":49.95039,\"USDGNF\":9240.000355,\"USDGTQ\":7.668704,\"USDGYD\":208.76504,\"USDHKD\":7.82935,\"USDHNL\":24.680389,\"USDHRK\":6.646204,\"USDHTG\":94.778504,\"USDHUF\":294.670388,\"USDIDR\":14231.75,\"USDILS\":3.49055,\"USDIMP\":0.822359,\"USDINR\":69.666904,\"USDIQD\":1190,\"USDIRR\":42105.000352,\"USDISK\":122.610386,\"USDJEP\":0.822359,\"USDJMD\":135.240386,\"USDJOD\":0.708104,\"USDJPY\":106.58504,\"USDKES\":103.050385,\"USDKGS\":69.787504,\"USDKHR\":4080.000351,\"USDKMF\":443.303796,\"USDKPW\":899.534063,\"USDKRW\":1204.610384,\"USDKWD\":0.30468,\"USDKYD\":0.83261,\"USDKZT\":385.860383,\"USDLAK\":8707.000349,\"USDLBP\":1508.000349,\"USDLKR\":176.660382,\"USDLRD\":202.925039,\"USDLSL\":14.770382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.410381,\"USDMAD\":9.62135,\"USDMDL\":17.812039,\"USDMGA\":3657.503758,\"USDMKD\":55.381504,\"USDMMK\":1512.25038,\"USDMNT\":2655.5,\"USDMOP\":8.053039,\"USDMRO\":357.000346,\"USDMUR\":36.099504,\"USDMVR\":15.403741,\"USDMWK\":735.000345,\"USDMXN\":19.306604,\"USDMYR\":4.157039,\"USDMZN\":61.255039,\"USDNAD\":14.770377,\"USDNGN\":361.503727,\"USDNIO\":33.403725,\"USDNOK\":8.917704,\"USDNPR\":110.660376,\"USDNZD\":1.529304,\"USDOMR\":0.385039,\"USDPAB\":0.99905,\"USDPEN\":3.356039,\"USDPGK\":3.392504,\"USDPHP\":51.625504,\"USDPKR\":159.550375,\"USDPLN\":3.880374,\"USDPYG\":6041.950374,\"USDQAR\":3.641038,\"USDRON\":4.254504,\"USDRSD\":105.990373,\"USDRUB\":65.273604,\"USDRWF\":915,\"USDSAR\":3.751304,\"USDSBD\":8.19445,\"USDSCR\":13.949504,\"USDSDG\":45.069038,\"USDSEK\":9.636504,\"USDSGD\":1.376804,\"USDSHP\":1.320904,\"USDSLL\":9225.000339,\"USDSOS\":579.000338,\"USDSRD\":7.458038,\"USDSTD\":21560.79,\"USDSVC\":8.74215,\"USDSYP\":515.000338,\"USDSZL\":14.77037,\"USDTHB\":30.653504,\"USDTJS\":9.43195,\"USDTMT\":3.51,\"USDTND\":2.888504,\"USDTOP\":2.300504,\"USDTRY\":5.559804,\"USDTTD\":6.76285,\"USDTWD\":31.465038,\"USDTZS\":2299.103635,\"USDUAH\":25.398038,\"USDUGX\":3694.000335,\"USDUSD\":1,\"USDUYU\":34.330367,\"USDUZS\":8667.503624,\"USDVEF\":9.987504,\"USDVND\":23208.5,\"USDVUV\":116.199997,\"USDWST\":2.691068,\"USDXAF\":590.720365,\"USDXAG\":0.061735,\"USDXAU\":0.000694,\"USDXCD\":2.70255,\"USDXDR\":0.728258,\"USDXOF\":590.503602,\"USDXPF\":107.750364,\"USDYER\":250.303597,\"USDZAR\":14.786704,\"USDZMK\":9001.203593,\"USDZMW\":12.914037,\"USDZWL\":322.000001}}', 1, '2019-08-04 16:08:05', '2019-08-05 11:42:54', '2019-08-05 11:42:54', 'USD'),
(806, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565021286,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673103,\"USDAFN\":79.149627,\"USDALL\":107.86023,\"USDAMD\":476.150155,\"USDANG\":1.78465,\"USDAOA\":351.876045,\"USDARS\":45.396005,\"USDAUD\":1.474701,\"USDAWG\":1.8,\"USDAZN\":1.705016,\"USDBAM\":1.75045,\"USDBBD\":2.01865,\"USDBDT\":84.473054,\"USDBGN\":1.747103,\"USDBHD\":0.376983,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.90565,\"USDBRL\":3.940698,\"USDBSD\":0.9994,\"USDBTC\":0.000084905017,\"USDBTN\":68.914097,\"USDBWP\":10.897205,\"USDBYN\":2.053989,\"USDBYR\":19600,\"USDBZD\":2.01525,\"USDCAD\":1.319645,\"USDCDF\":1664.99966,\"USDCHF\":0.97235,\"USDCLF\":0.026137,\"USDCLP\":721.306089,\"USDCNY\":7.050799,\"USDCOP\":3473.15,\"USDCRC\":571.419817,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.992501,\"USDCZK\":23.036027,\"USDDJF\":177.719956,\"USDDKK\":6.66547,\"USDDOP\":51.010347,\"USDDZD\":119.509905,\"USDEGP\":16.560185,\"USDERN\":15.000092,\"USDETB\":29.039973,\"USDEUR\":0.89303,\"USDFJD\":2.16545,\"USDFKP\":0.82198,\"USDGBP\":0.821895,\"USDGEL\":2.905007,\"USDGGP\":0.821956,\"USDGHS\":5.398884,\"USDGIP\":0.82198,\"USDGMD\":49.985024,\"USDGNF\":9224.99995,\"USDGTQ\":7.678195,\"USDGYD\":209.089613,\"USDHKD\":7.840725,\"USDHNL\":24.664981,\"USDHRK\":6.646301,\"USDHTG\":94.950104,\"USDHUF\":291.702004,\"USDIDR\":14335.55,\"USDILS\":3.487034,\"USDIMP\":0.821956,\"USDINR\":70.817967,\"USDIQD\":1190,\"USDIRR\":42105.000172,\"USDISK\":121.73002,\"USDJEP\":0.821956,\"USDJMD\":135.220174,\"USDJOD\":0.708982,\"USDJPY\":106.058499,\"USDKES\":103.119831,\"USDKGS\":69.823303,\"USDKHR\":4089.999949,\"USDKMF\":440.550111,\"USDKPW\":900.071024,\"USDKRW\":1219.104939,\"USDKWD\":0.304009,\"USDKYD\":0.83315,\"USDKZT\":386.590021,\"USDLAK\":8702.501015,\"USDLBP\":1511.050108,\"USDLKR\":176.940076,\"USDLRD\":202.999968,\"USDLSL\":14.769922,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404998,\"USDMAD\":9.557499,\"USDMDL\":17.861024,\"USDMGA\":3657.495986,\"USDMKD\":55.042019,\"USDMMK\":1515.103078,\"USDMNT\":2665.975283,\"USDMOP\":8.0691,\"USDMRO\":357.000346,\"USDMUR\":35.999502,\"USDMVR\":15.450217,\"USDMWK\":733.564975,\"USDMXN\":19.56603,\"USDMYR\":4.200981,\"USDMZN\":61.204997,\"USDNAD\":14.769503,\"USDNGN\":362.000327,\"USDNIO\":17.349894,\"USDNOK\":8.91966,\"USDNPR\":112.374989,\"USDNZD\":1.52943,\"USDOMR\":0.38505,\"USDPAB\":0.9994,\"USDPEN\":3.38145,\"USDPGK\":3.397798,\"USDPHP\":52.129752,\"USDPKR\":160.249702,\"USDPLN\":3.85735,\"USDPYG\":6026.350348,\"USDQAR\":3.64075,\"USDRON\":4.225802,\"USDRSD\":105.109713,\"USDRUB\":65.111963,\"USDRWF\":910,\"USDSAR\":3.75145,\"USDSBD\":8.19445,\"USDSCR\":13.696014,\"USDSDG\":45.096003,\"USDSEK\":9.61079,\"USDSGD\":1.381905,\"USDSHP\":1.3209,\"USDSLL\":9200.000105,\"USDSOS\":580.000308,\"USDSRD\":7.457965,\"USDSTD\":21560.79,\"USDSVC\":8.748497,\"USDSYP\":515.000117,\"USDSZL\":14.934987,\"USDTHB\":30.830996,\"USDTJS\":9.42785,\"USDTMT\":3.505,\"USDTND\":2.86005,\"USDTOP\":2.303649,\"USDTRY\":5.564298,\"USDTTD\":6.76465,\"USDTWD\":31.641503,\"USDTZS\":2299.19912,\"USDUAH\":25.702979,\"USDUGX\":3692.10312,\"USDUSD\":1,\"USDUYU\":34.590113,\"USDUZS\":8667.498062,\"USDVEF\":9.987504,\"USDVND\":23269,\"USDVUV\":117.192849,\"USDWST\":2.649695,\"USDXAF\":587.079806,\"USDXAG\":0.061183,\"USDXAU\":0.000683,\"USDXCD\":2.70265,\"USDXDR\":0.727156,\"USDXOF\":590.50639,\"USDXPF\":107.249682,\"USDYER\":250.34994,\"USDZAR\":14.867199,\"USDZMK\":9001.200967,\"USDZMW\":12.893031,\"USDZWL\":322.000001}}', 1, '2019-08-05 16:08:06', '2019-08-05 16:42:55', '2019-08-05 16:42:55', 'USD'),
(807, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565107686,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673199,\"USDAFN\":78.449865,\"USDALL\":108.039813,\"USDAMD\":476.189592,\"USDANG\":1.78535,\"USDAOA\":354.571979,\"USDARS\":45.37205,\"USDAUD\":1.47775,\"USDAWG\":1.8,\"USDAZN\":1.704968,\"USDBAM\":1.74615,\"USDBBD\":2.01945,\"USDBDT\":84.484972,\"USDBGN\":1.746299,\"USDBHD\":0.375979,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.90225,\"USDBRL\":3.973504,\"USDBSD\":0.9982,\"USDBTC\":0.000085543441,\"USDBTN\":68.9141,\"USDBWP\":10.906987,\"USDBYN\":2.05095,\"USDBYR\":19600,\"USDBZD\":2.01605,\"USDCAD\":1.325675,\"USDCDF\":1664.999812,\"USDCHF\":0.97753,\"USDCLF\":0.02596,\"USDCLP\":716.303335,\"USDCNY\":7.026398,\"USDCOP\":3430.85,\"USDCRC\":572.270366,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.640496,\"USDCZK\":22.987011,\"USDDJF\":177.719889,\"USDDKK\":6.665199,\"USDDOP\":50.965006,\"USDDZD\":119.529837,\"USDEGP\":16.551976,\"USDERN\":15.000135,\"USDETB\":29.050242,\"USDEUR\":0.89293,\"USDFJD\":2.17265,\"USDFKP\":0.82061,\"USDGBP\":0.82352,\"USDGEL\":2.925044,\"USDGGP\":0.823098,\"USDGHS\":5.403721,\"USDGIP\":0.82058,\"USDGMD\":49.995002,\"USDGNF\":9224.999938,\"USDGTQ\":7.671297,\"USDGYD\":206.989836,\"USDHKD\":7.83867,\"USDHNL\":24.629783,\"USDHRK\":6.592704,\"USDHTG\":95.119023,\"USDHUF\":290.261972,\"USDIDR\":14316.35,\"USDILS\":3.484499,\"USDIMP\":0.823098,\"USDINR\":71.0345,\"USDIQD\":1191.5,\"USDIRR\":42104.999874,\"USDISK\":121.879766,\"USDJEP\":0.823098,\"USDJMD\":134.750254,\"USDJOD\":0.708902,\"USDJPY\":106.4325,\"USDKES\":103.354984,\"USDKGS\":69.839302,\"USDKHR\":4089.999718,\"USDKMF\":440.449532,\"USDKPW\":900.074448,\"USDKRW\":1213.596076,\"USDKWD\":0.304199,\"USDKYD\":0.83352,\"USDKZT\":387.409758,\"USDLAK\":8700.999713,\"USDLBP\":1509.749939,\"USDLKR\":177.529635,\"USDLRD\":202.999662,\"USDLSL\":14.830035,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.400902,\"USDMAD\":9.560503,\"USDMDL\":17.807978,\"USDMGA\":3649.999933,\"USDMKD\":54.906995,\"USDMMK\":1510.750287,\"USDMNT\":2665.73983,\"USDMOP\":8.07265,\"USDMRO\":357.000346,\"USDMUR\":36.302501,\"USDMVR\":15.45012,\"USDMWK\":735.205005,\"USDMXN\":19.62047,\"USDMYR\":4.192804,\"USDMZN\":61.069854,\"USDNAD\":14.830173,\"USDNGN\":362.490082,\"USDNIO\":33.480324,\"USDNOK\":8.90768,\"USDNPR\":113.145019,\"USDNZD\":1.53259,\"USDOMR\":0.38495,\"USDPAB\":0.99825,\"USDPEN\":3.386503,\"USDPGK\":3.3978,\"USDPHP\":52.062017,\"USDPKR\":160.249887,\"USDPLN\":3.8541,\"USDPYG\":6031.549915,\"USDQAR\":3.640964,\"USDRON\":4.223499,\"USDRSD\":105.109883,\"USDRUB\":65.197993,\"USDRWF\":914,\"USDSAR\":3.75135,\"USDSBD\":8.22401,\"USDSCR\":13.683009,\"USDSDG\":45.119498,\"USDSEK\":9.588185,\"USDSGD\":1.381235,\"USDSHP\":1.320897,\"USDSLL\":9199.999967,\"USDSOS\":580.000591,\"USDSRD\":7.458014,\"USDSTD\":21560.79,\"USDSVC\":8.75215,\"USDSYP\":514.999835,\"USDSZL\":14.830014,\"USDTHB\":30.715997,\"USDTJS\":9.438703,\"USDTMT\":3.51,\"USDTND\":2.858498,\"USDTOP\":2.30525,\"USDTRY\":5.508697,\"USDTTD\":6.75625,\"USDTWD\":31.503954,\"USDTZS\":2298.263464,\"USDUAH\":25.570021,\"USDUGX\":3693.602654,\"USDUSD\":1,\"USDUYU\":34.769862,\"USDUZS\":8715.000561,\"USDVEF\":9.987498,\"USDVND\":23255,\"USDVUV\":117.403162,\"USDWST\":2.649695,\"USDXAF\":585.64007,\"USDXAG\":0.060914,\"USDXAU\":0.000681,\"USDXCD\":2.70265,\"USDXDR\":0.726825,\"USDXOF\":585.640037,\"USDXPF\":107.224983,\"USDYER\":250.35015,\"USDZAR\":14.932005,\"USDZMK\":9001.199115,\"USDZMW\":12.902006,\"USDZWL\":322.000001}}', 1, '2019-08-06 16:08:06', '2019-08-07 10:20:44', '2019-08-07 10:20:44', 'USD'),
(808, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565194085,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673098,\"USDAFN\":78.249779,\"USDALL\":107.909846,\"USDAMD\":476.470253,\"USDANG\":1.784505,\"USDAOA\":355.550498,\"USDARS\":45.709714,\"USDAUD\":1.480155,\"USDAWG\":1.8,\"USDAZN\":1.704986,\"USDBAM\":1.748199,\"USDBBD\":2.01855,\"USDBDT\":84.481969,\"USDBGN\":1.740995,\"USDBHD\":0.37699,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350697,\"USDBOB\":6.90665,\"USDBRL\":3.98715,\"USDBSD\":0.99885,\"USDBTC\":0.000085646209,\"USDBTN\":68.914104,\"USDBWP\":10.908005,\"USDBYN\":2.04495,\"USDBYR\":19600,\"USDBZD\":2.015202,\"USDCAD\":1.333335,\"USDCDF\":1664.999602,\"USDCHF\":0.97055,\"USDCLF\":0.026076,\"USDCLP\":719.505015,\"USDCNY\":7.060201,\"USDCOP\":3428,\"USDCRC\":571.805016,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.610502,\"USDCZK\":22.937025,\"USDDJF\":177.719791,\"USDDKK\":6.642694,\"USDDOP\":51.065018,\"USDDZD\":119.389857,\"USDEGP\":16.550502,\"USDERN\":15.000004,\"USDETB\":28.846496,\"USDEUR\":0.89007,\"USDFJD\":2.17345,\"USDFKP\":0.824105,\"USDGBP\":0.82245,\"USDGEL\":2.930113,\"USDGGP\":0.822527,\"USDGHS\":5.395007,\"USDGIP\":0.824115,\"USDGMD\":49.995026,\"USDGNF\":9225.000122,\"USDGTQ\":7.6703,\"USDGYD\":206.890432,\"USDHKD\":7.84305,\"USDHNL\":24.478007,\"USDHRK\":6.5707,\"USDHTG\":95.005979,\"USDHUF\":290.254025,\"USDIDR\":14231.75,\"USDILS\":3.479698,\"USDIMP\":0.822527,\"USDINR\":71.155009,\"USDIQD\":1191,\"USDIRR\":42105.000213,\"USDISK\":122.21007,\"USDJEP\":0.822527,\"USDJMD\":134.96022,\"USDJOD\":0.7081,\"USDJPY\":105.611996,\"USDKES\":103.490271,\"USDKGS\":69.834502,\"USDKHR\":4090.000055,\"USDKMF\":439.149813,\"USDKPW\":900.079473,\"USDKRW\":1219.201534,\"USDKWD\":0.30397,\"USDKYD\":0.833055,\"USDKZT\":387.520297,\"USDLAK\":8701.00031,\"USDLBP\":1509.749755,\"USDLKR\":177.406916,\"USDLRD\":203.000244,\"USDLSL\":14.949761,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.395015,\"USDMAD\":9.539912,\"USDMDL\":17.744982,\"USDMGA\":3673.949687,\"USDMKD\":54.97201,\"USDMMK\":1508.549459,\"USDMNT\":2666.259828,\"USDMOP\":8.07305,\"USDMRO\":357.000346,\"USDMUR\":35.850078,\"USDMVR\":15.450321,\"USDMWK\":730.534951,\"USDMXN\":19.67715,\"USDMYR\":4.206499,\"USDMZN\":60.8977,\"USDNAD\":14.950088,\"USDNGN\":363.000565,\"USDNIO\":33.515045,\"USDNOK\":8.965795,\"USDNPR\":112.949797,\"USDNZD\":1.547465,\"USDOMR\":0.384981,\"USDPAB\":0.99865,\"USDPEN\":3.37985,\"USDPGK\":3.397794,\"USDPHP\":52.370246,\"USDPKR\":159.750061,\"USDPLN\":3.84675,\"USDPYG\":6077.200068,\"USDQAR\":3.64175,\"USDRON\":4.209596,\"USDRSD\":104.750163,\"USDRUB\":65.57297,\"USDRWF\":912.5,\"USDSAR\":3.75125,\"USDSBD\":8.23395,\"USDSCR\":13.707962,\"USDSDG\":45.100498,\"USDSEK\":9.62788,\"USDSGD\":1.382975,\"USDSHP\":1.320903,\"USDSLL\":9275.000065,\"USDSOS\":580.000277,\"USDSRD\":7.458003,\"USDSTD\":21560.79,\"USDSVC\":8.747097,\"USDSYP\":514.999902,\"USDSZL\":15.139602,\"USDTHB\":30.805499,\"USDTJS\":9.43285,\"USDTMT\":3.51,\"USDTND\":2.856051,\"USDTOP\":2.30635,\"USDTRY\":5.489398,\"USDTTD\":6.75985,\"USDTWD\":31.516033,\"USDTZS\":2299.098365,\"USDUAH\":25.569735,\"USDUGX\":3693.949837,\"USDUSD\":1,\"USDUYU\":35.149744,\"USDUZS\":8700.000275,\"USDVEF\":9.9875,\"USDVND\":23216,\"USDVUV\":117.353283,\"USDWST\":2.649695,\"USDXAF\":586.320268,\"USDXAG\":0.058518,\"USDXAU\":0.000664,\"USDXCD\":2.70265,\"USDXDR\":0.726178,\"USDXOF\":586.329892,\"USDXPF\":106.729687,\"USDYER\":250.350111,\"USDZAR\":15.067198,\"USDZMK\":9001.201395,\"USDZMW\":13.000972,\"USDZWL\":322.000001}}', 1, '2019-08-07 16:08:05', '2019-08-07 17:57:06', '2019-08-07 17:57:06', 'USD'),
(809, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565280489,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673103,\"USDAFN\":78.349784,\"USDALL\":108.349832,\"USDAMD\":476.20964,\"USDANG\":1.78525,\"USDAOA\":358.624505,\"USDARS\":45.377197,\"USDAUD\":1.467983,\"USDAWG\":1.8,\"USDAZN\":1.705028,\"USDBAM\":1.746399,\"USDBBD\":2.01935,\"USDBDT\":84.507956,\"USDBGN\":1.745905,\"USDBHD\":0.376898,\"USDBIF\":1845,\"USDBMD\":1,\"USDBND\":1.350698,\"USDBOB\":6.91615,\"USDBRL\":3.937096,\"USDBSD\":1.00025,\"USDBTC\":0.000085536746,\"USDBTN\":68.914105,\"USDBWP\":11.015003,\"USDBYN\":2.04575,\"USDBYR\":19600,\"USDBZD\":2.01595,\"USDCAD\":1.32415,\"USDCDF\":1665.000507,\"USDCHF\":0.97517,\"USDCLF\":0.025738,\"USDCLP\":710.196955,\"USDCNY\":7.045205,\"USDCOP\":3392.5,\"USDCRC\":572.390192,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.815497,\"USDCZK\":23.00803,\"USDDJF\":177.720057,\"USDDKK\":6.657201,\"USDDOP\":51.245021,\"USDDZD\":119.470202,\"USDEGP\":16.564012,\"USDERN\":15.000186,\"USDETB\":29.050378,\"USDEUR\":0.891996,\"USDFJD\":2.17905,\"USDFKP\":0.822889,\"USDGBP\":0.82408,\"USDGEL\":2.929839,\"USDGGP\":0.823919,\"USDGHS\":5.397922,\"USDGIP\":0.82292,\"USDGMD\":50.075041,\"USDGNF\":9225.00035,\"USDGTQ\":7.666202,\"USDGYD\":208.719517,\"USDHKD\":7.84035,\"USDHNL\":24.669774,\"USDHRK\":6.586501,\"USDHTG\":94.597977,\"USDHUF\":289.187014,\"USDIDR\":14171.2,\"USDILS\":3.475895,\"USDIMP\":0.823919,\"USDINR\":70.459011,\"USDIQD\":1191,\"USDIRR\":42105.000234,\"USDISK\":122.469953,\"USDJEP\":0.823919,\"USDJMD\":134.789908,\"USDJOD\":0.70896,\"USDJPY\":106.048502,\"USDKES\":103.394993,\"USDKGS\":69.843102,\"USDKHR\":4090.502771,\"USDKMF\":439.650338,\"USDKPW\":900.082006,\"USDKRW\":1207.602791,\"USDKWD\":0.304204,\"USDKYD\":0.83347,\"USDKZT\":387.950262,\"USDLAK\":8701.000196,\"USDLBP\":1507.950599,\"USDLKR\":176.879974,\"USDLRD\":202.99971,\"USDLSL\":15.080111,\"USDLTL\":2.95274,\"USDLVL\":0.604889,\"USDLYD\":1.403104,\"USDMAD\":9.53895,\"USDMDL\":17.636957,\"USDMGA\":3665.000541,\"USDMKD\":54.916971,\"USDMMK\":1509.2503,\"USDMNT\":2665.011671,\"USDMOP\":8.078603,\"USDMRO\":357.000346,\"USDMUR\":35.850498,\"USDMVR\":15.449731,\"USDMWK\":730.434966,\"USDMXN\":19.49936,\"USDMYR\":4.185012,\"USDMZN\":60.65503,\"USDNAD\":15.080153,\"USDNGN\":363.000054,\"USDNIO\":33.549608,\"USDNOK\":8.91909,\"USDNPR\":112.905013,\"USDNZD\":1.542701,\"USDOMR\":0.385013,\"USDPAB\":1.00025,\"USDPEN\":3.38225,\"USDPGK\":3.397799,\"USDPHP\":51.917992,\"USDPKR\":159.874989,\"USDPLN\":3.85414,\"USDPYG\":6105.896448,\"USDQAR\":3.64104,\"USDRON\":4.214501,\"USDRSD\":104.930551,\"USDRUB\":65.130994,\"USDRWF\":910,\"USDSAR\":3.75125,\"USDSBD\":8.24175,\"USDSCR\":13.704005,\"USDSDG\":45.120502,\"USDSEK\":9.577039,\"USDSGD\":1.38127,\"USDSHP\":1.320903,\"USDSLL\":9324.999374,\"USDSOS\":579.999708,\"USDSRD\":7.458003,\"USDSTD\":21560.79,\"USDSVC\":8.751704,\"USDSYP\":514.999786,\"USDSZL\":15.08041,\"USDTHB\":30.765499,\"USDTJS\":9.43125,\"USDTMT\":3.51,\"USDTND\":2.8649,\"USDTOP\":2.31115,\"USDTRY\":5.456396,\"USDTTD\":6.76685,\"USDTWD\":31.247498,\"USDTZS\":2300.299178,\"USDUAH\":25.253961,\"USDUGX\":3700.601981,\"USDUSD\":1,\"USDUYU\":35.169625,\"USDUZS\":8700.000096,\"USDVEF\":9.987495,\"USDVND\":23210,\"USDVUV\":117.440928,\"USDWST\":2.669991,\"USDXAF\":585.730006,\"USDXAG\":0.058961,\"USDXAU\":0.000667,\"USDXCD\":2.70255,\"USDXDR\":0.726664,\"USDXOF\":584.999697,\"USDXPF\":107.020336,\"USDYER\":250.350189,\"USDZAR\":15.037994,\"USDZMK\":9001.197348,\"USDZMW\":12.983026,\"USDZWL\":322.000001}}', 1, '2019-08-08 16:08:09', '2019-08-08 16:52:34', '2019-08-08 16:52:34', 'USD'),
(810, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565366886,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672997,\"USDAFN\":80.05021,\"USDALL\":107.929714,\"USDAMD\":476.129742,\"USDANG\":1.78565,\"USDAOA\":358.624495,\"USDARS\":45.439918,\"USDAUD\":1.471703,\"USDAWG\":1.8,\"USDAZN\":1.705011,\"USDBAM\":1.746025,\"USDBBD\":2.01985,\"USDBDT\":84.444995,\"USDBGN\":1.742701,\"USDBHD\":0.376898,\"USDBIF\":1849,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.91265,\"USDBRL\":3.941498,\"USDBSD\":1.00045,\"USDBTC\":0.000084774011,\"USDBTN\":68.914103,\"USDBWP\":11.041958,\"USDBYN\":2.04395,\"USDBYR\":19600,\"USDBZD\":2.01645,\"USDCAD\":1.322635,\"USDCDF\":1668.000059,\"USDCHF\":0.971505,\"USDCLF\":0.025829,\"USDCLP\":712.494061,\"USDCNY\":7.062398,\"USDCOP\":3395.7,\"USDCRC\":570.61972,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.780501,\"USDCZK\":23.03255,\"USDDJF\":177.720163,\"USDDKK\":6.65299,\"USDDOP\":51.244973,\"USDDZD\":119.439904,\"USDEGP\":16.550502,\"USDERN\":15.000142,\"USDETB\":29.010976,\"USDEUR\":0.89143,\"USDFJD\":2.17245,\"USDFKP\":0.827005,\"USDGBP\":0.827701,\"USDGEL\":2.934957,\"USDGGP\":0.827683,\"USDGHS\":5.412015,\"USDGIP\":0.82699,\"USDGMD\":50.124967,\"USDGNF\":9240.000364,\"USDGTQ\":7.66775,\"USDGYD\":207.045022,\"USDHKD\":7.842595,\"USDHNL\":24.495498,\"USDHRK\":6.585597,\"USDHTG\":94.754974,\"USDHUF\":289.363006,\"USDIDR\":14241.9,\"USDILS\":3.478009,\"USDIMP\":0.827683,\"USDINR\":70.996986,\"USDIQD\":1190,\"USDIRR\":42105.000573,\"USDISK\":122.589973,\"USDJEP\":0.827683,\"USDJMD\":134.696378,\"USDJOD\":0.708032,\"USDJPY\":105.384502,\"USDKES\":103.120034,\"USDKGS\":69.793799,\"USDKHR\":4091.507367,\"USDKMF\":439.104833,\"USDKPW\":900.075598,\"USDKRW\":1215.892847,\"USDKWD\":0.304202,\"USDKYD\":0.833635,\"USDKZT\":387.870319,\"USDLAK\":8703.000253,\"USDLBP\":1508.249843,\"USDLKR\":176.889649,\"USDLRD\":202.999738,\"USDLSL\":15.079851,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.392896,\"USDMAD\":9.541202,\"USDMDL\":17.556499,\"USDMGA\":3673.802491,\"USDMKD\":54.903497,\"USDMMK\":1510.549882,\"USDMNT\":2667.545834,\"USDMOP\":8.07755,\"USDMRO\":357.000346,\"USDMUR\":35.851008,\"USDMVR\":15.450116,\"USDMWK\":730.08498,\"USDMXN\":19.430798,\"USDMYR\":4.193497,\"USDMZN\":60.72025,\"USDNAD\":15.080076,\"USDNGN\":363.87986,\"USDNIO\":33.536502,\"USDNOK\":8.88339,\"USDNPR\":112.939863,\"USDNZD\":1.544285,\"USDOMR\":0.385027,\"USDPAB\":1.00025,\"USDPEN\":3.385505,\"USDPGK\":3.382101,\"USDPHP\":52.05098,\"USDPKR\":157.49942,\"USDPLN\":3.85577,\"USDPYG\":6091.649906,\"USDQAR\":3.640997,\"USDRON\":4.211198,\"USDRSD\":104.820007,\"USDRUB\":65.486995,\"USDRWF\":915,\"USDSAR\":3.75145,\"USDSBD\":8.24175,\"USDSCR\":14.00975,\"USDSDG\":45.122496,\"USDSEK\":9.547639,\"USDSGD\":1.3845,\"USDSHP\":1.320905,\"USDSLL\":9374.99953,\"USDSOS\":579.999743,\"USDSRD\":7.458039,\"USDSTD\":21560.79,\"USDSVC\":8.75325,\"USDSYP\":515.000272,\"USDSZL\":15.080073,\"USDTHB\":30.790372,\"USDTJS\":9.4452,\"USDTMT\":3.51,\"USDTND\":2.8521,\"USDTOP\":2.30795,\"USDTRY\":5.507405,\"USDTTD\":6.77545,\"USDTWD\":31.395937,\"USDTZS\":2299.303834,\"USDUAH\":25.253971,\"USDUGX\":3703.350271,\"USDUSD\":1,\"USDUYU\":35.319627,\"USDUZS\":8705.450186,\"USDVEF\":9.987505,\"USDVND\":23205,\"USDVUV\":117.283012,\"USDWST\":2.656029,\"USDXAF\":585.600773,\"USDXAG\":0.058889,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.726795,\"USDXOF\":585.59757,\"USDXPF\":107.020189,\"USDYER\":250.349774,\"USDZAR\":15.255501,\"USDZMK\":9001.195264,\"USDZMW\":13.029853,\"USDZWL\":322.000001}}', 1, '2019-08-09 16:08:06', '2019-08-09 18:51:35', '2019-08-09 18:51:35', 'USD'),
(811, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565712485,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.6731,\"USDAFN\":78.5175,\"USDALL\":108.149977,\"USDAMD\":475.940235,\"USDANG\":1.78515,\"USDAOA\":362.017502,\"USDARS\":54.746007,\"USDAUD\":1.471855,\"USDAWG\":1.8,\"USDAZN\":1.704965,\"USDBAM\":1.74375,\"USDBBD\":2.0193,\"USDBDT\":84.601986,\"USDBGN\":1.7501,\"USDBHD\":0.376004,\"USDBIF\":1843.25,\"USDBMD\":1,\"USDBND\":1.350598,\"USDBOB\":6.91535,\"USDBRL\":3.9545,\"USDBSD\":1.00005,\"USDBTC\":0.00009143286,\"USDBTN\":68.914097,\"USDBWP\":11.05799,\"USDBYN\":2.04265,\"USDBYR\":19600,\"USDBZD\":2.0159,\"USDCAD\":1.32266,\"USDCDF\":1665.000282,\"USDCHF\":0.974665,\"USDCLF\":0.025561,\"USDCLP\":705.295489,\"USDCNY\":7.043501,\"USDCOP\":3395.65,\"USDCRC\":572.645036,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.314504,\"USDCZK\":23.096662,\"USDDJF\":177.719767,\"USDDKK\":6.67504,\"USDDOP\":50.94504,\"USDDZD\":119.569782,\"USDEGP\":16.586992,\"USDERN\":14.999992,\"USDETB\":29.170952,\"USDEUR\":0.894414,\"USDFJD\":2.17785,\"USDFKP\":0.82746,\"USDGBP\":0.82904,\"USDGEL\":2.925017,\"USDGGP\":0.829233,\"USDGHS\":5.425099,\"USDGIP\":0.827496,\"USDGMD\":50.114992,\"USDGNF\":9187.650118,\"USDGTQ\":7.675199,\"USDGYD\":208.954972,\"USDHKD\":7.84655,\"USDHNL\":24.493503,\"USDHRK\":6.611096,\"USDHTG\":94.887503,\"USDHUF\":289.122962,\"USDIDR\":14188.05,\"USDILS\":3.481799,\"USDIMP\":0.829233,\"USDINR\":70.777501,\"USDIQD\":1193.25,\"USDIRR\":42104.999922,\"USDISK\":124.239395,\"USDJEP\":0.829233,\"USDJMD\":134.379772,\"USDJOD\":0.708899,\"USDJPY\":106.573994,\"USDKES\":103.270039,\"USDKGS\":69.782796,\"USDKHR\":4086.350159,\"USDKMF\":439.650117,\"USDKPW\":900.055319,\"USDKRW\":1207.315016,\"USDKWD\":0.304102,\"USDKYD\":0.83341,\"USDKZT\":387.579709,\"USDLAK\":8695.702602,\"USDLBP\":1512.150201,\"USDLKR\":176.90992,\"USDLRD\":203.000341,\"USDLSL\":15.250408,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.40345,\"USDMAD\":9.55015,\"USDMDL\":17.485502,\"USDMGA\":3685.597941,\"USDMKD\":54.832505,\"USDMMK\":1510.597835,\"USDMNT\":2667.912206,\"USDMOP\":8.08285,\"USDMRO\":356.999503,\"USDMUR\":35.898957,\"USDMVR\":15.485792,\"USDMWK\":729.034993,\"USDMXN\":19.40884,\"USDMYR\":4.1975,\"USDMZN\":60.445019,\"USDNAD\":15.250092,\"USDNGN\":363.760033,\"USDNIO\":33.527007,\"USDNOK\":8.879109,\"USDNPR\":113.765012,\"USDNZD\":1.549975,\"USDOMR\":0.385049,\"USDPAB\":0.99995,\"USDPEN\":3.37905,\"USDPGK\":3.397801,\"USDPHP\":51.970242,\"USDPKR\":160.249753,\"USDPLN\":3.87622,\"USDPYG\":6083.450146,\"USDQAR\":3.640987,\"USDRON\":4.221505,\"USDRSD\":105.289907,\"USDRUB\":65.013695,\"USDRWF\":917.885,\"USDSAR\":3.75105,\"USDSBD\":8.221398,\"USDSCR\":13.701024,\"USDSDG\":45.112501,\"USDSEK\":9.550995,\"USDSGD\":1.38303,\"USDSHP\":1.320903,\"USDSLL\":9299.999942,\"USDSOS\":580.000156,\"USDSRD\":7.457967,\"USDSTD\":21560.79,\"USDSVC\":8.75055,\"USDSYP\":515.00038,\"USDSZL\":15.297503,\"USDTHB\":30.801501,\"USDTJS\":9.43025,\"USDTMT\":3.5,\"USDTND\":2.843198,\"USDTOP\":2.31325,\"USDTRY\":5.56718,\"USDTTD\":6.77685,\"USDTWD\":31.09797,\"USDTZS\":2302.100677,\"USDUAH\":25.156972,\"USDUGX\":3695.102064,\"USDUSD\":1,\"USDUYU\":35.359547,\"USDUZS\":8643.599262,\"USDVEF\":9.987499,\"USDVND\":23206.5,\"USDVUV\":117.624099,\"USDWST\":2.665595,\"USDXAF\":584.88032,\"USDXAG\":0.058803,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.72706,\"USDXOF\":584.839784,\"USDXPF\":106.340009,\"USDYER\":250.350267,\"USDZAR\":15.130401,\"USDZMK\":9001.201154,\"USDZMW\":13.032028,\"USDZWL\":322.000001}}', 1, '2019-08-13 16:08:05', '2019-08-14 11:44:17', '2019-08-14 11:44:17', 'USD'),
(812, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565798885,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.6731,\"USDAFN\":78.488498,\"USDALL\":108.660223,\"USDAMD\":475.739793,\"USDANG\":1.784601,\"USDAOA\":362.017499,\"USDARS\":59.277988,\"USDAUD\":1.483205,\"USDAWG\":1.8,\"USDAZN\":1.705011,\"USDBAM\":1.74895,\"USDBBD\":2.0186,\"USDBDT\":84.483984,\"USDBGN\":1.7558,\"USDBHD\":0.376975,\"USDBIF\":1843.05,\"USDBMD\":1,\"USDBND\":1.35035,\"USDBOB\":6.90835,\"USDBRL\":4.015603,\"USDBSD\":0.99985,\"USDBTC\":0.000094984297,\"USDBTN\":68.914103,\"USDBWP\":11.041028,\"USDBYN\":2.041803,\"USDBYR\":19600,\"USDBZD\":2.0152,\"USDCAD\":1.33235,\"USDCDF\":1665.000344,\"USDCHF\":0.97378,\"USDCLF\":0.025793,\"USDCLP\":711.697943,\"USDCNY\":7.0244,\"USDCOP\":3448.3,\"USDCRC\":571.390215,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":98.609505,\"USDCZK\":23.225297,\"USDDJF\":177.719845,\"USDDKK\":6.69516,\"USDDOP\":51.105024,\"USDDZD\":119.780063,\"USDEGP\":16.592364,\"USDERN\":14.999539,\"USDETB\":29.218496,\"USDEUR\":0.89756,\"USDFJD\":2.17675,\"USDFKP\":0.82691,\"USDGBP\":0.828986,\"USDGEL\":2.925028,\"USDGGP\":0.828827,\"USDGHS\":5.423798,\"USDGIP\":0.82691,\"USDGMD\":50.115037,\"USDGNF\":9185.349975,\"USDGTQ\":7.67315,\"USDGYD\":208.55018,\"USDHKD\":7.846855,\"USDHNL\":24.489936,\"USDHRK\":6.630898,\"USDHTG\":94.916023,\"USDHUF\":292.223025,\"USDIDR\":14296.75,\"USDILS\":3.520699,\"USDIMP\":0.828827,\"USDINR\":71.562498,\"USDIQD\":1192.95,\"USDIRR\":42105.000214,\"USDISK\":123.780305,\"USDJEP\":0.828827,\"USDJMD\":134.460388,\"USDJOD\":0.70903,\"USDJPY\":105.785499,\"USDKES\":103.259803,\"USDKGS\":69.740502,\"USDKHR\":4080.449682,\"USDKMF\":439.650198,\"USDKPW\":900.064079,\"USDKRW\":1217.98495,\"USDKWD\":0.3042,\"USDKYD\":0.833175,\"USDKZT\":386.080387,\"USDLAK\":8688.595659,\"USDLBP\":1511.350407,\"USDLKR\":177.569628,\"USDLRD\":202.999997,\"USDLSL\":15.250162,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.403099,\"USDMAD\":9.551395,\"USDMDL\":17.482999,\"USDMGA\":3687.600803,\"USDMKD\":55.002498,\"USDMMK\":1513.349878,\"USDMNT\":2667.975628,\"USDMOP\":8.07945,\"USDMRO\":357.000024,\"USDMUR\":35.939664,\"USDMVR\":15.502346,\"USDMWK\":728.925019,\"USDMXN\":19.637964,\"USDMYR\":4.195031,\"USDMZN\":60.459972,\"USDNAD\":15.250212,\"USDNGN\":363.170168,\"USDNIO\":33.516998,\"USDNOK\":8.97363,\"USDNPR\":113.509992,\"USDNZD\":1.556791,\"USDOMR\":0.38505,\"USDPAB\":0.99975,\"USDPEN\":3.393603,\"USDPGK\":3.397797,\"USDPHP\":52.376947,\"USDPKR\":160.25022,\"USDPLN\":3.92582,\"USDPYG\":6090.549828,\"USDQAR\":3.641551,\"USDRON\":4.2365,\"USDRSD\":105.670022,\"USDRUB\":66.052701,\"USDRWF\":917.775,\"USDSAR\":3.75125,\"USDSBD\":8.221398,\"USDSCR\":13.707988,\"USDSDG\":45.105993,\"USDSEK\":9.635899,\"USDSGD\":1.390501,\"USDSHP\":1.320902,\"USDSLL\":9299.999731,\"USDSOS\":580.000359,\"USDSRD\":7.458002,\"USDSTD\":21560.79,\"USDSVC\":8.7485,\"USDSYP\":515.000314,\"USDSZL\":15.2505,\"USDTHB\":30.839602,\"USDTJS\":9.43365,\"USDTMT\":3.5,\"USDTND\":2.863696,\"USDTOP\":2.31115,\"USDTRY\":5.61549,\"USDTTD\":6.77485,\"USDTWD\":31.410497,\"USDTZS\":2298.800285,\"USDUAH\":25.263014,\"USDUGX\":3694.150145,\"USDUSD\":1,\"USDUYU\":35.900356,\"USDUZS\":8661.298182,\"USDVEF\":9.987498,\"USDVND\":23205,\"USDVUV\":117.259873,\"USDWST\":2.662336,\"USDXAF\":586.660332,\"USDXAG\":0.057954,\"USDXAU\":0.000659,\"USDXCD\":2.70255,\"USDXDR\":0.727686,\"USDXOF\":586.600707,\"USDXPF\":106.659853,\"USDYER\":250.349868,\"USDZAR\":15.41735,\"USDZMK\":9001.206202,\"USDZMW\":13.02698,\"USDZWL\":322.000001}}', 1, '2019-08-14 16:08:05', '2019-08-15 13:42:30', '2019-08-15 13:42:30', 'USD'),
(813, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1565971687,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673028,\"USDAFN\":78.344498,\"USDALL\":108.960308,\"USDAMD\":475.920229,\"USDANG\":1.7845,\"USDAOA\":362.017502,\"USDARS\":56.299838,\"USDAUD\":1.47425,\"USDAWG\":1.8,\"USDAZN\":1.705037,\"USDBAM\":1.765396,\"USDBBD\":2.01905,\"USDBDT\":84.544003,\"USDBGN\":1.763502,\"USDBHD\":0.377035,\"USDBIF\":1843.25,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.90795,\"USDBRL\":3.993802,\"USDBSD\":0.99965,\"USDBTC\":0.00009674493,\"USDBTN\":68.914102,\"USDBWP\":11.040429,\"USDBYN\":2.049597,\"USDBYR\":19600,\"USDBZD\":2.01505,\"USDCAD\":1.32845,\"USDCDF\":1665.00024,\"USDCHF\":0.979895,\"USDCLF\":0.025695,\"USDCLP\":708.804978,\"USDCNY\":7.042897,\"USDCOP\":3441.5,\"USDCRC\":568.194997,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.534496,\"USDCZK\":23.20199,\"USDDJF\":177.71943,\"USDDKK\":6.724041,\"USDDOP\":51.244993,\"USDDZD\":119.960132,\"USDEGP\":16.581497,\"USDERN\":15.000083,\"USDETB\":29.227969,\"USDEUR\":0.90151,\"USDFJD\":2.17765,\"USDFKP\":0.822397,\"USDGBP\":0.823205,\"USDGEL\":2.924957,\"USDGGP\":0.823115,\"USDGHS\":5.424299,\"USDGIP\":0.822415,\"USDGMD\":50.104999,\"USDGNF\":9186.350062,\"USDGTQ\":7.672803,\"USDGYD\":208.575003,\"USDHKD\":7.84275,\"USDHNL\":24.487993,\"USDHRK\":6.660302,\"USDHTG\":95.122502,\"USDHUF\":292.724963,\"USDIDR\":14203.85,\"USDILS\":3.546198,\"USDIMP\":0.823115,\"USDINR\":71.244503,\"USDIQD\":1192.9,\"USDIRR\":42104.999591,\"USDISK\":123.98967,\"USDJEP\":0.823115,\"USDJMD\":134.20261,\"USDJOD\":0.707102,\"USDJPY\":106.301942,\"USDKES\":103.400861,\"USDKGS\":69.797901,\"USDKHR\":4079.349594,\"USDKMF\":439.650168,\"USDKPW\":900.041706,\"USDKRW\":1207.155014,\"USDKWD\":0.304301,\"USDKYD\":0.83318,\"USDKZT\":386.829778,\"USDLAK\":8707.449669,\"USDLBP\":1511.549973,\"USDLKR\":177.169826,\"USDLRD\":203.000107,\"USDLSL\":15.250404,\"USDLTL\":2.952741,\"USDLVL\":0.60489,\"USDLYD\":1.402982,\"USDMAD\":9.61885,\"USDMDL\":17.548012,\"USDMGA\":3696.401894,\"USDMKD\":55.444951,\"USDMMK\":1518.550131,\"USDMNT\":2667.77161,\"USDMOP\":8.07545,\"USDMRO\":357.000024,\"USDMUR\":36.099498,\"USDMVR\":15.502067,\"USDMWK\":729.119944,\"USDMXN\":19.566403,\"USDMYR\":4.175978,\"USDMZN\":60.534978,\"USDNAD\":15.249944,\"USDNGN\":363.704253,\"USDNIO\":33.5145,\"USDNOK\":8.993525,\"USDNPR\":113.605021,\"USDNZD\":1.55502,\"USDOMR\":0.385005,\"USDPAB\":0.99975,\"USDPEN\":3.38745,\"USDPGK\":3.397799,\"USDPHP\":52.375499,\"USDPKR\":159.765026,\"USDPLN\":3.90981,\"USDPYG\":6098.549672,\"USDQAR\":3.64096,\"USDRON\":4.263597,\"USDRSD\":106.230055,\"USDRUB\":66.474022,\"USDRWF\":912.665,\"USDSAR\":3.75105,\"USDSBD\":8.2214,\"USDSCR\":13.743969,\"USDSDG\":45.106022,\"USDSEK\":9.665044,\"USDSGD\":1.38508,\"USDSHP\":1.320901,\"USDSLL\":9299.999982,\"USDSOS\":580.000154,\"USDSRD\":7.458016,\"USDSTD\":21560.79,\"USDSVC\":8.747801,\"USDSYP\":514.999696,\"USDSZL\":15.193503,\"USDTHB\":30.910346,\"USDTJS\":9.42895,\"USDTMT\":3.5,\"USDTND\":2.846399,\"USDTOP\":2.31325,\"USDTRY\":5.5748,\"USDTTD\":6.77705,\"USDTWD\":31.280151,\"USDTZS\":2299.409247,\"USDUAH\":25.262976,\"USDUGX\":3693.902114,\"USDUSD\":1,\"USDUYU\":36.190025,\"USDUZS\":9068.896565,\"USDVEF\":9.987504,\"USDVND\":23212,\"USDVUV\":117.54309,\"USDWST\":2.663103,\"USDXAF\":591.990179,\"USDXAG\":0.058326,\"USDXAU\":0.000661,\"USDXCD\":2.70255,\"USDXDR\":0.728631,\"USDXOF\":592.090468,\"USDXPF\":107.630024,\"USDYER\":250.349997,\"USDZAR\":15.220082,\"USDZMK\":9001.200203,\"USDZMW\":13.08599,\"USDZWL\":322.000001}}', 1, '2019-08-16 16:08:07', '2019-08-16 16:49:45', '2019-08-16 16:49:45', 'USD'),
(814, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566230887,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673101,\"USDAFN\":78.363499,\"USDALL\":109.120141,\"USDAMD\":475.909797,\"USDANG\":1.78475,\"USDAOA\":362.017498,\"USDARS\":54.836997,\"USDAUD\":1.476701,\"USDAWG\":1.8,\"USDAZN\":1.705009,\"USDBAM\":1.76095,\"USDBBD\":2.0188,\"USDBDT\":84.469662,\"USDBGN\":1.762804,\"USDBHD\":0.376974,\"USDBIF\":1843.7,\"USDBMD\":1,\"USDBND\":1.350499,\"USDBOB\":6.90505,\"USDBRL\":4.037602,\"USDBSD\":0.99925,\"USDBTC\":0.0000930801,\"USDBTN\":68.9141,\"USDBWP\":11.028991,\"USDBYN\":2.0601,\"USDBYR\":19600,\"USDBZD\":2.0154,\"USDCAD\":1.330835,\"USDCDF\":1665.000422,\"USDCHF\":0.980503,\"USDCLF\":0.025815,\"USDCLP\":712.40406,\"USDCNY\":7.0507,\"USDCOP\":3429,\"USDCRC\":568.264997,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.349499,\"USDCZK\":23.247603,\"USDDJF\":177.719752,\"USDDKK\":6.720303,\"USDDOP\":51.15495,\"USDDZD\":119.944974,\"USDEGP\":16.598502,\"USDERN\":15.000016,\"USDETB\":29.201028,\"USDEUR\":0.901199,\"USDFJD\":2.17595,\"USDFKP\":0.82491,\"USDGBP\":0.82351,\"USDGEL\":2.925008,\"USDGGP\":0.823453,\"USDGHS\":5.421298,\"USDGIP\":0.824899,\"USDGMD\":50.104972,\"USDGNF\":9187.849555,\"USDGTQ\":7.678898,\"USDGYD\":208.684971,\"USDHKD\":7.84605,\"USDHNL\":24.493983,\"USDHRK\":6.656704,\"USDHTG\":95.287495,\"USDHUF\":294.371983,\"USDIDR\":14261.45,\"USDILS\":3.523902,\"USDIMP\":0.823453,\"USDINR\":71.544988,\"USDIQD\":1193.05,\"USDIRR\":42105.000212,\"USDISK\":124.459609,\"USDJEP\":0.823453,\"USDJMD\":134.230185,\"USDJOD\":0.708977,\"USDJPY\":106.493498,\"USDKES\":103.303496,\"USDKGS\":69.7839,\"USDKHR\":4083.449552,\"USDKMF\":439.64994,\"USDKPW\":900.054418,\"USDKRW\":1210.820058,\"USDKWD\":0.304302,\"USDKYD\":0.833235,\"USDKZT\":387.040277,\"USDLAK\":8711.79911,\"USDLBP\":1510.750323,\"USDLKR\":177.439727,\"USDLRD\":202.999789,\"USDLSL\":15.250379,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.408397,\"USDMAD\":9.60265,\"USDMDL\":17.674969,\"USDMGA\":3693.149822,\"USDMKD\":55.403505,\"USDMMK\":1523.797329,\"USDMNT\":2667.944197,\"USDMOP\":8.07865,\"USDMRO\":357.000024,\"USDMUR\":36.047501,\"USDMVR\":15.503146,\"USDMWK\":729.004977,\"USDMXN\":19.816701,\"USDMYR\":4.1737,\"USDMZN\":60.575025,\"USDNAD\":15.24972,\"USDNGN\":363.769941,\"USDNIO\":33.519931,\"USDNOK\":8.974295,\"USDNPR\":114.189562,\"USDNZD\":1.55776,\"USDOMR\":0.385025,\"USDPAB\":0.99925,\"USDPEN\":3.380196,\"USDPGK\":3.397798,\"USDPHP\":52.290495,\"USDPKR\":159.954961,\"USDPLN\":3.93798,\"USDPYG\":6117.84975,\"USDQAR\":3.640994,\"USDRON\":4.2632,\"USDRSD\":106.169757,\"USDRUB\":66.925975,\"USDRWF\":918.475,\"USDSAR\":3.75065,\"USDSBD\":8.221397,\"USDSCR\":13.621994,\"USDSDG\":45.114028,\"USDSEK\":9.66825,\"USDSGD\":1.386201,\"USDSHP\":1.320903,\"USDSLL\":9299.999526,\"USDSOS\":580.000506,\"USDSRD\":7.457956,\"USDSTD\":21560.79,\"USDSVC\":8.74915,\"USDSYP\":514.99977,\"USDSZL\":15.353029,\"USDTHB\":30.860352,\"USDTJS\":9.43055,\"USDTMT\":3.5,\"USDTND\":2.872601,\"USDTOP\":2.312701,\"USDTRY\":5.67141,\"USDTTD\":6.77535,\"USDTWD\":31.368498,\"USDTZS\":2299.197435,\"USDUAH\":25.263021,\"USDUGX\":3693.150385,\"USDUSD\":1,\"USDUYU\":36.192558,\"USDUZS\":9150.399692,\"USDVEF\":9.987498,\"USDVND\":23206,\"USDVUV\":117.553352,\"USDWST\":2.663813,\"USDXAF\":590.524696,\"USDXAG\":0.058859,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.728946,\"USDXOF\":590.609965,\"USDXPF\":107.359803,\"USDYER\":250.350177,\"USDZAR\":15.437606,\"USDZMK\":9001.197417,\"USDZMW\":13.084947,\"USDZWL\":322.000001}}', 1, '2019-08-19 16:08:07', '2019-08-20 10:35:16', '2019-08-20 10:35:16', 'USD'),
(815, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566317286,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673098,\"USDAFN\":78.394034,\"USDALL\":109.140435,\"USDAMD\":475.901867,\"USDANG\":1.785198,\"USDAOA\":362.002502,\"USDARS\":54.792005,\"USDAUD\":1.475875,\"USDAWG\":1.8,\"USDAZN\":1.705032,\"USDBAM\":1.76495,\"USDBBD\":2.0193,\"USDBDT\":84.501989,\"USDBGN\":1.763798,\"USDBHD\":0.377038,\"USDBIF\":1843.75,\"USDBMD\":1,\"USDBND\":1.350596,\"USDBOB\":6.91075,\"USDBRL\":4.038703,\"USDBSD\":1.00005,\"USDBTC\":0.000094190908,\"USDBTN\":68.914097,\"USDBWP\":11.099028,\"USDBYN\":2.05725,\"USDBYR\":19600,\"USDBZD\":2.01585,\"USDCAD\":1.333225,\"USDCDF\":1665.000174,\"USDCHF\":0.97918,\"USDCLF\":0.025738,\"USDCLP\":710.197203,\"USDCNY\":7.060605,\"USDCOP\":3421.25,\"USDCRC\":566.599286,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.509502,\"USDCZK\":23.256987,\"USDDJF\":177.720162,\"USDDKK\":6.722203,\"USDDOP\":51.204978,\"USDDZD\":119.979893,\"USDEGP\":16.59428,\"USDERN\":14.999692,\"USDETB\":29.250497,\"USDEUR\":0.90161,\"USDFJD\":2.18255,\"USDFKP\":0.82822,\"USDGBP\":0.823245,\"USDGEL\":2.92499,\"USDGGP\":0.823152,\"USDGHS\":5.470404,\"USDGIP\":0.82821,\"USDGMD\":50.104987,\"USDGNF\":9178.701955,\"USDGTQ\":7.680702,\"USDGYD\":208.634986,\"USDHKD\":7.84345,\"USDHNL\":24.501992,\"USDHRK\":6.661981,\"USDHTG\":95.360497,\"USDHUF\":295.322982,\"USDIDR\":14257.75,\"USDILS\":3.52765,\"USDIMP\":0.823152,\"USDINR\":71.546998,\"USDIQD\":1193.25,\"USDIRR\":42104.999741,\"USDISK\":124.52977,\"USDJEP\":0.823152,\"USDJMD\":134.440345,\"USDJOD\":0.708991,\"USDJPY\":106.361498,\"USDKES\":103.004997,\"USDKGS\":69.803004,\"USDKHR\":4084.349796,\"USDKMF\":439.650154,\"USDKPW\":900.06293,\"USDKRW\":1207.800677,\"USDKWD\":0.304201,\"USDKYD\":0.83338,\"USDKZT\":386.879746,\"USDLAK\":8715.596494,\"USDLBP\":1512.150051,\"USDLKR\":177.960217,\"USDLRD\":202.99977,\"USDLSL\":15.249903,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.40825,\"USDMAD\":9.605501,\"USDMDL\":17.736012,\"USDMGA\":3695.250107,\"USDMKD\":55.494011,\"USDMMK\":1523.650062,\"USDMNT\":2669.371733,\"USDMOP\":8.078097,\"USDMRO\":357.000024,\"USDMUR\":36.0705,\"USDMVR\":15.49594,\"USDMWK\":729.019737,\"USDMXN\":19.757601,\"USDMYR\":4.1806,\"USDMZN\":60.609923,\"USDNAD\":15.249659,\"USDNGN\":362.530587,\"USDNIO\":33.527972,\"USDNOK\":8.997901,\"USDNPR\":114.465031,\"USDNZD\":1.55933,\"USDOMR\":0.384985,\"USDPAB\":1.00005,\"USDPEN\":3.38255,\"USDPGK\":3.397801,\"USDPHP\":52.309495,\"USDPKR\":160.150074,\"USDPLN\":3.92975,\"USDPYG\":6126.000327,\"USDQAR\":3.64175,\"USDRON\":4.263702,\"USDRSD\":106.189677,\"USDRUB\":66.513005,\"USDRWF\":918.665,\"USDSAR\":3.75075,\"USDSBD\":8.221398,\"USDSCR\":13.692015,\"USDSDG\":45.116012,\"USDSEK\":9.6995,\"USDSGD\":1.385115,\"USDSHP\":1.320896,\"USDSLL\":9299.999827,\"USDSOS\":580.000203,\"USDSRD\":7.457995,\"USDSTD\":21560.79,\"USDSVC\":8.750901,\"USDSYP\":514.999574,\"USDSZL\":15.363501,\"USDTHB\":30.770499,\"USDTJS\":9.695597,\"USDTMT\":3.5,\"USDTND\":2.8662,\"USDTOP\":2.31735,\"USDTRY\":5.73899,\"USDTTD\":6.76455,\"USDTWD\":31.370499,\"USDTZS\":2299.000479,\"USDUAH\":25.176946,\"USDUGX\":3690.298858,\"USDUSD\":1,\"USDUYU\":36.209932,\"USDUZS\":9150.693535,\"USDVEF\":9.987504,\"USDVND\":23204,\"USDVUV\":117.713491,\"USDWST\":2.668788,\"USDXAF\":591.939993,\"USDXAG\":0.058363,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.729083,\"USDXOF\":591.949936,\"USDXPF\":107.619818,\"USDYER\":250.349935,\"USDZAR\":15.35387,\"USDZMK\":9001.199647,\"USDZMW\":13.086032,\"USDZWL\":322.000001}}', 1, '2019-08-20 16:08:06', '2019-08-20 19:07:57', '2019-08-20 19:07:57', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(816, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566403686,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673203,\"USDAFN\":78.5105,\"USDALL\":109.149765,\"USDAMD\":475.940105,\"USDANG\":1.78475,\"USDAOA\":362.002498,\"USDARS\":55.034018,\"USDAUD\":1.47165,\"USDAWG\":1.8,\"USDAZN\":1.704967,\"USDBAM\":1.7615,\"USDBBD\":2.01885,\"USDBDT\":84.484017,\"USDBGN\":1.763302,\"USDBHD\":0.376975,\"USDBIF\":1843.4,\"USDBMD\":1,\"USDBND\":1.350697,\"USDBOB\":6.91415,\"USDBRL\":4.016044,\"USDBSD\":0.99985,\"USDBTC\":0.000101,\"USDBTN\":68.914101,\"USDBWP\":11.047036,\"USDBYN\":2.053702,\"USDBYR\":19600,\"USDBZD\":2.015198,\"USDCAD\":1.327249,\"USDCDF\":1665.00022,\"USDCHF\":0.981104,\"USDCLF\":0.025688,\"USDCLP\":708.803205,\"USDCNY\":7.063105,\"USDCOP\":3379.1,\"USDCRC\":565.055013,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.315498,\"USDCZK\":23.244992,\"USDDJF\":177.720138,\"USDDKK\":6.71703,\"USDDOP\":51.134995,\"USDDZD\":119.940301,\"USDEGP\":16.598019,\"USDERN\":15.000244,\"USDETB\":29.245944,\"USDEUR\":0.90085,\"USDFJD\":2.18055,\"USDFKP\":0.825125,\"USDGBP\":0.82367,\"USDGEL\":2.925009,\"USDGGP\":0.823483,\"USDGHS\":5.464401,\"USDGIP\":0.825125,\"USDGMD\":50.104958,\"USDGNF\":9176.849652,\"USDGTQ\":7.679103,\"USDGYD\":209.185019,\"USDHKD\":7.84299,\"USDHNL\":24.494502,\"USDHRK\":6.656201,\"USDHTG\":95.3345,\"USDHUF\":294.923035,\"USDIDR\":14223.25,\"USDILS\":3.524799,\"USDIMP\":0.823483,\"USDINR\":71.440498,\"USDIQD\":1193.1,\"USDIRR\":42105.000125,\"USDISK\":124.605413,\"USDJEP\":0.823483,\"USDJMD\":135.140427,\"USDJOD\":0.708972,\"USDJPY\":106.490362,\"USDKES\":103.000097,\"USDKGS\":69.816021,\"USDKHR\":4080.550319,\"USDKMF\":439.650238,\"USDKPW\":900.066132,\"USDKRW\":1201.898459,\"USDKWD\":0.304198,\"USDKYD\":0.83329,\"USDKZT\":385.9796,\"USDLAK\":8718.849822,\"USDLBP\":1511.750274,\"USDLKR\":178.870235,\"USDLRD\":202.99998,\"USDLSL\":15.249649,\"USDLTL\":2.95274,\"USDLVL\":0.604889,\"USDLYD\":1.40945,\"USDMAD\":9.601598,\"USDMDL\":17.798027,\"USDMGA\":3696.491881,\"USDMKD\":55.403499,\"USDMMK\":1521.803721,\"USDMNT\":2669.264832,\"USDMOP\":8.07545,\"USDMRO\":357.000024,\"USDMUR\":36.0475,\"USDMVR\":15.501928,\"USDMWK\":729.075007,\"USDMXN\":19.6567,\"USDMYR\":4.175012,\"USDMZN\":60.699549,\"USDNAD\":15.250382,\"USDNGN\":362.509638,\"USDNIO\":33.520967,\"USDNOK\":8.94528,\"USDNPR\":114.365021,\"USDNZD\":1.55955,\"USDOMR\":0.38495,\"USDPAB\":0.99985,\"USDPEN\":3.379299,\"USDPGK\":3.397801,\"USDPHP\":52.200575,\"USDPKR\":160.149986,\"USDPLN\":3.91929,\"USDPYG\":6140.493488,\"USDQAR\":3.64175,\"USDRON\":4.256497,\"USDRSD\":106.160181,\"USDRUB\":65.733017,\"USDRWF\":918.455,\"USDSAR\":3.75065,\"USDSBD\":8.221398,\"USDSCR\":13.687026,\"USDSDG\":45.106505,\"USDSEK\":9.61913,\"USDSGD\":1.382585,\"USDSHP\":1.320901,\"USDSLL\":9300.000401,\"USDSOS\":579.99977,\"USDSRD\":7.457968,\"USDSTD\":21560.79,\"USDSVC\":8.74905,\"USDSYP\":514.999859,\"USDSZL\":15.200959,\"USDTHB\":30.779502,\"USDTJS\":9.689197,\"USDTMT\":3.5,\"USDTND\":2.869402,\"USDTOP\":2.31545,\"USDTRY\":5.70944,\"USDTTD\":6.76675,\"USDTWD\":31.302005,\"USDTZS\":2299.197869,\"USDUAH\":25.154969,\"USDUGX\":3689.050192,\"USDUSD\":1,\"USDUYU\":36.349824,\"USDUZS\":9058.84995,\"USDVEF\":9.987499,\"USDVND\":23201.5,\"USDVUV\":117.696652,\"USDWST\":2.668983,\"USDXAF\":590.803286,\"USDXAG\":0.05836,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.729072,\"USDXOF\":590.720293,\"USDXPF\":107.410132,\"USDYER\":250.350213,\"USDZAR\":15.18825,\"USDZMK\":9001.199831,\"USDZMW\":13.121973,\"USDZWL\":322.000001}}', 1, '2019-08-21 16:08:06', '2019-08-21 17:46:52', '2019-08-21 17:46:52', 'USD'),
(817, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566490086,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.6731,\"USDAFN\":78.515503,\"USDALL\":109.250234,\"USDAMD\":475.910324,\"USDANG\":1.785597,\"USDAOA\":362.002501,\"USDARS\":55.020106,\"USDAUD\":1.478145,\"USDAWG\":1.8,\"USDAZN\":1.70502,\"USDBAM\":1.76755,\"USDBBD\":2.0197,\"USDBDT\":84.549784,\"USDBGN\":1.764301,\"USDBHD\":0.377045,\"USDBIF\":1844.4,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.91965,\"USDBRL\":4.0544,\"USDBSD\":1.00065,\"USDBTC\":0.00009895101,\"USDBTN\":71.623502,\"USDBWP\":11.070265,\"USDBYN\":2.05815,\"USDBYR\":19600,\"USDBZD\":2.016304,\"USDCAD\":1.32911,\"USDCDF\":1664.999847,\"USDCHF\":0.98361,\"USDCLF\":0.025894,\"USDCLP\":714.496429,\"USDCNY\":7.083705,\"USDCOP\":3376,\"USDCRC\":565.394999,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.540499,\"USDCZK\":23.252799,\"USDDJF\":177.719517,\"USDDKK\":6.72526,\"USDDOP\":51.174971,\"USDDZD\":119.949974,\"USDEGP\":16.581198,\"USDERN\":15.000224,\"USDETB\":29.268003,\"USDEUR\":0.90203,\"USDFJD\":2.18115,\"USDFKP\":0.82379,\"USDGBP\":0.81625,\"USDGEL\":2.925007,\"USDGGP\":0.816401,\"USDGHS\":5.451598,\"USDGIP\":0.82378,\"USDGMD\":50.105008,\"USDGNF\":9183.701112,\"USDGTQ\":7.68225,\"USDGYD\":209.274959,\"USDHKD\":7.84062,\"USDHNL\":24.524988,\"USDHRK\":6.664802,\"USDHTG\":95.378988,\"USDHUF\":296.088056,\"USDIDR\":14241.75,\"USDILS\":3.519103,\"USDIMP\":0.816401,\"USDINR\":71.928602,\"USDIQD\":1193.55,\"USDIRR\":42104.999926,\"USDISK\":124.929675,\"USDJEP\":0.816401,\"USDJMD\":135.160425,\"USDJOD\":0.709018,\"USDJPY\":106.458023,\"USDKES\":103.080034,\"USDKGS\":69.7961,\"USDKHR\":4083.203654,\"USDKMF\":439.649912,\"USDKPW\":900.069028,\"USDKRW\":1210.510032,\"USDKWD\":0.30397,\"USDKYD\":0.833595,\"USDKZT\":386.290082,\"USDLAK\":8725.600338,\"USDLBP\":1513.149912,\"USDLKR\":179.49408,\"USDLRD\":203.000467,\"USDLSL\":15.25009,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.409004,\"USDMAD\":9.610502,\"USDMDL\":17.73102,\"USDMGA\":3713.60243,\"USDMKD\":55.439499,\"USDMMK\":1520.950293,\"USDMNT\":2669.402437,\"USDMOP\":8.07805,\"USDMRO\":357.000024,\"USDMUR\":36.194499,\"USDMVR\":15.499877,\"USDMWK\":729.06502,\"USDMXN\":19.72633,\"USDMYR\":4.186604,\"USDMZN\":60.749513,\"USDNAD\":15.249392,\"USDNGN\":362.359757,\"USDNIO\":33.535006,\"USDNOK\":8.96837,\"USDNPR\":114.599295,\"USDNZD\":1.567902,\"USDOMR\":0.385057,\"USDPAB\":1.00055,\"USDPEN\":3.379596,\"USDPGK\":3.397802,\"USDPHP\":52.36977,\"USDPKR\":160.089677,\"USDPLN\":3.93425,\"USDPYG\":6156.000111,\"USDQAR\":3.641006,\"USDRON\":4.256702,\"USDRSD\":106.35956,\"USDRUB\":65.699798,\"USDRWF\":919.085,\"USDSAR\":3.75075,\"USDSBD\":8.221396,\"USDSCR\":13.670058,\"USDSDG\":45.126028,\"USDSEK\":9.66402,\"USDSGD\":1.385401,\"USDSHP\":1.320902,\"USDSLL\":9300.00014,\"USDSOS\":580.000042,\"USDSRD\":7.458005,\"USDSTD\":21560.79,\"USDSVC\":8.75255,\"USDSYP\":515.000256,\"USDSZL\":15.204022,\"USDTHB\":30.787503,\"USDTJS\":9.693397,\"USDTMT\":3.5,\"USDTND\":2.861198,\"USDTOP\":2.3165,\"USDTRY\":5.76097,\"USDTTD\":6.77335,\"USDTWD\":31.359711,\"USDTZS\":2299.206202,\"USDUAH\":25.154963,\"USDUGX\":3691.050175,\"USDUSD\":1,\"USDUYU\":36.629879,\"USDUZS\":9417.384438,\"USDVEF\":9.9875,\"USDVND\":23205,\"USDVUV\":117.613322,\"USDWST\":2.669501,\"USDXAF\":592.809786,\"USDXAG\":0.058481,\"USDXAU\":0.000667,\"USDXCD\":2.70255,\"USDXDR\":0.729052,\"USDXOF\":592.810214,\"USDXPF\":107.779575,\"USDYER\":250.349957,\"USDZAR\":15.191599,\"USDZMK\":9001.196279,\"USDZMW\":13.113967,\"USDZWL\":322.000001}}', 1, '2019-08-22 16:08:06', '2019-08-22 16:18:29', '2019-08-22 16:18:29', 'USD'),
(818, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566576486,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672967,\"USDAFN\":78.574498,\"USDALL\":108.669786,\"USDAMD\":475.989728,\"USDANG\":1.78515,\"USDAOA\":362.002498,\"USDARS\":55.2906,\"USDAUD\":1.481955,\"USDAWG\":1.8,\"USDAZN\":1.704969,\"USDBAM\":1.76905,\"USDBBD\":2.01925,\"USDBDT\":84.416056,\"USDBGN\":1.75705,\"USDBHD\":0.377017,\"USDBIF\":1843.8,\"USDBMD\":1,\"USDBND\":1.350495,\"USDBOB\":6.91535,\"USDBRL\":4.115897,\"USDBSD\":1.00005,\"USDBTC\":0.000095988589,\"USDBTN\":71.592502,\"USDBWP\":11.049011,\"USDBYN\":2.05555,\"USDBYR\":19600,\"USDBZD\":2.01555,\"USDCAD\":1.332725,\"USDCDF\":1664.999968,\"USDCHF\":0.97587,\"USDCLF\":0.026028,\"USDCLP\":718.306691,\"USDCNY\":7.095981,\"USDCOP\":3398.6,\"USDCRC\":566.1701,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.745496,\"USDCZK\":23.225012,\"USDDJF\":177.719718,\"USDDKK\":6.697815,\"USDDOP\":51.075035,\"USDDZD\":119.760069,\"USDEGP\":16.575497,\"USDERN\":14.999772,\"USDETB\":29.257968,\"USDEUR\":0.89815,\"USDFJD\":2.18675,\"USDFKP\":0.818399,\"USDGBP\":0.81644,\"USDGEL\":2.925021,\"USDGGP\":0.816075,\"USDGHS\":5.444699,\"USDGIP\":0.81835,\"USDGMD\":50.094997,\"USDGNF\":9181.950422,\"USDGTQ\":7.679499,\"USDGYD\":209.224995,\"USDHKD\":7.84405,\"USDHNL\":24.516502,\"USDHRK\":6.632701,\"USDHTG\":95.346499,\"USDHUF\":295.843997,\"USDIDR\":14277.25,\"USDILS\":3.51185,\"USDIMP\":0.816075,\"USDINR\":71.77702,\"USDIQD\":1193.35,\"USDIRR\":42105.000315,\"USDISK\":124.210032,\"USDJEP\":0.816075,\"USDJMD\":135.639605,\"USDJOD\":0.707497,\"USDJPY\":105.405497,\"USDKES\":103.260214,\"USDKGS\":69.788197,\"USDKHR\":4085.150338,\"USDKMF\":439.650071,\"USDKPW\":900.053737,\"USDKRW\":1217.330181,\"USDKWD\":0.304102,\"USDKYD\":0.83334,\"USDKZT\":386.12987,\"USDLAK\":8728.649882,\"USDLBP\":1512.249796,\"USDLKR\":180.050138,\"USDLRD\":202.999827,\"USDLSL\":15.249431,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.40945,\"USDMAD\":9.570979,\"USDMDL\":17.928501,\"USDMGA\":3728.302334,\"USDMKD\":55.169503,\"USDMMK\":1519.000363,\"USDMNT\":2669.650864,\"USDMOP\":8.0777,\"USDMRO\":357.000024,\"USDMUR\":36.2025,\"USDMVR\":15.434371,\"USDMWK\":728.984975,\"USDMXN\":19.87255,\"USDMYR\":4.191056,\"USDMZN\":60.904958,\"USDNAD\":15.249927,\"USDNGN\":362.229797,\"USDNIO\":33.522501,\"USDNOK\":8.97202,\"USDNPR\":114.540124,\"USDNZD\":1.56443,\"USDOMR\":0.38502,\"USDPAB\":0.99995,\"USDPEN\":3.37415,\"USDPGK\":3.397799,\"USDPHP\":52.464009,\"USDPKR\":156.59826,\"USDPLN\":3.93495,\"USDPYG\":6183.310995,\"USDQAR\":3.641025,\"USDRON\":4.2385,\"USDRSD\":105.960196,\"USDRUB\":66.151698,\"USDRWF\":918.82,\"USDSAR\":3.75025,\"USDSBD\":8.2214,\"USDSCR\":13.745965,\"USDSDG\":45.108981,\"USDSEK\":9.634797,\"USDSGD\":1.38748,\"USDSHP\":1.320899,\"USDSLL\":9300.000117,\"USDSOS\":580.000209,\"USDSRD\":7.458019,\"USDSTD\":21560.79,\"USDSVC\":8.7495,\"USDSYP\":515.000075,\"USDSZL\":15.179821,\"USDTHB\":30.619616,\"USDTJS\":9.68475,\"USDTMT\":3.5,\"USDTND\":2.861195,\"USDTOP\":2.320603,\"USDTRY\":5.76913,\"USDTTD\":6.77085,\"USDTWD\":31.443971,\"USDTZS\":2299.000174,\"USDUAH\":25.110972,\"USDUGX\":3684.801482,\"USDUSD\":1,\"USDUYU\":36.519606,\"USDUZS\":9383.450372,\"USDVEF\":9.987497,\"USDVND\":23199,\"USDVUV\":117.863856,\"USDWST\":2.668077,\"USDXAF\":593.390379,\"USDXAG\":0.057521,\"USDXAU\":0.000656,\"USDXCD\":2.70255,\"USDXDR\":0.727832,\"USDXOF\":593.329756,\"USDXPF\":107.879734,\"USDYER\":250.350187,\"USDZAR\":15.295697,\"USDZMK\":9001.207442,\"USDZMW\":13.109779,\"USDZWL\":322.000001}}', 1, '2019-08-23 16:08:06', '2019-08-23 17:47:32', '2019-08-23 17:47:32', 'USD'),
(819, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1566922086,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673007,\"USDAFN\":78.34951,\"USDALL\":109.659559,\"USDAMD\":475.929727,\"USDANG\":1.784996,\"USDAOA\":362.0025,\"USDARS\":55.778957,\"USDAUD\":1.479895,\"USDAWG\":1.8,\"USDAZN\":1.704982,\"USDBAM\":1.760796,\"USDBBD\":2.01905,\"USDBDT\":84.494004,\"USDBGN\":1.763505,\"USDBHD\":0.37702,\"USDBIF\":1855,\"USDBMD\":1,\"USDBND\":1.350449,\"USDBOB\":6.90975,\"USDBRL\":4.189504,\"USDBSD\":1.00005,\"USDBTC\":0.000097968678,\"USDBTN\":71.548979,\"USDBWP\":11.061984,\"USDBYN\":2.066696,\"USDBYR\":19600,\"USDBZD\":2.015602,\"USDCAD\":1.32787,\"USDCDF\":1659.99991,\"USDCHF\":0.98147,\"USDCLF\":0.026191,\"USDCLP\":722.700915,\"USDCNY\":7.162199,\"USDCOP\":3460.9,\"USDCRC\":567.235024,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.628495,\"USDCZK\":23.301027,\"USDDJF\":177.720287,\"USDDKK\":6.72254,\"USDDOP\":51.305003,\"USDDZD\":119.940223,\"USDEGP\":16.551014,\"USDERN\":14.999671,\"USDETB\":29.250014,\"USDEUR\":0.901598,\"USDFJD\":2.18295,\"USDFKP\":0.815995,\"USDGBP\":0.81407,\"USDGEL\":2.939991,\"USDGGP\":0.813952,\"USDGHS\":5.469994,\"USDGIP\":0.81599,\"USDGMD\":50.395,\"USDGNF\":9225.000073,\"USDGTQ\":7.679802,\"USDGYD\":209.205012,\"USDHKD\":7.84725,\"USDHNL\":24.649396,\"USDHRK\":6.673803,\"USDHTG\":95.343501,\"USDHUF\":297.049803,\"USDIDR\":14262.75,\"USDILS\":3.519604,\"USDIMP\":0.813952,\"USDINR\":71.526005,\"USDIQD\":1190,\"USDIRR\":42105.000466,\"USDISK\":124.329828,\"USDJEP\":0.813952,\"USDJMD\":135.589771,\"USDJOD\":0.70898,\"USDJPY\":105.760985,\"USDKES\":103.450239,\"USDKGS\":69.813011,\"USDKHR\":4139.496076,\"USDKMF\":443.349698,\"USDKPW\":900.054402,\"USDKRW\":1213.204465,\"USDKWD\":0.303599,\"USDKYD\":0.833335,\"USDKZT\":388.359764,\"USDLAK\":8735.000018,\"USDLBP\":1508.449853,\"USDLKR\":179.759961,\"USDLRD\":205.125002,\"USDLSL\":15.290351,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404976,\"USDMAD\":9.59145,\"USDMDL\":17.79904,\"USDMGA\":3705.00008,\"USDMKD\":55.404503,\"USDMMK\":1518.439783,\"USDMNT\":2669.456015,\"USDMOP\":8.08015,\"USDMRO\":357.000024,\"USDMUR\":36.070173,\"USDMVR\":15.396409,\"USDMWK\":729.940194,\"USDMXN\":20.03459,\"USDMYR\":4.202496,\"USDMZN\":61.060242,\"USDNAD\":15.309841,\"USDNGN\":361.999733,\"USDNIO\":33.549587,\"USDNOK\":9.025535,\"USDNPR\":114.47505,\"USDNZD\":1.57155,\"USDOMR\":0.38501,\"USDPAB\":1.00005,\"USDPEN\":3.38455,\"USDPGK\":3.394802,\"USDPHP\":52.240969,\"USDPKR\":159.501311,\"USDPLN\":3.94655,\"USDPYG\":6206.34992,\"USDQAR\":3.64175,\"USDRON\":4.267103,\"USDRSD\":106.219799,\"USDRUB\":66.617698,\"USDRWF\":915,\"USDSAR\":3.75045,\"USDSBD\":8.22815,\"USDSCR\":13.668501,\"USDSDG\":45.111015,\"USDSEK\":9.66739,\"USDSGD\":1.389055,\"USDSHP\":1.320896,\"USDSLL\":9665.000357,\"USDSOS\":580.00038,\"USDSRD\":7.457989,\"USDSTD\":21560.79,\"USDSVC\":8.750203,\"USDSYP\":515.000254,\"USDSZL\":15.309755,\"USDTHB\":30.579803,\"USDTJS\":9.69015,\"USDTMT\":3.51,\"USDTND\":2.858749,\"USDTOP\":2.318598,\"USDTRY\":5.831502,\"USDTTD\":6.77005,\"USDTWD\":31.408011,\"USDTZS\":2298.800959,\"USDUAH\":25.160277,\"USDUGX\":3684.895836,\"USDUSD\":1,\"USDUYU\":36.410053,\"USDUZS\":9387.999947,\"USDVEF\":9.987501,\"USDVND\":23197.5,\"USDVUV\":117.653033,\"USDWST\":2.671641,\"USDXAF\":590.569811,\"USDXAG\":0.05508,\"USDXAU\":0.000648,\"USDXCD\":2.70265,\"USDXDR\":0.72895,\"USDXOF\":584.502219,\"USDXPF\":107.924958,\"USDYER\":250.349787,\"USDZAR\":15.355699,\"USDZMK\":9001.212348,\"USDZMW\":13.084009,\"USDZWL\":322.000001}}', 1, '2019-08-27 16:08:06', '2019-08-28 12:25:15', '2019-08-28 12:25:15', 'USD'),
(820, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567008486,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673035,\"USDAFN\":78.249538,\"USDALL\":110.169937,\"USDAMD\":475.860284,\"USDANG\":1.78545,\"USDAOA\":362.0025,\"USDARS\":57.694983,\"USDAUD\":1.48235,\"USDAWG\":1.8,\"USDAZN\":1.705022,\"USDBAM\":1.763297,\"USDBBD\":2.0195,\"USDBDT\":84.511985,\"USDBGN\":1.7648,\"USDBHD\":0.377097,\"USDBIF\":1856,\"USDBMD\":1,\"USDBND\":1.350803,\"USDBOB\":6.91135,\"USDBRL\":4.154502,\"USDBSD\":1.00025,\"USDBTC\":0.000097826434,\"USDBTN\":71.840498,\"USDBWP\":11.096046,\"USDBYN\":2.086097,\"USDBYR\":19600,\"USDBZD\":2.016204,\"USDCAD\":1.32995,\"USDCDF\":1661.000024,\"USDCHF\":0.981095,\"USDCLF\":0.02622,\"USDCLP\":723.400193,\"USDCNY\":7.165302,\"USDCOP\":3475.75,\"USDCRC\":567.405007,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.621501,\"USDCZK\":23.34899,\"USDDJF\":177.720016,\"USDDKK\":6.729103,\"USDDOP\":51.365032,\"USDDZD\":119.99496,\"USDEGP\":16.555501,\"USDERN\":15.000032,\"USDETB\":29.477673,\"USDEUR\":0.902481,\"USDFJD\":2.18695,\"USDFKP\":0.81904,\"USDGBP\":0.81738,\"USDGEL\":2.934985,\"USDGGP\":0.817694,\"USDGHS\":5.468501,\"USDGIP\":0.81902,\"USDGMD\":50.394976,\"USDGNF\":9244.9997,\"USDGTQ\":7.67705,\"USDGYD\":209.259482,\"USDHKD\":7.84443,\"USDHNL\":24.649597,\"USDHRK\":6.680296,\"USDHTG\":95.372505,\"USDHUF\":297.955022,\"USDIDR\":14248.55,\"USDILS\":3.531699,\"USDIMP\":0.817694,\"USDINR\":71.776702,\"USDIQD\":1190,\"USDIRR\":42104.999784,\"USDISK\":124.440245,\"USDJEP\":0.817694,\"USDJMD\":135.539861,\"USDJOD\":0.708959,\"USDJPY\":105.914942,\"USDKES\":103.440344,\"USDKGS\":69.824094,\"USDKHR\":4090.999745,\"USDKMF\":444.249776,\"USDKPW\":900.062428,\"USDKRW\":1213.101706,\"USDKWD\":0.303596,\"USDKYD\":0.833525,\"USDKZT\":388.979687,\"USDLAK\":8740.000063,\"USDLBP\":1512.750258,\"USDLKR\":180.33973,\"USDLRD\":205.749985,\"USDLSL\":15.379905,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404998,\"USDMAD\":9.600599,\"USDMDL\":17.828029,\"USDMGA\":3705.000228,\"USDMKD\":55.434502,\"USDMMK\":1520.749686,\"USDMNT\":2669.382622,\"USDMOP\":8.08305,\"USDMRO\":357.000024,\"USDMUR\":36.165506,\"USDMVR\":15.424019,\"USDMWK\":726.129442,\"USDMXN\":20.012702,\"USDMYR\":4.215986,\"USDMZN\":61.17496,\"USDNAD\":15.380283,\"USDNGN\":362.499962,\"USDNIO\":33.549904,\"USDNOK\":9.035502,\"USDNPR\":114.945023,\"USDNZD\":1.57825,\"USDOMR\":0.38505,\"USDPAB\":1.00025,\"USDPEN\":3.39505,\"USDPGK\":3.397804,\"USDPHP\":52.353001,\"USDPKR\":158.749856,\"USDPLN\":3.96052,\"USDPYG\":6222.349876,\"USDQAR\":3.641036,\"USDRON\":4.2657,\"USDRSD\":106.249812,\"USDRUB\":66.585972,\"USDRWF\":912.5,\"USDSAR\":3.75035,\"USDSBD\":8.22815,\"USDSCR\":13.743026,\"USDSDG\":45.119013,\"USDSEK\":9.72174,\"USDSGD\":1.388335,\"USDSHP\":1.320899,\"USDSLL\":9665.000091,\"USDSOS\":581.000107,\"USDSRD\":7.458021,\"USDSTD\":21560.79,\"USDSVC\":8.751901,\"USDSYP\":515.00029,\"USDSZL\":15.379819,\"USDTHB\":30.610285,\"USDTJS\":9.696597,\"USDTMT\":3.5,\"USDTND\":2.865799,\"USDTOP\":2.32135,\"USDTRY\":5.80536,\"USDTTD\":6.77635,\"USDTWD\":31.423497,\"USDTZS\":2298.39907,\"USDUAH\":25.220995,\"USDUGX\":3685.999859,\"USDUSD\":1,\"USDUYU\":36.520253,\"USDUZS\":9388.000355,\"USDVEF\":9.987499,\"USDVND\":23208.5,\"USDVUV\":117.913212,\"USDWST\":2.67593,\"USDXAF\":591.430225,\"USDXAG\":0.054655,\"USDXAU\":0.00065,\"USDXCD\":2.70265,\"USDXDR\":0.729796,\"USDXOF\":598.504552,\"USDXPF\":108.049746,\"USDYER\":250.303419,\"USDZAR\":15.3427,\"USDZMK\":9001.201257,\"USDZMW\":13.078017,\"USDZWL\":322.000001}}', 1, '2019-08-28 16:08:06', '2019-08-28 17:58:43', '2019-08-28 17:58:43', 'USD'),
(821, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567094886,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673102,\"USDAFN\":78.093849,\"USDALL\":110.505044,\"USDAMD\":475.960285,\"USDANG\":1.78545,\"USDAOA\":362.002502,\"USDARS\":58.111698,\"USDAUD\":1.48498,\"USDAWG\":1.8,\"USDAZN\":1.704958,\"USDBAM\":1.766497,\"USDBBD\":2.02015,\"USDBDT\":84.511979,\"USDBGN\":1.76875,\"USDBHD\":0.377,\"USDBIF\":1856,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91205,\"USDBRL\":4.160048,\"USDBSD\":1.00025,\"USDBTC\":0.000105,\"USDBTN\":71.690496,\"USDBWP\":11.098022,\"USDBYN\":2.094401,\"USDBYR\":19600,\"USDBZD\":2.01625,\"USDCAD\":1.32965,\"USDCDF\":1661.000252,\"USDCHF\":0.985185,\"USDCLF\":0.026057,\"USDCLP\":719.000012,\"USDCNY\":7.144498,\"USDCOP\":3470.55,\"USDCRC\":567.984999,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.549502,\"USDCZK\":23.419028,\"USDDJF\":177.719547,\"USDDKK\":6.74343,\"USDDOP\":51.245004,\"USDDZD\":119.909779,\"USDEGP\":16.549649,\"USDERN\":15.000175,\"USDETB\":29.540215,\"USDEUR\":0.90438,\"USDFJD\":2.20505,\"USDFKP\":0.819704,\"USDGBP\":0.81972,\"USDGEL\":2.940289,\"USDGGP\":0.819973,\"USDGHS\":5.469931,\"USDGIP\":0.81971,\"USDGMD\":50.504999,\"USDGNF\":9242.483085,\"USDGTQ\":7.68465,\"USDGYD\":209.274961,\"USDHKD\":7.84648,\"USDHNL\":24.650082,\"USDHRK\":6.693979,\"USDHTG\":95.379773,\"USDHUF\":299.744971,\"USDIDR\":14203.65,\"USDILS\":3.5318,\"USDIMP\":0.819973,\"USDINR\":71.729432,\"USDIQD\":1190,\"USDIRR\":42104.999923,\"USDISK\":125.259822,\"USDJEP\":0.819973,\"USDJMD\":136.439854,\"USDJOD\":0.709015,\"USDJPY\":106.474975,\"USDKES\":103.609522,\"USDKGS\":69.84903,\"USDKHR\":4090.999783,\"USDKMF\":444.499323,\"USDKPW\":900.054808,\"USDKRW\":1210.660102,\"USDKWD\":0.303598,\"USDKYD\":0.833495,\"USDKZT\":387.37965,\"USDLAK\":8745.999636,\"USDLBP\":1512.750262,\"USDLKR\":180.439787,\"USDLRD\":206.000225,\"USDLSL\":15.27989,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.405033,\"USDMAD\":9.615101,\"USDMDL\":17.810213,\"USDMGA\":3697.49565,\"USDMKD\":55.573019,\"USDMMK\":1521.801466,\"USDMNT\":2668.682326,\"USDMOP\":8.08285,\"USDMRO\":357.000024,\"USDMUR\":36.151503,\"USDMVR\":15.401494,\"USDMWK\":727.464985,\"USDMXN\":20.11091,\"USDMYR\":4.215203,\"USDMZN\":61.239988,\"USDNAD\":15.279842,\"USDNGN\":362.000276,\"USDNIO\":33.549897,\"USDNOK\":9.08749,\"USDNPR\":114.710296,\"USDNZD\":1.583205,\"USDOMR\":0.384995,\"USDPAB\":1.00015,\"USDPEN\":3.39775,\"USDPGK\":3.380187,\"USDPHP\":52.167998,\"USDPKR\":156.990385,\"USDPLN\":3.97255,\"USDPYG\":6219.65002,\"USDQAR\":3.64175,\"USDRON\":4.274984,\"USDRSD\":106.519936,\"USDRUB\":66.519498,\"USDRWF\":920,\"USDSAR\":3.75015,\"USDSBD\":8.22815,\"USDSCR\":13.670499,\"USDSDG\":45.124987,\"USDSEK\":9.76351,\"USDSGD\":1.38804,\"USDSHP\":1.320901,\"USDSLL\":9274.999722,\"USDSOS\":582.000141,\"USDSRD\":7.458031,\"USDSTD\":21560.79,\"USDSVC\":8.752201,\"USDSYP\":514.99971,\"USDSZL\":15.310252,\"USDTHB\":30.61503,\"USDTJS\":9.692494,\"USDTMT\":3.5,\"USDTND\":2.869303,\"USDTOP\":2.3246,\"USDTRY\":5.840161,\"USDTTD\":6.77965,\"USDTWD\":31.345502,\"USDTZS\":2297.905413,\"USDUAH\":25.227025,\"USDUGX\":3689.050304,\"USDUSD\":1,\"USDUYU\":36.519862,\"USDUZS\":9367.999946,\"USDVEF\":9.987506,\"USDVND\":23208.5,\"USDVUV\":118.059315,\"USDWST\":2.683373,\"USDXAF\":592.430151,\"USDXAG\":0.05412,\"USDXAU\":0.000651,\"USDXCD\":2.70265,\"USDXDR\":0.73015,\"USDXOF\":591.50058,\"USDXPF\":108.22981,\"USDYER\":250.299812,\"USDZAR\":15.287005,\"USDZMK\":9001.194287,\"USDZMW\":13.059023,\"USDZWL\":322.000001}}', 1, '2019-08-29 16:08:06', '2019-08-29 18:56:15', '2019-08-29 18:56:15', 'USD'),
(822, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567440485,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673098,\"USDAFN\":77.920495,\"USDALL\":111.260077,\"USDAMD\":476.169922,\"USDANG\":1.784397,\"USDAOA\":362.002498,\"USDARS\":58.007977,\"USDAUD\":1.488901,\"USDAWG\":1.8,\"USDAZN\":1.705,\"USDBAM\":1.78285,\"USDBBD\":2.0184,\"USDBDT\":84.674986,\"USDBGN\":1.783198,\"USDBHD\":0.377019,\"USDBIF\":1844.05,\"USDBMD\":1,\"USDBND\":1.350399,\"USDBOB\":6.92565,\"USDBRL\":4.162984,\"USDBSD\":1.00195,\"USDBTC\":0.000101,\"USDBTN\":71.382497,\"USDBWP\":11.102992,\"USDBYN\":2.11055,\"USDBYR\":19600,\"USDBZD\":2.014995,\"USDCAD\":1.33185,\"USDCDF\":1659.999994,\"USDCHF\":0.989898,\"USDCLF\":0.026271,\"USDCLP\":724.895022,\"USDCNY\":7.172095,\"USDCOP\":3453,\"USDCRC\":569.170318,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.419495,\"USDCZK\":23.601024,\"USDDJF\":177.719711,\"USDDKK\":6.79635,\"USDDOP\":51.545004,\"USDDZD\":120.47497,\"USDEGP\":16.55986,\"USDERN\":14.999768,\"USDETB\":29.148032,\"USDEUR\":0.911505,\"USDFJD\":2.19195,\"USDFKP\":0.82819,\"USDGBP\":0.828955,\"USDGEL\":2.939726,\"USDGGP\":0.828845,\"USDGHS\":5.465103,\"USDGIP\":0.828215,\"USDGMD\":50.495021,\"USDGNF\":9178.350007,\"USDGTQ\":7.682401,\"USDGYD\":209.139668,\"USDHKD\":7.84296,\"USDHNL\":24.514495,\"USDHRK\":6.74905,\"USDHTG\":95.313502,\"USDHUF\":301.78698,\"USDIDR\":14210.05,\"USDILS\":3.5392,\"USDIMP\":0.828845,\"USDINR\":71.98899,\"USDIQD\":1192.75,\"USDIRR\":42105.000431,\"USDISK\":126.609589,\"USDJEP\":0.828845,\"USDJMD\":135.769738,\"USDJOD\":0.709104,\"USDJPY\":106.19102,\"USDKES\":103.530018,\"USDKGS\":69.822401,\"USDKHR\":4088.649797,\"USDKMF\":448.05023,\"USDKPW\":900.059287,\"USDKRW\":1214.399323,\"USDKWD\":0.304302,\"USDKYD\":0.83299,\"USDKZT\":388.279703,\"USDLAK\":8769.102795,\"USDLBP\":1515.450255,\"USDLKR\":179.889647,\"USDLRD\":207.725007,\"USDLSL\":15.185018,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.40965,\"USDMAD\":9.657199,\"USDMDL\":17.744033,\"USDMGA\":3732.74987,\"USDMKD\":56.069501,\"USDMMK\":1522.950024,\"USDMNT\":2669.450892,\"USDMOP\":8.075303,\"USDMRO\":357.000024,\"USDMUR\":36.2475,\"USDMVR\":15.44997,\"USDMWK\":724.920112,\"USDMXN\":20.135903,\"USDMYR\":4.221598,\"USDMZN\":61.344989,\"USDNAD\":15.184955,\"USDNGN\":363.000216,\"USDNIO\":33.513501,\"USDNOK\":9.10252,\"USDNPR\":114.210076,\"USDNZD\":1.58475,\"USDOMR\":0.38495,\"USDPAB\":1.00215,\"USDPEN\":3.39735,\"USDPGK\":3.40355,\"USDPHP\":52.157988,\"USDPKR\":156.749759,\"USDPLN\":3.97465,\"USDPYG\":6249.801,\"USDQAR\":3.641018,\"USDRON\":4.306796,\"USDRSD\":107.249934,\"USDRUB\":66.789018,\"USDRWF\":920.325,\"USDSAR\":3.75075,\"USDSBD\":8.142803,\"USDSCR\":13.687945,\"USDSDG\":45.097003,\"USDSEK\":9.82176,\"USDSGD\":1.390803,\"USDSHP\":1.320898,\"USDSLL\":9299.999775,\"USDSOS\":580.999918,\"USDSRD\":7.45803,\"USDSTD\":21560.79,\"USDSVC\":8.74645,\"USDSYP\":515.000274,\"USDSZL\":15.219499,\"USDTHB\":30.6375,\"USDTJS\":9.69175,\"USDTMT\":3.51,\"USDTND\":2.8814,\"USDTOP\":2.328898,\"USDTRY\":5.822098,\"USDTTD\":6.81045,\"USDTWD\":31.371978,\"USDTZS\":2298.750064,\"USDUAH\":25.275969,\"USDUGX\":3683.250103,\"USDUSD\":1,\"USDUYU\":36.609854,\"USDUZS\":9370.775981,\"USDVEF\":9.987495,\"USDVND\":23186,\"USDVUV\":118.353033,\"USDWST\":2.687446,\"USDXAF\":597.950006,\"USDXAG\":0.054192,\"USDXAU\":0.000654,\"USDXCD\":2.70265,\"USDXDR\":0.733096,\"USDXOF\":597.949967,\"USDXPF\":108.710111,\"USDYER\":250.349967,\"USDZAR\":15.23596,\"USDZMK\":9001.199085,\"USDZMW\":13.101019,\"USDZWL\":322.000001}}', 1, '2019-09-02 16:08:05', '2019-09-02 18:25:03', '2019-09-02 18:25:03', 'USD'),
(823, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567526886,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673099,\"USDAFN\":78.25025,\"USDALL\":111.190253,\"USDAMD\":476.329688,\"USDANG\":1.78505,\"USDAOA\":362.002504,\"USDARS\":55.746995,\"USDAUD\":1.47985,\"USDAWG\":1.8,\"USDAZN\":1.704983,\"USDBAM\":1.788051,\"USDBBD\":2.0191,\"USDBDT\":84.496027,\"USDBGN\":1.783598,\"USDBHD\":0.37702,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35045,\"USDBOB\":6.91025,\"USDBRL\":4.1674,\"USDBSD\":0.99995,\"USDBTC\":0.000093744944,\"USDBTN\":72.3305,\"USDBWP\":11.067964,\"USDBYN\":2.123905,\"USDBYR\":19600,\"USDBZD\":2.015699,\"USDCAD\":1.333115,\"USDCDF\":1664.999907,\"USDCHF\":0.98725,\"USDCLF\":0.026289,\"USDCLP\":725.297348,\"USDCNY\":7.178974,\"USDCOP\":3439,\"USDCRC\":569.449664,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.720235,\"USDCZK\":23.551903,\"USDDJF\":177.720602,\"USDDKK\":6.79945,\"USDDOP\":51.394958,\"USDDZD\":120.530193,\"USDEGP\":16.54402,\"USDERN\":15.000142,\"USDETB\":29.525002,\"USDEUR\":0.91182,\"USDFJD\":2.19455,\"USDFKP\":0.831023,\"USDGBP\":0.82743,\"USDGEL\":2.940118,\"USDGGP\":0.827468,\"USDGHS\":5.47988,\"USDGIP\":0.830975,\"USDGMD\":50.425008,\"USDGNF\":9230.0001,\"USDGTQ\":7.68515,\"USDGYD\":209.214947,\"USDHKD\":7.84258,\"USDHNL\":24.523961,\"USDHRK\":6.754499,\"USDHTG\":95.355503,\"USDHUF\":301.027007,\"USDIDR\":14181.25,\"USDILS\":3.539299,\"USDIMP\":0.827468,\"USDINR\":72.216701,\"USDIQD\":1190,\"USDIRR\":42105.000063,\"USDISK\":127.020287,\"USDJEP\":0.827468,\"USDJMD\":135.830261,\"USDJOD\":0.709012,\"USDJPY\":105.892501,\"USDKES\":103.896797,\"USDKGS\":69.845102,\"USDKHR\":4094.999952,\"USDKMF\":449.049954,\"USDKPW\":900.06577,\"USDKRW\":1212.595001,\"USDKWD\":0.304397,\"USDKYD\":0.833405,\"USDKZT\":388.640025,\"USDLAK\":8785.000246,\"USDLBP\":1508.05025,\"USDLKR\":180.390067,\"USDLRD\":207.725014,\"USDLSL\":15.139973,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.419785,\"USDMAD\":9.6824,\"USDMDL\":17.775495,\"USDMGA\":3705.000143,\"USDMKD\":56.058499,\"USDMMK\":1527.501224,\"USDMNT\":2668.573828,\"USDMOP\":8.07885,\"USDMRO\":357.000024,\"USDMUR\":36.244506,\"USDMVR\":15.401804,\"USDMWK\":724.935042,\"USDMXN\":19.98133,\"USDMYR\":4.209202,\"USDMZN\":61.435001,\"USDNAD\":15.139973,\"USDNGN\":362.500507,\"USDNIO\":33.670277,\"USDNOK\":9.10489,\"USDNPR\":115.734999,\"USDNZD\":1.581075,\"USDOMR\":0.385026,\"USDPAB\":1.00005,\"USDPEN\":3.405903,\"USDPGK\":3.38785,\"USDPHP\":52.225498,\"USDPKR\":156.749936,\"USDPLN\":3.964421,\"USDPYG\":6257.349933,\"USDQAR\":3.640983,\"USDRON\":4.310201,\"USDRSD\":107.230147,\"USDRUB\":67.087502,\"USDRWF\":920,\"USDSAR\":3.75105,\"USDSBD\":8.142798,\"USDSCR\":13.670099,\"USDSDG\":45.113502,\"USDSEK\":9.83575,\"USDSGD\":1.39074,\"USDSHP\":1.320901,\"USDSLL\":9299.999768,\"USDSOS\":580.000032,\"USDSRD\":7.457973,\"USDSTD\":21560.79,\"USDSVC\":8.75115,\"USDSYP\":515.000332,\"USDSZL\":15.139753,\"USDTHB\":30.61034,\"USDTJS\":9.690103,\"USDTMT\":3.5,\"USDTND\":2.858498,\"USDTOP\":2.328402,\"USDTRY\":5.7234,\"USDTTD\":6.77975,\"USDTWD\":31.391497,\"USDTZS\":2298.820298,\"USDUAH\":25.26897,\"USDUGX\":3682.150046,\"USDUSD\":1,\"USDUYU\":36.620307,\"USDUZS\":9374.198387,\"USDVEF\":9.987497,\"USDVND\":23208.5,\"USDVUV\":118.412975,\"USDWST\":2.686761,\"USDXAF\":599.69004,\"USDXAG\":0.052249,\"USDXAU\":0.000646,\"USDXCD\":2.70265,\"USDXDR\":0.732932,\"USDXOF\":590.999945,\"USDXPF\":109.124993,\"USDYER\":250.298235,\"USDZAR\":15.12935,\"USDZMK\":9001.226387,\"USDZMW\":13.110963,\"USDZWL\":322.000001}}', 1, '2019-09-03 16:08:06', '2019-09-03 17:11:04', '2019-09-03 17:11:04', 'USD'),
(824, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567613286,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673026,\"USDAFN\":78.20203,\"USDALL\":110.479826,\"USDAMD\":476.499486,\"USDANG\":1.769903,\"USDAOA\":364.732998,\"USDARS\":56.0556,\"USDAUD\":1.470855,\"USDAWG\":1.8,\"USDAZN\":1.70496,\"USDBAM\":1.77525,\"USDBBD\":2.0191,\"USDBDT\":84.491996,\"USDBGN\":1.77485,\"USDBHD\":0.37701,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.90975,\"USDBRL\":4.114003,\"USDBSD\":0.99995,\"USDBTC\":0.000095255187,\"USDBTN\":72.085501,\"USDBWP\":10.959738,\"USDBYN\":2.1165,\"USDBYR\":19600,\"USDBZD\":2.0156,\"USDCAD\":1.32415,\"USDCDF\":1666.999782,\"USDCHF\":0.981295,\"USDCLF\":0.026181,\"USDCLP\":722.400846,\"USDCNY\":7.146023,\"USDCOP\":3398.45,\"USDCRC\":573.990163,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.598421,\"USDCZK\":23.4424,\"USDDJF\":177.720578,\"USDDKK\":6.762803,\"USDDOP\":51.394985,\"USDDZD\":120.219539,\"USDEGP\":16.524942,\"USDERN\":14.99987,\"USDETB\":29.574978,\"USDEUR\":0.906742,\"USDFJD\":2.19665,\"USDFKP\":0.8193,\"USDGBP\":0.819745,\"USDGEL\":2.959567,\"USDGGP\":0.820138,\"USDGHS\":5.472496,\"USDGIP\":0.819295,\"USDGMD\":50.415011,\"USDGNF\":9225.000287,\"USDGTQ\":7.67985,\"USDGYD\":208.925022,\"USDHKD\":7.83915,\"USDHNL\":24.649883,\"USDHRK\":6.713704,\"USDHTG\":96.006964,\"USDHUF\":298.679493,\"USDIDR\":14122.6,\"USDILS\":3.5284,\"USDIMP\":0.820138,\"USDINR\":72.008013,\"USDIQD\":1190,\"USDIRR\":42104.999707,\"USDISK\":126.309891,\"USDJEP\":0.820138,\"USDJMD\":136.000344,\"USDJOD\":0.707599,\"USDJPY\":106.25984,\"USDKES\":103.910315,\"USDKGS\":69.85001,\"USDKHR\":4089.999831,\"USDKMF\":447.050295,\"USDKPW\":900.060469,\"USDKRW\":1204.800382,\"USDKWD\":0.303899,\"USDKYD\":0.833355,\"USDKZT\":388.619779,\"USDLAK\":8795.000226,\"USDLBP\":1509.450191,\"USDLKR\":180.589674,\"USDLRD\":207.124971,\"USDLSL\":14.869919,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.419859,\"USDMAD\":9.66765,\"USDMDL\":17.8745,\"USDMGA\":3720.000202,\"USDMKD\":55.839499,\"USDMMK\":1531.450259,\"USDMNT\":2668.458887,\"USDMOP\":8.075601,\"USDMRO\":357.000024,\"USDMUR\":36.204496,\"USDMVR\":15.449671,\"USDMWK\":725.079966,\"USDMXN\":19.768597,\"USDMYR\":4.193025,\"USDMZN\":61.520226,\"USDNAD\":15.140087,\"USDNGN\":361.999796,\"USDNIO\":33.697903,\"USDNOK\":9.033455,\"USDNPR\":115.334992,\"USDNZD\":1.573195,\"USDOMR\":0.38501,\"USDPAB\":1.00005,\"USDPEN\":3.40015,\"USDPGK\":3.404201,\"USDPHP\":51.870498,\"USDPKR\":156.739696,\"USDPLN\":3.93345,\"USDPYG\":6286.000126,\"USDQAR\":3.641035,\"USDRON\":4.2875,\"USDRSD\":106.620063,\"USDRUB\":66.144403,\"USDRWF\":920,\"USDSAR\":3.751499,\"USDSBD\":8.17195,\"USDSCR\":13.699014,\"USDSDG\":45.111498,\"USDSEK\":9.749295,\"USDSGD\":1.38413,\"USDSHP\":1.320898,\"USDSLL\":9487.502673,\"USDSOS\":581.000071,\"USDSRD\":7.45798,\"USDSTD\":21560.79,\"USDSVC\":8.75015,\"USDSYP\":514.999724,\"USDSZL\":15.140449,\"USDTHB\":30.580307,\"USDTJS\":9.689698,\"USDTMT\":3.51,\"USDTND\":2.866201,\"USDTOP\":2.32565,\"USDTRY\":5.672299,\"USDTTD\":6.77545,\"USDTWD\":31.263978,\"USDTZS\":2298.29906,\"USDUAH\":25.277998,\"USDUGX\":3687.450353,\"USDUSD\":1,\"USDUYU\":36.809839,\"USDUZS\":9379.999673,\"USDVEF\":9.987495,\"USDVND\":23208.5,\"USDVUV\":118.103983,\"USDWST\":2.680951,\"USDXAF\":595.409646,\"USDXAG\":0.051523,\"USDXAU\":0.000646,\"USDXCD\":2.70265,\"USDXDR\":0.73085,\"USDXOF\":604.999827,\"USDXPF\":108.696248,\"USDYER\":250.350101,\"USDZAR\":14.79465,\"USDZMK\":9001.197576,\"USDZMW\":13.110329,\"USDZWL\":322.000001}}', 1, '2019-09-04 16:08:06', '2019-09-05 09:39:26', '2019-09-05 09:39:26', 'USD'),
(825, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567699686,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673032,\"USDAFN\":78.349461,\"USDALL\":110.27988,\"USDAMD\":476.340437,\"USDANG\":1.765103,\"USDAOA\":365.415005,\"USDARS\":55.983956,\"USDAUD\":1.466203,\"USDAWG\":1.799,\"USDAZN\":1.705036,\"USDBAM\":1.76925,\"USDBBD\":2.01945,\"USDBDT\":84.429951,\"USDBGN\":1.771798,\"USDBHD\":0.377035,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.90435,\"USDBRL\":4.090697,\"USDBSD\":0.99915,\"USDBTC\":0.000094447239,\"USDBTN\":71.809496,\"USDBWP\":10.932999,\"USDBYN\":2.10975,\"USDBYR\":19600,\"USDBZD\":2.016035,\"USDCAD\":1.32362,\"USDCDF\":1664.999882,\"USDCHF\":0.986802,\"USDCLF\":0.02596,\"USDCLP\":716.398647,\"USDCNY\":7.148597,\"USDCOP\":3376.6,\"USDCRC\":576.574961,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.429815,\"USDCZK\":23.395102,\"USDDJF\":177.71979,\"USDDKK\":6.75703,\"USDDOP\":51.39496,\"USDDZD\":120.070168,\"USDEGP\":16.50857,\"USDERN\":14.99972,\"USDETB\":29.589473,\"USDEUR\":0.905705,\"USDFJD\":2.18475,\"USDFKP\":0.813021,\"USDGBP\":0.81089,\"USDGEL\":2.960288,\"USDGGP\":0.810855,\"USDGHS\":5.46999,\"USDGIP\":0.812979,\"USDGMD\":50.414968,\"USDGNF\":9229.999816,\"USDGTQ\":7.6888,\"USDGYD\":208.694991,\"USDHKD\":7.83825,\"USDHNL\":24.71976,\"USDHRK\":6.706043,\"USDHTG\":95.897499,\"USDHUF\":298.640119,\"USDIDR\":14115.25,\"USDILS\":3.516503,\"USDIMP\":0.810855,\"USDINR\":71.863098,\"USDIQD\":1190,\"USDIRR\":42104.99992,\"USDISK\":126.169848,\"USDJEP\":0.810855,\"USDJMD\":135.780277,\"USDJOD\":0.708958,\"USDJPY\":106.962974,\"USDKES\":103.849551,\"USDKGS\":69.849804,\"USDKHR\":4091.000341,\"USDKMF\":444.725002,\"USDKPW\":900.011401,\"USDKRW\":1198.169776,\"USDKWD\":0.303802,\"USDKYD\":0.83343,\"USDKZT\":388.160026,\"USDLAK\":8795.000105,\"USDLBP\":1509.349952,\"USDLKR\":180.759857,\"USDLRD\":206.999811,\"USDLSL\":14.839815,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.415012,\"USDMAD\":9.6445,\"USDMDL\":17.922988,\"USDMGA\":3724.999832,\"USDMKD\":55.573031,\"USDMMK\":1540.296301,\"USDMNT\":2669.526329,\"USDMOP\":8.0756,\"USDMRO\":357.000024,\"USDMUR\":36.149888,\"USDMVR\":15.380041,\"USDMWK\":725.495013,\"USDMXN\":19.690703,\"USDMYR\":4.191604,\"USDMZN\":61.550104,\"USDNAD\":14.824998,\"USDNGN\":362.50015,\"USDNIO\":33.502967,\"USDNOK\":8.993685,\"USDNPR\":114.905013,\"USDNZD\":1.56892,\"USDOMR\":0.384979,\"USDPAB\":0.99925,\"USDPEN\":3.36355,\"USDPGK\":3.40355,\"USDPHP\":52.018948,\"USDPKR\":156.692461,\"USDPLN\":3.92835,\"USDPYG\":6248.471922,\"USDQAR\":3.641018,\"USDRON\":4.2855,\"USDRSD\":106.489667,\"USDRUB\":66.102105,\"USDRWF\":921,\"USDSAR\":3.752097,\"USDSBD\":8.212299,\"USDSCR\":13.691966,\"USDSDG\":45.119755,\"USDSEK\":9.682175,\"USDSGD\":1.38424,\"USDSHP\":1.320898,\"USDSLL\":9500.000168,\"USDSOS\":580.000084,\"USDSRD\":7.457987,\"USDSTD\":21560.79,\"USDSVC\":8.752101,\"USDSYP\":514.999892,\"USDSZL\":14.824984,\"USDTHB\":30.690219,\"USDTJS\":9.68925,\"USDTMT\":3.5,\"USDTND\":2.86695,\"USDTOP\":2.320798,\"USDTRY\":5.695596,\"USDTTD\":6.77055,\"USDTWD\":31.247502,\"USDTZS\":2298.000398,\"USDUAH\":25.209001,\"USDUGX\":3678.601759,\"USDUSD\":1,\"USDUYU\":36.710066,\"USDUZS\":9399.999719,\"USDVEF\":9.987504,\"USDVND\":23198.5,\"USDVUV\":117.673291,\"USDWST\":2.673063,\"USDXAF\":593.359958,\"USDXAG\":0.053363,\"USDXAU\":0.000659,\"USDXCD\":2.70255,\"USDXDR\":0.73045,\"USDXOF\":597.000347,\"USDXPF\":108.149562,\"USDYER\":250.300135,\"USDZAR\":14.86265,\"USDZMK\":9001.19767,\"USDZMW\":13.148028,\"USDZWL\":322.000001}}', 1, '2019-09-05 16:08:06', '2019-09-06 11:34:00', '2019-09-06 11:34:00', 'USD'),
(826, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567786086,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673033,\"USDAFN\":78.250041,\"USDALL\":110.202384,\"USDAMD\":476.549693,\"USDANG\":1.76605,\"USDAOA\":365.678497,\"USDARS\":55.872992,\"USDAUD\":1.458525,\"USDAWG\":1.8,\"USDAZN\":1.704965,\"USDBAM\":1.774096,\"USDBBD\":2.0202,\"USDBDT\":84.560161,\"USDBGN\":1.771601,\"USDBHD\":0.3772,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.350599,\"USDBOB\":6.91885,\"USDBRL\":4.067037,\"USDBSD\":1.00055,\"USDBTC\":0.000091993883,\"USDBTN\":71.641013,\"USDBWP\":10.928018,\"USDBYN\":2.10645,\"USDBYR\":19600,\"USDBZD\":2.01685,\"USDCAD\":1.317015,\"USDCDF\":1665.999598,\"USDCHF\":0.986305,\"USDCLF\":0.025742,\"USDCLP\":710.300677,\"USDCNY\":7.115696,\"USDCOP\":3366.4,\"USDCRC\":579.098855,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.126498,\"USDCZK\":23.398605,\"USDDJF\":177.719718,\"USDDKK\":6.756695,\"USDDOP\":51.414996,\"USDDZD\":120.050242,\"USDEGP\":16.495715,\"USDERN\":15.000404,\"USDETB\":29.450201,\"USDEUR\":0.90552,\"USDFJD\":2.18275,\"USDFKP\":0.811195,\"USDGBP\":0.813198,\"USDGEL\":2.955009,\"USDGGP\":0.813193,\"USDGHS\":5.495019,\"USDGIP\":0.81118,\"USDGMD\":50.445027,\"USDGNF\":9224.999857,\"USDGTQ\":7.69185,\"USDGYD\":208.769745,\"USDHKD\":7.83875,\"USDHNL\":24.449533,\"USDHRK\":6.70599,\"USDHTG\":95.362992,\"USDHUF\":298.938005,\"USDIDR\":14066.05,\"USDILS\":3.518303,\"USDIMP\":0.813193,\"USDINR\":71.592501,\"USDIQD\":1190,\"USDIRR\":42104.999932,\"USDISK\":126.149722,\"USDJEP\":0.813193,\"USDJMD\":137.289836,\"USDJOD\":0.707101,\"USDJPY\":106.805503,\"USDKES\":103.855001,\"USDKGS\":69.849502,\"USDKHR\":4090.999812,\"USDKMF\":444.724986,\"USDKPW\":900.024252,\"USDKRW\":1191.69501,\"USDKWD\":0.303902,\"USDKYD\":0.833895,\"USDKZT\":388.109869,\"USDLAK\":8795.000102,\"USDLBP\":1509.949872,\"USDLKR\":180.90972,\"USDLRD\":206.9998,\"USDLSL\":14.840311,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.414998,\"USDMAD\":9.660301,\"USDMDL\":17.876018,\"USDMGA\":3680.000341,\"USDMKD\":55.666046,\"USDMMK\":1525.849863,\"USDMNT\":2669.498264,\"USDMOP\":8.079399,\"USDMRO\":357.000024,\"USDMUR\":36.152497,\"USDMVR\":15.403349,\"USDMWK\":726.020154,\"USDMXN\":19.554301,\"USDMYR\":4.174295,\"USDMZN\":61.5503,\"USDNAD\":14.825009,\"USDNGN\":362.500548,\"USDNIO\":33.559922,\"USDNOK\":8.969305,\"USDNPR\":114.625012,\"USDNZD\":1.553105,\"USDOMR\":0.38485,\"USDPAB\":1.00065,\"USDPEN\":3.34355,\"USDPGK\":3.40355,\"USDPHP\":51.829898,\"USDPKR\":156.960051,\"USDPLN\":3.92989,\"USDPYG\":6241.149582,\"USDQAR\":3.640954,\"USDRON\":4.283698,\"USDRSD\":106.48965,\"USDRUB\":65.716295,\"USDRWF\":921,\"USDSAR\":3.75115,\"USDSBD\":8.23935,\"USDSCR\":13.742986,\"USDSDG\":45.130496,\"USDSEK\":9.62048,\"USDSGD\":1.3798,\"USDSHP\":1.320902,\"USDSLL\":9299.999825,\"USDSOS\":580.00028,\"USDSRD\":7.457972,\"USDSTD\":21560.79,\"USDSVC\":8.755303,\"USDSYP\":514.999903,\"USDSZL\":14.824969,\"USDTHB\":30.63402,\"USDTJS\":9.695398,\"USDTMT\":3.5,\"USDTND\":2.869503,\"USDTOP\":2.316497,\"USDTRY\":5.71996,\"USDTTD\":6.77295,\"USDTWD\":31.192495,\"USDTZS\":2299.101861,\"USDUAH\":25.057955,\"USDUGX\":3679.999758,\"USDUSD\":1,\"USDUYU\":36.689848,\"USDUZS\":9394.999547,\"USDVEF\":9.987503,\"USDVND\":23199,\"USDVUV\":117.505025,\"USDWST\":2.669501,\"USDXAF\":595.019759,\"USDXAG\":0.053297,\"USDXAU\":0.000657,\"USDXCD\":2.70255,\"USDXDR\":0.72985,\"USDXOF\":601.489851,\"USDXPF\":108.150169,\"USDYER\":250.292642,\"USDZAR\":14.75352,\"USDZMK\":9001.200902,\"USDZMW\":13.136992,\"USDZWL\":322.000001}}', 1, '2019-09-06 16:08:06', '2019-09-06 17:16:47', '2019-09-06 17:16:47', 'USD'),
(827, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1567958885,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673042,\"USDAFN\":77.529504,\"USDALL\":109.410403,\"USDAMD\":472.525041,\"USDANG\":1.74885,\"USDAOA\":365.678504,\"USDARS\":55.506041,\"USDAUD\":1.46005,\"USDAWG\":1.8,\"USDAZN\":1.705041,\"USDBAM\":1.75685,\"USDBBD\":2.00055,\"USDBDT\":83.734504,\"USDBGN\":1.75685,\"USDBHD\":0.37359,\"USDBIF\":1828.25,\"USDBMD\":1,\"USDBND\":1.36925,\"USDBOB\":6.85155,\"USDBRL\":4.06995,\"USDBSD\":0.99079,\"USDBTC\":0.00009591948,\"USDBTN\":70.942041,\"USDBWP\":10.811041,\"USDBYN\":2.085904,\"USDBYR\":19600,\"USDBZD\":1.997204,\"USDCAD\":1.31755,\"USDCDF\":1666.000362,\"USDCHF\":0.987175,\"USDCLF\":0.025793,\"USDCLP\":711.695041,\"USDCNY\":7.115704,\"USDCOP\":3347.05,\"USDCRC\":573.465041,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.05204,\"USDCZK\":23.44804,\"USDDJF\":177.720394,\"USDDKK\":6.765904,\"USDDOP\":50.888504,\"USDDZD\":119.050393,\"USDEGP\":16.341504,\"USDERN\":15.000358,\"USDETB\":29.110504,\"USDEUR\":0.89827,\"USDFJD\":2.17585,\"USDFKP\":0.811215,\"USDGBP\":0.81403,\"USDGEL\":2.960391,\"USDGGP\":0.81448,\"USDGHS\":5.43445,\"USDGIP\":0.811215,\"USDGMD\":50.44504,\"USDGNF\":9104.15039,\"USDGTQ\":7.61695,\"USDGYD\":206.73504,\"USDHKD\":7.839604,\"USDHNL\":24.314504,\"USDHRK\":6.65065,\"USDHTG\":94.43504,\"USDHUF\":299.330388,\"USDIDR\":14067.15,\"USDILS\":3.518304,\"USDIMP\":0.81448,\"USDINR\":71.645504,\"USDIQD\":1182.35,\"USDIRR\":42105.000352,\"USDISK\":126.310386,\"USDJEP\":0.81448,\"USDJMD\":135.95504,\"USDJOD\":0.707104,\"USDJPY\":106.92504,\"USDKES\":102.950385,\"USDKGS\":69.849504,\"USDKHR\":4062.903799,\"USDKMF\":445.950384,\"USDKPW\":899.751354,\"USDKRW\":1192.903792,\"USDKWD\":0.303904,\"USDKYD\":0.82578,\"USDKZT\":384.315039,\"USDLAK\":8707.850383,\"USDLBP\":1498.303779,\"USDLKR\":179.240382,\"USDLRD\":208.503775,\"USDLSL\":14.760382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.39955,\"USDMAD\":9.58095,\"USDMDL\":17.701504,\"USDMGA\":3708.15038,\"USDMKD\":55.243504,\"USDMMK\":1510.95038,\"USDMNT\":2661.5,\"USDMOP\":8.00085,\"USDMRO\":357.000024,\"USDMUR\":36.150379,\"USDMVR\":15.450378,\"USDMWK\":725.820378,\"USDMXN\":19.537104,\"USDMYR\":4.180504,\"USDMZN\":61.550377,\"USDNAD\":14.760377,\"USDNGN\":363.000344,\"USDNIO\":33.237039,\"USDNOK\":8.974404,\"USDNPR\":113.505039,\"USDNZD\":1.556104,\"USDOMR\":0.385039,\"USDPAB\":0.990865,\"USDPEN\":3.33315,\"USDPGK\":3.37235,\"USDPHP\":51.399039,\"USDPKR\":155.510375,\"USDPLN\":3.93355,\"USDPYG\":6180.303699,\"USDQAR\":3.641038,\"USDRON\":4.292038,\"USDRSD\":105.640373,\"USDRUB\":65.787504,\"USDRWF\":913.005,\"USDSAR\":3.750704,\"USDSBD\":8.23935,\"USDSCR\":13.740372,\"USDSDG\":44.692504,\"USDSEK\":9.644204,\"USDSGD\":1.381304,\"USDSHP\":1.320904,\"USDSLL\":9300.000339,\"USDSOS\":581.000338,\"USDSRD\":7.458038,\"USDSTD\":21560.79,\"USDSVC\":8.670104,\"USDSYP\":515.000338,\"USDSZL\":14.627504,\"USDTHB\":30.393038,\"USDTJS\":9.600704,\"USDTMT\":3.51,\"USDTND\":2.869504,\"USDTOP\":2.316504,\"USDTRY\":5.714904,\"USDTTD\":6.70705,\"USDTWD\":31.194504,\"USDTZS\":2277.903635,\"USDUAH\":24.812504,\"USDUGX\":3644.303631,\"USDUSD\":1,\"USDUYU\":36.329038,\"USDUZS\":9313.750367,\"USDVEF\":9.987504,\"USDVND\":22985.85,\"USDVUV\":116.279999,\"USDWST\":2.71444,\"USDXAF\":589.230365,\"USDXAG\":0.055001,\"USDXAU\":0.000663,\"USDXCD\":2.70255,\"USDXDR\":0.730428,\"USDXOF\":589.230364,\"USDXPF\":107.130364,\"USDYER\":250.350364,\"USDZAR\":14.807204,\"USDZMK\":9001.203593,\"USDZMW\":13.010363,\"USDZWL\":322.000001}}', 1, '2019-09-08 16:08:05', '2019-09-09 12:26:43', '2019-09-09 12:26:43', 'USD'),
(828, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568045286,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673014,\"USDAFN\":78.549959,\"USDALL\":109.879676,\"USDAMD\":476.650351,\"USDANG\":1.76495,\"USDAOA\":365.678504,\"USDARS\":56.005016,\"USDAUD\":1.455045,\"USDAWG\":1.8,\"USDAZN\":1.705002,\"USDBAM\":1.773805,\"USDBBD\":2.01905,\"USDBDT\":84.335996,\"USDBGN\":1.768698,\"USDBHD\":0.377017,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.350349,\"USDBOB\":6.89965,\"USDBRL\":4.081903,\"USDBSD\":0.99915,\"USDBTC\":0.000097354603,\"USDBTN\":71.4905,\"USDBWP\":10.903997,\"USDBYN\":2.094503,\"USDBYR\":19600,\"USDBZD\":2.01555,\"USDCAD\":1.314305,\"USDCDF\":1664.999741,\"USDCHF\":0.990765,\"USDCLF\":0.025865,\"USDCLP\":713.701498,\"USDCNY\":7.121995,\"USDCOP\":3372.3,\"USDCRC\":579.455007,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.7415,\"USDCZK\":23.376996,\"USDDJF\":177.71984,\"USDDKK\":6.744485,\"USDDOP\":51.289842,\"USDDZD\":120.02497,\"USDEGP\":16.460966,\"USDERN\":15.000098,\"USDETB\":29.180997,\"USDEUR\":0.90415,\"USDFJD\":2.18035,\"USDFKP\":0.81378,\"USDGBP\":0.80861,\"USDGEL\":2.960211,\"USDGGP\":0.808564,\"USDGHS\":5.495025,\"USDGIP\":0.813801,\"USDGMD\":50.444966,\"USDGNF\":9240.000307,\"USDGTQ\":7.69465,\"USDGYD\":209.20503,\"USDHKD\":7.83836,\"USDHNL\":24.543501,\"USDHRK\":6.690099,\"USDHTG\":95.301991,\"USDHUF\":298.325986,\"USDIDR\":14026.3,\"USDILS\":3.526954,\"USDIMP\":0.808564,\"USDINR\":71.687968,\"USDIQD\":1193,\"USDIRR\":42105.000341,\"USDISK\":125.760276,\"USDJEP\":0.808564,\"USDJMD\":136.820161,\"USDJOD\":0.708999,\"USDJPY\":107.128495,\"USDKES\":103.705,\"USDKGS\":69.849742,\"USDKHR\":4090.000246,\"USDKMF\":445.949819,\"USDKPW\":899.978776,\"USDKRW\":1191.815562,\"USDKWD\":0.303906,\"USDKYD\":0.833298,\"USDKZT\":386.160005,\"USDLAK\":8793.60184,\"USDLBP\":1508.35034,\"USDLKR\":180.569931,\"USDLRD\":208.520298,\"USDLSL\":14.76015,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.400338,\"USDMAD\":9.657696,\"USDMDL\":17.804979,\"USDMGA\":3742.402114,\"USDMKD\":55.776971,\"USDMMK\":1534.950064,\"USDMNT\":2668.993667,\"USDMOP\":8.075895,\"USDMRO\":357.000024,\"USDMUR\":36.160027,\"USDMVR\":15.449802,\"USDMWK\":725.245016,\"USDMXN\":19.532902,\"USDMYR\":4.165301,\"USDMZN\":61.615019,\"USDNAD\":14.759981,\"USDNGN\":362.999689,\"USDNIO\":33.56028,\"USDNOK\":8.925595,\"USDNPR\":114.400586,\"USDNZD\":1.554455,\"USDOMR\":0.38505,\"USDPAB\":0.99925,\"USDPEN\":3.344602,\"USDPGK\":3.40355,\"USDPHP\":51.860226,\"USDPKR\":156.750203,\"USDPLN\":3.91966,\"USDPYG\":6277.850113,\"USDQAR\":3.64101,\"USDRON\":4.276698,\"USDRSD\":106.329919,\"USDRUB\":65.525962,\"USDRWF\":920,\"USDSAR\":3.75115,\"USDSBD\":8.23935,\"USDSCR\":13.739923,\"USDSDG\":45.11098,\"USDSEK\":9.64925,\"USDSGD\":1.378901,\"USDSHP\":1.320902,\"USDSLL\":9299.999904,\"USDSOS\":580.999652,\"USDSRD\":7.457995,\"USDSTD\":21560.79,\"USDSVC\":8.750149,\"USDSYP\":514.999938,\"USDSZL\":14.705006,\"USDTHB\":30.638001,\"USDTJS\":9.69075,\"USDTMT\":3.51,\"USDTND\":2.86275,\"USDTOP\":2.312497,\"USDTRY\":5.753194,\"USDTTD\":6.75845,\"USDTWD\":31.199497,\"USDTZS\":2297.801973,\"USDUAH\":24.994008,\"USDUGX\":3677.849625,\"USDUSD\":1,\"USDUYU\":36.601353,\"USDUZS\":9399.650151,\"USDVEF\":9.987499,\"USDVND\":23208.5,\"USDVUV\":117.162199,\"USDWST\":2.669501,\"USDXAF\":594.920086,\"USDXAG\":0.055548,\"USDXAU\":0.000667,\"USDXCD\":2.70255,\"USDXDR\":0.72985,\"USDXOF\":594.920143,\"USDXPF\":108.500496,\"USDYER\":250.349512,\"USDZAR\":14.747197,\"USDZMK\":9001.19797,\"USDZMW\":13.164985,\"USDZWL\":322.000001}}', 1, '2019-09-09 16:08:06', '2019-09-09 18:14:09', '2019-09-09 18:14:09', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(829, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568131686,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672989,\"USDAFN\":78.399831,\"USDALL\":110.109753,\"USDAMD\":476.350414,\"USDANG\":1.765504,\"USDAOA\":365.678501,\"USDARS\":56.087032,\"USDAUD\":1.456485,\"USDAWG\":1.801,\"USDAZN\":1.704958,\"USDBAM\":1.772351,\"USDBBD\":2.02025,\"USDBDT\":84.338022,\"USDBGN\":1.77155,\"USDBHD\":0.377199,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35035,\"USDBOB\":6.90005,\"USDBRL\":4.103299,\"USDBSD\":0.99995,\"USDBTC\":0.000098108902,\"USDBTN\":71.922,\"USDBWP\":10.879906,\"USDBYN\":2.08895,\"USDBYR\":19600,\"USDBZD\":2.01635,\"USDCAD\":1.314445,\"USDCDF\":1665.000187,\"USDCHF\":0.99072,\"USDCLF\":0.02584,\"USDCLP\":713.10058,\"USDCNY\":7.112697,\"USDCOP\":3363,\"USDCRC\":578.135036,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.768506,\"USDCZK\":23.411604,\"USDDJF\":177.720044,\"USDDKK\":6.755704,\"USDDOP\":51.334997,\"USDDZD\":119.934967,\"USDEGP\":16.458604,\"USDERN\":14.999745,\"USDETB\":29.350495,\"USDEUR\":0.9056,\"USDFJD\":2.17505,\"USDFKP\":0.809915,\"USDGBP\":0.809255,\"USDGEL\":2.959949,\"USDGGP\":0.809407,\"USDGHS\":5.480134,\"USDGIP\":0.80991,\"USDGMD\":50.455043,\"USDGNF\":9224.999911,\"USDGTQ\":7.702497,\"USDGYD\":208.635041,\"USDHKD\":7.84025,\"USDHNL\":24.555018,\"USDHRK\":6.694303,\"USDHTG\":95.011496,\"USDHUF\":300.07965,\"USDIDR\":14047.9,\"USDILS\":3.545503,\"USDIMP\":0.809407,\"USDINR\":71.852498,\"USDIQD\":1193.6,\"USDIRR\":42105.000172,\"USDISK\":125.590036,\"USDJEP\":0.809407,\"USDJMD\":136.879836,\"USDJOD\":0.709015,\"USDJPY\":107.327006,\"USDKES\":103.649863,\"USDKGS\":69.850138,\"USDKHR\":4100.000311,\"USDKMF\":446.125025,\"USDKPW\":899.985107,\"USDKRW\":1191.906991,\"USDKWD\":0.3039,\"USDKYD\":0.833585,\"USDKZT\":386.249847,\"USDLAK\":8804.99993,\"USDLBP\":1507.549794,\"USDLKR\":180.409871,\"USDLRD\":209.124985,\"USDLSL\":14.689977,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404988,\"USDMAD\":9.65465,\"USDMDL\":17.770155,\"USDMGA\":3743.201894,\"USDMKD\":55.686503,\"USDMMK\":1526.449664,\"USDMNT\":2668.745703,\"USDMOP\":8.07965,\"USDMRO\":357.000024,\"USDMUR\":36.229774,\"USDMVR\":15.401804,\"USDMWK\":725.234974,\"USDMXN\":19.5044,\"USDMYR\":4.166499,\"USDMZN\":61.62499,\"USDNAD\":14.68972,\"USDNGN\":362.508989,\"USDNIO\":33.556051,\"USDNOK\":8.958035,\"USDNPR\":115.07499,\"USDNZD\":1.557101,\"USDOMR\":0.384981,\"USDPAB\":0.99985,\"USDPEN\":3.34165,\"USDPGK\":3.40355,\"USDPHP\":52.060501,\"USDPKR\":156.496125,\"USDPLN\":3.92315,\"USDPYG\":6299.85001,\"USDQAR\":3.64175,\"USDRON\":4.285398,\"USDRSD\":106.390122,\"USDRUB\":65.4169,\"USDRWF\":922.5,\"USDSAR\":3.7514,\"USDSBD\":8.23935,\"USDSCR\":13.713993,\"USDSDG\":45.127502,\"USDSEK\":9.691575,\"USDSGD\":1.379345,\"USDSHP\":1.320898,\"USDSLL\":9350.000289,\"USDSOS\":580.999779,\"USDSRD\":7.458026,\"USDSTD\":21560.79,\"USDSVC\":8.75285,\"USDSYP\":515.000046,\"USDSZL\":14.690428,\"USDTHB\":30.616992,\"USDTJS\":9.693499,\"USDTMT\":3.51,\"USDTND\":2.85625,\"USDTOP\":2.31145,\"USDTRY\":5.780399,\"USDTTD\":6.75805,\"USDTWD\":31.227049,\"USDTZS\":2299.705142,\"USDUAH\":24.994036,\"USDUGX\":3669.149838,\"USDUSD\":1,\"USDUYU\":36.449592,\"USDUZS\":9403.0502,\"USDVEF\":9.987501,\"USDVND\":23208.5,\"USDVUV\":116.982397,\"USDWST\":2.659589,\"USDXAF\":594.409768,\"USDXAG\":0.055119,\"USDXAU\":0.000669,\"USDXCD\":2.70255,\"USDXDR\":0.730116,\"USDXOF\":594.419876,\"USDXPF\":108.550152,\"USDYER\":250.349623,\"USDZAR\":14.668898,\"USDZMK\":9001.199372,\"USDZMW\":13.129016,\"USDZWL\":322.000001}}', 1, '2019-09-10 16:08:06', '2019-09-10 17:31:53', '2019-09-10 17:31:53', 'USD'),
(830, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568218086,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673103,\"USDAFN\":78.550477,\"USDALL\":110.449828,\"USDAMD\":476.340291,\"USDANG\":1.76465,\"USDAOA\":365.678501,\"USDARS\":56.064996,\"USDAUD\":1.457675,\"USDAWG\":1.801,\"USDAZN\":1.704979,\"USDBAM\":1.77635,\"USDBBD\":2.0188,\"USDBDT\":84.47602,\"USDBGN\":1.778198,\"USDBHD\":0.377097,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.35075,\"USDBOB\":6.90835,\"USDBRL\":4.060133,\"USDBSD\":0.99955,\"USDBTC\":0.000101,\"USDBTN\":71.675503,\"USDBWP\":10.892021,\"USDBYN\":2.08195,\"USDBYR\":19600,\"USDBZD\":2.01535,\"USDCAD\":1.32023,\"USDCDF\":1665.999677,\"USDCHF\":0.993215,\"USDCLF\":0.025938,\"USDCLP\":715.497889,\"USDCNY\":7.1167,\"USDCOP\":3376.3,\"USDCRC\":576.674986,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.502134,\"USDCZK\":23.54803,\"USDDJF\":177.720551,\"USDDKK\":6.782795,\"USDDOP\":51.415018,\"USDDZD\":120.29502,\"USDEGP\":16.430277,\"USDERN\":15.000121,\"USDETB\":29.44988,\"USDEUR\":0.90913,\"USDFJD\":2.17685,\"USDFKP\":0.81011,\"USDGBP\":0.810905,\"USDGEL\":2.959692,\"USDGGP\":0.810936,\"USDGHS\":5.479916,\"USDGIP\":0.81011,\"USDGMD\":50.465018,\"USDGNF\":9230.000283,\"USDGTQ\":7.70115,\"USDGYD\":208.634989,\"USDHKD\":7.839955,\"USDHNL\":24.584981,\"USDHRK\":6.721097,\"USDHTG\":94.972502,\"USDHUF\":302.559774,\"USDIDR\":14053.8,\"USDILS\":3.539498,\"USDIMP\":0.810936,\"USDINR\":71.599499,\"USDIQD\":1189.5,\"USDIRR\":42105.000049,\"USDISK\":125.930143,\"USDJEP\":0.810936,\"USDJMD\":135.959836,\"USDJOD\":0.709019,\"USDJPY\":107.748016,\"USDKES\":103.816407,\"USDKGS\":69.849934,\"USDKHR\":4100.999767,\"USDKMF\":447.650082,\"USDKPW\":899.978486,\"USDKRW\":1191.409729,\"USDKWD\":0.3041,\"USDKYD\":0.83319,\"USDKZT\":386.48977,\"USDLAK\":8806.502842,\"USDLBP\":1507.749828,\"USDLKR\":180.360313,\"USDLRD\":208.625019,\"USDLSL\":14.739878,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.415017,\"USDMAD\":9.66185,\"USDMDL\":17.670496,\"USDMGA\":3724.999376,\"USDMKD\":55.962504,\"USDMMK\":1528.697181,\"USDMNT\":2668.904276,\"USDMOP\":8.07285,\"USDMRO\":357.000024,\"USDMUR\":36.198499,\"USDMVR\":15.420163,\"USDMWK\":725.410301,\"USDMXN\":19.54641,\"USDMYR\":4.174979,\"USDMZN\":61.690047,\"USDNAD\":14.739857,\"USDNGN\":362.999671,\"USDNIO\":33.586468,\"USDNOK\":8.976731,\"USDNPR\":114.680138,\"USDNZD\":1.55904,\"USDOMR\":0.385,\"USDPAB\":0.99985,\"USDPEN\":3.34725,\"USDPGK\":3.38503,\"USDPHP\":52.094968,\"USDPKR\":156.494249,\"USDPLN\":3.94705,\"USDPYG\":6311.103383,\"USDQAR\":3.641009,\"USDRON\":4.305797,\"USDRSD\":106.449694,\"USDRUB\":65.474899,\"USDRWF\":922.5,\"USDSAR\":3.75125,\"USDSBD\":8.22815,\"USDSCR\":13.706901,\"USDSDG\":45.101498,\"USDSEK\":9.686802,\"USDSGD\":1.379635,\"USDSHP\":1.320898,\"USDSLL\":9399.999834,\"USDSOS\":579.999767,\"USDSRD\":7.457997,\"USDSTD\":21560.79,\"USDSVC\":8.748801,\"USDSYP\":514.999835,\"USDSZL\":14.739682,\"USDTHB\":30.579845,\"USDTJS\":9.68735,\"USDTMT\":3.5,\"USDTND\":2.86955,\"USDTOP\":2.310601,\"USDTRY\":5.74789,\"USDTTD\":6.77855,\"USDTWD\":31.132499,\"USDTZS\":2299.298706,\"USDUAH\":24.938996,\"USDUGX\":3664.463599,\"USDUSD\":1,\"USDUYU\":36.489759,\"USDUZS\":9404.999777,\"USDVEF\":9.9875,\"USDVND\":23208.5,\"USDVUV\":117.012629,\"USDWST\":2.660977,\"USDXAF\":595.780175,\"USDXAG\":0.055322,\"USDXAU\":0.000669,\"USDXCD\":2.70255,\"USDXDR\":0.731317,\"USDXOF\":595.000265,\"USDXPF\":108.874994,\"USDYER\":250.30389,\"USDZAR\":14.733003,\"USDZMK\":9001.207217,\"USDZMW\":13.123999,\"USDZWL\":322.000001}}', 1, '2019-09-11 16:08:06', '2019-09-11 16:58:35', '2019-09-11 16:58:35', 'USD'),
(831, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568304486,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67296,\"USDAFN\":78.592499,\"USDALL\":109.680232,\"USDAMD\":476.219812,\"USDANG\":1.76495,\"USDAOA\":365.678503,\"USDARS\":56.18704,\"USDAUD\":1.45565,\"USDAWG\":1.8,\"USDAZN\":1.705021,\"USDBAM\":1.774102,\"USDBBD\":2.01915,\"USDBDT\":84.495025,\"USDBGN\":1.765991,\"USDBHD\":0.3771,\"USDBIF\":1845.45,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.90995,\"USDBRL\":4.0632,\"USDBSD\":0.99955,\"USDBTC\":0.00009666913,\"USDBTN\":71.150502,\"USDBWP\":10.877993,\"USDBYN\":2.06655,\"USDBYR\":19600,\"USDBZD\":2.01565,\"USDCAD\":1.320845,\"USDCDF\":1665.000336,\"USDCHF\":0.989275,\"USDCLF\":0.025706,\"USDCLP\":709.40145,\"USDCNY\":7.079398,\"USDCOP\":3355.55,\"USDCRC\":576.520099,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.077501,\"USDCZK\":23.380402,\"USDDJF\":177.719883,\"USDDKK\":6.7457,\"USDDOP\":51.294955,\"USDDZD\":120.030259,\"USDEGP\":16.391881,\"USDERN\":14.999985,\"USDETB\":29.194002,\"USDEUR\":0.903855,\"USDFJD\":2.17525,\"USDFKP\":0.810875,\"USDGBP\":0.80959,\"USDGEL\":2.95501,\"USDGGP\":0.809564,\"USDGHS\":5.48958,\"USDGIP\":0.81091,\"USDGMD\":50.495045,\"USDGNF\":9193.409134,\"USDGTQ\":7.70245,\"USDGYD\":208.649901,\"USDHKD\":7.82568,\"USDHNL\":24.547498,\"USDHRK\":6.683962,\"USDHTG\":95.237996,\"USDHUF\":300.394963,\"USDIDR\":13928.7,\"USDILS\":3.537301,\"USDIMP\":0.809564,\"USDINR\":70.988983,\"USDIQD\":1193.2,\"USDIRR\":42104.999699,\"USDISK\":125.020221,\"USDJEP\":0.809564,\"USDJMD\":135.501776,\"USDJOD\":0.708971,\"USDJPY\":107.94502,\"USDKES\":103.805244,\"USDKGS\":69.850252,\"USDKHR\":4105.096565,\"USDKMF\":447.350061,\"USDKPW\":899.992005,\"USDKRW\":1181.890049,\"USDKWD\":0.304011,\"USDKYD\":0.833365,\"USDKZT\":387.140152,\"USDLAK\":8804.550417,\"USDLBP\":1512.150337,\"USDLKR\":180.360196,\"USDLRD\":208.674978,\"USDLSL\":14.709947,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.411301,\"USDMAD\":9.64875,\"USDMDL\":17.669502,\"USDMGA\":3743.450301,\"USDMKD\":55.958499,\"USDMMK\":1529.450298,\"USDMNT\":2669.189829,\"USDMOP\":8.0628,\"USDMRO\":357.000024,\"USDMUR\":36.311014,\"USDMVR\":15.401184,\"USDMWK\":734.985014,\"USDMXN\":19.4308,\"USDMYR\":4.165999,\"USDMZN\":61.714976,\"USDNAD\":14.710126,\"USDNGN\":362.499145,\"USDNIO\":33.544503,\"USDNOK\":8.96775,\"USDNPR\":113.844993,\"USDNZD\":1.55885,\"USDOMR\":0.38495,\"USDPAB\":1.00005,\"USDPEN\":3.33555,\"USDPGK\":3.40355,\"USDPHP\":51.804982,\"USDPKR\":156.44987,\"USDPLN\":3.91855,\"USDPYG\":6348.502622,\"USDQAR\":3.64097,\"USDRON\":4.282204,\"USDRSD\":106.439675,\"USDRUB\":64.838099,\"USDRWF\":921.89,\"USDSAR\":3.75165,\"USDSBD\":8.24175,\"USDSCR\":13.6795,\"USDSDG\":45.112035,\"USDSEK\":9.630805,\"USDSGD\":1.37427,\"USDSHP\":1.320899,\"USDSLL\":9450.000139,\"USDSOS\":580.999862,\"USDSRD\":7.458013,\"USDSTD\":21560.79,\"USDSVC\":8.7499,\"USDSYP\":514.999964,\"USDSZL\":14.632503,\"USDTHB\":30.402496,\"USDTJS\":9.687903,\"USDTMT\":3.51,\"USDTND\":2.860897,\"USDTOP\":2.31115,\"USDTRY\":5.66186,\"USDTTD\":6.78035,\"USDTWD\":30.874982,\"USDTZS\":2297.949895,\"USDUAH\":24.768988,\"USDUGX\":3665.000336,\"USDUSD\":1,\"USDUYU\":36.601286,\"USDUZS\":9399.949844,\"USDVEF\":9.987504,\"USDVND\":23208.5,\"USDVUV\":117.072353,\"USDWST\":2.66231,\"USDXAF\":595.030122,\"USDXAG\":0.055267,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.73004,\"USDXOF\":595.019759,\"USDXPF\":108.180158,\"USDYER\":250.350004,\"USDZAR\":14.601698,\"USDZMK\":9001.202218,\"USDZMW\":13.100118,\"USDZWL\":322.000001}}', 1, '2019-09-12 16:08:06', '2019-09-12 16:15:55', '2019-09-12 16:15:55', 'USD'),
(832, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568390885,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672991,\"USDAFN\":78.363502,\"USDALL\":109.660262,\"USDAMD\":476.179994,\"USDANG\":1.76445,\"USDAOA\":365.678503,\"USDARS\":56.170695,\"USDAUD\":1.45245,\"USDAWG\":1.801,\"USDAZN\":1.704978,\"USDBAM\":1.76285,\"USDBBD\":2.01855,\"USDBDT\":84.495961,\"USDBGN\":1.766895,\"USDBHD\":0.377096,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.350802,\"USDBOB\":6.90805,\"USDBRL\":4.059499,\"USDBSD\":0.99915,\"USDBTC\":0.000096864524,\"USDBTN\":70.837499,\"USDBWP\":10.85501,\"USDBYN\":2.047804,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.32712,\"USDCDF\":1665.999936,\"USDCHF\":0.99044,\"USDCLF\":0.025561,\"USDCLP\":705.305187,\"USDCNY\":7.079498,\"USDCOP\":3357.6,\"USDCRC\":576.319946,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.827496,\"USDCZK\":23.345964,\"USDDJF\":177.720111,\"USDDKK\":6.74609,\"USDDOP\":51.414977,\"USDDZD\":119.81501,\"USDEGP\":16.421505,\"USDERN\":15.000122,\"USDETB\":29.333501,\"USDEUR\":0.90347,\"USDFJD\":2.17505,\"USDFKP\":0.80309,\"USDGBP\":0.80243,\"USDGEL\":2.960166,\"USDGGP\":0.802565,\"USDGHS\":5.484972,\"USDGIP\":0.80311,\"USDGMD\":50.475031,\"USDGNF\":9229.999769,\"USDGTQ\":7.7004,\"USDGYD\":208.580082,\"USDHKD\":7.824205,\"USDHNL\":24.594988,\"USDHRK\":6.680701,\"USDHTG\":95.200499,\"USDHUF\":299.061983,\"USDIDR\":13967.6,\"USDILS\":3.52905,\"USDIMP\":0.802565,\"USDINR\":70.940495,\"USDIQD\":1190,\"USDIRR\":42104.999442,\"USDISK\":124.599899,\"USDJEP\":0.802565,\"USDJMD\":135.439557,\"USDJOD\":0.709057,\"USDJPY\":108.169798,\"USDKES\":103.700752,\"USDKGS\":69.850193,\"USDKHR\":4109.999635,\"USDKMF\":444.35007,\"USDKPW\":900.015803,\"USDKRW\":1177.597519,\"USDKWD\":0.303906,\"USDKYD\":0.833115,\"USDKZT\":386.669553,\"USDLAK\":8802.497801,\"USDLBP\":1501.749603,\"USDLKR\":180.309854,\"USDLRD\":207.99988,\"USDLSL\":14.710146,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.404968,\"USDMAD\":9.65355,\"USDMDL\":17.744503,\"USDMGA\":3724.999907,\"USDMKD\":55.481021,\"USDMMK\":1529.049685,\"USDMNT\":2668.974216,\"USDMOP\":8.06085,\"USDMRO\":357.000219,\"USDMUR\":36.219499,\"USDMVR\":15.39771,\"USDMWK\":733.970369,\"USDMXN\":19.3517,\"USDMYR\":4.1685,\"USDMZN\":61.740308,\"USDNAD\":14.709571,\"USDNGN\":361.499211,\"USDNIO\":33.535497,\"USDNOK\":8.97725,\"USDNPR\":113.33972,\"USDNZD\":1.566899,\"USDOMR\":0.384495,\"USDPAB\":0.99965,\"USDPEN\":3.316019,\"USDPGK\":3.40355,\"USDPHP\":51.987048,\"USDPKR\":156.649842,\"USDPLN\":3.90161,\"USDPYG\":6329.249729,\"USDQAR\":3.640992,\"USDRON\":4.277099,\"USDRSD\":106.454976,\"USDRUB\":64.238203,\"USDRWF\":922.5,\"USDSAR\":3.75115,\"USDSBD\":8.24175,\"USDSCR\":13.698004,\"USDSDG\":45.094,\"USDSEK\":9.60735,\"USDSGD\":1.373104,\"USDSHP\":1.320897,\"USDSLL\":9400.000023,\"USDSOS\":580.000344,\"USDSRD\":7.457998,\"USDSTD\":21560.79,\"USDSVC\":8.747598,\"USDSYP\":515.000078,\"USDSZL\":14.619986,\"USDTHB\":30.469906,\"USDTJS\":9.684902,\"USDTMT\":3.5,\"USDTND\":2.86205,\"USDTOP\":2.312503,\"USDTRY\":5.683775,\"USDTTD\":6.77875,\"USDTWD\":30.903503,\"USDTZS\":2299.500169,\"USDUAH\":24.769026,\"USDUGX\":3672.999987,\"USDUSD\":1,\"USDUYU\":36.550158,\"USDUZS\":9399.999668,\"USDVEF\":9.987498,\"USDVND\":23208.5,\"USDVUV\":117.609182,\"USDWST\":2.662393,\"USDXAF\":591.249976,\"USDXAG\":0.056701,\"USDXAU\":0.000671,\"USDXCD\":2.70255,\"USDXDR\":0.728464,\"USDXOF\":595.999729,\"USDXPF\":108.139997,\"USDYER\":250.288498,\"USDZAR\":14.528101,\"USDZMK\":9001.193234,\"USDZMW\":13.170969,\"USDZWL\":322.000001}}', 1, '2019-09-13 16:08:05', '2019-09-13 18:30:29', '2019-09-13 18:30:29', 'USD'),
(833, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568563686,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673042,\"USDAFN\":78.363504,\"USDALL\":109.660403,\"USDAMD\":476.180403,\"USDANG\":1.76445,\"USDAOA\":365.678504,\"USDARS\":55.666041,\"USDAUD\":1.454104,\"USDAWG\":1.801,\"USDAZN\":1.705041,\"USDBAM\":1.76285,\"USDBBD\":2.01855,\"USDBDT\":84.496041,\"USDBGN\":1.765604,\"USDBHD\":0.377045,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.35055,\"USDBOB\":6.90805,\"USDBRL\":4.085104,\"USDBSD\":0.99915,\"USDBTC\":0.000096329629,\"USDBTN\":70.837504,\"USDBWP\":10.855041,\"USDBYN\":2.047804,\"USDBYR\":19600,\"USDBZD\":2.01515,\"USDCAD\":1.32935,\"USDCDF\":1666.000362,\"USDCHF\":0.990396,\"USDCLF\":0.025641,\"USDCLP\":707.505041,\"USDCNY\":7.079504,\"USDCOP\":3357.6,\"USDCRC\":576.320395,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.827504,\"USDCZK\":23.343104,\"USDDJF\":177.720394,\"USDDKK\":6.742904,\"USDDOP\":51.41504,\"USDDZD\":119.960393,\"USDEGP\":16.304504,\"USDERN\":15.000358,\"USDETB\":29.333504,\"USDEUR\":0.89634,\"USDFJD\":2.17505,\"USDFKP\":0.803115,\"USDGBP\":0.799615,\"USDGEL\":2.960391,\"USDGGP\":0.801793,\"USDGHS\":5.48504,\"USDGIP\":0.803115,\"USDGMD\":50.47504,\"USDGNF\":9230.000355,\"USDGTQ\":7.700404,\"USDGYD\":208.580389,\"USDHKD\":7.82065,\"USDHNL\":24.59504,\"USDHRK\":6.678304,\"USDHTG\":95.200504,\"USDHUF\":299.190388,\"USDIDR\":13965,\"USDILS\":3.52905,\"USDIMP\":0.801793,\"USDINR\":71.030704,\"USDIQD\":1190,\"USDIRR\":42105.000352,\"USDISK\":124.403816,\"USDJEP\":0.801793,\"USDJMD\":135.440386,\"USDJOD\":0.70904,\"USDJPY\":108.08504,\"USDKES\":103.710385,\"USDKGS\":69.850385,\"USDKHR\":4110.000351,\"USDKMF\":444.350384,\"USDKPW\":900.033849,\"USDKRW\":1179.720384,\"USDKWD\":0.303904,\"USDKYD\":0.833115,\"USDKZT\":386.670383,\"USDLAK\":8802.503782,\"USDLBP\":1499.603779,\"USDLKR\":180.310382,\"USDLRD\":208.000348,\"USDLSL\":14.710382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.405039,\"USDMAD\":9.65355,\"USDMDL\":17.744504,\"USDMGA\":3725.000347,\"USDMKD\":55.481039,\"USDMMK\":1529.05038,\"USDMNT\":2661.5,\"USDMOP\":8.06085,\"USDMRO\":357.000346,\"USDMUR\":36.210379,\"USDMVR\":15.403741,\"USDMWK\":733.835039,\"USDMXN\":19.408039,\"USDMYR\":4.168504,\"USDMZN\":61.740377,\"USDNAD\":14.710377,\"USDNGN\":361.503727,\"USDNIO\":33.535504,\"USDNOK\":8.986304,\"USDNPR\":113.340376,\"USDNZD\":1.56815,\"USDOMR\":0.385039,\"USDPAB\":0.99965,\"USDPEN\":3.321039,\"USDPGK\":3.40355,\"USDPHP\":51.941039,\"USDPKR\":156.650375,\"USDPLN\":3.90505,\"USDPYG\":6329.250374,\"USDQAR\":3.641038,\"USDRON\":4.275604,\"USDRSD\":106.440373,\"USDRUB\":64.350373,\"USDRWF\":922.5,\"USDSAR\":3.72345,\"USDSBD\":8.24175,\"USDSCR\":13.743504,\"USDSDG\":45.094038,\"USDSEK\":9.609504,\"USDSGD\":1.373404,\"USDSHP\":1.320904,\"USDSLL\":9400.000339,\"USDSOS\":580.000338,\"USDSRD\":7.458038,\"USDSTD\":21560.79,\"USDSVC\":8.747604,\"USDSYP\":515.000338,\"USDSZL\":14.62037,\"USDTHB\":30.28037,\"USDTJS\":9.684904,\"USDTMT\":3.5,\"USDTND\":2.86205,\"USDTOP\":2.312504,\"USDTRY\":5.686304,\"USDTTD\":6.77875,\"USDTWD\":30.931038,\"USDTZS\":2299.000336,\"USDUAH\":24.769038,\"USDUGX\":3673.000335,\"USDUSD\":1,\"USDUYU\":36.550367,\"USDUZS\":9400.000335,\"USDVEF\":9.987504,\"USDVND\":23208.5,\"USDVUV\":115.190002,\"USDWST\":2.707093,\"USDXAF\":591.250365,\"USDXAG\":0.057303,\"USDXAU\":0.000672,\"USDXCD\":2.70255,\"USDXDR\":0.728242,\"USDXOF\":596.000332,\"USDXPF\":108.140364,\"USDYER\":250.303597,\"USDZAR\":14.577804,\"USDZMK\":9001.203593,\"USDZMW\":13.171037,\"USDZWL\":322.000001}}', 1, '2019-09-15 16:08:06', '2019-09-16 14:05:24', '2019-09-16 14:05:24', 'USD'),
(834, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568650086,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673101,\"USDAFN\":78.201088,\"USDALL\":110.150012,\"USDAMD\":476.159893,\"USDANG\":1.754404,\"USDAOA\":365.678503,\"USDARS\":56.291002,\"USDAUD\":1.45665,\"USDAWG\":1.8,\"USDAZN\":1.705044,\"USDBAM\":1.77125,\"USDBBD\":2.0184,\"USDBDT\":84.524983,\"USDBGN\":1.778302,\"USDBHD\":0.37698,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.91135,\"USDBRL\":4.083702,\"USDBSD\":0.99935,\"USDBTC\":0.000098856038,\"USDBTN\":71.525502,\"USDBWP\":10.852025,\"USDBYN\":2.04635,\"USDBYR\":19600,\"USDBZD\":2.01505,\"USDCAD\":1.32435,\"USDCDF\":1664.999786,\"USDCHF\":0.991801,\"USDCLF\":0.025684,\"USDCLP\":708.698543,\"USDCNY\":7.067303,\"USDCOP\":3370.1,\"USDCRC\":576.780082,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.778502,\"USDCZK\":23.494046,\"USDDJF\":177.719893,\"USDDKK\":6.783598,\"USDDOP\":51.229587,\"USDDZD\":120.195002,\"USDEGP\":16.339043,\"USDERN\":15.000045,\"USDETB\":29.507518,\"USDEUR\":0.908399,\"USDFJD\":2.17515,\"USDFKP\":0.80097,\"USDGBP\":0.80482,\"USDGEL\":2.949839,\"USDGGP\":0.804773,\"USDGHS\":5.484976,\"USDGIP\":0.80097,\"USDGMD\":50.444993,\"USDGNF\":9234.999848,\"USDGTQ\":7.699899,\"USDGYD\":208.845026,\"USDHKD\":7.81825,\"USDHNL\":24.698462,\"USDHRK\":6.719201,\"USDHTG\":95.467504,\"USDHUF\":301.67002,\"USDIDR\":14055.8,\"USDILS\":3.545299,\"USDIMP\":0.804773,\"USDINR\":71.574982,\"USDIQD\":1190,\"USDIRR\":42104.999642,\"USDISK\":123.719725,\"USDJEP\":0.804773,\"USDJMD\":136.020155,\"USDJOD\":0.709015,\"USDJPY\":107.975024,\"USDKES\":103.844993,\"USDKGS\":69.809897,\"USDKHR\":4105.000369,\"USDKMF\":446.950214,\"USDKPW\":899.991982,\"USDKRW\":1185.201607,\"USDKWD\":0.304103,\"USDKYD\":0.833055,\"USDKZT\":387.079717,\"USDLAK\":8792.905582,\"USDLBP\":1503.750022,\"USDLKR\":180.490163,\"USDLRD\":208.094926,\"USDLSL\":14.529969,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.410195,\"USDMAD\":9.675976,\"USDMDL\":17.693988,\"USDMGA\":3736.249839,\"USDMKD\":55.799503,\"USDMMK\":1519.950281,\"USDMNT\":2668.488417,\"USDMOP\":8.052397,\"USDMRO\":357.000346,\"USDMUR\":36.301501,\"USDMVR\":15.45027,\"USDMWK\":732.524984,\"USDMXN\":19.431702,\"USDMYR\":4.175597,\"USDMZN\":61.74496,\"USDNAD\":14.53003,\"USDNGN\":360.999996,\"USDNIO\":33.550062,\"USDNOK\":8.958399,\"USDNPR\":114.439937,\"USDNZD\":1.574402,\"USDOMR\":0.38505,\"USDPAB\":1.00025,\"USDPEN\":3.3252,\"USDPGK\":3.389502,\"USDPHP\":52.298501,\"USDPKR\":156.099154,\"USDPLN\":3.93215,\"USDPYG\":6334.299271,\"USDQAR\":3.640972,\"USDRON\":4.302704,\"USDRSD\":106.450137,\"USDRUB\":63.950369,\"USDRWF\":923,\"USDSAR\":3.75145,\"USDSBD\":8.275902,\"USDSCR\":13.712025,\"USDSDG\":45.0975,\"USDSEK\":9.66908,\"USDSGD\":1.375502,\"USDSHP\":1.320897,\"USDSLL\":9449.999653,\"USDSOS\":581.000126,\"USDSRD\":7.457995,\"USDSTD\":21560.79,\"USDSVC\":8.74715,\"USDSYP\":515.000325,\"USDSZL\":14.530202,\"USDTHB\":30.519946,\"USDTJS\":9.684597,\"USDTMT\":3.51,\"USDTND\":2.86405,\"USDTOP\":2.31385,\"USDTRY\":5.715345,\"USDTTD\":6.77845,\"USDTWD\":30.903972,\"USDTZS\":2298.049936,\"USDUAH\":24.769014,\"USDUGX\":3668.750119,\"USDUSD\":1,\"USDUYU\":36.450142,\"USDUZS\":9415.000344,\"USDVEF\":9.987503,\"USDVND\":23208.5,\"USDVUV\":117.072624,\"USDWST\":2.664522,\"USDXAF\":594.039868,\"USDXAG\":0.05577,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.730411,\"USDXOF\":598.497294,\"USDXPF\":108.670154,\"USDYER\":250.349747,\"USDZAR\":14.61525,\"USDZMK\":9001.20232,\"USDZMW\":13.170982,\"USDZWL\":322.000001}}', 1, '2019-09-16 16:08:06', '2019-09-16 16:54:50', '2019-09-16 16:54:50', 'USD'),
(835, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568736486,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673101,\"USDAFN\":78.349981,\"USDALL\":109.559735,\"USDAMD\":476.097616,\"USDANG\":1.755202,\"USDAOA\":365.6785,\"USDARS\":56.362001,\"USDAUD\":1.458285,\"USDAWG\":1.801,\"USDAZN\":1.705022,\"USDBAM\":1.77425,\"USDBBD\":2.01935,\"USDBDT\":84.580996,\"USDBGN\":1.7684,\"USDBHD\":0.37709,\"USDBIF\":1861,\"USDBMD\":1,\"USDBND\":1.350603,\"USDBOB\":6.91655,\"USDBRL\":4.091699,\"USDBSD\":0.99975,\"USDBTC\":0.000097835918,\"USDBTN\":71.860964,\"USDBWP\":10.859841,\"USDBYN\":2.05495,\"USDBYR\":19600,\"USDBZD\":2.01595,\"USDCAD\":1.32465,\"USDCDF\":1665.999984,\"USDCHF\":0.993106,\"USDCLF\":0.02592,\"USDCLP\":715.200193,\"USDCNY\":7.091897,\"USDCOP\":3379.8,\"USDCRC\":577.830313,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.864502,\"USDCZK\":23.418037,\"USDDJF\":177.720113,\"USDDKK\":6.752901,\"USDDOP\":51.314967,\"USDDZD\":120.039872,\"USDEGP\":16.333008,\"USDERN\":14.999932,\"USDETB\":29.474969,\"USDEUR\":0.904335,\"USDFJD\":2.17885,\"USDFKP\":0.805385,\"USDGBP\":0.80052,\"USDGEL\":2.95501,\"USDGGP\":0.800411,\"USDGHS\":5.509694,\"USDGIP\":0.805395,\"USDGMD\":50.405032,\"USDGNF\":9229.999993,\"USDGTQ\":7.70345,\"USDGYD\":208.660307,\"USDHKD\":7.82155,\"USDHNL\":24.69768,\"USDHRK\":6.690604,\"USDHTG\":95.652995,\"USDHUF\":301.637979,\"USDIDR\":14072.3,\"USDILS\":3.548195,\"USDIMP\":0.800411,\"USDINR\":71.513501,\"USDIQD\":1190,\"USDIRR\":42105.000565,\"USDISK\":123.529831,\"USDJEP\":0.800411,\"USDJMD\":136.28984,\"USDJOD\":0.707602,\"USDJPY\":108.167031,\"USDKES\":103.760053,\"USDKGS\":69.794201,\"USDKHR\":4110.999633,\"USDKMF\":446.492896,\"USDKPW\":899.984069,\"USDKRW\":1187.670162,\"USDKWD\":0.3041,\"USDKYD\":0.833515,\"USDKZT\":387.329926,\"USDLAK\":8812.502635,\"USDLBP\":1507.549918,\"USDLKR\":180.650541,\"USDLRD\":208.375021,\"USDLSL\":14.739802,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.414989,\"USDMAD\":9.664801,\"USDMDL\":17.692503,\"USDMGA\":3740.000203,\"USDMKD\":55.7035,\"USDMMK\":1533.649878,\"USDMNT\":2668.466639,\"USDMOP\":8.059005,\"USDMRO\":357.000346,\"USDMUR\":36.3015,\"USDMVR\":15.398309,\"USDMWK\":730.044984,\"USDMXN\":19.41491,\"USDMYR\":4.1875,\"USDMZN\":61.744991,\"USDNAD\":14.739686,\"USDNGN\":359.999643,\"USDNIO\":33.525029,\"USDNOK\":8.932097,\"USDNPR\":114.975001,\"USDNZD\":1.57555,\"USDOMR\":0.38505,\"USDPAB\":1.00085,\"USDPEN\":3.344993,\"USDPGK\":3.40355,\"USDPHP\":52.149712,\"USDPKR\":155.740044,\"USDPLN\":3.92281,\"USDPYG\":6340.44942,\"USDQAR\":3.640996,\"USDRON\":4.282402,\"USDRSD\":106.309615,\"USDRUB\":64.302504,\"USDRWF\":925,\"USDSAR\":3.75115,\"USDSBD\":8.31035,\"USDSCR\":13.701028,\"USDSDG\":45.118496,\"USDSEK\":9.674205,\"USDSGD\":1.37444,\"USDSHP\":1.320904,\"USDSLL\":9400.000181,\"USDSOS\":580.000158,\"USDSRD\":7.458011,\"USDSTD\":21560.79,\"USDSVC\":8.75155,\"USDSYP\":515.000024,\"USDSZL\":14.739667,\"USDTHB\":30.515977,\"USDTJS\":9.691405,\"USDTMT\":3.5,\"USDTND\":2.863098,\"USDTOP\":2.31385,\"USDTRY\":5.70945,\"USDTTD\":6.78165,\"USDTWD\":30.943503,\"USDTZS\":2298.100038,\"USDUAH\":24.786017,\"USDUGX\":3668.450185,\"USDUSD\":1,\"USDUYU\":36.469821,\"USDUZS\":9412.49594,\"USDVEF\":9.987503,\"USDVND\":23208.5,\"USDVUV\":117.242921,\"USDWST\":2.670214,\"USDXAF\":595.070165,\"USDXAG\":0.055603,\"USDXAU\":0.000665,\"USDXCD\":2.70255,\"USDXDR\":0.729329,\"USDXOF\":599.000014,\"USDXPF\":108.499256,\"USDYER\":250.300059,\"USDZAR\":14.751203,\"USDZMK\":9001.199815,\"USDZMW\":13.197002,\"USDZWL\":322.000001}}', 1, '2019-09-17 16:08:06', '2019-09-18 15:31:38', '2019-09-18 15:31:38', 'USD'),
(836, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568909287,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673098,\"USDAFN\":78.25044,\"USDALL\":109.760415,\"USDAMD\":476.259895,\"USDANG\":1.765398,\"USDAOA\":367.423499,\"USDARS\":56.640233,\"USDAUD\":1.47179,\"USDAWG\":1.8,\"USDAZN\":1.705011,\"USDBAM\":1.76785,\"USDBBD\":2.0195,\"USDBDT\":84.508986,\"USDBGN\":1.771297,\"USDBHD\":0.376991,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.91155,\"USDBRL\":4.138901,\"USDBSD\":0.99975,\"USDBTC\":0.000101,\"USDBTN\":71.110974,\"USDBWP\":10.859793,\"USDBYN\":2.04885,\"USDBYR\":19600,\"USDBZD\":2.0161,\"USDCAD\":1.32596,\"USDCDF\":1664.999825,\"USDCHF\":0.99305,\"USDCLF\":0.025967,\"USDCLP\":716.498421,\"USDCNY\":7.096402,\"USDCOP\":3378.6,\"USDCRC\":578.595016,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.7925,\"USDCZK\":23.451199,\"USDDJF\":177.72042,\"USDDKK\":6.76216,\"USDDOP\":51.410179,\"USDDZD\":119.919849,\"USDEGP\":16.309754,\"USDERN\":15.000434,\"USDETB\":29.549598,\"USDEUR\":0.905428,\"USDFJD\":2.18585,\"USDFKP\":0.80221,\"USDGBP\":0.80162,\"USDGEL\":2.969956,\"USDGGP\":0.80133,\"USDGHS\":5.50501,\"USDGIP\":0.802205,\"USDGMD\":50.404971,\"USDGNF\":9230.000383,\"USDGTQ\":7.709098,\"USDGYD\":208.749895,\"USDHKD\":7.83205,\"USDHNL\":24.649649,\"USDHRK\":6.702502,\"USDHTG\":95.533019,\"USDHUF\":301.355966,\"USDIDR\":14109.55,\"USDILS\":3.51215,\"USDIMP\":0.80133,\"USDINR\":71.340093,\"USDIQD\":1190,\"USDIRR\":42105.00022,\"USDISK\":124.070175,\"USDJEP\":0.80133,\"USDJMD\":136.170227,\"USDJOD\":0.708997,\"USDJPY\":108.021971,\"USDKES\":103.849409,\"USDKGS\":69.8488,\"USDKHR\":4111.000301,\"USDKMF\":446.506428,\"USDKPW\":900.003453,\"USDKRW\":1193.680038,\"USDKWD\":0.303797,\"USDKYD\":0.833475,\"USDKZT\":387.000017,\"USDLAK\":8812.502388,\"USDLBP\":1507.55027,\"USDLKR\":180.960309,\"USDLRD\":208.374943,\"USDLSL\":14.740214,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.414999,\"USDMAD\":9.672098,\"USDMDL\":17.609023,\"USDMGA\":3740.000539,\"USDMKD\":55.620975,\"USDMMK\":1534.795659,\"USDMNT\":2667.97408,\"USDMOP\":8.066601,\"USDMRO\":357.000346,\"USDMUR\":36.266501,\"USDMVR\":15.401949,\"USDMWK\":724.050433,\"USDMXN\":19.41375,\"USDMYR\":4.189798,\"USDMZN\":61.754989,\"USDNAD\":14.739796,\"USDNGN\":360.000141,\"USDNIO\":33.524983,\"USDNOK\":8.98103,\"USDNPR\":113.780177,\"USDNZD\":1.587298,\"USDOMR\":0.38501,\"USDPAB\":1.00005,\"USDPEN\":3.35455,\"USDPGK\":3.40355,\"USDPHP\":52.289871,\"USDPKR\":156.69143,\"USDPLN\":3.93203,\"USDPYG\":6366.693717,\"USDQAR\":3.64175,\"USDRON\":4.297501,\"USDRSD\":106.380313,\"USDRUB\":63.9035,\"USDRWF\":925,\"USDSAR\":3.75105,\"USDSBD\":8.22815,\"USDSCR\":13.684499,\"USDSDG\":45.121029,\"USDSEK\":9.70509,\"USDSGD\":1.37915,\"USDSHP\":1.320899,\"USDSLL\":9399.999994,\"USDSOS\":579.999911,\"USDSRD\":7.457986,\"USDSTD\":21560.79,\"USDSVC\":8.75155,\"USDSYP\":514.999946,\"USDSZL\":14.740079,\"USDTHB\":30.5395,\"USDTJS\":9.692398,\"USDTMT\":3.5,\"USDTND\":2.86435,\"USDTOP\":2.31595,\"USDTRY\":5.708525,\"USDTTD\":6.77345,\"USDTWD\":30.985498,\"USDTZS\":2298.198106,\"USDUAH\":24.657003,\"USDUGX\":3675.749576,\"USDUSD\":1,\"USDUYU\":36.759817,\"USDUZS\":9401.891475,\"USDVEF\":9.987503,\"USDVND\":23208.5,\"USDVUV\":117.503618,\"USDWST\":2.678083,\"USDXAF\":592.920323,\"USDXAG\":0.056161,\"USDXAU\":0.000667,\"USDXCD\":2.70255,\"USDXDR\":0.729584,\"USDXOF\":594.9998,\"USDXPF\":108.501579,\"USDYER\":250.349941,\"USDZAR\":14.731796,\"USDZMK\":9001.153992,\"USDZMW\":13.214959,\"USDZWL\":322.000001}}', 1, '2019-09-19 16:08:07', '2019-09-20 13:04:59', '2019-09-20 13:04:59', 'USD'),
(837, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1568995688,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673005,\"USDAFN\":78.249802,\"USDALL\":110.280064,\"USDAMD\":476.129995,\"USDANG\":1.76535,\"USDAOA\":367.423497,\"USDARS\":56.594298,\"USDAUD\":1.47755,\"USDAWG\":1.8,\"USDAZN\":1.704999,\"USDBAM\":1.7714,\"USDBBD\":2.02,\"USDBDT\":84.520013,\"USDBGN\":1.778802,\"USDBHD\":0.377013,\"USDBIF\":1860,\"USDBMD\":1,\"USDBND\":1.35065,\"USDBOB\":6.91365,\"USDBRL\":4.168207,\"USDBSD\":0.99995,\"USDBTC\":0.000098397682,\"USDBTN\":70.864003,\"USDBWP\":10.869003,\"USDBYN\":2.040303,\"USDBYR\":19600,\"USDBZD\":2.016103,\"USDCAD\":1.327215,\"USDCDF\":1664.999871,\"USDCHF\":0.99292,\"USDCLF\":0.026011,\"USDCLP\":717.698567,\"USDCNY\":7.091603,\"USDCOP\":3405.75,\"USDCRC\":579.579916,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.852501,\"USDCZK\":23.510004,\"USDDJF\":177.719724,\"USDDKK\":6.785902,\"USDDOP\":51.469939,\"USDDZD\":120.080557,\"USDEGP\":16.306498,\"USDERN\":15.000118,\"USDETB\":29.549817,\"USDEUR\":0.908802,\"USDFJD\":2.188149,\"USDFKP\":0.79791,\"USDGBP\":0.800703,\"USDGEL\":2.96496,\"USDGGP\":0.800609,\"USDGHS\":5.505045,\"USDGIP\":0.79791,\"USDGMD\":50.395007,\"USDGNF\":9230.000105,\"USDGTQ\":7.70905,\"USDGYD\":208.615029,\"USDHKD\":7.83912,\"USDHNL\":24.649819,\"USDHRK\":6.726698,\"USDHTG\":95.653501,\"USDHUF\":303.315016,\"USDIDR\":14075.3,\"USDILS\":3.52195,\"USDIMP\":0.800609,\"USDINR\":71.069397,\"USDIQD\":1190,\"USDIRR\":42104.99978,\"USDISK\":124.680128,\"USDJEP\":0.800609,\"USDJMD\":136.129795,\"USDJOD\":0.708981,\"USDJPY\":107.953021,\"USDKES\":103.702416,\"USDKGS\":69.831704,\"USDKHR\":4110.000176,\"USDKMF\":447.374977,\"USDKPW\":900.038371,\"USDKRW\":1190.210319,\"USDKWD\":0.303798,\"USDKYD\":0.833535,\"USDKZT\":387.660014,\"USDLAK\":8815.000275,\"USDLBP\":1507.550289,\"USDLKR\":181.189761,\"USDLRD\":208.625018,\"USDLSL\":14.729862,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.405007,\"USDMAD\":9.683203,\"USDMDL\":17.653498,\"USDMGA\":3744.85006,\"USDMKD\":55.8055,\"USDMMK\":1532.849769,\"USDMNT\":2666.810531,\"USDMOP\":8.06985,\"USDMRO\":357.000346,\"USDMUR\":36.268501,\"USDMVR\":15.402547,\"USDMWK\":720.049744,\"USDMXN\":19.45305,\"USDMYR\":4.175501,\"USDMZN\":61.78504,\"USDNAD\":14.729819,\"USDNGN\":360.49797,\"USDNIO\":33.551017,\"USDNOK\":9.04769,\"USDNPR\":113.379525,\"USDNZD\":1.598389,\"USDOMR\":0.385008,\"USDPAB\":1.00025,\"USDPEN\":3.35935,\"USDPGK\":3.40355,\"USDPHP\":52.015985,\"USDPKR\":156.829691,\"USDPLN\":3.97625,\"USDPYG\":6381.249804,\"USDQAR\":3.640979,\"USDRON\":4.318495,\"USDRSD\":106.71502,\"USDRUB\":63.921102,\"USDRWF\":922.5,\"USDSAR\":3.75725,\"USDSBD\":8.22815,\"USDSCR\":13.697232,\"USDSDG\":45.1145,\"USDSEK\":9.72992,\"USDSGD\":1.37654,\"USDSHP\":1.3209,\"USDSLL\":9399.999718,\"USDSOS\":579.999708,\"USDSRD\":7.458008,\"USDSTD\":21560.79,\"USDSVC\":8.75195,\"USDSYP\":515.000316,\"USDSZL\":14.730372,\"USDTHB\":30.492024,\"USDTJS\":9.69205,\"USDTMT\":3.51,\"USDTND\":2.865598,\"USDTOP\":2.323802,\"USDTRY\":5.744775,\"USDTTD\":6.77345,\"USDTWD\":30.963991,\"USDTZS\":2298.189175,\"USDUAH\":24.416957,\"USDUGX\":3674.149745,\"USDUSD\":1,\"USDUYU\":36.749779,\"USDUZS\":9401.897235,\"USDVEF\":9.9875,\"USDVND\":23208.5,\"USDVUV\":117.803466,\"USDWST\":2.687607,\"USDXAF\":594.120288,\"USDXAG\":0.05624,\"USDXAU\":0.000666,\"USDXCD\":2.70255,\"USDXDR\":0.730099,\"USDXOF\":595.000132,\"USDXPF\":108.400322,\"USDYER\":250.306089,\"USDZAR\":14.95809,\"USDZMK\":9001.198647,\"USDZMW\":13.212974,\"USDZWL\":322.000001}}', 1, '2019-09-20 16:08:08', '2019-09-20 17:05:03', '2019-09-20 17:05:03', 'USD'),
(838, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1573747747,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.67285,\"USDAFN\":78.31506,\"USDALL\":111.668096,\"USDAMD\":477.510166,\"USDANG\":1.724878,\"USDAOA\":462.511004,\"USDARS\":59.633496,\"USDAUD\":1.476335,\"USDAWG\":1.79,\"USDAZN\":1.697874,\"USDBAM\":1.779402,\"USDBBD\":2.018924,\"USDBDT\":84.73693,\"USDBGN\":1.77801,\"USDBHD\":0.377034,\"USDBIF\":1876.2953,\"USDBMD\":1,\"USDBND\":1.362871,\"USDBOB\":6.914343,\"USDBRL\":4.185505,\"USDBSD\":0.999864,\"USDBTC\":0.000116,\"USDBTN\":71.91766,\"USDBWP\":10.916162,\"USDBYN\":2.051585,\"USDBYR\":19600,\"USDBZD\":2.015467,\"USDCAD\":1.325185,\"USDCDF\":1663.753446,\"USDCHF\":0.987797,\"USDCLF\":0.029131,\"USDCLP\":803.801522,\"USDCNY\":7.020702,\"USDCOP\":3427.9216,\"USDCRC\":582.14074,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":100.31843,\"USDCZK\":23.255397,\"USDDJF\":177.720351,\"USDDKK\":6.79032,\"USDDOP\":52.815357,\"USDDZD\":120.214995,\"USDEGP\":16.129903,\"USDERN\":15.000082,\"USDETB\":29.493153,\"USDEUR\":0.90876,\"USDFJD\":2.18585,\"USDFKP\":0.81288,\"USDGBP\":0.777565,\"USDGEL\":2.954966,\"USDGGP\":0.777689,\"USDGHS\":5.524451,\"USDGIP\":0.81288,\"USDGMD\":51.24988,\"USDGNF\":9509.620991,\"USDGTQ\":7.704226,\"USDGYD\":208.75222,\"USDHKD\":7.82959,\"USDHNL\":24.618114,\"USDHRK\":6.758423,\"USDHTG\":97.36159,\"USDHUF\":303.563017,\"USDIDR\":14118.5,\"USDILS\":3.48305,\"USDIMP\":0.777689,\"USDINR\":71.972497,\"USDIQD\":1193.6951,\"USDIRR\":42105.000187,\"USDISK\":123.497143,\"USDJEP\":0.777689,\"USDJMD\":141.10631,\"USDJOD\":0.709015,\"USDJPY\":108.574026,\"USDKES\":102.05102,\"USDKGS\":69.84966,\"USDKHR\":4054.587601,\"USDKMF\":447.70032,\"USDKPW\":900.059014,\"USDKRW\":1171.289943,\"USDKWD\":0.30379,\"USDKYD\":0.83328,\"USDKZT\":388.491098,\"USDLAK\":8855.38799,\"USDLBP\":1512.0775,\"USDLKR\":180.38275,\"USDLRD\":198.498701,\"USDLSL\":14.919653,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.407451,\"USDMAD\":9.692308,\"USDMDL\":17.61079,\"USDMGA\":3754.646799,\"USDMKD\":55.909962,\"USDMMK\":1515.855099,\"USDMNT\":2706.410689,\"USDMOP\":8.063139,\"USDMRO\":356.999516,\"USDMUR\":36.649309,\"USDMVR\":15.44985,\"USDMWK\":735.055201,\"USDMXN\":19.407599,\"USDMYR\":4.157499,\"USDMZN\":62.289619,\"USDNAD\":14.919823,\"USDNGN\":361.503157,\"USDNIO\":33.73152,\"USDNOK\":9.185675,\"USDNPR\":115.06801,\"USDNZD\":1.56939,\"USDOMR\":0.384977,\"USDPAB\":0.999955,\"USDPEN\":3.388164,\"USDPGK\":3.403903,\"USDPHP\":50.742964,\"USDPKR\":156.18505,\"USDPLN\":3.89389,\"USDPYG\":6454.624028,\"USDQAR\":3.641023,\"USDRON\":4.332403,\"USDRSD\":106.760599,\"USDRUB\":64.066201,\"USDRWF\":932.193,\"USDSAR\":3.750296,\"USDSBD\":8.090568,\"USDSCR\":13.680107,\"USDSDG\":45.108221,\"USDSEK\":9.71747,\"USDSGD\":1.36306,\"USDSHP\":1.320902,\"USDSLL\":9625.000355,\"USDSOS\":582.999561,\"USDSRD\":7.457993,\"USDSTD\":21560.79,\"USDSVC\":8.749488,\"USDSYP\":515.000129,\"USDSZL\":14.832552,\"USDTHB\":30.219749,\"USDTJS\":9.689032,\"USDTMT\":3.51,\"USDTND\":2.8545,\"USDTOP\":2.316497,\"USDTRY\":5.754335,\"USDTTD\":6.775872,\"USDTWD\":30.554501,\"USDTZS\":2303.780202,\"USDUAH\":24.235091,\"USDUGX\":3694.673099,\"USDUSD\":1,\"USDUYU\":37.57176,\"USDUZS\":9499.095011,\"USDVEF\":9.9875,\"USDVND\":23208.5,\"USDVUV\":117.213362,\"USDWST\":2.664282,\"USDXAF\":596.785697,\"USDXAG\":0.058801,\"USDXAU\":0.00068,\"USDXCD\":2.70255,\"USDXDR\":0.7285,\"USDXOF\":596.785699,\"USDXPF\":108.50202,\"USDYER\":250.350256,\"USDZAR\":14.79804,\"USDZMK\":9001.200601,\"USDZMW\":14.003639,\"USDZWL\":322.000001}}', 1, '2019-11-14 16:09:07', '2019-11-14 17:29:18', '2019-11-14 17:29:18', 'USD'),
(839, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1574266146,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672799,\"USDAFN\":78.250046,\"USDALL\":110.798187,\"USDAMD\":476.98002,\"USDANG\":1.714862,\"USDAOA\":465.2575,\"USDARS\":59.714197,\"USDAUD\":1.469497,\"USDAWG\":1.8,\"USDAZN\":1.700803,\"USDBAM\":1.768789,\"USDBBD\":2.01891,\"USDBDT\":84.78844,\"USDBGN\":1.76811,\"USDBHD\":0.376994,\"USDBIF\":1870,\"USDBMD\":1,\"USDBND\":1.361616,\"USDBOB\":6.914433,\"USDBRL\":4.196299,\"USDBSD\":0.999959,\"USDBTC\":0.000123,\"USDBTN\":71.80399,\"USDBWP\":10.892385,\"USDBYN\":2.049388,\"USDBYR\":19600,\"USDBZD\":2.015564,\"USDCAD\":1.330325,\"USDCDF\":1665.999758,\"USDCHF\":0.99269,\"USDCLF\":0.028819,\"USDCLP\":795.000357,\"USDCNY\":7.0358,\"USDCOP\":3444.5,\"USDCRC\":577.42969,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.949827,\"USDCZK\":23.07135,\"USDDJF\":177.720424,\"USDDKK\":6.753101,\"USDDOP\":52.796079,\"USDDZD\":119.91185,\"USDEGP\":16.099297,\"USDERN\":15.000299,\"USDETB\":29.819621,\"USDEUR\":0.903698,\"USDFJD\":2.189504,\"USDFKP\":0.81288,\"USDGBP\":0.774515,\"USDGEL\":2.975042,\"USDGGP\":0.774503,\"USDGHS\":5.550296,\"USDGIP\":0.81288,\"USDGMD\":51.295892,\"USDGNF\":9399.999715,\"USDGTQ\":7.714436,\"USDGYD\":208.737089,\"USDHKD\":7.82698,\"USDHNL\":24.725019,\"USDHRK\":6.720946,\"USDHTG\":97.24484,\"USDHUF\":300.960415,\"USDIDR\":14091.8,\"USDILS\":3.47215,\"USDIMP\":0.774503,\"USDINR\":71.753501,\"USDIQD\":1190,\"USDIRR\":42105.000589,\"USDISK\":122.751286,\"USDJEP\":0.774503,\"USDJMD\":140.55936,\"USDJOD\":0.70903,\"USDJPY\":108.671034,\"USDKES\":101.40176,\"USDKGS\":69.850178,\"USDKHR\":4064.99992,\"USDKMF\":445.624973,\"USDKPW\":900.047786,\"USDKRW\":1169.59005,\"USDKWD\":0.30369,\"USDKYD\":0.833284,\"USDKZT\":387.24468,\"USDLAK\":8859.999725,\"USDLBP\":1512.000139,\"USDLKR\":179.28618,\"USDLRD\":196.000325,\"USDLSL\":14.720282,\"USDLTL\":2.952741,\"USDLVL\":0.60489,\"USDLYD\":1.409775,\"USDMAD\":9.652499,\"USDMDL\":17.398677,\"USDMGA\":3699.999711,\"USDMKD\":55.559067,\"USDMMK\":1516.383401,\"USDMNT\":2707.08208,\"USDMOP\":8.060267,\"USDMRO\":356.999516,\"USDMUR\":36.552322,\"USDMVR\":15.349808,\"USDMWK\":733.473613,\"USDMXN\":19.449401,\"USDMYR\":4.15299,\"USDMZN\":63.71504,\"USDNAD\":14.720096,\"USDNGN\":361.501504,\"USDNIO\":33.874971,\"USDNOK\":9.134345,\"USDNPR\":114.88634,\"USDNZD\":1.55708,\"USDOMR\":0.384978,\"USDPAB\":0.999959,\"USDPEN\":3.37197,\"USDPGK\":3.383366,\"USDPHP\":50.874985,\"USDPKR\":155.495018,\"USDPLN\":3.88176,\"USDPYG\":6467.585198,\"USDQAR\":3.640998,\"USDRON\":4.320697,\"USDRSD\":106.210182,\"USDRUB\":63.867401,\"USDRWF\":931.5,\"USDSAR\":3.750293,\"USDSBD\":8.302328,\"USDSCR\":13.700598,\"USDSDG\":45.109044,\"USDSEK\":9.63395,\"USDSGD\":1.36128,\"USDSHP\":1.320899,\"USDSLL\":9675.000029,\"USDSOS\":580.999938,\"USDSRD\":7.458001,\"USDSTD\":21560.79,\"USDSVC\":8.749757,\"USDSYP\":514.999745,\"USDSZL\":14.77021,\"USDTHB\":30.205405,\"USDTJS\":9.695545,\"USDTMT\":3.51,\"USDTND\":2.844993,\"USDTOP\":2.31595,\"USDTRY\":5.694505,\"USDTTD\":6.771023,\"USDTWD\":30.504501,\"USDTZS\":2301.800032,\"USDUAH\":24.158373,\"USDUGX\":3687.7399,\"USDUSD\":1,\"USDUYU\":37.66239,\"USDUZS\":9500.000317,\"USDVEF\":9.987496,\"USDVND\":23208.5,\"USDVUV\":116.61992,\"USDWST\":2.649352,\"USDXAF\":593.22629,\"USDXAG\":0.058557,\"USDXAU\":0.000681,\"USDXCD\":2.70255,\"USDXDR\":0.726909,\"USDXOF\":588.999551,\"USDXPF\":108.402943,\"USDYER\":250.34983,\"USDZAR\":14.758105,\"USDZMK\":9001.197591,\"USDZMW\":14.053963,\"USDZWL\":322.000001}}', 1, '2019-11-20 16:09:06', '2019-11-21 11:19:21', '2019-11-21 11:19:21', 'USD'),
(840, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1576598946,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672976,\"USDAFN\":78.705012,\"USDALL\":109.550117,\"USDAMD\":477.44031,\"USDANG\":1.694933,\"USDAOA\":459.052017,\"USDARS\":59.729498,\"USDAUD\":1.459498,\"USDAWG\":1.8,\"USDAZN\":1.697429,\"USDBAM\":1.752591,\"USDBBD\":2.018994,\"USDBDT\":84.89002,\"USDBGN\":1.753749,\"USDBHD\":0.377018,\"USDBIF\":1876,\"USDBMD\":1,\"USDBND\":1.354925,\"USDBOB\":6.914572,\"USDBRL\":4.063897,\"USDBSD\":0.999955,\"USDBTC\":0.000149,\"USDBTN\":70.955602,\"USDBWP\":10.717645,\"USDBYN\":2.103226,\"USDBYR\":19600,\"USDBZD\":2.015589,\"USDCAD\":1.31525,\"USDCDF\":1681.00006,\"USDCHF\":0.979905,\"USDCLF\":0.027405,\"USDCLP\":756.201391,\"USDCNY\":6.997095,\"USDCOP\":3349.58,\"USDCRC\":566.536749,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.750141,\"USDCZK\":22.808027,\"USDDJF\":177.719935,\"USDDKK\":6.699805,\"USDDOP\":53.150283,\"USDDZD\":119.434977,\"USDEGP\":16.028905,\"USDERN\":15.000093,\"USDETB\":31.649776,\"USDEUR\":0.89651,\"USDFJD\":2.159786,\"USDFKP\":0.81288,\"USDGBP\":0.76114,\"USDGEL\":2.899944,\"USDGGP\":0.76118,\"USDGHS\":5.749683,\"USDGIP\":0.81288,\"USDGMD\":51.424983,\"USDGNF\":9400.000338,\"USDGTQ\":7.694575,\"USDGYD\":208.58308,\"USDHKD\":7.78778,\"USDHNL\":24.749656,\"USDHRK\":6.674903,\"USDHTG\":96.24781,\"USDHUF\":295.889664,\"USDIDR\":13998.5,\"USDILS\":3.48678,\"USDIMP\":0.76118,\"USDINR\":71.058975,\"USDIQD\":1190,\"USDIRR\":42104.999916,\"USDISK\":122.840245,\"USDJEP\":0.76118,\"USDJMD\":140.55936,\"USDJOD\":0.708958,\"USDJPY\":109.482993,\"USDKES\":101.509679,\"USDKGS\":69.839205,\"USDKHR\":4064.999809,\"USDKMF\":441.37498,\"USDKPW\":900.012092,\"USDKRW\":1163.064962,\"USDKWD\":0.303501,\"USDKYD\":0.833221,\"USDKZT\":384.75806,\"USDLAK\":8878.000271,\"USDLBP\":1511.999698,\"USDLKR\":181.16445,\"USDLRD\":187.499619,\"USDLSL\":14.400135,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.398886,\"USDMAD\":9.602501,\"USDMDL\":17.231272,\"USDMGA\":3649.999751,\"USDMKD\":55.104782,\"USDMMK\":1504.912498,\"USDMNT\":2737.167254,\"USDMOP\":8.022488,\"USDMRO\":356.999834,\"USDMUR\":36.554414,\"USDMVR\":15.459964,\"USDMWK\":722.504301,\"USDMXN\":18.9112,\"USDMYR\":4.143023,\"USDMZN\":63.379542,\"USDNAD\":14.403019,\"USDNGN\":362.497843,\"USDNIO\":33.875045,\"USDNOK\":9.020796,\"USDNPR\":113.52864,\"USDNZD\":1.52101,\"USDOMR\":0.385038,\"USDPAB\":0.999866,\"USDPEN\":3.345503,\"USDPGK\":3.402501,\"USDPHP\":50.585498,\"USDPKR\":154.249973,\"USDPLN\":3.81645,\"USDPYG\":6454.419201,\"USDQAR\":3.64075,\"USDRON\":4.285303,\"USDRSD\":105.330019,\"USDRUB\":62.430802,\"USDRWF\":920,\"USDSAR\":3.750717,\"USDSBD\":8.269546,\"USDSCR\":13.700399,\"USDSDG\":45.11595,\"USDSEK\":9.376703,\"USDSGD\":1.354798,\"USDSHP\":1.320902,\"USDSLL\":9725.000026,\"USDSOS\":581.000178,\"USDSRD\":7.45802,\"USDSTD\":21560.79,\"USDSVC\":8.748824,\"USDSYP\":514.999804,\"USDSZL\":14.400838,\"USDTHB\":30.236957,\"USDTJS\":9.68172,\"USDTMT\":3.51,\"USDTND\":2.8475,\"USDTOP\":2.29785,\"USDTRY\":5.88358,\"USDTTD\":6.756349,\"USDTWD\":30.152993,\"USDTZS\":2297.89205,\"USDUAH\":23.466039,\"USDUGX\":3670.300204,\"USDUSD\":1,\"USDUYU\":37.782556,\"USDUZS\":9520.000514,\"USDVEF\":9.987502,\"USDVND\":23172.5,\"USDVUV\":116.305396,\"USDWST\":2.657763,\"USDXAF\":587.696098,\"USDXAG\":0.058718,\"USDXAU\":0.000677,\"USDXCD\":2.70255,\"USDXDR\":0.724149,\"USDXOF\":587.506766,\"USDXPF\":107.374982,\"USDYER\":250.349896,\"USDZAR\":14.393897,\"USDZMK\":9001.201154,\"USDZMW\":14.546342,\"USDZWL\":322.000001}}', 1, '2019-12-17 16:09:06', '2019-12-17 19:40:32', '2019-12-17 19:40:32', 'USD'),
(841, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1576685347,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672992,\"USDAFN\":78.650142,\"USDALL\":109.650636,\"USDAMD\":477.540029,\"USDANG\":1.695103,\"USDAOA\":458.052028,\"USDARS\":59.816305,\"USDAUD\":1.457715,\"USDAWG\":1.8,\"USDAZN\":1.697857,\"USDBAM\":1.757662,\"USDBBD\":2.019169,\"USDBDT\":84.89843,\"USDBGN\":1.759065,\"USDBHD\":0.37698,\"USDBIF\":1875,\"USDBMD\":1,\"USDBND\":1.355926,\"USDBOB\":6.915303,\"USDBRL\":4.058598,\"USDBSD\":1.000058,\"USDBTC\":0.000147,\"USDBTN\":71.00324,\"USDBWP\":10.718814,\"USDBYN\":2.106342,\"USDBYR\":19600,\"USDBZD\":2.015844,\"USDCAD\":1.31081,\"USDCDF\":1679.999895,\"USDCHF\":0.98138,\"USDCLF\":0.027221,\"USDCLP\":750.899023,\"USDCNY\":7.004901,\"USDCOP\":3321.88,\"USDCRC\":565.13006,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":99.549739,\"USDCZK\":22.908699,\"USDDJF\":177.719712,\"USDDKK\":6.71796,\"USDDOP\":53.160107,\"USDDZD\":119.53066,\"USDEGP\":16.056098,\"USDERN\":14.999597,\"USDETB\":31.689795,\"USDEUR\":0.89904,\"USDFJD\":2.165013,\"USDFKP\":0.81288,\"USDGBP\":0.765115,\"USDGEL\":2.900597,\"USDGGP\":0.764911,\"USDGHS\":5.720521,\"USDGIP\":0.81288,\"USDGMD\":51.424974,\"USDGNF\":9399.999964,\"USDGTQ\":7.695363,\"USDGYD\":208.66603,\"USDHKD\":7.786049,\"USDHNL\":24.770533,\"USDHRK\":6.694957,\"USDHTG\":96.25832,\"USDHUF\":297.439745,\"USDIDR\":14002.5,\"USDILS\":3.49729,\"USDIMP\":0.764911,\"USDINR\":70.973697,\"USDIQD\":1191,\"USDIRR\":42104.999976,\"USDISK\":123.150414,\"USDJEP\":0.764911,\"USDJMD\":134.01543,\"USDJOD\":0.709041,\"USDJPY\":109.611504,\"USDKES\":100.959967,\"USDKGS\":69.840164,\"USDKHR\":4064.999703,\"USDKMF\":441.374985,\"USDKPW\":900.007079,\"USDKRW\":1166.214983,\"USDKWD\":0.30355,\"USDKYD\":0.833352,\"USDKZT\":384.74569,\"USDLAK\":8877.999726,\"USDLBP\":1512.000293,\"USDLKR\":181.182302,\"USDLRD\":187.502765,\"USDLSL\":14.397564,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.406028,\"USDMAD\":9.605002,\"USDMDL\":17.230877,\"USDMGA\":3600.000011,\"USDMKD\":55.265391,\"USDMMK\":1505.060895,\"USDMNT\":2737.463759,\"USDMOP\":8.023222,\"USDMRO\":356.999834,\"USDMUR\":36.593309,\"USDMVR\":15.46011,\"USDMWK\":724.999792,\"USDMXN\":18.94723,\"USDMYR\":4.14303,\"USDMZN\":63.180592,\"USDNAD\":14.398576,\"USDNGN\":362.505074,\"USDNIO\":33.895524,\"USDNOK\":9.021245,\"USDNPR\":113.60554,\"USDNZD\":1.51937,\"USDOMR\":0.384913,\"USDPAB\":1.000058,\"USDPEN\":3.340499,\"USDPGK\":3.400959,\"USDPHP\":50.645501,\"USDPKR\":154.250024,\"USDPLN\":3.84175,\"USDPYG\":6462.814597,\"USDQAR\":3.64075,\"USDRON\":4.29255,\"USDRSD\":105.649766,\"USDRUB\":62.678596,\"USDRWF\":940,\"USDSAR\":3.751062,\"USDSBD\":8.290125,\"USDSCR\":13.697263,\"USDSDG\":45.11595,\"USDSEK\":9.40842,\"USDSGD\":1.35528,\"USDSHP\":1.320898,\"USDSLL\":9725.000003,\"USDSOS\":581.000214,\"USDSRD\":7.457978,\"USDSTD\":21560.79,\"USDSVC\":8.750511,\"USDSYP\":514.99995,\"USDSZL\":14.401353,\"USDTHB\":30.180486,\"USDTJS\":9.68146,\"USDTMT\":3.5,\"USDTND\":2.836499,\"USDTOP\":2.30155,\"USDTRY\":5.910205,\"USDTTD\":6.756984,\"USDTWD\":30.160501,\"USDTZS\":2301.098055,\"USDUAH\":23.426153,\"USDUGX\":3665.170302,\"USDUSD\":1,\"USDUYU\":37.746294,\"USDUZS\":9512.506766,\"USDVEF\":9.987498,\"USDVND\":23172.5,\"USDVUV\":116.324726,\"USDWST\":2.660497,\"USDXAF\":589.49445,\"USDXAG\":0.058884,\"USDXAU\":0.000678,\"USDXCD\":2.70255,\"USDXDR\":0.725199,\"USDXOF\":588.999844,\"USDXPF\":107.375,\"USDYER\":250.271583,\"USDZAR\":14.2811,\"USDZMK\":9001.197482,\"USDZMW\":14.475683,\"USDZWL\":322.000001}}', 1, '2019-12-18 16:09:07', '2019-12-18 18:03:37', '2019-12-18 18:03:37', 'USD');
INSERT INTO `exchange_rate` (`id`, `rates`, `status`, `date`, `created_at`, `updated_at`, `default_curr`) VALUES
(842, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1581610145,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673198,\"USDAFN\":77.208119,\"USDALL\":112.350092,\"USDAMD\":478.596497,\"USDANG\":1.790322,\"USDAOA\":494.755501,\"USDARS\":61.399772,\"USDAUD\":1.485388,\"USDAWG\":1.8005,\"USDAZN\":1.67226,\"USDBAM\":1.801604,\"USDBBD\":2.019408,\"USDBDT\":84.95829,\"USDBGN\":1.801302,\"USDBHD\":0.37704,\"USDBIF\":1890,\"USDBMD\":1,\"USDBND\":1.389443,\"USDBOB\":6.906036,\"USDBRL\":4.327101,\"USDBSD\":1.00017,\"USDBTC\":0.000097349447,\"USDBTN\":71.29562,\"USDBWP\":10.966871,\"USDBYN\":2.203267,\"USDBYR\":19600,\"USDBZD\":2.016,\"USDCAD\":1.325595,\"USDCDF\":1685.999898,\"USDCHF\":0.97827,\"USDCLF\":0.028866,\"USDCLP\":796.495659,\"USDCNY\":6.977302,\"USDCOP\":3380.78,\"USDCRC\":569.86132,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":101.999895,\"USDCZK\":22.931986,\"USDDJF\":177.719872,\"USDDKK\":6.88599,\"USDDOP\":53.480165,\"USDDZD\":120.689734,\"USDEGP\":15.681704,\"USDERN\":15.000132,\"USDETB\":32.101675,\"USDEUR\":0.921603,\"USDFJD\":2.196499,\"USDFKP\":0.766259,\"USDGBP\":0.766635,\"USDGEL\":2.875029,\"USDGGP\":0.766259,\"USDGHS\":5.370009,\"USDGIP\":0.766259,\"USDGMD\":51.050107,\"USDGNF\":9437.495433,\"USDGTQ\":7.631158,\"USDGYD\":209.0428,\"USDHKD\":7.766685,\"USDHNL\":24.825003,\"USDHRK\":6.867802,\"USDHTG\":100.798689,\"USDHUF\":311.313012,\"USDIDR\":13702.5,\"USDILS\":3.42377,\"USDIMP\":0.766259,\"USDINR\":71.282981,\"USDIQD\":1190,\"USDIRR\":42104.999746,\"USDISK\":126.879555,\"USDJEP\":0.766259,\"USDJMD\":141.35213,\"USDJOD\":0.708999,\"USDJPY\":109.819499,\"USDKES\":100.59937,\"USDKGS\":69.850468,\"USDKHR\":4075.000137,\"USDKMF\":453.598985,\"USDKPW\":900.050976,\"USDKRW\":1182.510467,\"USDKWD\":0.30485,\"USDKYD\":0.833445,\"USDKZT\":377.09221,\"USDLAK\":8904.999846,\"USDLBP\":1512.999771,\"USDLKR\":181.50339,\"USDLRD\":196.500298,\"USDLSL\":14.940205,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.405006,\"USDMAD\":9.715504,\"USDMDL\":17.702939,\"USDMGA\":3681.000411,\"USDMKD\":56.769082,\"USDMMK\":1451.227803,\"USDMNT\":2756.919573,\"USDMOP\":8.001566,\"USDMRO\":357.000259,\"USDMUR\":37.197259,\"USDMVR\":15.45023,\"USDMWK\":730.000091,\"USDMXN\":18.640597,\"USDMYR\":4.140498,\"USDMZN\":64.314987,\"USDNAD\":14.939698,\"USDNGN\":363.000207,\"USDNIO\":34.150038,\"USDNOK\":9.25529,\"USDNPR\":114.07267,\"USDNZD\":1.550045,\"USDOMR\":0.385001,\"USDPAB\":1.000078,\"USDPEN\":3.381499,\"USDPGK\":3.379732,\"USDPHP\":50.506009,\"USDPKR\":154.504736,\"USDPLN\":3.91815,\"USDPYG\":6528.6835,\"USDQAR\":3.641024,\"USDRON\":4.390502,\"USDRSD\":108.329782,\"USDRUB\":63.475399,\"USDRWF\":925,\"USDSAR\":3.750594,\"USDSBD\":8.261159,\"USDSCR\":13.700561,\"USDSDG\":51.689851,\"USDSEK\":9.67152,\"USDSGD\":1.388605,\"USDSHP\":0.766259,\"USDSLL\":9699.999739,\"USDSOS\":585.000147,\"USDSRD\":7.457951,\"USDSTD\":21888.77818,\"USDSVC\":8.750804,\"USDSYP\":514.99882,\"USDSZL\":14.940128,\"USDTHB\":31.1095,\"USDTJS\":9.696933,\"USDTMT\":3.51,\"USDTND\":2.849501,\"USDTOP\":2.31005,\"USDTRY\":6.040599,\"USDTTD\":6.762802,\"USDTWD\":29.995499,\"USDTZS\":2310.401804,\"USDUAH\":24.466316,\"USDUGX\":3667.5985,\"USDUSD\":1,\"USDUYU\":37.78969,\"USDUZS\":9524.999766,\"USDVEF\":9.987501,\"USDVND\":23238.5,\"USDVUV\":118.044332,\"USDWST\":2.674458,\"USDXAF\":604.19557,\"USDXAG\":0.05658,\"USDXAU\":0.000635,\"USDXCD\":2.70255,\"USDXDR\":0.729872,\"USDXOF\":602.000223,\"USDXPF\":110.349422,\"USDYER\":250.35019,\"USDZAR\":14.9065,\"USDZMK\":9001.189175,\"USDZMW\":14.697291,\"USDZWL\":322.000001}}', 1, '2020-02-13 16:09:05', '2020-02-14 10:56:21', '2020-02-14 10:56:21', 'USD'),
(843, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1581696545,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.672956,\"USDAFN\":77.25049,\"USDALL\":112.62501,\"USDAMD\":479.0502,\"USDANG\":1.790112,\"USDAOA\":494.755498,\"USDARS\":61.447396,\"USDAUD\":1.48937,\"USDAWG\":1.8,\"USDAZN\":1.692558,\"USDBAM\":1.804762,\"USDBBD\":2.019148,\"USDBDT\":84.89353,\"USDBGN\":1.804201,\"USDBHD\":0.377038,\"USDBIF\":1890,\"USDBMD\":1,\"USDBND\":1.391746,\"USDBOB\":6.915265,\"USDBRL\":4.316117,\"USDBSD\":1.000023,\"USDBTC\":0.000097409312,\"USDBTN\":71.301631,\"USDBWP\":10.953561,\"USDBYN\":2.195801,\"USDBYR\":19600,\"USDBZD\":2.015807,\"USDCAD\":1.32585,\"USDCDF\":1685.000081,\"USDCHF\":0.981701,\"USDCLF\":0.028663,\"USDCLP\":790.902084,\"USDCNY\":6.987096,\"USDCOP\":3374,\"USDCRC\":566.775089,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":101.950445,\"USDCZK\":22.94498,\"USDDJF\":177.720428,\"USDDKK\":6.891985,\"USDDOP\":53.450413,\"USDDZD\":120.725996,\"USDEGP\":15.706205,\"USDERN\":14.999962,\"USDETB\":32.090106,\"USDEUR\":0.922505,\"USDFJD\":2.194982,\"USDFKP\":0.768286,\"USDGBP\":0.7682,\"USDGEL\":2.870255,\"USDGGP\":0.768286,\"USDGHS\":5.334984,\"USDGIP\":0.768286,\"USDGMD\":51.096721,\"USDGNF\":9437.503975,\"USDGTQ\":7.630332,\"USDGYD\":208.87259,\"USDHKD\":7.76695,\"USDHNL\":24.860239,\"USDHRK\":6.872944,\"USDHTG\":99.93494,\"USDHUF\":309.94969,\"USDIDR\":13712,\"USDILS\":3.42706,\"USDIMP\":0.768286,\"USDINR\":71.570501,\"USDIQD\":1190,\"USDIRR\":42104.999881,\"USDISK\":126.76987,\"USDJEP\":0.768286,\"USDJMD\":141.49076,\"USDJOD\":0.708968,\"USDJPY\":109.777499,\"USDKES\":100.709906,\"USDKGS\":69.850424,\"USDKHR\":4075.999507,\"USDKMF\":453.624985,\"USDKPW\":900.031742,\"USDKRW\":1183.769952,\"USDKWD\":0.30485,\"USDKYD\":0.833368,\"USDKZT\":376.62463,\"USDLAK\":8900.000197,\"USDLBP\":1513.999752,\"USDLKR\":181.45754,\"USDLRD\":196.649916,\"USDLSL\":14.849668,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.405039,\"USDMAD\":9.7095,\"USDMDL\":17.660249,\"USDMGA\":3704.999936,\"USDMKD\":56.813571,\"USDMMK\":1447.060101,\"USDMNT\":2755.948426,\"USDMOP\":8.000461,\"USDMRO\":357.000035,\"USDMUR\":37.297908,\"USDMVR\":15.44981,\"USDMWK\":730.000112,\"USDMXN\":18.5749,\"USDMYR\":4.139796,\"USDMZN\":64.419802,\"USDNAD\":14.850365,\"USDNGN\":363.000006,\"USDNIO\":34.199624,\"USDNOK\":9.250603,\"USDNPR\":114.08217,\"USDNZD\":1.55526,\"USDOMR\":0.385018,\"USDPAB\":1.000023,\"USDPEN\":3.381956,\"USDPGK\":3.3825,\"USDPHP\":50.543498,\"USDPKR\":154.350055,\"USDPLN\":3.91821,\"USDPYG\":6531.478501,\"USDQAR\":3.640982,\"USDRON\":4.3996,\"USDRSD\":108.419923,\"USDRUB\":63.587702,\"USDRWF\":930,\"USDSAR\":3.750582,\"USDSBD\":8.228692,\"USDSCR\":13.704692,\"USDSDG\":51.675035,\"USDSEK\":9.71619,\"USDSGD\":1.392097,\"USDSHP\":0.768286,\"USDSLL\":9699.999569,\"USDSOS\":585.000055,\"USDSRD\":7.458014,\"USDSTD\":21888.77818,\"USDSVC\":8.749855,\"USDSYP\":514.99882,\"USDSZL\":14.849918,\"USDTHB\":31.210217,\"USDTJS\":9.696735,\"USDTMT\":3.51,\"USDTND\":2.845496,\"USDTOP\":2.31165,\"USDTRY\":6.049395,\"USDTTD\":6.757007,\"USDTWD\":30.01697,\"USDTZS\":2310.089851,\"USDUAH\":24.471327,\"USDUGX\":3668.166199,\"USDUSD\":1,\"USDUYU\":37.916349,\"USDUZS\":9534.999948,\"USDVEF\":9.987496,\"USDVND\":23238.5,\"USDVUV\":118.069074,\"USDWST\":2.677605,\"USDXAF\":605.30786,\"USDXAG\":0.056346,\"USDXAU\":0.000632,\"USDXCD\":2.70255,\"USDXDR\":0.73098,\"USDXOF\":604.5023,\"USDXPF\":110.298376,\"USDYER\":250.298362,\"USDZAR\":14.88302,\"USDZMK\":9001.197134,\"USDZMW\":14.700625,\"USDZWL\":322.000001}}', 1, '2020-02-14 16:09:05', '2020-02-14 17:56:22', '2020-02-14 17:56:22', 'USD'),
(844, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1583771645,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673101,\"USDAFN\":75.999826,\"USDALL\":107.703947,\"USDAMD\":480.480079,\"USDANG\":1.791331,\"USDAOA\":491.888502,\"USDARS\":62.4455,\"USDAUD\":1.508728,\"USDAWG\":1.8,\"USDAZN\":1.702594,\"USDBAM\":1.713056,\"USDBBD\":2.017675,\"USDBDT\":84.89169,\"USDBGN\":1.7059,\"USDBHD\":0.377309,\"USDBIF\":1895,\"USDBMD\":1,\"USDBND\":1.384675,\"USDBOB\":6.90001,\"USDBRL\":4.747592,\"USDBSD\":1.000692,\"USDBTC\":0.000128,\"USDBTN\":74.01027,\"USDBWP\":11.199436,\"USDBYN\":3.079864,\"USDBYR\":19600,\"USDBZD\":2.011325,\"USDCAD\":1.357585,\"USDCDF\":1700.999682,\"USDCHF\":0.927025,\"USDCLF\":0.030511,\"USDCLP\":841.79797,\"USDCNY\":6.946498,\"USDCOP\":3588.27,\"USDCRC\":569.49535,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":97.249737,\"USDCZK\":22.260237,\"USDDJF\":177.719615,\"USDDKK\":6.513515,\"USDDOP\":53.85998,\"USDDZD\":119.00268,\"USDEGP\":15.694108,\"USDERN\":14.999669,\"USDETB\":32.400369,\"USDEUR\":0.87234,\"USDFJD\":2.214986,\"USDFKP\":0.762917,\"USDGBP\":0.762415,\"USDGEL\":2.790222,\"USDGGP\":0.762917,\"USDGHS\":5.46497,\"USDGIP\":0.762917,\"USDGMD\":50.939616,\"USDGNF\":9429.999645,\"USDGTQ\":7.675631,\"USDGYD\":209.69882,\"USDHKD\":7.772245,\"USDHNL\":24.9015,\"USDHRK\":6.557399,\"USDHTG\":94.17035,\"USDHUF\":293.404963,\"USDIDR\":14383,\"USDILS\":3.52384,\"USDIMP\":0.762917,\"USDINR\":74.384999,\"USDIQD\":1189.5,\"USDIRR\":42104.999464,\"USDISK\":127.289902,\"USDJEP\":0.762917,\"USDJMD\":134.64508,\"USDJOD\":0.708967,\"USDJPY\":102.228494,\"USDKES\":102.910147,\"USDKGS\":69.850267,\"USDKHR\":4059.999884,\"USDKMF\":435.850478,\"USDKPW\":899.990978,\"USDKRW\":1198.846549,\"USDKWD\":0.305103,\"USDKYD\":0.833994,\"USDKZT\":386.282219,\"USDLAK\":8897.504632,\"USDLBP\":1513.999979,\"USDLKR\":182.06203,\"USDLRD\":198.000033,\"USDLSL\":15.680267,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.389882,\"USDMAD\":9.425501,\"USDMDL\":17.327564,\"USDMGA\":3664.999503,\"USDMKD\":53.983675,\"USDMMK\":1363.526705,\"USDMNT\":2765.385258,\"USDMOP\":8.00953,\"USDMRO\":357.000035,\"USDMUR\":37.000229,\"USDMVR\":15.482409,\"USDMWK\":734.999868,\"USDMXN\":21.12084,\"USDMYR\":4.221501,\"USDMZN\":65.604975,\"USDNAD\":15.680223,\"USDNGN\":366.499831,\"USDNIO\":34.250066,\"USDNOK\":9.50073,\"USDNPR\":118.41911,\"USDNZD\":1.56568,\"USDOMR\":0.385113,\"USDPAB\":1.00078,\"USDPEN\":3.501997,\"USDPGK\":3.407498,\"USDPHP\":50.534984,\"USDPKR\":155.503608,\"USDPLN\":3.77411,\"USDPYG\":6537.619301,\"USDQAR\":3.640988,\"USDRON\":4.206598,\"USDRSD\":102.664953,\"USDRUB\":74.27315,\"USDRWF\":945,\"USDSAR\":3.753826,\"USDSBD\":8.302328,\"USDSCR\":13.706219,\"USDSDG\":55.304285,\"USDSEK\":9.39514,\"USDSGD\":1.38274,\"USDSHP\":0.762917,\"USDSLL\":9724.999794,\"USDSOS\":584.999912,\"USDSRD\":7.45797,\"USDSTD\":21888.77818,\"USDSVC\":8.756848,\"USDSYP\":514.99882,\"USDSZL\":15.680474,\"USDTHB\":31.489626,\"USDTJS\":9.688543,\"USDTMT\":3.5,\"USDTND\":2.797499,\"USDTOP\":2.30795,\"USDTRY\":6.13886,\"USDTTD\":6.761497,\"USDTWD\":30.000498,\"USDTZS\":2304.525104,\"USDUAH\":25.033151,\"USDUGX\":3717.5164,\"USDUSD\":1,\"USDUYU\":40.903915,\"USDUZS\":9510.000528,\"USDVEF\":9.987502,\"USDVND\":23205.5,\"USDVUV\":118.848831,\"USDWST\":2.690113,\"USDXAF\":574.574299,\"USDXAG\":0.059046,\"USDXAU\":0.000599,\"USDXCD\":2.70255,\"USDXDR\":0.718681,\"USDXOF\":571.506343,\"USDXPF\":105.250242,\"USDYER\":250.297794,\"USDZAR\":16.07202,\"USDZMK\":9001.205713,\"USDZMW\":15.360239,\"USDZWL\":322.000001}}', 1, '2020-03-09 16:34:05', '2020-03-10 15:58:00', '2020-03-10 15:58:00', 'USD'),
(845, '{\"success\":true,\"terms\":\"https://currencylayer.com/terms\",\"privacy\":\"https://currencylayer.com/privacy\",\"timestamp\":1598805486,\"source\":\"USD\",\"quotes\":{\"USDAED\":3.673204,\"USDAFN\":77.00029,\"USDALL\":104.209104,\"USDAMD\":487.240403,\"USDANG\":1.795134,\"USDAOA\":596.703981,\"USDARS\":73.919204,\"USDAUD\":1.357405,\"USDAWG\":1.8,\"USDAZN\":1.70397,\"USDBAM\":1.643009,\"USDBBD\":2.002881,\"USDBDT\":84.83675,\"USDBGN\":1.64353,\"USDBHD\":0.376937,\"USDBIF\":1929.9644,\"USDBMD\":1,\"USDBND\":1.3604,\"USDBOB\":6.90054,\"USDBRL\":5.39145,\"USDBSD\":1.000097,\"USDBTC\":0.000085771089,\"USDBTN\":73.30712,\"USDBWP\":11.46881,\"USDBYN\":2.67029,\"USDBYR\":19600,\"USDBZD\":2.00515,\"USDCAD\":1.309835,\"USDCDF\":1950.000362,\"USDCHF\":0.904176,\"USDCLF\":0.02825,\"USDCLP\":779.503912,\"USDCNY\":6.865404,\"USDCOP\":3745.5,\"USDCRC\":595.40401,\"USDCUC\":1,\"USDCUP\":26.5,\"USDCVE\":92.62892,\"USDCZK\":21.93304,\"USDDJF\":177.720394,\"USDDKK\":6.251304,\"USDDOP\":58.414714,\"USDDZD\":127.96708,\"USDEGP\":15.867803,\"USDERN\":15.000358,\"USDETB\":36.148841,\"USDEUR\":0.839877,\"USDFJD\":2.120504,\"USDFKP\":0.748975,\"USDGBP\":0.749005,\"USDGEL\":3.090391,\"USDGGP\":0.748975,\"USDGHS\":5.785391,\"USDGIP\":0.748975,\"USDGMD\":51.803853,\"USDGNF\":9659.65104,\"USDGTQ\":7.710615,\"USDGYD\":209.10041,\"USDHKD\":7.750315,\"USDHNL\":24.662609,\"USDHRK\":6.333604,\"USDHTG\":112.01922,\"USDHUF\":297.40504,\"USDIDR\":14534.7,\"USDILS\":3.361504,\"USDIMP\":0.748975,\"USDINR\":73.128504,\"USDIQD\":1193.9078,\"USDIRR\":42105.000352,\"USDISK\":137.520386,\"USDJEP\":0.748975,\"USDJMD\":149.61714,\"USDJOD\":0.70904,\"USDJPY\":105.36504,\"USDKES\":108.13421,\"USDKGS\":78.468304,\"USDKHR\":4129.672304,\"USDKMF\":412.950384,\"USDKPW\":900,\"USDKRW\":1180.610384,\"USDKWD\":0.30547,\"USDKYD\":0.833428,\"USDKZT\":420.37307,\"USDLAK\":9142.084039,\"USDLBP\":1512.283804,\"USDLKR\":186.31484,\"USDLRD\":199.303775,\"USDLSL\":17.350382,\"USDLTL\":2.95274,\"USDLVL\":0.60489,\"USDLYD\":1.366773,\"USDMAD\":9.160572,\"USDMDL\":16.666316,\"USDMGA\":3850.276604,\"USDMKD\":51.76013,\"USDMMK\":1341.607204,\"USDMNT\":2856.736167,\"USDMOP\":7.983299,\"USDMRO\":357.000149,\"USDMUR\":39.742997,\"USDMVR\":15.410378,\"USDMWK\":749.318504,\"USDMXN\":21.753604,\"USDMYR\":4.165504,\"USDMZN\":71.560377,\"USDNAD\":17.350377,\"USDNGN\":387.460377,\"USDNIO\":34.86267,\"USDNOK\":8.84633,\"USDNPR\":117.29146,\"USDNZD\":1.48291,\"USDOMR\":0.384966,\"USDPAB\":1.000097,\"USDPEN\":3.564309,\"USDPGK\":3.487695,\"USDPHP\":48.363499,\"USDPKR\":167.39836,\"USDPLN\":3.68589,\"USDPYG\":6972.534038,\"USDQAR\":3.641038,\"USDRON\":4.065104,\"USDRSD\":98.780373,\"USDRUB\":74.085204,\"USDRWF\":966.9731,\"USDSAR\":3.750472,\"USDSBD\":8.265569,\"USDSCR\":17.887708,\"USDSDG\":55.303678,\"USDSEK\":8.63827,\"USDSGD\":1.35862,\"USDSHP\":0.748975,\"USDSLL\":9762.503669,\"USDSOS\":582.503667,\"USDSRD\":7.458038,\"USDSTD\":21292.767074,\"USDSVC\":8.75095,\"USDSYP\":511.633793,\"USDSZL\":16.722825,\"USDTHB\":31.108038,\"USDTJS\":10.318256,\"USDTMT\":3.51,\"USDTND\":2.727504,\"USDTOP\":2.27665,\"USDTRY\":7.334904,\"USDTTD\":6.777807,\"USDTWD\":29.348038,\"USDTZS\":2320.182038,\"USDUAH\":27.486926,\"USDUGX\":3676.342704,\"USDUSD\":1,\"USDUYU\":42.798758,\"USDUZS\":10272.481038,\"USDVEF\":9.987504,\"USDVND\":23175,\"USDVUV\":112.058659,\"USDWST\":2.646201,\"USDXAF\":551.04609,\"USDXAG\":0.036355,\"USDXAU\":0.000509,\"USDXCD\":2.70255,\"USDXDR\":0.708174,\"USDXOF\":551.04146,\"USDXPF\":100.9036,\"USDYER\":250.350364,\"USDZAR\":16.57285,\"USDZMK\":9001.203593,\"USDZMW\":19.526376,\"USDZWL\":322.000109}}', 1, '2020-08-30 16:38:06', '2020-08-30 21:12:55', '2020-08-30 21:12:55', 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `external_payroll`
--

CREATE TABLE `external_payroll` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `component` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `gross_pay` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curr_id` int(11) DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `bonus_deduc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus_deduc_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus_deduc_type` int(11) DEFAULT NULL,
  `sal_adv_deduct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_deduct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payroll_status` int(11) DEFAULT NULL,
  `process_date` date DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `week` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_year` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_year`
--

CREATE TABLE `financial_year` (
  `id` int(11) NOT NULL,
  `fin_name` varchar(100) NOT NULL,
  `fin_date` date NOT NULL,
  `active_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_cat` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `response` text COLLATE utf8mb4_unicode_ci,
  `response_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `response_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `response_dates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_approval_sys`
--

CREATE TABLE `hris_approval_sys` (
  `id` int(11) NOT NULL,
  `approval_name` varchar(225) NOT NULL,
  `level_users` longtext NOT NULL,
  `levels` longtext NOT NULL,
  `users` longtext NOT NULL,
  `json_display` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hse_access`
--

CREATE TABLE `hse_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hse_reports`
--

CREATE TABLE `hse_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_type` int(11) NOT NULL,
  `source_id` int(11) DEFAULT NULL,
  `report_details` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_status` int(11) DEFAULT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `report_date` date DEFAULT NULL,
  `report_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hse_source_type`
--

CREATE TABLE `hse_source_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `idp`
--

CREATE TABLE `idp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `short_term` longtext,
  `long_term` longtext,
  `user_competency` longtext,
  `dev_obj` longtext,
  `dev_assign` longtext,
  `other_act` longtext,
  `remarks` longtext,
  `formal_training` longtext,
  `target_comp_date` varchar(22) DEFAULT NULL,
  `actual_comp_date` varchar(22) DEFAULT NULL,
  `views` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `idp_competency`
--

CREATE TABLE `idp_competency` (
  `id` int(11) NOT NULL,
  `idp_id` int(11) NOT NULL,
  `core_comp` varchar(30) NOT NULL,
  `capability` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `indi_goals`
--

CREATE TABLE `indi_goals` (
  `id` int(11) NOT NULL,
  `indi_goal_cat` int(11) NOT NULL,
  `goal_set_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `indi_comment` longtext,
  `reviewer_comment` longtext,
  `overview_str` longtext,
  `area_improv` longtext,
  `sug_pp_dev` longtext,
  `final_review` varchar(225) DEFAULT NULL,
  `emp_comment` varchar(225) DEFAULT NULL,
  `emp_sign` varchar(225) DEFAULT NULL,
  `rev_sign` varchar(225) DEFAULT NULL,
  `supervisor_id` int(11) NOT NULL DEFAULT '0',
  `appraisal_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `indi_goal_cat`
--

CREATE TABLE `indi_goal_cat` (
  `id` int(11) NOT NULL,
  `goal_name` varchar(222) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(22) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indi_goal_cat`
--

INSERT INTO `indi_goal_cat` (`id`, `goal_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Appraisal Objectives and Goals', 1, '3', '0', '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(2, 'Competency Assessments', 1, '3', '0', '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(3, 'Behavioral Competencies', 1, '3', '0', '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(4, 'Individual/Reviewer Comments', 1, '3', '0', '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(5, 'Employee Comments of Appraisal platform', 1, '3', '0', '2018-04-06 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `indi_objectives`
--

CREATE TABLE `indi_objectives` (
  `id` int(11) NOT NULL,
  `indi_goal_id` int(11) NOT NULL,
  `objectives` text,
  `obj_level` varchar(225) NOT NULL DEFAULT '1',
  `reviewer_rating` varchar(225) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_no` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `sales_desc` longtext,
  `purchase_desc` longtext,
  `unit_measure` int(11) DEFAULT NULL,
  `qty` varchar(50) DEFAULT '0',
  `as_of_date` date DEFAULT NULL,
  `assemble_bom` varchar(50) DEFAULT NULL,
  `shelf_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `inventory_type` int(11) DEFAULT NULL,
  `whse_status` int(11) DEFAULT NULL,
  `search_key` varchar(200) DEFAULT NULL,
  `pref_vendor` int(11) DEFAULT '0',
  `re_order_level` varchar(50) DEFAULT '0',
  `sku` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `costing_method` varchar(50) DEFAULT NULL,
  `unit_cost` varchar(50) DEFAULT NULL,
  `expense_account` int(11) NOT NULL,
  `unit_price` varchar(50) DEFAULT NULL,
  `curr_id` int(11) DEFAULT NULL,
  `income_account` int(11) DEFAULT NULL,
  `inventory_account` int(11) NOT NULL,
  `special_equip` varchar(50) DEFAULT NULL,
  `put_away_template` int(11) DEFAULT NULL,
  `invt_count_period` int(11) DEFAULT NULL,
  `last_count_period` varchar(50) DEFAULT NULL,
  `next_count_start` varchar(50) DEFAULT NULL,
  `next_count_end` varchar(50) DEFAULT NULL,
  `cross_dock` varchar(50) DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_access`
--

CREATE TABLE `inventory_access` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assign`
--

CREATE TABLE `inventory_assign` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `user_id` varchar(11) DEFAULT NULL,
  `qty` varchar(22) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `item_desc` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_bom`
--

CREATE TABLE `inventory_bom` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` varchar(20) NOT NULL,
  `extended_amount` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_cat`
--

CREATE TABLE `inventory_cat` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `cat_desc` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_contract`
--

CREATE TABLE `inventory_contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `contract_type` int(11) DEFAULT NULL,
  `contract_status` int(11) DEFAULT NULL,
  `recurring_cost` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `next_reminder` date DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicing_interval` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `active_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recurring_interval` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_contract_items`
--

CREATE TABLE `inventory_contract_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extended_amount` int(11) DEFAULT NULL,
  `servicing_interval` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_reminder` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_contract_status`
--

CREATE TABLE `inventory_contract_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_contract_type`
--

CREATE TABLE `inventory_contract_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_record`
--

CREATE TABLE `inventory_record` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_desc` varchar(250) DEFAULT NULL,
  `dept_id` varchar(11) DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `warranty_expiry_date` varchar(50) DEFAULT NULL,
  `item_condition` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_type`
--

CREATE TABLE `inventory_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_type`
--

INSERT INTO `inventory_type` (`id`, `name`, `status`) VALUES
(1, 'Inventory', 1),
(2, 'Non-Inventory', 1),
(3, 'Services', 1);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `issue_desc` longtext COLLATE utf8mb4_unicode_ci,
  `impact` longtext COLLATE utf8mb4_unicode_ci,
  `resolution` longtext COLLATE utf8mb4_unicode_ci,
  `importance` longtext COLLATE utf8mb4_unicode_ci,
  `issue_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_access`
--

CREATE TABLE `jobs_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applicants`
--

CREATE TABLE `job_applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` int(11) NOT NULL,
  `cover_letter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_list`
--

CREATE TABLE `job_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_purpose` longtext COLLATE utf8mb4_unicode_ci,
  `job_desc` longtext COLLATE utf8mb4_unicode_ci,
  `experience` int(11) DEFAULT NULL,
  `job_spec` longtext COLLATE utf8mb4_unicode_ci,
  `job_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_default_transaction_account`
--

CREATE TABLE `journal_default_transaction_account` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_account_payable` int(11) DEFAULT NULL,
  `default_account_receivable` int(11) DEFAULT NULL,
  `default_sales_tax` int(11) DEFAULT NULL,
  `default_purchase_tax` int(11) DEFAULT NULL,
  `default_payroll_tax` int(11) DEFAULT NULL,
  `default_discount_allowed` int(11) DEFAULT NULL,
  `default_discount_received` int(11) DEFAULT NULL,
  `default_inventory` int(11) DEFAULT NULL,
  `active_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_extention`
--

CREATE TABLE `journal_extention` (
  `id` int(11) NOT NULL,
  `uid` varchar(15) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `fin_year` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `sum_total` varchar(100) NOT NULL,
  `trans_total` varchar(20) DEFAULT NULL,
  `balance` varchar(11) DEFAULT NULL,
  `balance_trans` varchar(11) DEFAULT NULL,
  `balance_paid` varchar(11) DEFAULT NULL,
  `balance_paid_trans` varchar(11) DEFAULT NULL,
  `total_excl_tax_trans` varchar(20) DEFAULT NULL,
  `total_excl_tax` varchar(20) DEFAULT NULL,
  `tax_total` varchar(15) DEFAULT NULL,
  `tax_trans` varchar(15) DEFAULT NULL,
  `discount_total` varchar(20) DEFAULT NULL,
  `discount_trans` varchar(20) DEFAULT NULL,
  `discount_type` varchar(20) DEFAULT NULL,
  `discount_perct` varchar(5) DEFAULT NULL,
  `message` longtext,
  `attachment` longtext,
  `ex_rate` longtext,
  `curr_date` datetime DEFAULT NULL,
  `vendor_customer` int(11) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `transaction_format` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `post_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `balance_status` int(11) DEFAULT NULL,
  `journal_status` int(11) DEFAULT NULL,
  `reconcile_status` int(11) DEFAULT NULL,
  `transaction_type` int(11) DEFAULT NULL,
  `cash_status` tinyint(4) DEFAULT '0',
  `print_status` int(11) DEFAULT NULL,
  `file_no` int(11) DEFAULT NULL,
  `terms` int(11) DEFAULT NULL,
  `tax_perct` varchar(5) DEFAULT NULL,
  `tax_type` int(11) DEFAULT NULL,
  `default_curr` varchar(15) DEFAULT NULL,
  `trans_curr` varchar(15) DEFAULT NULL,
  `mails` varchar(255) DEFAULT NULL,
  `mail_copy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_transaction_format`
--

CREATE TABLE `journal_transaction_format` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_transaction_terms`
--

CREATE TABLE `journal_transaction_terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days_due` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_approval`
--

CREATE TABLE `leave_approval` (
  `id` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `approval_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(222) NOT NULL,
  `updated_by` varchar(222) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_log`
--

CREATE TABLE `leave_log` (
  `id` int(11) NOT NULL,
  `leave_type` int(11) NOT NULL,
  `leave_desc` longtext,
  `edit_request` longtext,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `year` varchar(22) DEFAULT NULL,
  `attachment` longtext,
  `dept_id` int(11) NOT NULL,
  `approval_json` longtext NOT NULL,
  `approval_level` longtext NOT NULL,
  `approval_user` longtext NOT NULL,
  `approved_users` longtext,
  `approved_date` datetime DEFAULT NULL,
  `approval_date` varchar(30) DEFAULT NULL,
  `deny_reason` varchar(255) DEFAULT NULL,
  `approval_id` int(11) NOT NULL,
  `approval_status` int(11) NOT NULL,
  `request_user` int(11) NOT NULL,
  `dept_req_user` int(11) NOT NULL,
  `deny_user` int(11) DEFAULT NULL,
  `complete_status` int(11) NOT NULL,
  `views` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `id` int(11) NOT NULL,
  `leave_type` varchar(225) NOT NULL,
  `days` int(11) NOT NULL,
  `leave_desc` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_learnt`
--

CREATE TABLE `lessons_learnt` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `lesson_date` date DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommendation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `need` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `follow_up` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `loan_name` varchar(225) DEFAULT NULL,
  `loan_desc` longtext,
  `interest_rate` varchar(22) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `loan_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_11_14_142144_create_department_table', 1),
(4, '2017_11_14_142251_create_position_table', 1),
(5, '2017_11_14_142339_create_salary_table', 1),
(6, '2017_11_14_150317_create_salary_component_table', 1),
(7, '2017_11_14_150511_create_salary_category_table', 1),
(8, '2017_11_14_150817_create_roles_table', 1),
(9, '2018_02_21_142248_CreateCompanyInfo', 1),
(10, '2019_04_04_174620_create_temp_users_table', 1),
(11, '2019_04_04_174709_create_milestones_table', 1),
(12, '2019_04_04_174840_create_task_lists_table', 1),
(13, '2019_04_04_174859_create_tasks_table', 1),
(14, '2019_04_04_175058_create_change_logs_table', 1),
(15, '2019_04_04_175117_create_decisions_table', 1),
(16, '2019_04_04_175328_create_deliverables_table', 1),
(17, '2019_04_04_175424_create_change_log_comments_table', 1),
(18, '2019_04_04_175452_create_decision_comments_table', 1),
(19, '2019_04_04_175514_create_deliverable_comments_table', 1),
(20, '2019_04_04_175555_create_risks_table', 1),
(21, '2019_04_04_175622_create_assump_constraints_table', 1),
(22, '2019_04_04_175645_create_assump_constraints_comments_table', 1),
(23, '2019_04_04_175713_create_project_docs_table', 1),
(24, '2019_04_04_175735_create_issues_table', 1),
(25, '2019_04_04_175752_create_lessons_learnts_table', 1),
(26, '2019_06_07_105843_create_user_pin_code', 1),
(27, '2019_06_07_131730_create_number_times_to_user_pin_code_table', 1),
(28, '2019_06_27_132429_create_test_table', 2),
(29, '2019_06_27_132633_create_test_category_table', 2),
(30, '2019_06_27_132747_create_test_question_table', 2),
(31, '2019_06_27_133344_create_test_quest_ans_table', 2),
(32, '2019_06_27_133448_create_test_session_table', 2),
(33, '2019_06_27_134318_create_test_user_ans_table', 2),
(34, '2019_06_27_134340_create_test_temp_user_ans_table', 2),
(35, '2019_06_27_184025_create_test_session_7more_columns_table', 3),
(36, '2019_07_01_105428_add_department_to_test', 4),
(37, '2019_07_01_125252_add_duration_to_test_category', 5),
(38, '2019_07_19_145521_index_test_user_ans_columns', 6),
(39, '2019_08_11_180907_create_jobs_table', 7),
(40, '2019_08_11_181040_create_job_applicants_table', 7),
(41, '2019_08_12_093032_create__jobs__access_table', 8),
(42, '2019_08_12_101010_add_more_columns_to_jobs', 9),
(43, '2019_08_17_114449_create_admin_approval_sys_table', 10),
(44, '2019_08_17_114744_create_admin_approval_dept_table', 10),
(45, '2019_08_17_115736_create_admin_category_table', 10),
(46, '2019_08_17_123933_create_admin_requisition_table', 10),
(47, '2019_08_20_112109_rename_level_admin_approval_sys_table', 11),
(48, '2019_08_20_132100_add_proj_id_admin_requisition', 12),
(49, '2019_08_20_190812_add_feedback_admin_requisition_table', 13),
(50, '2019_08_23_113635_create_helpdesk_table', 14),
(51, '2019_08_23_115414_create_ticket_category_table', 14),
(52, '2019_08_23_182941_add_to_help_desk_table', 15),
(53, '2019_08_29_135517_create_events_table', 16),
(54, '2019_08_29_135600_create_documents_table', 16),
(55, '2019_08_29_135648_create_news_table', 16),
(56, '2019_08_29_135738_create_hse_reports_table', 16),
(57, '2019_08_29_163357_create_hse_source_type_table', 16),
(58, '2019_08_30_191133_create_hse_access_table', 17),
(59, '2019_09_06_191024_create_crm_activity_types_table', 18),
(60, '2019_09_06_191257_create_crm_lead_table', 18),
(61, '2019_09_06_191354_create_crm_stages_table', 18),
(62, '2019_09_06_191434_create_crm_opportunity_table', 19),
(63, '2019_09_06_191511_create_crm_activity_table', 19),
(64, '2019_09_06_191552_create_crm_sales_team_table', 19),
(65, '2019_09_06_191616_create_crm_notes_table', 19),
(66, '2019_09_07_095824_create_discuss_table', 19),
(67, '2019_09_07_095845_create_notes_table', 19),
(68, '2019_09_07_100147_create_discuss_comments_table', 19),
(69, '2019_09_10_154554_add_to_crm_notes', 20),
(70, '2019_09_12_144239_add_to_crm_activity', 21),
(71, '2019_09_13_155946_modify_crm_activity', 22),
(72, '2019_09_13_163351_modify_crm_activity2', 23),
(73, '2019_09_13_174644_add_to_crm_opportunity', 24),
(74, '2019_09_16_104910_create_crm_sales_cycle_table', 25),
(77, '2019_09_16_105133_add_to_crm_opportunity2', 26),
(78, '2019_09_20_173401_add_to_discuss', 27),
(79, '2019_09_21_114815_add_to_discuss_comments', 28),
(80, '2019_09_23_133554_create_quick_note', 29),
(81, '2019_09_23_153655_modify_quick_note', 30),
(96, '2019_09_26_133156_create_vehicle_model_table', 31),
(97, '2019_09_26_133223_create_vehicle_make_table', 31),
(98, '2019_09_26_133325_create_vehicle_service_types_table', 31),
(99, '2019_09_26_133402_create_vehicle_contract_types_table', 31),
(100, '2019_09_26_133454_create_vehicle_status_table', 31),
(101, '2019_09_26_133519_create_vehicle_category_table', 31),
(102, '2019_09_26_133624_create_vehicle_table', 31),
(103, '2019_09_26_133842_create_vehicle_contract_table', 31),
(104, '2019_09_26_133908_create_vehicle_fuel_log_table', 31),
(105, '2019_09_26_133951_create_vehicle_service_log_table', 31),
(106, '2019_09_26_134513_create_vehicle_odometer_table', 31),
(107, '2019_09_27_122622_create_vehicle_maintenance_reminder_table', 31),
(108, '2019_09_27_122652_create_vehicle_maintenance_schedule_table', 31),
(109, '2019_09_27_122738_create_vehicle_fuel_station_table', 31),
(110, '2019_10_04_181137_modify_vehicle_service_log_table', 32),
(111, '2019_10_07_093221_add_to_vehicle_odometer_table', 33),
(112, '2019_10_07_132142_create_vehicle_fleet_access_table', 34),
(113, '2019_10_14_094638_create_budget_summary_table', 35),
(114, '2019_10_14_094709_create_budget_table', 35),
(115, '2019_10_16_122705_add_to_budget_summary_table', 36),
(116, '2019_10_16_150836_add_to_budget_summary_table2', 37),
(117, '2019_10_29_081646_add_to_budget', 38),
(118, '2019_11_13_184324_create_document_comments_table', 39),
(119, '2019_11_14_074514_add_to_documents_table', 40),
(120, '2019_11_14_095532_create_document_category_table', 41),
(121, '2019_11_20_184931_create_warehouse_inventory_table', 42),
(122, '2019_11_22_095952_add_to_news_table', 43),
(123, '2019_11_23_162953_add_to_zone_bin_table', 44),
(124, '2019_12_02_180602_create_odometer_measure_table', 45),
(125, '2019_12_02_182408_create_vehicle_workshop_table', 45),
(126, '2019_12_03_094641_add_to_vehicle_workshop_table', 46),
(127, '2019_12_04_095001_add_to_vehicle_service_log_table', 47),
(128, '2019_12_02_180602_create_vehicle_odometer_measure_table', 48),
(129, '2019_12_05_183607_create_inventory_contract_table', 49),
(130, '2019_12_05_183636_create_inventory_contract_type_table', 49),
(131, '2019_12_05_183715_create_inventory_contract_status_table', 49),
(132, '2019_12_05_183742_create_inventory_contract_items_table', 49),
(133, '2019_12_06_130449_add_to_inventory_contract_table', 50),
(134, '2019_12_09_092742_add_to_inventory_contract_items_table', 51),
(135, '2019_12_11_100900_add_to_inventory_contract_table2', 52),
(136, '2019_12_12_162455_add_to_inventory_contract_table3', 53),
(137, '2019_12_12_162546_add_to_inventory_contract_items_table3', 53),
(138, '2019_12_13_105145_add_to_inventory_contract_table4', 54),
(139, '2019_12_15_183543_add_to_payroll_table', 55),
(140, '2019_12_17_201610_add_to_payroll_table3', 56),
(141, '2020_01_11_152239_create_budget_request_tracking_table', 57),
(145, '2020_01_23_140019_add_to_whse_pick_put_away_table', 58),
(146, '2020_01_14_161345_create_sales_order_table', 59),
(147, '2020_01_14_163326_create_sales_extention_table', 59),
(148, '2020_01_26_175903_add_to_warehouse_shipment_table', 60),
(149, '2020_01_26_191412_add_to_sales_extention_table', 61),
(150, '2020_02_12_130407_add_to_warehouse_shipment_table2', 62),
(151, '2020_02_13_103222_add_to_stock_table', 63),
(153, '2020_03_03_072920_add_to_users_table', 64),
(154, '2020_03_18_130337_add_to_journal_extention_table', 65),
(155, '2020_03_19_101121_add_to_account_journal_table', 66),
(156, '2020_03_19_110826_add_to_account_journal_table2', 67),
(157, '2020_03_19_111040_add_to_journal_extention_table3', 67),
(158, '2020_03_19_135054_add_to_journal_extention4', 68),
(159, '2020_03_19_151428_create_account_status_table', 69),
(160, '2020_03_22_131709_add_to_journal_extention5', 70),
(161, '2020_03_22_131821_add_to_account_journal3', 70),
(162, '2020_03_23_222244_create_journal_transaction_terms_table', 71),
(163, '2020_03_23_222426_create_journal_transaction_format_table', 71),
(164, '2020_03_23_223022_create_journal_default_transaction_account_table', 71),
(165, '2020_03_24_112255_add_to_journal_default_transaction_account', 72),
(166, '2020_03_25_122545_add_to_journal_default_transaction_account', 73),
(167, '2020_03_29_113009_add_to_account_chart', 74),
(168, '2020_03_29_125447_add_to5_journal_extention', 74),
(169, '2020_03_29_125534_add_to5_account_journal', 74),
(170, '2020_03_29_140137_add_to_account_chart_2', 75),
(171, '2020_04_01_130550_modify_account_journal', 76),
(172, '2020_04_01_132710_modify_journal_extention_2', 76),
(173, '2020_04_01_145210_add_to_account_journal', 77),
(174, '2020_04_01_162555_add_to_account_journal', 78),
(175, '2020_04_03_103125_add_to_journal_default_account_transaction', 79),
(176, '2020_04_03_110913_add_to_account_journal', 80),
(177, '2020_04_03_111722_add_to_account_journal', 81),
(178, '2020_04_06_124818_add_to_journal_extention', 82),
(179, '2020_04_11_214540_add_to_journal_extention', 83),
(180, '2020_04_21_123053_add_to_account_journal', 84),
(181, '2020_05_23_090646_create_bank_reconciliation_table', 85),
(182, '2020_05_27_124755_add_to_users_table', 86),
(183, '2020_06_01_213808_add_to_journal_extention', 87),
(184, '2020_06_01_214825_add_to_journal_extention', 88),
(185, '2020_06_01_215510_add_to_journal_extention', 89),
(186, '2020_07_05_194805_modify_to_journal_extention_table', 90),
(187, '2020_07_06_014021_modify_journal_extention_table', 91),
(189, '2020_07_12_101530_add_index_to_currency_table', 92),
(190, '2020_07_12_102437_add_index_to_exchange_rate_table', 93),
(191, '2020_07_12_102621_add_index_to_account_chart_table', 94),
(192, '2020_07_12_102913_add_index_to_account_journal_table', 95),
(193, '2020_07_12_103609_add_index_to_journal_extention_table', 96),
(194, '2020_07_12_104312_add_index_to_financial_year_table', 97),
(195, '2020_07_12_184454_add_to_trans_class_table', 98),
(196, '2020_07_20_131201_add_to_account_journal_table', 99),
(197, '2020_07_20_132350_add_to_journal_extenstion_table', 99),
(198, '2020_08_03_185609_add_to_journal_extention_table', 100),
(199, '2020_08_08_192424_create_bank_reconciliation_table', 101),
(200, '2020_08_08_192801_add_to_account_journal_table', 101),
(201, '2020_08_09_201812_add_to_bank_reconciliation_table', 102),
(202, '2020_08_19_191659_add_to_bank_reconciliation_table', 103),
(203, '2020_08_20_224350_add_to_bank_reconciliation_table', 104),
(204, '2020_08_21_142953_create_external_payroll_table', 105),
(205, '2020_08_21_155836_add_to_payroll_table', 105),
(206, '2020_08_21_213519_add_to_temp_users_table', 106),
(207, '2020_09_01_112223_rename_jobs_table', 107),
(208, '2020_09_01_112705_create_jobs_table', 108),
(209, '2020_09_01_115000_create_failed_jobs_table', 109),
(210, '2020_09_29_125651_modify_users_table', 110);

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `milestone_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `milestone_desc` longtext COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `milestone_status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milestone_items`
--

CREATE TABLE `milestone_items` (
  `id` int(11) NOT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `list_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_desc` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `embed_video` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `component` longtext,
  `user_id` int(11) NOT NULL,
  `gross_pay` varchar(20) DEFAULT NULL,
  `total_amount` varchar(22) DEFAULT NULL,
  `tax_amount` varchar(30) DEFAULT NULL,
  `curr_id` int(11) DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) DEFAULT NULL,
  `bonus_deduc` varchar(22) NOT NULL,
  `bonus_deduc_desc` longtext,
  `bonus_deduc_type` int(11) DEFAULT '0',
  `sal_adv_deduct` varchar(20) DEFAULT NULL,
  `loan_deduct` varchar(20) DEFAULT NULL,
  `payroll_status` int(11) NOT NULL,
  `process_date` date DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `week` varchar(45) DEFAULT NULL,
  `month` varchar(22) DEFAULT NULL,
  `pay_year` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `physical_inv_count`
--

CREATE TABLE `physical_inv_count` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `code_desc` varchar(50) NOT NULL,
  `value` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_extention`
--

CREATE TABLE `po_extention` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `assigned_user` varchar(11) DEFAULT NULL,
  `po_number` varchar(100) DEFAULT NULL,
  `vendor_invoice_no` varchar(30) DEFAULT NULL,
  `sum_total` varchar(100) NOT NULL,
  `trans_total` varchar(100) NOT NULL,
  `discount_total` varchar(50) DEFAULT NULL,
  `discount_trans` varchar(50) DEFAULT NULL,
  `tax_total` varchar(20) DEFAULT NULL,
  `tax_trans` varchar(20) DEFAULT NULL,
  `tax_type` int(11) DEFAULT NULL,
  `tax_perct` varchar(10) DEFAULT NULL,
  `discount_perct` varchar(10) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `message` longtext,
  `attachment` longtext,
  `ex_rate` int(11) DEFAULT NULL,
  `curr_date` datetime DEFAULT NULL,
  `default_curr` int(11) DEFAULT NULL,
  `trans_curr` int(11) DEFAULT NULL,
  `vendor` int(11) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `ship_to_city` varchar(100) DEFAULT NULL,
  `ship_address` varchar(100) DEFAULT NULL,
  `ship_to_country` varchar(100) DEFAULT NULL,
  `ship_to_contact` varchar(100) DEFAULT NULL,
  `ship_method` varchar(100) DEFAULT NULL,
  `ship_agent` varchar(100) DEFAULT NULL,
  `purchase_status` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `rfq_no` varchar(50) DEFAULT NULL,
  `mails` longtext,
  `mail_copy` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_name` varchar(225) NOT NULL,
  `project_desc` varchar(255) NOT NULL,
  `project_head` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `budget` varchar(100) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `project_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_docs`
--

CREATE TABLE `project_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `doc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_member_request`
--

CREATE TABLE `project_member_request` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `assigned_user` varchar(11) DEFAULT NULL,
  `temp_user` varchar(11) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `details` longtext,
  `response` longtext,
  `response_status` int(11) DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_team`
--

CREATE TABLE `project_team` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(50) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `temp_user` varchar(20) DEFAULT NULL,
  `user_type` int(11) DEFAULT '1',
  `project_access` int(11) DEFAULT NULL,
  `team_lead` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `po_desc` varchar(255) DEFAULT NULL,
  `unit_measurement` varchar(50) DEFAULT NULL,
  `bin_stock` int(11) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `reserved_quantity` varchar(50) DEFAULT NULL,
  `received_quantity` varchar(50) DEFAULT NULL,
  `planned_receipt_date` varchar(20) DEFAULT NULL,
  `expected_receipt_date` varchar(20) DEFAULT NULL,
  `promised_receipt_date` varchar(20) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `unit_cost` varchar(50) DEFAULT NULL,
  `unit_cost_trans` varchar(50) DEFAULT NULL,
  `tax_amount_trans` varchar(50) DEFAULT NULL,
  `discount_amount_trans` varchar(50) DEFAULT NULL,
  `extended_amount_trans` varchar(50) DEFAULT NULL,
  `extended_amount` varchar(50) DEFAULT NULL,
  `discount_perct` varchar(20) DEFAULT NULL,
  `discount_amount` varchar(50) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `tax_perct` varchar(20) DEFAULT NULL,
  `tax_amount` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `requisition_id` int(11) DEFAULT '0',
  `po_status` varchar(100) DEFAULT NULL,
  `po_status_comment` longtext,
  `status_comment_history` longtext,
  `blanket_order_no` varchar(50) DEFAULT NULL,
  `blanket_order_line_no` varchar(50) DEFAULT NULL,
  `ship_to_whse` int(11) DEFAULT NULL,
  `receipt_status` int(11) DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `put_away_template`
--

CREATE TABLE `put_away_template` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `put_away_desc` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quick_note`
--

CREATE TABLE `quick_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `id` int(11) NOT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `quote_desc` varchar(255) DEFAULT NULL,
  `unit_measurement` varchar(50) DEFAULT NULL,
  `bin_stock` int(11) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `unit_cost` varchar(50) DEFAULT NULL,
  `unit_cost_trans` varchar(50) DEFAULT NULL,
  `tax_amount_trans` varchar(50) DEFAULT NULL,
  `discount_amount_trans` varchar(50) DEFAULT NULL,
  `extended_amount_trans` varchar(50) DEFAULT NULL,
  `extended_amount` varchar(50) DEFAULT NULL,
  `discount_perct` varchar(20) DEFAULT NULL,
  `discount_amount` varchar(50) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `tax_perct` varchar(20) DEFAULT NULL,
  `tax_amount` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `requisition_id` int(11) DEFAULT '0',
  `po_status` varchar(100) DEFAULT NULL,
  `po_status_comment` longtext,
  `status_comment_history` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quote_extention`
--

CREATE TABLE `quote_extention` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `assigned_user` varchar(11) DEFAULT NULL,
  `quote_number` varchar(100) DEFAULT NULL,
  `sum_total` varchar(100) NOT NULL,
  `trans_total` varchar(100) NOT NULL,
  `discount_total` varchar(50) DEFAULT NULL,
  `discount_trans` varchar(50) DEFAULT NULL,
  `tax_total` varchar(20) DEFAULT NULL,
  `tax_trans` varchar(20) DEFAULT NULL,
  `tax_type` int(11) DEFAULT NULL,
  `tax_perct` varchar(10) DEFAULT NULL,
  `discount_perct` varchar(10) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `message` longtext,
  `attachment` longtext,
  `ex_rate` int(11) DEFAULT NULL,
  `curr_date` datetime DEFAULT NULL,
  `default_curr` int(11) DEFAULT NULL,
  `trans_curr` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `ship_to_city` varchar(100) DEFAULT NULL,
  `ship_address` varchar(100) DEFAULT NULL,
  `ship_to_country` varchar(100) DEFAULT NULL,
  `ship_to_contact` varchar(100) DEFAULT NULL,
  `ship_method` varchar(100) DEFAULT NULL,
  `ship_agent` varchar(100) DEFAULT NULL,
  `quote_status` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `mails` longtext,
  `mail_copy` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_category`
--

CREATE TABLE `request_category` (
  `id` int(11) NOT NULL,
  `acct_id` int(11) NOT NULL,
  `request_name` varchar(225) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `general` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_category`
--

INSERT INTO `request_category` (`id`, `acct_id`, `request_name`, `dept_id`, `general`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 2, 'Salary Advance', 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 'Employee Loans', 0, 1, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE `request_type` (
  `id` int(11) NOT NULL,
  `request_type` varchar(225) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_type`
--

INSERT INTO `request_type` (`id`, `request_type`, `status`) VALUES
(1, 'Usual', 1),
(2, 'Project', 1);

-- --------------------------------------------------------

--
-- Table structure for table `requisition`
--

CREATE TABLE `requisition` (
  `id` int(11) NOT NULL,
  `acct_cat` int(11) NOT NULL,
  `req_cat` int(11) NOT NULL,
  `req_type` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL DEFAULT '0',
  `req_desc` varchar(225) NOT NULL,
  `edit_request` varchar(255) DEFAULT NULL,
  `hr_accessible` int(11) DEFAULT NULL,
  `accessible_status` int(11) DEFAULT NULL,
  `loan_balance` varchar(100) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `loan_monthly_deduc` varchar(22) DEFAULT NULL,
  `amount` varchar(225) NOT NULL,
  `curr_id` int(11) NOT NULL,
  `default_curr` int(11) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `approval_json` longtext NOT NULL,
  `approval_level` longtext NOT NULL,
  `approval_user` longtext NOT NULL,
  `approved_users` varchar(255) DEFAULT NULL,
  `approval_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `deny_reason` varchar(225) DEFAULT NULL,
  `approval_id` int(11) NOT NULL,
  `approval_status` int(11) NOT NULL,
  `request_user` int(11) NOT NULL,
  `dept_req_user` int(11) NOT NULL,
  `deny_user` int(11) NOT NULL DEFAULT '0',
  `complete_status` int(11) NOT NULL DEFAULT '0',
  `finance_status` int(11) DEFAULT '0',
  `attachment` longtext NOT NULL,
  `views` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rfq`
--

CREATE TABLE `rfq` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `unit_measurement` varchar(100) DEFAULT NULL,
  `rfq_desc` longtext,
  `rfq_id` varchar(100) NOT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rfq_extention`
--

CREATE TABLE `rfq_extention` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `rfq_no` varchar(50) DEFAULT NULL,
  `due_date` date NOT NULL,
  `message` longtext,
  `attachment` longtext,
  `vendor_message` longtext,
  `mails` longtext,
  `mail_copy` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `risks`
--

CREATE TABLE `risks` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `risk_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `probability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detectability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trigger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contingency_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_desc`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Controller', 'Controller', '1', '2017-11-15 23:00:00', NULL),
(2, 'Management', 'Software manager', '1', NULL, NULL),
(3, 'Administrator', 'System administrator', '1', NULL, NULL),
(4, 'Regular User', 'employees', '1', NULL, NULL),
(5, 'Accountant', 'Accountant', '1', NULL, NULL),
(6, 'HR', 'Human Resource', '1', NULL, NULL),
(7, 'Manpower', 'Outsourcing', '1', NULL, NULL),
(8, 'External Users/Contractor', 'External Users', '1', NULL, NULL),
(9, 'Supply Chain/Procurement', 'Supply Chain and Procurement of materials', '1', '2018-07-31 07:00:00', '2018-07-31 01:15:00'),
(10, 'Warehouse manager', 'Manages the warehouse', '1', '2018-07-31 07:16:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `salary_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_pay` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_pay` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `component` longtext COLLATE utf8mb4_unicode_ci,
  `payroll_view` longtext COLLATE utf8mb4_unicode_ci,
  `tax_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_category`
--

CREATE TABLE `salary_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `salary_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_component`
--

CREATE TABLE `salary_component` (
  `id` int(11) NOT NULL,
  `comp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comp_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_extention`
--

CREATE TABLE `sales_extention` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `vendor_po_no` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sum_total` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_total` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_total` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_total` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_perct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_perct` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ex_rate` int(11) DEFAULT NULL,
  `curr_date` date DEFAULT NULL,
  `default_curr` int(11) DEFAULT NULL,
  `trans_curr` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `ship_to_city` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_address` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_to_country` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_to_contact` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_method` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mails` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_copy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `sales_desc` text COLLATE utf8mb4_unicode_ci,
  `unit_measurement` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bin_stock` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserved_quantity` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipped_quantity` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `planned_ship_date` date DEFAULT NULL,
  `expected_ship_date` date DEFAULT NULL,
  `promised_ship_date` date DEFAULT NULL,
  `unit_cost` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_cost_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extended_amount_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount_trans` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extended_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_perct` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_perct` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `requisition_id` int(11) DEFAULT NULL,
  `sales_status` int(11) DEFAULT NULL,
  `sales_status_comment` text COLLATE utf8mb4_unicode_ci,
  `status_comment_history` text COLLATE utf8mb4_unicode_ci,
  `blanket_order_no` text COLLATE utf8mb4_unicode_ci,
  `blanket_order_line_no` text COLLATE utf8mb4_unicode_ci,
  `ship_to_whse` text COLLATE utf8mb4_unicode_ci,
  `ship_status` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ship_details`
--

CREATE TABLE `ship_details` (
  `id` int(11) NOT NULL,
  `ship_to_whse` int(11) DEFAULT NULL,
  `ship_to_country` int(11) DEFAULT NULL,
  `ship_to_city` varchar(100) DEFAULT NULL,
  `ship_to_contact` varchar(100) DEFAULT NULL,
  `ship_type` varchar(100) DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `promised_receipt_date` date DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `ship_agent` varchar(100) DEFAULT NULL,
  `ship_method` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `skill_competency_frame_cat`
--

CREATE TABLE `skill_competency_frame_cat` (
  `id` int(11) NOT NULL,
  `skill_comp` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skill_competency_frame_cat`
--

INSERT INTO `skill_competency_frame_cat` (`id`, `skill_comp`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Academic/Professional Requirements', 1, '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(2, 'Technical Competencies', 1, '2018-04-06 00:00:00', '0000-00-00 00:00:00'),
(3, 'Behavioral Competencies', 1, '2018-04-06 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `skill_comp_cat`
--

CREATE TABLE `skill_comp_cat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_comp_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `cat_desc` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `qty` varchar(20) NOT NULL,
  `qty_remain` varchar(20) NOT NULL DEFAULT '0',
  `purchase_date` varchar(50) DEFAULT NULL,
  `sales_date` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(11) NOT NULL,
  `survey_name` varchar(50) DEFAULT NULL,
  `survey_desc` longtext,
  `all_dept` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `uptdated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_access`
--

CREATE TABLE `survey_access` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_ans_cat`
--

CREATE TABLE `survey_ans_cat` (
  `id` int(11) NOT NULL,
  `category_name` longtext NOT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_quest`
--

CREATE TABLE `survey_quest` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `question` longtext NOT NULL,
  `text_type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_quest_ans`
--

CREATE TABLE `survey_quest_ans` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `ans_cat_id` int(11) NOT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `alphabet` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_quest_cat`
--

CREATE TABLE `survey_quest_cat` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_session`
--

CREATE TABLE `survey_session` (
  `id` int(11) NOT NULL,
  `session_name` varchar(100) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `user_status` int(5) NOT NULL DEFAULT '0',
  `temp_user_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_temp_user_ans`
--

CREATE TABLE `survey_temp_user_ans` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `text_answer` longtext,
  `text_type` int(5) NOT NULL,
  `quest_cat_id` int(11) NOT NULL,
  `ans_cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey_user_ans`
--

CREATE TABLE `survey_user_ans` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `ans_id` int(11) DEFAULT NULL,
  `text_answer` longtext,
  `text_type` int(11) NOT NULL,
  `quest_cat_id` int(11) NOT NULL,
  `ans_cat_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_user` varchar(22) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `milestone_id` int(11) DEFAULT NULL,
  `task_list_id` int(11) DEFAULT NULL,
  `task_docs` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_items`
--

CREATE TABLE `task_items` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_lists`
--

CREATE TABLE `task_lists` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `list_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_desc` longtext COLLATE utf8mb4_unicode_ci,
  `list_status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `tax_name` varchar(255) NOT NULL,
  `sum_percentage` varchar(11) NOT NULL,
  `component` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_roles`
--

CREATE TABLE `temp_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_desc` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_roles`
--

INSERT INTO `temp_roles` (`id`, `role_name`, `role_desc`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Exam/Job Candidate', 'Job candidate for interview', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Contract Staff', 'external employees on contract', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Client', 'Client for partaking in survey', 1, '2019-06-07 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `temp_users`
--

CREATE TABLE `temp_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discipline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_issue_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bupa_hmo_expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `green_card_expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_category` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `all_dept` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_category`
--

CREATE TABLE `test_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `duration` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_question`
--

CREATE TABLE `test_question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `text_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_quest_ans`
--

CREATE TABLE `test_quest_ans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `correct_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_session`
--

CREATE TABLE `test_session` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `session_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_status` int(11) NOT NULL,
  `temp_user_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_temp_user_ans`
--

CREATE TABLE `test_temp_user_ans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `text_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_answer` longtext COLLATE utf8mb4_unicode_ci,
  `correct_status` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_user_ans`
--

CREATE TABLE `test_user_ans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `text_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_answer` longtext COLLATE utf8mb4_unicode_ci,
  `correct_status` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_category`
--

CREATE TABLE `ticket_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE `timesheet` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `temp_user` int(11) DEFAULT NULL,
  `work_hours` varchar(100) DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `timesheet_title` varchar(100) DEFAULT NULL,
  `timesheet_desc` longtext,
  `attachment` longtext,
  `approved_by` int(11) DEFAULT NULL,
  `approval_status` int(2) DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `training_name` varchar(255) DEFAULT NULL,
  `training_desc` varchar(255) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `vendor` varchar(225) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_order`
--

CREATE TABLE `transfer_order` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `from_whse` int(11) NOT NULL DEFAULT '0',
  `from_zone` int(11) DEFAULT '0',
  `from_bin` int(11) DEFAULT '0',
  `from_location` varchar(100) DEFAULT NULL,
  `from_contact` varchar(100) DEFAULT NULL,
  `ship_date` date DEFAULT NULL,
  `ship_agent` varchar(100) DEFAULT NULL,
  `ship_duration` varchar(50) DEFAULT NULL,
  `ship_method` varchar(100) DEFAULT NULL,
  `out_hand_time` varchar(20) NOT NULL,
  `to_whse` int(11) DEFAULT '0',
  `to_zone` int(11) DEFAULT NULL,
  `to_bin` int(11) DEFAULT '0',
  `receipt_date` date DEFAULT NULL,
  `to_location` varchar(100) DEFAULT NULL,
  `to_contact` varchar(100) DEFAULT NULL,
  `in_hand_time` varchar(20) DEFAULT NULL,
  `vendor_ship_no` varchar(50) DEFAULT NULL,
  `assigned_user_receipt` int(11) DEFAULT '0',
  `assigned_date_time_receipt` datetime DEFAULT NULL,
  `sorting_method_receipt` varchar(100) DEFAULT NULL,
  `assigned_user_ship` int(11) DEFAULT '0',
  `assigned_date_time_ship` datetime DEFAULT NULL,
  `sorting_method_ship` varchar(100) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `item_desc` longtext,
  `qty` varchar(20) DEFAULT NULL,
  `qty_to_ship` varchar(20) DEFAULT NULL,
  `reserved_qty` varchar(20) DEFAULT NULL,
  `reserved_qty_ship` varchar(20) DEFAULT NULL,
  `reserved_qty_inbound` varchar(20) DEFAULT NULL,
  `qty_to_receive` varchar(20) DEFAULT NULL,
  `qty_received` varchar(20) DEFAULT '0',
  `qty_remaining` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_class`
--

CREATE TABLE `trans_class` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_desc` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_location`
--

CREATE TABLE `trans_location` (
  `id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unique_indi_goal`
--

CREATE TABLE `unique_indi_goal` (
  `id` int(11) NOT NULL,
  `goal_name` varchar(225) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_goals`
--

CREATE TABLE `unit_goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goal_set_id` int(11) NOT NULL,
  `unit_goal_cat` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `program` longtext,
  `appraisal_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `weight_perf_score` varchar(22) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_goal_cat`
--

CREATE TABLE `unit_goal_cat` (
  `id` int(11) NOT NULL,
  `category_name` varchar(222) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(22) NOT NULL,
  `updated_by` varchar(22) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_goal_cat`
--

INSERT INTO `unit_goal_cat` (`id`, `category_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'financials', 1, '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Customers', 1, '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Internal Processes', 1, '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Learning', 1, '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `unit_goal_ext`
--

CREATE TABLE `unit_goal_ext` (
  `id` int(11) NOT NULL,
  `unit_goal_id` int(11) NOT NULL,
  `strat_obj` longtext,
  `measurement` longtext,
  `q1` longtext,
  `q2` varchar(225) DEFAULT NULL,
  `q3` varchar(225) DEFAULT NULL,
  `q4` varchar(225) DEFAULT NULL,
  `over_perf_score` longtext,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_goal_series`
--

CREATE TABLE `unit_goal_series` (
  `id` int(10) UNSIGNED NOT NULL,
  `goal_name` varchar(225) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_measure`
--

CREATE TABLE `unit_measure` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employ_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_kin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_kin_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local_govt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employ_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate_dept` int(11) NOT NULL DEFAULT '0',
  `resign_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `email`, `password`, `other_email`, `role`, `firstname`, `lastname`, `othername`, `sex`, `dob`, `phone`, `job_role`, `address`, `employ_type`, `position_id`, `dept_id`, `salary_id`, `nationality`, `marital`, `blood_group`, `next_kin`, `next_kin_phone`, `state`, `local_govt`, `emergency_name`, `emergency_phone`, `emergency_contact`, `photo`, `sign`, `title`, `qualification`, `employ_date`, `affiliate_dept`, `resign_date`, `active_status`, `status`, `remember_token`, `created_by`, `created_at`, `updated_by`, `updated_at`, `religion`) VALUES
(1, '2147483647', 'Snweze@hyprops.com', '$2y$10$1HS5A2C30Nex/OByxRFDeOtxHYxnTTfJmSukkJZ7aCY.iiADbHK32', '', '1', 'Solomon', 'Nweze', '', 'Male', '2019-08-22', '', '', '', 'Permanent', '2', '8', '1', '', 'Single', '', '', '', '', '', '', '', NULL, 'user.png', '2018-07-25-08-59-11_code-2434271_960_720.jpg', '', '', '', 0, NULL, '1', '1', 'pdLfy3J0XvEpIJJJmAsCr4aw036UuUmCzynpUkXnMlQP2Q3ymj6CkfA3O80d', '1', '2017-11-17 09:19:26', 'Solomon Nweze', '2020-03-18 08:58:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_pin_code`
--

CREATE TABLE `user_pin_code` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `number_times` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `license_plate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chasis_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `registration_due_date` date DEFAULT NULL,
  `purchase_price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seat_number` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doors` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colour` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmission` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horsepower` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_category`
--

CREATE TABLE `vehicle_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_contract`
--

CREATE TABLE `vehicle_contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `contract_type` int(11) DEFAULT NULL,
  `contract_status` int(11) DEFAULT NULL,
  `recurring_cost` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `recurring_interval` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage_start` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mileage_end` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_cost` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contractor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_contract_types`
--

CREATE TABLE `vehicle_contract_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_fleet_access`
--

CREATE TABLE `vehicle_fleet_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_fuel_log`
--

CREATE TABLE `vehicle_fuel_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `liter` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_liter` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `mileage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `invoice_reference` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_station` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_fuel_station`
--

CREATE TABLE `vehicle_fuel_station` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_maintenance_reminder`
--

CREATE TABLE `vehicle_maintenance_reminder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_types` text COLLATE utf8mb4_unicode_ci,
  `mileage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_reminder` date DEFAULT NULL,
  `next_reminder` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_maintenance_schedule`
--

CREATE TABLE `vehicle_maintenance_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reminder_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mileage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_make`
--

CREATE TABLE `vehicle_make` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_model`
--

CREATE TABLE `vehicle_model` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_odometer`
--

CREATE TABLE `vehicle_odometer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `start_mileage` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `end_mileage` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_date` date DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_mileage` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_odometer_measure`
--

CREATE TABLE `vehicle_odometer_measure` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_service_log`
--

CREATE TABLE `vehicle_service_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `service_type` int(11) DEFAULT NULL,
  `mileage_in` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `mileage_out` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `invoice_reference` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workshop` int(11) DEFAULT NULL,
  `docs` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_service_types`
--

CREATE TABLE `vehicle_service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_status`
--

CREATE TABLE `vehicle_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_workshop`
--

CREATE TABLE `vehicle_workshop` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_customer`
--

CREATE TABLE `vendor_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip_code` varchar(50) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `search_key` varchar(100) DEFAULT NULL,
  `company_desc` longtext,
  `website` varchar(50) DEFAULT NULL,
  `email1` varchar(50) DEFAULT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `company_no` varchar(50) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `tax_id_no` int(11) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `company_type` int(11) DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `post_code` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fax` varchar(50) NOT NULL,
  `whse_manager` int(11) DEFAULT NULL,
  `default_bin_select` int(11) DEFAULT NULL,
  `outb_whse_hd_time` varchar(50) DEFAULT NULL,
  `inb_whse_hd_time` varchar(50) DEFAULT NULL,
  `cross_dock` varchar(50) DEFAULT NULL,
  `cross_dock_due_date_calc` varchar(50) DEFAULT NULL,
  `receipt_bin_code` int(11) DEFAULT NULL,
  `adjust_bin_code` int(11) DEFAULT NULL,
  `ship_bin_code` int(11) DEFAULT NULL,
  `open_shop_floor_bin_code` int(11) DEFAULT NULL,
  `to_prod_bin_code` int(11) DEFAULT NULL,
  `from_prod_bin_code` int(11) DEFAULT NULL,
  `cross_dock_bin_code` int(11) DEFAULT NULL,
  `to_assembly_bin_code` int(11) DEFAULT NULL,
  `from_assembly_bin_code` int(11) DEFAULT NULL,
  `assembly_to_order_ship_bin_code` int(11) DEFAULT NULL,
  `special_equip` varchar(50) DEFAULT NULL,
  `bin_capacity_policy` varchar(50) DEFAULT NULL,
  `allow_break_bulk` varchar(50) DEFAULT NULL,
  `put_away_template_code` varchar(100) DEFAULT NULL,
  `put_away_line` varchar(100) DEFAULT NULL,
  `pick_line` varchar(100) DEFAULT NULL,
  `pick_feffo` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_employee`
--

CREATE TABLE `warehouse_employee` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_inventory`
--

CREATE TABLE `warehouse_inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `bin_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_receipt`
--

CREATE TABLE `warehouse_receipt` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `receipt_no` int(11) DEFAULT NULL,
  `whse_id` int(11) NOT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `bin_id` int(11) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `vendor_ship_no` varchar(50) DEFAULT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `assign_time` varchar(20) DEFAULT NULL,
  `sorting_method` varchar(100) DEFAULT NULL,
  `po_id` int(11) NOT NULL,
  `po_ext_id` int(11) DEFAULT NULL,
  `qty` varchar(20) DEFAULT NULL,
  `qty_to_receive` varchar(20) DEFAULT NULL,
  `qty_to_cross_dock` varchar(20) DEFAULT NULL,
  `qty_received` varchar(20) DEFAULT NULL,
  `qty_outstanding` varchar(20) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `work_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_shipment`
--

CREATE TABLE `warehouse_shipment` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `sales_ext_id` int(11) DEFAULT NULL,
  `sales_invoice_id` int(11) NOT NULL,
  `assigned_user` int(11) NOT NULL DEFAULT '0',
  `customer_ship_no` varchar(50) NOT NULL,
  `shipment_no` varchar(45) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `post_date` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `whse_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL,
  `bin_id` int(11) DEFAULT NULL,
  `ship_desc` longtext,
  `qty` varchar(20) DEFAULT NULL,
  `qty_to_cross_dock` varchar(20) DEFAULT NULL,
  `sorting_method` int(11) DEFAULT NULL,
  `qty_to_ship` varchar(20) DEFAULT NULL,
  `pick_qty` varchar(20) DEFAULT NULL,
  `qty_picked` varchar(20) DEFAULT NULL,
  `qty_shipped` varchar(20) DEFAULT NULL,
  `qty_outstanding` varchar(20) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `work_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_zone`
--

CREATE TABLE `warehouse_zone` (
  `id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `whse_pick_put_away`
--

CREATE TABLE `whse_pick_put_away` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `po_ext_id` int(11) DEFAULT NULL,
  `sales_ext_id` int(11) DEFAULT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `pick_put_type` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `to_whse` int(11) DEFAULT NULL,
  `to_zone` int(11) DEFAULT NULL,
  `to_bin` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `qty_to_handle` int(11) DEFAULT NULL,
  `qty_handled` int(11) DEFAULT NULL,
  `qty_outstanding` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `pick_put_status` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `zone_desc` longtext,
  `bin_id` int(11) DEFAULT NULL,
  `special_equip` varchar(100) DEFAULT NULL,
  `zone_ranking` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zone_bin`
--

CREATE TABLE `zone_bin` (
  `id` int(11) NOT NULL,
  `warehouse_id` varchar(11) DEFAULT NULL,
  `zone_id` int(11) NOT NULL,
  `bin_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` varchar(22) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_request`
--
ALTER TABLE `access_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_category`
--
ALTER TABLE `account_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_chart`
--
ALTER TABLE `account_chart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_chart_acct_cat_id_index` (`acct_cat_id`),
  ADD KEY `account_chart_detail_id_index` (`detail_id`),
  ADD KEY `account_chart_curr_id_index` (`curr_id`),
  ADD KEY `account_chart_status_index` (`status`),
  ADD KEY `account_chart_active_status_index` (`active_status`);

--
-- Indexes for table `account_journal`
--
ALTER TABLE `account_journal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `uid_2` (`uid`),
  ADD KEY `acct_cat_id` (`acct_cat_id`),
  ADD KEY `detail_id` (`detail_id`),
  ADD KEY `chart_id` (`chart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `vendor_customer` (`vendor_customer`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `chart_id_2` (`chart_id`),
  ADD KEY `uid_3` (`uid`),
  ADD KEY `acct_cat_id_2` (`acct_cat_id`),
  ADD KEY `chart_id_3` (`chart_id`),
  ADD KEY `detail_id_2` (`detail_id`),
  ADD KEY `extension_id` (`extension_id`),
  ADD KEY `fin_year` (`fin_year`),
  ADD KEY `class_id_2` (`class_id`),
  ADD KEY `account_journal_uid_index` (`uid`),
  ADD KEY `account_journal_extension_id_index` (`extension_id`),
  ADD KEY `account_journal_acct_cat_id_index` (`acct_cat_id`),
  ADD KEY `account_journal_detail_id_index` (`detail_id`),
  ADD KEY `account_journal_account_id_index` (`account_id`),
  ADD KEY `account_journal_chart_id_index` (`chart_id`),
  ADD KEY `account_journal_item_id_index` (`item_id`),
  ADD KEY `account_journal_fin_year_index` (`fin_year`),
  ADD KEY `account_journal_class_id_index` (`class_id`),
  ADD KEY `account_journal_location_id_index` (`location_id`),
  ADD KEY `account_journal_vendor_customer_index` (`vendor_customer`),
  ADD KEY `account_journal_debit_credit_index` (`debit_credit`),
  ADD KEY `account_journal_transaction_type_index` (`transaction_type`),
  ADD KEY `account_journal_reconcile_status_index` (`reconcile_status`),
  ADD KEY `account_journal_post_date_index` (`post_date`),
  ADD KEY `account_journal_status_index` (`status`),
  ADD KEY `account_journal_employee_id_index` (`employee_id`);

--
-- Indexes for table `account_status`
--
ALTER TABLE `account_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_approval_dept`
--
ALTER TABLE `admin_approval_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_approval_sys`
--
ALTER TABLE `admin_approval_sys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_category`
--
ALTER TABLE `admin_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_requisition`
--
ALTER TABLE `admin_requisition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_supervision`
--
ALTER TABLE `appraisal_supervision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval_system`
--
ALTER TABLE `approval_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assump_constraints`
--
ALTER TABLE `assump_constraints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assump_constraints_comments`
--
ALTER TABLE `assump_constraints_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_reconciliation`
--
ALTER TABLE `bank_reconciliation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `behav_comp`
--
ALTER TABLE `behav_comp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_method`
--
ALTER TABLE `bill_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin`
--
ALTER TABLE `bin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_type`
--
ALTER TABLE `bin_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_request_tracking`
--
ALTER TABLE `budget_request_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_summary`
--
ALTER TABLE `budget_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_logs`
--
ALTER TABLE `change_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_log_comments`
--
ALTER TABLE `change_log_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing_books`
--
ALTER TABLE `closing_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_assess`
--
ALTER TABLE `competency_assess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_framework`
--
ALTER TABLE `competency_framework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_map`
--
ALTER TABLE `competency_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_activity`
--
ALTER TABLE `crm_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_activity_types`
--
ALTER TABLE `crm_activity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_lead`
--
ALTER TABLE `crm_lead`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_notes`
--
ALTER TABLE `crm_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_opportunity`
--
ALTER TABLE `crm_opportunity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_sales_cycle`
--
ALTER TABLE `crm_sales_cycle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_sales_team`
--
ALTER TABLE `crm_sales_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_stages`
--
ALTER TABLE `crm_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `currency_status_index` (`status`),
  ADD KEY `currency_active_status_index` (`active_status`),
  ADD KEY `currency_code_index` (`code`),
  ADD KEY `currency_default_curr_status_index` (`default_curr_status`);

--
-- Indexes for table `debit_credit`
--
ALTER TABLE `debit_credit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decisions`
--
ALTER TABLE `decisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decision_comments`
--
ALTER TABLE `decision_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverables`
--
ALTER TABLE `deliverables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverable_comments`
--
ALTER TABLE `deliverable_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dept_approvals`
--
ALTER TABLE `dept_approvals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_type`
--
ALTER TABLE `detail_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discuss`
--
ALTER TABLE `discuss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discuss_comments`
--
ALTER TABLE `discuss_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_category`
--
ALTER TABLE `document_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_comments`
--
ALTER TABLE `document_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_rate`
--
ALTER TABLE `exchange_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `exchange_rate_status_index` (`status`);

--
-- Indexes for table `external_payroll`
--
ALTER TABLE `external_payroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `external_payroll_user_id_index` (`user_id`),
  ADD KEY `external_payroll_salary_id_index` (`salary_id`),
  ADD KEY `external_payroll_dept_id_index` (`dept_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_year`
--
ALTER TABLE `financial_year`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_year_fin_date_index` (`fin_date`),
  ADD KEY `financial_year_active_status_index` (`active_status`),
  ADD KEY `financial_year_status_index` (`status`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hris_approval_sys`
--
ALTER TABLE `hris_approval_sys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hse_access`
--
ALTER TABLE `hse_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hse_reports`
--
ALTER TABLE `hse_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hse_source_type`
--
ALTER TABLE `hse_source_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idp`
--
ALTER TABLE `idp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idp_competency`
--
ALTER TABLE `idp_competency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indi_goals`
--
ALTER TABLE `indi_goals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indi_goal_cat`
--
ALTER TABLE `indi_goal_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indi_objectives`
--
ALTER TABLE `indi_objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_access`
--
ALTER TABLE `inventory_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_assign`
--
ALTER TABLE `inventory_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_bom`
--
ALTER TABLE `inventory_bom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_cat`
--
ALTER TABLE `inventory_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_contract`
--
ALTER TABLE `inventory_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_contract_items`
--
ALTER TABLE `inventory_contract_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_contract_status`
--
ALTER TABLE `inventory_contract_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_contract_type`
--
ALTER TABLE `inventory_contract_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_record`
--
ALTER TABLE `inventory_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_type`
--
ALTER TABLE `inventory_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`(191));

--
-- Indexes for table `jobs_access`
--
ALTER TABLE `jobs_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applicants`
--
ALTER TABLE `job_applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_list`
--
ALTER TABLE `job_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_default_transaction_account`
--
ALTER TABLE `journal_default_transaction_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_extention`
--
ALTER TABLE `journal_extention`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `journal_extention_uid_index` (`uid`),
  ADD KEY `journal_extention_journal_id_index` (`journal_id`),
  ADD KEY `journal_extention_file_no_index` (`file_no`),
  ADD KEY `journal_extention_journal_status_index` (`journal_status`),
  ADD KEY `journal_extention_balance_status_index` (`balance_status`),
  ADD KEY `journal_extention_due_date_index` (`due_date`),
  ADD KEY `journal_extention_class_id_index` (`class_id`),
  ADD KEY `journal_extention_location_id_index` (`location_id`),
  ADD KEY `journal_extention_vendor_customer_index` (`vendor_customer`),
  ADD KEY `journal_extention_transaction_type_index` (`transaction_type`),
  ADD KEY `journal_extention_reconcile_status_index` (`reconcile_status`),
  ADD KEY `journal_extention_post_date_index` (`post_date`),
  ADD KEY `journal_extention_status_index` (`status`),
  ADD KEY `journal_extention_employee_id_index` (`employee_id`);

--
-- Indexes for table `journal_transaction_format`
--
ALTER TABLE `journal_transaction_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_transaction_terms`
--
ALTER TABLE `journal_transaction_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_approval`
--
ALTER TABLE `leave_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_log`
--
ALTER TABLE `leave_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons_learnt`
--
ALTER TABLE `lessons_learnt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestone_items`
--
ALTER TABLE `milestone_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `physical_inv_count`
--
ALTER TABLE `physical_inv_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_extention`
--
ALTER TABLE `po_extention`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_docs`
--
ALTER TABLE `project_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_member_request`
--
ALTER TABLE `project_member_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_team`
--
ALTER TABLE `project_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `put_away_template`
--
ALTER TABLE `put_away_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quick_note`
--
ALTER TABLE `quick_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote_extention`
--
ALTER TABLE `quote_extention`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_category`
--
ALTER TABLE `request_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisition`
--
ALTER TABLE `requisition`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rfq`
--
ALTER TABLE `rfq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfq_extention`
--
ALTER TABLE `rfq_extention`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risks`
--
ALTER TABLE `risks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_category`
--
ALTER TABLE `salary_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_component`
--
ALTER TABLE `salary_component`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_extention`
--
ALTER TABLE `sales_extention`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ship_details`
--
ALTER TABLE `ship_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill_competency_frame_cat`
--
ALTER TABLE `skill_competency_frame_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill_comp_cat`
--
ALTER TABLE `skill_comp_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_access`
--
ALTER TABLE `survey_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_ans_cat`
--
ALTER TABLE `survey_ans_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_quest`
--
ALTER TABLE `survey_quest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_quest_ans`
--
ALTER TABLE `survey_quest_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_quest_cat`
--
ALTER TABLE `survey_quest_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_session`
--
ALTER TABLE `survey_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_temp_user_ans`
--
ALTER TABLE `survey_temp_user_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_user_ans`
--
ALTER TABLE `survey_user_ans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_items`
--
ALTER TABLE `task_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_lists`
--
ALTER TABLE `task_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_roles`
--
ALTER TABLE `temp_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_users`
--
ALTER TABLE `temp_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temp_users_salary_id_index` (`salary_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_category`
--
ALTER TABLE `test_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_question`
--
ALTER TABLE `test_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_quest_ans`
--
ALTER TABLE `test_quest_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_session`
--
ALTER TABLE `test_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_temp_user_ans`
--
ALTER TABLE `test_temp_user_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_user_ans`
--
ALTER TABLE `test_user_ans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_user_ans_cat_id_test_id_session_id_user_id_created_at_index` (`cat_id`,`test_id`,`session_id`,`user_id`,`created_at`);

--
-- Indexes for table `ticket_category`
--
ALTER TABLE `ticket_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_order`
--
ALTER TABLE `transfer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_class`
--
ALTER TABLE `trans_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_location`
--
ALTER TABLE `trans_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unique_indi_goal`
--
ALTER TABLE `unique_indi_goal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_goals`
--
ALTER TABLE `unit_goals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_goal_cat`
--
ALTER TABLE `unit_goal_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_goal_ext`
--
ALTER TABLE `unit_goal_ext`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_goal_series`
--
ALTER TABLE `unit_goal_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_measure`
--
ALTER TABLE `unit_measure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pin_code`
--
ALTER TABLE `user_pin_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_contract`
--
ALTER TABLE `vehicle_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_contract_types`
--
ALTER TABLE `vehicle_contract_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_fleet_access`
--
ALTER TABLE `vehicle_fleet_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_fuel_log`
--
ALTER TABLE `vehicle_fuel_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_fuel_station`
--
ALTER TABLE `vehicle_fuel_station`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_maintenance_reminder`
--
ALTER TABLE `vehicle_maintenance_reminder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_maintenance_schedule`
--
ALTER TABLE `vehicle_maintenance_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_make`
--
ALTER TABLE `vehicle_make`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_model`
--
ALTER TABLE `vehicle_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_odometer`
--
ALTER TABLE `vehicle_odometer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_odometer_measure`
--
ALTER TABLE `vehicle_odometer_measure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_service_log`
--
ALTER TABLE `vehicle_service_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_service_types`
--
ALTER TABLE `vehicle_service_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_status`
--
ALTER TABLE `vehicle_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_workshop`
--
ALTER TABLE `vehicle_workshop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_customer`
--
ALTER TABLE `vendor_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_employee`
--
ALTER TABLE `warehouse_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `warehouse_inventory`
--
ALTER TABLE `warehouse_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_receipt`
--
ALTER TABLE `warehouse_receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `whse_id` (`whse_id`),
  ADD KEY `receipt_id` (`receipt_no`);

--
-- Indexes for table `warehouse_shipment`
--
ALTER TABLE `warehouse_shipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `warehouse_zone`
--
ALTER TABLE `warehouse_zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whse_pick_put_away`
--
ALTER TABLE `whse_pick_put_away`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone_bin`
--
ALTER TABLE `zone_bin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_request`
--
ALTER TABLE `access_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_category`
--
ALTER TABLE `account_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `account_chart`
--
ALTER TABLE `account_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `account_journal`
--
ALTER TABLE `account_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_status`
--
ALTER TABLE `account_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_approval_dept`
--
ALTER TABLE `admin_approval_dept`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_approval_sys`
--
ALTER TABLE `admin_approval_sys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_category`
--
ALTER TABLE `admin_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_requisition`
--
ALTER TABLE `admin_requisition`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appraisal_supervision`
--
ALTER TABLE `appraisal_supervision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_system`
--
ALTER TABLE `approval_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assump_constraints`
--
ALTER TABLE `assump_constraints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assump_constraints_comments`
--
ALTER TABLE `assump_constraints_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_reconciliation`
--
ALTER TABLE `bank_reconciliation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `behav_comp`
--
ALTER TABLE `behav_comp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_method`
--
ALTER TABLE `bill_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bin`
--
ALTER TABLE `bin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bin_type`
--
ALTER TABLE `bin_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_request_tracking`
--
ALTER TABLE `budget_request_tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `budget_summary`
--
ALTER TABLE `budget_summary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_logs`
--
ALTER TABLE `change_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_log_comments`
--
ALTER TABLE `change_log_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `closing_books`
--
ALTER TABLE `closing_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competency_assess`
--
ALTER TABLE `competency_assess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competency_framework`
--
ALTER TABLE `competency_framework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competency_map`
--
ALTER TABLE `competency_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `crm_activity`
--
ALTER TABLE `crm_activity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_activity_types`
--
ALTER TABLE `crm_activity_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_lead`
--
ALTER TABLE `crm_lead`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_notes`
--
ALTER TABLE `crm_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_opportunity`
--
ALTER TABLE `crm_opportunity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_sales_cycle`
--
ALTER TABLE `crm_sales_cycle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_sales_team`
--
ALTER TABLE `crm_sales_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_stages`
--
ALTER TABLE `crm_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `debit_credit`
--
ALTER TABLE `debit_credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `decisions`
--
ALTER TABLE `decisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `decision_comments`
--
ALTER TABLE `decision_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliverables`
--
ALTER TABLE `deliverables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliverable_comments`
--
ALTER TABLE `deliverable_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dept_approvals`
--
ALTER TABLE `dept_approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_type`
--
ALTER TABLE `detail_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `discuss`
--
ALTER TABLE `discuss`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discuss_comments`
--
ALTER TABLE `discuss_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_category`
--
ALTER TABLE `document_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_comments`
--
ALTER TABLE `document_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchange_rate`
--
ALTER TABLE `exchange_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=846;

--
-- AUTO_INCREMENT for table `external_payroll`
--
ALTER TABLE `external_payroll`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_year`
--
ALTER TABLE `financial_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hris_approval_sys`
--
ALTER TABLE `hris_approval_sys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hse_access`
--
ALTER TABLE `hse_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hse_reports`
--
ALTER TABLE `hse_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hse_source_type`
--
ALTER TABLE `hse_source_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idp`
--
ALTER TABLE `idp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idp_competency`
--
ALTER TABLE `idp_competency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indi_goals`
--
ALTER TABLE `indi_goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indi_goal_cat`
--
ALTER TABLE `indi_goal_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `indi_objectives`
--
ALTER TABLE `indi_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_access`
--
ALTER TABLE `inventory_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_assign`
--
ALTER TABLE `inventory_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_contract`
--
ALTER TABLE `inventory_contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_contract_items`
--
ALTER TABLE `inventory_contract_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_contract_status`
--
ALTER TABLE `inventory_contract_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_contract_type`
--
ALTER TABLE `inventory_contract_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs_access`
--
ALTER TABLE `jobs_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applicants`
--
ALTER TABLE `job_applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_list`
--
ALTER TABLE `job_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_default_transaction_account`
--
ALTER TABLE `journal_default_transaction_account`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_extention`
--
ALTER TABLE `journal_extention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_transaction_format`
--
ALTER TABLE `journal_transaction_format`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_transaction_terms`
--
ALTER TABLE `journal_transaction_terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_log`
--
ALTER TABLE `leave_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons_learnt`
--
ALTER TABLE `lessons_learnt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milestone_items`
--
ALTER TABLE `milestone_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `physical_inv_count`
--
ALTER TABLE `physical_inv_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `po_extention`
--
ALTER TABLE `po_extention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_docs`
--
ALTER TABLE `project_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_member_request`
--
ALTER TABLE `project_member_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_team`
--
ALTER TABLE `project_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `put_away_template`
--
ALTER TABLE `put_away_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quick_note`
--
ALTER TABLE `quick_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_extention`
--
ALTER TABLE `quote_extention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_category`
--
ALTER TABLE `request_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `request_type`
--
ALTER TABLE `request_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requisition`
--
ALTER TABLE `requisition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rfq`
--
ALTER TABLE `rfq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rfq_extention`
--
ALTER TABLE `rfq_extention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risks`
--
ALTER TABLE `risks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_category`
--
ALTER TABLE `salary_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_component`
--
ALTER TABLE `salary_component`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_extention`
--
ALTER TABLE `sales_extention`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ship_details`
--
ALTER TABLE `ship_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skill_competency_frame_cat`
--
ALTER TABLE `skill_competency_frame_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skill_comp_cat`
--
ALTER TABLE `skill_comp_cat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_access`
--
ALTER TABLE `survey_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_ans_cat`
--
ALTER TABLE `survey_ans_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_quest`
--
ALTER TABLE `survey_quest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_quest_ans`
--
ALTER TABLE `survey_quest_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_quest_cat`
--
ALTER TABLE `survey_quest_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_session`
--
ALTER TABLE `survey_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_temp_user_ans`
--
ALTER TABLE `survey_temp_user_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_user_ans`
--
ALTER TABLE `survey_user_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_items`
--
ALTER TABLE `task_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_lists`
--
ALTER TABLE `task_lists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_roles`
--
ALTER TABLE `temp_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_users`
--
ALTER TABLE `temp_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_category`
--
ALTER TABLE `test_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_question`
--
ALTER TABLE `test_question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_quest_ans`
--
ALTER TABLE `test_quest_ans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_session`
--
ALTER TABLE `test_session`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_temp_user_ans`
--
ALTER TABLE `test_temp_user_ans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_user_ans`
--
ALTER TABLE `test_user_ans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_category`
--
ALTER TABLE `ticket_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timesheet`
--
ALTER TABLE `timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_order`
--
ALTER TABLE `transfer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_class`
--
ALTER TABLE `trans_class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_location`
--
ALTER TABLE `trans_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unique_indi_goal`
--
ALTER TABLE `unique_indi_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_goals`
--
ALTER TABLE `unit_goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_goal_cat`
--
ALTER TABLE `unit_goal_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_goal_ext`
--
ALTER TABLE `unit_goal_ext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_goal_series`
--
ALTER TABLE `unit_goal_series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_measure`
--
ALTER TABLE `unit_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_pin_code`
--
ALTER TABLE `user_pin_code`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_contract`
--
ALTER TABLE `vehicle_contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_contract_types`
--
ALTER TABLE `vehicle_contract_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_fleet_access`
--
ALTER TABLE `vehicle_fleet_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_fuel_log`
--
ALTER TABLE `vehicle_fuel_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_fuel_station`
--
ALTER TABLE `vehicle_fuel_station`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_maintenance_reminder`
--
ALTER TABLE `vehicle_maintenance_reminder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_maintenance_schedule`
--
ALTER TABLE `vehicle_maintenance_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_make`
--
ALTER TABLE `vehicle_make`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_model`
--
ALTER TABLE `vehicle_model`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_odometer`
--
ALTER TABLE `vehicle_odometer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_odometer_measure`
--
ALTER TABLE `vehicle_odometer_measure`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_service_log`
--
ALTER TABLE `vehicle_service_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_service_types`
--
ALTER TABLE `vehicle_service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_status`
--
ALTER TABLE `vehicle_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_workshop`
--
ALTER TABLE `vehicle_workshop`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_customer`
--
ALTER TABLE `vendor_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_employee`
--
ALTER TABLE `warehouse_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_inventory`
--
ALTER TABLE `warehouse_inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_receipt`
--
ALTER TABLE `warehouse_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_shipment`
--
ALTER TABLE `warehouse_shipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse_zone`
--
ALTER TABLE `warehouse_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whse_pick_put_away`
--
ALTER TABLE `whse_pick_put_away`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zone_bin`
--
ALTER TABLE `zone_bin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
