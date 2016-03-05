import { EventEmitter } from "events";
import $ from "jquery" ;
import Dispatcher from "../dispatcher";
import axios from "axios";
import * as SearchActions from '../actions/SearchActions';
import appConstants from '../constants/appConstants';

class BibleChapterStore extends EventEmitter {
	
	constructor(){
		super();
		this.chapters = {
			id:'2',
			reference:'Genesis 2', 
			url:'/bible/genesis/2',
			next:['3','\/bible\/genesis\/3'],
			previous:['1','\/bible\/genesis\/1'], 
			chapters:[]
		};
		
		this.CHANGE_EVENT = 'change';
		this.message = false;
	}
	
	emitChange() {
		console.log("BibleChapterStore was changed.");
		this.emit(this.CHANGE_EVENT);
	}
	
	addChapter(data){
		this.chapters.id = data.id;
		this.chapters.reference =  data.reference;
		this.chapters.url =  data.url;
		this.chapters.next[0] = data.next[0];
		this.chapters.next[1] =  data.next[1];
		this.chapters.previous[0] = data.previous[0];
		this.chapters.previous[1] = data.previous[1];	
		this.chapters.chapters.push(data);
		
		this.emitChange();
	}
	
	getChapter(data){
		
		this.chapters.id = data.id;
		this.chapters.reference =  data.reference;
		this.chapters.url =  data.url;
		this.chapters.next[0] = data.next[0];
		this.chapters.next[1] =  data.next[1];
		this.chapters.previous[0] = data.previous[0];
		this.chapters.previous[1] = data.previous[1];
		this.chapters.chapters = [data];

		this.emitChange();
		
	}
	
	getAll(){
		return this.chapters;
	}
	
	getMessage(){
		return this.message;
	}
	
	
	addChangeListener(cb){
		this.on(this.CHANGE_EVENT, cb);
	}
	
	removeChangeListener(cb){
		this.removeListener(this.CHANGE_EVENT, cb);
	}
	
	fetchChapter(){
		console.log("status: fetching...");
		this.emitChange();
	}
	fetchFailed(){
		console.log("status: fetch failed!");
		this.message = 'Cannot find that Scripture reference. Sorry :( ';
		this.emitChange();
	}
	
	keepAndClear(data){
		
		console.log("status: cleared array to selected only!");
		
		this.chapters.chapters = [];
		
		this.getChapter(data);
	}
}

const bibleChapterStore = new BibleChapterStore;

bibleChapterStore.dispatchToken = Dispatcher.register(function(action){
	console.log("bibleChapterStore received action: ");
	console.log(action);
  
  switch(action.type){
    case appConstants.ADD_CHAPTER:
	  bibleChapterStore.addChapter(action.data);
      break;
    case appConstants.GET_CHAPTER:
      bibleChapterStore.getChapter(action.data);
      break;
    case appConstants.FETCH_CHAPTER:
		bibleChapterStore.fetchChapter();
      break;
    case appConstants.FETCH_FAILED:
      bibleChapterStore.fetchFailed();
      break;
	case appConstants.KEEP_AND_CLEAR_CHAPTER:
      bibleChapterStore.keepAndClear(action.data);
      break; 
    default:
      return true;
  }

});

export default bibleChapterStore;