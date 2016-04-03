import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {   
   
  create: (note) => {
    dispatch(ActionTypes.NOTE_CREATE, note	);
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