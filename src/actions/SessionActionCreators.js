import { dispatch, dispatchAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import RequestService from '../util/RequestService';

export default {
  loginUser: (email, password) => {
    let promise = RequestService.login(email, password);   

	dispatchAsync(promise, {
      request: ActionTypes.REQUEST_LOGIN_USER,
      success: ActionTypes.REQUEST_LOGIN_USER_SUCCESS,
      failure: ActionTypes.REQUEST_LOGIN_USER_ERROR
    }, { email, password });
	
  },

  signup: (email, password, extra) => {
    let promise = RequestService.signup(email, password, extra);
    dispatchAsync(promise, {
      request: ActionTypes.REQUEST_LOGIN_USER,
      success: ActionTypes.REQUEST_LOGIN_USER_SUCCESS,
      failure: ActionTypes.REQUEST_LOGIN_USER_ERROR
    }, { email, password, extra });
  },

  logoutUser: () => {
    dispatch(ActionTypes.LOGOUT_USER);
  },
  
  getUser: (token) => {
    let promise = RequestService.fetch(token);   
	
	dispatchAsync(promise, {
      request: ActionTypes.REQUEST_USER,
      success: ActionTypes.REQUEST_USER_SUCCESS,
      failure: ActionTypes.REQUEST_USER_ERROR
    }, { token });
	
  }
}