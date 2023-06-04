import { DataSource } from '@angular/cdk/collections';
import { MatSort, Sort } from '@angular/material/sort';
import { map } from 'rxjs/operators';
import { Observable, of as observableOf, merge, BehaviorSubject } from 'rxjs';
import { WineService } from 'src/app/_services/wine.service';
import { Options, SearchOptions, SortBy, SortOrder, Wine } from 'src/app/_types';

/**
 * Data source for the WineTable view. This class should
 * encapsulate all logic for fetching and manipulating the displayed data
 * (including sorting, pagination, and filtering).
 */
export class WineTableDataSource extends DataSource<Wine> {
  data = new BehaviorSubject<Wine[]>([]);
  sort?: SortBy<Wine>;
  filter?: SearchOptions<Wine> = {};

  constructor(private wineService: WineService) {
    super();
  }

  /**
   * Connect this data source to the table. The table will only update when
   * the returned stream emits new items.
   * @returns A stream of the items to be rendered.
   */
  connect(): Observable<Wine[]> {
    this.wineService.getAll().subscribe(res => this.data.next(res));
    return this.data.asObservable();
  }

  setSort(sort: Sort) {
    console.log("sort");
    if(sort.direction.length == 0) {
      this.sort = undefined;
    }
    else {
      this.sort = {
        key: sort.active as keyof Wine,
        order: sort.direction == 'asc' ? SortOrder.Ascending : SortOrder.Descending
      }
    }
    console.log(this.sort);
    this.getData();
  }
  setFilter(filter?: SearchOptions<Wine>) {
    this.filter = filter;
    this.getData();
  }

  getData() {
    this.wineService.getAll({
      sortBy: this.sort,
      search: this.filter,
    }).subscribe(res => this.data.next(res));
  }
  updateWine(wine: Wine) {
    this.data.next(this.data.value.map(elem => {
      if(elem.id != wine.id) return elem;
      return wine;
    }));
  }
  removeWine(wine: Wine) {
    this.data.next(this.data.value.filter(elem => elem.id != wine.id));
  }

  /**
   *  Called when the table is being destroyed. Use this function, to clean up
   * any open connections or free any held resources that were set up during connect.
   */
  disconnect(): void {
    this.data.complete();
  }

}
