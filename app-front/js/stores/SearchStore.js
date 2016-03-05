import { EventEmitter } from "events";
import $ from "jquery" ;
import Dispatcher from "../dispatcher";
import axios from "axios";
import BibleChapterStore from "./BibleChapterStore";
import appConstants from '../constants/appConstants';

class SearchStore extends EventEmitter {
	
	constructor(){
		super();
		this.search = {
			term: BibleChapterStore.chapters.reference
		};
		
		this.CHANGE_EVENT = 'change';
		
	}
	
	emitChange() {
		console.log("SearchStore was changed.");
		this.emit(this.CHANGE_EVENT);
	}
	
	getTerm(){
		return this.search.term;
	}
	
	changeTerm(newTerm){
		console.log("line 20 SearchStore.js: ");
		console.log(newTerm);
		this.search.term = newTerm;
		this.emitChange();
	}
	
	addChangeListener(cb){
		this.on(this.CHANGE_EVENT, cb);
	}
	
	removeChangeListener(cb){
		this.removeListener(this.CHANGE_EVENT, cb);
	}
	
}

const searchStore = new SearchStore;

searchStore.dispatchToken = Dispatcher.register(function(action){
  
  console.log("SearchStore received action: ");
  console.log(action);

  switch(action.type){
    case appConstants.UPDATE_SEARCH:
	  searchStore.changeTerm(action.data);
      break;
    case appConstants.GET_CHAPTER:
		Dispatcher.waitFor([BibleChapterStore.dispatchToken]);
		searchStore.changeTerm(action.data.reference);
      break;
	case appConstants.ADD_CHAPTER:
		Dispatcher.waitFor([BibleChapterStore.dispatchToken]);
		searchStore.changeTerm(action.data.reference);
      break;
    case appConstants.FETCH_CHAPTER:
		console.log("status: fetching...");
      break;
    case appConstants.CHAPTER_WAS_CHANGED:	
		searchStore.changeTerm(action.data.reference);
      break;
	case appConstants.KEEP_AND_CLEAR_CHAPTER:
      searchStore.changeTerm(action.data.reference);
      break;
    default:
      return true;
  }

});

export default searchStore;