import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { UserDetailComponent } from "./user-detail/user-detail.component";
import { UserNewComponent } from "./user-new/user-new.component";
import { UserEditComponent } from "./user-edit/user-edit.component";

const userRoutes: Routes = [
  { path: 'user/new', component: UserNewComponent },
  { path: 'user/:id/edit', component: UserEditComponent },
  { path: 'user/:id',  component: UserDetailComponent }
];

@NgModule({
  imports: [RouterModule.forChild(userRoutes)],
  exports: [RouterModule]
})
export class UserRoutingModule { }
