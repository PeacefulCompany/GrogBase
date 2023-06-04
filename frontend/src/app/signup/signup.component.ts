import { Component, OnInit } from '@angular/core';
import { UserService } from '../_services/user.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router } from '@angular/router';

@Component({
  selector: 'signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.sass']
})
export class SignupComponent{

  email = '';
  fName = '';
  lName = '';
  password = '';

  constructor(private userService: UserService, private snackBar: MatSnackBar, private router: Router) { }

  signup(){
    this.userService.signUpUser(this.email, this.fName, this.lName, this.password);
  }

}
