import ActionTypes from '../constants/ActionTypes';
import BaseStore from './BaseStore';
import example from '../data/ListExample';
import assign from 'object-assign'
import Helper from '../tools/helpers.js';

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
	  
	      case ActionTypes.SECTION_CREATE:
			this.logChange(payload);
			  let newTitle = payload.action.title.trim();
			  let newType = payload.action.type.trim();
			  
			  if (newTitle !== '') {
				this.create({type:newType,title:newTitle});
				this.emitChange();
			  }
			  break;

			case ActionTypes.SECTION_UPDATE_TITLE:
				this.logChange(payload);
				var title = payload.action.text.trim();
			  if (title !== '') {
				this.updateDirective(payload.action.id, {title: title});
				this.emitChange();
			  }
			  break;

			case ActionTypes.SECTION_DESTROY:
				this.logChange(payload);
			  this.destroy(payload.action);
			  this.emitChange();
			  break;

			case ActionTypes.SECTION_DESTROY_COMPLETED:
				this.logChange(payload);
			  this.destroyCompleted();
			  this.emitChange();
			  break;
	  
			default:
			  return true;
		  }
	  }

	create(newSection) {
	 var id = (new Date() + Math.floor(Math.random() * 999999)).toString(36);
	  this._list.sections[id] = {
		id: id,
		type: newSection.type,
		title: newSection.title
	  };
	}

	destroy(id) {
		const newList = this._list.sections
			.filter(function (el) {
				  return el.id !== id;
			 }
		);
		this._list.sections = newList;
	}
	
	updateDirective(id, updates) {
		let newArray = [];
		
		this._list.sections.map(function(section, index){
			if(section.id === id){
				for (var key in updates) { 
					section[key] = updates[key]; 
					}	
			}
			newArray.push(section);
		});
		
		this._list.sections = newArray;
	}
	
  getAll() {
    return this._list;
  }
	
  getSection(index) {
    return this._list.sections[index-1];
  }
	
}

export default new ListStore();