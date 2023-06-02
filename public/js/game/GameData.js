
GameData.createGameDataFromAPIData = function (apiJSON) {
	
	let apiData = JSON.parse(apiJSON);
	
	let bookMetaData = null;
	
	TextTools.loadPunctuationMap(apiData.punctuationArray);
	
	if(apiData.translatedBook != null) {
		
		bookMetaData = new BookMetaData(apiData.translatedBook, apiData.book_title, apiData.author, apiData.part, apiData.chapter, apiData.paragraph, apiData.serverGameTitle);
		
	}
	
	let gameMetaData = new GameMetaData(apiData.base_api_address, apiData.game_address, apiData.native_language, apiData.learning_language, apiData.paragraphNumberInBook, apiData.paragraphsInBook, apiData.title, apiData.author, bookMetaData, apiData.user, apiData.csrf);
	let gameContentData = new GameContentData(apiData.original_words, apiData.translated_words, apiData.translated_sentences, apiData.grammar);
	
	return new GameData(gameContentData, gameMetaData);
	
}


// Just handles information about the game to make changing games easy
function GameData(gameContentData, gameMetaData) {
	
	this.gameMetaData = gameMetaData;
	this.gameContentData = gameContentData;
	
	this.getGameMode = function () {
		
		return this.gameMetaData.getGameMode();
		
	}
	
	this.getTestNumber = function () {
		
		return this.gameMetaData.getCurrentTest();
		
	}
	
	this.hasUser = function () {
		
		return this.gameMetaData.hasUser();
		
	}
	
	this.getUser = function() {
		
		return this.gameMetaData.getUser();
		
	}
	
	this.getTitle = function () {
		
		return this.getMetaData().getTitle();
		
	}
	
	this.getMetaData = function() {
		
		return this.gameMetaData;
		
	}
	
	this.getContentData = function() {
		
		return this.gameContentData;
		
	}
	
	this.getExpectedAPIAddressForNextGame = function () {
		
		return this.gameMetaData.getNextAPIAddress();
		
	}
	
	this.getExpectedAPIAddressForPreviousGame = function () {
		
		return this.gameMetaData.getPreviousAPIAddress();
		
	}
	
	this.getExpectedAPIAddressForThisGame = function () {
		
		return this.gameMetaData.getAPIAddress();
		
	}
	
	return this;
	
}
	