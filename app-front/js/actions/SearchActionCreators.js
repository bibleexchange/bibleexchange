import { dispatch } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';

export default {
	updateSearch: (input) => {
		dispatch(ActionTypes.UPDATE_SEARCH, input);
	}	
}