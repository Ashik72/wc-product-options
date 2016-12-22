jQuery(document).ready(function($) {

var post_id = upload_img_data.post_id;

function get_and_add_to_list() {

  $("#add_to_the_list").click(function(e) {

    e.preventDefault();

    var the_img = $(".thumbnail.tf-image-preview > img").attr('src');

    if (typeof the_img === 'undefined')
      return;

    var the_area = $("select[name='wc-product-options_select_printing_area'] option:selected").text();

    if (typeof the_area === 'undefined')
      return;

    var the_title = $("#wc-product-options_img_title").val();

    if (typeof the_title === 'undefined')
      the_title = "";

    if ($(".section_row_"+the_area+" .row:last-child div.col-sm-4").length >= 3)
      $(".section_row_"+the_area).append("<div class='row'></div>");

      var col_data = '<div class="col-sm-4"><div>';
      col_data += '<img height="140" width="100" src="'+the_img+'" />';
      col_data += '<span><a href="#" class="delete_this_img">X</a></span>';
      col_data += '</div><br><div>';
      col_data += '<input type="hidden" name="'+the_area+'_'+post_id+'_area_src[]" value="'+the_img+'">';
      //col_data += '<br><br>';
      col_data += '<input type="text" name="'+the_area+'_'+post_id+'_area_title[]" value="'+the_title+'"><br><br></div></div>';

      $(".section_row_"+the_area+" .row:last-child").append(col_data);


      $(".thumbnail.tf-image-preview").empty();
      $("#wc-product-options_img_title").val("");
      

  })

}

get_and_add_to_list();


function delete_selected_img() {


  $(document).on('click', 'a.delete_this_img', function(e){

    e.preventDefault();

    console.log($(this).parent().parent().parent().remove());

  })

}

delete_selected_img();


})
