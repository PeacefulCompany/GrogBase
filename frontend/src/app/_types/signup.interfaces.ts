export interface signupRequest{
  type: "Register";

  details:{
    email: string;
    fname: string;
    lname: string;
    password: string;
  }
}

export interface signupResponse{
  status: string;
  timestamp: number;
  data: string | {
    user_id: number;
    api_key: string;
    user_type: string;
  };
}
