import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminPage } from './admin/admin.component';

import { LoginComponent } from './login/login.component';
import { SignupComponent} from './signup/signup.component';
import {  HomeComponent } from './home/home.component';

const routes: Routes = [

  {
     path: 'login', component: LoginComponent
  },
  {
    path: 'signup', component: SignupComponent
  },
  
  {
    path: "admin",
    component: AdminPage
  }
  { path: '', component: HomeComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
