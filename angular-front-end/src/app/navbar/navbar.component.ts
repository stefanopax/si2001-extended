import { Component, OnInit } from '@angular/core';
import { UtilityService } from "../utility.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  input: string;

  constructor(
    private utilityService: UtilityService
  ) { }

  ngOnInit() {
  }

  sendValues(){
    this.utilityService.input = this.input;
  }
}
