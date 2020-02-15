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
           echo "Evaluate task ".$task['code'].' for plugin '.$task['plugin'].'<br />';
            try {
                if (Expression::isDue($task['frequency'])) {
                    echo "Running task ".$task['code'].' for plugin '.$task['plugin'].'<br />';
                    $curl = new Curl();
                    $t_url = $baseUrl . plugin_page($task['url'], false, $task['plugin']);
                    $curl->get($t_url);
                    if ($curl->error) {
                        throw new Exception('Error: url ' . $t_url . ' is not valid');
                    }
                }
            } catch (UnexpectedValueException $e) {
                echo 'Invalid cron schedule ' . $task;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
