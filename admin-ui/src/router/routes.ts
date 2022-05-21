import { RouteRecordRaw } from 'vue-router';
import authRoutes from './authRoutes';
import adminRoutes from './managerRoutes';
import agentsRoutes from './agentRoutes';
import { authGuard } from './guards';
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
  adminRoutes,
  agentsRoutes,
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
