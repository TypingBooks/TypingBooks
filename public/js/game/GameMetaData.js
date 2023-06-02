
GameMetaData.TYPING_BOOKS = 1;
GameMetaData.TYPING_QUOTES = 2;

function GameMetaData(apiAddress, gameAddress, language, learningLanguage, currentTest, amountOfTests, title, author, bookMetaData, user, csrf) {
	
	this.gameAddress = gameAddress;
	this.apiAddress = apiAddress;
	this.language = language;
	this.learningLanguage = learningLanguage;
	this.currentTest = currentTest;
	this.amountOfTests = amountOfTests;
	this.author = author;
	this.book = bookMetaData;
	this.gameAddress = gameAddress;
	this.user = user;
	this.csrf = csrf;
	this.title = title;
	
	this.getCSRF = function () {
		
		return this.csrf;
		
	}
	
	this.hasUser = function () {
		
		return this.user != null;
		
	}
	
	this.getUser = function () {
		
		return this.user;
		
	}
	
	this.getExpectedNextGameTest = function () {
		
		if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
			
			if(this.getCurrentTest() + 1 <= this.getAmountOfTestsInSet()) {
				
				return this.getCurrentTest() + 1;
			
			} 
			
			return -1;
			
		}
	
		return -1;
	
	}
	
	this.getGameAddress = function () {
		
		return this.gameAddress;
		
	}
	
	this.getExpectedPreviousGameTest = function () {
		
		if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
	
			if(this.getCurrentTest() - 1 >= 1) {
				
				return this.getCurrentTest() - 1;
			
			} 
			
			return -1;
			
		}
	
		return -1;
	
	}
	
	this.getBaseAPIAddress = function () {
		
		return this.apiAddress;
		
	}
	
	this.getAPIAddress = function () {
		
		if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
			
			return this.getBaseAPIAddress() + BookMetaData.buildAPIPath(this.book.getID(), this.getCurrentTest());  
			
		}
		
		console.log("Error: Could not build the API Address. Game mode is undefined.")
		
		return this.apiAddress;
		
	}
	
	this.hasNextGame = function() {
		
		return this.getExpectedNextGameTest() != -1;
		
	}
	
	this.hasPreviousGame = function() {
		
		return this.getExpectedPreviousGameTest() != -1;
		
	}
	
	this.getNextAPIAddress = function () {
		
		if(this.hasNextGame()) {
		
			if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
				
				return this.getBaseAPIAddress() + BookMetaData.buildAPIPath(this.book.getID(), this.getCurrentTest() + 1);  
				
			}
			
		}
		
		console.log("Error: There is not a next test. Loading the same game again.");
		
		return this.getAPIAddress();
		
	}
	
	this.getPreviousAPIAddress = function () {
		
		if(this.hasPreviousGame()) {
		
			if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
				
				return this.getBaseAPIAddress() + BookMetaData.buildAPIPath(this.book.getID(), this.getCurrentTest() - 1);  
				
			}
			
		}
		
		console.log("Error: There is not a previous test. Loading the same game again.");
		
		return this.getAPIAddress();
		
	}
	
	this.getAuthor =  function () {
		
		return this.author;
		
	}
	
	this.getAmountOfTests = function() {
		
		return this.amountOfTests;
		
	}
	
	this.getCurrentTest = function() {
		
		return this.currentTest;
		
	}
	
	this.getGameMode = function () {
		
		if(this.book == null) {
			
			return GameMetaData.TYPING_QUOTES;
			
		}
		
		return GameMetaData.TYPING_BOOKS;
		
	}
	
	this.getTitle = function() {
		
		if(this.getGameMode() == GameMetaData.TYPING_BOOKS) {
			
			return this.book.getFullTitle();
			
		}
		
		return this.title;
		
	}
	
	this.getChapter = function() {
		
		if(this.getGameMode == GameMetaData.TYPING_BOOKS) {
			
			return book.getChapter();
			
		}
		
		return "";
		
	}
	
	this.getPart = function() {
		
		if(this.getGameMode == GameMetaData.TYPING_BOOKS) {
			
			return book.getPart();
			
		}
		
		return "";
		
	}
	
	this.getParagraph = function() {
		
		if(this.getGameMode == GameMetaData.TYPING_BOOKS) {
			
			return book.getParagraph();
			
		}
		
		return currentTest;
		
	}
	
	this.getAmountOfTestsInSet = function() {
		
		return this.amountOfTests;
		
	}
	
	return this;
	
}