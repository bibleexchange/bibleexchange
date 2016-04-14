import request from 'request';
import bluebird from 'bluebird';
import AppConstants from './AppConstants';
import SessionStore from '../stores/SessionStore'; 

class LocalRequestService {

	github(){
		return this.get();
	}
	
///MASTER SEND GET REQUEST:
	get(){	  
	    console.log("YES!!! I CAN DO IT!!! WOOT!!!");
		var openRequest = '';
		
		return openRequest;
	}
}

export default new LocalRequestService();