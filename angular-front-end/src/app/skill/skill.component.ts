import { Component, OnInit } from '@angular/core';
import { SkillService } from './skill.service';
import { UtilityService } from "../utility.service";

@Component({
  selector: 'app-skill',
  templateUrl: './skill.component.html',
  styleUrls: ['./skill.component.css']
})

export class SkillComponent implements OnInit {

  skills;
  title = 'Skill | SI2001';
  constructor(
    private skillService: SkillService,
    private utilityService: UtilityService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Skills | SI2001');
    this.skillService.getSkills()
      .subscribe((result) => {
        console.log(result);
        this.skills = result;
      });
  }
}
