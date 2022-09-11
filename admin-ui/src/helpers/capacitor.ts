import { Plugins, PermissionType } from '@capacitor/core';
import { latLng } from 'leaflet';
const { Geolocation, Permissions, Storage } = Plugins;
import { $app } from 'src/injectables';
/**
 * @class CapacitorHelper
 */
export class CapacitorHelper {
  /**
   * Geolocation_currentPosition
   * @returns
   */
  async Geolocation_currentPosition() {
    const { state } = await Permissions.query({
      name: PermissionType.Geolocation,
    });
    if (state === 'denied' && Geolocation.requestPermissions) {
      await Geolocation.requestPermissions();
    }
    // request permission
    Geolocation.requestPermissions;
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
    const { state } = await Permissions.query({
      name: PermissionType.Geolocation,
    });
    if (state === 'denied' && Geolocation.requestPermissions) {
      await Geolocation.requestPermissions();
    }
    // request permission
    Geolocation.requestPermissions;
    Geolocation.watchPosition({
      enableHighAccuracy: true,
      maximumAge: 8000,
      timeout: 8000,
    }, (pos, err) => {
      if(!err)
        $app.currentPosition = latLng(pos.coords.latitude, pos.coords.longitude);
    });

  }
  /**
   * Storage_load
   * @param key
   * @returns
   */
  async Storage_load<T>(key: string) {
    const keys = (await Storage.keys()).keys;
    if (!keys.includes(key)) return null;
    const data = await Storage.get({ key });
    return data.value ? (JSON.parse(data.value) as T) : null;
  }
  /**
   * Storage_save
   * @param key
   * @param data
   */
  async Storage_save<T>(key: string, data: T) {
    return await Storage.set({ key, value: JSON.stringify(data) });
  }
}
