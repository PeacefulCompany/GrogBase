import { Injectable } from '@angular/core';
import {
  signupRequest,
  signupResponse
} from '../_types/signup.interfaces';
import {
  loginRequest,
  loginResponse
} from '../_types/login.interfaces';

import { user } from '../_types/user.interface';

import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { HttpClient } from '@angular/common/http';
import { from } from 'rxjs';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { on } from 'events';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient, private router: Router, private snackBar: MatSnackBar) { }

  user = {
    user_id: null,
    email: null,
    fname: null,
    lname: null,
    user_type: null,
    api_key: null
  } as user;

  //get user
  get currentUser(): user {
    return this.user;
  }


  signUpUser(email: string, fName: string, lName: string, password: string) {

      const signupRequest: signupRequest = {
          type: "Register",
          details: {
              email: email,
              fname: fName,
              lname: lName,
              password: password
          }
      }

      this.http.post<signupResponse>(environment.apiEndpoint, signupRequest)
      .pipe(
        tap((response: signupResponse) => {
          if (response.status === 'success') {
            this.snackBar.open("Signup Succesful", 'Close', {
              duration: 3000,
            });
            this.router.navigate(['/login']);
          } else {
            this.snackBar.open(`Signup Failed: ${response.data}`, 'Close', {
              duration: 3000,
            });
          }
        })
      );
  }

  logInUser(email: string, password: string) {

    const loginRequest: loginRequest = {
        type: "Login",
        details: {
            email: email,
            password: password
        }
    }

    this.http.post<loginResponse>(environment.apiEndpoint, loginRequest)
    .pipe(
      tap((response: loginResponse) => {
        if (response.status === 'success') {
          this.snackBar.open("Login Succesful", 'Close', {
            duration: 3000,
          });

          if(!(typeof response.data === 'string')){
            this.currentUser.user_id = response.data.user_id;
            this.currentUser.email = email;
            this.currentUser.user_type = response.data.user_type;
            this.currentUser.api_key = response.data.api_key;
          }

          this.router.navigate(['/home']);
        } else {
          this.snackBar.open(`Login Failed: ${response.data}`, 'Close', {
            duration: 3000,
          });
        }
      })
    );
  }

}
