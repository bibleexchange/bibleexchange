import { EventEmitter } from "events";
import $ from "jquery" ;
import dispatcher from "../dispatcher";
import axios from "axios";

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
	}
	
	getAll(){
		return this.chapters;
	}
	
	handleActions(action){
		console.log(action.type);
		switch(action.type){
			case "ADD_CHAPTER":
				this.addChapter(action.data);
				this.emit("change");
				break;
			case "GET_CHAPTER":
				this.getChapter(action.data);
				this.emit("change");
				break;
			case "FETCH_CHAPTER":
				console.log("status: fetching...");
				this.emit("change");
				break;
			case "FETCH_FAILED":
				 console.log(action.data);
				break;				
				
		}
	}
	
}

const bibleChapterStore = new BibleChapterStore;
dispatcher.register(bibleChapterStore.handleActions.bind(bibleChapterStore));

export default bibleChapterStore;