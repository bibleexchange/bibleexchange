import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import BibleChapterStore from './BibleChapterStore';
import { waitFor } from '../dispatchers/AppDispatcher';

class BibleVerseStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));

		this._initialize();
		
		this.meta = {
			name : "BibleVerseStore"
		};
		
	}
	
	 _registerToActions(payload) {

		  switch(payload.type){
			case ActionTypes.FETCH_VERSE:
				this.logChange(payload);
				this.fetchVerse();
				this.emitChange();
			  break;
			
			case ActionTypes.GET_VERSE:
				this.logChange(payload);
				this.updateVerse(payload.action.body.data.bibleverses[0]);
				this.emitChange();
			  break;	
			
			case ActionTypes.CLEAR_VERSE:
				this.logChange(payload);
				this._initialize();
				this.emitChange();
			  break;			
			
			case ActionTypes.GET_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.logChange(payload);
				this._initialize();
				this.emitChange();
				break;
				
			default:
			  return true;
		  }
	  }
	
	getAll(){
		
		const x = {
			id: this._id,
			b: this._b,
			c: this._c,
			v: this._v,
			body: this._body,
			reference: this._reference,
			url: this._url,
			chapterURL: this._chapterURL,
			bible_chapter_id: this._bible_chapter_id,
			notes: this._notes
		};
		
		return x;
	}

	///GETTERS

	get id(){
		return this._id;
	}
	get b(){
		return this._b;
	}
	get c(){
		return this._c;
	}
	get v(){
		return this._v;
	}
	get body(){
		return this._body;
	}
	get reference(){
		return this._reference;
	}
	get url(){
		return this._url;
	}
	get chapterURL(){
		return this._chapterURL;
	}
	get bible_chapter_id(){
		return this._bible_chapter_id;
	}
	get notes(){
		return this._notes;
	}
	get errors(){
		return this._errors;
	}
	///END OF GETTERS
	
	updateVerse(data){
		this._id = data.id;
		this._b = data.b;
		this._c = data.c;
		this._v = data.v;
		this._body =  data.t;
		this._reference =  data.reference;
		this._url =  data.url;
		this._chapterURL =  data.chapterURL;
		this._bible_chapter_id = data.bible_chapter_id;
		this._notes = data.notes;
	}
	
	_initialize(){
		this._id = null;
		this._b = null;
		this._c = null;
		this._v = null;
		this._body = null;
		this._reference = null;
		this._url = null;
		this._chapterURL = null;
		this._bible_chapter_id = null;
		this._notes = [];

		this._errors = [];
	}
	
	fetchVerse(){
		console.log("status: fetching verse...");
	}
	fetchFailed(){
		console.log("status: fetch of verse failed!");
		this._error = 'Cannot find that Scripture reference. Sorry :( ';
	}
}
export default new BibleVerseStore();