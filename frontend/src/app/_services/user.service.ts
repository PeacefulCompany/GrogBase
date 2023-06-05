import { Injectable } from '@angular/core';
import {
  SignupRequest,
  SignupResponse
} from '../_types/signup.interfaces';
import {
  LoginRequest,
  LoginResponse
} from '../_types/login.interfaces';

import { User } from '../_types/user.interface';

import { environment } from 'src/environments/environment';
import { tap } from 'rxjs/operators';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient, private router: Router, private snackBar: MatSnackBar) { }

  private user?: User;

  //get user
  get currentUser(): User {
    return this.user!;
  }
  get isLoggedIn(): boolean {
    return !!this.user;
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

      this.http.post<SignupResponse>(environment.apiEndpoint, signupRequest)
      .pipe(
        tap((response: SignupResponse) => {
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
      ).subscribe();
  }

  logInUser(email: string, password: string) {

    const loginRequest: LoginRequest = {
        type: "login",
        details: {
            email: email,
            password: password
        }
    }

    this.http.post<LoginResponse>(environment.apiEndpoint, loginRequest)
    .pipe(
      tap((response: LoginResponse) => {
        if (response.status === 'success') {
          this.snackBar.open("Login Succesful", 'Close', {
            duration: 3000,
          });

          if(!(typeof response.data === 'string')){
            this.user = {
              ...response.data,
              email
            }
          }

          this.router.navigate(['/home']);
        } else {
          this.snackBar.open(`Login Failed: ${response.data}`, 'Close', {
            duration: 3000,
          });
        }
      })
    ).subscribe();
  }

}
