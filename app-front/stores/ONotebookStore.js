import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';

class ONotebookStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._title = false;
		this.url = false;
		this._notes = [];
		this.meta = {
			name : "ONotebookStore"
		};
		
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
			notes:this._notes,
			error: this._error,
			loading:this._loading
			};
		
		return x;
	}
	
}

export default new ONotebookStore();