import { serialize as toFormData } from 'object-to-formdata';
/**
 * serialize
 * @param data
 * @returns
 */
export function serialize<T = unknown>(data: T) {
  return toFormData(data, {
    allowEmptyArrays: true,
    booleansAsIntegers: true,
    nullsAsUndefineds: true,
  }) as unknown as T;
}
