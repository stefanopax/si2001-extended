import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Skill } from './skill';

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
  getOneSkill (id: string): Observable<any> {
    let url = `${this.skillUrl}/${id}`;
    return this._http.get(url);
  }

  /** POST skill to server */
  addSkill (mySkill: Skill) {
    return this._http.post(this.skillUrl, mySkill);
  }

  /** PUT skill to server */
  editSkill (id: string, mySkill: Skill) {
    let url = `${this.skillUrl}/${id}`;
    return this._http.put(url, mySkill);
  }

  /** DELETE skill from server */
  deleteSkill (id: string) {
    let url = `${this.skillUrl}/${id}`;
    return this._http.delete(url);
  }

}
