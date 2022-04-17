import { ref, InjectionKey } from 'vue';
/**
 * STORAGE_KEY
 */
// const STORAGE_KEY = 'storage/app';
/**
 * AppStore
 */
export class AppStore {
  private _leftDrawer = ref(false);
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
   * -----------------------------------------
   *	Methods
   * -----------------------------------------
   */
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
