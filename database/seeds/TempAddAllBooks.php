<?php

use Illuminate\Database\Seeder;

class TempAddAllBooks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language =  \App\Language::where('abbreviation', '=', 'af')->first();
        
        if(!\App\Book::createBook('Boesman-Stories', 'G. R. von Wielligh', $language->id, 'books/import/' . $language->language . '/Boesman-Stories, G. R. von Wielligh.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'ca')->first();
        
        if(!\App\Book::createBook("L'Abrandament", 'Carles Soldevila', $language->id, "books/import/" . $language->language . "/L'Abrandament - Carles Soldevila.txt")) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'da')->first();
        
        if(!\App\Book::createBook('Kaptajnen paa 15 Aar (I Slavelænker)', 'Jules Verne', $language->id, 'books/import/' . $language->language . '/Kaptajnen paa 15 Aar (I Slavelænker) - Jules Verne.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'nl')->first();
        
        if(!\App\Book::createBook('Op Het Onheilspad', 'James Oliver Curwood', $language->id, 'books/import/' . $language->language . '/Op Het Onheilspad - James Oliver Curwood.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'en')->first();
        
        if(!\App\Book::createBook('Tales of Space and Time', 'H. G. Wells', $language->id, 'books/import/' . $language->language . '/Tales of Space and Time - H. G. Wells.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'eo')->first();
        
        if(!\App\Book::createBook('La Majstro kaj Martinelli', 'Jorge Camacho', $language->id, 'books/import/' . $language->language . '/La Majstro kaj Martinelli - Jorge Camacho.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        
        
        $language =  \App\Language::where('abbreviation', '=', 'fi')->first();
        
        if(!\App\Book::createBook('Aina Kertomus 1808 & 1809 Sodasta', 'Jon Olof Åberg', $language->id, 'books/import/' . $language->language . '/Aina Kertomus 1808 & 1809 Sodasta - Jon Olof Åberg.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'fr')->first();
        
        if(!\App\Book::createBook('Germaine', 'Edmon About', $language->id, 'books/import/' . $language->language . '/Germaine - Edmon About.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'de')->first();
        
        if(!\App\Book::createBook('Der Dunkelgraf', 'Ludwig Bechstein', $language->id, 'books/import/' . $language->language . '/Der Dunkelgraf - Ludwig Bechstein.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'el')->first();
        
        if(!\App\Book::createBook('Menexenos', 'Plato', $language->id, 'books/import/' . $language->language . '/Menexenos - Plato.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'hu')->first();
        
        if(!\App\Book::createBook('A Három Galamb', 'Lehel Kádár', $language->id, 'books/import/' . $language->language . '/A Három Galamb - Lehel Kádár.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'it')->first();
        
        if(!\App\Book::createBook('Novelle Lombarde', 'Avancinio Avancini', $language->id, 'books/import/' . $language->language . '/Novelle Lombarde - Avancinio Avancini.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'la')->first();
        
        if(!\App\Book::createBook('Commentarii de Bello Gallico', 'Julius Caesar', $language->id, 'books/import/' . $language->language . '/Commentarii de Bello Gallico - Julius Caesar.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'ru')->first();
        
        if(!\App\Book::createBook('Анна Каренина', 'Lev Tolstoy', $language->id, 'books/import/' . $language->language . '/Анна Каренина - Lev Tolstoy.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'es')->first();
        
        if(!\App\Book::createBook('La Niña Robada', 'Hendrik Conscience', $language->id, 'books/import/' . $language->language . '/La Niña Robada - Hendrik Conscience.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        $language =  \App\Language::where('abbreviation', '=', 'sv')->first();
        
        if(!\App\Book::createBook('Arvid Kurck Och Hans Samtida', 'Voldemar Lindman', $language->id, 'books/import/' . $language->language . '/Arvid Kurck Och Hans Samtida - Voldemar Lindman.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        
    }
}
