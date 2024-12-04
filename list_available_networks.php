<?php
// Fetch current connections
$current_connections = shell_exec("nmcli -t -f NAME connection show");
$current_connections = explode("\n", trim($current_connections));

// Check if form data is submitted to connect to a new network
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connect_ssid'])) {
    $ssid = escapeshellarg($_POST['connect_ssid']);
    $password = !empty($_POST['password'][$_POST['connect_ssid']])
        ? escapeshellarg($_POST['password'][$_POST['connect_ssid']])
        : '';

    // Attempt to connect to the network
    if ($password) {
        $result = shell_exec("sudo nmcli device wifi connect $ssid password $password 2>&1");
    } else {
        $result = shell_exec("sudo nmcli device wifi connect $ssid 2>&1");
    }

    // Display feedback
    if (strpos($result, 'successfully activated') !== false) {
        echo "<p class='success'>Successfully connected to $ssid.</p>";
        shell_exec("sudo reboot");
    } else {
        echo "<p class='error'>Failed to connect to $ssid. Error: $result</p>";
    }
}

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
