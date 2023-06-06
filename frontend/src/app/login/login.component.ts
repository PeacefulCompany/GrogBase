import { Component } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { UserService } from '../_services/user.service';

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass']
})
export class LoginComponent {

  constructor(private userService: UserService, private snackBar: MatSnackBar, private router: Router) { }

  email = '';
  password = '';

  login(){
    this.userService.logInUser(this.email, this.password);
  }
}
