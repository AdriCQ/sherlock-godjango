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
  IAssignment,
  IAssignmentCheckpoint,
} from 'src/types';
import { InjectionKey, ref } from 'vue';
import { $user } from './user';
/**
 * @var API_PATH
 */
const API_PATH = 'agents';
/**
 * @class Agent Injectable
 */
class AgentInjectable {
  private _agent = ref<IAgent>();
  private _agents = ref<IAgent[]>([]);
  private _assignments = ref<IAssignment[]>([]);
  private _categories = ref<IAgentCategory[]>([]);
  private _groups = ref<IAgentGroup[]>([]);
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get agent() {
    return $user.profile && $user.profile.role.name === 'user'
      ? this._agent.value
      : undefined;
  }
  set agent(a: IAgent | undefined) {
    if ($user.profile && $user.profile.role.name === 'user')
      this._agent.value = a;
    else this._agent.value = undefined;
  }
  get agents() {
    return this._agents.value;
  }
  set agents(a: IAgent[]) {
    this._agents.value = a;
  }
  get assignments() {
    return this._assignments.value;
  }
  set assignments(a: IAssignment[]) {
    this._assignments.value = a;
  }
  get availableAgents() {
    return this.agents.filter((a) => Boolean(a.bussy) === false);
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
   * Get Assignment
   * @param assignmeId
   * @returns
   */
  async getAssignment(assignmeId: number) {
    const assignment = (
      await $api.get<IApiResponse<IAssignment>>(
        API_PATH + `assignments/${assignmeId}`
      )
    ).data.data;
    const assignmentIndex = this.assignments.findIndex(
      (as) => as.id === assignmeId
    );

    if (assignmentIndex >= 0) {
      this.assignments[assignmentIndex] = assignment;
    } else {
      this.assignments.push(assignment);
    }
    return assignment;
  }
  /**
   * Get Assignment Checkpoint
   * @param checkpointId
   * @returns
   */
  async getAssignmentByCheckpoint(checkpointId: number) {
    const assignment = (
      await $api.get<IApiResponse<IAssignment>>(
        API_PATH + `/assignments/checkpoints/${checkpointId}`
      )
    ).data.data;
    const assignmentIndex = this.assignments.findIndex(
      (as) => as.id === assignment.id
    );

    if (assignmentIndex >= 0) {
      this.assignments[assignmentIndex] = assignment;
    } else {
      this.assignments.push(assignment);
    }
    return assignment;
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
   * List Assignments
   * @param status
   * @returns
   */
  async listAssignments(status = 0) {
    const resp = await $api.get<IApiResponse<IAssignment[]>>(
      API_PATH + '/assignments',
      {
        params: { status },
      }
    );
    this.assignments = resp.data.data ? resp.data.data : [];
    return this.assignments;
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
   * Update Assignment Checkpoint
   * @param update
   * @returns
   */
  async updateAssignmentCheckpoint(
    checkpointId: number,
    update: Partial<IAssignmentCheckpoint>
  ) {
    await $csrf();
    const checkpoint = (
      await $api.patch<IApiResponse<IAssignmentCheckpoint>>(
        `assignments/checkpoints/${checkpointId}`,
        update
      )
    ).data.data;
    // Update Checkpoint
    let chIndex;
    let assIndex = -1;
    this.assignments.forEach((ass, index) => {
      assIndex = index;
      chIndex = ass.checkpoints?.findIndex((ch) => ch.id === checkpoint.id);
      if (chIndex && chIndex >= 0) {
        return;
      }
    });
    if (chIndex) {
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      this.assignments[assIndex].checkpoints[chIndex] = checkpoint;
    }
    return checkpoint;
  }
  /**
   * whoami
   * @returns
   */
  async whoami() {
    this.agent = (
      await $api.get<IApiResponse<IAgent>>(`${API_PATH}/whoami`)
    ).data.data;
    return this.agent;
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
    const index = this.groups.findIndex((g) => g.id === id);
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

  /**
   * findCheckpointById
   * @param checkpointId
   * @returns
   */
  findCheckpointById(checkpointId: number) {
    let checkpoint: IAssignmentCheckpoint | undefined;
    this.assignments.forEach((ass) => {
      checkpoint = ass.checkpoints?.find((ch) => ch.id === checkpointId);
      if (checkpoint) return;
    });
    return checkpoint;
  }
}

export const $agentInjectable = new AgentInjectable();
export const _agentInjectable: InjectionKey<AgentInjectable> =
  Symbol('AgentInjectable');
