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
      path: 'personal',
      name: ROUTE_NAME.ADMIN_USERS,
      component: () => import('src/pages/admin/AdminUsersPage.vue'),
    },
    {
      path: 'personal/groups',
      name: ROUTE_NAME.ADMIN_PERSONAL_GROUP,
      component: () => import('src/pages/admin/PersonalGroupPage.vue'),
    },
  ],
};

export default route;
