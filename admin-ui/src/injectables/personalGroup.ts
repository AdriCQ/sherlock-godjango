import { $api, $csrf } from 'src/boot/axios';
import { IApiResponse, IPersonalGroup } from 'src/types';
import { InjectionKey, ref } from 'vue';
/**
 * Personal Group
 */
class PersonalGroupInjectable {
  allGroups = ref<IPersonalGroup[]>([]);
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * addUser
   * @param groupId
   * @param userId
   */
  async addUser(groupId: number, userId: number) {
    $csrf();
    const data = (
      await $api.post<IApiResponse<IPersonalGroup>>(
        `personal/groups/${groupId}/add-user`,
        {
          user_id: userId,
        }
      )
    ).data.data;
    const index = this.allGroups.value.findIndex((g) => g.id === groupId);
    if (index) this.allGroups.value[index] = data;
  }
  /**
   * create
   * @param c
   * @returns
   */
  async create(c: Omit<IPersonalGroup, 'id'>) {
    await $csrf();
    this.allGroups.value.push(
      (await $api.post<IApiResponse<IPersonalGroup>>('personal/groups', c)).data
        .data
    );
  }
  /**
   * list
   * @returns
   */
  async list() {
    this.allGroups.value = (
      await $api.get<IApiResponse<IPersonalGroup[]>>('personal/groups')
    ).data.data;
  }
  /**
   * remove
   * @param id
   * @returns
   */
  async remove(id: number) {
    await $csrf();
    await $api.delete<IApiResponse<void>>(`personal/groups/${id}`);
    const index = this.allGroups.value.findIndex((g) => g.id === id);
    if (index >= 0) this.allGroups.value.splice(index, 1);
  }

  /**
   * removeUser
   * @param groupId
   * @param userId
   */
  async removeUser(groupId: number, userId: number) {
    $csrf();
    const data = (
      await $api.post<IApiResponse<IPersonalGroup>>(
        `personal/groups/${groupId}/remove-user`,
        {
          user_id: userId,
        }
      )
    ).data.data;
    const index = this.allGroups.value.findIndex((g) => g.id === groupId);
    if (index >= 0) this.allGroups.value[index] = data;
  }
  /**
   * update
   * @param id
   * @param c
   * @returns
   */
  async update(id: number, c: Partial<IPersonalGroup>) {
    await $csrf();
    const resp = await $api.patch<IApiResponse<IPersonalGroup>>(
      `personal/groups/${id}`,
      c
    );
    const index = this.allGroups.value.findIndex((g) => g.id === id);
    if (index >= 0) this.allGroups.value[index] = resp.data.data;
  }
}

export const $personalGroup = new PersonalGroupInjectable();
export const _personalGroup: InjectionKey<PersonalGroupInjectable> = Symbol(
  'PersonalGroupInjectable'
);
