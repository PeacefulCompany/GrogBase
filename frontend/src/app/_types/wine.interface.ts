export enum WineType {
  Red = 'Red',
  White = 'White',
  Rose = 'Rose',
  Orange = 'Orange',
  Sparkling = 'Sparkling',
  Fortified = 'Fortified',
  Ice = 'Ice',
  Dessert = 'Dessert',
  Other = 'Other',
  NonAlcoholic = 'Non-Alcoholic',
}

export interface Wine {
  wine_id: number,
  name: string,
  description: string,
  type: WineType,
  year: number,
  price: number,
  winery: number
}

export namespace WineType {
  const reverseMap = new Map<string, WineType>();
  Object.keys(WineType).forEach((s: string) => {
    const e = (<any>WineType)[s];
    reverseMap.set(e.toString(), e);
  });
  export function valueOf(str: string) {
    return reverseMap.get(str);
  }
}
export interface WineReview {
  wine_id: number,
  drunk: boolean,
  points: number,
  review: string
}

import { SortOrder } from "./sort.interface";
import { SearchOptions } from ".";
import { SortBy } from "./sort.interface";

export interface WineReviewRequest{
  api_key: string | null,
  type: "getWineReviews",
  return: ["wine_id", "user_id", "points", "review", "drunk", "first_name", "last_name", "email", "name", "type"],
  limit?: number,
  sort?: SortBy<WineReview>,
  order?: SortOrder,
  search?: SearchOptions<WineReview>,
  fuzzy?: boolean
}

export interface WineReviewResponse{
  status: string,
  data: WineReview[]
}
