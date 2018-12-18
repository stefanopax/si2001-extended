import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SkillNewComponent } from "./skill-new/skill-new.component";
import { SkillEditComponent } from "./skill-edit/skill-edit.component";
import { SkillDetailComponent } from "./skill-detail/skill-detail.component";

const skillRoutes: Routes = [
  { path: 'skill/new', component: SkillNewComponent },
  { path: 'skill/:id/edit', component: SkillEditComponent },
  { path: 'skill/:id',  component: SkillDetailComponent }
];

@NgModule({
  imports: [RouterModule.forChild(skillRoutes)],
  exports: [RouterModule]
})
export class SkillRoutingModule { }
