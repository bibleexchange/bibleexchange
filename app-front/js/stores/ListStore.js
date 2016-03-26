import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import example from '../data/ListExample';
import assign from 'object-assign'

class ListStore extends BaseStore {
	
	constructor(){
		super();
		this.subscribe(() => this._registerToActions.bind(this));
		
		this._list = example;
		
		this.meta = {
			name : "ListStore"
		};

	}
	
	 _registerToActions(payload) {
		
		 switch(payload.type){			  
			
			 case ActionTypes.LIST_TOGGLE_COMPLETE_ALL:
				this.logChange(payload);
			  if (this.areAllComplete()) {
				this.updateAll({complete: false});
			  } else {
				this.updateAll({complete: true});
			  }
			  this.emitChange();
			  break;
	  
	      case ActionTypes.DIRECTIVE_CREATE:
			this.logChange(payload);
			  let newBody = payload.action.body.trim();
			  let newType = payload.action.type.trim();
			  
			  if (newBody !== '') {
				this.create({type:newType,body:newBody});
				this.emitChange();
			  }
			  break;

			case ActionTypes.DIRECTIVE_UNDO_COMPLETE:
				this.logChange(payload);
			  this.update(payload.action.id, {complete: false});
			  this.emitChange();
			  break;

			case ActionTypes.DIRECTIVE_COMPLETE:
				this.logChange(payload);
			  this.update(payload.action.id, {complete: true});
			  this.emitChange();
			  break;

			case ActionTypes.DIRECTIVE_UPDATE_TEXT:
				this.logChange(payload);
			  text = payload.action.body.trim();
			  if (text !== '') {
				this.update(payload.action.id, {text: text});
				this.emitChange();
			  }
			  break;

			case ActionTypes.DIRECTIVE_DESTROY:
				this.logChange(payload);
			  this.destroy(payload.action);
			  this.emitChange();
			  break;

			case ActionTypes.DIRECTIVE_DESTROY_COMPLETED:
				this.logChange(payload);
			  this.destroyCompleted();
			  this.emitChange();
			  break;
	  
			default:
			  return true;
		  }
	  }

	create(newItem) {
	 var id = (+new Date() + Math.floor(Math.random() * 999999)).toString(36);;
	  this._list.directives[id] = {
		id: id,
		type: newItem.type,
		body: newItem.body
	  };
	}

	destroy(id) {
	  delete this._list.directives[id];
	}

	/////////////////////////
	
update(id, updates) {
  this._list[id] = assign({}, this._list.directives[id], updates);
}

/**
 * Update all of the TODO items with the same object.
 * @param  {object} updates An object literal containing only the data to be
 *     updated.
 */
updateAll(updates) {
  for (var id in this._list) {
    this.update(id, updates);
  }
}

destroyCompleted() {
  for (var id in this._list.directives) {
    if (this._list.directives[id].complete) {
      this.destroy(id);
    }
  }
}

  areAllComplete() {
    for (var id in this._list.directives) {
      if (!this._list.directives[id].complete) {
        return false;
      }
    }
    return true;
  }

  getAll() {
    return this._list;
  }
	
}

export default new ListStore();