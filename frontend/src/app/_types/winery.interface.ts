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
}
