import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { UserRoutingModule } from './user-routing.module';
import { UserDetailComponent } from "./user-detail/user-detail.component";
import { UserEditComponent } from './user-edit/user-edit.component';

@NgModule({
  declarations: [
    UserDetailComponent,
    UserEditComponent
  ],
  imports: [
    CommonModule,
    UserRoutingModule,
    FormsModule
  ]
})
export class UserModule { }
