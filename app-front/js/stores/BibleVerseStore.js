import { EventEmitter } from "events";
import $ from "jquery" ;
import Dispatcher from "../dispatcher";
import axios from "axios";
import appConstants from '../constants/appConstants';

class BibleVerseStore extends EventEmitter {
	
	constructor(){
		super();
		this.verse = {false};
		this.CHANGE_EVENT = 'change';
	}
	
	emitChange() {
		console.log("BibleVerseStore was changed.");
		this.emit(this.CHANGE_EVENT);
	}
	
	getVerse(data){
		console.log(data);
		this.verse.id = data.id;
		this.verse.body =  data.t;
		this.verse.reference =  data.reference;
		this.verse.url =  data.url;
		this.verse.bible_chapter_id = data.bible_chapter_id;
		this.verse.notes = data.notes;

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
	
	fetchVerse(){
		console.log("status: fetching...");
		this.emitChange();
	}
	fetchFailed(){
		console.log("status: fetch failed!");
		this.message = 'Cannot find that Scripture reference. Sorry :( ';
		this.emitChange();
	}
}

const bibleVerseStore = new BibleVerseStore;

bibleVerseStore.dispatchToken = Dispatcher.register(function(action){
	console.log("bibleVerseStore received action: ");
	console.log(action);
  
  switch(action.type){
	case appConstants.FETCH_VERSE:
		bibleVerseStore.fetchVerse();
      break;
	case appConstants.GET_VERSE:
		bibleVerseStore.getVerse(action.data);
      break;	
    default:
      return true;
  }

});

export default bibleVerseStore;