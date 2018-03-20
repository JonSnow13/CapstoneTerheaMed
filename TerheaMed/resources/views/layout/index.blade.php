@extends('layout.app')

@section('content')
	<div class="man-content">
		<div class="row">
			<div class="col-md-6" id="medicinePanel">
				<div class="man-loader col-md-6">
					<img src="{{asset('assets/images/load.gif')}}" style="width: 40px;">
				</div>
				<h5 style="padding: .5rem .5rem; color: #696a6d;">Suggested Medicine(s):</h5>
				<div class="card-specific-med" style="display: none;">
					<button class="btn btn-light btn-xs btn-simple" style="margin-bottom: 5px;" onclick="backToAllSearchMed()">< back</button>
			  		<div class="man-row">
			  			<div class="col-md-12 man-img-center">
				  			<img src="{{asset('assets/images/biogesic.jpg')}}" style="height: 100%;">
				  		</div>
				  		<div class="col-md-8">
				  			<div class="card-title"><b>Paracetamol Biogesic</b></div>
				  			<b>Product Details</b>
				  			<p>Brand Name: Unilab</p>
				  			<p>Format: Caplet</p>
				  			<p>What is this medicine for?</p>
				  			<p style="font-size: 15px;">For the relief of minor aches and pains such as headache, backache, menstrual cramps, muscular aches, minor arthritis pain, toothache, and pain associated with the common cold and flu; For fever reduction. What is in the medicine? Each tablet contains: Paracetamol, 500 mg.</p>

				  			<p>How much and how often should you use this medicine?</p>
				  			<p style="font-size: 15px;">This medicine should be taken orally every 4 hours, as needed for pain and/or as directed by doctor.</p>
				  		</div>
			  		</div>
				</div>
				<div class="card-panel-medicine">
					<div class="card" id="searchedPanel">
						{{-- @for($i = 0; $i < 6; $i++)
						<div class="man-card" onclick="view_medicine()">
					  		<div class="man-row">
					  			<div class="col-md-4 man-img-med-shell">
						  			<img src="{{asset('assets/images/biogesic.jpg')}}" style="width: 100%;">
						  		</div>
						  		<div class="col-md-8">
						  			<div class="card-title"><b>Paracetamol Biogesic</b></div>
						  			<p style="font-size: 15px;">For the relief of minor aches and pains such as headache, backache, menstrual cramps, muscular aches, minor arthritis pain, toothache, and pain associated with the common cold and flu; For fever reduction. What is in the medicine? Each tablet contains: Paracetamol, 500 mg.</p>
						  		</div>
					  		</div>
					  	</div>
					  	<hr style="margin-right: 1%; margin-left: 1%;">
					  	@endfor --}}
					  	<div class="welcome-card">
			  				<center>
			  					<h2>Welcome to Terhea</h2>
			  					<p>We find cure for you.</p>
			  				</center>
					  	</div>
					</div>
				</div>
			</div>

			<div class="col-md-6 pharma-clinic-panel">
				<h6 style="padding: .5rem .5rem; color: #696a6d;" id="nearestPhamacy">Nearby pharmacy and clinic / hospital in your area: <small><a href="javascript: seeAllPharmaClinic()">See all</a></small></h6>

				<div class="row">
					<div class="col-md-6">
						<div class="pharmacy-container" id="panel-1">
							
							{{-- @for($i = 0; $i < 5; $i++)
							<div class="pharmacy-panel">
								<div class="img-box" style="background: grey; color: white;" id="pharma'+i+'" >
									<h6 class="pharma-title">Generic</h6>
									<div class="open-icon">
										<i class="material-icons">check_circle</i> Open now
									</div>
									<div class="person-waving">
										<img src="{{asset('assets/images/nurse4.gif')}}" style="width: 50%">
									</div>
								</div>
								<div class="man-card-body">
									<div class="distance-view" id="directionView'+i+'">
										<i class="material-icons location-pointer">location_on</i>
										<p class="distance-label" id="pharmaD'+ i +'">1km away</p>
									</div>
									<div class="option-view">
										<i class="material-icons">more_vert</i>
									</div>
								</div>
							</div>
							@endfor --}}

							{{-- <div class="pharmacy-panel">
								<img class="card-img-top" src="{{asset('assets/images/mercury.jpg')}}" alt="Card image cap">
							  	<div class="card-body">
							  		<h6 class="pharma-title">Mercury Last</h6>
							  		<div class="man-row location-label" onclick="locationView()">
							  			<i class="material-icons">location_on</i>
							  			<p class="distance-label"><b>Distance: </b>150m away from your location</p>
							  		</div>
								</div>
							</div> --}}
						</div>
						<button class="btn btn-xs btn-light col-md-12" onclick="loadMore(this, 'pharma')">Load more <img src="{{asset('assets/images/loader.gif')}}" class="loader-more"></button>
					</div>

				<div class="col-md-6">
					<div class="pharmacy-container" id="panel-2">
						{{-- <div class="pharmacy-panel-2">
							<img class="card-img-top" src="{{asset('assets/images/generic.jpg')}}" alt="Card image cap">
						  	<div class="card-body">
						  		<h6 class="pharma-title">Generic pharmacy</h6>
						  		<div class="man-row location-label" onclick="locationView()">
						  			<i class="material-icons">location_on</i>
						  			<p class="distance-label"><b>Distance: </b>1km away from your location</p>
						  		</div>
							</div>
						</div>

						<div class="pharmacy-panel-2">
							<img class="card-img-top" src="{{asset('assets/images/mercury.jpg')}}" alt="Card image cap">
						  	<div class="card-body">
						  		<h6 class="pharma-title">Mercury Last</h6>
						  		<div class="man-row location-label" onclick="locationView()">
						  			<i class="material-icons">location_on</i>
						  			<p class="distance-label"><b>Distance: </b>150m away from your location</p>
						  		</div>
							</div>
						</div> --}}
					</div>
					<button class="btn btn-xs btn-light col-md-12" onclick="loadMore(this, 'clinic')">Load more <img src="{{asset('assets/images/loader.gif')}}" class="loader-more"></button>
				</div>
				</div>
			</div>
			
		</div>
	</div>

@endsection
