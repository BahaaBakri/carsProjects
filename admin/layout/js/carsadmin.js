/*global console*/

$(function () {
	// Nice Scroll
	// $("body").niceScroll({cursorborder:"none", cursorwidth: "5px", autohidemode: false});
	$(".left #forScroll").niceScroll(".left #forScroll .pages", {cursorborder:"none", cursorwidth: "8px", autohidemode:true});
	var options = {
		max_value: 5,
		step_size: 1,
		readonly: true,

	}
	$(".popup-child #forScrollComments, .popup-child #forScrollCommentsCat").niceScroll({cursorborder:"none", cursorwidth: "8px", autohidemode:true});
	var options = {
		max_value: 5,
		step_size: 1,
		readonly: true,

	}
	// rating
	$(".rating").rate(options);

	$('[data-toggle="tooltip"]').tooltip({html:true}); // it is very important to trigger tooltips
	$('[data-toggle="popover"]').popover(); // it is very important to trigger popover

	//Triger mixslider
	$("#filterParent").mixItUp();
	// add class selected

	$("#catItems .navbar_works ul li").on("click", function () {
	$(this).addClass("selected").siblings().removeClass("selected");
});

	// hide and show placeholder in admins form
	"use strict";
	var placeholder;
	$('[placeholder]').on('focus', function () {
		placeholder = $(this).attr("placeholder");
		$(this).attr("placeholder", "");
	}).on('blur', function () {
		$(this).attr("placeholder", placeholder);
	});

	// validation in Jquery

	// function show message validate take event and element must show it
	var inp;
	function validate (inp, e) {
		e.preventDefault();
		$(inp).slideDown(400, function () {
			$(inp).delay(3000);
			$(inp).siblings("input, select").on('focus', function () {
				$(inp).slideUp(400);
			})
		});
	}
	function validateFile (inp, e) {
		e.preventDefault();
		$(inp).slideDown(400, function () {
			$(inp).delay(3000);
			$(inp).parent().find(".blahbutton").on('click', function () {
				$(inp).slideUp(400);
			})
		});
	}
	// validation on click button submit in categories.php
	$(".categories input[type='submit']").on("click", function (e) {
		// name is required

		if(($("#name").val().length) == 0) {
			validate('.uservalidate0', e);
		}

		// name more than 3 letters

		if(($("#name").val().length) < 3) {
			validate('.uservalidate1', e);
		}

	});

	// validation on click button submit in items.php
	$(".items input[type='submit']").on("click", function (e) {

		$(".items [required='required']").each(function () {
			if((($(this).val().length) == 0) && ($(this).attr('type') == 'file')) {
				var elem = $(this).parent().siblings(".reqvalidate");
				validateFile(elem, e);
			}
			if(($(this).val().length) == 0) {
				var elem = $(this).siblings(".reqvalidate");
				validate(elem, e);
			}

			if (($(this).val()) == "") {
				var elem = $(this).siblings(".reqselectvalidate");
				validate(elem, e);
			}
		});

		if(($(".items #name").val().length) < 3) {
			validate('.namevalidate', e);
		}
		if(($(".items #description").val().length) < 20) {
			validate('.descvalidate', e);
		}
	});
	// validation on click button submit in items.php predict
	$(".predict input[type='submit']").on("click", function (e) {
		var countFalseElment = 0;
		$(".predict [required='required']").each(function () {
			if(($(this).val().length) == 0) {
				var elem = $(this).siblings(".reqvalidate");
				validate(elem, e);
				countFalseElment++;
			}

			if (($(this).val()) == "") {
				var elem = $(this).siblings(".reqselectvalidate");
				validate(elem, e);
				countFalseElment++;
			}
		});
		if (countFalseElment == 0) {
			e.preventDefault();
			predictPrice();
		}
	});
	// validation on click button submit in comments.php
	$(".comments input[type='submit']").on("click", function (e) {
		// comment is required
		if(($("#comment").val().length) == 0) {
			validate('.comvalidate0', e);
		}

	});
	// validation on click button submit in members.php
	$(".members input[type='submit']").on("click", function (e) {

		// username is required

		if(($("#username").val().length) == 0) {
			validate('.uservalidate0', e);
		}

		// username more than 3 letters

		if(($("#username").val().length) < 3) {
			validate('.uservalidate1', e);
		}

		// email is required

		if(($("input[type='email']").val().length) == 0) {
			validate('.emailvalidate0', e);
		}

		// fullname is required

		if(($("#fullname").val().length) == 0) {
			validate('.fullvalidate0', e);
		}

		// password has (passwordreq) id is required
		if (!$(this).parents().is("#edit")) {
			if(($("#passwordreq").val().length) == 0) {
				validate('.passvalidate0', e);
			}
	}

		// password must has numbers and letters only without spaces

		var newpass = $("input[name='password']").val(),
			wordpass1 = newpass.search(/[.,;''""=_/!@#%^&*+\-?^${}()|[\]\\]/g),
			wordpass2 = newpass.search(" ");
		if ((wordpass1 !== -1) || (wordpass2 !== -1)) {
			validate('.passvalidate1', e);
		}

		// email must has numbers and letters and [@._-] only without spaces
		// email must contains @ . togather

		var email = $("input[type='email']").val(),
			wordemail1a = email.search(/[@]/g),
			wordemail1dot = email.search(/[.]/g),
			wordemail2 = email.search(/[,;''""=/!#%^&*+\?^${}()|[\]\\]/g),
			wordemail2space = email.search(" ");
		if ((wordemail1a === -1) || (wordemail1dot === -1)) {
			validate('.emailvalidate1', e);
		}
		if ((wordemail2 !== -1) || (wordemail2space !== -1)) {
			validate('.emailvalidate2', e);
		}
	});
	// add estrisc * for required filed

	$("[required='required']").each(function () {
			$(this).after("<span class ='astrisc'>*</span>");
		});

	// every password on focuse show show button

	$(".showpass").on("click", function () {
			$(this).removeClass("showen").siblings("a").addClass("showen");
			if ($(this).is(".eye")) {
				$(this).siblings("input[name='password']").attr("type", "text");
			} else {
				$(this).siblings("input[name='password']").attr("type", "password");
			}
	});
	$(window).resize(function () {
		var passwidth = $("input[name='password']").css("width");
		//console.log(passwidth);
	});

	// $('.blah').onerror = onCancelImage()
	// File Reader in item page
	function readURL(input) {
		console.log(input);
		if (input[0].files && input[0].files[0]) {
			//console.log("bbbbbbbbsg");
		  var reader = new FileReader();
		  console.log(reader);
		  reader.onload = function(e) {
			$('.blah').attr('src', e.target.result);
		  }
		  
		  reader.readAsDataURL(input[0].files[0]); // convert to base64 string
		}
	  }
	  function onCancelImage() {
		$('.imageAdd .edit').css('display', 'none');
		$('.imageAdd .add, .imageEdit .edit').css('display', 'inline')
		$('.imageAdd .delete, .imageEdit .delete').css('display', 'none')
		$('.blahAvatar').attr('src', "layout/images/avatar.jpg");
		$('.blahItem').attr('src', "layout/images/preview.jpg");
	  }
	// When change file
	$(".imgInp").on("change click", function(ev){
		if (ev.originalEvent != null){
			console.log("OK clicked");
		}
		document.body.onfocus = function(){
			document.body.onfocus = null;
			setTimeout(function(){
				if ($(".imgInp").val().length === 0) {
					console.log("Cancel clicked");
					onCancelImage();
				}
				else {
					console.log("select")
					$('.imageAdd .add').css('display', 'none');
					$('.imageAdd .edit, .imageEdit .edit').css('display', 'inline')
					$('.imageAdd .delete, .imageEdit .delete').css('display', 'inline')
					// let path = $(".imgInp").val();
					// console.log(path);
					readURL($(".imgInp"));
				}
			}, 1000);
		};
	});
	/*
	$(".imgInp").change(function(e) {
	console.log("szfsef");
	
		console.log("bbbb")
		if($(this).val() == "") {
			$('.imageAdd .edit').css('display', 'none');
			$('.imageAdd .add').css('display', 'inline')
		} else {
			$('.imageAdd .add').css('display', 'none');
			$('.imageAdd .edit').css('display', 'inline')
		}
		readURL(this);
	

	});
	*/

	// When delete image
	$(".imageEdit .delete, .imageAdd .delete").on('click', ()=> {
		onCancelImage();
	})
	// show the model in delete Page

	$('.triggermodal').each(function () {
		$(this).click();
	});

	// counterdown timer
	function counter(i) {
		var set = setInterval(function () {
			i = i - 1;
			$('span.timer').text( i );
		}, 1000);
		if (i === 0) {
			clearInterval(set);
		}

	}
	var ii = $('span.timer').text();
	counter(ii);

	// slide Div

	$(".slide").hover(
		function() {
			$(this).find("span").animate({
				height:$(this).height()
			}, 400);
		}
		, function() {
			$(this).find("span").animate({
				height:0
			}, 400);
	});

	$(".options .show .show-span").on("click", function () {
		$(this).addClass("active").siblings(".show-span").removeClass("active");
		if ($(this).data("show") == "full") {
			$(".card .catdata").each(function () {
				$(this).removeClass("hidden");
			});
		} else {
			$(".card .catdata").each(function () {
				$(this).addClass("hidden");
			});
		}
	});
	// card layout
	$(".card").each(function() {
		if ($(this).hasClass("sold")) {
			$(this).find('.image .overlay p').text("SOLD")
		} else 	if ($(this).hasClass("offered")) {
			$(this).find('.image .overlay p').text("OFFERED")
		} else 	if ($(this).hasClass("pending")) {
			$(this).find('.image .overlay p').text("PENDING")
		}

		$(this).find('.image ').mouseenter(function() {
			// console.log("TTTTT");
			$(this).find('.overlay').show();
		}).mouseleave(function() {
			$(this).find('.overlay').hide();
		});
	})



	function ajaxfunc () {
		var sort = $(this).data('sort');
		$(this).addClass("active").siblings(".sort").removeClass("active");

		$.ajax({
			method: "GET",
			url: "ajaxcats.php?sort=" + sort,
			success: function (restxt, status, xhr) {
				// json to javascriot object
				let restxtobj = JSON.parse(restxt);
				console.log(restxtobj);

				$("#ajaxcats").html("");
				//console.log(restxtobj.length);
				for (var i = 0; i < restxtobj.length; i++) {
					//console.log(i);
					//console.log(restxtobj[i]);

					$("#ajaxcats").append("<div class='card'><div class='card-body'><h3 class='card-title card-title" + i + "'>" + restxtobj[i].name + "</h3><div class='catdata catdata" + i + " hidden '><p class='text-muted card-text'>" + restxtobj[i].description +"</p> <div class='catinfo catinfo" + i + "'></div></div></div><div class='control'> <a href='categories.php?do=edit&catid=" + restxtobj[i].catid + "'class='btn btn-success '>Edit <i class='fa fa-edit'></i></a> <a href='categories.php?do=delete&catid=" + restxtobj[i].catid + "' class='btn btn-danger '>Delete <i class='fa fa-trash'></i></a></div></div>");
					//console.log(restxtobj[i].visiblity);
					//console.log(restxtobj[i].allow_comments);
					//console.log(restxtobj[i].allow_ads);
					/*
					if (restxtobj[i].visiblity == "0") {
						$(".catinfo" + i).append("<p class='mr-2 mybadge badge badge-danger'>hidden</p>");
					}
				 	if (restxtobj[i].allow_comments == "0") {
						$(".catinfo" + i).append("<p class='mr-2 mybadge badge badge-warning'>comments disabled</p>");
					}
				 	if (restxtobj[i].allow_ads == "0") {
						$(".catinfo" + i).append("<p class='mybadge badge badge-secondary'>ads disabled</p>");
					}
					*/

				}
				$(".card .card-title").on("click", function () {
					$(this).toggleClass("clicked");
					$(this).siblings(".catdata").toggleClass("hidden");
				});


				if ($(".options .show .show-span.full").hasClass("active")) {
					$(".card .catdata").each(function () {
						$(this).removeClass("hidden");
					});
				}
				else {
					$(".card .catdata").each(function () {
						$(this).addClass("hidden");
					});
				}
			}
		});
	}
	$(".options .ordering .sort").on("click", ajaxfunc);
	$(".options .ordering .sort.asc").click();


	// dashbord Latest
	$(".latest .slidebutton").on("click", function () {
		$(this).addClass('hidden').siblings('.slidebutton').removeClass("hidden")
		if ($(this).data("class") == "show") {
			console.log("bahaa")
			$(this).parents(".latest").find(".mylist").slideUp(500);
			
		} if ($(this).data("class") == "hide") {
			console.log("jkfvndfkj")
			$(this).parents(".latest").find(".mylist").slideDown(500);
		}
		

	});
	/*
	// item show details
	$(".itemActions .openDetails").on("click", function () {
		$(this).addClass('hidden').siblings('.openDetails').removeClass("hidden")
		if ($(this).data("class") == "hide") {
			console.log("bahaa")
			$(this).parents(".card-body").find(".itemDetails").slideUp(500);
			
		} if ($(this).data("class") == "show") {
			console.log("jkfvndfkj")
			$(this).parents(".card").find(".itemDetails").slideDown(500);
		}
		

	});
	*/

	// pop_up button functionalty
	
	$(".pop-button").on('click', function() {

		var id_but = $(this).attr("id");
		console.log(id_but)
		if ($(this).data('class') == "details") {
			console.log("Details")
			$(".popup-child[data-popup='" + id_but + "'][data-class='details']").parent().fadeIn(1000).end()
			.fadeIn(1000).end();
		} else if ($(this).data('class') == "comments") {
			$(".popup-child[data-popup='" + id_but + "'][data-class='comments']").parent().fadeIn(1000).end()
			.fadeIn(1000).end();
		}


		// close pop_up by click close (method 1)
		
		$(".pop-button-close").on('click', function() {
			$(".price").css("opacity",1);
			$(".popup-child[data-popup='" + id_but + "']").parent().fadeOut(1000).end()
			.fadeOut(1000).end();
		})
		// close pop_up by click Esc or Q (method 2)
		
		$(document).keydown(function(e) {
			if (e.keyCode == 27 || e.keyCode == 81) {
				$(".price").css("opacity",1);
				$(".popup-child[data-popup='" + id_but + "']").parent().fadeOut(1000).end()
					.fadeOut(1000).end();
			}
		});
		
		// close pop_up when click on body (out of pop_up) (method 3)
		
		$(".popup-parent").on('click', function() {
			$(".price").css("opacity",1);
			$(".popup-child[data-popup='" + id_but + "']").parent().fadeOut(1000).end()
					.fadeOut(1000).end();
		});
		$(".popup-child").on('click', function(e) {
			e.stopPropagation();
		});

		// hide price mark

		$(".price").css("opacity", 0.8);
		
	});


	// Search Item, User, Comment

	$('.searchUser').change(function() {
		let value = $(this).val()
		// console.log(value)
		$(this).siblings('a').attr("href", `members.php?search=${value}`)
		console.log($(this).siblings('a').attr("href"))
	})

	let value = ($('input.searchItem').val() == "") ? "all" : $('input.searchItem').val()
	$('input[name="search"]').val(value);

	$('input.searchItem').change(function() {
		console.log($(this).val());
		let value = ($(this).val() == "") ? "all" : $(this).val()
		$('input[name="search"]').val(value);
	});
	$('input.searchItem').siblings('button').click (function() {
		let value = `items.php?action=filter&show=all&status=all&price=all&rating=all&search=${$(this).siblings('input[name="search"]').val()}`
		window.location.href = value
	})
	
	$('.searchComment').change(function() {
		let value = $(this).val()
		console.log(value)-
		$(this).siblings('a').attr("href", `comments.php?search=${value}`)
		console.log($(this).siblings('a').attr("href"))
	})


	/*************************************/


	let toShow;
	if (sessionStorage.getItem("toShow") === null) {
		toShow = ["hidden", "hidden", "hidden", "hidden", "hidden"];
		sessionStorage.setItem("toShow", toShow)
	} else {
		toShowFromSS = sessionStorage.getItem("toShow").split(',');
		console.log(toShowFromSS)
		toShow = toShowFromSS
	}
	toShow.forEach((element, i) => {
		if (element == "showen") {
			$(function () {
				// show ul
				$('.left .slidebutton[data-class=show][data-index=' +  i + ']').siblings('ul').show()

				// hide icon ">"
				$('.left .slidebutton[data-class=show][data-index=' +  i + ']').addClass('hidden')
			})
			
		} else  {
			// hide icon "\/"
			$('.left .slidebutton[data-class=hide][data-index=' +  i + ']').addClass('hidden')
		}
	
	});


	// left show details
	$(".left .slidebutton").on("click", function () {
		
		$(this).addClass('hidden').siblings('.slidebutton').removeClass("hidden")
		if ($(this).data("class") == "hide") {
			//console.log("bahaa")
			$(this).parent().find("ul").slideUp(500, () => {
				$(".left #forScroll").getNiceScroll().resize()
				console.log(($(this).data("index")))
				toShow.splice($(this).data("index"), 1,"hidden")
				sessionStorage.setItem("toShow", toShow)
			});
			
		} if ($(this).data("class") == "show") {
			//console.log("jkfvndfkj")
			$(this).parent().find("ul").slideDown(500, () => {
				$(".left #forScroll").getNiceScroll().resize()
				console.log(($(this).data("index")))
				toShow.splice($(this).data("index"), 1,"showen")
				sessionStorage.setItem("toShow", toShow)
			});
		}	
		
	});
	// Smooth Scroll in cat
	$('.smoothScroll').on("click", function () {
		let getData = "#" + $(this).data("scroll")
		let nav = $(getData);
		if (nav.length) {
			$('html, body').animate({
				scrollTop: nav.offset().top - 50
			}, 1000);
		}

	})

	// Predict Ajax

	function predictPrice() {
		$("div.animate_loading2").css('display','block')
		setTimeout(() => {
			let myData = {
				year : $('.predict #year').val(),
				Kilometers : $('.predict #Kilometers').val(),
				transmission : $('.predict #transmission').val(),
				cc: $('.predict #cc').val(),
				power: $('.predict #power').val(),
				seats: $('.predict #seats').val(),
				fuel: $('.predict #fuel').val(),
				owner: $('.predict #owner').val(),
				
			}
			let yearRate = (myData.year - 2000) * 10;
			let KilometersRate = (1/((myData.Kilometers/100) + 1)) * 1000;
			let transmissionRate = (myData.transmission == 0 ) ? 200 : 100;
			let ccRate = myData.cc /10;
			let powerRate = myData.power;
			let seatsRate = myData.seats * 2;
	
			let fuelRate;
			if (myData.fuel == 1 ) fuelRate = 100
			else if (myData.fuel == 2) fuelRate = 300
			else fuelRate = 200
	
			let ownerRate;
			if (myData.owner == 1 ) ownerRate = 100
			else if (myData.owner == 0) ownerRate = 300
			else ownerRate = 200
	
			
			let rateAll = parseInt(yearRate) + parseInt(KilometersRate) + parseInt(transmissionRate) + parseInt(ccRate) + parseInt(powerRate) + parseInt(seatsRate) + parseInt(fuelRate) + parseInt(ownerRate);
			rateAll = rateAll * 15
			$('#price').val(rateAll);
			$("div.animate_loading2").css('display','none')

		},
		3000)


		// console.log(data);
		// Ajax call to python across php
		// $("div.animate_loading2").css('display','none')

		// $.ajax({  
        //     type: 'POST',  
        //     url: '../car_rent.php', 
        //     data: myData,
        //     success: function(response) {
		// 		$('#price').val(JSON.parse(response));
		//		$("div.animate_loading2").css('display','none')

		// 	}
		// })
	}

	// front-end filter
	$('.navbar_works .filter').on('click', function() {
		$(".noFilter").hide(0)
		$(this).addClass('selected').siblings().removeClass('selected')
		let filter = $(this).data('filter')
		let count = 0;
		$('.card').each(function () {
			if (filter == 'all') {
				$(this).show(1000)
			}
			else {
				$(this).hide(0)
				if ($(this).hasClass(filter)) {
					$(this).show(1000)
					count++;
				}
			}

		})
		if (count == 0 && filter !== 'all') {
			$(".noFilter").show(500)
		}
	})
});
