import { Component, OnInit } from '@angular/core';
import { UserService } from "../user.service";
import { ActivatedRoute } from '@angular/router';
import { UtilityService } from "../../utility.service";
import {User} from "../user";

@Component({
  selector: 'app-user-detail',
  templateUrl: './user-detail.component.html',
  styleUrls: ['./user-detail.component.css']
})
export class UserDetailComponent implements OnInit {

  user;
  id;
  skills;
  status;
  roles;
  submitted = false;
  model: User;

  constructor(
    private utilityService: UtilityService,
    private userService: UserService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {

  this.utilityService.setTitle('User | SI2001');

  this.id=this.getParamValues('id');

  this.userService.getOneUser(this.id)
    .subscribe((result) => {
      console.log(result);
      this.user = result;
    });
  }

  getParamValues(id: string): string {
    return this.route.snapshot.params[id];
  }

  get diagnostic() {
    return JSON.stringify(this.model);
  }

  onSubmit() {
    this.submitted = true;
  }

  newUser() {
    console.log("Adding user..." + this.model);
    this.userService.addUser(this.model)
      .subscribe((result) => {
        console.log(result);
        this.user = result;
      });
  }

  /*
  deleteUser() {
    console.log("Deleting user..." + this.model);
    this.userService.addUser(this.model)
      .subscribe((result) => {
        console.log(result);
        this.user = result;
      });
  }
  */

}
