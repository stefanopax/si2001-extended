import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { UserComponent } from './user/user.component';
import { StatusComponent } from './status/status.component';
import { SkillComponent } from './skill/skill.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';

const routes: Routes = [
  { path: 'user', component: UserComponent },
  { path: 'skill', component: SkillComponent },
  { path: 'status', component: StatusComponent },
  { path: '', redirectTo: '/user', pathMatch: 'full' },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
