import LaravelApi from './LaravelApi';
const authUser = [];

class Auth {
    constructor(){
        this.authenticated = false
    }
    
    isAuthenticated(user){
       LaravelApi.get('/AuthUser').then((response) => {
          authUser.push(response.data[1]);
          console.log(authUser);
       });
      if(authUser === user){
          return true;
      }else return false . authUser;
    }
}

export default new Auth();