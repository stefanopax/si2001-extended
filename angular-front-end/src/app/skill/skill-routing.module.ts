import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SkillEditComponent } from "./skill-edit/skill-edit.component";
import { SkillDetailComponent } from "./skill-detail/skill-detail.component";

const skillRoutes: Routes = [
  { path: 'skill/new', component: SkillEditComponent },
  { path: 'skill/:id',
    children: [
      { path: '',component: SkillDetailComponent },
      { path: 'edit', component: SkillEditComponent}
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(skillRoutes)],
  exports: [RouterModule]
})
export class SkillRoutingModule { }
