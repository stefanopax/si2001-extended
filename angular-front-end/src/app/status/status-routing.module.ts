import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { StatusEditComponent } from "./status-edit/status-edit.component";
import { StatusDetailComponent } from "./status-detail/status-detail.component";

const statusRoutes: Routes = [
  { path: 'status/new', component: StatusEditComponent },
  { path: 'status/:id',
    children: [
      { path: '',component: StatusDetailComponent },
      { path: 'edit', component: StatusEditComponent}
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(statusRoutes)],
  exports: [RouterModule]
})
export class StatusRoutingModule { }
