

var pageScreen = [];

pageScreen.gameText = document.getElementById("gameText");
pageScreen.wordTranslation = document.getElementById("wordTranslation");
pageScreen.wordTranslationTitle = document.getElementById("wordTranslationTitle");
pageScreen.grammarText = document.getElementById("grammarText");
pageScreen.sentenceTranslation = document.getElementById("sentenceTranslation");
pageScreen.gameWPM = document.getElementById("gameWPM");
pageScreen.typingInput = document.getElementById("typingInput");
pageScreen.gameCrumbTitle = document.getElementById("gameCrumbTitle");
pageScreen.gameTitle = document.getElementById("gameTitle");

pageScreen.wordTranslationDefaultWinTitle = "Press ENTER to start the next game";
pageScreen.wordTranslationDefaultCompleteTitle = "Last test completed!"
pageScreen.wordTranslationDefaultTitle = "Current Word Translation";

pageScreen.notLearningLanguage = false;

pageScreen.apiAddress = "";

pageScreen.gameFontSize = 1;
pageScreen.MAX_FONT_SIZE = 6;

pageScreen.darkMode = false;

pageScreen.isDarkModeOn = function() {
	
	return pageScreen.darkMode;
	
}

pageScreen.getTagForFontSize = function(size) {
	
	let tag = "";
	
	switch(size) {
	
	case 2:
	case 3:	
	case 4:
	case 5:
	case 6:
	case 7: 
		tag = "h" + (6 - (size - 1));
		break;
	default:
	case 1:
		tag = "";
		break;
		
	}
	
	return tag;
	
}

pageScreen.updateGameText = function (newHTML) {
	
	let fontSizeTag = pageScreen.getTagForFontSize(pageScreen.gameFontSize); 
	
	if(fontSizeTag != "") {
		
		pageScreen.gameText.innerHTML = "<p class=\"" + fontSizeTag + "\">" + newHTML + "</p>";
		
	} else {
		
		pageScreen.gameText.innerHTML = newHTML;
		
	}
	
}


pageScreen.currentInputTextState = "";
pageScreen.lastInputTextState = "";

pageScreen.resetPage = function () {
	
	pageScreen.currentInputTextState = "";
	pageScreen.lastInputTextState = "";
	pageScreen.typingInput.value = "";

}

pageScreen.getCurrentTypedText = function () {
	
	return pageScreen.typingInput.value;

}

pageScreen.changeCurrentlyTypedText = function (newText) {

	pageScreen.typingInput.value = newText;

}

pageScreen.updatePageState = function () {

	pageScreen.currentInputTextState = pageScreen.getCurrentTypedText();

}

pageScreen.updateButtons = function () {
	
	let prev = document.getElementById("previousGameButton");
	let next = document.getElementById("nextGameButton");
	
	if(this.gameController.hasPreviousGame()) {
		
		prev.disabled = false;
		
	} else {
		
		prev.disabled = true;
		
	}
	
	if(this.gameController.hasNextGame()) {
		
		next.disabled = false;
		
	} else {
		
		next.disabled = true;
		
	}
	
}

// https://stackoverflow.com/a/55368012
pageScreen.getViewport = function () {
	
	const width = Math.max(
	    document.documentElement.clientWidth,
	    window.innerWidth || 0
	);
	  
	if (width <= 576) 
		return GameSplitter.XTRA_SMALL;
		
	if (width <= 768) 
		return GameSplitter.SMALL;
		
	if (width <= 992) 
		return GameSplitter.MEDIUM;
		
	if (width <= 1200) 
		return GameSplitter.LARGE;
		
	return GameSplitter.XTRA_LARGE;
	
}

pageScreen.manageGameState = function (input) {
	
	const ENTER = 13;
	
	if(this.gameController.game.getGameState() == Game.GAME_IS_OVER) {
	
		if(input == ENTER) {
			
			if(pageScreen.gameController.hasNextGame()) {
				
				// Games are loaded with a game splitter. We only want to change
				// the game size between full games. As long as the screen size is updated
				// before the load method, then the game will be correctly split.
				pageScreen.gameController.setScreenType(pageScreen.getViewport());
				
				pageScreen.loadNextGame();

			}
			
		}
		
	} else if(this.gameController.game.getGameState() == Game.GAME_NOT_STARTED) {
		
		this.gameController.startGame();
		
	}
	
	pageScreen.updatePageState();
	
}


pageScreen.fixTextThatOverlapsGame = function () {
	
	if(pageScreen.currentInputTextState.length >= pageScreen.gameController.getGameText().length) {
		
		// The game actually works fine without these, this is just to save 
		// someone else time. It's totally non-game dependent. 
		
		pageScreen.changeCurrentlyTypedText(pageScreen.currentInputTextState.substring(0, pageScreen.gameController.getGameText().length - 1));
		
		pageScreen.updatePageState();
	
	}
	
}

// I should improve this so that it isn't as ugly as it is.
pageScreen.sendGameInputChanges = function () {
	
	let BACKSPACE = 8;
	let changeCode = -1;
	let changeCount = 0;

	if(pageScreen.currentInputTextState.length > pageScreen.lastInputTextState.length) {
	
		changeCode = pageScreen.currentInputTextState.charCodeAt(pageScreen.currentInputTextState.length - 1);
		
		changeCount = pageScreen.currentInputTextState.length - pageScreen.lastInputTextState.length;
	
	// if the size decreased, we'll just automatically assume it was a backspace
	// this should make it harder for people who want to cheat, but ultimately, 
	// it won't be impossible for someone to cheat. we just don't care.
	} else if(pageScreen.currentInputTextState.length < pageScreen.lastInputTextState.length) {
	
		changeCount = pageScreen.lastInputTextState.length - pageScreen.currentInputTextState.length;
	
		changeCode = BACKSPACE;
	
	} 
	
	pageScreen.lastInputTextState = pageScreen.currentInputTextState;
	
	// If a user highlights text, and then presses a character, but the new text area is the same length.
	// This catches that, and send a backspace to the game, followed by whatever this new character is. 
	if(changeCount == 0) {
		
		if(pageScreen.currentInputTextState.length > 0) {
			
			pageScreen.gameController.sendGameInput(BACKSPACE);
			pageScreen.gameController.sendGameInput(pageScreen.currentInputTextState.charCodeAt(pageScreen.currentInputTextState.length - 1));
			
		}
		
		
	}
	
	// yes, this doesn't actually work. The game isn't supposed to be beatable by 
	// copy/pasting. It's just basically recognizing that there is input typed, but
	// doesn't count any of it as valid after the first character.
	for(let i = 0; i < changeCount; i++) { 
	
		// as long as changes happened
		if(changeCode != -1) {
			
			if(this.gameController.game.getGameState() == Game.GAME_IS_RUNNING) {
			
				pageScreen.gameController.sendGameInput(changeCode);
				
				if(i == changeCount - 1) {
					
					if(changeCode == BACKSPACE) {
						
						// Like above when it was equal... This covers when it wasn't equal. Just in case they replaced a character.
						if(pageScreen.currentInputTextState.length > 0) {
							
							// When the backspace is sent here, it messes up the highlighting because normally someone
							// isn't going to do the backspace + character combo.
							
							// Backspace moves the highlight back one character, which sticks so that the player isn't distracted
							// But, now it's offset...
							pageScreen.gameController.sendGameInput(BACKSPACE);
							pageScreen.gameController.sendGameInput(pageScreen.currentInputTextState.charCodeAt(pageScreen.currentInputTextState.length - 1));
							
							
							// ...We fix that highlight error above by sending another input (we don't care if it's correct)
							// then correcting it with a backspace (which fixes the highlight) 
							
							// See comment on commit 0d17458d 
							// https://gitlab/project-name/-/commit/0d17458d75e467721f165820e63dee2e18949215
							pageScreen.gameController.sendGameInput(pageScreen.currentInputTextState.charCodeAt(pageScreen.currentInputTextState.length - 1));
							pageScreen.gameController.sendGameInput(changeCode);
							
							
							
						} 
						
					}
					
				}
			
			} else {
			
				// reset text ?
			
			}
			
		}
		
	}
	
}

pageScreen.savedCurrentGameScore = false;

// get's page changes, returns them to the current game.
pageScreen.handleGameInput = function (input) {
	
	// Handles loading the next game and starting games
	pageScreen.manageGameState(input);
	
	// Adjusts the input area if the text is overlapping the game
	pageScreen.fixTextThatOverlapsGame();
	
	// Sends input changes that are detected in the the game input
	pageScreen.sendGameInputChanges();

	// Updates the screen after the game has finished processing changes
	pageScreen.updateGameScreen();
	
	if(this.gameController.game.getGameState() == Game.GAME_IS_OVER) { 
		
		pageScreen.updateWordTranslation(this.gameController.getGameWPM() + " WPM");
		pageScreen.updateGameText(this.gameController.game.rawGameText.join(""));
		
		if(pageScreen.gameController.hasNextGame()) {
			
			pageScreen.updateWordTranslationTitle(pageScreen.wordTranslationDefaultWinTitle);
			
		} else {
			
			pageScreen.updateWordTranslationTitle(pageScreen.wordTranslationDefaultCompleteTitle);
			
		}
		
		if(!pageScreen.savedCurrentGameScore) { 
			
		
				
				pageScreen.saveGameScore();
				
			
		}
		
	}

}

pageScreen.saveGameScore = function () {
	
	let scoreData = new ScoreData(pageScreen.gameController.getGameWPM(), pageScreen.gameController.getGameData());
	
	pageScreen.gameController.addScoreToScoreHistory(scoreData);
	
	pageScreen.savedCurrentGameScore = true;
	
	pageScreen.addScoreToChart(pageScreen.gameController.getCurrentTitle(), pageScreen.gameController.getGameWPM());
	
	let testCount = pageScreen.gameController.getScoreHistory().length;
	
	pageScreen.setTestCount(testCount);
	pageScreen.setAverageWPM(pageScreen.gameController.getAverageWPM());
	
	pageScreen.gameController.gameSplitter.handleScoreData(scoreData);
	
	if(pageScreen.gameController.gameSplitter.getCurrentGame() == pageScreen.gameController.gameSplitter.getAmountOfGames()) {
		
		// Only save completed paragraphs. The score is submitted only if all parts have been commpleted, otherwise
		// it just isn't saved.		
		
		let avg = pageScreen.gameController.gameSplitter.getAverageScoreForGame();
		
		if(avg != -1) {
			
			GameController.saveScore(new ScoreData(avg, pageScreen.gameController.getGameData()));
			
		}
		
	} 
	
}


pageScreen.clearGameInputArea = function() {
	
	pageScreen.typingInput.value = "";
	
}

pageScreen.updateWPM = function (newWPM) {

	newWPM = pageScreen.sanitize(newWPM);
	
	pageScreen.gameWPM.innerHTML = newWPM;

}

pageScreen.updateGameScreen = function () {
	
	pageScreen.updateWPM(pageScreen.gameController.getGameWPM());
	
	if(pageScreen.gameController.game != null) {
		
		if(pageScreen.gameController.game.getGameState() != Game.GAME_IS_OVER) {
			
			pageScreen.updateGrammarText(pageScreen.gameController.getGrammarText());
			pageScreen.updateSentenceTranslation(pageScreen.gameController.getTranslatedSentences());
			
			if(pageScreen.notLearningLanguage) {
				
				pageScreen.updateWordTranslation(this.gameController.getGameWPM() + " WPM");
				
			} else {
				
				pageScreen.updateWordTranslation(pageScreen.gameController.getTranslatedWords());
				
			}
			
			pageScreen.updateGameText(pageScreen.gameController.getGameHTML());
		
		}
		
		pageScreen.updateButtons();
		
	}

}

pageScreen.loadNextGame = function () {
	
	if(pageScreen.gameController.hasNextGame()) {
		
		pageScreen.gameController.setScreenType(pageScreen.getViewport());
		
		pageScreen.gameController.loadNextGame();
		
	}
	
	pageScreen.setupNewGame();
	pageScreen.updateGameScreen();
	
}


pageScreen.setupNewGame = function() {
	
	pageScreen.resetPage();
	pageScreen.savedCurrentGameScore = false;
	pageScreen.clearGameInputArea();
	
	pageScreen.updateWordTranslationTitle(pageScreen.wordTranslationDefaultTitle);

	gameTitle.innerHTML = pageScreen.gameController.getCurrentTitle();
	gameCrumbTitle.innerHTML = pageScreen.gameController.getCurrentTitle();
	pageScreen.updateButtons();
	
	window.history.pushState(pageScreen.gameController.getCurrentTitle(), pageScreen.gameController.getCurrentTitle(), pageScreen.gameController.gameData.gameMetaData.getGameAddress());

	
}

pageScreen.loadPreviousGame = function() {
	
	if(pageScreen.gameController.hasPreviousGame()) {
		
		pageScreen.gameController.setScreenType(pageScreen.getViewport());
		
		pageScreen.gameController.loadPreviousGame();
		
	}
	
	pageScreen.setupNewGame();
	pageScreen.updateGameScreen();
	
}



pageScreen.updateWordTranslation = function (newText) {

	newText = pageScreen.sanitize(newText);
	
	if(newText.length < 1) {
		
		newText = "&nbsp;";
		
	}
	
	pageScreen.wordTranslation.innerHTML = newText;
	

}

pageScreen.updateWordTranslationTitle = function (newText) {
	
	newText = pageScreen.sanitize(newText);
	
	pageScreen.wordTranslationTitle.innerHTML = newText;
	
}

pageScreen.updateGrammarText = function (newText) {

	newText = pageScreen.sanitize(newText);
	
	pageScreen.grammarText.innerHTML = newText;


}

pageScreen.updateSentenceTranslation = function (newText) {

	newText = pageScreen.sanitize(newText);
	
	pageScreen.sentenceTranslation.innerHTML = newText;


}


// lazy method to just remove tags
pageScreen.sanitize = function (text) {
	
	text = text + ""; //force string

	text = text.replace(">", "");
	text = text.replace("<", "");
	
	return text;

}

pageScreen.scoreHistoryChart = new Chart(document.getElementById('typingHistory'),
{
	"type":"line","data":
	{
		"labels":
		[],
		"datasets":[{
			"label":" WPM",
			"display":false,
			"data":
				[],
				"fill":false,
				"borderColor":"#007bff",
				"lineTension":0.0
			}
		]
	},"options":{


	    legend: {
	        display: false
	    },
        scales: {
            xAxes: [{
                ticks: {
                    display: false,
                },
            }]
        },
	    layout: {
	        padding: 10
	      }

	}
});

pageScreen.amountOfTests = document.getElementById("testCount");
pageScreen.averageWPM = document.getElementById("averageWPM");

pageScreen.setAverageWPM = function(amount) {
	
	amount = amount.toFixed(2);
	
	pageScreen.averageWPM.innerHTML = pageScreen.sanitize(amount);
	
}


pageScreen.changeFontBy = function(amount) {
	
	let sum = pageScreen.gameFontSize + amount;
	
	if(sum <= pageScreen.MAX_FONT_SIZE && sum > 0) {
		
		pageScreen.gameFontSize = sum;
		
		pageScreen.updateGameText(pageScreen.gameController.getGameHTML());
		
	}
	
}

pageScreen.setTestCount = function(newAmount) {
	
	pageScreen.amountOfTests.innerHTML = pageScreen.sanitize(newAmount);
	
}


pageScreen.addScoreToChart = function (testTitle, score) {
	
	pageScreen.scoreHistoryChart.data.labels.push(testTitle);
	pageScreen.scoreHistoryChart.data.datasets[0].data.push(score);
	pageScreen.scoreHistoryChart.update();
	
}


