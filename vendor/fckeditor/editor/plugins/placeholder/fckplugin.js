/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2006 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: fckplugin.js
 * 	Plugin to insert "Placeholders" in the editor.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

// Register the related command.
FCKCommands.RegisterCommand('Placeholder', new FCKDialogCommand('Placeholder', FCKLang.PlaceholderDlgTitle, FCKPlugins.Items['placeholder'].Path + 'fck_placeholder.html', 340, 170));

// Create the "Plaholder" toolbar button.
var oPlaceholderItem = new FCKToolbarButton('Placeholder', FCKLang.PlaceholderBtn);
oPlaceholderItem.IconPath = FCKPlugins.Items['placeholder'].Path + 'placeholder.gif' ;


FCKToolbarItems.RegisterItem('Placeholder', oPlaceholderItem);

// The object used for all Placeholder operations.
var FCKPlaceholders = new Object();
FCKPlaceholders.Unique = false;
// Add a new placeholder at the actual selection.
FCKPlaceholders.Add = function(name) {
    var oSpan = FCK.CreateElement('SPAN');
    this.SetupSpan(oSpan, name);
};

FCKPlaceholders.SetupSpan = function(span, name) {
    span.innerHTML = '{' + name + '}';
    span.className = 'placeholder';

    span._fckplaceholder = name;
    span.contentEditable = false;

    // To avoid it to be resized.
    span.onresizestart = function() {
        FCK.EditorWindow.event.returnValue = false;
        return false;
    };
};

// On Gecko we must do this trick so the user select all the SPAN when clicking on it.
FCKPlaceholders._SetupClickListener = function() {
    FCKPlaceholders._ClickListener = function(e) {
        if (e.target.tagName == 'SPAN' && e.target._fckplaceholder)
            FCKSelection.SelectNode(e.target);
    };

    FCK.EditorDocument.addEventListener('click', FCKPlaceholders._ClickListener, true);
};

// Open the Placeholder dialog on double click.
FCKPlaceholders.OnDoubleClick = function(span) {
    if (span.tagName == 'SPAN' && span._fckplaceholder)
        FCKCommands.GetCommand('Placeholder').Execute();
};

FCK.RegisterDoubleClickHandler(FCKPlaceholders.OnDoubleClick, 'SPAN');

// Check if a Placholder name is already in use.
FCKPlaceholders.Exist = function(name) {
    if (FCKPlaceholders.Unique) {
        var aSpans = FCK.EditorDocument.getElementsByTagName('SPAN');
        for (var i = 0; i < aSpans.length; i++) {
            if (aSpans[i]._fckplaceholder == name) {
                return true;
            }
        }
    }
    return false;
};


FCKPlaceholders.CleanupPaste = function() {
    if (FCK.EditorDocument) {
        var aSpans = FCK.EditorDocument.getElementsByTagName('SPAN'), span = null, sName = null;
        for (var i = 0, l = aSpans.length; i < l; i++) {
            span = aSpans[i];
            if (span.style.backgroundColor == 'rgb(255, 255, 0)') {
                span.removeAttribute('style');
            }
            matches = span.innerHTML.match(/\{\s*([^\}]*?)\s*\}/);
            if (matches) {
                sName = matches[1];
                if (span.className == 'placeholder' && !span._fckplaceholder) {
                    if (sName) {
                        FCKPlaceholders.SetupSpan(span,sName)
                    } else {
                        span.parentNode.removeChild(span);
                    }
                }
            }
        }
    }
    return true;
};






if (FCKBrowserInfo.IsIE) {
    FCKPlaceholders.escapeHTML = function(unsafe) {
        return unsafe
            .replace(/&(?!amp;)/g, "&amp;")
            .replace(/<(?!lt;)/g, "&lt;")
            .replace(/>(?!gt;)/g, "&gt;")
            .replace(/"(?!quot;)/g, "&quot;")
            .replace(/'(?!#039;)/g, "&#039;");
    };
    FCKPlaceholders.Redraw = function() {
        var aPlaholders = FCK.EditorDocument.body.innerText.match(/\{[^\{\}]+\}/g);
        if (!aPlaholders)
            return;

        var oRange = FCK.EditorDocument.body.createTextRange();

        for (var i = 0; i < aPlaholders.length; i++) {
            if (oRange.findText(aPlaholders[i])) {
                var sName = aPlaholders[i].match(/\{\s*([^\}]*?)\s*\}/)[1];
                oRange.pasteHTML('<span class="placeholder" contenteditable="false" _fckplaceholder="' + FCKPlaceholders.escapeHTML(sName) + '">' + aPlaholders[i] + '</span>');
            }
        }
    };
} else {
    FCKPlaceholders.Redraw = function() {
        var oInteractor = FCK.EditorDocument.createTreeWalker(FCK.EditorDocument.body, NodeFilter.SHOW_TEXT, FCKPlaceholders._AcceptNode, true);

        var aNodes = new Array();

        while (oNode = oInteractor.nextNode()) {
            aNodes[aNodes.length] = oNode;
        }

        for (var n = 0; n < aNodes.length; n++) {
            var aPieces = aNodes[n].nodeValue.split(/(\{[^\}]+\})/g);

            for (var i = 0; i < aPieces.length; i++) {
                if (aPieces[i].length > 0) {
                    if (aPieces[i].indexOf('{') === 0) {
                        var sName = aPieces[i].match(/\{\s*([^\}]*?)\s*\}/)[1];

                        var oSpan = FCK.EditorDocument.createElement('span');
                        FCKPlaceholders.SetupSpan(oSpan, sName);

                        aNodes[n].parentNode.insertBefore(oSpan, aNodes[n]);
                    } else
                        aNodes[n].parentNode.insertBefore(FCK.EditorDocument.createTextNode(aPieces[i]), aNodes[n]);
                }
            }

            aNodes[n].parentNode.removeChild(aNodes[n]);
        }
        FCKPlaceholders._SetupClickListener();
    };

    FCKPlaceholders._AcceptNode = function(node) {
        if (/\{[^\{\}]+\}/.test(node.nodeValue))
            return NodeFilter.FILTER_ACCEPT;
        else
            return NodeFilter.FILTER_SKIP;
    };


}

FCK.Events.AttachEvent('OnAfterSetHTML', FCKPlaceholders.Redraw);

window.onload = function() {
    window.setInterval(FCKPlaceholders.CleanupPaste,1000);
}


// We must process the SPAN tags to replace then with the real resulting value of the placeholder.
FCKXHtml.TagProcessors['span'] = function(node, htmlNode) {
    if (htmlNode._fckplaceholder)
        node = FCKXHtml.XML.createTextNode('{' + htmlNode._fckplaceholder + '}');
    else
        FCKXHtml._AppendChildNodes(node, htmlNode, false);

    return node;
};

