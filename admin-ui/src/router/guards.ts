import { $user } from 'src/injectables';
import { NavigationGuard } from 'vue-router';
import { ROUTE_NAME } from './names';
/**
 * authGuard
 * @param to
 * @param from
 * @param next
 */
export const authGuard: NavigationGuard = (to, from, next) => {
  if ($user.api_token && $user.profile.id) next();
  else next({ name: ROUTE_NAME.LOGIN });
};
