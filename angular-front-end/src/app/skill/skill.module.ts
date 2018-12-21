import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { SkillRoutingModule } from './skill-routing.module';
import { SkillDetailComponent } from './skill-detail/skill-detail.component';
import { SkillEditComponent } from './skill-edit/skill-edit.component';

@NgModule({
  declarations: [
    SkillDetailComponent,
    SkillEditComponent
  ],
  imports: [
    CommonModule,
    SkillRoutingModule,
    FormsModule
  ]
})
export class SkillModule { }
