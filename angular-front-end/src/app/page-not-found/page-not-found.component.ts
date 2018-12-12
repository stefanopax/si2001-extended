import { Component, OnInit } from '@angular/core';
import {UtilityService} from "../utility.service";

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.css']
})
export class PageNotFoundComponent implements OnInit {

  constructor(
    private utilityService: UtilityService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Error | SI2001');
  }

}
