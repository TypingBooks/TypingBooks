
var TextTools = [];

TextTools.punctuationMap = [];

TextTools.loadPunctuationMap = function(punctuationArray) {
	
	for(i = 0; i < punctuationArray.length; i++) {
	
		TextTools.punctuationMap[punctuationArray[i]] = true;
		
	}
	
} 

TextTools.isPunctuation = function (word) {
	
	/*
	//33 - 47 are kind of punctuation
	//40 - "(", 41 - ")", 45 - "-" 
	let charCode = word.charCodeAt(0);
	
	if(charCode >= 33 && charCode <= 47) {
	
		if(charCode != 45) {
		
			return true;
		
		}
	
	}*/
	
	/*
	
	if(word.charAt(0) == '?' || word.charAt(0) == '.' || word.charAt(0) == '!')
		return true;
	
	*/
	
	if(TextTools.punctuationMap[word] != null && TextTools.punctuationMap[word] == true) {
		
		return true;
		
	}
	
	
	return false;

}

TextTools.getSentenceCount = function (words) {
	
	
	let count = 0;
	
	for(i = 0; i < words.length; i++) {
	
		if(TextTools.wordContainsPunctuation(words[i])) {
	 
			count++;
		
		// Not every paragraph ends with punctuation.
		} else if(i == words.length - 1) {
			
			count++;
			
		}
	
	}
	
	return count;

}

TextTools.wordContainsPunctuation = function (word) {

	let i = word.length - 1;
	
	for(i; i >= 0; i--) {
	
		if(TextTools.isPunctuation(word.charAt(i))) {
		
			return true;
		
		}
	
	}
	
	return false;

}

