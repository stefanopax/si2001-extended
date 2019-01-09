import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, BehaviorSubject } from 'rxjs';
import { Title } from '@angular/platform-browser';

@Injectable({
  providedIn: 'root'
})
export class UtilityService {

  private roleUrl = 'http://localhost:8000/api/role';
  private myInput = new BehaviorSubject<string>("");
  input = this.myInput.asObservable();

  constructor(
    private titleService: Title,
    private _http: HttpClient
  ) { }

  setTitle(newTitle: string) {
    this.titleService.setTitle(newTitle);
  }

  /** GET roles from the server */
  getRoles(): Observable<any> {
    return this._http.get(this.roleUrl);
  }
}
