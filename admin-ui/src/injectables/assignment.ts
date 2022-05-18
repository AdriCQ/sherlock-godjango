import { InjectionKey, ref } from 'vue';
import {
  IApiResponse,
  IAssignment,
  IAssignmentCheckpoint,
  IAssignmentCreateRequest,
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
  async create(a: IAssignmentCreateRequest) {
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
    this.findByIdAndUpdate(id, update);
    return update;
  }
  /**
   * -----------------------------------------
   *	Checkpoint Actions
   * -----------------------------------------
   */
  /**
   * Add Checkpoint
   * @param assignId
   * @param checkpoint
   */
  async addCheckpoint(
    assignId: number,
    checkpoint: Omit<IAssignmentCheckpoint, 'id' | 'created_at'>
  ) {
    const resp = (
      await $api.post<IApiResponse<IAssignment>>(
        `assignments/${assignId}/assign-checkpoint`,
        checkpoint
      )
    ).data.data;
    return this.findByIdAndUpdate(assignId, resp);
  }
  /**
   * Remove Checkpoint
   * @param assignmentId
   * @param checkpointId
   */
  async removeCheckpoint(assignmentId: number, checkpointId: number) {
    await $api.delete(`assignments/checkpoints/${checkpointId}`);
    const assignmentIndex = this.assignments.findIndex(
      (a) => a.id === assignmentId
    );
    if (assignmentIndex >= 0) {
      const checkpointIndex = this.assignments[
        assignmentIndex
      ].checkpoints?.findIndex((ch) => ch.id === checkpointId);
      if (checkpointIndex && checkpointIndex >= 0) {
        this.assignments[assignmentIndex].checkpoints?.splice(
          checkpointIndex,
          1
        );
      }
    }
  }
  /**
   * -----------------------------------------
   *	Methods
   * -----------------------------------------
   */
  /**
   * findByIdAndUpdate
   * @param id
   * @param update
   */
  findByIdAndUpdate(id: number, update: IAssignment) {
    const index = this.assignments.findIndex((a) => a.id === id);
    if (index >= 0) this.assignments[index] = update;
    return this.assignments;
  }
  /**
   * findByIdAndUpdate
   * @param id
   * @param update
   */
  findByIdAndRemove(id: number) {
    const index = this.assignments.findIndex((a) => a.id === id);
    if (index >= 0) this.assignments.splice(id, 1);
    return this.assignments;
  }
}

export const $assignmentInjectable = new AssignmetnInjectable();
export const _assignmentInjectable: InjectionKey<AssignmetnInjectable> = Symbol(
  'AssignmetnInjectable'
);
