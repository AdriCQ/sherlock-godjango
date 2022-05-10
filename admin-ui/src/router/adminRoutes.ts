import MainLayoutVue from 'src/layouts/MainLayout.vue';
import { RouteRecordRaw } from 'vue-router';
import { authGuard } from './guards';
import { ROUTE_NAME } from './names';

const route: RouteRecordRaw = {
  path: '/admin',
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
  ],
};

export default route;
