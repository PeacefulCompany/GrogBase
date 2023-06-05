import { Response } from "./index";
import { UserType } from "./user.interface";
export interface LoginRequest{
  type: "login";
  details:{
    email: string;
    password: string;
  }
}
export type LoginResponse = Response<{
  user_id: number;
  api_key: string;
  user_type: UserType;
}>;
