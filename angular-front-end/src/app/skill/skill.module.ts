import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SkillRoutingModule } from './skill-routing.module';
import { SkillDetailComponent } from './skill-detail/skill-detail.component';
import { SkillEditComponent } from './skill-edit/skill-edit.component';
import { SkillNewComponent } from './skill-new/skill-new.component';

@NgModule({
  declarations: [SkillDetailComponent, SkillEditComponent, SkillNewComponent],
  imports: [
    CommonModule,
    SkillRoutingModule
  ]
})
export class SkillModule { }
