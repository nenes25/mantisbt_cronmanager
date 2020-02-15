<?php
# MantisBT - A PHP based bugtracking system
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

class HhCronManagerPlugin extends MantisPlugin
{
    /**
     * Register Plugin
     */
    public function register()
    {
        $this->name = plugin_lang_get('title');
        $this->description = plugin_lang_get('description');
        $this->page = 'config.php';

        $this->version = '0.0.1';
        $this->requires = array(
            'MantisCore' => '2.0.0',
        );

        $this->author = 'Hennes Hervé';
        $this->contact = 'contact@h-hennes.fr';
        $this->url = 'https://www.h-hennes.fr/blog/';
    }

    /**
     * Module configuration
     * @return array
     */
    public function config()
    {
        return parent::config();
    }

    /**
     * Module hooks
     * @return array
     */
    public function hooks()
    {
        $t_hooks = array(
            'EVENT_MENU_MAIN' => 'main_menu',
        );
        return $t_hooks;
    }

    public function events()
    {
        return array(
            'EVENT_PLUGIN_HHCRONMANAGER_COLLECT_CRON' => EVENT_TYPE_DEFAULT
        );
    }

    /**
     * plugin schema
     * @return array
     */
   /* function schema()
    {
        return array(
            array('CreateTableSQL',
                array(plugin_table('cron_manager_task'), "
	 	 		cron_id		I		NOTNULL UNSIGNED PRIMARY,
	 	 		cron_code C(100)  NOT NULL,
	 	 		cron_description C(250) NOT NULL,
	 	 		hour C(10) NOT NULL,
	 	 		day C(10) NOT NULL,
	 	 		month C(10) NOT NULL,
	 	 		day_of_week C(10) NOT NULL,
	 	 		active I NOTNULL UNSIGNED,
	 	 		created_at T		NOTNULL,
	 	 		last_run T		NOTNULL,
	 	 	    ",
                    array('mysql' => 'ENGINE=MyISAM DEFAULT CHARSET=utf8'))
            ),
        );
    }*/

    /**
     * @return bool
     */
    public function install()
    {
        return parent::install();
    }

    /**
     * Display in main menu
     */
    public function main_menu()
    {
        return array(
            array(
                'title' => plugin_lang_get('menu_title'),
                'access_level' => ADMINISTRATOR,
                'url' => plugin_page('config'),
                'icon' => 'fa-info'
            ),
        );
    }
}