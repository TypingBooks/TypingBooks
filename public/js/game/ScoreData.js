
// while it's definitely not needed to store all of this data,
// it should make it easier to track if it's been submitted to the server or not
function ScoreData(score, gameData) {
	
	this.score = score;
	
	// One character games cheap fix.
	if(score > 250) {
		
		this.score = 100;
		
	}
	
	this.gameData = gameData;
	this.hasSubmit = false;
	
	this.getScore = function() {
		
		return this.score;
		
	}
	
	this.hasUser = function () {
		
		return this.getGameData().hasUser();
		
	}

	this.getGameData = function() {
		
		return this.gameData;
		
	}
	
	this.hasBeenSubmitted = function () {
		
		return this.hasSubmit;
		
	}
	
	this.markAsSubmitted = function () {
		
		this.hasSubmit = true;
		
	}
	
	this.getCSRFForSubmit = function () {
		
		return this.gameData.getMetaData().getCSRF();
		
	}
	
	this.getUserForSubmit = function () {
		
		return this.gameData.getUser();
		
	}
	
	return this;
	
}