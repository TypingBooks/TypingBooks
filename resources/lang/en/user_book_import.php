<?php 

return [
   
    
    //     @lang('user_book_import.')
    
    
    'state' => 'State',
    
    'website_desc' => 'Parallel typing tests while reading public domain books. Practice typing while learning a new language or reading a book.',
    'books_that_you_have_added' => 'Books that you have added',
    'review_validate' => 'Review/Validate',
    'import_a_book' => 'Import a book',
    
    'choose_file' => 'Select a file',
    
    'book_title' => 'Book Title',
    'author' => 'Author',
    'language' => 'Language',
    'text_file' => 'Text File',
    'only_allow_me_to_use_this_book' => 'Only allow me to use this book',
    
    'help_with_importing_books' => 'Help with importing books',
    'read' => 'Read',
    'this_guide' => 'this guide',
    'to_learn_how_to_format_books_for_import' => 'to learn how to format books for import.',
    
    'all_books' => 'All Books',
    'import' => 'Import',
    
    'you_can_only_import_text_files' => 'You can only import text files.',
    
    'book_information' => 'Book Information',
    'date_added' => 'Date Added',
    'book' => 'Book',
    'title' => 'Title',
    'access' => 'Access',
    
    'detected_index_in_book' => 'Detected Index in Book',
    'no_index_for_this_book_has_been_detected' => 'No index for this book has been detected!',
    
    //     @lang('user_book_import.')
    
    'fix_letters_that_are_not_typeable' => 'Fix letters that are not typeable',
    'detected_character' => 'Detected character',
    'desired_replacement' => 'Desired replacement',
    
    'confirm' => 'Confirm',
    'confirm_text' => 'If everything above looks correct, click "submit" to confirm adding the book to this website. If the title, author, language, index, or privacy settings are incorrect, try adding the book again instead.',
    'submit' => 'Submit',
    
    //     @lang('user_book_import.')
    
    '1' => 'The purpose of this page is to provide resources related to creating and formatting books that can be added to this website. The only sections directly related to formatting are',
    
    '2' => 'Requirements',
    
    '3' => 'Creating Tests',
    '03' => 'and',
    '4' => 'Sectioning',
    '5' => 'Formatting guide',
    '6' => 'Useful Applications and Websites',
    
    '7' => 'Books that are imported must meet the restrictions below',
    
    
    //     @lang('user_book_import.')
    
    
    '8' => 'Books are in plain text and encoded as',
    '9' => 'The filetype for uploaded books is',
    '10' => 'At least one section has been added',
    '11' => 'Extra information about the book has been removed from the text file',
    
    '12' => 'The parser breaks the book into test groups by line in the text file. If a line is less than 1200 letters, it will act as a single test when typing it. If a line is longer than this, it will be broken into multiple tests. If a line is more than 1200 letters, our database will still preserve that a test was meant to be grouped together as consecutive sentences in a paragraph. These groups are made available to users when users download the books using the "data" tab.',
    
    '13' => 'After importing a book, our server will begin addding it to the database. After it is finished,',
    '14' => 'it will not be made live until you confirm the information the parser found for the the book looks correct.',
    
    '15' => 'If there were letters inside the book that were detected as not being possible to type, you will be required to fix these errors before it can be made live. You also do not need to worry about removing extra tabs, spaces, or whitespace in the file.',
    
    '16' => 'Using the instructions below, sections can be created for books. The parser for this website shares the same section format as',
    '17' => 'However, it only uses the format for sections from it.',
    
    //     @lang('user_book_import.')
    
    '18' => 'Each section should begin with',
    '19' => 'followed by the title for the section. So for example, if the chapter was titled',
    '20' => 'you should add a line with',
    
    '21' => 'The parser also supports multiple levels in sections. If a book has multiple parts, chapters, and other types of sections, they can easily be added by using multiple',
    '22' => 'symbols.',
    
    '23' => 'Finding letters that are not typeable',
    
    
    //     @lang('user_book_import.')
    
    
    '24' => 'Test #1 in prologue',
    '25' => 'Test #2 in prologue',
    
    '26' => 'Prologue',
    '27' => 'Part Title',
    
    '28' => 'Chapter Title',
    
    '29' => 'Section #1 Title',
    '30' => 'Test #1 in section',
    '31' => 'Test #2 in section',
    
    
    //     @lang('user_book_import.')
    
    '32' => 'Test #3 in section',
    '33' => 'Section #2 Title',
    
    '34' => 'Test #1 in Section #2',
    '35' => 'After the the book has been imported, if there were any characters that were detected as not possible to type with a keyboard, they will be displayed with the ability to change them.',
    '36' => 'You do not need to worry about removing them before importing the book.',
    '37' => 'Converting eBooks with',
    '38' => 'By following the steps below, you can quickly and easily convert eBooks to the format needed for importing books to this website. You will still need to format this text file after converting the text file following the information on this page.',
    
    //     @lang('user_book_import.')
    
    
    '39' => 'Open the book that you have downloaded with',
    '40' => 'This can be done easily by right clicking on the book after installing',
    '41' => 'and selecting to open with',
    
    '42' => 'After',
    '43' => 'opens, it should show a list a books including the new book that was just added. Find the book you want to convert in the list, right click on it, then select "convert book" followed by "convert individually."',
    '44' => 'A new window should appear that shows information about this book. The top right of this window should allow you to select the "output format" for conversion. Select',
    '45' => 'then press',
    '46' => 'at the bottom of the this window.',
    '47' => 'will then begin converting this book.',
    '48' => 'After it completes, return back to the list of books within',
    '49' => 'Once again, right click on the book, then click',
    '50' => 'This should open the location on your computer for where the files for this book are stored. You should now be able to find the text file',
    '51' => 'created when converting this book.',
    '52' => 'Find the text file at the location that',
    
    //     @lang('user_book_import.')
    
    '53' => 'opened. Once you have located this file, you are free to move it to another location on your computer. You can always generate a new copy of it by completing the process above again. If you plan on importing this book to this website, you will still need to format with the instructions on this page for the index and tests to be displayed properly.',
    '54' => 'A better text editor than the text editor included with',
    '55' => 'It includes tools for searching the contents of large files and using regular expressions to find content within large files.',
  
    
    '56' => 'An alternative text editor that serves the same purpose as',
    '57' => 'is only available on',
    '057' => 'while',
    '58' => 'is on many operating systems.',
    '59' => 'An application made for managing many different types of eBook formats. It will allow you to easily convert books into the text format required for this website.',
    '60' => 'allows you to search combinations/variations of text. It provides a way to search chapter/part numbers that are not consistently created across all books. The editors above support',
    '060' => 'Guide',
    '61' => 'Understanding how to use',
    '62' => 'is not required, but the time spent learning how to use it will quickly outweigh the time spent searching for sections of text yourself.',
    '63' => 'If you are confused about anything with importing books or have concerns about content on this website, our',
    '64' => 'server is a great resource for asking questions.',
    '65' => 'Our',
    '66' => 'Prologue',
    '67' => 'Test #1 in prologue',
    
    //     @lang('user_book_import.')
    
    '68' => 'Test #2 in prologue',
    '69' => 'Part Title',
    '70' => 'Chapter Title',
    '71' => 'Section #1 Title',
    '72' => 'Test #1 in section',
    '73' => 'Test #2 in section',
    '74' => 'Test #3 in section',
    '75' => 'Section #2 Title',
    '76' => 'Test #1 in Section #2',
    '77' => 'A unique',
    '78' => 'that',
    '79' => 'and',
    
    //     @lang('user_book_import.')
    
    '80' => 'reference as their parent.',
    '81' => 'The title for this section.',
    '82' => 'An',
    '83' => 'that references a parent section. If this is',
    '84' => 'then the parent section is the book.',
    '85' => 'The order that this section is found within the book in relation to the section\'s parent.',
    '86' => 'The',
    
    //     @lang('user_book_import.')
    
    '87' => 'of the section that is the parent of this sentence.',
    '88' => 'The order that this sentence appears in this section in relation to other sentences in this section.',
    '89' => 'The test group that contains all sentences and tests related to this sentence. A test group most often acts as a paragraph, so this can also be assumed to be an order for paragraphs in the book.',
    '90' => 'The order of this sentence in relation to other sentences inside of a test group.',
    '91' => 'contains a block of data corresponding to a section in the book. A',
    
    
    //     @lang('user_book_import.')
    
    '92' => 'This book is still being added to our database. Check back in a few minutes to finish adding it.',
    '93' => 'It looks like this book failed to import. If you still want to add this book, try importing it again.',
    'only_you' => 'Only you',
    'everyone' => 'Everyone',
    
    'added_by' => 'Added by',
    
    //       ' .   __('user_book_import.') . '
    
    '94' => 'These are the sections from the index of this book.',
    
    '95' => 'This book is now being imported.',
    '96' => 'There was a problem while importing this book.',
    
    '97' => 'You did not define a replacement for',
    
    '98' => 'Your replacement of',
    '99' => 'is not allowed for',
    '100' => 'You cannot use punctuation in replacements. Please reimport the book instead if this replacement is required.',
    
    '101' => 'Your replacement of',
    '102' => 'is not allowed for',
    '103' => 'If this replacement is required, please reimport the book instead.',
    
    '104' => 'An error occurred, please try submitting this form again.',
    '105' => 'This book cannot be made live. Please import this book again instead.',
    '106' => 'This book is being added to the database.',
    
    '107' => 'Error',
    '108' => 'Importing',
    '109' => 'Needs validation',
    '110' => 'Live',
    '111' => 'Validating',
    
    
    //     @lang('user_book_import.')
];

?>