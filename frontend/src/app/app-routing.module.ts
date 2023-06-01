import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminPage } from './admin/admin.component';
import { WineriesPage } from './wineries/wineries.component';

const routes: Routes = [
  {
    path: "admin",
    component: AdminPage
  },
  {
    path: "wineries",
    component: WineriesPage
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
