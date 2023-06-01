export enum SortOrder {
  Ascending = 'ASC',
  Descending = 'DESC',
}
export interface SortBy<T> {
  key: keyof T,
  order: SortOrder
}
