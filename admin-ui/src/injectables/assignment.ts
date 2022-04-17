import { $api } from 'src/boot/axios';
import { IApiResponse } from 'src/types';
import { InjectionKey } from 'vue';
import { IAgent } from './agent';
import { IAssignmentJoin } from './assignmentJoin';
/**
 * IAssignment
 */
export interface IAssignment {
  id: number;
  name: string;
  description: string;
  observations: string;
  event: string;
  state: string;
  agent_id: number | null;
  agent?: IAgent;
  joins?: Omit<IAssignmentJoin, 'assignment_id' | 'id'>[];
}
/**
 * @class AssignmentInjectable
 */
class AssignmentInjectable {
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param create
   * @returns
   */
  async create(create: Omit<IAssignment, 'agent'>) {
    return $api.post<IApiResponse<IAssignment>>('assignments', create)
  }
  /**
   * list
   * @returns
   */
  async list() {
    return $api.get<IApiResponse<IAssignment[]>>('assignments');
  }
  /**
   * remove
   * @param assignmentId
   * @returns
   */
  async remove(assignmentId: number) {
    return $api.delete<IApiResponse<void>>(`assignments/${assignmentId}`);
  }
  /**
   * update
   * @param assignmentId
   * @returns
   */
  async update(assignment: Partial<IAssignment>) {
    return $api.patch<IApiResponse<IAssignment>>(`assignments/${assignment.id}`, assignment);
  }
}
/**
 * Assignment Injectable Instance
 */
export const $assignment = new AssignmentInjectable();
/**
 * Assignment Injection Key
 */
export const _assignment: InjectionKey<AssignmentInjectable> = Symbol('AssignmentInjectable');
