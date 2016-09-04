// Блок подсказки для Sir Trevor
SirTrevor.Blocks.Help = (function() {
    return SirTrevor.Block.extend({

        type: "help",

        title: function() {
            return 'Help';
        },

        editorHTML: function() {
            return '<h4>Подсказка</h4><div class="st-text-block" contenteditable="true"></div>';
        },

        icon_name: 'embed',

        className: 'st-block st-block-help',

        textable: false,

        loadData: function(data){
            this.setTextBlockHTML(data.text);
        },
    });
})();

// Sir Trevor options
SirTrevor.setDefaults({
    iconUrl:      '/libs/sir-trevor/sir-trevor-icons.svg',
    blockTypes:   ["Text", "List", "Help"]
});

// Init new Sir Trevor editor
var editor = new SirTrevor.Editor({
    el: document.querySelector('#sir-trevor-textArea'),
    defaultType: 'Text',
});
