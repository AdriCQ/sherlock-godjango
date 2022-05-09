/**
 * User Role Name
 */
export type IUserRoleName = 'admin' | 'deliver' | 'client';
/**
 * IUserRole
 */
export interface IUserRole {
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
  phone?: string;
  role: IUserRole;
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
