import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class UserStore extends BaseStore {
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		this.details = {
				notifications:{
					unread:['test message','hi','great to  hear','no way']
				},
				isAdmin:false,
				auth:false
		};
		
		this.meta = {
			name : "UserStore"
		};
		//this.logChange(action);
		
	}
	
	 _registerToActions(action) {
		switch(action.type) {

		  case ActionTypes.REQUEST_LOGIN_USER_SUCCESS:
			
			//this.emitChange();
			break;

		  case ActionTypes.REQUEST_LOGIN_USER_ERROR:
			//this.emitChange();
			break;

		  case ActionTypes.LOGOUT_USER:
			//this.emitChange();
			break;

		case ActionTypes.REQUEST_AUTHORIZED_USER_SUCCESS:
			this.details = action.action.body.data.userSession;
			this.details.auth = true;
			this.emitChange();
			break;
			
		  default:
			break;
		};
	  }
	
	getAuthorizedUser(){
		return this.details;
	}

}

export default new UserStore();