import { dispatch } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';

export default {
	updateSearch: (input) => {
		dispatch({type: ActionTypes.UPDATE_SEARCH, data: input});
	}
}