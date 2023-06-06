import { Observable, catchError, filter, of, map } from "rxjs";
import { UiService } from "./ui.service";
import { Response } from "src/app/_types/index";

export function handleResponse<T>(ui: UiService):
  (source$: Observable<Response<T>>) => Observable<T>
{
  return (source$: Observable<Response<T>>) =>
  source$.pipe(
    catchError(e => {
      ui.showError(e.error.data);
      return of(e.error);
    }),
    filter((res: any) => res.status == "success"),
      map((res: any) => res.data)
  );
};
