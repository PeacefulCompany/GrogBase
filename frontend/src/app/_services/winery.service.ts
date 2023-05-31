import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { SearchOptions, SortBy, Winery } from '../_types';
import { faker } from "@faker-js/faker";

function generateWinery(): Winery {
  return {
    id: faker.number.int(),
    name: faker.company.name(),
    description: faker.lorem.paragraph(20),
    established: faker.date.past().getFullYear(),
    location: faker.location.streetAddress(),
    region: faker.location.county(),
    country: faker.location.country(),
    website: faker.internet.url()
  }
}

/**
  * Represents generic options regarding the
  * data that is to be returned from the API.
  *
  * Note: as of the time of the last commit,
  * wineries may not have any null values. This
  * is to facilitate the sorting of mock data
  * and can be changed to allow for the correct
  * specification of return parameters
  */
export interface WineryOptions {
  sortBy?: SortBy<Winery>,
  return?: keyof Winery[]
}

@Injectable({
  providedIn: 'root'
})
export class WineryService {

  constructor() { }

  /**
    * Retrieves all entries from the database with
    * no filtering applied
    * @param options Optional return parameters
    * @return The array of wineries
    */
  getAll(options?: WineryOptions): Observable<Winery[]> {
    let arr = faker.helpers.multiple(generateWinery, {
      count: 10
    });
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }

  /**
    * Updates the data of a winery
    * @param winery The winery to update
    * @return Whether the update was successful
    */
  update(winery: Winery): Observable<boolean> {
    alert("update: " + JSON.stringify(winery));
    return of(true);
  }

  /**
    * Updates the data of a winery
    * @param winery The winery to update
    * @return Whether the update was successful
    */
  delete(winery: Winery): Observable<boolean> {
    alert("delete: " + winery.id);
    return of(true);
  }

  /*
    * @param term The search term
    * @return The array of wineries
    */
  search(search: SearchOptions<Winery>, options?: WineryOptions): Observable<Winery[]> {
    let arr = faker.helpers.multiple(generateWinery, {
      count: 10
    });

    return of(arr);
  }
}
