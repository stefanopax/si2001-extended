import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UserDetailComponent } from "./user-detail/user-detail.component";
import { UserEditComponent } from "./user-edit/user-edit.component";

const userRoutes: Routes = [
  { path: 'user/new', component: UserEditComponent },
  { path: 'user/:id',
    children: [
      { path: '',component: UserDetailComponent },
      { path: 'edit', component: UserEditComponent}
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(userRoutes)],
  exports: [RouterModule]
})
export class UserRoutingModule { }
