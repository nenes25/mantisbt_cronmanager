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

#Load composer Autoload
include_once dirname(__FILE__) . '/../vendor/autoload.php';

use Ahc\Cron\Expression;
use Curl\Curl;

#Define Base url
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . $domainName;

#Push cron module
plugin_push_current('HhCronManager');

#Get cron task from others plugins with a event
$crons = event_signal('EVENT_PLUGIN_HHCRONMANAGER_COLLECT_CRON');

foreach ($crons as $plugin => $function) {

    foreach ( $function as $tasks) {

        foreach ($tasks as $task) {
           logDebug("Evaluate task ".$task['code'].' for plugin '.$task['plugin']);
            try {
                if (Expression::isDue($task['frequency'])) {
                    logDebug("Running task ".$task['code'].' for plugin '.$task['plugin']);
                    $curl = new Curl();
                    $t_url = $baseUrl . plugin_page($task['url'], false, str_replace('Plugin','',$task['plugin']));
                    logDebug("Opening url ".$t_url);
                    $content = $curl->get($t_url);
                    if ($curl->error) {
                        throw new Exception('Error: url ' . $t_url . ' is not valid');
                    }
                }
            } catch (UnexpectedValueException $e) {
                logDebug('ERROR : Invalid cron schedule ' . $task);
            } catch (Exception $e) {
                logDebug('ERROR :'.$e->getMessage());
            }
        }
    }
}

/**
 * Affichage du message de debug
 * @param $message
 */
function logDebug($message)
{
    if( plugin_config_get(HhCronManagerPlugin::CONFIGURATION_KEY_ENABLE_DEBUG)){
        file_put_contents(
            dirname(__FILE__).'/../logs/debug.log',
            date('Y-m-d H:i:s').' '.$message."\n",
            FILE_APPEND
        );
    }
}
