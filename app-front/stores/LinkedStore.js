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
				this._github = payload.action.body;
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
			
			default:
			  return true;
		  }
	  }
	  
	 getAll(){
		
		const x = {
			gh:this._github,
			error: this._error,
			loading:this._loading
			};
		
		return x;
	}
	
}

export default new LinkedStore();