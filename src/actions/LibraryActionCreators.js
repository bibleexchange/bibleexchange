import { dispatch, dispatchAsync, dispatchLocalAsync } from '../util/AppDispatcher';
import ActionTypes from '../util/ActionTypes';
import AppConstants from '../util/AppConstants';
import RequestService from '../util/RequestService';

export default {
   	githubManifest: (path) => {
			
			let local = localStorage.getItem(ActionTypes.GITHUB_MANIFEST_SUCCESS);
	
			if(local){
				console.log('Getting Notebooks Index from local. ',JSON.parse(local));
				dispatch(ActionTypes.GITHUB_MANIFEST_SUCCESS,JSON.parse(local).action);
			}else{
				console.log('fetching from github');
				let promise = RequestService.github(path,false);
				
				dispatchAsync(promise, {
				  request: ActionTypes.GITHUB_MANIFEST_FETCH,
				  success: ActionTypes.GITHUB_MANIFEST_SUCCESS,
				  failure: ActionTypes.GITHUB_MANIFEST_FAILED
				}, {});
			}
	},
	
	githubDirectory: () => {
		
			let local = localStorage.getItem('notebookdirectory');
			console.log(local);
			
			if(local){
				console.log('getting from local storage');
				dispatch(ActionTypes.GITHUB_SUCCESS,local);
			}else{
				console.log('fetching from github');
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
	
	githubNotebookManifest: (path) => {
		let promise = RequestService.github(path,false);
		
		dispatchAsync(promise, {
		  request: ActionTypes.GITHUB_NOTEBOOK_MANIFEST_FETCH,
		  success: ActionTypes.GITHUB_NOTEBOOK_MANIFEST_SUCCESS,
		  failure: ActionTypes.GITHUB_NOTEBOOK_MANIFEST_FAILED
		}, { path });
		 
	},
	
	githubFile: (path,dir) => {
		let promise = RequestService.github(path,dir);
		
		dispatchAsync(promise, {
		  request: ActionTypes.GITHUB_FILE_FETCH,
		  success: ActionTypes.GITHUB_FILE_SUCCESS,
		  failure: ActionTypes.GITHUB_FILE_FAILED
		}, { path });
		 
	},
} 