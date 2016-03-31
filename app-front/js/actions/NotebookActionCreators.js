import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
   
create: (directive) => {
    dispatch(ActionTypes.NOTE_CREATE, directive	);
  },
  
  updateDirectiveTitle: (id, text) => {
    dispatch(ActionTypes.NOTE_UPDATE_TITLE,
	{ id: id,
      text: text
    });
  },

  destroy: (id) => {
    dispatch(ActionTypes.NOTE_DESTROY,id);
  },
  
  getList: (id) => {
    dispatch(ActionTypes.NOTE_LIST,id);
  },
  
  destroyCompleted: () => {
    dispatch(ActionTypes.NOTE_DESTROY_COMPLETED);
  }
} 