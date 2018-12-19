export class User {

  constructor(
    public username: string,
    public password: string,
    public name: string,
    public surname: string,
    public birthday?: string,
    public country?: string,
    public link?: string,
    public status?: any,
    public roles?: any,
    public skills?: any
  ) { }

}
