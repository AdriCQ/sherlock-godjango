import { LocalStorage } from 'quasar';
import { $api } from 'src/boot/axios';
import { notificationHelper } from 'src/helpers';
import { IAuthRequest, IAuthResponse, IUserProfile } from 'src/types';
import { InjectionKey, ref } from 'vue';
/**
 * UserInjectable
 */
class UserInjectable {
  private _api_token = ref<null | string>(null);
  private _profile = ref<IUserProfile>({
    email: '',
    id: 0,
    name: '',
    phone: '',
  });
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get api_token() {
    return this._api_token.value;
  }
  set api_token(token: string | null) {
    this._api_token.value = token;
  }
  get profile() {
    return this._profile.value;
  }
  set profile(profile: IUserProfile) {
    this._profile.value = profile;
  }
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * login
   * @param login
   * @returns
   */
  async login(login: IAuthRequest) {
    try {
      const resp = await $api.post<IAuthResponse>('users/login', login);
      this.api_token = resp.data.api_token;
      this.profile = resp.data.profile;
      this.save();
      return resp.data;
    } catch (error) {
      notificationHelper.axiosError(error, ['Credenciales incorrectas']);
    }
  }
  /**
   * -----------------------------------------
   *	Mutations
   * -----------------------------------------
   */
  /**
   * load
   */
  load() {
    const _key = 'store/UserInjectable';
    if (LocalStorage.has(_key)) {
      const resp = LocalStorage.getItem(_key)?.toString();
      if (resp) {
        const json = JSON.parse(resp) as unknown as IAuthResponse;
        this.profile = json.profile;
        this.api_token = json.api_token;
      }
    }
  }
  /**
   * logout
   */
  logout() {
    this.api_token = null;
    this.profile = {
      email: '',
      id: 0,
      name: '',
      phone: '',
    };
    this.save();
  }
  /**
   * save
   */
  save() {
    LocalStorage.set(
      'store/UserInjectable',
      JSON.stringify({
        profile: this.profile,
        api_token: this.api_token,
      })
    );
  }
}

export const $user = new UserInjectable();
export const _user: InjectionKey<UserInjectable> = Symbol('UserInjectable');
