import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Options, Wine, WineType } from '../_types';

const WINES: Wine[] = [
  {
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  },{
    id: Math.floor(Math.random()*1000),
    winery: Math.floor(Math.random() * 1000),
    name: "x",
    type: WineType.Red,
    year: 1968,
    price: 69,
    "description": "x"
  }
];
@Injectable({
  providedIn: 'root'
})
export class WineService {

  constructor() { }

  getAll(options?: Options<Wine>): Observable<Wine[]> {

    let arr = WINES;
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }

  update(wine: Wine) {
    alert("update wine: " + JSON.stringify(wine));
  }
  delete(wine: Wine) {
    alert("delete wine: " + JSON.stringify(wine));
  }

  getTopWines(options?: Options<Wine>): Observable<Wine[]> {
    let arr = WINES;
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }
}
