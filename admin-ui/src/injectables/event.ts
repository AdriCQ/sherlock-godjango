import { $api, $csrf } from 'src/boot/axios';
import {
  IApiResponse,
  IEvent,
  IEventCreateRequest,
  IEventStatus,
  IEventUpdateRequest,
} from 'src/types';
import { InjectionKey, ref } from 'vue';
/**
 * @constant
 */
const API_PATH = 'events';
/**
 * @class Event Injectable
 */
class EventInjectable {
  private _events = ref<IEvent[]>([]);
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get events() {
    return this._events.value;
  }
  set events(e: IEvent[]) {
    this._events.value = e;
  }
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param params
   * @returns
   */
  async create(params: IEventCreateRequest) {
    await $csrf();
    const resp = await $api.post<IApiResponse<IEvent>>(API_PATH, params);
    this.events.unshift(resp.data.data);
    return resp.data.data;
  }
  /**
   * find
   * @param eventId
   * @returns
   */
  async find(eventId: number) {
    await $csrf();
    return $api.get<IApiResponse<IEvent>>(`${API_PATH}/${eventId}`);
  }
  /**
   * list
   * @returns
   */
  async list() {
    return $api.get<IApiResponse<IEvent[]>>(API_PATH);
  }
  /**
   * listCompleted
   * @returns
   */
  async listCompleted() {
    return (await this.search('completed')).data.data;
  }
  /**
   * listOnProgress
   * @returns
   */
  async listOnProgress() {
    this.events = (await this.search('onprogress')).data.data;
    return this.events;
  }
  /**
   * mine
   * @returns
   */
  async mine() {
    this.events = (
      await $api.get<IApiResponse<IEvent[]>>(API_PATH + '/mine')
    ).data.data;
    return this.events;
  }
  /**
   * remove
   * @param eventId
   * @returns
   */
  async remove(eventId: number) {
    await $csrf();
    return $api.delete(`${API_PATH}/${eventId}`);
  }

  async search(status: IEventStatus) {
    await $csrf();
    return $api.post<IApiResponse<IEvent[]>>(`${API_PATH}/search`, { status });
  }
  /**
   * update
   * @param eventId
   * @returns
   */
  async update(eventId: number, params: IEventUpdateRequest) {
    await $csrf();
    return $api.patch<IApiResponse<IEvent>>(`${API_PATH}/${eventId}`, params);
  }
}

export const $event = new EventInjectable();
export const _eventInjectable: InjectionKey<EventInjectable> =
  Symbol('EventInjectable');
