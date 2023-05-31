export interface loginRequest{
  email: string;
  password: string;
}

export interface loginResponse{
  status: string;
  data: object | string;
}
