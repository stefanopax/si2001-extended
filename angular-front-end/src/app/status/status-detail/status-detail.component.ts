import { Component, OnInit } from '@angular/core';
import { UtilityService } from "../../utility.service";
import { ActivatedRoute } from '@angular/router';
import { StatusService } from "../status.service";

@Component({
  selector: 'app-status-detail',
  templateUrl: './status-detail.component.html',
  styleUrls: ['./status-detail.component.css']
})
export class StatusDetailComponent implements OnInit {

  id;
  status;
  submitted = false;

  constructor(
    private utilityService: UtilityService,
    private statusService: StatusService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Status | SI2001');

    this.id=this.getParamValues('id');
    this.statusService.getOneStatus(this.id)
      .subscribe((result) => {
        console.log(result);
        this.status = result;
      });
  }

  onSubmit() {
    this.submitted = true;
  }

  getParamValues(id: string): string {
    return this.route.snapshot.params[id];
  }

  deleteStatus() {
    console.log("Deleting status...");
    this.statusService.deleteStatus(this.id)
      .subscribe((result) => {
        console.log(result);
        this.status = result;
      });
  }

}
