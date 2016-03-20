import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import books from '../data/BibleBooks';

class BibleStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._books = books.list;
		
		this._nav = [];
		
	}
	
	 _registerToActions(action) {
		 
		 console.log("BibleStore heard a change!" + action.type);
 
		  switch(action.type){			  
			
			case ActionTypes.BIBLE_URL_CHANGED:
				this._nav.push(action.data);
				this.emitChange();
			  break;
						
			case ActionTypes.GET_CHAPTER:
			  console.log(action.action.body.data.biblechapters[0]);
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