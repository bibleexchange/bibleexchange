import $ from 'jquery';

export default {

	getFromJSON: (objectToSearch,valueToFind) => {
		var value = $.grep(objectToSearch, function(obj) { 
			return obj.id == valueToFind;
			});
			
		return value[0];
	}
};
