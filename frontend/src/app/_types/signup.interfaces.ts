import { Response } from "./index";

export interface SignupRequest {
  type: "register";

  details:{
    email: string;
    fname: string;
    lname: string;
    password: string;
  }
}

export type SignupResponse = Response<{
  user_id: number;
  api_key: string;
  user_type: string;
}>;
