import { $user } from 'src/injectables';
import { NavigationGuard } from 'vue-router';
import { ROUTE_NAME } from './names';

/**
 * Admin Guard
 * @param to
 * @param from
 * @param next
 */
export const adminGuard: NavigationGuard = (to, from, next) => {
  if (
    $user.api_token &&
    $user.profile.id &&
    $user.profile.role.name === 'admin'
  )
    next();
  else next({ name: ROUTE_NAME.LOGIN });
};
/**
 * Agent Guard
 * @param to
 * @param from
 * @param next
 */
export const agentGuard: NavigationGuard = (to, from, next) => {
  if ($user.api_token && $user.profile.id && $user.profile.role.name === 'user')
    next();
  else next({ name: ROUTE_NAME.LOGIN });
};

/**
 * Auth Guard
 * @param to
 * @param from
 * @param next
 */
export const authGuard: NavigationGuard = (to, from, next) => {
  if ($user.api_token && $user.profile.id) next();
  else next({ name: ROUTE_NAME.LOGIN });
};
/**
 * Manager Guard
 * @param to
 * @param from
 * @param next
 */
export const managerGuard: NavigationGuard = (to, from, next) => {
  if (
    $user.api_token &&
    $user.profile.id &&
    $user.profile.role.name === 'manager'
  )
    next();
  else next({ name: ROUTE_NAME.LOGIN });
};
