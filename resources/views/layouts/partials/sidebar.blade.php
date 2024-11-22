 <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 100%;">	
			  <!-- sidebar menu-->
			 
			  <ul class="sidebar-menu" data-widget="tree">	
			  	<li>
				  <a href="{{ URL('home')}}">
					<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
					<span>Dashboard</span>
				  </a>
				</li>
			  	<li class="header">Profile</li>				
						
				  @foreach($menus as $menu)
					@if($menu->submenus->isNotEmpty())
						<!-- Menu with Submenu -->
						<li class="treeview">
							<a href="#">
								<i class="{{ $menu->icon }}"><span class="path1"></span><span class="path2"></span></i>
								<span>{{ $menu->name }}</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								@foreach($menu->submenus as $submenu)
									<li>
										<a href="{{ URL($submenu->url ?? '#') }}">
											<i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
											{{ $submenu->name }}
										</a>
									</li>
								@endforeach
							</ul>
						</li>
					@else
						<!-- Single Link Menu -->
						<li>
							<a href="{{ URL($menu->url ?? '#') }}">
								<i class="{{ $menu->icon }}"><span class="path1"></span><span class="path2"></span></i>
								<span>{{ $menu->name }}</span>
							</a>
						</li>
					@endif
				@endforeach
				
					 	     
			  </ul>
		  </div>
		</div>
    </section>
	<div class="sidebar-footer">
		<a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Settings"><span class="icon-Settings-2"></span></a>
		<a href="mailbox.html" class="link" data-bs-toggle="tooltip" title="Email"><span class="icon-Mail"></span></a>
		<a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Logout"><span class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span></span></a>
	</div>
  </aside>