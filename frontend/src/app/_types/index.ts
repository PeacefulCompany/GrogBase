import { SortBy } from "./sort.interface";

export * from "./sort.interface";
export * from "./wine.interface";
export * from "./winery.interface";

export type SearchOptions<T> = {
  [Prop in keyof T]?: string;
}

/**
  * Represents generic options regarding the
  * data that is to be returned from the API.
  */
export interface Options<T> {
  sortBy?: SortBy<T>,
  search?: SearchOptions<T>,
  return?: keyof T[]
}

export interface Update<T> {
  type: string,
  api_key: string,
  id: number,
  update: {
    // indicate the property (key) and it's new value (value)
    [Prop in keyof T]?: string;
  }
}
