import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import jwt_decode from 'jwt-decode';
import SessionActionCreators from '../actions/SessionActionCreators';

class SessionStore extends BaseStore {

  constructor() {
    super();
	this._jwt = false;
    this.subscribe(() => this._registerToActions.bind(this));
    this._claims = false;
	this._details = false;
    this._errors = [];
    this._loading = false;

	this.meta = {
		name : "SessionStore"
	};
	
  }

  _registerToActions(payload) {
	 
    switch(payload.type) {
		
	  case ActionTypes.REQUEST_LOGIN_USER:	
		this.logChange(payload);		
		this.onLogin();
        this.emitChange();
        break;
	
      case ActionTypes.REQUEST_LOGIN_USER_SUCCESS:	
		this.logChange(payload);	
		let token = payload.action.body.data.userSession.token;	
		this.onLoginSuccess(token);
        this.emitChange();
        break;

      case ActionTypes.REQUEST_LOGIN_USER_ERROR:
		this.logChange(payload);
		this.onLogout();
        this._errors = payload.action.error;
		this._loading = false;
		this._details = false;
		console.log("&*&*&* autologin failed.");
        this.emitChange();
        break;

      case ActionTypes.LOGOUT_USER:
		this.logChange(payload);
		this.onLogout();
        this.emitChange();
        break;
	
	case ActionTypes.REQUEST_USER:	
		this.logChange(payload);		
		this.onLoginSuccess(payload.action.token);
        this.emitChange();
        break;
	
	case ActionTypes.REQUEST_USER_SUCCESS:	
		this.logChange(payload);		
		this._details  = payload.action.body.data.userSession;	
		this._loading = false;
        this.emitChange();
        break;
		
	case ActionTypes.REQUEST_USER_ERROR:	
		this.logChange(payload);		
		this.onLogout();	
        this.emitChange();
        break;
		
      default:
        break;
    };
  }

  onLogin() {
	console.log('&*&*&*& attempting auto-login in SessionStore');
	this._loading = true;
  }
	
onLoginSuccess(token) {
    this._jwt = token;
	localStorage.setItem("jv_jwt", token);
    this._claims = jwt_decode(token);
    this._errors = [];		
	this._loading = false;
	console.log("&*&*&* autologin success");
  }
	
  onLogout() {
    // clear it all
    this._jwt = null;
    this._claims = false;
    this._errors = [];
    this._loading = false;
    localStorage.removeItem('jv_jwt');
	this._details = false;
  }
	
  getState() {
    return {
      loading: this._loading,
      error: this._error,
      user: this.userFromClaims(),
      loggedIn: this.loggedIn(),
	  details: this._details,
	  isReady: this.isReady()
    };
  }
  
   get details() {
    return this._details;	
  }
  
  get errors() {
    return this._errors;
  }

  get jwt() {
    return this._jwt;
  }

  loggedIn() {
    return this._claims;
  }
  
   userFromClaims() {
    return this._claims;
  }
  
  isJWT(){
	  let x = localStorage.getItem('jv_jwt');
	  this._jwt = x;
	  return x;
  }
  
    isReady(){
	  if(this._loading == true || this._claims == false || this._details == false){
		  return false;
	  }else{
		  return true;
	  }
  }
  
}

export default new SessionStore();