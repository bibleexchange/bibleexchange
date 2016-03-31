import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class LibraryStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._notes = [];
		this._notebooks = [];
		
		this.meta = {
			name : "LibraryStore"
		};
	}
	
	 _registerToActions(action) {
		 
		  switch(action.type){
			case ActionTypes.ADD_CHAPTER:
				this.logChange(action);
				//
				this.emitChange();
				break;
			  
			default:
			  return true;
		  }
	  }
	
	getAll(){
		
	}
//GETTERS:	

	get id(){
		return this._id;
	}
	
//END GETTERS
	
}

export default new LibraryStore();