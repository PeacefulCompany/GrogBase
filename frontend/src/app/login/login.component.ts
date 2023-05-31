import { Component } from '@angular/core';
import { LoginService } from '../_services/login.service';
import { loginResponse } from '../_types/login.interfaces';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass']
})
export class LoginComponent {

  constructor(private loginService: LoginService, private snackBar: MatSnackBar, private router: Router) { }

  email = '';
  password = '';

  async login(){

    console.log('Username:', this.email);
    console.log('Password:', this.password);

    const response = await this.loginService.logInUser(this.email, this.password) as loginResponse;

    if(response.status === '200'){
      //route to home page

      this.router.navigate(['/home']);

      this.snackBar.open("Login Succesful", 'Close', {
        duration: 3000,
      });
    }else{
      this.snackBar.open("Login Failed", 'Close', {
        duration: 3000,
      });
    }

  }
}
