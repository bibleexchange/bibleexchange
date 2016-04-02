import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
  bookMarkIt: (url, token) => {
    let promise = RequestService.bookMarkIt(url,token);   
	
	dispatchAsync(promise, {
      request: ActionTypes.REQUEST_BOOKMARK_IT,
      success: ActionTypes.REQUEST_BOOKMARK_IT_SUCCESS,
      failure: ActionTypes.REQUEST_BOOKMARK_IT_ERROR
    }, { url });
	
  }
  
}