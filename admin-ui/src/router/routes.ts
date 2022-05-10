import { RouteRecordRaw } from 'vue-router';
import authRoutes from './authRoutes';
import adminRoutes from './managerRoutes';
import { authGuard } from './guards';
/**
 * App Routes
 */
const routes: RouteRecordRaw[] = [
  {
    path: '/',
    beforeEnter: authGuard,
    component: () => import('layouts/MainLayout.vue'),
    children: [{ path: '', component: () => import('pages/IndexPage.vue') }],
  },
  authRoutes,
  adminRoutes,
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
