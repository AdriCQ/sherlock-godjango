import { latLng } from 'leaflet';
import { CapacitorHelper } from './capacitor';

export const $capacitor = new CapacitorHelper();
export const DEFAULT_COORDINATES = latLng(22.4056, -79.9539);

export * from './cookie';
export * from './notification';
export * from './serialize';
export * from './ui';
