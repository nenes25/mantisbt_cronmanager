<?php
plugin_push_current('HhCronManager');
file_put_contents(
    dirname(__FILE__).'/../logs/hearbeat.log',
    date('Y-m-d H:i:s')
);
