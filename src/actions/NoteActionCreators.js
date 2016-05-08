import { dispatch, dispatchAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import RequestService from '../util/RequestService';

export default {   
   
  create: (note) => {
	let promise = RequestService.createNote(note);
	
	dispatchAsync(promise, {
	  request: ActionTypes.NOTE_CREATE_REQUEST,
	  success: ActionTypes.NOTE_CREATE_SUCCESS,
	  failure: ActionTypes.NOTE_CREATE_FAILED
	}, { note });
		
  },
  
  find: (id) => {
    dispatch(ActionTypes.NOTE_FIND,id);
  },
  
  get: (id) => {
    dispatch(ActionTypes.NOTE_GET,id);
  },
  
  update: (updatedNote) => {
    dispatch(ActionTypes.NOTE_UPDATE,updatedNote);
  },
  
  destroy: (id) => {	  
    dispatch(ActionTypes.NOTE_DESTROY,id);
  }
  
} 