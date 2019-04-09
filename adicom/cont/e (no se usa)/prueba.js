<h1>jQuery Autocomplete</h1>
<p>Hint: try tying "caf" or "jam".</p>
<input type="text" name="restaurant" id="autocomplete" placeholder="Type a restaurant here"/>
<p id="autocomplete-suggestion"></p>




<br />
<br />
<hr />

$('#autocomplete').autocomplete({
    minLength: 3, 
 		source: aRestaurants, 

    response: function(event, ui) {
      if(ui.content.length == 0) {
        $('#autocomplete-suggestion').html('No matches found.');
      }
      else {
        //console.log(ui.content);
        $.each(ui.content, function( key, value ) {
          var logoKey = value.label.replace(/\s+/g,'_')
                                   .replace(/[^\w]/gi, '')
                                   .toLowerCase()

          if ( logos[logoKey] ) value.icon = logos[logoKey];
        });
      }
    },
    select: function(event, ui) {
        event.preventDefault();
        $(event.target).val(ui.item.label);
        $('#autocomplete-suggestion').html( 'You selected: ' + ui.item.label);
    },
    focus: function(event, ui) {
      event.preventDefault();
      $(event.target).val(ui.item.label);
      $('#autocomplete-suggestion').html('');
    }
}).on('keyup', function(event) {
  $('#selection-ajax').html(''); 
    }).data('ui-autocomplete')._renderItem = function( ul, item ) {
  //thanks to Salman Arshad for icon and match highlighting code
  //http://salman-w.blogspot.ca/2013/12/jquery-ui-autocomplete-examples.html
  var $div = $("<div></div>");
  if (item.icon) { 
    $("<img class='m-icon'>").attr("src", item.icon).appendTo($div); 
  } else { 
    $("<span class='x-icon'>no img</span>").appendTo($div); 
  } 
  var mName       = $("<span class='m-name'></span>").text(item.label).appendTo($div),
      searchText  = $.trim(this.term).toLowerCase(), 
      currentNode = mName.get(0).firstChild, 
      matchIndex, newTextNode, newSpanNode; 
  while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) { 
    newTextNode = currentNode.splitText(matchIndex); 
    currentNode = newTextNode.splitText(searchText.length); 
    newSpanNode = document.createElement("span"); 
    newSpanNode.className = "highlight"; 
    currentNode.parentNode.insertBefore(newSpanNode, currentNode); 
    newSpanNode.appendChild(newTextNode); 
  } 
  
  return $("<li></li>").append($div).appendTo(ul); 
};