import { InjectionKey, ref } from 'vue';
import {
  IAgentCreateRequest,
  IApiResponse,
  IAssignment,
  IAssignmentUpdateRequest,
} from 'src/types';
import { $api } from 'src/boot/axios';
/**
 * @class Assignment Injectable
 */
class AssignmetnInjectable {
  private _assignments = ref<IAssignment[]>([]);
  /**
   * -----------------------------------------
   *	Getters & Setters
   * -----------------------------------------
   */
  get assignments() {
    return this._assignments.value;
  }
  set assignments(a: IAssignment[]) {
    this._assignments.value = a;
  }
  getById(id: number) {
    const index = this.assignments.findIndex((a) => a.id === id);
    if (index >= 0) return this.assignments[index];
  }
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param a
   * @returns
   */
  async create(a: IAgentCreateRequest) {
    const assignment = (
      await $api.post<IApiResponse<IAssignment>>('assignments', a)
    ).data.data;
    this.assignments.push(assignment);
    return assignment;
  }
  /**
   * list
   * @returns
   */
  async list() {
    return (await $api.get<IApiResponse<IAssignment[]>>('assignments')).data
      .data;
  }
  /**
   * filter
   * @param f
   * @returns
   */
  async filter(f: IAssignmentUpdateRequest) {
    this.assignments = (
      await $api.post<IApiResponse<IAssignment[]>>('assignments/search', f)
    ).data.data;
    return this.assignments;
  }
  /**
   * update
   * @param id
   * @param params
   * @returns
   */
  async update(id: number, params: IAssignmentUpdateRequest) {
    const update = (
      await $api.patch<IApiResponse<IAssignment>>(`assignments/${id}`, params)
    ).data.data;
    const index = this.assignments.findIndex((a) => a.id === id);
    if (index >= 0) this.assignments[index] = update;
    return update;
  }
}

export const $assignmentInjectable = new AssignmetnInjectable();
export const _assignmentInjectable: InjectionKey<AssignmetnInjectable> = Symbol(
  'AssignmetnInjectable'
);
