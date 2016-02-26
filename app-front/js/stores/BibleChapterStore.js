import { EventEmitter } from "events";

class BibleChapterStore extends EventEmitter {
	constructor(){
		super();			
	}
	
	getAllVerses(){
		
		var URL = 'localhost/graphql?query=query+FetchBibleChapter{biblechapters(id:%221%22){id,verses{id,t}}}';
		
		$.get(URL, function (result) {
			return result;
		}.bind(this));
		
	}

}

const bibleChapterStore = new BibleChapterStore;

export default bibleChapterStore;