import { boot } from 'quasar/wrappers';
import axios, { AxiosInstance, AxiosRequestHeaders } from 'axios';
import { $user } from 'src/injectables';
import { getCookie } from 'src/helpers/cookie';

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $axios: AxiosInstance;
  }
}
const baseURL = 'https://godjango.nairda.net';
// const baseURL = 'http://localhost:8000';
// if (!process.env.DEV) {
//   const location = window.location;
//   if (location.hostname !== 'localhost') {
//     _baseURL = location.origin;
//   }
// }

const $api = axios.create({
  baseURL: `${baseURL}/api`,
  timeout: 30000,
  timeoutErrorMessage: 'Error en la red',
});

export default boot(({ app }) => {
  $user.load();
  /**
   * Api request Interceptor
   */
  $api.interceptors.request.use((_request) => {
    /* Append content type header if its not present */
    if (!(_request.headers as AxiosRequestHeaders)['Content-Type']) {
      (_request.headers as AxiosRequestHeaders)['Content-Type'] =
        'application/json';
    }
    /* Check if authorization is set */
    if (!(_request.headers as AxiosRequestHeaders)['Authorization']) {
      /* Check if the user is authenticated to send Bearer token */
      const token = $user.api_token;
      if (token && token.length > 0) {
        (_request.headers as AxiosRequestHeaders).Authorization =
          'Bearer ' + token;
      } else {
        /* Send the application authentication as Bearer token */
        (_request.headers as AxiosRequestHeaders).Authorization =
          'Bearer ApiToken';
      }
    }
    return _request;
  });

  app.config.globalProperties.$axios = axios;

  app.config.globalProperties.$api = $api;
});
/**
 * csrf
 * @returns
 */
const $csrf = async () => {
  if (!getCookie('XSRF-TOKEN'))
    return axios.get<void>(`${baseURL}/sanctum/csrf-cookie`);
};
export { $api, $csrf, baseURL };
