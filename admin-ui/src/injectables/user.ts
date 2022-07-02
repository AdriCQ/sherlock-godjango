import { LocalStorage } from 'quasar';
import { $api, $csrf } from 'src/boot/axios';
import {
  IApiResponse,
  IAuthRequest,
  IAuthResponse,
  IUserCreateRequest,
  IUserProfile,
  IUserRole,
} from 'src/types';
import { InjectionKey, ref } from 'vue';
const STORAGE_KEY = 'godjango-sherlock/UserInjectable';
/**
 * UserInjectable
 */
class UserInjectable {
  private _allUsers = ref<IUserProfile[]>([]);
  private _api_token = ref<null | string>(null);
  private _profile = ref<IUserProfile>({
    email: '',
    id: 0,
    name: '',
    phone: '',
    role: {
      id: 2,
      display_name: 'User',
      name: 'user',
    },
  });
  private _roles = ref<IUserRole[]>([]);
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get allUsers() {
    return this._allUsers.value;
  }
  set allUsers(u: IUserProfile[]) {
    this._allUsers.value = u;
  }
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
  get roles() {
    return this._roles.value;
  }
  set roles(r: IUserRole[]) {
    this._roles.value = r;
  }
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param user
   * @returns
   */
  async create(user: IUserCreateRequest) {
    await $csrf();
    const resp = await $api.post<IApiResponse<IUserProfile>>('users', user);
    this.allUsers.push(resp.data.data);
    return resp.data.data;
  }
  /**
   * list
   * @returns
   */
  async list() {
    this.allUsers = (
      await $api.get<IApiResponse<IUserProfile[]>>('users/list')
    ).data.data;
    return this.allUsers;
  }
  /**
   * listRoles
   */
  async listRoles() {
    this.roles = (
      await $api.get<IApiResponse<IUserRole[]>>('users/roles')
    ).data.data;
  }
  /**
   * login
   * @param login
   * @returns
   */
  async login(login: IAuthRequest) {
    await $csrf();
    const resp = await $api.post<IApiResponse<IAuthResponse>>(
      'users/login',
      login
    );
    this.api_token = resp.data.data.api_token;
    this.profile = resp.data.data.profile;
    this.save();
    return resp.data;
  }
  /**
   * remove
   * @param userId
   * @returns
   */
  async remove(userId: number) {
    await $csrf();
    const resp = await $api.delete(`users/${userId}`);
    const index = this.allUsers.findIndex((u) => u.id == userId);
    if (index >= 0) this.allUsers.splice(index, 1);
    return resp.data.data;
  }
  /**
   * update
   * @param id
   * @param user
   * @returns
   */
  async update(id: number, user: Partial<IUserCreateRequest>) {
    await $csrf();
    const resp = await $api.patch<IApiResponse<IUserProfile>>(
      `users/${id}`,
      user
    );
    const index = this.allUsers.findIndex((u) => u.id == id);
    if (index >= 0) this.allUsers[index] = resp.data.data;
    return resp.data.data;
  }
  /**
   * updateEmail
   * @param id
   * @param email
   * @returns
   */
  async updateEmail(id: number, email: string) {
    await $csrf();
    const resp = await $api.patch<IApiResponse<IUserProfile>>(
      `users/${id}/email`,
      { email }
    );
    const index = this.allUsers.findIndex((u) => u.id == id);
    if (index >= 0) this.allUsers[index] = resp.data.data;
    return resp.data.data;
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
    if (LocalStorage.has(STORAGE_KEY)) {
      const resp = LocalStorage.getItem(STORAGE_KEY)?.toString();
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
      role: {
        id: 2,
        display_name: 'User',
        name: 'user',
      },
    };
    this.save();
  }
  /**
   * save
   */
  save() {
    LocalStorage.set(
      STORAGE_KEY,
      JSON.stringify({
        profile: this.profile,
        api_token: this.api_token,
      })
    );
  }
}

export const $user = new UserInjectable();
export const _user: InjectionKey<UserInjectable> = Symbol('UserInjectable');
