
GameSplitter.NO_SPLIT = 0;
GameSplitter.XTRA_SMALL = 1;
GameSplitter.SMALL = 2;
GameSplitter.MEDIUM = 3;
GameSplitter.LARGE = 4;
GameSplitter.XTRA_LARGE = 5;

// These are the amount of characters to use per game
// to be used along with the values above.

// These values were chosen by:
// 1. Typing the below into the console.
// 	javascript:document.body.contentEditable = true; void 0; 
// 2. Adjusting the window until the page snaps to a the perspective
// 3. Increasing the text with @ symbols until the game wasn't playable
// 4. Repeat from 2.

// It's probably an even better idea to combine the below
// with detection of the height of the screen size...

GameSplitter.CHARACTERS_FOR_NO_SPLIT = Infinity;
GameSplitter.CHARACTERS_FOR_XS = 120; //120
GameSplitter.CHARACTERS_FOR_SM = 120; //120
GameSplitter.CHARACTERS_FOR_MD = 234; //234
GameSplitter.CHARACTERS_FOR_LG = 330;
GameSplitter.CHARACTERS_FOR_XL = 402;


GameSplitter.getSizeForGameType = function (gameType) {
	
	let size = 0;
	
	switch(gameType) {
	
		case GameSplitter.XTRA_SMALL:
			size = GameSplitter.CHARACTERS_FOR_XS;
			break;
			
		case GameSplitter.SMALL:
			size = GameSplitter.CHARACTERS_FOR_SM
			break;
			
		case GameSplitter.MEDIUM:
			size = GameSplitter.CHARACTERS_FOR_MD
			break;
			
		case GameSplitter.LARGE:
			size = GameSplitter.CHARACTERS_FOR_LG
			break;
			
		case GameSplitter.XTRA_LARGE:
			size = GameSplitter.CHARACTERS_FOR_XL
			break;
		
		default:	
		case GameSplitter.NO_SPLIT:
			size = Infinity;
			break;
	
	}
	
	return size;
	
}

GameSplitter.isValidGameType = function(newGameType) {
	
	return newGameType >= GameSplitter.NO_SPLIT && newGameType <= GameSplitter.XTRA_LARGE;
	
}


function GameSplitter(gameContentData, gameType) {

	this.originalGameContentData = gameContentData;
	
	this.gameType = GameSplitter.NO_SPLIT;
	
	this.modifiedGameData = [];
	this.modifiedGameData[0] = gameContentData;
	this.currentGameDataIndex = 0;
	this.lastGameDataIndex = 0;
	this.scoresForGame = [];
	
	this.getSize = function () {
		
		return GameSplitter.getSizeForGameType(this.gameType);
		
	}
	
	this.getCurrentGameIndex = function() {
		
		return this.currentGameDataIndex;
		
	}
	
	this.getOriginalData = function() {
		
		return this.originalGameContentData;
		
	}
	
	this.getAllContentData = function() {
		
		return this.modifiedGameData;
		
	}
	
	this.getContentData = function() {
		
		return this.modifiedGameData[this.getCurrentGameIndex()];
		
	}
	
	this.calculateAmountOfCharactersInGameData = function() {
		
		let words = this.getOriginalData().getWordsInTest();
		let size = 0;
		
		for(let i = 0; i < words.length - 1; i++) {
			
			// + 1 for the space
			size += words[i].length + 1; 
			
		}
		
		// no space on last word
		size += words[words.length - 1].length;
		
		return size;
		
	}
	
	
	
	this.calculateAmountOfGames = function() {
		
		return this.modifiedGameData.length;
		
	}
	

	
	
	this.getGameType = function() {
		
		return this.gameType;
		
	}
	
	this.hasNextGame = function () {
		
		return this.getCurrentGame() < this.getAmountOfGames();
		
	}
	
	this.nextGame = function () {
		
		if(this.hasNextGame()) {
			
			this.incrementGameIndex();
			
			return this.getContentData();
			
		} else {
			
			throw "There is not a next game.";
			
		}
		
	}
	
	this.hasPreviousGame = function() {
		
		// games start at 1
		return this.getCurrentGame() > 1;
		
	}
	
	this.previousGame = function() {
		
		if(this.hasPreviousGame()) {
			
			this.decrementGameIndex();
			
			return this.getContentData();
			
		} else {
			
			throw "There is not a previous game";
			
		}
		
	}
	
	this.buildContentData = function() {
		
		let gameSize = this.getSize();
		
		let data = this.getOriginalData();
		
		let words = data.getWordsInTest();
		let grammar = data.getGrammarExplanationsInTest();
		let sentences = data.getSentenceTranslationsInTest();
		let translations = data.getWordTranslationsInTest();
		
		let arrayOfContentData = [];
		let currentArrayIndex = 0;
		
		let currentGameLength = 0;
		
		let startIndex = 0;
		
		let startSentenceIndex = 0;
		let sentenceAddition = 0;
		let sentenceIndex = 0;
		
		for(let i = 0; i < words.length; i++) {
			
			let currentWordLength = TextTools.wordContainsPunctuation(words[i]) ? words[i].length : words[i].length + 1;
			
			// add to current game
			if((currentGameLength + currentWordLength) < gameSize) {
				
				currentGameLength += currentWordLength;
				
			// split it
			} else {
				
				// if a word is more than the game size, it just starts a new game with it.
				// if there's a 300-800 character word, the person typing probably won't care that
				// the typing test no longer fits perfectly on the screen...
				
				let tempWords = words.slice(startIndex, i); // don't include the current word
				let tempGrammar = grammar.slice(startIndex, i);
				let tempTranslations = translations.slice(startIndex, i);
				
				// always include the sentence index
				let tempSentences = sentences.slice(startSentenceIndex, sentenceIndex + 1);
				
				if(sentenceIndex > 0) {
					
					// The last "game part" received an extra sentence above when it didn't
					// need one because it was the word that increased the sentence index.
					if(TextTools.wordContainsPunctuation(words[i - 1])) {
						
						tempSentences = sentences.slice(startSentenceIndex, sentenceIndex);
						
					}
					
				}
				
				
				let tempContentData = new GameContentData(tempWords, tempTranslations, tempSentences, tempGrammar);
				
				arrayOfContentData[currentArrayIndex] = tempContentData;
				
				if(tempWords.length == 0) {
				
					// The logic above doesn't check if the word is literally the reason it was thrown to here.
					// This just forces it to be accepted in this spot.
					
					currentArrayIndex--;
					
				}
				
				startSentenceIndex = sentenceIndex;
				
				
				// 0 to show it's reset
				currentGameLength = 0 + currentWordLength;
			
				startIndex = i; //this word is the start of a new game
				currentArrayIndex++;
				
				
			}
			
			if(i == words.length - 1) {
				
				// add the rest 
				
				arrayOfContentData[currentArrayIndex] = new GameContentData( 
						words.slice(startIndex, words.length), 
						translations.slice(startIndex, words.length), 
						sentences.slice(startSentenceIndex, sentences.length), 
						grammar.slice(startIndex, words.length));
				
			}
			
			if(TextTools.wordContainsPunctuation(words[i])) {
				
				sentenceIndex++;
				
			}
			
			
		}
		
		return arrayOfContentData;
		
	}
	
	this.setGameType = function(newGameType) {
		
		if(GameSplitter.isValidGameType(newGameType)) {
			
			// Everything has to be reset because the game sizes
			// will be different...
			this.gameType = newGameType;
			this.currentGameDataIndex = 0;
			this.lastGameDataIndex = this.calculateAmountOfGames() - 1;
			this.scoresForGame = [];
			
			this.modifiedGameData = this.buildContentData(); 
			
		} else {
			
			throw "Invalid game type";
			
		}
		
	}
	
	this.setGameType(gameType);
	
	this.getTitle = function() {
		
		let title = "";
		
		if(this.getAmountOfGames() > 1) {
			
			title = "(" + this.getCurrentGame() + "\/" + this.getAmountOfGames() + ")";
			
		}
		
		return title;
		
	}
	
	this.lastGameDataIndex = this.calculateAmountOfGames() - 1;
	
	this.getAmountOfGames = function () {
		
		return this.lastGameDataIndex + 1;
		
	}
	
	this.getCurrentGame = function () {
		
		return this.currentGameDataIndex + 1;
		
	}
	
	this.setGameIndex = function(newIndex) {
		
		if(newIndex >= 0 && newIndex < this.getAmountOfGames()) {
			
			this.currentGameDataIndex = newIndex;
			
		} else {
			
			throw "New game index is out of bounds.";
			
		}
		
	}
	
	
	this.incrementGameIndex = function() {
		
		if(this.lastGameDataIndex >= this.getCurrentGameIndex() + 1) {
			
			this.setGameIndex(this.getCurrentGameIndex() + 1)
			
		} else {
			
			throw "There are not any more games. Staying on last game.";
			
		}
		
	}
	
	this.decrementGameIndex = function() {
		
		if(0 <= this.getCurrentGameIndex() - 1) {
			
			this.setGameIndex(this.getCurrentGameIndex() - 1)
			
		} else {
			
			throw "There are not any more games. Staying on first game.";
			
		}
		
	}
	
	this.getScoresForGame = function () {
		
		return this.scoresForGame;
		
	}
	
	// If all parts were completed, it returns the average
	// otherwise it returns -1
	this.getAverageScoreForGame = function () {
		
		if(this.scoresForGame.length == this.getAmountOfGames()) {
		
			let total = 0.00;
			
			for(let i = 0; i < this.scoresForGame.length; i++) {
				
				if(this.scoresForGame[i] == null)
					return -1;
				
				total += parseFloat(this.scoresForGame[i].getScore());
				
			}
			
			if(total > 0)  {
				
				return total / this.getAmountOfGames();
				
			}
				
		}
		
		return -1;
		
		
	}
	
	this.handleScoreData = function(data) {
		
		this.scoresForGame[this.getCurrentGame() - 1] = data;
		
	} 
	

	return this;
	
}