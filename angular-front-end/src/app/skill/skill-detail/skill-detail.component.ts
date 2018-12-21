import { Component, OnInit } from '@angular/core';
import { UtilityService } from "../../utility.service";
import { ActivatedRoute } from '@angular/router';
import { SkillService } from "../skill.service";

@Component({
  selector: 'app-skill-detail',
  templateUrl: './skill-detail.component.html',
  styleUrls: ['./skill-detail.component.css']
})
export class SkillDetailComponent implements OnInit {

  id;
  skill;
  submitted = false;

  constructor(
    private utilityService: UtilityService,
    private skillService: SkillService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Skill | SI2001');
    this.id=this.getParamValues('id');
    this.skillService.getOneSkill(this.id)
      .subscribe((result) => {
        console.log(result);
        this.skill = result;
      });
  }

  getParamValues(id: string): string {
    return this.
      route.snapshot.params[id];
  }

  onSubmit() {
    this.submitted = true;
  }

  deleteSkill() {
    console.log("Deleting skill...");
    this.skillService.deleteSkill(this.id)
      .subscribe((result) => {
        console.log(result);
        this.skill = result;
      });
  }

}
