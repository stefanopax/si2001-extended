import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from './user';

@Injectable({
  providedIn: 'root'
})

export class UserService {

    private userUrl = 'http://localhost:8000/api/user';  // URL to web api

    constructor(
        private _http: HttpClient
    ) { }

    /** GET users from the server */
    getUsers (): Observable<any> {
      return this._http.get(this.userUrl);
    }

    /** GET user from the server */
    getOneUser (id: string): Observable<any> {
      let url = `${this.userUrl}/${id}`;
      return this._http.get(url);
    }

    /** GET users by country */
    getUsersByCountry (country: string): Observable<any> {
      let url = `${this.userUrl}search/${country}`;
      return this._http.get(url);
    }

    /** POST user to server */
    addUser (myUser: User) {
      return this._http.post(this.userUrl, myUser);
    }

    /** PUT user to server */
    editUser (id: string, myUser: User) {
      let url = `${this.userUrl}/${id}`;
      return this._http.put(url, myUser);
    }

    /** DELETE user from server */
    deleteUser (id: string) {
      let url = `${this.userUrl}/${id}`;
      return this._http.delete(url);
    }

}
