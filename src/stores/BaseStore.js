import { EventEmitter } from 'events';
import { register } from '../util/AppDispatcher';

class BaseStore extends EventEmitter {

  subscribe(actionSubscribe) {
    this._dispatchToken = register(actionSubscribe());
  }

  get dispatchToken() {
    return this._dispatchToken;
  }

  emitChange() {
	console.log('store emitted change!', this);
    this.emit('CHANGE');
  }

  addChangeListener(cb) {
    this.on('CHANGE', cb)
  }

  removeChangeListener(cb) {
    this.removeListener('CHANGE', cb);
  }

  logChange(action){
	console.log(this.meta.name + " Store heard a change: " , action);
  }
  
}

export default BaseStore;