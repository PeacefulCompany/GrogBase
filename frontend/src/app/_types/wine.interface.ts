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
  id: number,
  name: string,
  description: string,
  type: WineType,
  year: number,
  price: number,
  winery: number
}
