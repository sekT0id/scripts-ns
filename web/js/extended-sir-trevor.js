// Sir Trevor options
SirTrevor.setDefaults({
    iconUrl:      '/libs/sir-trevor/sir-trevor-icons.svg',
    blockTypes:   ["Text", "List"]
});

// Init new Sir Trevor editor
var editor = new SirTrevor.Editor({
    el: document.querySelector('#sir-trevor-textArea'),
    defaultType: 'Text'
});
