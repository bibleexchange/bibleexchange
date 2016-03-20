import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class AppStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this.data = {
			ready: false,
			globals: {},
			pages: [],
			item_num: 5
		  }
	}
	
	 _registerToActions(action) {
		 
		 console.log("AppStore heard a change!", action);
 
		  switch(action.type){
			  
			default:
			  return true;
		  }
	  }

}

export default new AppStore();