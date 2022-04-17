import { InjectionKey } from 'vue';
import { IAssignment } from './assignment';
/**
 * IAssignmentJoin
 */
export interface IAssignmentJoin {
  id: number;
  checkpoint: string;
  status: number;
  contact?: string;
  initiated_ts: string;
  ended_ts?: string;
  assignment_id: number;
  assignment?: IAssignment;
}
/**
 * @class AssignmentJoinInjectable
 */
class AssignmentJoinInjectable {}

/**
 * Assignment Join Instance
 */
export const $assignmentJoin = new AssignmentJoinInjectable();
/**
 * Assignment Join Injectable Key
 */
export const _assignmentJoin: InjectionKey<AssignmentJoinInjectable> = Symbol('AssignmentJoinInjectable');
