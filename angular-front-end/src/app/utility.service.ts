import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Title }     from '@angular/platform-browser';

@Injectable({
  providedIn: 'root'
})
export class UtilityService {

  private roleUrl = 'http://localhost:8000/api/role';

  constructor(
    private titleService: Title,
    private _http: HttpClient
  ) { }

  setTitle(newTitle: string) {
    this.titleService.setTitle(newTitle);
  }

  /** GET roles from the server */
  getRoles (): Observable<any> {
    return this._http.get(this.roleUrl);
  }
}
