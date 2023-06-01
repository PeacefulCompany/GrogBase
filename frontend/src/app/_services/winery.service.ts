import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Options, SearchOptions, SortBy, Winery } from '../_types';
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
  getAll(options?: Options<Winery>): Observable<Winery[]> {
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
  search(search: SearchOptions<Winery>, options?: Options<Winery>): Observable<Winery[]> {
    let arr = faker.helpers.multiple(generateWinery, {
      count: 10
    });

    return of(arr);
  }

  getTopWineries(options?: Options<Winery>): Observable<Winery[]> {
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
}
