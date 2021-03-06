<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title')</title>

		<!-- CSS -->
      	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
		<link href="/css/vuetify/app.css" rel="stylesheet">
		@yield('css')
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
	</head>

	<body>
		<div id="app" style="display: none;" >
			<v-app id="inspire">
{{-- Right Main Sidebar --}}
				<v-navigation-drawer fixed v-model="drawerRight" right clipped app class="grey lighten-4" v-if="rightMainNavCheck">
					<v-list dense>
						<template v-for="(item, i) in rightMainNav">
							<v-layout row v-if="item.heading" align-center :key="i">
					            <v-flex xs6>
					              	<v-subheader v-if="item.heading">
					                	@{{ item.heading }}
					              	</v-subheader>
					            </v-flex>
				          	</v-layout>
			        		<v-divider dark v-else-if="item.divider" class="my-3" :key="i"></v-divider>
							<v-list-group v-else-if="item.children" v-model="item.model" no-action>
            					<v-list-tile slot="activator" >
									<v-list-tile-content>
										<v-list-tile-title>
											@{{ item.text }}
										</v-list-tile-title>
									</v-list-tile-content>
            					</v-list-tile>
								<v-list-tile v-for="(child, i) in item.children" :key="i" @click="" :href="child.link" :target="item.target">
									<v-list-tile-action v-if="child.icon">
										<v-icon>@{{ child.icon }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title>
											@{{ child.text }}
										</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
         	 				</v-list-group>
							<v-list-tile v-else-if="item.click" :key="i" @click="clickMenu(item.click)">
				        		<v-list-tile-action  v-if="item.icon">
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content  v-if="item.text">
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
				        	</v-list-tile>
							<v-list-tile v-else :href="item.link" :target="item.target">
					            <v-list-tile-action >
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content >
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
	          				</v-list-tile>
						</template>
					</v-list>
				</v-navigation-drawer>
{{-- End Right Main Sidebar --}}
{{-- Toolbar --}}
				<v-toolbar fixed app clipped-right clipped-left>
					<v-toolbar-side-icon @click="left = !left" v-if="leftSubNavCheck" class="hidden-lg-only"></v-toolbar-side-icon>
					<v-toolbar-title>
						<img :src="nav.logo" alt="logo" width="50px" height="50px" v-if="nav.logo" >
			      		<v-btn v-else-if="nav.text" flat class="headline cap" :href="nav.link">@{{ nav.text }}</v-btn>
					</v-toolbar-title>
					<v-btn v-if="nav.logo && nav.text" flat :class="siteNameVisibility" :href="nav.link">@{{ nav.text }}</v-btn>
					<v-spacer></v-spacer>
					<v-toolbar-items class="hidden-md-and-down">
		  				<v-btn flat v-for="(nav, i) in toolBarMenu" :key="i" :href="nav.link" class="cap" v-if="!nav.children">
		  					<v-icon left v-if="nav.icon">@{{ nav.icon }}</v-icon>
		  					@{{ nav.text }}
		  				</v-btn>
		  			</v-toolbar-items>
					<v-toolbar-side-icon @click="right = !right" v-if="rightSubNavCheck" class="hidden-lg-only"></v-toolbar-side-icon>
					<v-menu open-on-hover offset-y v-if="authMenu" class="hidden-md-and-down">
				      	<v-btn flat slot="activator" class="cap">
				      		@{{ authUserName }}
				      		<v-icon>arrow_drop_down</v-icon>
			      		</v-btn>
				      	<v-list dense>
				      		<template v-for="(item, i) in authMenuList">
					        	<v-list-tile v-if="item.link" :key="i" :href="item.link">
					        		<v-list-tile-action v-if="item.icon">
						              	<v-icon>@{{ item.icon }}</v-icon>
						            </v-list-tile-action>
						            <v-list-tile-content v-if="item.text">
						              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
						            </v-list-tile-content>
					        	</v-list-tile>
					        	<v-list-tile v-else-if="item.click" :key="i" @click="clickMenu(item.click)">
					        		<v-list-tile-action v-if="item.icon">
						              	<v-icon>@{{ item.icon }}</v-icon>
						            </v-list-tile-action>
						            <v-list-tile-content v-if="item.text">
						              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
						            </v-list-tile-content>
					        	</v-list-tile>
					            <v-divider v-else-if="item.divider" class="my-3" :key="i"></v-divider>
					        </template>
				      	</v-list>
				    </v-menu>
				</v-toolbar>
{{-- End Toolbar --}}				
{{-- Left Main Sidebar --}}
				<v-navigation-drawer fixed v-model="drawer" clipped app v-if="leftMainNavCheck" >
					<v-list dense>
						<template v-for="(item, i) in leftMainNav">
							<v-layout row v-if="item.heading" align-center :key="i">
					            <v-flex xs6>
					              	<v-subheader v-if="item.heading">
					                	@{{ item.heading }}
					              	</v-subheader>
					            </v-flex>
				          	</v-layout>
			        		<v-divider dark v-else-if="item.divider" class="my-3" :key="i"></v-divider>
							<v-list-group v-else-if="item.children" v-model="item.model" no-action >
								<v-list-tile slot="activator">
									<v-list-tile-action  v-if="item.icon">
					                	<v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content >
										<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
								<v-list-tile v-for="(child, i) in item.children" :key="i" :href="child.link" :target="item.target">
									<v-list-tile-action  v-if="child.icon">
										<v-icon>@{{ child.icon }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title >
											@{{ child.text }}
										</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
         	 				</v-list-group>
							<v-list-tile v-else-if="item.click" :key="i" @click="clickMenu(item.click)">
				        		<v-list-tile-action  v-if="item.icon">
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content  v-if="item.text">
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
				        	</v-list-tile>
							<v-list-tile v-else :href="item.link" :target="item.target">
					            <v-list-tile-action >
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content >
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
	          				</v-list-tile>
						</template>
					</v-list>
				</v-navigation-drawer>
{{-- End Left Main Sidebar --}}
{{-- sub Left SideBar --}}
				<v-navigation-drawer temporary v-model="left" fixed>
					<v-list dense>
						<template v-for="(item, i) in leftSubNav">
							<v-layout row v-if="item.heading" align-center :key="i">
					            <v-flex xs6>
					              	<v-subheader v-if="item.heading">
					                	@{{ item.heading }}
					              	</v-subheader>
					            </v-flex>
				          	</v-layout>
			        		<v-divider dark v-else-if="item.divider" class="my-3" :key="i"></v-divider>
							<v-list-group v-else-if="item.children" v-model="item.model" no-action >
								<v-list-tile slot="activator">
									<v-list-tile-action  v-if="item.icon">
					                	<v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content >
										<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
								<v-list-tile v-for="(child, i) in item.children" :key="i" :href="child.link" :target="item.target">
									<v-list-tile-action  v-if="child.icon">
										<v-icon>@{{ child.icon }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title >
											@{{ child.text }}
										</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
         	 				</v-list-group>
							<v-list-tile v-else-if="item.click" :key="i" @click="clickMenu(item.click)">
				        		<v-list-tile-action  v-if="item.icon">
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content  v-if="item.text">
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
				        	</v-list-tile>
							<v-list-tile v-else :href="item.link" :target="item.target">
					            <v-list-tile-action >
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content >
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
	          				</v-list-tile>
						</template>
					</v-list>
				</v-navigation-drawer>
{{-- End Sub Left SideBar --}}
{{-- Content --}}
				<v-content>
					<v-container fluid fill-height>
						@yield('content')
					</v-container>
				</v-content>
{{-- End Content --}}
{{-- Sub Right SideBar --}}
    			<v-navigation-drawer right temporary v-model="right" fixed >
					<v-list dense>
						<template v-for="(item, i) in rightSubNav">
							<v-layout row v-if="item.heading" align-center :key="i">
					            <v-flex xs6>
					              	<v-subheader v-if="item.heading">
					                	@{{ item.heading }}
					              	</v-subheader>
					            </v-flex>
				          	</v-layout>
			        		<v-divider dark v-else-if="item.divider" class="my-3" :key="i"></v-divider>
							<v-list-group v-else-if="item.children" v-model="item.model" no-action >
								<v-list-tile slot="activator">
									<v-list-tile-action  v-if="item.icon">
					                	<v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content >
										<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
								<v-list-tile v-for="(child, i) in item.children" :key="i" :href="child.link" :target="item.target">
									<v-list-tile-action  v-if="child.icon">
										<v-icon>@{{ child.icon }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title >
											@{{ child.text }}
										</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
         	 				</v-list-group>
							<v-list-tile v-else-if="item.click" :key="i" @click="clickMenu(item.click)">
				        		<v-list-tile-action  v-if="item.icon">
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content  v-if="item.text">
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
				        	</v-list-tile>
							<v-list-tile v-else :href="item.link" :target="item.target">
					            <v-list-tile-action >
					              	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
					            <v-list-tile-content >
					              	<v-list-tile-title>@{{ item.text }}</v-list-tile-title>
					            </v-list-tile-content>
	          				</v-list-tile>
						</template>
					</v-list>
				</v-navigation-drawer>
{{-- End Sub Right SideBar --}}
				<v-footer color="grey lighten-4" app>
					<v-spacer></v-spacer>
					<span>&copy; 2017</span>
				</v-footer>
			<v-app>
		</div>
		<!-- JavaScript -->
		@yield('scripts')
		<script type="text/javascript">
			window.onload = function () {
				var app = document.getElementById('app');
				app.style.display = '';
			}
		</script>
	</body>
</html>
