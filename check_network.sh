#!/bin/bash

# Sleep for 30 seconds before starting
#sleep 2

# Check the network connection state
network_state=$(sudo nmcli -t -f STATE general)
active_connection=$(sudo nmcli -t -f NAME,DEVICE con show --active | grep wlan0 | awk -F: '{print $1}')
crafter3d_state=$(sudo nmcli connection show --active | grep "Crafter3D" | wc -l)
echo "Current network state: $network_state"
echo "Active connection on wlan0: $active_connection"
if [[ "$network_state" == "disconnected" || "$network_state" == "unknown" ]]; then
  if sudo nmcli con up "Crafter3D"; then
    echo "Hotspot 'Crafter3D' activated."
  else
    echo "Failed to activate hotspot 'Crafter3D'."
  fi
elif [[ "$active_connection" != "Crafter3D" && "$crafter3d_state" -eq 1 ]]; then
  if sudo nmcli con down "Crafter3D"; then
    echo "Hotspot 'Crafter3D' disabled."
  else
    echo "Failed to disable hotspot 'Crafter3D'."
  fi
else
  echo "Hotspot 'Crafter3D' is already inactive."
fi
