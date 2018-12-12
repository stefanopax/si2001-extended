import { Component, OnInit } from '@angular/core';
import {UserService} from "../user.service";
import { ActivatedRoute, ParamMap } from '@angular/router';
import { switchMap } from 'rxjs/operators';

@Component({
  selector: 'app-user-detail',
  templateUrl: './user-detail.component.html',
  styleUrls: ['./user-detail.component.css']
})
export class UserDetailComponent implements OnInit {

  user;
  id;

  constructor(
    private userService: UserService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
   this.id=this.getParamValues();
    this.userService.getOneUser(this.id)
      .subscribe((result) => {
        console.log(result);
        this.user = result;
      });
  }

  getParamValues(): string {
    return this.route.snapshot.params['id'];
  }

}
