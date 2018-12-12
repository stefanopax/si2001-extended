import { Component, OnInit } from '@angular/core';
import { StatusService } from './status.service';
import { Status } from "./status";
import {UtilityService} from "../utility.service";

@Component({
  selector: 'app-status',
  templateUrl: './status.component.html',
  styleUrls: ['./status.component.css']
})

export class StatusComponent implements OnInit {

  allstatus;
  title = 'Status | SI2001';
  constructor(
    private statusService: StatusService,
    private utilityService: UtilityService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Status | SI2001');
    this.statusService.getStatus()
      .subscribe((result) =>{
        console.log(result);
        this.allstatus = result;
    });
  }

}
