<?php
/**
 * @package RealEstateACFPlugin
 */

/*
Plugin Name: RealEstate ACF Plugin
Plugin URI: https://github.com/Oljacic/realestate-acf-plugin
Description: This plugin is for testing my skills and ability to nail a job!
Version: 1.0.0
Author: Stefan "Stef" Oljacic
License: GPLv2 or latter
Text Domain: realestate-acf-plugin
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

defined('ABSPATH') or die('Hi there! What are you doing here, you can\' access this file, you silly human?');

class RealEstateACFPlugin
{
    function __construct() {
        add_action('init', array($this, 'custom_post_type'));
    }

    function activate() {
        // generate a CPT
        $this->custom_post_type();
        // flush rewrite rules
        flush_rewrite_rules();
    }

    function deactivate() {
        // flush rewrite rules
        flush_rewrite_rules();
    }

    function custom_post_type() {
        register_post_type('real_estate', [
            'public' => true,
            'label'  => 'Real Estate'
        ]);
    }
}

if (class_exists('RealEstateACFPlugin')){
    $realEstateACFPlugin = new RealEstateACFPlugin();
}

// activation
register_activation_hook(__FILE__, array($realEstateACFPlugin, 'activate'));

// deactivation
register_deactivation_hook(__FILE__, array($realEstateACFPlugin, 'deactivate'));

//just for purpose of testing to see if evreything is working fine