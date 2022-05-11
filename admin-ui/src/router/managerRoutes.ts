import MainLayoutVue from 'src/layouts/MainLayout.vue';
import { RouteRecordRaw } from 'vue-router';
import { authGuard } from './guards';
import { ROUTE_NAME } from './names';

const route: RouteRecordRaw = {
  path: '/manager',
  beforeEnter: authGuard,
  component: MainLayoutVue,
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
      path: 'agents',
      name: ROUTE_NAME.ADMIN_AGENTS,
      component: () => import('src/pages/admin/AgentsPage.vue'),
    },
    {
      path: 'agents/groups',
      name: ROUTE_NAME.ADMIN_AGENT_GROUP,
      component: () => import('src/pages/admin/AgentGroupPage.vue'),
    },
  ],
};

export default route;
