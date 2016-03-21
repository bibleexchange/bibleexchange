import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import BibleChapterStore from './BibleChapterStore';
import { waitFor } from '../dispatchers/AppDispatcher';

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
	
	_registerToActions(action) {	
		
		 switch(action.type){
			 
			case ActionTypes.UPDATE_SEARCH:
				this.logChange(action);
			  this.changeTerm(action.data);
			  this.emitChange();
			  break;
			  
			case ActionTypes.GET_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.logChange(action);
				this.changeTerm(BibleChapterStore.reference);
				this.changeUrl(BibleChapterStore.url);
				this.emitChange();
				break;
				
			case ActionTypes.GET_VERSE:
				this.logChange(action);
				this.changeTerm(action.action.body.data.bibleverses[0].reference);
				this.changeUrl(action.action.body.data.bibleverses[0].url);
				this.emitChange();
				break;
				
			case ActionTypes.ADD_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.logChange(action);
				this.changeTerm(action.data.reference);
				this.changeUrl(action.data.url);
				this.emitChange();
				break;
				
			case ActionTypes.CHAPTER_WAS_CHANGED:	
				this.logChange(action);
				this.changeTerm(action.data.reference);
				this.emitChange();
				break;
				
			case ActionTypes.KEEP_AND_CLEAR_CHAPTER:
				this.logChange(action);
				this.changeTerm(action.data.reference);
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