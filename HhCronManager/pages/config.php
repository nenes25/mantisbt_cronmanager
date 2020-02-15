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
auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));
layout_page_header(plugin_lang_get('title'));
layout_page_begin();
print_manage_menu();
#Define Base url
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . $domainName;
$helpUrl = "https://www.github.com";
$crons = event_signal('EVENT_PLUGIN_HHCRONMANAGER_COLLECT_CRON');
?>
    <div class="col-md-12 col-xs-12">
        <div class="space-10"></div>
        <div class="form-container">
                <div class="widget-box widget-color-blue2">
                    <div class="widget-header widget-header-small">
                        <h4 class="widget-title lighter">
                            <?php echo plugin_lang_get('config_title') ?>
                        </h4>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="alert alert-info">
                            <?php echo sprintf(plugin_lang_get('config_description'),$baseUrl.plugin_page('cron')); ?>
                        </div>
                    </div>

                    <div class="widget-box widget-color-blue2" style="margin-top:20px;">
                        <div class="widget-header widget-header-small">
                            <h4 class="widget-title lighter">
                                <?php echo plugin_lang_get('config_list') ?>
                            </h4>
                        </div>
                    </div>
                    <table class="table" style="margin-top:20px;">
                        <thead>
                            <tr class="table-header">
                                <th><?php echo lang_get('plugin');?></th>
                                <th><?php echo plugin_lang_get('config_cron_code');?></th>
                                <th><?php echo plugin_lang_get('config_cron_frequency');?></th>
                                <th><?php echo plugin_lang_get('config_cron_url');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ( is_array($crons) && count($crons) > 0): ?>
                                <?php
                                foreach ( $crons as $plugin => $function):
                                    foreach ( $function as $tasks):
                                        foreach ($tasks as $task): ?>
                                        <tr>
                                            <td><?php echo $task['plugin']; ?></td>
                                            <td><?php echo $task['code'];?></td>
                                            <td><?php echo $task['frequency'];?></td>
                                            <td><?php echo plugin_page($task['url'],false,$task['plugin']);?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php else:?>
                                <tr>
                                    <td colspan="4" align="center">
                                        <?php echo sprintf(plugin_lang_get('config_list_no_tasks'),$helpUrl,$helpUrl);?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
<?php
layout_page_end();