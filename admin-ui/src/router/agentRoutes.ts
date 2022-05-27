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
    {
      name: ROUTE_NAME.AGENT_ASSIGNMENT,
      path: 'assignments',
      component: () => import('pages/AssignmentPage.vue'),
    },
    {
      name: ROUTE_NAME.AGENT_REPORTS,
      path: 'reports',
      component: () => import('pages/agent/AgentReport.vue'),
    },
  ],
};

export default agentsRoutes;
