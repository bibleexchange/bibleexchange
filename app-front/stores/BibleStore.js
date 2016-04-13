import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';
import books from '../util/BibleBooks';

class BibleStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._books = books.list;
		
		this._nav = [];
		
		this.meta = {
			name : "BibleStore"
		};
	}
	
	 _registerToActions(payload) {
 
		  switch(payload.type){			  
			
			case ActionTypes.GET_CHAPTER:
				this.logChange(payload);
				this._nav.unshift({url: payload.action.body.data.biblechapters[0].url, title:payload.action.body.data.biblechapters[0].reference});
				this.emitChange();
			  break;
			
			case ActionTypes.GET_VERSE:
				this.logChange(payload);
				this._nav.unshift({url:payload.action.body.data.bibleverses[0].url, title:payload.action.body.data.bibleverses[0].reference});
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