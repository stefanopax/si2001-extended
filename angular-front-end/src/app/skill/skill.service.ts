import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Skill } from './';

@Injectable({
  providedIn: 'root'
})
export class SkillService {

  private skillUrl = 'http://localhost:8000/api/skill';  // URL to web api
  constructor(
    private _http: HttpClient) { }

  /** GET skills from the server */
  getSkills (): Observable<any> {
    return this._http.get(this.skillUrl);
  }
  /** GET skills from the server */
  getSkill (id: number): Observable<any> {
    return this._http.get(this.skillUrl);
  }

  /** POST skill to server */
  postSkill (mySkill: Skill): Observable<any> {
    return this._http.post(this.skillUrl, mySkill);
  }

}
