@extends('layouts.admin')
@section('content')
        <section class="content">
			<div class="row">
				<div class="col-12">
					<div class="box bg-gradient-primary overflow-hidden pull-up">
						<div class="box-body pe-0 ps-lg-50 ps-15 py-0">							
							<div class="row align-items-center">
								<div class="col-12 col-lg-8">
									<h1 class="fs-40 text-white">{{$profile->userdesc}}</h1>
									<p class="text-white mb-0 fs-20">NamaUnit : {{$profile->namaunit}}</p>
									<p class="text-white mb-0 fs-15">Email    : {{$profile->email}}</p>
								</div>
								<div class="col-12 col-lg-4"><img src="{{asset('assets/images/svg-icon/color-svg/custom-14.svg')}}" alt=""></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</section>
@endsection
