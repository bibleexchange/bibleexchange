import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import books from '../data/BibleBooks';

class BibleStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._books = books.list;
		
		this._nav = [];
		
		this.meta = {
			name : "BibleStore"
		};
		//this.logChange(action);
	}
	
	 _registerToActions(action) {
 
		  switch(action.type){			  
			
			case ActionTypes.BIBLE_URL_CHANGED:
				this.logChange(action);
				this._nav.push(action.data);
				this.emitChange();
			  break;
			  
			default:
			  return true;
		  }
	  }
	
//GETTERS:	
	
	get books(){
		return this._books;
	}
	
	get nav(){
		return this._nav;
	}

}

export default new BibleStore();