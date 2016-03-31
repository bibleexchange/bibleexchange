import $ from 'jquery';

export default {

	getFromJSON: (objectToSearch,valueToFind) => {
		var value = $.grep(objectToSearch, function(obj) { 
			return obj.id == valueToFind;
			});
			
		return value[0];
	}
};

export function randomIntFromInterval(min,max){
	return Math.floor(Math.random()*(max-min+1)+min);
};

export function getRandomBibleChapter() {
	return randomIntFromInterval(1,1189);
};