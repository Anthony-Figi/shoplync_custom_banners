<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$sql = array();

$sql[0] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'shoplync_banner_position` (
    `position_id` int(11) NOT NULL AUTO_INCREMENT,
    `position_name` varchar(30) NOT NULL,
    `position_order` int(11),
    `hook_name` varchar(30),
    `description` varchar(255),
    `enabled` boolean DEFAULT TRUE,
    PRIMARY KEY  (`position_id`),
    UNIQUE KEY `unique_position_order` (position_order)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'; 

$sql[1] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'shoplync_banner_types` (
    `banner_type` varchar(30) NOT NULL,
    `type_name` varchar(30) NOT NULL,
    `template_path` varchar(255) NOT NULL,
    PRIMARY KEY  (`banner_type`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[2] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'shoplync_custom_banners` (
    `banner_id` int(11) NOT NULL AUTO_INCREMENT,
    `banner_name` varchar(30) NOT NULL,
    `position` int(11) NOT NULL,
    `visible` boolean DEFAULT TRUE,
    `banner_type` varchar(30) NOT NULL,
    PRIMARY KEY  (`banner_id`),
    FOREIGN KEY (`position`) REFERENCES ' . _DB_PREFIX_ . 'shoplync_banner_position(`position_id`),
    FOREIGN KEY (`banner_type`) REFERENCES ' . _DB_PREFIX_ . 'shoplync_banner_types(`banner_type`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'; 

$sql[3] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'shoplync_banner_data` (
    `banner_data_id` int(11) NOT NULL AUTO_INCREMENT,
    `banner_id` int(11) NOT NULL,
    `custom_style` varchar(255),
    `image_path` varchar(255),
    `banner_text` varchar(255),
    `raw_html` varchar(255),
    PRIMARY KEY  (`banner_data_id`),
    UNIQUE KEY `unique_banner_id` (banner_id),
    FOREIGN KEY (`banner_id`) REFERENCES ' . _DB_PREFIX_ . 'shoplync_custom_banners(`banner_id`) ON DELETE CASCADE
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

//--Insert defaults for Banner Position--
$sql[4] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_position(position_name, position_order, hook_name, description)
    VALUES("Top Page Banner", 1, "displayBanner", "Displays at the very top of the webpage.") ON DUPLICATE KEY UPDATE hook_name = "displayBanner";';
    
$sql[5] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_position(position_name, position_order, hook_name, description)
    VALUES("Top Header Banner", 2, "displayTop", "Displays in the header area below the searchbar.") ON DUPLICATE KEY UPDATE hook_name = "displayTop";';    
    
$sql[6] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_position(position_name, position_order, hook_name, description)
    VALUES("Navigation Menu Banner", 3, "displayNavFullWidth", "Displays below the top header navigation menu bar.") ON DUPLICATE KEY UPDATE hook_name = "displayNavFullWidth";';    
    
$sql[7] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_position(position_name, position_order, hook_name, description)
    VALUES("Product Footer Banner", 4, "displayFooterProduct", "Displays a banner at the bottom page while viewing a product.") ON DUPLICATE KEY UPDATE hook_name = "displayFooterProduct";';    
    
$sql[8] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_position(position_name, position_order, hook_name, description)
    VALUES("Bottom Page Footer Banner", 5, "displayFooter", "Displays a banner in the footer area of the page.") ON DUPLICATE KEY UPDATE hook_name = "displayFooter";';

//--Insert defaults for Banner Types--
$sql[9] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_types(banner_type, type_name, template_path)
    VALUES("ImageBanner", "Image Only", "views/templates/front/img-only.tpl") ON DUPLICATE KEY UPDATE banner_type = "ImageBanner";';
    
$sql[10] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_types(banner_type, type_name, template_path)
    VALUES("TextBanner", "Text Only", "views/templates/front/text-only.tpl") ON DUPLICATE KEY UPDATE banner_type = "TextBanner";';
    
$sql[11] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_types(banner_type, type_name, template_path)
    VALUES("HtmlBanner", "Raw HTML Banner", "views/templates/front/raw-html.tpl") ON DUPLICATE KEY UPDATE banner_type = "HtmlBanner";';
    
$sql[12] = 'INSERT INTO ' . _DB_PREFIX_ . 'shoplync_banner_types(banner_type, type_name, template_path)
    VALUES("Default", "Default Test Banner", "views/templates/front/default.tpl") ON DUPLICATE KEY UPDATE banner_type = "Default";';


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

