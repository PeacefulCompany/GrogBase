import { Injectable } from '@angular/core';
import {
  SignupRequest,
  SignupResponse
} from '../_types/signup.interfaces';
import {
  Response
} from '../_types';
import {
  LoginRequest,
  LoginResponse
} from '../_types/login.interfaces';

import { User } from '../_types/user.interface';

import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { UiService } from './ui.service';
import { handleResponse } from './util';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(
    private http: HttpClient,
    private router: Router,
    private ui: UiService
  ) {
    const value = localStorage.getItem('user');
    if(value) {
      this.user = JSON.parse(value);
    }
  }

  private user?: User;

  //get user
  get currentUser(): User {
    return this.user!;
  }
  get isLoggedIn(): boolean {
    return !!this.user;
  }

  logout() {
    this.user = undefined;
    localStorage.removeItem('user');
    this.router.navigate(['/login']);
  }

  signUpUser(email: string, fName: string, lName: string, password: string) {
    const signupRequest: SignupRequest = {
      type: "register",
      details: {
        email: email,
        fname: fName,
        lname: lName,
        password: password
      }
    }

    this.http.post<Response<any>>(environment.apiEndpoint, signupRequest)
    .pipe(handleResponse(this.ui))
    .subscribe(() => {
      this.router.navigate(['/login']);
    });
  }

  logInUser(email: string, password: string) {

    const loginRequest: LoginRequest = {
      type: "login",
      details: {
        email: email,
        password: password
      }
    }

    this.http.post<Response<LoginResponse>>(environment.apiEndpoint, loginRequest)
    .pipe(handleResponse(this.ui))
    .subscribe(res => {
      this.ui.showMessage("Login Successful");
      this.user = {
        ...res,
        email
      }
      localStorage.setItem('user', JSON.stringify(this.user));
      this.router.navigate(['/home']);
    });
  }

}
