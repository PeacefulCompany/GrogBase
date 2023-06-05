
export enum WineryRequest {
  GetAll = "getWineries",
  Add = "addWinery",
  Update = "updateWinery",
  Delete = "deleteWinery",
  Review = "insertReviewWinery",
}

export type RequestType = WineryRequest;


export interface Request {
  type: RequestType,
}

export interface AuthRequest extends Request {
  api_key: string
}
