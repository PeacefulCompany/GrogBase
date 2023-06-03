import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Options, SearchOptions, SortBy, Winery } from '../_types';

const WINERIES: Winery[]  = [
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerOne',
      established: 2019,
      location: 'Wien',
      country: 'South Africa',
      region: 'Africa',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    },
    {
      id: Math.floor(Math.random() * 1000),
      name: 'WienerTwo',
      established: 2019,
      location: 'Wien',
      country: 'Austria',
      region: 'Europe',
      website: 'https://www.wiener.com',
      description: 'Wiener is a company that sells hot dogs.'
    }
   ];

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
    let arr = WINERIES;
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
    let arr = WINERIES;
    return of(arr);
  }

  getTopWineries(options?: Options<Winery>): Observable<Winery[]> {
    let arr = WINERIES;
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }
}
