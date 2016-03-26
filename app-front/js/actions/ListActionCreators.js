import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
   
create: (directive) => {
	
    dispatch(ActionTypes.SECTION_CREATE,
		directive
		);
  },
  
  updateDirectiveTitle: (id, text) => {
    dispatch(ActionTypes.SECTION_UPDATE_TITLE,
	{ id: id,
      text: text
    });
  },

  destroy: (id) => {
    dispatch(ActionTypes.SECTION_DESTROY,id);
  },
  
  getList: (id) => {
    dispatch(ActionTypes.FETCH_LIST,id);
  },
  
  destroyCompleted: () => {
    dispatch(ActionTypes.SECTION_DESTROY_COMPLETED);
  }
} 