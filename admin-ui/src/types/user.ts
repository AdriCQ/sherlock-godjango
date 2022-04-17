/**
 * IUserProfile
 */
export interface IUserProfile {
  id: number;
  name: string;
  email: string;
  phone?: string;
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
