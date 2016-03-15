import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class BibleChapterStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._id = 2;
		this._reference = "Genesis 2";
		this._url = "/bible/genesis/2";
		this._next = ['3','\/bible\/genesis\/3'];
		this._previous = ['1','\/bible\/genesis\/1'];
		this._chapters = [];
		
		this._errors = [];
	}
	
	 _registerToActions(action) {
		 
		 console.log("BibleChapter Store heard a change!" + action.type);
		 
		  switch(action.type){
			case ActionTypes.ADD_CHAPTER:
			  this.addChapter(action.data, action.searched);
			  break;
			case ActionTypes.GET_CHAPTER:
			  this.getChapter(action.data, action.searched);
			  break;
			case ActionTypes.FETCH_CHAPTER:
				this.fetchChapter();
			  break;
			case ActionTypes.FETCH_FAILED:
			  this.fetchFailed();
			  break;
			case ActionTypes.KEEP_AND_CLEAR_CHAPTER:
			  this.keepAndClear(action.data);
			  break; 
			default:
			  return true;
		  }
	  }
	
	addChapter(data,reference=null){
		this._id = data.id;
		this._reference =  data.reference;
		this._url =  data.url;
		this._next[0] = data.next[0];
		this._next[1] =  data.next[1];
		this._previous[0] = data.previous[0];
		this._previous[1] = data.previous[1];	
		this._push(data);
	}
	
	getChapter(data,reference=null){
		
		this._id = data.id;
		
		if(reference !== null){
			this._reference = reference;
		}else{
			this._reference =  data.reference;
		}
		
		this._url =  data.url;
		this._next[0] = data.next[0];
		this._next[1] =  data.next[1];
		this._previous[0] = data.previous[0];
		this._previous[1] = data.previous[1];
		this._chapters = [data];
		
	}
	
	getAll(){
		
		const x = {
			id: this._id,
			reference: this._reference,
			url: this._url,
			next: this._next,
			previous: this._previous,
			chapters: this._chapters
		};
		
		return x;
	}
//GETTERS:	

	get id(){
		return this._id;
	}
	
	get reference(){
		return this._reference;
	}
	
	get url(){
		return this._url;
	}
	
	get next(){
		return this._next;
	}
	
	get previous(){
		return this._previous;
	}
	
	get chapters(){
		return this._chapters;
	}
	
	get errors(){
		return this._errors;
	}
	
//END GETTERS
	
	fetchChapter(){
		console.log("status: fetching...");
	}
	fetchFailed(){
		console.log("status: fetch failed!");
		this._errors = ['Cannot find that Scripture reference. Sorry :( '];
	}
	
	keepAndClear(data){
		
		console.log("status: cleared array to selected only!");
		
		this._chapters = [];
		this._errors = [];
		
		this.getChapter(data);
	}
}

export default new BibleChapterStore();