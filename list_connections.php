<?php
$connections = shell_exec("nmcli -t -f NAME connection show");
$connections = explode("\n", trim($connections));
foreach ($connections as $name) {
    if (!empty($name) and $name!='Crafter3D' and $name!='Wired connection 1' and $name!='preconfigured' and $name!='lo') {
        echo "<tr>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['forget_ssid'])) {
    $forget_ssid = escapeshellarg($_POST['forget_ssid']);
    shell_exec("sudo nmcli connection delete id $forget_ssid");
}
?>
