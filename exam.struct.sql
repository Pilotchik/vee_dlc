-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 23 2014 г., 10:45
-- Версия сервера: 5.5.35-1
-- Версия PHP: 5.5.9-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `exam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `new_annul`
--

DROP TABLE IF EXISTS `new_annul`;
CREATE TABLE IF NOT EXISTS `new_annul` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `person_id` int(255) NOT NULL,
  `data` varchar(50) NOT NULL,
  `result` varchar(50) NOT NULL,
  `razd_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=439 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_answers`
--

DROP TABLE IF EXISTS `new_answers`;
CREATE TABLE IF NOT EXISTS `new_answers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `text` longtext NOT NULL,
  `quest_t` longtext NOT NULL,
  `true` int(9) NOT NULL,
  `vopros_id` int(255) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT '0',
  `del` int(5) NOT NULL DEFAULT '0',
  `success` float NOT NULL DEFAULT '0',
  `option_1` float NOT NULL DEFAULT '0',
  `option_2` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7379 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_comps`
--

DROP TABLE IF EXISTS `new_comps`;
CREATE TABLE IF NOT EXISTS `new_comps` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `prof_activity` text NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1',
  `del` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_comps_contributions`
--

DROP TABLE IF EXISTS `new_comps_contributions`;
CREATE TABLE IF NOT EXISTS `new_comps_contributions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `compet_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `discipline_id` int(10) NOT NULL,
  `expert_id` int(10) NOT NULL,
  `contribution` int(4) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `del` int(1) NOT NULL DEFAULT '0',
  `contr_proz` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_comps_image`
--

DROP TABLE IF EXISTS `new_comps_image`;
CREATE TABLE IF NOT EXISTS `new_comps_image` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `compet_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(10) NOT NULL,
  `balls` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=298 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_conf`
--

DROP TABLE IF EXISTS `new_conf`;
CREATE TABLE IF NOT EXISTS `new_conf` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rate_resort` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_courses`
--

DROP TABLE IF EXISTS `new_courses`;
CREATE TABLE IF NOT EXISTS `new_courses` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` int(2) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `kod` varchar(50) NOT NULL,
  `del` int(2) NOT NULL DEFAULT '0',
  `data` varchar(60) NOT NULL,
  `test_id` int(20) NOT NULL,
  `time_avg` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_crs_results`
--

DROP TABLE IF EXISTS `new_crs_results`;
CREATE TABLE IF NOT EXISTS `new_crs_results` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `timebeg` int(30) NOT NULL,
  `timeend` int(30) NOT NULL DEFAULT '0',
  `data` varchar(70) NOT NULL,
  `proz` float NOT NULL DEFAULT '0',
  `balls` float NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_feedback`
--

DROP TABLE IF EXISTS `new_feedback`;
CREATE TABLE IF NOT EXISTS `new_feedback` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `uri_string` text NOT NULL,
  `message` text NOT NULL,
  `data` varchar(60) NOT NULL,
  `time` int(20) NOT NULL,
  `to` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_forms`
--

DROP TABLE IF EXISTS `new_forms`;
CREATE TABLE IF NOT EXISTS `new_forms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `author_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `access` int(3) NOT NULL,
  `description` text NOT NULL,
  `type_r` int(10) NOT NULL DEFAULT '1',
  `del` int(2) NOT NULL DEFAULT '0',
  `active` int(2) NOT NULL DEFAULT '1',
  `public_res` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_form_answers`
--

DROP TABLE IF EXISTS `new_form_answers`;
CREATE TABLE IF NOT EXISTS `new_form_answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quest_id` int(10) NOT NULL,
  `res_id` int(10) NOT NULL,
  `answer` text NOT NULL,
  `option` text NOT NULL,
  `option_7` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7871 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_form_quests`
--

DROP TABLE IF EXISTS `new_form_quests`;
CREATE TABLE IF NOT EXISTS `new_form_quests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `subtitle` text NOT NULL,
  `required` int(2) NOT NULL,
  `type` int(2) NOT NULL,
  `form_id` int(10) NOT NULL,
  `option1` text NOT NULL,
  `option2` text NOT NULL,
  `option3` text NOT NULL,
  `active` int(2) NOT NULL DEFAULT '0',
  `del` int(2) NOT NULL DEFAULT '0',
  `own_version` int(2) NOT NULL DEFAULT '1',
  `numb` int(3) NOT NULL DEFAULT '1',
  `site` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_form_results`
--

DROP TABLE IF EXISTS `new_form_results`;
CREATE TABLE IF NOT EXISTS `new_form_results` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) NOT NULL,
  `person_id` int(10) NOT NULL,
  `begin` int(11) NOT NULL DEFAULT '0',
  `end` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=749 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_lections`
--

DROP TABLE IF EXISTS `new_lections`;
CREATE TABLE IF NOT EXISTS `new_lections` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` int(2) NOT NULL DEFAULT '1',
  `comment` text NOT NULL,
  `content` longtext NOT NULL,
  `del` int(2) NOT NULL DEFAULT '0',
  `data` varchar(60) NOT NULL,
  `course_id` int(20) NOT NULL,
  `tags` text NOT NULL,
  `test_id` int(20) NOT NULL DEFAULT '0',
  `type` int(2) NOT NULL DEFAULT '0',
  `number` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_lect_results`
--

DROP TABLE IF EXISTS `new_lect_results`;
CREATE TABLE IF NOT EXISTS `new_lect_results` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `lection_id` int(20) NOT NULL,
  `timebeg` int(30) NOT NULL,
  `timeend` int(30) NOT NULL DEFAULT '0',
  `data` varchar(70) NOT NULL,
  `test_res_id` int(20) NOT NULL DEFAULT '0',
  `opinion` int(3) NOT NULL DEFAULT '0',
  `crs_res_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_log`
--

DROP TABLE IF EXISTS `new_log`;
CREATE TABLE IF NOT EXISTS `new_log` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `date` varchar(50) NOT NULL,
  `type` longtext NOT NULL,
  `time` int(50) NOT NULL DEFAULT '0',
  `goal` int(5) NOT NULL DEFAULT '1',
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=10979 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_log_status`
--

DROP TABLE IF EXISTS `new_log_status`;
CREATE TABLE IF NOT EXISTS `new_log_status` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user` int(20) NOT NULL,
  `log_type` int(3) NOT NULL,
  `count` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_materials`
--

DROP TABLE IF EXISTS `new_materials`;
CREATE TABLE IF NOT EXISTS `new_materials` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `disc_id` int(20) NOT NULL,
  `active` int(2) NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `date` varchar(50) NOT NULL,
  `del` int(2) NOT NULL,
  `url` varchar(150) NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_mat_themes`
--

DROP TABLE IF EXISTS `new_mat_themes`;
CREATE TABLE IF NOT EXISTS `new_mat_themes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mat_id` int(5) NOT NULL,
  `theme_id` int(5) NOT NULL,
  `balls` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_moder_answers`
--

DROP TABLE IF EXISTS `new_moder_answers`;
CREATE TABLE IF NOT EXISTS `new_moder_answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `answer_id` int(10) NOT NULL,
  `prepod_id` int(10) NOT NULL,
  `comment` text NOT NULL,
  `student_read` int(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `proz_before` float NOT NULL,
  `proz_after` float NOT NULL,
  `balls` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_numbers`
--

DROP TABLE IF EXISTS `new_numbers`;
CREATE TABLE IF NOT EXISTS `new_numbers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `plosh_id` int(255) NOT NULL,
  `name_numb` varchar(40) NOT NULL,
  `date_end` int(40) NOT NULL,
  `prepod_id` int(255) NOT NULL DEFAULT '16',
  `type_r` int(99) NOT NULL,
  `level` int(255) NOT NULL,
  `active` int(2) NOT NULL,
  `del` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_perevod`
--

DROP TABLE IF EXISTS `new_perevod`;
CREATE TABLE IF NOT EXISTS `new_perevod` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `person_id` int(255) NOT NULL,
  `data` varchar(30) NOT NULL,
  `group_old` int(255) NOT NULL,
  `group_new` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_persons`
--

DROP TABLE IF EXISTS `new_persons`;
CREATE TABLE IF NOT EXISTS `new_persons` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `numbgr` int(255) NOT NULL,
  `progr` int(255) NOT NULL DEFAULT '0',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL DEFAULT '0',
  `pass` varchar(50) NOT NULL,
  `data_r` varchar(50) NOT NULL,
  `gender` int(4) NOT NULL,
  `guest` int(3) NOT NULL,
  `type_r` int(10) NOT NULL,
  `old_id` int(10) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `reyt_type` int(10) NOT NULL DEFAULT '0',
  `reyting` float NOT NULL DEFAULT '0',
  `block` int(5) NOT NULL DEFAULT '0',
  `photo` varchar(100) NOT NULL DEFAULT '0',
  `middlename` varchar(50) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  `birthday` varchar(40) NOT NULL,
  `mail_adr` varchar(100) NOT NULL,
  `resume_cmpl` int(1) NOT NULL DEFAULT '0',
  `comp_image` int(1) NOT NULL DEFAULT '0',
  `resume_date` datetime NOT NULL,
  `public_status` int(1) NOT NULL DEFAULT '0',
  `isrz` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2529 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_plosh`
--

DROP TABLE IF EXISTS `new_plosh`;
CREATE TABLE IF NOT EXISTS `new_plosh` (
  `id_plosh` int(255) NOT NULL AUTO_INCREMENT,
  `name_plosh` varchar(50) NOT NULL,
  PRIMARY KEY (`id_plosh`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_portfolios`
--

DROP TABLE IF EXISTS `new_portfolios`;
CREATE TABLE IF NOT EXISTS `new_portfolios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `url` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_begin` varchar(50) NOT NULL,
  `date_end` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_prepods`
--

DROP TABLE IF EXISTS `new_prepods`;
CREATE TABLE IF NOT EXISTS `new_prepods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `active` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_present_content`
--

DROP TABLE IF EXISTS `new_present_content`;
CREATE TABLE IF NOT EXISTS `new_present_content` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `slide` int(3) NOT NULL,
  `image` text NOT NULL,
  `present_id` int(20) NOT NULL,
  `del` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_present_list`
--

DROP TABLE IF EXISTS `new_present_list`;
CREATE TABLE IF NOT EXISTS `new_present_list` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `present_name` text NOT NULL,
  `date` datetime NOT NULL,
  `del` int(1) NOT NULL DEFAULT '0',
  `public_status` int(1) NOT NULL,
  `current_slide` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_razd`
--

DROP TABLE IF EXISTS `new_razd`;
CREATE TABLE IF NOT EXISTS `new_razd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_razd` varchar(100) NOT NULL,
  `active` int(5) NOT NULL,
  `del` int(5) NOT NULL,
  `comment` longtext NOT NULL,
  `kod` varchar(20) NOT NULL,
  `data` varchar(50) NOT NULL,
  `time_long` int(50) NOT NULL,
  `test_id` int(255) NOT NULL,
  `view` int(5) NOT NULL,
  `three` int(5) NOT NULL DEFAULT '20',
  `four` int(5) NOT NULL DEFAULT '40',
  `five` int(5) NOT NULL DEFAULT '60',
  `stud_view` int(5) NOT NULL DEFAULT '0',
  `stat_date` varchar(50) NOT NULL DEFAULT '0',
  `multiplicity` float NOT NULL DEFAULT '50',
  `time_avg` int(20) NOT NULL DEFAULT '2400',
  `rnd_status` int(2) NOT NULL DEFAULT '0',
  `qual_status` float NOT NULL DEFAULT '0',
  `equability` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_results`
--

DROP TABLE IF EXISTS `new_results`;
CREATE TABLE IF NOT EXISTS `new_results` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `razd_id` int(255) NOT NULL,
  `true` double NOT NULL,
  `true_all` int(50) NOT NULL,
  `user` int(255) NOT NULL,
  `proz` double NOT NULL DEFAULT '0',
  `proz_corr` double NOT NULL DEFAULT '0',
  `timesave` int(50) NOT NULL,
  `timebeg` int(50) NOT NULL,
  `timeend` int(50) NOT NULL,
  `ban` int(50) NOT NULL,
  `data` varchar(50) NOT NULL,
  `year` int(10) NOT NULL,
  `variant` int(10) NOT NULL,
  `opinion` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4833 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_reyting`
--

DROP TABLE IF EXISTS `new_reyting`;
CREATE TABLE IF NOT EXISTS `new_reyting` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `reyt` int(50) NOT NULL,
  `isrz` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=676 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_scenaries`
--

DROP TABLE IF EXISTS `new_scenaries`;
CREATE TABLE IF NOT EXISTS `new_scenaries` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `res_id` int(50) NOT NULL,
  `quests` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2450 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_sessions`
--

DROP TABLE IF EXISTS `new_sessions`;
CREATE TABLE IF NOT EXISTS `new_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `ddos` int(4) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `new_skills`
--

DROP TABLE IF EXISTS `new_skills`;
CREATE TABLE IF NOT EXISTS `new_skills` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group` int(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_skill_descriptions`
--

DROP TABLE IF EXISTS `new_skill_descriptions`;
CREATE TABLE IF NOT EXISTS `new_skill_descriptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `skill_id` int(10) NOT NULL,
  `ball` int(2) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_stud_ans`
--

DROP TABLE IF EXISTS `new_stud_ans`;
CREATE TABLE IF NOT EXISTS `new_stud_ans` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` int(255) NOT NULL,
  `quest_id` int(255) NOT NULL,
  `answer` text NOT NULL,
  `results` int(255) NOT NULL,
  `true` float NOT NULL,
  `time` int(50) NOT NULL DEFAULT '0',
  `check` int(2) NOT NULL DEFAULT '0',
  `unix_time` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=102018 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_tests`
--

DROP TABLE IF EXISTS `new_tests`;
CREATE TABLE IF NOT EXISTS `new_tests` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name_test` varchar(100) NOT NULL,
  `data` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `prepod_id` int(255) NOT NULL,
  `active` int(20) NOT NULL,
  `del` int(20) NOT NULL,
  `type_r` int(255) NOT NULL,
  `kurs` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_themes`
--

DROP TABLE IF EXISTS `new_themes`;
CREATE TABLE IF NOT EXISTS `new_themes` (
  `id_theme` int(255) NOT NULL AUTO_INCREMENT,
  `name_th` varchar(100) NOT NULL,
  `test_id` int(255) NOT NULL,
  `del` int(5) NOT NULL,
  PRIMARY KEY (`id_theme`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=177 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_th_block`
--

DROP TABLE IF EXISTS `new_th_block`;
CREATE TABLE IF NOT EXISTS `new_th_block` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `gr_id` int(50) NOT NULL,
  `th_id` int(50) NOT NULL,
  `test_id` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_type_reg`
--

DROP TABLE IF EXISTS `new_type_reg`;
CREATE TABLE IF NOT EXISTS `new_type_reg` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `reyt_date` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_user_skills`
--

DROP TABLE IF EXISTS `new_user_skills`;
CREATE TABLE IF NOT EXISTS `new_user_skills` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `skill_id` int(10) NOT NULL,
  `balls` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1171 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_vopros`
--

DROP TABLE IF EXISTS `new_vopros`;
CREATE TABLE IF NOT EXISTS `new_vopros` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` int(10) NOT NULL,
  `theme_id` int(255) NOT NULL,
  `text` longtext NOT NULL,
  `image` varchar(150) NOT NULL DEFAULT '0',
  `razd_id` int(255) NOT NULL,
  `active` int(10) NOT NULL,
  `level` int(10) NOT NULL,
  `variant` int(10) NOT NULL,
  `del` int(5) NOT NULL DEFAULT '0',
  `code` int(10) NOT NULL DEFAULT '0',
  `incorrect` int(5) NOT NULL DEFAULT '0',
  `success` float NOT NULL DEFAULT '0',
  `number` int(50) NOT NULL DEFAULT '1',
  `original` int(20) NOT NULL DEFAULT '0',
  `avg_time` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2197 ;

-- --------------------------------------------------------

--
-- Структура таблицы `new_vopros_feedback`
--

DROP TABLE IF EXISTS `new_vopros_feedback`;
CREATE TABLE IF NOT EXISTS `new_vopros_feedback` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `quest_id` int(255) NOT NULL,
  `type` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=741 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
