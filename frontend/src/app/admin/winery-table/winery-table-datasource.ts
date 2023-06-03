import { DataSource } from '@angular/cdk/collections';
import { Observable, BehaviorSubject } from 'rxjs';
import { SearchOptions, SortBy, SortOrder, Winery } from 'src/app/_types';
import { WineryService } from 'src/app/_services/winery.service';
import { Sort } from '@angular/material/sort';


/**
 * Data source for the WineryTable view. This class should
 * encapsulate all logic for fetching and manipulating the displayed data
 * (including sorting, pagination, and filtering).
 */
export class WineryTableDataSource extends DataSource<Winery> {
  data = new BehaviorSubject<Winery[]>([]);
  sort?: SortBy<Winery>;
  filter?: SearchOptions<Winery> = {};

  constructor(
    private wineryService: WineryService
  ) {
    super();
  }

  /**
   * Connect this data source to the table. The table will only update when
   * the returned stream emits new items.
   * @returns A stream of the items to be rendered.
   */
  connect(): Observable<Winery[]> {
    this.getData();
    return this.data.asObservable();
  }

  getData() {
    this.wineryService.getAll({
      sortBy: this.sort,
      search: this.filter,
    }).subscribe(res => this.data.next(res));
  }

  setSort(sort: Sort) {
    console.log("sort");
    if(sort.direction.length == 0) {
      this.sort = undefined;
    }
    else {
      this.sort = {
        key: sort.active as keyof Winery,
        order: sort.direction == 'asc' ? SortOrder.Ascending : SortOrder.Descending
      }
    }
    console.log(this.sort);
    this.getData();
  }
  setFilter(filter?: SearchOptions<Winery>) {
    this.filter = filter;
    this.getData();
  }

  /**
   *  Called when the table is being destroyed. Use this function, to clean up
   * any open connections or free any held resources that were set up during connect.
   */
  disconnect(): void {
    this.data.complete();
  }


}
