import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UserRoutingModule } from './user-routing.module';
import { UserDetailComponent } from "./user-detail/user-detail.component";
import { UserNewComponent } from './user-new/user-new.component';

@NgModule({
  declarations: [
    UserDetailComponent,
    UserNewComponent
  ],
  imports: [
    CommonModule,
    UserRoutingModule
  ]
})
export class UserModule { }
