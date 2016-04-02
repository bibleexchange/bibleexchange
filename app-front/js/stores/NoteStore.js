import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
//import example from '../data/ListExample';
import Helper from '../tools/helpers.js';

class NoteStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._url = false;
		this._body = false;
		this._reference = false;
		
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
	  
			default:
			  return true;
		  }
	  }

	find(id) {
	 
	}

	get(id) {
	
	}
	
  get list() {
    return this._list;
  }
	
}

export default new NoteStore();