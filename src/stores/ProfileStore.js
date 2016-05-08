import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';
import SessionStore from './SessionStore';
import { waitFor } from '../util/AppDispatcher';

class ProfileStore extends BaseStore {

  constructor() {
    super();
    this.subscribe(() => this._registerToActions.bind(this));
    
	this._setDefault();
	
	this.meta = {
		name : "ProfileStore"
	};
	
  }
	
  _registerToActions(payload) {
	 
    switch(payload.type) {
		
		case ActionTypes.REQUEST_LOGIN_USER:	
			this.logChange(payload);		
			this.onRequest();
			this.emitChange();
			break;
		
		case ActionTypes.REQUEST_LOGIN_USER_SUCCESS:
			waitFor(SessionStore);		
			this.logChange(payload);	
			this.onSuccess(payload.action.body.data.userSession);
			this.emitChange();
			break;

			console.log('** ATTEMPTING TO GET USER DETAILS...');
		
		case ActionTypes.REQUEST_USER:	
			this.logChange(payload);		
			this.onRequest();
			this.emitChange();
			break;

		case ActionTypes.REQUEST_USER_SUCCESS:	
			this.logChange(payload);		
			this.onSuccess(payload.action.body.data.userSession);
			this.emitChange();
			break;
			
		case ActionTypes.REQUEST_USER_ERROR:	
			this.logChange(payload);		
			this.onError(payload.action.error);
			this.emitChange();
			break;

		case ActionTypes.LOGOUT_USER:
			this.logChange(payload);
			this.onLogout();
			this.emitChange();
			break;
			
		  default:
			break;
    };
  }

  onRequest() {
	this._loading = true;
  }
	
  onSuccess(profile) {
	this._profile  = profile;
	this._loading = false;
  }
	
  onLogout() {
	this._setDefault();
  }
	
  onError(error) {
	this._profile  = false;
	this._loading = false;
	this._error = error;
  }
	
  getState() {
    return {
      loading: this._loading,
      all: this._profile,
	  error: this._error,
	  isReady: this.isReady()
    };
  }
  	
	_setDefault(){
		this._profile = false;
		this._loading = false;
		this._error = false;
	}
	
    isReady(){
	  if(this._profile === false ||  this._loading){
		  return false;
	  }else{
		  return true;
	  }
  }
  
}

export default new ProfileStore();