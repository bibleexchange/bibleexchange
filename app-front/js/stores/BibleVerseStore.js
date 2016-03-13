import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';

class BibleVerseStore extends BaseStore {
	
	constructor(){
		super();
		this._verse = null;
		this._error = null;
	}
	
	 _registerToActions(action) {
		  switch(action.type){
			case ActionTypes.FETCH_VERSE:
				this.fetchVerse();
				this.emitChange();
			  break;
			case ActionTypes.GET_VERSE:
				this.getVerse(action.data);
				this.emitChange();
			  break;	
			default:
			  return true;
		  }
	  }
	
	
	///GETTERS
	
	get error(){
		return this._error;
	}
	
	get verse(){
		return this._error;
	}
	
	///END OF GETTERS
	
	updateVerse(data){
		this._verse.id = data.id;
		this._verse.body =  data.t;
		this._verse.reference =  data.reference;
		this._verse.url =  data.url;
		this._verse.bible_chapter_id = data.bible_chapter_id;
		this._verse.notes = data.notes;
	}
	
	fetchVerse(){
		console.log("status: fetching...");
	}
	fetchFailed(){
		console.log("status: fetch failed!");
		this._error = 'Cannot find that Scripture reference. Sorry :( ';
	}
}

export default new BibleVerseStore();