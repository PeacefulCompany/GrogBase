import { Injectable } from '@angular/core';
import {
    signupRequest
} from '../_types/signup.interfaces';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SignupService {

  constructor(private http: HttpClient) { }

  URL = 'http://localhost:3000/signup';

  async signUpUser(email: string, fName: string, lName: string, password: string) {

      const signupRequest: signupRequest = {
        email: email,
        fName: fName,
        lName: lName,
        password: password
      }

      const response = await this.http.post(this.URL, signupRequest).toPromise();

      console.log(response);

      return response;

  }
}
