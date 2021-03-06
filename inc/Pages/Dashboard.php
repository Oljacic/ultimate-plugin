<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController
{
	public $settings;
    public $callback;
    public $callback_mngr;
	public $pages = array();


	public function register() {

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();
        $this->callback_mngr = new ManagerCallbacks();

        $this->setPages();

        $this->storeSettings();
        $this->storeSections();
        $this->storeFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
	}

	public function setPages() {
        $this->pages = array(
            array(
                'page_title' => 'Ultimate Plugin',
                'menu_title' => 'Ultimate Plugin',
                'capability' => 'manage_options',
                'menu_slug'  => 'ultimate_plugin',
                'callback'   => array($this->callback, 'adminDashboard'),
                'icon_url'   => 'dashicons-admin-home',
                'position'   => 110
            )
        );
    }

    // This are classical setters but I use store
    public function storeSettings() {

        $args = array(
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'ultimate_plugin',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function storeSections() {
        $args = array(
            array(
                'id'       => 'ultimate_admin_index',
                'title'    => 'Settings Manager',
                'callback' => array($this->callback_mngr, 'adminSectionManager'),
                'page'     => 'ultimate_plugin'
            )
        );

        $this->settings->setSections($args);
    }

    public function storeFields() {

        $args = array();

        foreach ($this->managers as $key => $val) {
            $args[] = array(
                'id'       => $key,
                'title'    => $val,
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin',
                    'label_for' => $key, //always must to match ID
                    'class'     => 'ui-toggle'
                )
            );
        }

        $this->settings->setFields($args);
    }
}