// placholder function
'use strict';

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

// confirmation message on delete button in members page
$('.confirm').click(function () {
    return confirm('Are You Sure ?');
});

//live create Ads
$('.live-name').keyup(function (){
    $('.live-preview .caption h4').text($(this).val());
});
//live create Ads
$('.live-desc').keyup(function (){
    $('.live-preview .caption p').text($(this).val());
});
//live create Ads
$('.live-price').keyup(function (){
    $('.live-preview .caption .price').text('$ ' + $(this).val());
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


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// #@#@#@#@#@ start of home page @#@#@#@#@#@#@#@#@
// #@#@#@#@#@ start of home page @#@#@#@#@#@#@#@#@
// #@#@#@#@#@ start of home page @#@#@#@#@#@#@#@#@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// icons action in nav bar in home page
// icons action in nav bar in home page
// icons action in nav bar in home page
// get all buttons and dropdown section

let categoriesBtn = $(".homeNav .third #categories");
let categoriesDrop = $(".homeNav #categories-drop");

let brandsBtn = $(".homeNav .third #brands");
let brandsDrop = $(".homeNav #brands-drop");

let pagesBtn = $(".homeNav .third #pages");
let pagesDrop = $(".homeNav #pages-drop");
// make a function for friend request button
categoriesBtn.click(function () {
    brandsDrop.css("display","none");
    pagesDrop.css("display","none");
    categoriesDrop.toggle("showdrop");
});
// make a function for message button 
brandsBtn.click(function () {
    categoriesDrop.css("display","none");
    pagesDrop.css("display","none");
    brandsDrop.fadeToggle("showdrop");
});
// make a function for notification button 
pagesBtn.click(function () {
    brandsDrop.css("display","none");
    categoriesDrop.css("display","none");
    pagesDrop.fadeToggle("showdrop");
});
//!@$#@$%#@%#$%^$#^%$^&%$&%^*&%^$^#$%#@%@
//!@$#@$%#@%#$%^$#^%$^&%$&%^*&%^$^#$%#@%@
// end of icons action in nav bar in home page
// end of icons action in nav bar in home page
// end of icons action in nav bar in home page
//!@$#@$%#@%#$%^$#^%$^&%$&%^*&%^$^#$%#@%@
//!@$#@$%#@%#$%^$#^%$^&%$&%^*&%^$^#$%#@%@

