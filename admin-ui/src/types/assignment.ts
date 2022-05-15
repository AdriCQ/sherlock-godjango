import { LatLng } from 'leaflet';
import { IAgent } from './agent';
/**
 * Assignment
 */
export interface IAssignment {
  id: number;
  name: string;
  description: string;
  observations?: string;
  event: string;
  status: 0 | 1 | 2;
  agent_id: number;
  agent?: IAgent;
  checkpoints?: IAssignmentCheckpoint[];
}
/**
 * Assignment Checkpoint
 */
export interface IAssignmentCheckpoint {
  id: number;
  name: string;
  position: LatLng;
  status: 0 | 1 | 2;
  contact?: string;
  created_at: string;
  updated_at?: string;
}
/**
 * Assignment Create Request
 */
export type IAssignmentCreateRequest = Omit<
  IAssignment,
  'id' | 'agent' | 'status'
>;
/**
 * Assignment Update Request
 */
export type IAssignmentUpdateRequest = Partial<
  Omit<IAssignment, 'id' | 'agent' | 'checkpoints'>
>;
