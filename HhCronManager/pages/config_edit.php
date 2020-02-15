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

form_security_validate(plugin_get_current() . '_config');

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

$f_change_heartbeat = gpc_get_int('enable_heartbeat');
$f_change_debug = gpc_get_int('enable_debug');

if (plugin_config_get('enable_heartbeat') != $f_change_heartbeat) {
    plugin_config_set('enable_heartbeat', $f_change_heartbeat);
}

if (plugin_config_get('enable_debug') != $f_change_debug) {
    plugin_config_set('enable_debug', $f_change_debug);
}

print_successful_redirect(plugin_page('config', true));
