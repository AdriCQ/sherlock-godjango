import { LatLng } from 'leaflet';
import { IUserProfile } from './user';
/**
 * Agent
 */
export interface IAgent {
  id: number;
  nick: string;
  address: string;
  others?: string;
  position?: LatLng;
  bussy: boolean;
  user_id: number;
  user?: IUserProfile;
  agent_group_id: number;
  categories?: IAgentCategory[];
}
/**
 * Agent Group
 */
export interface IAgentGroup {
  id: number;
  name: string;
  description?: string;
  agents?: IAgent[];
}
/**
 * Agent Category
 */
export interface IAgentCategory {
  id: number;
  name: string;
}

export type IAgentCreateRequest = Omit<IAgent, 'id' | 'bussy'>;
export type IAgentUpdateRequest = Partial<Omit<IAgent, 'id' | 'user_id'>>;
/**
 * Agent Search Request
 */
export interface IAgentSearchRequest {
  mode: 'user' | 'nick';
  search: string;
}

/**
 * Agent Create Group Request
 */
export type IAgentGroupCreateRequest = Omit<IAgentGroup, 'id'>;

/**
 * Agent Update Group Request
 */
export type IAgentGroupUpdateRequest = Partial<IAgentGroupCreateRequest>;
