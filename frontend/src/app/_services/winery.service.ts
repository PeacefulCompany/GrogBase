import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { SortBy, SortOrder, Winery } from '../_types';
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

  getAll(sortBy?: SortBy<Winery>): Observable<Winery[]> {
    let arr = faker.helpers.multiple(generateWinery, {
      count: 10
    });
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }
}
