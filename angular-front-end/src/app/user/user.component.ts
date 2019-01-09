import { Component, OnInit } from '@angular/core';
import { UserService } from './user.service';
import { UtilityService } from '../utility.service';
import { myInput$ } from '../navbar/navbar.component';
import { filter, cloneDeep }  from 'lodash';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  users;
  originalUsers;
  myInput : string;

  constructor(
    private userService: UserService,
    private utilityService: UtilityService,
  ) { }

  ngOnInit() {
    this.utilityService.setTitle('Employees | SI2001');

    myInput$.asObservable().subscribe(myInput => {
      this.myInput = myInput;
      this.users = filter(this.originalUsers, (user) => {
        return user.country === this.myInput;
      });
      console.log(this.users)
    });

    if(localStorage.getItem('search')) {
      // comes from navbar search function
      this.users = filter(this.originalUsers, (user) => {
        return user.country === myInput$;
      });
      localStorage.removeItem('search')
    }
    else {
      this.userService.getUsers()
        .subscribe((result) => {
          console.log(result);
          this.users = result;
          this.originalUsers = cloneDeep(this.users);
        });
    }
  }

}
