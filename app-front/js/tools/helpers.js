export default {

	getFromJSON: (objectToSearch,valueToFind) => {
		
		var allElementsThatMatch = objectToSearch.filter(function(obj) {
			return objc.id == valueToFind;
		});
		
		return allElementsThatMatch[0];
	}
};

export function randomIntFromInterval(min,max){
	return Math.floor(Math.random()*(max-min+1)+min);
};

export function getRandomBibleChapter() {
	return randomIntFromInterval(1,1189);
};