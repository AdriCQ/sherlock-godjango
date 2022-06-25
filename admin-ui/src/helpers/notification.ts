import { AxiosError } from 'axios';
import { Notify, QSpinnerTail } from 'quasar';
import { $router } from 'src/boot/router';
import { $user } from 'src/injectables';
import { ROUTE_NAME } from 'src/router';
import { IApiResponse, INotifyPosition } from 'src/types';
/**
 * ErrorHandler
 */
class NotificationHelper {
  /**
   * axiosError
   * @param _error
   */
  axiosError<T = unknown>(_error: unknown, _default = 'No se pudo guardar') {
    console.log({ AxiosError: _error as T });
    const error = _error as AxiosError<IApiResponse<T>>;
    if (error.response) {
      if (error.response.status === 401) {
        $user.logout();
        void $router.push({ name: ROUTE_NAME.LOGIN });
        this.error(['No podemos verificar sus credenciales']);
        return;
      } else if (error.response.status >= 400 && error.response.data.message) {
        this.error([error.response.data.message]);
      } else this.error([_default]);
    } else this.error([_default]);
  }
  /**
   * Loading
   */
  private _loading: CallableFunction | undefined;
  /**
   * success
   * @param _p
   */
  success(_p: string[], timeout = 4000, position: INotifyPosition = 'center') {
    _p.forEach((message) => {
      Notify.create({
        type: 'positive',
        message,
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        position,
        timeout,
        actions: [
          {
            label: 'x',
            color: 'white',
            handler: () => {
              /* ... */
            },
          },
        ],
      });
    });
  }
  /**
   * success
   * @param _p
   */
  error(_p: string[], timeout = 4000, position: INotifyPosition = 'center') {
    _p.forEach((message) => {
      Notify.create({
        type: 'negative',
        message,
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        position,
        timeout,
        actions: [
          {
            label: 'x',
            color: 'white',
            handler: () => {
              /* ... */
            },
          },
        ],
      });
    });
  }
  /**
   * loading
   * @param _load
   * @param message
   */
  loading(
    _load = true,
    message = '',
    timeout = 0,
    position: INotifyPosition = 'center'
  ) {
    if (_load) {
      this._loading = Notify.create({
        spinner: QSpinnerTail,
        // eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
        position,
        message,
        timeout,
      });
    } else {
      if (this._loading) this._loading();
    }
  }
}
/**
 * Notification Helper Instance
 */
export const notificationHelper = new NotificationHelper();
