import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
	
	getVerseByReference: (book,chapter,verse) => {
		let ref = book + " " + chapter + ":" + verse;
		let promise = RequestService.bibleVerseByReference(ref);
		
		dispatchAsync(promise, {
		  request: ActionTypes.FETCH_VERSE,
		  success: ActionTypes.GET_VERSE,
		  failure: ActionTypes.FETCH_FAILED
		}, { ref, book, chapter, verse });
		 
	},

}