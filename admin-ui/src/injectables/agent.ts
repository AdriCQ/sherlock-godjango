import { $api } from 'src/boot/axios';
import { IApiResponse } from 'src/types';
import { InjectionKey } from 'vue';
/**
 * IAgent
 */
export interface IAgent {
  id: number;
  name: string;
  email: string;
  phone?: string;
  address?: string;
  others?: string;
  user_name: string;
  path: string;
  password: string;
}
/**
 * AgentInjectable
 */
class AgentInjectable {
  /**
   * -----------------------------------------
   *	Actions
   * -----------------------------------------
   */
  /**
   * create
   * @param agent
   */
  async create(agent: Omit<IAgent, 'id'>) {
    return $api.post<IApiResponse<IAgent>>('agents', agent);
  }
  /**
   * list
   * @returns
   */
  async list() {
    return $api.get<IApiResponse<IAgent[]>>('agents');
  }
  /**
   * remove
   * @param id
   * @returns
   */
  async remove(id: number) {
    return $api.delete<IApiResponse<void>>(`agents/${id}`);
  }
  /**
   * remove
   * @param id
   * @returns
   */
  async update(agent: IAgent) {
    return $api.patch<IApiResponse<IAgent>>(`agents/${agent.id}`, agent);
  }
}
/**
 * Agent Injectable Instance
 */
export const $agent = new AgentInjectable();
/**
 * Agent Injection Key
 */
export const _agent: InjectionKey<AgentInjectable> = Symbol('AgentInjectable');
