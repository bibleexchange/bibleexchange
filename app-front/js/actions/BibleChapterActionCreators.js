import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

String.prototype.ucfirst = function()
{
	return this.charAt(0).toUpperCase() + this.substr(1);
}

export default {
  
	keepOnlyThisChapter: (data) => {
		dispatch({type: ActionTypes.KEEP_AND_CLEAR_CHAPTER, action: data}); 
	},
	
	addChapter: (id) => {
		let promise = RequestService.addChapter(id);
		
		dispatchAsync(promise, {
		  request: ActionTypes.FETCH_CHAPTER,
		  success: ActionTypes.ADD_CHAPTER,
		  failure: ActionTypes.FETCH_FAILED
		}, { id });
		 
	},
	
	getChapter: (id) => {
		console.log('get chapter zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
		let promise = RequestService.getChapter(id);
		
		dispatchAsync(promise, {
		  request: ActionTypes.FETCH_CHAPTER,
		  success: ActionTypes.GET_CHAPTER,
		  failure: ActionTypes.FETCH_FAILED
		}, { id });
		 
	},
	
	getChapterByReference: (book,chapter=null,verse=null) => {
		let ifVerse = (!verse) ? "":":"+verse;
		let ifChapter = (!chapter) ? "":chapter;
		let ifBook = (!book) ? "":book+" ";
		let ref = ifBook.ucfirst() + ifChapter + ifVerse;
		
		if(!ref || ref === ""){
			dispatch(
				{type: ActionTypes.FETCHED_BAD_REFERENCE}, 
				{book: book, chapter: chapter, verse:verse, error:"None or Bad Scripture Reference entered"}
				);
		}else{
			
			let promise = RequestService.bibleChapterByReference(ref);
			
			dispatchAsync(promise, {
			  request: ActionTypes.FETCH_CHAPTER,
			  success: ActionTypes.GET_CHAPTER,
			  failure: ActionTypes.FETCH_FAILED
			}, { book, chapter, verse, ref });
		}
		 
	},
	
	urlChanged: () => {
		
		let data = {};
		
		dispatch({type: ActionTypes.BIBLE_URL_CHANGED, action: data}); 
		 
	},
	
	
}