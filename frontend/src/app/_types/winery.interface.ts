export interface Winery {
  winery_id: number,
  name: string,
  description: string,
  established: number,
  location: string,
  region: string,
  country: string,
  website: string,
}


export interface WineryReview {
  winery_id: number
  points: number,
  review: string,
  first_name?: string;
  last_name?: string;
  user_type?: UserType
}

import { SortOrder } from "./sort.interface";
import { SearchOptions } from ".";
import { SortBy } from "./sort.interface";
import { UserType } from "./user.interface";

export interface WineryReviewRequest{
  api_key: string | null,
  type: "getWineryReviews",
  return: ["winery_id", "user_id", "points", "review", "first_name", "last_name", "email", "name", "user_type"],
  limit?: number,
  sort?: SortBy<WineryReview>,
  order?: SortOrder,
  search?: SearchOptions<WineryReview>,
  fuzzy?: boolean
}

export interface WineryReviewResponse{
  status: string,
  data: WineryReview[]
}
