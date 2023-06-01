export interface loginRequest{
  email: string;
  password: string;
}

export interface loginResponse<T>{
  status: string;
  data: T | string;
}
