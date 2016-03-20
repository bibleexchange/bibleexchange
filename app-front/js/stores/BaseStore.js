import { EventEmitter } from 'events';
import { register } from '../dispatchers/AppDispatcher';

class BaseStore extends EventEmitter {

  constructor() {
    super();
  }

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
	console.log('Component added change listener!');
    this.on('CHANGE', cb)
  }

  removeChangeListener(cb) {
    this.removeListener('CHANGE', cb);
  }
}

export default BaseStore;