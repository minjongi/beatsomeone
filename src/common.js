window.sortItem = [
    'Sort By',
    'Top Downloads',
    'Newest'
];

window.genre = [
    'BGMSOUND',
    'Free',
    'K-pop',
    'Hip hop',
    'Pop',
    'R&B',
    'Dance',
    'Rock',
    'Electronic',
    'Jazz',
    'Acoustic',
    'Indie',
    'Reggae',
    'World',
];

window.moods = [
    'Angry',
    'Annoyed',
    'Anxious',
    'Bouncy',
    'Calm',
    'Chill',
    'Confident',
    'Crazy',
    'Dark',
    'Depressed',
    'Dirty',
    'Dope',
    'Energetic',
    'Enraged',
    'Evil',
    'Giddy',
    'Gloomy',
    'Groovy',
    'Happy',
    'Hyper',
    'Kitsch',
    'Lazy',
    'Lo-fi',
    'Lonely',
    'Loved',
    'Majestic',
    'Mellow',
    'Peaceful',
    'Rebellious',
    'Relaxed',
    'Sad',
    'Sensual',
    'Scared',
    'Soulful',
];

window.trackType = [
    'Beats',
    'Beats with chorus',
    'Vocals',
    'Song reference',
    'Songs'
];

window.genLangCode = function(val) {
    return val.replace(/ /g,"").replace(/-/g,"").replace(/&/g,"");
}

window.langUrl = function(lang, url) {
    return '/' + lang + url;
}

window.mobon_convType = ''
window.mobon_productName = ''
window.mobonConversion = function(convType, productName) {
    window.mobon_convType = convType
    window.mobon_productName = productName
    let myScript = document.createElement('script');
    myScript.setAttribute('src', '/src/mobon_conversion.js');
    document.body.appendChild(myScript);
}
