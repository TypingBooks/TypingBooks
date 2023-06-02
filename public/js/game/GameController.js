GameController.saveScore = function (scoreData) {

	let apiAddress = scoreData.getGameData().getExpectedAPIAddressForThisGame();
	
	if(scoreData.hasUser()) { 
	
		try {
			
			new URL(apiAddress);
	
			var xmlHttp = new XMLHttpRequest();
			
			xmlHttp.onreadystatechange = function() { 
				
				// currently don't care what is here.
					
			}
			
			xmlHttp.addEventListener('error', function() {
				
				console.log("Error: Failed to save the score for some unknown reason. Retrying...");
				
				GameController.saveScore(scoreData);
				
			});
			
			xmlHttp.open("POST", apiAddress, true); 
			xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			
			// we don't actually use the user id, idk why I tracked it all the way through
			xmlHttp.send("user=" + scoreData.getUserForSubmit()
					+ "&score=" + scoreData.getScore() 
					+ "&test=" + scoreData.getGameData().getTestNumber() 
					+ "&_token=" + scoreData.getGameData().getMetaData().getCSRF());
			
		} catch(e) {
			
			console.log("Error: Failed to save the score for some unknown reason. Retrying...");
			
			GameController.saveScore(scoreData); 
		
		}
		
	}

}

// Using a controller because it's supposed to manage the switching
// of games. I thought about naming it GameManager, but I think
// GameController is more fitting.
function GameController(gameData, screenType) {
	
	this.game = null;
	this.gameData = gameData;
	this.nextGameData = null;
	this.previousGameData = null;
	this.gameScores = [];
	this.screenType = screenType;
	this.gameSplitter = new GameSplitter(this.gameData.getContentData(), this.screenType);
	
	this.startGame = function () {
	
		try {
	
			this.game.startGame();
	
		} catch(exception) {
		
			console.log("Error: Game has not been created.")
		
		}
	
	}
	
	this.setScreenType = function(newType) {
		
		if(GameSplitter.isValidGameType(newType)) {
			
			this.screenType = newType;
			
			return true;
			
		}
		
		return false;
		
	}
	
	this.loadGame = function (gameContentData) {
	
		if(Game.isValidGameContentData(gameContentData)) {
		
			this.game = new Game(gameContentData);
			
		} else {
		
			console.log("Error: Game data isn't valid.");
		
		}
	
	}
	
	this.hasUser = function() {
		
		return this.gameData.hasUser();
		
	}
	
	this.getUser = function() {
		
		return this.gameData.getUser();
		
	}
	
	this.addScoreToScoreHistory = function (scoreData) {
		
		this.gameScores.push(scoreData);
		
	}
	
	this.getScoreHistory = function () {
		
		return this.gameScores;
		
	}
	
	this.getAverageWPM = function () {
		
		if(this.gameScores == null || this.gameScores.length == 0) {
			
			return 0;
			
		}
		
		let total = 0;
		
		for(let i = 0; i < this.gameScores.length; i++) {
			
			total += parseFloat(this.gameScores[i].getScore());
			
		}
		
		if(total == 0)
			return 0;
		
		return total / this.gameScores.length;
		
	}
	
	this.setPreviousGame = function (previousGameData) {
		
		this.previousGameData = previousGameData;
		
	}
	
	this.setNextGame = function (nextGameData) {
		
		this.nextGameData = nextGameData;
		
	}
	
	this.hasNextDownloadableGame = function() {
		
		return this.gameData.getMetaData().hasNextGame();
		
	}
	
	this.hasNextGame = function () {
		
		return this.gameData.getMetaData().hasNextGame() || this.gameSplitter.hasNextGame();
		
	}
	
	this.hasPreviousDownloadableGame = function() {
		
		return this.gameData.getMetaData().hasPreviousGame();
		
	}
	
	this.hasPreviousGame = function () {
		
		return this.gameData.getMetaData().hasPreviousGame() || this.gameSplitter.hasPreviousGame();
		
	}
	
	this.getCurrentTitle = function() {
		
		return this.gameData.getMetaData().getTitle() + " " + this.gameSplitter.getTitle();
		
	}
	
	this.downloadNextGameData = function () {
		
		let address = this.gameData.getExpectedAPIAddressForNextGame();
		
		// if we don't bind the current context, it creates a copy of the function and passes that instead (without context)
		// this feels so unnatural, but I am passing a function to begin with. 
		this.downloadGameData(address, this.setNextGame.bind(this));
		
	}
	
	this.downloadPreviousGameData = function () {
		
		let address = this.gameData.getExpectedAPIAddressForPreviousGame();
		
		this.downloadGameData(address, this.setPreviousGame.bind(this));
		
	}
	
	
	this.downloadGameData = function (apiAddress, onLoad) {

		try {
			
			new URL(apiAddress);
	
			var xmlHttp = new XMLHttpRequest();
			
			xmlHttp.onreadystatechange = function() { 
			
				if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
					
					onLoad(GameData.createGameDataFromAPIData(xmlHttp.responseText));
					
				}
					
			}.bind(this);
			
			xmlHttp.addEventListener('error', function() {
				
				console.log("Error: Failed to download game data for some unknown reason. Retrying...");
				
				this.downloadGameData(apiAddress, onLoad);
				
			}.bind(this));
			
			xmlHttp.open("GET", apiAddress, true); 
			xmlHttp.send(null);
			
		} catch(e) {
			
			console.log("Error: Failed to download game data for some unknown reason. Retrying...");
			
			this.downloadGameData(apiAddress, onLoad); // I wonder if context is lost when it was bound when passed in.
		
		}
	
	}
	
	this.loadGame(this.gameSplitter.getContentData());
	
	if(this.hasNextDownloadableGame()) {
		
		this.downloadNextGameData();
		
	}
	
	if(this.hasPreviousDownloadableGame()) {
		
		this.downloadPreviousGameData();
		
	}
	
	
	this.restartGame = function () {
	
		let temp = this.game.getInitializedGameData();
		
		this.loadGame(temp);
	
	}
	
	this.sendGameInput = function (inputCode) {
	
		if(this.game.getGameState() == Game.GAME_IS_RUNNING) {
		
			this.game.sendGameInput(inputCode);
		
		} else {

			console.log("Error: The game has either not been started or it's finished");
		
		}
	
	}
	
	this.isGameOver = function () {
	
		return this.game.getGameState() == GAME_IS_OVER;
	
	}
	
	this.getNextGameData = function() {
		
		return this.nextGameData;
		
	}
	
	this.getPreviousGameData = function() {
		
		return this.previousGameData;
		
	}
	
	this.getGameData = function() {
		
		return this.gameData;
		
	}
	
	this.isNextGameDownloaded = function () {
		
		let next = this.getNextGameData();
		
		if(next == null) {
			
			return false;
			
		}
		
		if(next.getTestNumber() == this.getGameData().getTestNumber()) {
			
			return false;
			
		}
		
		return true;
		
	}
	
	this.isPreviousGameDownloaded = function () {
		
		let previous = this.getPreviousGameData();
		
		if(previous == null) {
			
			return false;
			
		}
		
		if(previous.getTestNumber() == this.getGameData().getTestNumber()) {
			
			return false;
			
		}
		
		return true;
		
	}
	
	
	this.hasNextSplitGame = function() {
		
		if(this.gameSplitter.hasNextGame()) {
			
			return true;
			
		}
		
		return false;
		
	}
	
	this.hasPreviousSplitGame = function() {
		
		if(this.gameSplitter.hasPreviousGame()) {
			
			return true;
			
		}
		
		return false;
		
	}
	
	this.loadNextGame = function() {
		
		if(!this.hasNextGame() && !this.hasNextSplitGame())
			return false;
		
		if(this.hasNextSplitGame()) {
			
			this.loadGame(this.gameSplitter.nextGame());
			
		} else if(this.isNextGameDownloaded()) {
			
			this.previousGameData = this.gameData;
			
			// screen size is changed here. it would be annoying to have the game size
			// to change during a split game. (as different screen sizes result in different game sizes
			// and the best way to handle that is to just reset the game.)
			
			this.gameSplitter = new GameSplitter(this.getNextGameData().getContentData(), this.screenType);
			
			this.loadGame(this.gameSplitter.getContentData()); // saving of scores is done here
			
			this.gameData = this.getNextGameData();
			
			this.nextGameData = null;
			this.downloadNextGameData();
			
		} else {
			
			if(this.hasNextDownloadableGame()) {
				
				this.downloadNextGameData();
				
			}
			
			console.log("Error: Game wasn't downloaded... downloading it now.");
			
			return false;
			
		}
		
		return true;
		
	}
	
	this.loadPreviousGame = function () {
		
		if(!this.hasPreviousGame() && !this.hasPreviousSplitGame())
			return false;
		
		if(this.hasPreviousSplitGame()) {
			
			this.loadGame(this.gameSplitter.previousGame());
			
		} else if(this.isPreviousGameDownloaded()) {
			
			this.nextGameData = this.gameData;
			
			// see comments on loadNextGame for why this is done.
			this.gameSplitter = new GameSplitter(this.getPreviousGameData().getContentData(), this.screenType);
			
			this.gameSplitter.setGameIndex(this.gameSplitter.getAmountOfGames() - 1);
			
			this.loadGame(this.gameSplitter.getContentData());
			
			this.gameData = this.getPreviousGameData();
			
			this.previousGameData = null;
			this.downloadPreviousGameData();
			
		} else {
			
			this.downloadPreviousGameData();
			
			console.log("Error: Game wasn't downloaded... downloading it now.");
			
			return false;
			
		}
		
		return true;
		
	}
	
	
	this.getGameWPM = function () {
		
		if(this.game != null) {
			
			return this.game.getGameWPM();
			
		}
		
		return 0;
	
	}
	
	this.getGameText = function () {
	
		return this.game.rawGameText;
		
	}
	
	this.getGrammarText = function() {
	
		return this.game.wordGrammar[this.game.currentWordIndex];
	
	}
	
	this.getTranslatedSentences = function () {
	
		return this.game.translatedSentences[this.game.currentSentenceIndex];
	
	}
	
	this.getTranslatedWords = function () {
	
		return this.game.translations[this.game.currentWordIndex];
	
	}
	
	this.getGameHTML = function () {
	
		return this.game.createGameHTML();
	
	}
	
	
	return this;
	

}
