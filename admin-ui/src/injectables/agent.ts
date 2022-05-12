import { $api, $csrf } from 'src/boot/axios';
import {
  IAgent,
  IAgentCreateRequest,
  IAgentUpdateRequest,
  IAgentCategory,
  IAgentGroup,
  IAgentGroupCreateRequest,
  IAgentGroupUpdateRequest,
  IApiResponse,
  IAgentSearchRequest,
} from 'src/types';
import { InjectionKey, ref } from 'vue';
/**
 * @var API_PATH
 */
const API_PATH = 'agents';
/**
 * @class Agent Injectable
 */
class AgentInjectable {
  private _agents = ref<IAgent[]>([]);
  private _categories = ref<IAgentCategory[]>([]);
  private _groups = ref<IAgentGroup[]>([]);
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get agents() {
    return this._agents.value;
  }
  set agents(a: IAgent[]) {
    this._agents.value = a;
  }
  get categories() {
    return this._categories.value;
  }
  set categories(c: IAgentCategory[]) {
    this._categories.value = c;
  }
  get groups() {
    return this._groups.value;
  }
  set groups(c: IAgentGroup[]) {
    this._groups.value = c;
  }
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param p
   * @returns
   */
  async create(p: IAgentCreateRequest) {
    await $csrf();
    const agent = (await $api.post<IApiResponse<IAgent>>(API_PATH, p)).data
      .data;
    this.agents.push(agent);
    return agent;
  }
  /**
   * list
   * @returns
   */
  async list() {
    this.agents = (await $api.get<IApiResponse<IAgent[]>>(API_PATH)).data.data;
    return this.agents;
  }
  /**
   * remove
   * @param id
   */
  async remove(id: number) {
    await $csrf();
    await $api.delete(`${API_PATH}/${id}`);
    const index = this.agents.findIndex((a) => a.id === id);
    if (index >= 0) this.agents.splice(index, 1);
  }
  /**
   * search
   * @param params
   * @returns
   */
  async search(params: IAgentSearchRequest) {
    return $api.get<IApiResponse<IAgent[]>>(`${API_PATH}/search`, { params });
  }
  /**
   * update
   * @param id
   * @param u
   */
  async update(id: number, u: IAgentUpdateRequest) {
    await $csrf();
    const agent = (
      await $api.patch<IApiResponse<IAgent>>(`${API_PATH}/${id}`, u)
    ).data.data;
    const index = this.agents.findIndex((a) => a.id === id);
    if (index >= 0) this.agents[index] = agent;
    return agent;
  }
  /**
   * -----------------------------------------
   *	Group Actions
   * -----------------------------------------
   */
  /**
   * Add Agent To Group
   * @param agent_id
   * @param groupId
   * @returns
   */
  async addAgentToGroup(agent_id: number, groupId: number) {
    await $csrf();
    const group = (
      await $api.post<IApiResponse<IAgentGroup>>(
        `${API_PATH}/groups/${groupId}/add-agent`,
        { agent_id }
      )
    ).data.data;
    const index = this.groups.findIndex((g) => g.id === groupId);
    if (index >= 0) this.groups[index] = group;
    return group;
  }
  /**
   * create Group
   * @param p
   * @returns
   */
  async createGroup(p: IAgentGroupCreateRequest) {
    await $csrf();
    const group = (
      await $api.post<IApiResponse<IAgentGroup>>(`${API_PATH}/groups`, p)
    ).data.data;
    this.groups.push(group);
    return group;
  }
  /**
   * list Group
   * @returns
   */
  async listGroup() {
    this.groups = (
      await $api.get<IApiResponse<IAgentGroup[]>>(`${API_PATH}/groups`)
    ).data.data;
    return this.agents;
  }
  /**
   * remove Group
   * @param id
   */
  async removeGroup(id: number) {
    await $csrf();
    await $api.delete(`${API_PATH}/groups/${id}`);
    const index = this.groups.findIndex((a) => a.id === id);
    if (index >= 0) this.groups.splice(index, 1);
  }

  /**
   * Remove AgentToGroup Agent From Group
   * @param agent_id
   * @param groupId
   * @returns
   */
  async removeAgentFromGroup(agent_id: number, groupId: number) {
    await $csrf();
    const group = (
      await $api.post<IApiResponse<IAgentGroup>>(
        `${API_PATH}/groups/${groupId}/remove-agent`,
        { agent_id }
      )
    ).data.data;
    const index = this.groups.findIndex((g) => g.id === groupId);
    if (index >= 0) this.groups[index] = group;
    return group;
  }
  /**
   * update Group
   * @param id
   * @param u
   */
  async updateGroup(id: number, u: IAgentGroupUpdateRequest) {
    await $csrf();
    const group = (
      await $api.patch<IApiResponse<IAgentGroup>>(`${API_PATH}/groups/${id}`, u)
    ).data.data;
    const index = this.groups.findIndex((a) => a.id === id);
    if (index >= 0) this.groups[index] = group;
    return group;
  }
}

export const $agentInjectable = new AgentInjectable();
export const _agentInjectable: InjectionKey<AgentInjectable> =
  Symbol('AgentInjectable');
