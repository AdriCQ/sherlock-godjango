import { RouteRecordRaw } from 'vue-router';
import AgentLayout from 'layouts/agent/AgentLayout.vue';
import { ROUTE_NAME } from './names';
/**
 * agentsRoutes
 */
const agentsRoutes: RouteRecordRaw = {
  path: '/agents',
  component: AgentLayout,
  children: [
    {
      name: ROUTE_NAME.AGENT_HOME,
      path: '',
      component: () => import('pages/agent/AgentHome.vue'),
    },
  ],
};

export default agentsRoutes;
