import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UtilityService } from "../../utility.service";
import { SkillService } from "../skill.service";
import { Skill } from "../skill";

@Component({
  selector: 'app-skill-edit',
  templateUrl: './skill-edit.component.html',
  styleUrls: ['./skill-edit.component.css']
})
export class SkillEditComponent implements OnInit {

  id;
  model;
  skill;
  submitted = false;

  constructor(
    private utilityService: UtilityService,
    private skillService: SkillService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {

    // saving id param from url to discriminate between create and edit skill
    this.id = this.getParamValues('id');

    // get skills to display in the select option
    this.skillService.getSkills()
      .subscribe((result) => {
        console.log(result);
        this.skill = result;
      });

    if(this.id) {
      this.utilityService.setTitle('Edit Skill | SI2001');

      // get skill requested
      this.skillService.getOneSkill(this.id)
        .subscribe((result) => {
          console.log(result);
          this.model = result;
        });
    }
    else {
      this.utilityService.setTitle('New Skill | SI2001');
      this.model = new Skill('');
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

  neweditSkill() {
    if(this.id){
      console.log("Editing skill..." + this.model);
      this.skillService.editSkill(this.id, this.model)
        .subscribe((result) => {
          console.log(result);
          this.skill = result;
        });
    }
    else {
      console.log("Adding skill..." + this.model);
      this.skillService.addSkill(this.model)
        .subscribe((result) => {
          console.log(result);
          this.model = <Skill> result;
        });
    }
  }

}
