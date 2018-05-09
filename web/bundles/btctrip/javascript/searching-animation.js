/*!
FRAMEWORK_VERSION:1.1.197
*/
registerNameSpace("Nibbler.SearchingAnimation.js");
Nibbler.SearchingAnimation.js.searchingAnimation = function (a) {
    this.options = $.extend(true, a.jsonInit, a.customOptions)
};
Nibbler.SearchingAnimation.js.searchingAnimation.prototype = {
    init: function init() {
        this.number = 0;
        this.thereAreDescription = true;
        this.setClassElements();
        this.setValuesAndDisplayAll();
        var a = this;
        setTimeout(function () {
                a.fadeLoop()
            }, this.options.delay)
    },
    setClassElements: function () {
        this.elements = {
            iteratedText: {
                container: $(".loader .iterated-text"),
                msg: $(".loader .iterated-text .iterated-text-description") //,
            } 
        }
    },
    setValuesAndDisplayAll: function () {
        if (this.options.iteratedText.length) {
            this.elements.iteratedText.msg.html(this.options.iteratedText[0].msg);
            this.elements.iteratedText.container.show()
        } else {
            this.thereAreDescription = false
        }
    },
    fadeLoop: function () {
        var a = this;
        a.elements.iteratedText.container.delay(a.options.delay).fadeOut( function () {
                        if (a.thereAreDescription) {
                            if (a.number + 1 == a.options.iteratedText.length) {
                                a.number = 0
                            } else {
                                a.number = a.number + 1
                            }
                            a.elements.iteratedText.msg.html(a.options.iteratedText[a.number].msg)
                        }
                        a.elements.iteratedText.container.fadeIn(function () {
                                setTimeout(function () {
                                        a.fadeLoop()
                                    }, a.options.delay)
                            })
                    })
    }
};