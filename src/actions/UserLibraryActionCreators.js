import { dispatch, dispatchAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import RequestService from '../util/RequestService';

export default {
   
create: (directive) => {
	dispatch(ActionTypes.NOTE_CREATE, directive);
  }
  
} 