import { EventEmitter } from "events";
import $ from "jquery" ;
import dispatcher from "../dispatcher";
import axios from "axios";

class BibleChapterStore extends EventEmitter {
	constructor(){
		super();
		this.state = {id:'',reference:'',next:['',''],previous:['',''], chapters:[]};
		var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\"1\"){id,next,previous,reference,verses{id,v,t}}}";
	  axios(URL).then((data) => {	 
		this.getChapter(data);
	  })
		
	}
	
	getAll(){
		return this.state;
	}
	
	addChapter(data){
		const ch = data.data.data.biblechapters;
		
		this.data.id = ch[0].id;
		this.data.reference =  ch[0].reference;
		this.data.next.id = ch[0].next[0];
		this.data.next.url =  ch[0].next[1];
		this.data.previous.id = ch[0].previous[0];
		this.data.previous.url = ch[0].previous[1];			
		this.data.chapters.push(ch);
	}
	
	getChapter(data){
		const ch = data.data.data.biblechapters;
		
		this.state.id = ch[0].id;
		this.state.reference =  ch[0].reference;
		this.state.next[0] = ch[0].next[0];
		this.state.next[1] =  ch[0].next[1];
		this.state.previous[0] = ch[0].previous[0];
		this.state.previous[1] = ch[0].previous[1];	
		this.state.chapters = ch;
		
		this.emit("change");

	}
	
	handleActions(action){
		
		switch(action.type){
			case "GET_CHAPTER":{
				this.getChapter(action.data);
			}
			case "ADD_CHAPTER":{
				this.addChapter(action.data);
				this.emit("change");
			}
		}
	}
	
}

const bibleChapterStore = new BibleChapterStore;
dispatcher.register(bibleChapterStore.handleActions.bind(bibleChapterStore));

export default bibleChapterStore;