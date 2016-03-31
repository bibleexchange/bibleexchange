import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class BibleChapterStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._id = null;
		this._reference = null;
		this._url = null;
		this._next = [];
		this._previous = [];
		this._chapters = [];
		
		this._fetching = true;
		
		this._errors = [];
		
		this.meta = {
			name : "BibleChapterStore"
		};
		
	}
	
	 _registerToActions(payload) {
		 
		  switch(payload.type){
			case ActionTypes.ADD_CHAPTER:
				this.logChange(payload);
				this.addChapter(payload.action.body.data.biblechapters[0], payload.action.searched);
				this.emitChange();				
			  break;
			case ActionTypes.GET_CHAPTER:
				this.logChange(payload);
			  this.getChapter(payload.action.body.data.biblechapters[0]);
			  this.emitChange();
			  break;
			case ActionTypes.FETCH_CHAPTER:
				this.logChange(payload);
				this.fetchChapter();
			  break;
			case ActionTypes.FETCH_FAILED:
				this.logChange(payload);
			  this.fetchFailed();
			  break;
			case ActionTypes.KEEP_AND_CLEAR_CHAPTER:
				this.logChange(payload);
			  this.keepAndClear(payload.action.body.data.biblechapters[0]);
			  this.emitChange();
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
		this._chapters.push(data);
		
		this._fetching = false;
	}
	
	getChapter(data){
		this._id = data.id;
		this._reference =  data.reference;
		this._url =  data.url;
		this._next[0] = data.next[0];
		this._next[1] =  data.next[1];
		this._previous[0] = data.previous[0];
		this._previous[1] = data.previous[1];
		this._chapters = [data];
		
		this._fetching = false;
		
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
	
	get fetching(){
		return this._fetching;
	}
	
	get errors(){
		return this._errors;
	}
	
//END GETTERS
	
	fetchChapter(){
		this._fetching = true;
	}
	fetchFailed(){
		console.log("status: fetch failed!");
		this._fetching = false;
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