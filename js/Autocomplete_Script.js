jQuery(document).ready(function() {

  setupFields("select.dep-select");
});

    function fetch_service(ID)  
    {  
        $.ajax({  
            url:"Function_qualification_Functions.php?action=service",  
            method:"POST",  
            dataType:"text",
            data:{ID:ID},              
            success:function(data){  
        $('#Service').html(data); 
          setupFields("select.service-select");
            }  
        });
    }

function setupFields(nameclass) {

  var fields = jQuery(nameclass);

  jQuery("body").append(returnModal());

  fields.each(function() {

    var field = jQuery(this);

    var attributes = {};
    for (var att, i = 0, atts = this.attributes, n = atts.length; i < n; i++) {

      att = atts[i];
      attributes[atts[i].nodeName] = atts[i].nodeValue;
    }
    button = jQuery("<button>", attributes);
    button.addClass("btn");
    button.addClass("btn-primary");
    button.attr("type", "button");
    button.attr("data-toggle", "modal");
    button.attr("data-target", "#selectModal");
    button.insertAfter(this);

    setDisplayedTitle(field);
    field.hide();
  //console.log(field);
  });

  jQuery('#selectModal').on('show.bs.modal', displayModal);
}

function setDisplayedTitle(field) {
  var fieldValue = field.val();
  var fieldName = field.attr("name");

  var button = jQuery("button[name=" + fieldName + "]");

  if (button) {
//console.log("ici");

    var hasCurrentValue = false;

    if (fieldValue) {

      var options = field.find("option");

      options.each(function() {

        var option = jQuery(this);

        var optionValue = option.attr("value");

        var optionTitle = option.html();

        if (optionTitle) {

          if (fieldValue === optionValue) {

            if (optionTitle.trim() !== "" && fieldValue !== null) {

              hasCurrentValue = true;
              button.html(optionTitle);
            }
          }
        }
      });
    }

    if (hasCurrentValue === false) {

      button.html("Click to select");
    }
  }
}

function displayModal(event) {

  var button = jQuery(event.relatedTarget);
  var name = button.attr('name');
  var title = button.data('title');
  jQuery(this).find(".modal-title").html(title);
  var optionsContainer = jQuery(this).find(".modal-body");

  var selectField = jQuery("select[name=" + name + "]");

  var currentValue = selectField.val();

  optionsContainer.empty();

  var options = selectField.find("option");

  options.each(function() {

    var option = jQuery(this);

    var optionValue = option.attr("value");

	var isdep = option.attr("class");

    var isCurrentValue = false;

    if (currentValue === optionValue) {

      isCurrentValue = true;
    }

    var modalButton = returnModalButton(option.html(), option.attr("value"), name, isCurrentValue);

    if (modalButton) {
      optionsContainer.append(modalButton);
    }
  });
}

function returnModalButton(title, value, name, isCurrent) {

  if (title !== null && title.trim() !== "" && title !== "null") {
    var button = jQuery("<button>", {
      'data-value': value,
      'data-dismiss': "modal",
      'data-name': name,
      type: "button"
    });
    button.addClass("btn");
    button.addClass("btn-secondary");

    if (isCurrent === true) {

      title = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + title;
    }

    button.html(title);

    button.on('click', selectedButton);

    return button;
  } else {

    return null;
  }
}

function selectedButton() {

  var button = jQuery(this);

  var name = button.data("name");
  var value = button.data("value");
  var isdep = button.data("class");

  var selectField = jQuery("select[name=" + name + "]");

  selectField.val(value);
  selectField.trigger('change');

  setDisplayedTitle(selectField);
  if(name=="dep-select"){
  
  fetch_service(value);

}
}

function returnModal() {

  var returnModal = '<div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="selectModal">' +
    '  <div class="modal-dialog" role="document">' +
    '    <div class="modal-content">' +
    '      <div class="modal-header">' +
    '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
    '      </div>' +
    '      <div class="modal-body">\n' +
    '        ' +
    '      </div>' +
    '      <div class="modal-footer">' +
    '        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
    '      </div>' +
    '    </div>' +
    '  </div>' +
    '</div>';

  return returnModal;
}
