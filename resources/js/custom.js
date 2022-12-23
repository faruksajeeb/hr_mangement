(function ($) {

  var ww = (window.innerWidth > 0) ? window.innerWidth : screen.width;

  $( document ).ready(function() {
 // var datepicker = $.fn.datepicker.noConflict();
 //    $.fn.bootstrapDP = datepicker;  
 //    $("'.edatepicker'").bootstrapDP();
  //  $('.edatepicker').datepicker({ format: "dd-mm-yyyy" }).on('changeDate', function(ev){
  //     $(this).datepicker('hide');
  //     var datevalue=$('#emp_dob').val();
  //     if(datevalue){
  //       var dateParts = datevalue.split("-");
  //       var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
  //     // console.log(date);
  //     var final_age=getAge(date);
  //     if(final_age !=0){ 
  //       $("#emp_age").val(final_age);
  //     } 
  //   }
  // });
// $( ".datepicker" ).datepicker({ 
//   dateFormat:"dd-mm-yy",
//   onSelect: function() {
//     var datevalue=$('#emp_dob').val();
//     if(datevalue){
//       var dateParts = datevalue.split("-");
//       var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
//       // console.log(date);
//       var final_age=getAge(date);
//       if(final_age !=0){ 
//         $("#emp_age").val(final_age);
//       } 
//     }
//   }
// });
//var host = window.location.host;
// var base_url = window.location;
// console.log(host+" Url");
var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
  $.ajax({
    type: "POST",
   // url: "./dashboard/getprovisionalemp",
   url: ""+baseUrl+"dashboard/getprovisionalemp",
          dataType: 'json',
            success: function (data) {
            }
        });   
$('.datepicker').datetimepicker({
    viewMode: 'days',
  format: 'd-m-Y',
  showTodayButton:true,
});
// var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
// $.fn.bootstrapDP = datepicker; 
jQuery('.numbersOnly').keyup(function (e) { 
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 37, 39, 38, 40, 36, 35, ]) !== -1 ||
     // Allow: Ctrl+A
     (e.keyCode == 65 && e.ctrlKey === true)  
     ) {
  }else{
   this.value = this.value.replace(/[^0-9\-]/g,'');
 }
});  
jQuery(".phonenumbersOnly").keyup(function(e){
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 37, 39, 38, 40, 36, 35, ]) !== -1 ||
             // Allow: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true)  
             ) {
  }else{
   this.value = this.value.replace(/[^0-9\+\-]/g, '');
 }

});
$('#add_more_file').click(function() {
  $(this).before($("<div/>", {class: 'documentsdiv'}).append(
    $("<input />", {name: 'documents[]', type: 'file', class: 'documents1'}),        
    $("<br/><br/>")
    ));
});
$('body').on('change', '#file', function(){
  if (this.files && this.files[0]) {        
    var reader = new FileReader();
    reader.onload = imageIsLoaded;
    reader.readAsDataURL(this.files[0]);

  }
});
function imageIsLoaded(e) {
  $('#preview').attr('src', e.target.result);
};

$('#upload').click(function(e) {
  var name = $(":file").val();
  if (!name)
  {
    alert("First Image Must Be Selected");
    e.preventDefault();
  }
});

});

})(jQuery);
//menu js start here
(function ($) {

var ww = (window.innerWidth > 0) ? window.innerWidth : screen.width;

$(document).ready(function() {
  ww = (window.innerWidth > 0) ? window.innerWidth : screen.width;
  $(".nav li a").each(function() {
    if ($(this).next().length > 0) {
      $(this).addClass("parent");
    };
  })
  
  $(".toggleMenu").click(function(e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(".nav").toggle();
  });
  adjustMenu();
})

$(window).bind('resize orientationchange', function() {
  ww = (window.innerWidth > 0) ? window.innerWidth : screen.width;
  adjustMenu();
});

var adjustMenu = function() {
  if (ww < 768) {
    $(".toggleMenu").css("display", "inline-block");
    if (!$(".toggleMenu").hasClass("active")) {
      $(".nav").hide();
    } else {
      $(".nav").show();
    }
    $(".nav li").unbind('mouseenter mouseleave');
    $(".nav li a.parent").unbind('click').bind('click', function(e) {
      // must be attached to anchor element to prevent bubbling
      e.preventDefault();
      $(this).parent("li").toggleClass("hover");
    });
  } 
  else if (ww >= 768) {
    $(".toggleMenu").css("display", "none");
    $(".nav").show();
    $(".nav li").removeClass("hover");
    $(".nav li a").unbind('click');
    $(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
      // must be attached to li so that mouseleave is not triggered when hover over submenu
      $(this).toggleClass('hover');
    });
  }
}
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
  var tabs = $('ul.tabs'),
      tabsContent = $('ul.tabs-content');
  
  tabs.each(function(i) {
    //Get all tabs
    var tab = $(this).find('> li > a');
    tab.click(function(e) {
      
      //Get Location of tab's content
      var contentLocation = $(this).attr('href') + "Tab";
      
      //Let go if not a hashed one
      if(contentLocation.charAt(0)=="#") {
      
        e.preventDefault();
      
        //Make Tab Active
        tab.removeClass('active');
        $(this).addClass('active');
        
        //Show Tab Content
        $(contentLocation).show().siblings().hide();
        
      } 
    });
  }); 

})(jQuery);
// menu js end here
function isNumber(e){
  e = e || window.event;
  var charCode = e.which ? e.which : e.keyCode;
  return /\d/.test(String.fromCharCode(charCode));
}