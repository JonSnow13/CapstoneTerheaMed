<script type="text/javascript">
	var windowHeight = $( window ).height();
	var pharmaPlace;
	var clinicPlace;

	$(function(){

		// $('#mapModal').modal('show');
		// $('#pharmacy-section-holder').scrollToFixed();
		

		// var lastElement = $('.pharmacy-container .pharmacy-panel:last-child');
		// $(window).scroll(function(){
		// 	if ($(window).scrollTop() > 2) 
		// 	{
		// 		$('.navbar').addClass('man-fixed-top');
		// 	}
		// 	else
		// 	{
		// 		$('.navbar').fadeOut(50);
		// 		$('.navbar').removeClass('man-fixed-top');
		// 		setTimeout(function(){
		// 			$('.navbar').fadeIn();
		// 		},20);
		// 	}
		// 	// var lastElement = $('.pharmacy-container .pharmacy-panel:last-child');
		// 	// if (isScrolledIntoView($('.aaa'))) 
		// 	// {
		// 	// 	$('#pharmacy-section-holder').addClass('pharma-fixed-top');
		// 	// 	var name = lastElement.find('.pharma-title').text();
		// 	// 	console.log(name);
		// 	// }
		// 	// else
		// 	// {
		// 	// 	$('#pharmacy-section-holder').removeClass('pharma-fixed-top');
		// 	// }
		// });

		// function isScrolledIntoView(elem){
		//     var $elem = $(elem);
		//     var $window = $(window);

		//     var docViewTop = $window.scrollTop();
		//     var docViewBottom = docViewTop + $window.height();

		//     var elemTop = $elem.offset().top;
		//     var elemBottom = elemTop + $elem.height();

		//     return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		// }

	});

	function getClassOfPharmaPanel()//unused
	{
		var secondToLastElement = $('.pharmacy-panel').eq(-3);

            secondToLastElement.scrollToFixed ({
                marginTop: $ ( '.navbar'). outerHeight (true) + 10
        	});

        var lastElement = $('.pharmacy-panel').eq(-2);
        	lastElement.scrollToFixed ({
                marginTop: $('.pharmacy-panel').eq(-3). outerHeight (true) + 65
        	});
	}

	function getClassOfHospitalPanel()//unused
	{

        var secondToLastClinic = $('.clinic-panel').eq(-3);
        	secondToLastClinic.scrollToFixed ({
                marginTop: $ ( '.navbar'). outerHeight (true) + 10
        	});

        var lastClinic = $('.clinic-panel').eq(-2);
        	lastClinic.scrollToFixed ({
                marginTop: $('.clinic-panel').eq(-3). outerHeight (true) + 65
        	});
	}

	function view_medicine(id)
	{
		$('.man-loader').css('display', 'flex');
		setTimeout(function(){
			$('.man-loader').css('display', 'none');
			$('.card-panel-medicine').hide();
			$('.card-specific-med').show();

			for (var i = 0; i < resultRearchData.length; i++) 
			{
				var data = resultRearchData[i];
				if (data.id == id) 
				{
					var format = jQuery.parseJSON(data.format);
					$('#productPicture').attr('src', data.picture);
					$('#productName').text(data.name);
					$('#productBrand').text('Brand Name: ' + data.brand_name);
					$('#productFormat').text('Format: ' + format.format);
					$('#productDesc').text(data.desc);
					$('#productSideEffects').text(data.side_effect);
					$('#productGenericName').text('Generic Name: ' + data.generic_name);

					var directionOfUse = data.direction_of_use;
						directionOfUse = directionOfUse.split('*');

					$('#productUsage > li').remove();
					$(directionOfUse).each(function(index){
						if (directionOfUse.length > 1) 
						{
							if (index > 0) 
							{
								$('#productUsage').append('<li>' + this + '</li>');
							}
						}
						else
						{
							$('#productUsage').append('<li>' + this + '</li>');
						}
					});


				 	(format.prescription_required == 0)? $('.prescription').hide() : $('.prescription').show();

				 	if (data.category_id == 1) 
				 	{
				 		$('#whatsInside').text('What is in this medicine?');
				 		$('#whatUsage').text('How much and how often should you use this medicine?');
				 		$('#whatDesc').text('What is this medicine for?');
				 	}
				 	else
				 	{
				 		$('#whatsInside').text('What is in this herbal?');
				 		$('#whatUsage').text('How much and how often should you use this herbal?');
				 		$('#whatDesc').text('What is this herbal for?');
				 	}

				 	getContentOfMedicine(data.id);
				}
			}

			var body = $("html, body");
			body.stop().animate({scrollTop:0}, 500, 'swing');

		},800);
		// $('.card-panel-medicine').hide();

	}

	function getContentOfMedicine(id)
	{
		$('#contentOfMedicine').html('');
		$.ajax({
			url: '{{ route("json_get_content_of_medicine") }}',
			type: 'GET',
			data: {medicine_id: id},
			success: function(data){

				for (var i = 0; i < data.length; i++) 
				{
					var tempDensity = (data[i].density == null || data[i].density == '')? '' : data[i].density;
					var html = '<tr>' +
							      	'<th scope="row">'+ (i+1) +'</th>' +
							      	'<td>'+ data[i].name +'</td>' +
							    	'<td>'+ tempDensity +'</td>' +
							    '</tr>';
					$('#contentOfMedicine').append(html);
				}

			}
		});
	}

	function backToAllSearchMed()
	{
		$('.man-loader').css('display', 'flex');
		setTimeout(function(){
			$('.man-loader').css('display', 'none');
			$('.card-specific-med').hide();
			$('.card-panel-medicine').show();
		},800);
		
	}

	function showPharmacy()
	{
		$('#medicinePanel').hide();
		$('.pharma-clinic-panel').show();
		$('#burgerMenu').addClass('collapsed');
		$('#navbarTogglerDemo02').removeClass('show');
		// for (var i = 0; i < 6; i++) {
		// 	showStreetView(pharmaPlace[i], 'pharma'+i);
		// }
		// for (var i = 0; i < 6; i++) {
		// 	showStreetView(clinicPlace[i], 'clinic'+i);
		// }
	}

	function loadMore(elm, option)
	{
		$(elm).find('.loader-more').show();
		setTimeout(function(){
			if (option == 'pharma') 
			{
				pharmaLoadMore();
			}
			else
			{
				clinicLoadMore();
			}
			$(elm).find('.loader-more').hide();
		},1000);
	}

	function clinicLoadMore()
	{
		var count  = ($('#panel-2 .clinic-panel').length);

		if (count < clinicPlace.length) 
		{
			var remaining = clinicPlace.length - count;
			var execute;
			if (remaining > 0) 
			{
				if (remaining < 5) 
				{
					execute = clinicPlace.length;
				}
				else
				{
					execute = count + 5;
				}
			}
			for (var i = count; i < execute; i++) 
			{
				var place = clinicPlace[i];
				appendClinicHtml(place, i);
			}
			personWavingRandom();
			// getClassOfPharmaPanel();
		}
	}

	function pharmaLoadMore()
	{
		var count  = ($('#panel-1 .pharmacy-panel').length);

		if (count < pharmaPlace.length) 
		{
			var remaining = pharmaPlace.length - count;
			var execute;
			if (remaining > 0) 
			{
				if (remaining < 5) 
				{
					execute = pharmaPlace.length;
				}
				else
				{
					execute = count + 5;
				}
			}
			for (var i = count; i < execute; i++) 
			{
				var place = pharmaPlace[i];
				appendPharmacyHtml(place, i);
			}
			personWavingRandom();
			// getClassOfPharmaPanel();
		}
	}

	function getContrastYIQ(hexcolor){
		var r = parseInt(hexcolor.substr(0,2),16);
		var g = parseInt(hexcolor.substr(2,2),16);
		var b = parseInt(hexcolor.substr(4,2),16);
		var yiq = ((r*299)+(g*587)+(b*114))/1000;
		return (yiq >= 128) ? 'black' : 'white';
	}

	//random color generator
	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '';
	  for (var i = 0; i < 6; i++) {
	    color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}

	function appendPopover(elmt)
	{
		elmt.popover({ trigger: "manual" , html: true, animation:false})
	        .on("mouseenter", function () {
	            
	            elmt.popover("show");
	            $(".popover").on("mouseleave", function () {
	                elmt.popover('hide');
	            });
	        }).on("mouseleave", function () {
	            
	            setTimeout(function () {
	                if (!$(".popover:hover").length) {
	                    elmt.popover("hide");
	                }
	            }, 300);
	    });
	}

	function openHoursClinic(index) 
	{
		getPlaceDetails(clinicPlace[index].place_id);
		$('#openHoursModal .modal-title').text(clinicPlace[index].name);
		$('#openHoursModal').modal('show');
	}

	function openHoursPharma(index) 
	{
		getPlaceDetails(pharmaPlace[index].place_id);
		$('#openHoursModal .modal-title').text(pharmaPlace[index].name);
		$('#openHoursModal').modal('show');
	}

	function getPlaceDetails(place_id)
    {
    	$('.open-hours-loader').show();
    	$('.option-view').popover('hide');
    	$('#establishment').text('');
    	var serviceDetails = new google.maps.places.PlacesService(map);
    	serviceDetails.getDetails({
    		placeId: place_id
    	}, function(place, status){
    		// console.log(place);
    		$('.open-hours-loader').hide();
    		try
    		{
    			$('#establishment').append('<table class="table"> <thead> <tr> <th>Open Hours</th> </tr> </thead> <tbody>');
    			for (var i = 0; i < place.opening_hours.weekday_text.length; i++) 
	    		{
	    			$('#establishment').append( '<tr> <td>' + place.opening_hours.weekday_text[i] + '</td> </tr>');
	    		}
	    		$('#establishment').append('</tbody> </table>');	
    		}
    		catch(err)
    		{
    			$('#establishment').text('No open hours available.');
    		}
    		
    	});
    }

    function appendPharmacyHtml(place, i) 
    {
    	var bgColor = getRandomColor();
	  	var textColor = getContrastYIQ(bgColor);

	  	var openNowDisplay = '<div class="open-icon" style="color: white; background: rgba(0, 0, 0, 0.125);">' +
		  						'<i class="material-icons">help</i> Unknown' +
		  					 '</div>';
		var personWaving = '';

	  	try
	  	{
	  		if (place.opening_hours.open_now == true) 
		  	{
		  		openNowDisplay = '<div class="open-icon" style="color: white;">' +
		  							'<i class="material-icons">check_circle</i> Open now' +
		  						  '</div>';
		  		personWaving =  '<div class="person-waving">' +
									'<img src="{{asset('assets/images/nurse4.gif')}}" style="width: 50%">' +
								'</div>';				  
		  	}
		  	else 
		  	{
		  		openNowDisplay = '<div class="open-icon" style="color: white; background: red;">' +
		  							'<i class="material-icons">highlight_off</i> Closed' +
		  						  '</div>';
		  	}
	  	}catch(err){}

	  	var cardView = '<div class="pharmacy-panel">' +
							// '<div class="img-box" style="background: #'+ bgColor +'; color: '+ textColor +'" id="pharma'+i+'" >' +
							'<div class="img-box" style="background: #e4e2e2" id="pharma'+i+'" >' +
								'<h6 class="pharma-title">'+ place.name +'</h6>' +
								openNowDisplay +
								personWaving +
							'</div>' +
							'<div class="man-card-body">' +
								'<div class="distance-view" id="directionView'+i+'">' +
									'<i class="material-icons location-pointer">location_on</i>' +
									'<p class="distance-label" id="pharmaD'+ i +'"></p>' +
								'</div>' +
								'<div class="option-view">' +
									'<i class="material-icons">more_vert</i>' +
								'</div>' +
							'</div>' +
						'</div>';

      	$('#panel-1').append(cardView);
      	var popoverElmt = $('#directionView' + i ).siblings('.option-view');
      	popoverElmt.attr({'data-toggle' : 'popover', 'data-placement': 'bottom', 'data-content' : '<div class="man-list-btn" onclick="openHoursPharma('+ i +')" ><i class="material-icons">schedule</i> Open Hours</div>' +
  						'<div class="man-list-btn" onclick="openPharmaStreetview('+ i +')"><i class="material-icons">streetview</i> Streetview</div>'
  						});
      	appendPopover(popoverElmt);

      	calculateDistance(place, '#pharmaD'+i);
	    directionView('#directionView'+i, place);
    }

    function appendClinicHtml(place, i)
    {
    	var bgColor = getRandomColor();
  		var textColor = getContrastYIQ(bgColor);

  		var openNowDisplay = '<div class="open-icon" style="color: white; background: rgba(0, 0, 0, 0.125);">' +
		  						'<i class="material-icons">help</i> Unknown' +
		  					 '</div>';
		var personWaving = '';

	  	try
	  	{
	  		if (place.opening_hours.open_now == true) 
		  	{
		  		openNowDisplay = '<div class="open-icon" style="color: white;">' +
		  							'<i class="material-icons">check_circle</i> Open now' +
		  						 '</div>';
		  		personWaving =  '<div class="person-waving">' +
									'<img src="{{asset('assets/images/nurse4.gif')}}" style="width: 50%">' +
								'</div>';
		  	}
		  	else 
		  	{
		  		openNowDisplay = '<div class="open-icon" style="color: white; background: red;">' +
		  							'<i class="material-icons">highlight_off</i> Closed' +
		  						  '</div>';
		  	}
	  	}catch(err){}

  		var cardView = '<div class="clinic-panel">' +
						// '<div class="img-box" style="background: #'+ bgColor +'; color: '+ textColor +'" id="clinic'+i+'" >' +
						'<div class="img-box" style="background: #e4e2e2" id="clinic'+i+'" >' +
							'<h6 class="pharma-title">'+ place.name +'</h6>' +
							openNowDisplay +
							personWaving +
						'</div>' +
						'<div class="man-card-body">' +
							'<div class="distance-view" id="directionViewX'+i+'">' +
								'<i class="material-icons location-pointer">location_on</i>' +
								'<p class="distance-label" id="clinicX'+ i +'"></p>' +
							'</div>' +
							'<div class="option-view">' +
								'<i class="material-icons">more_vert</i>' +
							'</div>' +
						'</div>' +
					'</div>';

	    $('#panel-2').append(cardView);

	    var popoverElmt = $('#directionViewX' + i ).siblings('.option-view');
     	popoverElmt.attr({'data-toggle' : 'popover', 'data-placement': 'bottom', 'data-content' : '<div class="man-list-btn" onclick="openHoursClinic('+ i +')"><i class="material-icons">schedule</i> Open Hours</div>' +
	  						'<div class="man-list-btn" onclick="openClinicStreetview('+ i +')"><i class="material-icons">streetview</i> Streetview</div>'
	  						});
      	appendPopover(popoverElmt);

	     // showStreetView(place, 'clinic'+i);
	    calculateDistance(place, '#clinicX'+i);
	    directionView('#directionViewX'+i, place);
    }

    function openClinicStreetview(i)
    {
    	$('.option-view').popover('hide');
    	$('#openStreetview').modal('show');
    	$('#streetViewLoader').show();

    	try
    	{
    		panorama.setVisible(false);
    	}catch(err){}

    	setTimeout(function(){

    		$('#openStreetview .modal-title').text(clinicPlace[i].name);
    		renderStreetView(clinicPlace[i].geometry.location, 'man-streeview');

	    	$('#streetViewLoader').hide();
    	},1000);
    	
    }

    function openPharmaStreetview(i)
    {
    	$('.option-view').popover('hide');
    	$('#openStreetview').modal('show');
    	$('#streetViewLoader').show();

    	try
    	{
    		panorama.setVisible(false);
    	}catch(err){}

    	setTimeout(function(){
    		$('#openStreetview .modal-title').text(pharmaPlace[i].name);
    		renderStreetView(pharmaPlace[i].geometry.location, 'man-streeview');
    // 		try
	   //  	{
	   //  		panorama.setVisible(true);
				// panorama.setPosition(pharmaPlace[i].geometry.location);
	   //  		panorama.setPano(pharmaPlace[i].geometry.location.pano)
	   //  		panorama.setPov({
		  //           heading: 280,
		  //           pitch: 0
		  //         });
	   //  	}
	   //  	catch(err)
	   //  	{
	   //  		renderStreetView(pharmaPlace[i].geometry.location, 'man-streeview');
	   //  	}

	    	$('#streetViewLoader').hide();
    	},1000);
    	
    }

    var resultRearchData;
    function searchBtn()
    {
    	var searchName = $('#searchBox').val();

    	if (isNullOrWhitespace(searchName)) return false;

    	$('#searchedPanel').html('');
    	
    	if (!isNullOrWhitespace(searchName)) 
    	{
    		@if (Request::is('admin'))
    			window.history.pushState('admin', 'Search', 'admin?search=' + searchName);
    		@else
    			window.history.pushState('index', 'Search', 'search=' + searchName);
    		@endif
    	}

    	$('.man-loader').css('display', 'flex');
    	$.ajax({
    		url: '{{ route("json_search") }}',
    		type: 'GET',
    		data: {searchName: searchName},
    		success: function(data){
    			resultRearchData = data;
    			$('.card-panel-medicine').show();
				$('.card-specific-med').hide();
				$('.man-loader').css('display', 'none');
    			// console.log(data);
    			for (var i = 0; i < data.length; i++) 
    			{
    				
    				var htmlAppend =  	'<div class="man-card" onclick="view_medicine('+ data[i].id +')">' +
	    									'<div class="man-row">' +
										  		'<div class="col-md-4 man-img-med-shell">' +
											  			'<img src="'+ data[i].picture +'" style="width: 100%;">' +
											  	'</div>' +
											  	'<div class="col-md-8">' +
											  		'<div class="card-title"><b>'+ data[i].name +'</b></div>' +
											  		'<p style="font-size: 15px;">'+ data[i].desc +'</p>' +
											  	'</div>' +
									  		'</div>' +
									  	'</div>' +
									  	'<div class="med-footer">' +
							  				'<div class="row">' +
												// '<button type="button" class="btn btn-light col-md-6" style="padding: 15px;">' +
												//   	'<div class="fb-like" ' +
												// 	    'data-href="https://terheamed.com/commentPanel'+ data[i].id +'"' +
												// 	    'data-layout="button_count" ' +
												// 	    'data-action="recommend" ' +
												// 	    'data-size="large"' +
												// 	'</div>' +
												// '</button>' +
							  					'<button type="button" class="btn btn-light col-md-12 commentBtn" onclick="appendComment('+ "'" +'#commentPanel' + data[i].id +"'" +', '+ "'" +'terheamed.com/commentPanel' + data[i].id +"'" +')">' +
												  'Reviews' +
												'</button>' +
							  				'</div>' +
							  			'</div>' +
							  			'<div class="comment-section" id="commentPanel'+ data[i].id +'">' +
							  				'<ul class="comment-group">' +
							  				'</ul>' +
			  							'</div>' +
									  	'<hr style="margin-right: 1%; margin-left: 1%;">';

					$('#searchedPanel').append(htmlAppend);
    			}
    			FB.XFBML.parse();

    			// FB.logout(function(response) {
       //              // this part just clears the $_SESSION var
       //              // replace with your own code
       //          });
    		}

    	});
    }

    $('#searchBox').keypress(function(e){
    	if (e.which == 13) searchBtn();
    });

    window.onload = function(){
    	FB.init({
			      appId      : '161442394556549',
			      xfbml      : true,
			      version    : 'v2.5',
			      logout     : true
			    });
    	if(FB.getLoginStatus() != null) {
    		FB.api('/me', function(response) 
		    {
		        alert ("Welcome " + response.name + ": Your UID is " + response.id); 
		    });
    	}

    	// FB.logout(re);

    };


    function appendComment(elmt, urlForComment)
    {
  //   	FB.api(
		//   '/{100004330294967}',
		//   'GET',
		//   {},
		//   function(response) {
		//      console.log(response);
		//   }
		// );

    	if (!$(elmt).hasClass('man-show')) 
    	{
    		$(elmt).prev('.med-footer').find('.commentBtn').append('<img src="{{asset('assets/images/busy.gif')}}" style="width: 8%">');

    		// for (var i = 0; i < 3; i++) 
    		// {
    		// 	var commentHtml =  	'<li class="comment-item">' +
    		// 							'<div style="width: 13%">' +
						// 			  		'<img src="{{asset('assets/images/manuel.png')}}" style="width: 45px; border-radius: 50%;">' +
						// 			  	'</div>' +
						// 			  	'<div style="width: 87%">' +
						// 			  		'Cras justo odio  Cras justo odio  Cras justo odio  Cras justo odio  Cras justo odio' +
						// 			  	'</div>' +
    		// 						'</li>';

    		// 	$(elmt + ' .comment-group').append(commentHtml);
	    	// }

			if (!$(elmt + ' .comment-group').children().length > 0) 
			{
				var commentHtml = '<div class="fb-comments" data-href="https://'+ urlForComment +'" data-numposts="2"></div>';
		    	$(elmt + ' .comment-group').append(commentHtml);
		    	FB.XFBML.parse();
			}

	    	setTimeout(function(){

	    		$(elmt).addClass('man-show');

				$(elmt).siblings('.med-footer').find('.commentBtn').find('img').remove();

	    	},1000);
    	}
    	else
    	{
    		$(elmt).animate({
				height: "0px"
			},400);

    		setTimeout(function(){
    			$(elmt).removeClass('man-show');
    			$(elmt).css('height', '100%');
    		},430);
    	}

    }


// function autocomplete(inp, arr) {
//   /*the autocomplete function takes two arguments,
//   the text field element and an array of possible autocompleted values:*/
//   var currentFocus;
//   /*execute a function when someone writes in the text field:*/
//   inp.addEventListener("input", function(e) {
//       var a, b, i, val = this.value;
//       /*close any already open lists of autocompleted values*/
//       closeAllLists();
//       if (!val) { return false;}
//       currentFocus = -1;
//       /*create a DIV element that will contain the items (values):*/
//       a = document.createElement("DIV");
//       a.setAttribute("id", this.id + "autocomplete-list");
//       a.setAttribute("class", "autocomplete-items");
//       /*append the DIV element as a child of the autocomplete container:*/
//       this.parentNode.appendChild(a);
//       /*for each item in the array...*/
//       for (i = 0; i < arr.length; i++) {
//         /*check if the item starts with the same letters as the text field value:*/
//         if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
//           /*create a DIV element for each matching element:*/
//           b = document.createElement("DIV");
//           /*make the matching letters bold:*/
//           b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
//           b.innerHTML += arr[i].substr(val.length);
//           /*insert a input field that will hold the current array item's value:*/
//           b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
//           /*execute a function when someone clicks on the item value (DIV element):*/
//           b.addEventListener("click", function(e) {
//               /*insert the value for the autocomplete text field:*/
//               inp.value = this.getElementsByTagName("input")[0].value;
//               /*close the list of autocompleted values,
//               (or any other open lists of autocompleted values:*/
//               closeAllLists();
//           });
//           a.appendChild(b);
//         }
//       }
//   });
//   /*execute a function presses a key on the keyboard:*/
//   inp.addEventListener("keydown", function(e) {
//       var x = document.getElementById(this.id + "autocomplete-list");
//       if (x) x = x.getElementsByTagName("div");
//       if (e.keyCode == 40) {
//         /*If the arrow DOWN key is pressed,
//         increase the currentFocus variable:*/
//         currentFocus++;
//         /*and and make the current item more visible:*/
//         addActive(x);
//       } else if (e.keyCode == 38) { //up
//         /*If the arrow UP key is pressed,
//         decrease the currentFocus variable:*/
//         currentFocus--;
//         /*and and make the current item more visible:*/
//         addActive(x);
//       } else if (e.keyCode == 13) {
//         /*If the ENTER key is pressed, prevent the form from being submitted,*/
//         e.preventDefault();
//         if (currentFocus > -1) {
//           /*and simulate a click on the "active" item:*/
//           if (x) x[currentFocus].click();
//         }
//       }
//   });
//   function addActive(x) {
//     /*a function to classify an item as "active":*/
//     if (!x) return false;
//     /*start by removing the "active" class on all items:*/
//     removeActive(x);
//     if (currentFocus >= x.length) currentFocus = 0;
//     if (currentFocus < 0) currentFocus = (x.length - 1);
//     /*add class "autocomplete-active":*/
//     x[currentFocus].classList.add("autocomplete-active");
//   }
//   function removeActive(x) {
//     /*a function to remove the "active" class from all autocomplete items:*/
//     for (var i = 0; i < x.length; i++) {
//       x[i].classList.remove("autocomplete-active");
//     }
//   }
//   function closeAllLists(elmnt) {
//     /*close all autocomplete lists in the document,
//     except the one passed as an argument:*/
//     var x = document.getElementsByClassName("autocomplete-items");
//     for (var i = 0; i < x.length; i++) {
//       if (elmnt != x[i] && elmnt != inp) {
//         x[i].parentNode.removeChild(x[i]);
//       }
//     }
//   }
//   /*execute a function when someone clicks in the document:*/
//   document.addEventListener("click", function (e) {
//       closeAllLists(e.target);
//       });
// }

// /*An array containing all the country names in the world:*/
// var countries = ["Fever", "Cough", "Headache"];

// /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
// autocomplete(document.getElementById("myInput"), countries);

</script>