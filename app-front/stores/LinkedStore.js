import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';

class LinkedStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		this._github = [];
		this.meta = {
			name : "LinkedStore"
		};
		this._description = false;
		this._name = false;
		this._error = false;
		this._loading = true;
	}
	
	 _registerToActions(payload) {
 
		  switch(payload.type){			  
			
			case ActionTypes.GITHUB_FETCH:
				this.logChange(payload);
				this._error = false;
				this._loading = true;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_SUCCESS:
				this.logChange(payload);
				this._github = this._getNotebooks(payload.action.body);
				this._loading = false;
				this._error = false;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_FAILED:
				this.logChange(payload);
				this._error = payload.action.error;
				this._loading = false;
				this.emitChange();
			  break;	
			
			case ActionTypes.GITHUB_MANIFEST_FETCH:
				this.logChange(payload);
				this._error = false;
				this._loading = true;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_MANIFEST_SUCCESS:
				this.logChange(payload);
				this._cacheManifest(payload);
				this._getNotebooksFromManifest(JSON.parse(payload.action.body.responseText));
				this._loading = false;
				this._error = false;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_MANIFEST_FAILED:
				this.logChange(payload);
				this._error = payload.action.error;
				this._loading = false;
				this.emitChange();
			  break;
			
			default:
			  return true;
		  }
	  }
	  
	 getAll(){
		
		const x = {
			gh:this._github,
			error: this._error,
			loading:this._loading,
			description: this._description,
			name: this._name
			};
		
		return x;
	}
	
	_getNotebooks(response){
		if(response instanceof Array){

			response.map(function(r){
				return r.name = r.name.replace(/-/g,' ').split('.')[0].toUpperCase();
			});
			
			return response;
		}
		
		return false;
		
	}
	
	_getNotebooksFromManifest(manifest){
		this._name = manifest.name;
		this._description = manifest.description;
		this._github = manifest.notebooks;
	}
	
	_cacheManifest(payload){
		if(!localStorage.getItem(payload.type)){
			console.log('storing directoryManifest in local storage');
			localStorage.setItem(payload.type, JSON.stringify(payload));
		}
	}
	
}

export default new LinkedStore();