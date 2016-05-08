import ActionTypes from '../util/ActionTypes';
import BaseStore from './BaseStore';
import example from '../util/NotebookExample';
import Helper from '../util/MyHelpers';

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
	  
	      case ActionTypes.NOTE_CREATE:
			this.logChange(payload);
			  let newTitle = payload.action.title.trim();
			  let newType = payload.action.type.trim();
			  
			  if (newTitle !== '') {
				this.create({type:newType,title:newTitle});
				this.emitChange();
			  }
			  break;

			case ActionTypes.NOTE_UPDATE_TITLE:
				this.logChange(payload);
				var title = payload.action.text.trim();
			  if (title !== '') {
				this.updateDirective(payload.action.id, {title: title});
				this.emitChange();
			  }
			  break;

			case ActionTypes.NOTE_DESTROY:
				this.logChange(payload);
			  this.destroy(payload.action);
			  this.emitChange();
			  break;

			case ActionTypes.NOTE_DESTROY_COMPLETED:
				this.logChange(payload);
			  this.destroyCompleted();
			  this.emitChange();
			  break;
	  
			default:
			  return true;
		  }
	  }

	create(newNote) {
	 var id = (new Date() + Math.floor(Math.random() * 999999)).toString(36);
	  this._list.notes[id] = {
		id: id,
		type: newNote.type,
		title: newNote.title
	  };
	}

	destroy(id) {
		const newList = this._list.notes
			.filter(function (el) {
				  return el.id !== id;
			 }
		);
		this._list.notes = newList;
	}
	
	updateDirective(id, updates) {
		let newArray = [];
		
		this._list.notes.map(function(note, index){
			if(note.id === id){
				for (var key in updates) { 
					note[key] = updates[key]; 
					}	
			}
			newArray.push(note);
		});
		
		this._list.notes = newArray;
	}
	
  getAll() {
    return this._list;
  }
	
  getSection(index) {
    return this._list.notes[index-1];
  }
	
}

export default new ListStore();