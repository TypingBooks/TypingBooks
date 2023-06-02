Game.createRawGameText = function (wordsArray) {

	let i = 0;
	let j = 0;
	let rawGameText = []; //could be optimized, but this method should only be called once per game
	
	for(i = 0; i < wordsArray.length; i++) {
	
		let word = wordsArray[i];
		
		let k = 0;
		
		for(k = 0; k < word.length; k++) {
			
			rawGameText[j] = word.charAt(k);
			j++;					
		
		}
		
		if(i < wordsArray.length - 1) {
		
			rawGameText[j] = ' ';
			j++;
			
		}
	
	}
	
	rawGameText[j] = " "; //cheap fix to handle highlighting (word count will be wrong if changed)
	
	return rawGameText;

}

Game.GAME_NOT_STARTED = 0;
Game.GAME_IS_RUNNING = 1;
Game.GAME_IS_OVER = 2;

Game.isValidGameContentData = function (gameContentData) {
	
	return	gameContentData.getWordsInTest().length == gameContentData.getWordTranslationsInTest().length
			&& gameContentData.getWordTranslationsInTest().length == gameContentData.getGrammarExplanationsInTest().length
			&& gameContentData.getSentenceTranslationsInTest().length == TextTools.getSentenceCount(gameContentData.getWordsInTest());
			
}

function Game(gameContentData) {
	
	this.gameContentData = gameContentData;

	this.startTime = 0;
	this.endTime = 0;
	
	this.words = gameContentData.getWordsInTest(); //array
	this.translations = gameContentData.getWordTranslationsInTest(); //array
	this.translatedSentences = gameContentData.getSentenceTranslationsInTest(); //array
	this.wordGrammar = gameContentData.getGrammarExplanationsInTest(); //array
	
	this.gameIsOver = false;
	this.gameStarted = false;
	
	this.currentWordIndex = 0;
	this.rawTextIndex = 0;
	this.currentSentenceIndex = 0;
	
	this.errorStartIndex = 0;
	this.hasError = false;
	
	this.currentWordStartIndex = 0;
	this.currentWordEndIndex = 0;
	
	this.correctWordLettersTyped = 0;
	
	this.getInitializedGameData = function () {

		return this.gameContentData;
	
	}
	
	this.rawGameText = Game.createRawGameText(this.words);
	
	this.createGameHTML = function () {
		
		let highlightType = 0; // 0 - word selection
		let highlightStart = this.currentWordStartIndex;
		let highlightEnd = this.currentWordEndIndex;
		
		// we'll create a version with error highlighting and return it instead
		if(this.hasError) {
		
			highlightType = 1;
			highlightStart = this.errorStartIndex; 
			highlightEnd = this.rawTextIndex - 1;
		
		}
		
		let highlightStartTag = "";
		
		switch(highlightType) {
	
			case 0:
			default:
				highlightStartTag = "<span class=\"bg-dark text-white\">";
				
				// Not only should tags not be passed like this, but this is not supposed to 
				// interact with the interface **at all.** This is a hack to make it work right now.
				if(pageScreen.isDarkModeOn()) {
					
					highlightStartTag = "<span class=\"bg-white text-dark\">";
					
				} 
				
			break;
	
			case 1:
				highlightStartTag = "<span class=\"bg-danger text-white\">";
			break;
		
		}
		
		// This should really just be a pre-calculated array for efficiency
		// memory will be re-allocated a lot if this isn't fixed.
		let html = "";
		
		for(let i = 0; i < this.rawGameText.length; i++) {
		
			if(!this.gameIsOver && this.gameStarted) {
			
				if(i == highlightStart) {
				
					html = html + highlightStartTag;
				
				}
				
			}
		
			
			html = html + this.getRawTextAtIndex(i);
		
			if(!this.gameIsOver && this.gameStarted) {
			
				// highlight ends after this index
				if(i == highlightEnd) {
				
					html = html + "</span>"
				
				}
				
			}
		
		}
		
		return html;
	
	}
	
	this.getRawTextAtIndex = function (index) {
	
		return this.rawGameText[index];
	
	}
	
	// avoid messing with this index by hand if at all possible
	this.getRawTextIndex = function () {
	
		return this.rawTextIndex;
	
	}
	
	this.getGameWPM = function () {
		
		let passedTime = this.getElapsedTime();
		// passed time in seconds
		passedTime = ((passedTime > 0) ? passedTime : 1) / 1000;
		
		/*
		// each word has a space that is counted with it, we don't actually want to count these
		// spaces in our WPM calculation
		let wordCount = this.getWordCount();
		let averageWordLength = (this.rawGameText.length / wordCount) - 1;
		
		if(this.correctWordLettersTyped == 0)
			return (0).toFixed(2);
		
		let wordsTyped = this.correctWordLettersTyped / averageWordLength;
		
		let wpm = ((wordsTyped > 0 ? wordsTyped : 1) / (passedTime > 0 ? passedTime : 1)) * 60;
		*/
		
		// It's pretty much standard that WPM = (((keystrokes / 5) / seconds) * 60) 
		// Actual WPM will just be calculated later if people want to see it, I think
		// there will probably be more annoyance that it doesn't follow the same standard as
		// everyone else.
		let keystrokes = this.rawTextIndex - (this.hasError ? this.rawTextIndex - this.errorStartIndex :  0)
		
		if(keystrokes <= 0)
			return (0).toFixed(2);
		
		let wpm = (((keystrokes / 5) / passedTime) * 60);
		
		
		return wpm.toFixed(2);
	
	}
	
	this.sendGameInput = function (inputCode) {
	
		if(this.getGameState() != Game.GAME_IS_RUNNING) {
		
			console.log("Error: Game is either over or not started.");
			
			return;
		
		}
		
		const backspace = 8;
			
		if(String.fromCharCode(inputCode) == this.getCurrentRawCharacter()) {
		
			// current word and error high lighting is handled here.
			this.moveToNextCharacter();
		
		// We are either starting an error, backspacing an error,
		// backspacing correct text, or increasing an error
		} else {
		
			if(inputCode == backspace) {
				
				// current word and error high lighting is handled here.
				this.moveToPreviousCharacter();
			
			} else {
			
				if(!this.hasError) {
				
					this.hasError = true;
					this.errorStartIndex = this.getRawTextIndex();
					this.errorEndIndex = this.getRawTextIndex() - 1;
				
				}
				
				// current word and error high lighting is handled here.
				this.moveToNextCharacter();
			
			}
		
		}
	
	}
	
	this.getCurrentRawCharacter = function () {
		
		return this.getRawTextAtIndex(this.getRawTextIndex());
	
	}
	
	this.moveToNextCharacter = function () {
	
		this.incrementRawTextIndex();
	
	}
	
	this.moveToPreviousCharacter = function () {
	
		this.decrementRawTextIndex();
	
	}
	
	
	this.incrementRawTextIndex = function () {
		
		const space = 32;
	
		if(!this.hasError) {
		
			this.correctWordLettersTyped++;
		
			// if our current change is from a space, we need 						
			// to change the highlighting/word that we're on
			if(this.getCurrentRawCharacter().charCodeAt(0) == space) {

			
				// our calculation is based purely on the words typed. we could ignore spaces
				// but no one actually types without spaces
				this.correctWordLettersTyped--;
			
				this.moveToNextWord();
			
			} 
		
		} else {
		
			this.errorEndIndex++;
			
			if(this.errorEndIndex >= this.rawGameText.length)
				this.errorEndIndex = this.rawGameText.length - 1;
		
		}
		
		// raw text index is increased without looking
		// basically just saying go to the next character
		this.rawTextIndex++;
		
		if(!this.hasError) {
		
			// raw text index is increased without looking
			// basically just saying go to the next character
			// the -1 is there because there's actually a hidden space in the rawGameText (at the end)
			if(this.rawTextIndex >= this.rawGameText.length - 1) 
				this.endGame();
		
		}
		
		if(this.rawTextIndex >= this.rawGameText.length) {
		
			this.rawTextIndex = this.rawGameText.length - 1; //sets it to the last character
		
		}
	
	}
	
	this.decrementRawTextIndex = function () {
		
		const space = 32;
		
		if(!this.gameIsOver) {
			
			// if our current change is from a space, we need 						
			// to change the highlighting/word that we're on
			
				
			if(this.rawTextIndex > 0) {
				
				this.rawTextIndex--;	
				
				this.currentWordStartIndex = this.rawTextIndex;
				
			} else {
				
				this.currentWordStartIndex = 0
				
			} 
		
			if(this.getCurrentRawCharacter().charCodeAt(0) == space) {
			
				if(!this.hasError) {
			
					this.moveToPreviousWord();
				
				}
				
				this.currentWordEndIndex = this.rawTextIndex;
			
			}
		
			if(this.hasError == true) {
				
				this.errorEndIndex--;
				
				if(this.errorEndIndex < 0)
					this.errorEndIndex = 0;
				
				if(this.rawTextIndex <= this.errorStartIndex) {
					this.hasError = false;
				
				}
			
			} else {
			
				if(this.getCurrentRawCharacter().charCodeAt(0) != space) {
				
					// if it's at the start, and someone sends a backspace, 
					// this check happens
					if(this.correctWordLettersTyped > 0) {
						
						this.correctWordLettersTyped--;
					
					}
					
				}	
			
			}
		
		}
	
	}
	
	this.moveToNextWord = function () {

		this.currentWordStartIndex = this.getRawTextIndex();

		//fix highlighting
		let i = this.getRawTextIndex() + 1;
		
		for(i; this.getRawTextAtIndex(i) != " " && i < this.rawGameText.length - 1; i++);
		
		this.currentWordEndIndex = i;

		if(this.currentWordIndex < this.words.length - 1) {
		
			this.currentWordIndex++;
			
			// don't move to the next sentence until after the word with punctuation
			if(TextTools.wordContainsPunctuation(this.getWord(this.currentWordIndex - 1))) {
			
				if(this.currentSentenceIndex < this.translatedSentences.length - 1) {
				
					this.currentSentenceIndex++;
				
				}
				
			}
			
		}

	}
	
	this.getCurrentWord = function () {
	
		return this.words[this.currentWordIndex];			
	
	}
	
	this.getWord = function(index) { 
	
		return this.words[index];
	
	}

	this.moveToPreviousWord = function () {

		this.currentWordIndex--;

		if(this.currentWordIndex < 0)
			this.currentWordIndex = 0;
			
			
		if(this.currentWordIndex >= 0) {
		
			// don't move to the next sentence until after the word with punctuation
			if(TextTools.wordContainsPunctuation(this.getCurrentWord())) {
			
				if(this.currentSentenceIndex > 0) {
				
					this.currentSentenceIndex--;
				
				}
				
			}
			
		}

	}
	
	
	this.getWordCount = function () {
		
		return this.words.length;
	
	}
	
	this.startTimer = function () {
	
		this.startTime = new Date().getTime();
	
	}
	
	this.stopTimer = function () {
	
		this.endTime = new Date().getTime();
	
	}
	
	this.getElapsedTime = function () {
	
		if(this.gameIsOver) {
		
			return this.endTime - this.startTime;
		
		}
		
		return new Date().getTime() - this.startTime;
	
	}
	
	this.startGame = function () {
	
		this.startTimer();
		this.setupFirstWordHighlight();
		
		this.gameStarted = true;
		
	}
	
	this.setupFirstWordHighlight = function () {
	
		let i = 0;
		
		for(i; this.getRawTextAtIndex(i) != ' ' && i < this.rawGameText.length - 1; i++);
		
		this.currentWordEndIndex = i;
	
	}
	
	this.endGame = function () {
		
		this.stopTimer();
		
		this.gameIsOver = true;
		
	}
	
	this.isGameStarted = function () {
	
		return this.gameStarted;
	
	}
	
	this.isGameOver = function() {
	
		return this.gameIsOver;
	
	}
	

	this.getAmountOfSentences = function () {

		return TextTools.getSentenceCount(this.words);
	
	}
	

	
	this.getGameState = function() {
		
		if(this.isGameStarted()) {
		
			if(this.isGameOver()) {
				
				return Game.GAME_IS_OVER;
			
			}
		
			return Game.GAME_IS_RUNNING;
			
		}

		return Game.GAME_NOT_STARTED;
	
	}

	return this;

}
	