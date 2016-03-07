import { EventEmitter } from "events";

class UserStore extends EventEmitter {
	constructor(){
		super();
		
		this.details = {
				notifications:{
					unread:['test message','hi','great to  hear','no way']
				},
				isAdmin:false,
				auth:false
		};
		
	}
	
	getAuthorizedUser(){
	
		return this.details;
		
	}

}

const userStore = new UserStore;

export default userStore;