import { latLng } from 'leaflet';
import { CapacitorHelper } from './capacitor';

export const $capacitor = new CapacitorHelper();
export const DEFAULT_COORDINATES = latLng(0, 0);

export * from './cookie';
export * from './notification';
export * from './serialize';
export * from './ui';
