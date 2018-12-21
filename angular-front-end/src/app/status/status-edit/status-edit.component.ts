import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UtilityService } from "../../utility.service";
import { StatusService } from "../status.service";
import { Status } from "../status";

@Component({
  selector: 'app-status-edit',
  templateUrl: './status-edit.component.html',
  styleUrls: ['./status-edit.component.css']
})
export class StatusEditComponent implements OnInit {

  id;
  model;
  status;
  submitted=false;

  constructor(
    private utilityService: UtilityService,
    private statusService: StatusService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {

    // saving id param from url to discriminate between create and edit status
    this.id = this.getParamValues('id');

    // get status to display in the select option
    this.statusService.getStatus()
      .subscribe((result) => {
        console.log(result);
        this.status = result;
      });

    if(this.id) {
      this.utilityService.setTitle('Edit Status | SI2001');

      // get status requested
      this.statusService.getOneStatus(this.id)
        .subscribe((result) => {
          console.log(result);
          this.model = result;
        });
    }
    else {
      this.utilityService.setTitle('New Status | SI2001');
      this.model = new Status('');
    }

  }

  getParamValues(id: string): string {
    if(id)
      return this.route.snapshot.params[id];
    return '';
  }

  onSubmit() {
    this.submitted = true;
  }

  neweditStatus() {
    if(this.id){
      console.log("Editing status..." + this.model);
      this.statusService.editStatus(this.id, this.model)
        .subscribe((result) => {
          console.log(result);
          this.status = result;
        });
    }
    else {
      console.log("Adding status..." + this.model);
      this.statusService.addStatus(this.model)
        .subscribe((result) => {
          console.log(result);
          this.model = <Status> result;
        });
    }
  }

}
