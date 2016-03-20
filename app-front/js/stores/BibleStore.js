import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import books from '../data/BibleBooks';

class BibleStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._books = books.list;
		
		this._nav = [];
		
		this._verse = {
			id: null,
			b:null,
			c:null,
			v:null,
			body:null,
			reference:null,
			url:null,
			chapterURL:null,
			bible_chapter_id:null,
			notes:[],
			errors:[],
		};
		
	}
	
	 _registerToActions(action) {
		 
		 console.log("BibleStore heard a change!" + action.type);
 
		  switch(action.type){
			
			case ActionTypes.FETCH_VERSE:
				this.fetchVerse();
				this.emitChange();
			  break;
			case ActionTypes.GET_VERSE:
				this.updateVerse(action.action.body.data.bibleverses[0]);
				this.emitChange();
			  break;	
			  
			case ActionTypes.ADD_CHAPTER:
				this.emitChange();
			  break;
			
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
	
	get verse(){
		return this._verse;
	}
	
	get nav(){
		return this._nav;
	}

}

export default new BibleStore();