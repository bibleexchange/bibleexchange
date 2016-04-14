import { dispatch, dispatchAsync, dispatchLocalAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import AppConstants from '../util/AppConstants';
import RequestService from '../util/RequestService';
import LocalRequestService from '../util/LocalRequestService';

export default {
   
	githubDirectory: () => {
		
		if(AppConstants.IDB_SUPPORTED) {
			let promise = indexedDB.open("test_v2",2);
			
			
			
			dispatchLocalAsync(promise, {
			  request: ActionTypes.GITHUB_FETCH,
			  success: ActionTypes.GITHUB_SUCCESS,
			  error: ActionTypes.GITHUB_FAILED,
			  upgradeNeeded: ActionTypes.GITHUB_FETCH
			}, {});
			
		} else {
			let promise = RequestService.github();
			
			dispatchAsync(promise, {
			  request: ActionTypes.GITHUB_FETCH,
			  success: ActionTypes.GITHUB_SUCCESS,
			  failure: ActionTypes.GITHUB_FAILED
			}, {});
		}
		
	},
	
	githubNotebook: (path) => {
		let promise = RequestService.github(path);
		
		dispatchAsync(promise, {
		  request: ActionTypes.GITHUB_NOTEBOOK_FETCH,
		  success: ActionTypes.GITHUB_NOTEBOOK_SUCCESS,
		  failure: ActionTypes.GITHUB_NOTEBOOK_FAILED
		}, { path });
		 
	},
	
	githubFile: (path) => {
		let promise = RequestService.github(path);
		
		dispatchAsync(promise, {
		  request: ActionTypes.GITHUB_FILE_FETCH,
		  success: ActionTypes.GITHUB_FILE_SUCCESS,
		  failure: ActionTypes.GITHUB_FILE_FAILED
		}, { path });
		 
	},
} 