import { dispatch, dispatchAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import RequestService from '../util/RequestService';

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
    dispatch(ActionTypes.NOTE_DESTROY_FROM_NOTEBOOK,id);
  },
  
  getList: (id) => {
    dispatch(ActionTypes.NOTE_LIST,id);
  },
  
  destroyCompleted: () => {
    dispatch(ActionTypes.NOTE_DESTROY_COMPLETED);
  }
} 