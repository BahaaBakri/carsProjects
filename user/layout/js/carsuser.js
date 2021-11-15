/*global console*/

$(function () {

	$('[data-toggle="tooltip"]').tooltip(); // it is very important to trigger tooltips
	$('[data-toggle="popover"]').popover(); // it is very important to trigger popover
	// hide and show placeholder in admins form

	"use strict";
	var placeholder;
	$('[placeholder]').on('focus', function () {
		placeholder = $(this).attr("placeholder");
		$(this).attr("placeholder", "");
	}).on('blur', function () {
		$(this).attr("placeholder", placeholder);
	});
	// nice scroll
	$("#ajaxNotification").niceScroll({cursorborder:"none", cursorwidth: "8px", autohidemode:true});

	// validation in Jquery

	// function show message validate take event and element must show it
	let inp;
	function validate (inp, e) {
		e.preventDefault();
		$(inp).slideDown(400, function () {
			$(inp).delay(3000);
			$(inp).siblings("input, select").on('focus', function () {
				$(inp).slideUp(400);
			});
		});
	}

	// validation on click button submit in login
	$(".login input[type='submit']").on("click", function (e) {

		$("[required='required']").each(function () {
			if(($(this).val().length) == 0) {
				var elem = $(this).siblings(".reqvalidate");
				validate(elem, e);
			}
		});
	});

	// validation on click button submit in signup
	$(".signup input[type='submit']").on("click", function (e) {

		// required elements
		$("[required='required']").each(function () {
			if(($(this).val().length) == 0) {
				var elem = $(this).siblings(".reqvalidate");
				validate(elem, e);
			}
		});

		// username validate
		if(($("[name='username']").val().length) < 3) {
			validate('.uservalidate1', e);
		}

		// password validate
		// password must has numbers and letters only without spaces
		$("[type='password']").each(function () {
			var newpass = $(this).val(),
				wordpass1 = newpass.search(/[.,;''""=_/!@#%^&*+\-?^${}()|[\]\\]/g),
				wordpass2 = newpass.search(" ");
			if ((wordpass1 !== -1) || (wordpass2 !== -1)) {
				var elem = $(this).siblings(".passvalidate1");
				validate(elem, e);
			}
		});

		// password must mutched confirm password

		if ($("[name='password']").val() !== $("[name='conpassword']").val()) {
			validate('.passvalidate2', e);
		}

		// email validate
		// email must has numbers and letters and [@._-] only without spaces
		// email must contains @ . togather

		var email = $("input[type='email']").val(),
			wordemail1a = email.search(/[@]/g),
			wordemail1dot = email.indexOf(".", wordemail1a),
			wordemail2 = email.search(/[,;''""=/!#%^&*+\?^${}()|[\]\\]/g),
			wordemail2space = email.search(" ");
		if ((wordemail1a === -1) || (wordemail1dot === -1)) {
			validate('.emailvalidate1', e);
		} else {
			charaftera = email.slice(wordemail1a, wordemail1dot);

			charafterdot = email.slice(wordemail1dot);

			if ((charaftera.length === 1) || (charafterdot.length === 1)) {
				validate('.emailvalidate3', e);
			}
		}
		if ((wordemail2 !== -1) || (wordemail2space !== -1)) {
			validate('.emailvalidate2', e);
		}
	});

	// validation on click submit in add item
	$(".items input[type='submit']").on("click", function (e) {

		$(".items [required='required']").each(function () {
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


	/* login or signup in the midle of page */
	 function calcleftlogin() {
		 var leftlogin = (window.innerWidth / 2) - 230;
		 var leftsignup = (window.innerWidth / 2) - 400;
		 $('.logindiv').css({
			left:leftlogin
		});
		 $('.signupdiv').css({
			left:leftsignup
		});
	 }
	calcleftlogin();
	window.addEventListener("resize", calcleftlogin);

	// Animation for login

	$(".logindiv").animate({
		top:"150px"
	}, 1000);

	// Animation for signup

	$(".signupdiv").animate({
		top:"100px"
	}, 1000);

	// add estrisc * for required filed

	$("[required='required']").parent("div").each(function () {
			$(this).css('position', 'relative')
			$(this).append("<span class ='astrisc'>*</span>");
			
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

	// preview in add item page
	$('.form-control').keyup(function () {
		$("." + $(this).data('class')).text($(this).val());
		//console.log("." + $(this).data('class'));
	});

	// add comment
	var itemid = $('#commentitemid').val();
	$(".pop-button").on('click', function() {
		itemid = $(this).attr("id");
		console.log(itemid)
	})
	$('.addComment').on('click', function () {
		let valu = $(this).siblings("input[type='text']").val();
		console.log(itemid)
		if (valu !== "") {
			$.ajax({  
				type: 'POST',  
				url: 'ajaxcomment.php', 
				data: { func: "add" ,comment: valu, itemid:itemid},
				success: function(response) {
					// let responseOBJECT = JSON.parse(response);
					// console.log(responseOBJECT);
					if (response == 1) {
						var check = window.confirm("Comment added, refresh the page to show comment, do you want to refresh now ?")
						if (check) {
							location.reload()
						}

					} else {
						let check = window.confirm ("There is some thing wrong, comment not added, do you want to refresh the page now ?")
						if (check) {
							location.reload()
						}
					}
				}
			})
		}

	})
	var editcomid;
	$('.editComment').on('click', function () {
		
		editcomid = $(this).attr('id')
		console.log(editcomid)
		let vvv = $(".thisComment#" + editcomid).text();
		console.log($('#comment'))
		$('input#comment').val(vvv);
		$('.addComment').hide(0,() => {
			$('.updateComment').show(0);
			$('.exitEditComment').show(0);
		})

	})
	$('.updateComment').on('click', function () {
		let updatevalu = $(this).siblings("input[type='text']").val();
		// console.log(comid)
		if (updatevalu !== "") {
			$.ajax({  
				type: 'POST',  
				url: 'ajaxcomment.php', 
				data: { func: "edit" ,comment: updatevalu, comid:editcomid},
				success: function(response) {
					// let responseOBJECT = JSON.parse(response);
					console.log(response);
					exitEditing();
					if (response == 1) {
						var check = window.confirm("Comment edited, refresh the page to show comment, do you want to refresh now ?")
						if (check) {
							location.reload()
						}

					} else {
						let check = window.confirm ("Comment not found, do you want to refresh the page now ?")
						if (check) {
							location.reload()
						}
					}
				}
			})
		}

	})
	function exitEditing() { 
		$('#comment').val("");
		$('.updateComment').hide(0);
		$('.exitEditComment').hide(0);
		$('.addComment').show(0);

	}
	$(".exitEditComment").on('click', exitEditing )
	$('.deleteComment').on('click', function () {
		let deletecomid = $(this).attr('id')
		let confirm = window.confirm("Are you sure want to delete this comment ?");
		if (confirm == 1) {
			$.ajax({  
				type: 'POST',  
				url: 'ajaxcomment.php', 
				data: { func: "delete",  comid:deletecomid},
				success: function(response) {
					// let responseOBJECT = JSON.parse(response);
					console.log(response);
					if (response == 1) {
						let check = window.confirm("Comment deleted, do you want to refresh the page now ?")
						if (check) {
							location.reload()
						}

					} else {
						let check = window.confirm ("Comment not found, do you want to refresh the page now ?")
						if (check) {
							location.reload()
						}
					}
				}
			})
		}
	})
	$('.notificationButton').on('click', function () {
		$('.numberNotification').hide();
		$.ajax({  
			type: 'POST',  
			url: 'ajaxnotification.php', 
			data: {},
			success: function(response) {
				let responseOBJECT = JSON.parse(response);
				console.log(responseOBJECT);
				$("#ajaxNotification").html("");
				if (responseOBJECT.length == 0) {
					$('#ajaxNotification').append(`
						<p class="text-muted text-center">no any notification yet</p>

				`)
				} else {
					responseOBJECT.forEach(element => {
						if (element['notstatus'] == 'comment') {
							$('#ajaxNotification').append(`
								<a class="dropdown-item" href="items.php?do=details&itemid=${element['itemid']}">
									<p class="preLine">${element['username']} comment on your item ${element['name']}</p>
									<span class="text-primary">${element['notdatetime']}</span>
								</a>
								<div class="dropdown-divider"></div>

							`)
						} else if (element['notstatus'] == 'buyrequest') {
							$('#ajaxNotification').append(`
							<a class="dropdown-item" href="items.php?do=details&itemid=${element['itemid']}">
								<p class="preLine">${element['username']} want to buy your item ${element['name']}</p>
								<span>
									<a  class="btn btn-primary" href="items.php?do=sell&status=approve&itemid=${element['itemid']}&userid=${element['userid']}">Sell</a>
									<a  class="btn btn-secondary" href="items.php?do=sell&status=reject&itemid=${element['itemid']}&userid=${element['userid']}">Reject</a>							
								</span>
								<span class="text-primary">${element['notdatetime']}</span>

							</a>
							<div class="dropdown-divider"></div>

							`)
						} else if (element['notstatus'] == 'buysuccess') {
							$('#ajaxNotification').append(`
							<a class="dropdown-item" href="items.php?do=details&itemid=${element['itemid']}">
								<p class="preLine">${element['username']} approve your request for buying his item ${element['name']}</p>
								<span class="text-primary">${element['notdatetime']}</span>
							</a>
							<div class="dropdown-divider"></div>

							`)
						} else if (element['notstatus'] == 'buyfails') {
							$('#ajaxNotification').append(`
							<a class="dropdown-item" href="items.php?do=details&itemid=${element['itemid']}">
								
									<p class="preLine">${element['username']} reject your request for buying his item ${element['name']}</p>
									<span class="text-primary">${element['notdatetime']}</span>
								
							</a>
							<div class="dropdown-divider"></div>
							`)
						}

					});
					
				}
				responseOBJECT = []
			}
		})
	})
});
