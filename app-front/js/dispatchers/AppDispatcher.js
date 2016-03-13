import { Dispatcher } from 'flux';
import AppConstants from '../constants/AppConstants';

const flux = new Dispatcher();

export function register(callback) {
  return flux.register(callback);
}

export function waitFor(ids) {
  return flux.waitFor(ids);
}

// Some Flux examples have methods like `handleViewAction`
// or `handleServerAction` here. They are only useful if you
// want to have extra pre-processing or logging for such actions,
// but I found no need for them.

/**
 * Dispatches a single action.
 */
export function dispatch(type, action = {}) {
  if (!type) {
    throw new Error('You forgot to specify type.');
  }

    if (action.error) {
      console.error('**', type, action);
    } else {
      console.log('**', type, action);
    }
	console.log(action);
	flux.dispatch({ type, action }); 
}

/**
 * Dispatches three actions for an async operation represented by promise.
 */
export function dispatchAsync(promise, types, action = {}) {
  const { request, success, failure } = types;

  dispatch(request, action);
  //NB: unable to use Promise.catch() syntax here
  promise.then(
    //dispatches the action for the async-promise-resolved
    //with a hash of the async-promise params and the response body
    (body) => dispatch(success, { action, body }),
    (error) => dispatch(failure, { action, error })
  )
}