<?php
$current_connections = shell_exec("nmcli -t -f NAME connection show");
$current_connections = explode("\n", trim($current_connections));

$networks = shell_exec("nmcli -t -f SSID,SIGNAL,SECURITY dev wifi");
$networks = explode("\n", trim($networks));

foreach ($networks as $network) {
    if (!empty($network)) {
        list($ssid, $signal, $security) = explode(':', $network);
        if (in_array($ssid, $current_connections)) {
            continue;
        }
        echo "<tr>
                <td>$ssid</td>
                <td>$signal%</td>
                <td>$security</td>
              </tr>";
    }
}
?>
