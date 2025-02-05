<?php

function logmsg($message, $priority = LOG_INFO)
{
    syslog($priority, "unraid-tailscale: {$message}");
}

$plugin = "tailscale";
$ifname = 'tailscale1';

$config_file        = '/boot/config/plugins/tailscale/tailscale.cfg';
$defaults_file      = '/usr/local/emhttp/plugins/tailscale/settings.json';
$network_extra_file = '/boot/config/network-extra.cfg';

// Load configuration file
if (file_exists($config_file)) {
    $tailscale_config = parse_ini_file($config_file);
}

// Load default settings and assign values
$settings_config = json_decode(file_get_contents($defaults_file), true);
foreach ($settings_config as $key => $value) {
    if ( ! isset($tailscale_config[$key])) {
        $tailscale_config[$key] = $value['default'];
    }
}
