import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import BibleChapterStore from './BibleChapterStore';

class SearchStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		this._term = BibleChapterStore.reference;
		this._url = BibleChapterStore.chapters.url;	
	}
	
	_registerToActions(action) {		
		 switch(action.type){
			 
			case ActionTypes.UPDATE_SEARCH:
			  this.changeTerm(action.data);
			  this.emitChange();
			  break;
			  
			case ActionTypes.GET_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.changeTerm(action.data.reference);
				this.changeUrl(action.data.url);
				this.emitChange();
				break;
				
			case ActionTypes.GET_VERSE:
				this.changeTerm(action.data.reference);
				this.changeUrl(action.data.url);
				this.emitChange();
				break;
				
			case ActionTypes.ADD_CHAPTER:
				waitFor([BibleChapterStore.dispatchToken]);
				this.changeTerm(action.data.reference);
				this.changeUrl(action.data.url);
				this.emitChange();
				break;
				
			case ActionTypes.FETCH_CHAPTER:
				console.log("status: fetching...");
				break;
				
			case ActionTypes.CHAPTER_WAS_CHANGED:	
				this.changeTerm(action.data.reference);
				this.emitChange();
				break;
				
			case ActionTypes.KEEP_AND_CLEAR_CHAPTER:
				this.changeTerm(action.data.reference);
				this.emitChange();
				break;
			
			default:
				break;
		 };	 
	  }
	
	getAll(){
		const a = {term:this._term, url:this._url};
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