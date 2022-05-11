/**
 * User Role Name
 */
export type IUserRoleName = 'admin' | 'manager' | 'user';
/**
 * IUserRole
 */
export interface IUserRole {
  id: number;
  name: IUserRoleName;
  display_name: string;
}

/**
 * IUserProfile
 */
export interface IUserProfile {
  id: number;
  name: string;
  email: string;
  phone: string;
  role: IUserRole;
}
/**
 * User Create Request
 */
export interface IUserCreateRequest {
  name: string;
  email: string;
  phone: string;
  role_id: number;
  password?: string;
  password_confirmation?: string;
}
/**
 * IAuthResponse
 */
export interface IAuthResponse {
  api_token: string;
  profile: IUserProfile;
}
/**
 * IAuthRequest
 */
export interface IAuthRequest {
  email: string;
  password: string;
}
