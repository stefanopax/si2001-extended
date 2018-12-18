import { Injectable } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Status } from './status';

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
  postStatus (myStatus: Status): Observable<any> {
    return this._http.post(this.statusUrl, myStatus);
  }

}
