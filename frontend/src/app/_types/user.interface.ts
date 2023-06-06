export enum UserType {
  Critic = "Critic",
  Manager = "Manager",
  User = "User",
  Admin = "Admin"
}

export interface User{
  user_id: number | null;
  email: string | null;
  user_type: UserType;
  api_key: string | null;
}
