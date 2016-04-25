import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';

class ONotebookStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._name = false;
		this._url = false;
		this._author = false;
		this._description = false;
		this._notes = [];
		this.meta = {
			name : "ONotebookStore"
		};
		this._manifestFile = false;
		this._error = false;
		this._loading = true;
	}
	
	 _registerToActions(payload) {
 
		  switch(payload.type){			  
			
			case ActionTypes.GITHUB_NOTEBOOK_FETCH:
				this.logChange(payload);
				this._error = false;
				this._loading = true;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_SUCCESS:
				this.logChange(payload);
				this._url = payload.action.action.path;
				this._notes = this._getNotes(payload.action.body.responseText);
				this._name = this._getName(payload.action.body.responseText,payload.action.action.path);
				this._loading = false;
				this._error = false;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_FAILED:
				this.logChange(payload);
				this._error = payload.action.error;				
				this._loading = false;
				this.emitChange();
			  break;	
			
			case ActionTypes.GITHUB_NOTEBOOK_MANIFEST_FETCH:
				this.logChange(payload);
				this._error = false;
				this._loading = true;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_MANIFEST_SUCCESS:
				this.logChange(payload);
				this._url = payload.action.action.path.replace('be-notebook.json','');
				this._getFromManifest(JSON.parse(payload.action.body.responseText));
				
				this._cacheManifest(payload);
				
				this._manifestFile = true;
				this._loading = false;
				this._error = false;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_MANIFEST_FAILED:
				this.logChange(payload);
				this._error = payload.action.error;
				this._manifestFile = false;
				this._loading = false;
				this.emitChange();
			  break;	
			
			default:
			  return true;
		  }
	  }
	  
	 getAll(){

		const x = {
			notes:this._notes,
			error: this._error,
			loading:this._loading,
			name:this._name,
			description:this._description,
			url:this._url,
			author:this._author,
			manifestFile: this._manifestFile
			};
		
		return x;
	}
	
_getName(response,name){
		
		if(response instanceof Array){
			let s = name.replace(/-/g,' ');
			return s.toUpperCase();
		}
		
		return false;
	}
	
	_getNotes(response){
		if(response instanceof Array){

			response.map(function(r){
				return r.name = r.name.replace(/-/g,' ').split('.')[0].toUpperCase();
			});
			
			return response;
		}
		
		return false;
	}

	_getFromManifest(manifest){
		this._name = manifest.name;
		this._author = manifest.author;
		this._description = manifest.description;
		this._notes = manifest.notes;
	}
	
	_cacheManifest(payload){
		if(!localStorage.getItem(payload.action.action.path)){
			console.log('storing Notebook manifest in local storage');
			localStorage.setItem(payload.action.action.path, payload);
		}
	}
	
}

export default new ONotebookStore();