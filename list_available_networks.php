<?php
// Fetch current connections
$current_connections = shell_exec("nmcli -t -f NAME connection show");
$current_connections = explode("\n", trim($current_connections));

// Fetch available networks
$networks = shell_exec("nmcli -t -f SSID,SIGNAL,SECURITY dev wifi");
$networks = explode("\n", trim($networks));

foreach ($networks as $network) {
    if (!empty($network)) {
        list($ssid, $signal, $security) = explode(':', $network);

        // Skip if already a saved connection
        if (in_array($ssid, $current_connections)) {
            continue;
        }

        // Display network row
        echo "<tr>
                <td>$ssid</td>
                <td>$signal%</td>
                <td>$security</td>
                <td>";
        if ($security !== '--') {
            echo "<input type='text' name='password[$ssid]' placeholder='Password'>";
        } else {
            echo "Open";
        }
        echo "</td>
                <td>
                    <button type='submit' name='connect_ssid' value='$ssid'>Connect</button>
                </td>
              </tr>";
    }
}
?>
