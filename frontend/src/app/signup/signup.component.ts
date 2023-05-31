import { Component, OnInit } from '@angular/core';
import { SignupService } from '../_services/signup.service';
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

  constructor(private signupService: SignupService, private snackBar: MatSnackBar, private router: Router) { }

  async signup(){


    console.log('Username:', this.email);
    console.log('First Name:', this.fName);
    console.log('Last Name:', this.lName);
    console.log('Password:', this.password);

    await this.signupService.signUpUser(this.email, this.fName, this.lName, this.password);

    this.snackBar.open("Sign up Succesful", 'Close', {
      duration: 3000,
    });

    //redirect to login page

    this.router.navigate(['/login']);

  }

}
