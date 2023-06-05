import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminPage } from './admin/admin.component';
import { WineriesPage } from './wineries/wineries.component';

import { LoginComponent } from './login/login.component';
import { SignupComponent} from './signup/signup.component';
import {  HomeComponent } from './home/home.component';
import { WinePage } from './wines/wines.component';

import { AuthGuard } from './_services/auth.guard';

const routes: Routes = [

  {
     path: 'login', component: LoginComponent
  },
  {
    path: 'signup', component: SignupComponent
  },
  {
    path: "admin",
    component: AdminPage,
    canActivate: [AuthGuard]
  },
  {
    path: "wineries",
    component: WineriesPage,
    canActivate: [AuthGuard]
  },
  {
    path: "wines",
    component: WinePage,
    canActivate: [AuthGuard]
  },
  { path: 'home', component: HomeComponent, canActivate: [AuthGuard] },
  { path: '', component: HomeComponent, canActivate: [AuthGuard] },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
