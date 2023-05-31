import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {
    loginRequest,
    loginResponse
} from '../_types/login.interfaces';
@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient) { }

  URL = 'http://localhost:3000/login';

  async logInUser(email: string, password: string) {

    const loginRequest: loginRequest = {
      email: email,
      password: password
    }

    const response = await this.http.post<loginResponse>(this.URL, loginRequest).toPromise();

    console.log(response);

    return response;

  }



}
