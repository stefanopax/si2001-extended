import { Component, OnInit } from '@angular/core';
import { UserService } from './user.service';
import { UtilityService } from "../utility.service";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  users;

  constructor(
    private userService: UserService,
    private utilityService: UtilityService
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Employees | SI2001');

    this.userService.getUsers()
      .subscribe((result) => {
        console.log(result);
        this.users = result;
    });

    if(this.utilityService.input)
      this.showCountry(this.utilityService.input)

  }

  showCountry(country: string) {
    console.log("Sono in user e ricevo: "+ country)
  }

}
