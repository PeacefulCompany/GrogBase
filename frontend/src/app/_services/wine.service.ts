import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Options, SortOrder, Wine, WineType } from '../_types';

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

    let arr = [...WINES];
    const sortBy = options?.sortBy;
    const search = options?.search;
    if(sortBy) {
      arr = arr.sort((a, b) => {
        let dir = 0;
        if(a[sortBy.key] < b[sortBy.key]) dir = -1;
        if(a[sortBy.key] > b[sortBy.key]) dir =  1;
        if(sortBy.order == SortOrder.Descending) dir *= -1;
        return dir;
      });
      console.log("sort");
    }
    if(search) {
      console.log("search ", search);
      arr = arr.filter(elem => {
        return !Object.keys(search).some(key => {
          const value = search[key as keyof Wine];
          if(!value) return false;
          return elem[key as keyof Wine].toString().indexOf(value.toString()) == -1;
        });
      })
    }

    return of(arr);
  }

  update(wine: Wine) {
    alert("update wine: " + JSON.stringify(wine));
  }
  delete(wine: Wine) {
    alert("delete wine: " + JSON.stringify(wine));
  }

  getTopWines(options?: Options<Wine>): Observable<Wine[]> {
    let arr = [...WINES];
    const sortBy = options?.sortBy;
    if(sortBy) arr = arr.sort((a, b) => {
      if(a[sortBy.key] < b[sortBy.key]) return -1;
      if(a[sortBy.key] > b[sortBy.key]) return 1;
      return 0;
    });

    return of(arr);
  }
}
