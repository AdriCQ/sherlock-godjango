import { AxiosError } from 'axios';
import { Dialog, Notify } from 'quasar';
import { $router } from 'src/boot/router';
import { $user } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
/**
 * UI Helper
 * @param $q
 * @returns
 */
export function useGuiHelper() {
  /**
   * Deletes dialog
   * @param _config
   */
  function deleteDialog(_config: {
    title?: string;
    message: string;
    onOk: CallableFunction;
  }) {
    Dialog.create({
      title: _config.title,
      message: _config.message,
      ok: true,
      cancel: true,
    }).onOk(() => {
      _config.onOk();
    });
  }
  /**
   * errorHandler
   * @param _error
   */
  function errorHandler(
    _error?: AxiosError,
    _default = 'Ha ocurrido un error'
  ) {
    console.log({ _error });
    if (_error && _error.response && _error.response.data) {
      if (_error.response.status === 401) {
        // Show notification
        Notify.create({
          type: 'negative',
          icon: 'mdi-alert-circle-outline',
          message: _default,
          position: 'center',
          actions: [
            {
              icon: 'mdi-close',
              color: 'white',
              handler: () => {
                /* ... */
              },
            },
          ],
        });
        $user.logout();
        if ($router) void $router.push({ name: ROUTE_NAME.LOGIN });
      } else {
        // Show notification
        // $q.notify({
        //     type: 'negative',
        //     icon: 'mdi-alert-circle-outline',
        //     message: _error.response.data.message,
        //     position: 'center'
        // });
        Notify.create({
          type: 'negative',
          icon: 'mdi-alert-circle-outline',
          message: _default,
          position: 'center',
          actions: [
            {
              icon: 'mdi-close',
              color: 'white',
              handler: () => {
                /* ... */
              },
            },
          ],
        });
      }
    } else {
      Notify.create({
        type: 'negative',
        icon: 'mdi-alert-circle-outline',
        message: _default,
        position: 'center',
      });
    }
  }
  return {
    errorHandler,
    deleteDialog,
  };
}
/**
 * cryptHash
 * @param _text
 * @returns
 */
export function cryptHash(_text: string): string {
  return btoa(_text);
}
