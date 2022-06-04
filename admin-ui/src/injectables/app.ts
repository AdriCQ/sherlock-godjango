import { LatLng } from 'leaflet';
import { Dialog, Platform } from 'quasar';
import { $capacitor } from 'src/helpers';
import { IUserRoleName } from 'src/types';
import { ref, InjectionKey } from 'vue';
import { $user } from './user';
/**
 * STORAGE_KEY
 */
// const STORAGE_KEY = 'storage/app';
/**
 * AppStore
 */
export class AppStore {
  private _currentPosition = ref<LatLng>();
  private _leftDrawer = ref(false);
  /**
   * CurrentPosition
   */
  get currentPosition() {
    return this._currentPosition.value;
  }
  set currentPosition(p: LatLng | undefined) {
    this._currentPosition.value = p;
  }
  /**
   * Left drawer setter & getter
   */
  get leftDrawer() {
    return this._leftDrawer.value;
  }
  set leftDrawer(_open: boolean) {
    this._leftDrawer.value = _open;
  }
  /**
   * mode setter & getter
   */
  get mode(): IUserRoleName {
    if (!$user.profile || !$user.profile.role) return 'user';
    return $user.profile.role.name;
  }

  /**
   * -----------------------------------------
   *	Methods
   * -----------------------------------------
   */
  /**
   * Get Gps Position
   * @returns
   */
  async getGpsPosition() {
    if (!Platform.is.capacitor) return;
    try {
      const coords = await $capacitor.Geolocation_currentPosition();
      this.currentPosition = coords;
    } catch (error) {
      Dialog.create({
        title: 'Activación de GPS',
        message: 'Necesitamos que active su conexión de GPS',
        ok: true,
        persistent: true,
      }).onOk(async () => {
        await this.getGpsPosition();
      });
    }
  }
  /**
   * toggleLeftDrawer
   */
  toggleLeftDrawer() {
    this._leftDrawer.value = !this._leftDrawer.value;
  }
}
/**
 * App instance
 */
export const $app = new AppStore();
/**
 * App Inject Key
 */
export const _app: InjectionKey<AppStore> = Symbol('App');
