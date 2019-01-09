import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Status } from './status';
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})

export class StatusService {

  private statusUrl = 'http://localhost:8000/api/status';  // URL to web api
  constructor(
    private _http: HttpClient) { }

  /** GET status from the server */
  getStatus (): Observable<any> {
    return this._http.get(this.statusUrl);
  }

  /** GET one status from the server */
  getOneStatus (id: string): Observable<any> {
    let url = `${this.statusUrl}/${id}`;
    return this._http.get(url);
  }

  /** POST status to server */
  addStatus (myStatus: Status) {
    return this._http.post(this.statusUrl, myStatus);
  }

  /** PUT status to server */
  editStatus (id: string, myStatus: Status) {
    let url = `${this.statusUrl}/${id}`;
    return this._http.put(url, myStatus);
  }

  /** DELETE status from server */
  deleteStatus (id: string) {
    let url = `${this.statusUrl}/${id}`;
    return this._http.delete(url);
  }

}
