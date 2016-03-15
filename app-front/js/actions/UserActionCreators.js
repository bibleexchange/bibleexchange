import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import AuthService from '../services/AuthService';

export default {
  getUser: (token) => {
    let promise = AuthService.fetch(token);   
	console.log(promise);
	
	dispatchAsync(promise, {
      request: ActionTypes.REQUEST_AUTHORIZED_USER,
      success: ActionTypes.REQUEST_AUTHORIZED_USER_SUCCESS,
      failure: ActionTypes.REQUEST_AUTHORIZED_USER_ERROR
    }, { token });
	
  }
}