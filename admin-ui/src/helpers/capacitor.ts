import { Geolocation } from '@capacitor/geolocation';
import { Preferences } from '@capacitor/preferences';
import { registerPlugin } from '@capacitor/core'
import { BackgroundGeolocationPlugin } from '@capacitor-community/background-geolocation';
const BackgroundGeolocation = registerPlugin<BackgroundGeolocationPlugin>('BackgroundGeolocation');
import { LatLng, latLng } from 'leaflet';
import { $mapInjectable, $agentInjectable } from 'src/injectables';
/**
 * @class CapacitorHelper
 */
export class CapacitorHelper {
	/**
	 * Geolocation_currentPosition
	 * @returns
	 */
	async Geolocation_currentPosition(): Promise<LatLng> {
		// request permission
		await Geolocation.requestPermissions();
		const { coords } = await Geolocation.getCurrentPosition({
			enableHighAccuracy: true,
			maximumAge: 8000,
			timeout: 8000,
		});

		return latLng(coords.latitude, coords.longitude);
	}


	/**
	 * Geolocation_watchPosition
	 * @returns
	 */
	async Geolocation_watchPosition() {
		// Check permission
		BackgroundGeolocation.addWatcher(
			{
				backgroundMessage: 'Cancel to prevent battery drain.',
				backgroundTitle: 'Tracking You.',
				requestPermissions: true,
				stale: false,
				distanceFilter: 100
			},
			async (location, error) => {
				if (error) {
					if (error.code === 'NOT_AUTHORIZED') {
						if (window.confirm(
							'This app needs your location, ' +
							'but does not have permission.\n\n' +
							'Open settings now?'
						)) {
							BackgroundGeolocation.openSettings();
						}
					}
					return console.error(error);
				}
				// Update position
				if ($agentInjectable.agent && location) {
					// Update $app position
					$mapInjectable.gpsPosition = latLng(location.latitude, location.longitude)
					// Update $agentPosition
					await $agentInjectable.update($agentInjectable.agent.id, {
						position: latLng(location.latitude, location.longitude),
					});
				}

				return location;
			}
		).then((watcher_id) => {
			if ($mapInjectable.watcherId) {
				if ($mapInjectable.watcherId !== watcher_id) {
					BackgroundGeolocation.removeWatcher({
						id: $mapInjectable.watcherId
					});
				}
			}
			$mapInjectable.watcherId = watcher_id;

		});


	}
	/**
	 * Storage_load
	 * @param key
	 * @returns
	 */
	async Storage_load<T>(key: string) {
		const keys = (await Preferences.keys()).keys;
		if (!keys.includes(key)) return null;
		const data = await Preferences.get({ key });
		return data.value ? (JSON.parse(data.value) as T) : null;
	}
	/**
	 * Storage_save
	 * @param key
	 * @param data
	 */
	async Storage_save<T>(key: string, data: T) {
		return await Preferences.set({ key, value: JSON.stringify(data) });
	}
}
