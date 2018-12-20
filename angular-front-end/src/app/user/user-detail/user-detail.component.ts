import { Component, OnInit } from '@angular/core';
import { UserService } from "../user.service";
import { ActivatedRoute } from '@angular/router';
import { UtilityService } from "../../utility.service";

@Component({
  selector: 'app-user-detail',
  templateUrl: './user-detail.component.html',
  styleUrls: ['./user-detail.component.css']
})
export class UserDetailComponent implements OnInit {

  user;
  id;
  submitted = false;

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

  onSubmit() {
    this.submitted = true;
  }

  deleteUser() {
    console.log("Deleting user...");
    this.userService.deleteUser(this.id)
      .subscribe((result) => {
        console.log(result);
        this.user = result;
      });
  }

}
