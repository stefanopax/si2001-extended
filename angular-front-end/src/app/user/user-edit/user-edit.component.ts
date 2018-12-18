import { Component, OnInit } from '@angular/core';
import { UtilityService } from "../../utility.service";
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

  submitted = false;
  status;
  skills;
  constructor(
    private utilityService: UtilityService,
  private userService: UserService,
  private skillService: SkillService,
  private statusService: StatusService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Edit User | SI2001');
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
  }

  onSubmit(){
    this.submitted = true;
  }

  editUser() {
    console.log("Editing user...");
  }
}
