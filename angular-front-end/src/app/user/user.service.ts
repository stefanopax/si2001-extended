import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpClientModule } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { User } from './user';

@Injectable({
  providedIn: 'root'
})

export class UserService {

    private userUrl = 'http://localhost:8000/api/user';  // URL to web api
    constructor(
        private _http: HttpClient) { }

    /** GET users from the server */
    getUsers (): Observable<any> {
      return this._http.get(this.userUrl);
    }

    /** GET users from the server */
    getOneUser (id: string): Observable<any> {
      let url = `${this.userUrl}/${id}`;
      return this._http.get(url);
    }

    /** POST user to server */
    addUser (myUser: string) {
      let url = `${this.userUrl}?${myUser}`;
      return this._http.post(url,'');
    }

}
