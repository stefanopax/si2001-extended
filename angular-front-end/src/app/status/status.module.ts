import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { StatusRoutingModule } from './status-routing.module';
import { StatusDetailComponent } from './status-detail/status-detail.component';
import { StatusEditComponent } from './status-edit/status-edit.component';
import { StatusNewComponent } from './status-new/status-new.component';

@NgModule({
  declarations: [StatusDetailComponent, StatusEditComponent, StatusNewComponent],
  imports: [
    CommonModule,
    StatusRoutingModule
  ]
})
export class StatusModule { }
