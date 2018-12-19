import { Component, OnInit } from '@angular/core';
import { UtilityService } from "../../utility.service";
import { ActivatedRoute } from '@angular/router';
import { User } from "../user";
import { UserService } from "../user.service";
import { SkillService } from "../../skill/skill.service";
import { StatusService } from "../../status/status.service";

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.css']
})
export class UserEditComponent implements OnInit {

  id;
  user;
  status;
  roles;
  skills;
  model: User;
  submitted = false;

  constructor(
    private utilityService: UtilityService,
    private userService: UserService,
    private skillService: SkillService,
    private statusService: StatusService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Edit User | SI2001');

    // saving id param from url to discriminate between create and edit user
    this.id = this.getParamValues('id');

    // get roles to display in the select option
    this.utilityService.getRoles()
      .subscribe((result)=> {
        console.log(result);
        this.roles = result;
      });

    // get skills to display in the select option
    this.statusService.getStatus()
      .subscribe((result) => {
        console.log(result);
        this.status = result;
      });

    // get skills to display in the select option
    this.skillService.getSkills()
      .subscribe((result) => {
        console.log(result);
        this.skills = result;
      });

    if(this.id) {
      // get user requested
      this.userService.getOneUser(this.id)
        .subscribe((result) => {
          console.log(result);
          this.model = result;
        });
    }
    else{
      this.model = new User('', '', '', '', '', '', '', [], [], []);
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

  neweditUser() {
    if(this.id){
      console.log("Editing user..." + this.model);
      this.userService.editUser(this.id, this.model)
        .subscribe((result) => {
          console.log(result);
          this.user = result;
        });
    }
    else {
      console.log("Adding user..." + this.model);
      this.userService.addUser(this.model)
        .subscribe((result) => {
          console.log(result);
          this.model = <User> result;
        });
    }
  }

  newUser() {

  }

  /*
  deleteUser() {
    console.log("Adding user..." + this.model);
    this.userService.addUser(this.model)
      .subscribe((result) => {
        console.log(result);
        this.model = <User> result;
      });
  }
  */

}
