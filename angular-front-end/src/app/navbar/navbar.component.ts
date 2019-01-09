import { Component, OnInit } from '@angular/core';
import { Subject } from 'rxjs';
import { Router } from '@angular/router'

export const myInput$ = new Subject<string>();

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  input: string;
  baseUrl: string;

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.baseUrl = location.origin;
  }

  sendValues() {
    this.router.navigate(['/user']);
    localStorage.setItem('search', 'myString');
    myInput$.next(this.input);
  }

}
