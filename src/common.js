window.sortItem = [
    'Sort By',
    'Top Downloads',
    'Newest'
];

window.genre = [
    'Hip hop',
    'K-pop',
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
    return (lang === 'ko' ? '/ko' : '') + url;
}
