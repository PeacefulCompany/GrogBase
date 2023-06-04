import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, map, Observable, of } from 'rxjs';
import { environment } from 'src/environments/environment';
import { Options, Response, Winery, WineryReview } from '../_types';


@Injectable({
  providedIn: 'root'
})
export class WineryService {

  constructor(
    private http: HttpClient
  ) { }

  /**
    * Retrieves all entries from the database with
    * no filtering applied
    * @param options Optional return parameters
    * @return The array of wineries
    */
  getAll(options?: Options<Winery>): Observable<Winery[]> {
    const sortBy = options?.sortBy;
    let search = options?.search;

    let params: any = {
      // should be replaced by actual authenticated API key
      api_key: "fuck tou",
      type: "getWineries",
      return: options?.return || ["*"],
      search: {}
    };

    if(sortBy) {
      params.sort = sortBy.key;
      params.order = sortBy.order;
    }

    if(search) {
      // filter out search paramters containing null values
      search = Object.fromEntries(
        Object.entries(search)
        .filter(([_, value]) => {
          return ![undefined, null].includes(value as any);
        }));

      // API doesn't accept empty search objects
      if(Object.keys(search).length > 0) {
        params.search = search;
        params.fuzzy = true;
      }
    }
    params.search.active = "1";

    const obs = this.http.post<Response<Winery[]>>(environment.apiEndpoint, params)
      .pipe(
        catchError(e => {
          console.error(e.error);
          return of(e.error)
        }),
        map((res: Response<any[]>) => {
          return res.data;
        }));
    return obs;
  }

  /**
    * Updates the data of a winery
    * @param winery The winery to update
    * @return Whether the update was successful
    */
  update(winery: Winery): Observable<boolean> {
    return this.http.post(environment.apiEndpoint, {
      api_key: 'fuck you',
      type: 'updateWinery',
      update: winery
    }).pipe(
      catchError(e => {
        throw e.error;
      }),
      map(() => true)
    );
  }

  /**
    * Adds a new winery to the database
    * @param winery The winery to add
    * @return Whether the insert was successful
    */
  insert(winery: any): Observable<boolean> {
    return this.http.post(environment.apiEndpoint, {
      api_key: 'fuck you',
      type: 'addWinery',
      wineries: [winery]
    }).pipe(
      catchError(e => {
        throw e.error;
      }),
      map(() => true)
    );
  }

  /**
    * Updates the data of a winery
    * @param winery The winery to delete
    * @return Whether the update was successful
    */
  delete(winery: Winery): Observable<boolean> {
    return this.http.post(environment.apiEndpoint, {
      api_key: 'fuck you',
      type: 'deleteWinery',
      winery_id: winery.winery_id
    }).pipe(map(() => true));
  }

  review(rating: WineryReview): Observable<boolean> {
    return this.http.post(environment.apiEndpoint, {
      api_key: 'fuck you',
      type: 'insertReviewWinery',
      target: {
        user_id: 1,
        winery_id: rating.winery_id
      },
      values: {
        points: rating,
        review: rating.review
      }
    }).pipe(map(() => true));
  }

  getTopWineries(options?: Options<Winery>): Observable<Winery[]> {
    let arr: Winery[] = [];
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }
}
