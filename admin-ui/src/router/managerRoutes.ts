import ManagerLayout from 'src/layouts/manager/ManagerLayout.vue';
import { RouteRecordRaw } from 'vue-router';
import { managerGuard } from './guards';
import { ROUTE_NAME } from './names';

const route: RouteRecordRaw = {
  path: '/manager',
  beforeEnter: managerGuard,
  component: ManagerLayout,
  children: [
    {
      path: '',
      name: ROUTE_NAME.ADMIN_HOME,
      component: () => import('src/pages/admin/AdminHomePage.vue'),
    },
    {
      path: 'users',
      name: ROUTE_NAME.ADMIN_USERS,
      component: () => import('src/pages/admin/AdminUsersPage.vue'),
    },
    {
      path: 'assignments/:id',
      name: ROUTE_NAME.ADMIN_ASSIGNMENT,
      component: () => import('src/pages/AssignmentPage.vue'),
    },
    {
      path: 'agents',
      name: ROUTE_NAME.ADMIN_AGENTS,
      component: () => import('src/pages/admin/AgentsPage.vue'),
    },
    {
      path: 'agents/groups',
      name: ROUTE_NAME.ADMIN_AGENT_GROUP,
      component: () => import('src/pages/admin/AgentGroupPage.vue'),
    },
    {
      path: 'events',
      name: ROUTE_NAME.ADMIN_EVENTS,
      component: () => import('src/pages/admin/EventsPage.vue'),
    },
  ],
};

export default route;
