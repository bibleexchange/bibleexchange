import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';
import Helper from '../util/helpers.js';

class NoteStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._title = false;
		this._url = false;
		this._body = false;
		this._reference = false;
		this._error = false;
		this._loading = true;
		
		this.meta = {
			name : "NoteStore"
		};
		
	}
	
	 _registerToActions(payload) {
 
		  switch(payload.type){			  
			
			case ActionTypes.NOTE_FIND:
				this.logChange(payload);
			  this.find(id);
			  this.emitChange();
			  break;

			case ActionTypes.NOTE_GET:
			  this.logChange(payload);
			  this.get(id);
			  this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_FETCH:
				this.logChange(payload);
				this._error = false;
				this._loading = true;
				this.emitChange();
			  break;
			
			case ActionTypes.GITHUB_NOTEBOOK_SUCCESS:
				this.logChange(payload);
				this._notes = payload.action.body;
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
			
			default:
			  return true;
		  }
	  }
	  
	 getAll(){

		const x = {
			body:this._body,
			error: this._error,
			loading:this._loading
			};
		
		return x;
	}
	
	find(id) {
	 
	}

	get(id) {
	
	}

}

export default new NoteStore();