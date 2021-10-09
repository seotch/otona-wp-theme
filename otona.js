jQuery(function($){

$(".mwform-checkbox-field input[type='checkbox']").change(function()
    {
      // console.log("changed!");
      var label = $(this).parent();
      // console.log(label);
      if ($(this).is(":checked")) {
          // console.log("checked!");
          label.addClass('checked');
      } else {
          // console.log("unchecked!");
          label.removeClass('checked');
      }
    }
)
});
