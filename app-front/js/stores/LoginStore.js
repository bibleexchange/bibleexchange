import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import jwt_decode from 'jwt-decode';

class LoginStore extends BaseStore {

  constructor() {
    super();
    this.subscribe(() => this._registerToActions.bind(this));
    this._user = null;
    this._error = [];
    this._jwt = null;

    //attempt auto-login
    console.log('&*&*&*& attempting auto-login in LoginStore');
    this._autoLogin();

	this.meta = {
		name : "LoginStore"
	};
	//this.logChange(action);
	
  }

  _registerToActions(action) {
	 
    switch(action.type) {
      case ActionTypes.REQUEST_LOGIN_USER_SUCCESS:	
		this.logChange(action);
		console.log(action.action.body);
		
        this._jwt = action.action.body.data.userSession.token;
        localStorage.setItem("jv_jwt", this._jwt);
        this._user = jwt_decode(this._jwt);
        this._error = [];
        this.emitChange();
        break;

      case ActionTypes.REQUEST_LOGIN_USER_ERROR:
		this.logChange(action);
        this._error = action.action.error;
        this.emitChange();
        break;

      case ActionTypes.LOGOUT_USER:
		this.logChange(action);
        this._user = null;
        this._error = [];
        this._jwt = null;
        localStorage.setItem("jv_jwt", "");
        this.emitChange();
        break;

      default:
        break;
    };
  }

  _autoLogin () {

    let jwt = localStorage.getItem("jv_jwt");
    if (jwt) {
      this._jwt = jwt;
      this._user = jwt_decode(this._jwt);
      console.log("&*&*&* autologin success")
    }
	
  }

  get user() {
    return this._user;
  }

  get error() {
    return this._error;
  }

  get jwt() {
    return this._jwt;
  }

  isLoggedIn() {
    return !!this._user;
  }
}

export default new LoginStore();