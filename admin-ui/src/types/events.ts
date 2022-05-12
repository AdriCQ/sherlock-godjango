import { IAgent } from './agent';

export type IEventType = 'info' | 'warning' | 'danger';
export type IEventStatus = 'completed' | 'onprogress';
/**
 * Event
 */
export interface IEvent {
  id: number;
  type: IEventType;
  status: IEventStatus;
  details: string;
  created_at: string;
  updated_at: string;
  agent_id: number;
  agent?: IAgent;
}
/**
 * Event Create Request
 */
export type IEventCreateRequest = Omit<
  IEvent,
  'id' | 'created_at' | 'updated_at' | 'agent'
>;
/**
 * Event Update Request
 */
export type IEventUpdateRequest = Partial<
  Omit<IEventCreateRequest, 'agent_id'>
>;
