// placholder function
'use strict';

// Dashboard
$(".toggle-info").click(function () {
    $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(300);

    if ($(this).hasClass('selected')) {
        $(this).html('<i class="fa fa-plus fa-lg"></i>');
    }else{
        $(this).html('<i class="fa fa-minus fa-lg"></i>');
    }
});

// trigger the SelectBoxIt
$('select').selectBoxIt({
    autoWidth: false,
    theme : "bootstrap"
});

// add count to plugin
$(".timer").countTo();

//hide placeholder on form focus
$('[placeholder]').focus(function () {
    $(this).attr('data-text' , $(this).attr('placeholder'));
    $(this).attr('placeholder' , '');
}).blur(function () {
    $(this).attr('placeholder' , $(this).attr('data-text'));
});

//  Add Asterisk on required field
$('input').each(function () {
    if ($(this).attr('required') == 'required') {
        $(this).after('<span class="asterisk">*</span>');
    }
});

// convert password Field to text field on hover
var passField = $('.password');
$('.show-password').hover(function () {
    passField.attr('type' , 'text');
} , function () {
    passField.attr('type' , 'password');
});

// confirmation message on delete button in members page
$('.confirm').click(function () {
    return confirm('Are You Sure ?');
});

// category view option
$('.cat h3').click(function () {
    $(this).next('.full-view').fadeToggle(100);
});

$('.option span').click(function () {
    $(this).addClass('active').siblings('span').removeClass('active')

    if ($(this).data('view') === 'full') {
        $('.cat .full-view').fadeIn(100);
    }else{
        $('.cat .full-view').fadeOut(100);
    }
});

// show Delete Button for shild categories
$('.child-link').hover(function () {
    $(this).find('.show-delete').fadeIn(100);
} , function () {
    $(this).find('.show-delete').fadeOut(100);
});
// tabs section
// tabs section
//get btns , about , content
const btns = document.querySelectorAll(".btnTab");
const btnsDiv = document.querySelector(".btns");
const items = document.querySelectorAll(".itemTabs");
//addEvent on btns to get the id of any btn
btnsDiv.addEventListener('click', (e) => {
    //get the mark
    const mark = e.target.dataset.mark;
    //console.log(mark);
    if (mark) { //check if there's an id
        btns.forEach((btn) => {
            //remove all activeBtn classes
            btn.classList.remove("activeBtn");
            //add activeBtn only in target element
            e.target.classList.add("activeBtn");
        });
        //remove all classes active in(item) to hide all then add active on current
        items.forEach(function (item) {
            //remove all active classes
            item.classList.remove("activeItem");
            //get the id from items
            const element = document.getElementById(mark);
            //add class activeItem to show the target element
            element.classList.add("activeItem");
        });
    }
});
// end tabs section
// end tabs section
