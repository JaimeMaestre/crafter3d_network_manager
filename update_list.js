document.addEventListener('DOMContentLoaded', () => {
    const refreshButton = document.getElementById('refresh-button');
    const stopAutoRefreshButton = document.getElementById('stop-auto-refresh-button');
    const availableNetworksTable = document.getElementById('available-networks');
    const countdownElement = document.getElementById('countdown');

    let autoRefreshInterval;
    let countdown = 60;

    const updateCountdown = () => {
        countdownElement.textContent = countdown;
        countdown--;
        if (countdown < 0) {
            countdown = 60;
            updateAvailableNetworks();
        }
    };

    const startAutoRefresh = () => {
        autoRefreshInterval = setInterval(updateCountdown, 1000);
    };

    const stopAutoRefresh = () => {
        clearInterval(autoRefreshInterval);
        countdownElement.textContent = 'Stopped';
    };

    const updateAvailableNetworks = () => {
        fetch('fetch_available_networks.php')
            .then(response => response.text())
            .then(data => {
                availableNetworksTable.innerHTML = data;
                countdown = 60; // Reset countdown after manual refresh
            })
            .catch(error => console.error('Error fetching available networks:', error));
    };

    // Attach event listeners
    refreshButton.addEventListener('click', updateAvailableNetworks);
    stopAutoRefreshButton.addEventListener('click', stopAutoRefresh);

    // Start auto-refresh on page load
    startAutoRefresh();
});
