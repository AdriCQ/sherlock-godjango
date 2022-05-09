import MainLayoutVue from 'src/layouts/MainLayout.vue';
import { RouteRecordRaw } from 'vue-router';
import { ROUTE_NAME } from './names';
// import { authGuard } from './guards';

const route: RouteRecordRaw = {
  path: '/admin',
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
