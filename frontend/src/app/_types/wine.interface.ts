export enum WineType {
  Red = 'Red',
  White = 'White',
  Rose = 'Rose',
  Orange = 'Orange',
  Sparkling = 'Sparkling',
  Fortified = 'Fortified',
  Ice = 'Ice',
  Dessert = 'Dessert',
  Other = 'Other',
  NonAlcoholic = 'Non-Alcoholic',
}

export interface Wine {
  wine_id: number,
  name: string,
  description: string,
  type: WineType,
  year: number,
  price: number,
  winery: number
}

export namespace WineType {
  const reverseMap = new Map<string, WineType>();
  Object.keys(WineType).forEach((s: string) => {
    const e = (<any>WineType)[s];
    reverseMap.set(e.toString(), e);
  });
  export function valueOf(str: string) {
    return reverseMap.get(str);
  }
}
export interface WineReview {
  wine_id: number,
  drunk: boolean,
  points: number,
  review: string
}
