import { BrowserModule, Title } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserComponent } from './user/user.component';
import { NavbarComponent } from './navbar/navbar.component';
import { StatusComponent } from './status/status.component';
import { SkillComponent } from './skill/skill.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { UserModule } from './user/user.module';
import { StatusModule } from './status/status.module';
import { SkillModule } from './skill/skill.module';

@NgModule({
  declarations: [
    AppComponent,
    UserComponent,
    NavbarComponent,
    StatusComponent,
    SkillComponent,
    PageNotFoundComponent,
  ],
  imports: [
    BrowserModule,
    UserModule,
    StatusModule,
    SkillModule,
    AppRoutingModule,
    HttpClientModule,
],
  providers: [
    Title
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
