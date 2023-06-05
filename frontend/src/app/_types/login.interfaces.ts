export interface loginRequest{
  type: "Login";
  details:{
    email: string;
    password: string;
  }
}

export interface loginResponse{
  status: string;
  timestamp: number;
  data: string | {
    user_id: number;
    api_key: string;
    user_type: string;
  };
}
