import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';
import BibleChapterStore from './BibleChapterStore';
import { waitFor } from '../util/AppDispatcher';

class SearchStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		this._term = BibleChapterStore.reference;
		this._url = BibleChapterStore.url;	
		
		this.meta = {
			name : "SearchStore"
		};
		
	}
	
	_registerToActions(payload) {	
		
		 switch(payload.type){
			 
			case ActionTypes.UPDATE_SEARCH:
			  this.logChange(payload); 
			  this.changeTerm(payload.action);
			  this.emitChange();
			  break;
			  
			case ActionTypes.GET_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.logChange(payload);
				var ref = payload.action.body.data.biblechapters[0].reference;
				var url = payload.action.body.data.biblechapters[0].url;
				this.changeTerm(ref);
				this.changeUrl(ref);
				this.emitChange();
				break;
				
			case ActionTypes.GET_VERSE:
				this.logChange(payload);
				this.changeTerm(payload.action.body.data.bibleverses[0].reference);
				this.changeUrl(payload.action.body.data.bibleverses[0].url);
				this.emitChange();
				break;
				
			case ActionTypes.ADD_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.logChange(payload);
				this.changeTerm(payload.action.reference);
				this.changeUrl(payload.action.url);
				this.emitChange();
				break;
				
			case ActionTypes.CHAPTER_WAS_CHANGED:	
				this.logChange(payload);
				this.changeTerm(payload.action.reference);
				this.emitChange();
				break;
				
			case ActionTypes.KEEP_AND_CLEAR_CHAPTER:
				this.logChange(payload);
				this.changeTerm(payload.action.reference);
				this.emitChange();
				break;
			
			default:
				break;
		 };	 
	  }
	
	getAll(){
		let a = {term:this._term, url:this._url};
		return a;
	}
//Getters	
	get url(){
		return this._url;
	}
	
	get term(){
		return this._term;
	}
////////////////////////////////////////////

	changeTerm(newTerm){
		this._term = newTerm;
	}
	
	changeUrl(url){
		this._url = url;
	} 
	
}

export default new SearchStore();