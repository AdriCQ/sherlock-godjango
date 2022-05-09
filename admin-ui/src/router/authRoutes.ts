import AuthLayoutVue from 'src/layouts/AuthLayout.vue';
import { RouteRecordRaw } from 'vue-router';
import { ROUTE_NAME } from './names';
// import { authGuard } from './guards';

const route: RouteRecordRaw = {
  path: '/auth',
  component: AuthLayoutVue,
  name: ROUTE_NAME.LOGIN,
};

export default route;
