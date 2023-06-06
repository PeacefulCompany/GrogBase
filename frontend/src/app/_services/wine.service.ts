import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable, tap } from 'rxjs';
import { Options, SortOrder, Wine, WineReview } from '../_types';

import { environment } from 'src/environments/environment';
import { Response } from '../_types';
import { UserService } from './user.service';
import { WineReviewRequest } from '../_types/wine.interface';
import { UiService } from './ui.service';
import { handleResponse } from './util';

@Injectable({
  providedIn: 'root'
})
export class WineService {

  constructor(
    private http: HttpClient,
    private user: UserService,
    private ui: UiService
  ) { }

  getAll(options?: Options<Wine>): Observable<Wine[]> {
    const sortBy = options?.sortBy;
    let search = options?.search;

    let params: any = {
      api_key: this.user.currentUser!.api_key,
      type: "wines",
      return: ["*"]
    };

    if(sortBy) {
      params.sort = sortBy.key;
      params.order = sortBy.order;
    }
    if(options?.limit) {
      params.limit = options.limit;
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

    const obs = this.http.post<Response<Wine[]>>(environment.apiEndpoint, params)
      .pipe(
        handleResponse(this.ui),
        tap(res => console.log(res)),
      );
    return obs;
  }

  update(wine: Wine): Observable<boolean> {
    return this.http.post<Response<string>>(environment.apiEndpoint, {
      api_key: this.user.currentUser!.api_key,
      type:'updateWine',
      id:wine.wine_id,
      details: {
        name: wine.name,
        description: wine.description,
        type: wine.type,
        year: wine.year,
        price: wine.price,
        winery: wine.winery
      }
    }).pipe(
      handleResponse(this.ui),
      map(() => true)
    );
  }

  insert(wine: Wine): Observable<boolean> {
    return this.http.post<Response<string>>(environment.apiEndpoint, {
      api_key: this.user.currentUser!.api_key,
      type: 'addWine',
      details: {
        name: wine.name,
        description: wine.description,
        type: wine.type,
        year: wine.year,
        price: wine.price,
        winery: wine.winery
      }
    }).pipe(
      handleResponse(this.ui),
      map(() => true)
    );
  }

  delete(wine: Wine) : Observable<boolean>{
    return this.http.post<Response<string>>(environment.apiEndpoint, {
      api_key: this.user.currentUser!.api_key,
      type: 'deleteWine',
      id: wine.wine_id
    }).pipe(
      handleResponse(this.ui),
      map(() => true)
    );
  }

  review(rating: WineReview): Observable<string> {
    return this.http.post<Response<string>>(environment.apiEndpoint, {
      api_key: this.user.currentUser!.api_key,
      type: 'insertReviewWines',
      target: {
        wine_id: rating.wine_id
      },
      values: {
        points: rating.points,
        review: rating.review,
        drunk: rating.drunk
      }
    })
    .pipe(
      handleResponse(this.ui)
    );
  }

  getTopWines(): Observable<Wine[]> {
    return this.getAll({
      limit: 10,
      sortBy: {
        key: "Avg_rating",
        order: SortOrder.Descending
      }
    });
  }

  getWineReviews(wine_id: number): Observable<WineReview[]>{

    const rqst: WineReviewRequest = {
      api_key: this.user.currentUser!.api_key,
      type: "getWineReviews",
      return: ["wine_id", "user_id", "points", "review", "drunk", "first_name", "last_name", "email", "name", "user_type"],
      search: {"wine_id": wine_id.toString()},
      fuzzy: false
    }

    return this.http.post<Response<WineReview[]>>(environment.apiEndpoint, rqst)
      .pipe(handleResponse(this.ui));

  }
}
