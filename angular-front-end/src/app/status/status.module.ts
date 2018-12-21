import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { StatusRoutingModule } from './status-routing.module';
import { StatusDetailComponent } from './status-detail/status-detail.component';
import { StatusEditComponent } from './status-edit/status-edit.component';

@NgModule({
  declarations: [
    StatusDetailComponent,
    StatusEditComponent
  ],
  imports: [
    CommonModule,
    StatusRoutingModule,
    FormsModule
  ]
})
export class StatusModule { }
