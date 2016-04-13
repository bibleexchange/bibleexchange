import { dispatch } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';

export default {
	updateSearch: (input) => {
		dispatch(ActionTypes.UPDATE_SEARCH, input);
	}	
}