export * from "./sort.interface";
export * from "./wine.interface";
export * from "./winery.interface";

export type SearchOptions<T> = {
  [Prop in keyof T]?: string;
}
