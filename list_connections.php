<?php
// Get all saved connections
$connections = shell_exec("nmcli -t -f NAME connection show");
$connections = explode("\n", trim($connections));

// Get the name of the currently active connection
$active_connection = trim(shell_exec("nmcli -t -f NAME connection show --active"));
// Remove unwanted words from the active connection
$unwanted_words = ['Crafter3D', 'Wired connection 1', 'lo'];
$active_connection = str_replace($unwanted_words, '', $active_connection);
$active_connection = trim($active_connection); // Remove any extra spaces

foreach ($connections as $name) {
    if (!empty($name) && $name != 'Crafter3D' && $name != 'Wired connection 1' && $name != 'lo') {
        // Highlight the active connection
        $highlight = ($name === $active_connection) ? "class='active-connection'" : "";

        echo "<tr $highlight>
                <td>$name</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='forget_ssid' value='$name'>
                        <button type='submit'>Forget</button>
                    </form>
                </td>
              </tr>";
    }
}

// Handle forgetting a connection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['forget_ssid'])) {
    $forget_ssid = escapeshellarg($_POST['forget_ssid']);
    shell_exec("sudo nmcli connection delete id $forget_ssid");
}
?>
