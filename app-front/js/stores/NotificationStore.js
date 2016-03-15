import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class NotificationStore extends BaseStore {
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		this.notifications = [];
	}
	
	 _registerToActions(action) {
		switch(action.type) {

		case ActionTypes.REQUEST_AUTHORIZED_USER_SUCCESS:
			//console.log(action.action.body.data.userSession);
			//this.emitChange();
			break;
			
		  default:
			break;
		};
	  }
	
	getAll(){
		return this.notifications;
	}

	
}

export default new NotificationStore();