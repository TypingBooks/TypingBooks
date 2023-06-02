function BookMetaData(id, title, author, part, chapter, paragraph, titleForTestFromServer) {
	
	this.id = id;
	this.title = title;
	this.author = author;
	this.part = part;
	this.chapter = chapter;
	this.paragraph = paragraph;
	this.titleForTestFromServer = titleForTestFromServer;
	
	// This entire file is pretty pointless now. The only title
	// used is the title grabbed from the server. The chapter, paragraph, part
	// are not used at all on the server side. They will probably be removed in the future.
	
	this.getID = function() {
		
		return this.id;
		
	}
	
	this.getFullTitle = function() {
		
		//return this.title + " Pt. " + this.part + " Ch. " + this.chapter + " #" + paragraph;
		return this.titleForTestFromServer
		
	}
	
	this.getTitle = function() {
		
		return this.title;
		
	}
	
	this.getAuthor = function() {
		
		return this.author;
		
	}
	
	this.getPart = function() { 
		
		return this.part;
		
	}
	
	this.getChapter = function() {
		
		return this.chapter;
		
	}
	
	this.getParagraph = function() {
		
		return this.paragraph;
		
	}
	
	BookMetaData.buildAPIPath = function (bookID, testNumber) {
		
		return "/" + bookID + "/" + testNumber;
		
	}
	
	return this;
	
}