import { Injectable } from '@angular/core';
import { faker } from '@faker-js/faker';
import { Observable, of } from 'rxjs';
import { SortBy, Wine, WineType } from '../_types';

function generateWine(): Wine {
  return {
    id: faker.number.int(),
    name: faker.company.name(),
    description: faker.lorem.paragraph(20),
    type: faker.helpers.enumValue(WineType),
    price: Number.parseFloat(faker.commerce.price()),
    year: faker.date.past().getFullYear(),
    winery: faker.number.int()
  }
}
@Injectable({
  providedIn: 'root'
})
export class WineService {

  constructor() { }

  getAll(sortBy?: SortBy<Wine>): Observable<Wine[]> {
    let arr = faker.helpers.multiple(generateWine, {
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
