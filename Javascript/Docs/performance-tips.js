Cache length during loops.

Cache selections

Use document fragments to add elements on a page

Keep DRY. If you have to copy paste something, then you are doing it wrong

Use object literals to organize code. We use the backbone.js for this

$(document.body) is a lot faster than $("body")

For jQuery selectors, use ids, or tag and class $("#fire"), $("span.hidden")

Use detach to apply heavy manipulation on an element and then append it again.

If we want to apply a style on over 50 elements, we should add a new srtyle tag with the selector inside instead of $("..").css(...), do this $("<style type'text/css'> a {color: BASA55;} </style>")

Dont act on absent elements

//regular
$(element).data(key, value);
// 10x faster
$.data(element, key, value);