
function GameContentData(words, wordTranslations, sentenceTranslations, grammar) {

	this.words = words;
	this.wordTranslations = wordTranslations;
	this.sentenceTranslations = sentenceTranslations;
	this.grammar = grammar;
	
	this.getWordsInTest = function() {
		
		return this.words;
		
	}
	
	this.getWordTranslationsInTest = function() {
		
		return this.wordTranslations;
		
	}
	
	this.getSentenceTranslationsInTest = function() {
		
		return this.sentenceTranslations;
		
	}
	
	this.getGrammarExplanationsInTest = function() {
		
		return this.grammar;
		
	}
	
	return this;
	
}
