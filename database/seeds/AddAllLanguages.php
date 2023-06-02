<?php

use App\Language;
use Illuminate\Database\Seeder;

class AddAllLanguages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::lazyCreate('Afrikaans', 'af', 'img/flag/af.png');
        Language::lazyCreate('Albanian', 'sq', 'img/flag/sq.png');
        Language::lazyCreate('Amharic', 'am', 'img/flag/am.png');
        Language::lazyCreate('Arabic', 'ar', 'img/flag/ar.png');
        Language::lazyCreate('Armenian', 'hy', 'img/flag/hy.png');
        Language::lazyCreate('Azerbaijani', 'az', 'img/flag/az.png');
        Language::lazyCreate('Basque', 'eu', 'img/flag/eu.png');
        Language::lazyCreate('Belarusian', 'be', 'img/flag/be.png');
        Language::lazyCreate('Bengali', 'bn', 'img/flag/bn.png');
        Language::lazyCreate('Bosnian', 'bs', 'img/flag/bs.png');
        Language::lazyCreate('Bulgarian', 'bg', 'img/flag/bg.png');
        Language::lazyCreate('Catalan', 'ca', 'img/flag/ca.png');
        Language::lazyCreate('Cebuano', 'ceb', 'img/flag/ceb.png');
        Language::lazyCreate('Chichewa', 'ny', 'img/flag/ny.png');
        Language::lazyCreate('Chinese (Simplified)', 'zh-CN', 'img/flag/zh-CN.png');
        Language::lazyCreate('Chinese (Traditional)', 'zh-TW', 'img/flag/zh-TW.png');
        Language::lazyCreate('Corsican', 'co', 'img/flag/co.png');
        Language::lazyCreate('Croatian', 'hr', 'img/flag/hr.png');
        Language::lazyCreate('Czech', 'cs', 'img/flag/cs.png');
        Language::lazyCreate('Danish', 'da', 'img/flag/da.png');
        Language::lazyCreate('Dutch', 'nl', 'img/flag/nl.png');
        
        $temp = Language::where('abbreviation', '=', 'en')->first();
        
        if(!isset($temp)) {
            
            Language::lazyCreate('English', 'en', 'img/flag/en.png');
            
        }
        
        
        Language::lazyCreate('Esperanto', 'eo', 'img/flag/eo.png');
        Language::lazyCreate('Estonian', 'et', 'img/flag/et.png');
        Language::lazyCreate('Filipino', 'tl', 'img/flag/tl.png');
        Language::lazyCreate('Finnish', 'fi', 'img/flag/fi.png');
        Language::lazyCreate('French', 'fr', 'img/flag/fr.png');
        Language::lazyCreate('Frisian', 'fy', 'img/flag/fy.png');
        Language::lazyCreate('Galician', 'gl', 'img/flag/gl.png');
        Language::lazyCreate('Georgian', 'ka', 'img/flag/ka.png');
        Language::lazyCreate('German', 'de', 'img/flag/de.png');
        Language::lazyCreate('Greek', 'el', 'img/flag/el.png');
        Language::lazyCreate('Gujarati', 'gu', 'img/flag/gu.png');
        Language::lazyCreate('Haitian Creole', 'ht', 'img/flag/ht.png');
        Language::lazyCreate('Hausa', 'ha', 'img/flag/ha.png');
        Language::lazyCreate('Hawaiian', 'haw', 'img/flag/haw.png');
        Language::lazyCreate('Hebrew', 'iw', 'img/flag/iw.png');
        Language::lazyCreate('Hindi', 'hi', 'img/flag/hi.png');
        Language::lazyCreate('Hmong', 'hmn', 'img/flag/hmn.jpg');
        Language::lazyCreate('Hungarian', 'hu', 'img/flag/hu.png');
        Language::lazyCreate('Icelandic', 'is', 'img/flag/is.png');
        Language::lazyCreate('Igbo', 'ig', 'img/flag/ig.png');
        Language::lazyCreate('Indonesian', 'id', 'img/flag/id.png');
        Language::lazyCreate('Irish', 'ga', 'img/flag/ga.png');
        Language::lazyCreate('Italian', 'it', 'img/flag/it.png');
        Language::lazyCreate('Japanese', 'ja', 'img/flag/ja.png');
        Language::lazyCreate('Javanese', 'jw', 'img/flag/jw.png');
        Language::lazyCreate('Kannada', 'kn', 'img/flag/kn.png');
        Language::lazyCreate('Kazakh', 'kk', 'img/flag/kk.png');
        Language::lazyCreate('Khmer', 'km', 'img/flag/km.png');
        Language::lazyCreate('Kinyarwanda', 'rw', 'img/flag/rw.png');
        Language::lazyCreate('Korean', 'ko', 'img/flag/ko.png');
        Language::lazyCreate('Kurdish (Kurmanji)', 'ku', 'img/flag/ku.png');
        Language::lazyCreate('Kyrgyz', 'ky', 'img/flag/ky.png');
        Language::lazyCreate('Lao', 'lo', 'img/flag/lo.png');
        Language::lazyCreate('Latin', 'la', 'img/flag/la.png');
        Language::lazyCreate('Latvian', 'lv', 'img/flag/lv.png');
        Language::lazyCreate('Lithuanian', 'lt', 'img/flag/lt.png');
        Language::lazyCreate('Luxembourgish', 'lb', 'img/flag/lb.png');
        Language::lazyCreate('Macedonian', 'mk', 'img/flag/mk.png');
        Language::lazyCreate('Malagasy', 'mg', 'img/flag/mg.png');
        Language::lazyCreate('Malay', 'ms', 'img/flag/ms.png');
        Language::lazyCreate('Malayalam', 'ml', 'img/flag/ml.png');
        Language::lazyCreate('Maltese', 'mt', 'img/flag/mt.png');
        Language::lazyCreate('Maori', 'mi', 'img/flag/mi.png');
        Language::lazyCreate('Marathi', 'mr', 'img/flag/mr.png');
        Language::lazyCreate('Mongolian', 'mn', 'img/flag/mn.png');
        Language::lazyCreate('Myanmar (Burmese)', 'my', 'img/flag/my.png');
        Language::lazyCreate('Nepali', 'ne', 'img/flag/ne.png');
        Language::lazyCreate('Norwegian', 'no', 'img/flag/no.png');
        Language::lazyCreate('Odia (Oriya)', 'or', 'img/flag/or.png');
        Language::lazyCreate('Pashto', 'ps', 'img/flag/ps.png');
        Language::lazyCreate('Persian', 'fa', 'img/flag/fa.png');
        Language::lazyCreate('Polish', 'pl', 'img/flag/pl.png');
        Language::lazyCreate('Portuguese', 'pt', 'img/flag/pt.png');
        Language::lazyCreate('Punjabi', 'pa', 'img/flag/pa.png');
        Language::lazyCreate('Romanian', 'ro', 'img/flag/ro.png');
        
        $temp = Language::where('abbreviation', '=', 'ru')->first();
        
        if(!isset($temp)) {
        
            Language::lazyCreate('Russian', 'ru', 'img/flag/ru.png');
        
        }
        
        Language::lazyCreate('Samoan', 'sm', 'img/flag/sm.png');
        Language::lazyCreate('Scots Gaelic', 'gd', 'img/flag/gd.png');
        Language::lazyCreate('Serbian', 'sr', 'img/flag/sr.png');
        Language::lazyCreate('Sesotho', 'st', 'img/flag/st.png');
        Language::lazyCreate('Shona', 'sn', 'img/flag/sn.png');
        Language::lazyCreate('Sindhi', 'sd', 'img/flag/sd.png');
        Language::lazyCreate('Sinhala', 'si', 'img/flag/si.png');
        Language::lazyCreate('Slovak', 'sk', 'img/flag/sk.png');
        Language::lazyCreate('Slovenian', 'sl', 'img/flag/sl.png');
        Language::lazyCreate('Somali', 'so', 'img/flag/so.png');
        Language::lazyCreate('Spanish', 'es', 'img/flag/es.png');
        Language::lazyCreate('Sundanese', 'su', 'img/flag/su.png');
        Language::lazyCreate('Swahili', 'sw', 'img/flag/sw.png');
        Language::lazyCreate('Swedish', 'sv', 'img/flag/sv.png');
        Language::lazyCreate('Tajik', 'tg', 'img/flag/tg.png');
        Language::lazyCreate('Tamil', 'ta', 'img/flag/ta.png');
        Language::lazyCreate('Tatar', 'tt', 'img/flag/tt.png');
        Language::lazyCreate('Telugu', 'te', 'img/flag/te.png');
        Language::lazyCreate('Thai', 'th', 'img/flag/th.png');
        Language::lazyCreate('Turkish', 'tr', 'img/flag/tr.png');
        Language::lazyCreate('Turkmen', 'tk', 'img/flag/tk.png');
        Language::lazyCreate('Ukrainian', 'uk', 'img/flag/uk.png');
        Language::lazyCreate('Urdu', 'ur', 'img/flag/ur.png');
        Language::lazyCreate('Uyghur', 'ug', 'img/flag/ug.png');
        Language::lazyCreate('Uzbek', 'uz', 'img/flag/uz.png');
        Language::lazyCreate('Vietnamese', 'vi', 'img/flag/vi.png');
        Language::lazyCreate('Welsh', 'cy', 'img/flag/cy.png');
        Language::lazyCreate('Xhosa', 'xh', 'img/flag/xh.png');
        Language::lazyCreate('Yiddish', 'yi', 'img/flag/yi.png');
        Language::lazyCreate('Yoruba', 'yo', 'img/flag/yo.png');
        Language::lazyCreate('Zulu', 'zu', 'img/flag/zu.png');
        
        $languages = \App\Language::get();
        
        foreach($languages as $native) {
            
            foreach($languages as $learning) {
                
                $landing = new \App\LearningLanding();
                
                $landing->title = $learning->language;
                $landing->native_lang = $native->id;
                $landing->learning_lang = $learning->id;
                
                $landing->save();
                
                $dictionary = new \App\Dictionary();
                
                $dictionary->from_language = $native->id;
                $dictionary->to_language = $learning->id;
                $dictionary->landing = $landing->id;
                
                $dictionary->save();
                
            }
            
        }
        
    }
}
