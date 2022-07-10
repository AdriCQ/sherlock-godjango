export * from './agent';
export * from './assignment';
export * from './axios';
export * from './client';
export * from './events';
export * from './quasar';
export * from './user';

export interface IMaPSettings {
  multiple: boolean;
  zoom: {
    min: number;
    max: number;
  };
}
