import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
   
create: (directive) => {
	dispatch(ActionTypes.NOTE_CREATE, directive);
  }
  
} 