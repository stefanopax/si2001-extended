import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { StatusNewComponent } from "./status-new/status-new.component";
import { StatusEditComponent } from "./status-edit/status-edit.component";
import { StatusDetailComponent } from "./status-detail/status-detail.component";

const statusRoutes: Routes = [
  { path: 'status/new', component: StatusNewComponent },
  { path: 'status/:id/edit', component: StatusEditComponent },
  { path: 'status/:id',  component: StatusDetailComponent }
];

@NgModule({
  imports: [RouterModule.forChild(statusRoutes)],
  exports: [RouterModule]
})
export class StatusRoutingModule { }
