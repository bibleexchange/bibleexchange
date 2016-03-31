import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {   
   
   find: (id) => {
    dispatch(ActionTypes.NOTE_FIND,id);
  },
  
  get: (id) => {
    dispatch(ActionTypes.NOTE_GET,id);
  }
  
} 