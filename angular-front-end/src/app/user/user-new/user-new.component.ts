import { Component, OnInit } from '@angular/core';
import { User } from "../user";
import { SkillService } from "../../skill/skill.service";
import { StatusService } from "../../status/status.service";
import { UtilityService } from "../../utility.service";
import { UserService } from "../user.service";

@Component({
  selector: 'app-user-new',
  templateUrl: './user-new.component.html',
  styleUrls: ['./user-new.component.css']
})
export class UserNewComponent implements OnInit {

  user;
  skills;
  status;
  submitted = false;
  model: User;
  roles = ['ROLE_USER', 'ROLE_ADMIN'];
  constructor(
    private utilityService: UtilityService,
    private userService: UserService,
    private skillService: SkillService,
    private statusService: StatusService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('New User | SI2001');

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

    this.model = new User('', '', '', '', '', '', '', '', [], []);
  }

  get diagnostic() {
    return JSON.stringify(this.model);
  }

  onSubmit() {
    this.submitted = true;
  }

  newUser() {
    console.log("Adding user..." + this.model);
    let user="";
    for (let key in this.model) {
      let value = this.model[key];
      user+=key+"="+value+"&";
    }
    this.userService.addUser(user)
      .subscribe((result) => {
        console.log(result);
        this.user = result;
      });
  }
}
