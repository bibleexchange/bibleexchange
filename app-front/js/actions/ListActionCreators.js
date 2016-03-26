import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import RequestService from '../services/RequestService';

export default {
   
  toggleComplete: (item) =>{
    var id = item.id;
    var actionType = item.complete ?
        ActionTypes.DIRECTIVE_UNDO_COMPLETE :
        ActionTypes.DIRECTIVE_COMPLETE;

    dispatch({
      type: actionType,
      id: id
    });
  },

  toggleCompleteAll: () => {
    dispatch({
      type: ActionTypes.LIST_TOGGLE_COMPLETE_ALL
    });
  },
	
create: (directive) => {
	
    dispatch(
		ActionTypes.DIRECTIVE_CREATE,
		directive
		);
  },

  updateText: (id, text) => {
    dispatch({
      type: ActionTypes.DIRECTIVE_UPDATE_TEXT,
      id: id,
      text: text
    });
  },

  destroy: (id) => {
    dispatch(ActionTypes.DIRECTIVE_DESTROY,id);
  },

  destroyCompleted: () => {
    dispatch({
      type: ActionTypes.DIRECTIVE_DESTROY_COMPLETED
    });
  }
} 