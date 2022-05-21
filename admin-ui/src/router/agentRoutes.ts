import { RouteRecordRaw } from 'vue-router';
import AgentLayout from 'layouts/agent/AgentLayout.vue';
import { ROUTE_NAME } from './names';
import { agentGuard } from './guards';
/**
 * agentsRoutes
 */
const agentsRoutes: RouteRecordRaw = {
  path: '/agents',
  component: AgentLayout,
  beforeEnter: agentGuard,
  children: [
    {
      name: ROUTE_NAME.AGENT_HOME,
      path: '',
      component: () => import('pages/agent/AgentHome.vue'),
    },
  ],
};

export default agentsRoutes;
