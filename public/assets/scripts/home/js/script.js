$('.p-finder').click(function () {
    $('#p-content').toggle();
});

/*$('.more-drop').hover(function () {
    $('#more-content').toggle();
});*/


$('.compare-drop').click(function () {
    $('#compare-content').show();
});

$('.cpr-close').click(function () {
    $('#compare-content').hide();
});

$('.search-drop1').click(function () {
    $('#search-content').toggle();
});

$('.search-drop2').click(function () {
    $('#search-content2').toggle();
});


$('.search-drop3').click(function () {
    $('#search-content3').toggle();
});
$('.feature1').click(function () {
    $('#feature-content1').toggle();
});

// ACCORDION-TABLE
$('.tbl-accordion-nested').each(function(){
  var thead = $(this).find('thead');
  var tbody = $(this).find('tbody');
  
  tbody.hide();
  thead.click(function(){
    tbody. slideToggle();
  })
});


/*$('#compareTable').on('shown.bs.collapse', function () {
    $("#test i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test1 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test1 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test2 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test2 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test3 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test4 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test4 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test5 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test5 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test6 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test6 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test7 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test2 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('shown.bs.collapse', function () {
    $("#test2 i.fa").removeClass("fa fa-plus-circle").addClass("fa fa-minus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test8 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});
$('#compareTable').on('hidden.bs.collapse', function () {
    $("#test8 i.fa").removeClass("fa fa-minus-circle").addClass("fa fa-plus-circle");
});*/



// Instantiate the Bootstrap carousel
$('.multi-item-carousel').carousel({
    interval: false
});

// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
$('.multi-item-carousel .item').each(function () {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    if (next.next().length > 0) {
        next.next().children(':first-child').clone().appendTo($(this));
    } else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
});
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
            $(this).toggleClass('open');       
        }
    );
});
$(document).ready(function() {
    $('#myCarousel').carousel({
	    interval: 10000
	})
});
$(document).ready(function() {
    $('#myCarousel1').carousel({
	    interval: 10000
	})
});
$(document).ready(function() {
    $('#myCarousel2').carousel({
	    interval: 10000
	})
});
$(document).ready(function() {
    $('#myCarousel3').carousel({
	    interval: 10000
	})
});
$(document).ready(function() {
    $('#myCarousel4').carousel({
	    interval: 10000
	})
});
$(document).ready(function() {
    $('#myCarousel5').carousel({
	    interval: 10000
	})
});