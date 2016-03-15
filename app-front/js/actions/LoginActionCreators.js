import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import AuthService from '../services/AuthService';

export default {
  loginUser: (email, password) => {
    let promise = AuthService.login(email, password);   

	dispatchAsync(promise, {
      request: ActionTypes.REQUEST_LOGIN_USER,
      success: ActionTypes.REQUEST_LOGIN_USER_SUCCESS,
      failure: ActionTypes.REQUEST_LOGIN_USER_ERROR
    }, { email, password });
	
  },

  signup: (email, password, extra) => {
    let promise = AuthService.signup(email, password, extra);
    dispatchAsync(promise, {
      request: ActionTypes.REQUEST_LOGIN_USER,
      success: ActionTypes.REQUEST_LOGIN_USER_SUCCESS,
      failure: ActionTypes.REQUEST_LOGIN_USER_ERROR
    }, { email, password, extra });
  },

  logoutUser: () => {
    dispatch(ActionTypes.LOGOUT_USER);
  }
}