<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crafter3D Network Manager</title>
    <link rel="stylesheet" href="styles.css">
    <script src="update_list.js" defer></script>
</head>
<body>
    <header>
        <h1>Crafter3D Network Manager</h1>
    </header>
    <main>
      <!-- Section: Available Wi-Fi Networks -->
      <section>
        <h2>Available Wi-Fi Networks</h2>
        <div class="controls">
            <button id="refresh-button">Refresh List (<span id="countdown">60</span>s)</button>
            <button id="stop-auto-refresh-button">Stop Auto-Refresh</button>
        </div>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>SSID</th>
                        <th>Signal Strength</th>
                        <th>Security</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="available-networks">
                    <?php include 'list_available_networks.php'; ?>
                </tbody>
            </table>
        </form>
      </section>



        <!-- Section: Current Wi-Fi Connections -->
        <section>
            <h2>Current Wi-Fi Connections</h2>
            <table>
                <thead>
                    <tr>
                        <th>SSID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'list_connections.php'; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>© 2024 Crafter3D</p>
    </footer>
</body>
</html>
