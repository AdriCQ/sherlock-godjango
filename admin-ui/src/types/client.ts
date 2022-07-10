import { IUserCreateRequest } from './user';

export interface IClient {
  id: number;
  name: string;
  description: string;
  created_at: string;
  updated_at: string;
}

export interface IClientCreateRequest {
  name: string;
  description: string;
  user: Omit<IUserCreateRequest, 'role_id'>;
}

export type IClientUpdateRequest = Omit<
  IClient,
  'id' | 'created_at' | 'updated_at'
>;
