import { RouteRecordRaw } from 'vue-router';
import authRoutes from './authRoutes';
import managerRoutes from './managerRoutes';
import agentsRoutes from './agentRoutes';
import { authGuard, adminGuard } from './guards';
import ManagerLayoutVue from 'src/layouts/manager/ManagerLayout.vue';
import { ROUTE_NAME } from './names';
/**
 * App Routes
 */
const routes: RouteRecordRaw[] = [
  {
    path: '/',
    beforeEnter: authGuard,
    component: () => import('src/layouts/AuthLayout.vue'),
  },
  authRoutes,
  managerRoutes,
  agentsRoutes,
  {
    path: '/admin',
    component: ManagerLayoutVue,
    beforeEnter: adminGuard,
    children: [
      {
        name: ROUTE_NAME.ADMIN_CLIENTS,
        path: 'clients',
        component: () => import('pages/ClientsPage.vue'),
      },
    ],
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
