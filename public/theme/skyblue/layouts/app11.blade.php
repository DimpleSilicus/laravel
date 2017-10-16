<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <meta name="description" content="">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
   		 <meta name="robots" content="all,follow">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <!-- core CSS -->
        <!-- Latest compiled and minified CSS -->
        <link href="{{ url('/theme') }}/{{$theme}}/css/bootstrap.min.css" rel="stylesheet">
         <link href="{{ url('/theme') }}/{{$theme}}/css/style.default.css" rel="stylesheet">
        <link href="{{ url('/theme') }}/{{$theme}}/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ url('/theme') }}/{{$theme}}/css/pe-icon-7-stroke.css" rel="stylesheet">
		 <link href="{{ url('/theme') }}/{{$theme}}/css/maps.css" rel="stylesheet">
                 <!--date picker-->
    	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/css/bootstrap-datepicker.css" rel="stylesheet" />
        <link href="{{ url('/theme') }}/{{$theme}}/family-tree/CSS/jquery-ui.css" rel="stylesheet" />
    	<link href="{{ url('/theme') }}/{{$theme}}/family-tree/CSS/style.css" rel="stylesheet" />
        
    	
    	
      
        @if(isset($cssFiles))
        @foreach($cssFiles as $src)
        <link href="{{$src}}{{$cssTimeStamp}}" rel="stylesheet" type="text/css" />
        @endforeach
        @endif
        <script>
            var themePath = "{{$url}}theme/{{$theme}}/";
            var siteUrl = "{{$url}}";
        </script>

    </head><!--/head-->

    <body>
       <!-- navbar-->
    <header class="header">
        <div role="navigation" class="navbar navbar-default">
            <div class="container">
               
                <div class="navbar-header">
                    <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ url('/theme') }}/{{$theme}}/images/GNH-logo.png" alt="GNH Logo" /></a>
                    <div class="navbar-buttons">
                        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn"><i class="fa fa-align-justify"></i></button>
                    </div>
                </div>
                @if (Auth::guest())
                <div class="profile-info login-link">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login</a>
                    <div class="dropdown-menu login-form">
                        <form id="loginForm" name="loginForm" action="{{url('/login')}}" method="POST">
                         {!! csrf_field() !!}
                            <div class="col-sm-12">
                                <div class="form-group" >
                                    <input type="text" class="form-control" id="username" name="username" >
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="LoginEmail">Username *</label>
                                    <span class="text-danger" id="username-div">
                                		<strong id="form-errors-username"></strong>
                           			</span>
                                </div>
                                <div class="form-group" >
                                    <input type="password" class="form-control" id="password" name="password" >
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="LoginPW">Password *</label>
                                      <span class="text-danger" id="password-div">
                                		<strong id="form-errors-password"></strong>
                           			</span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 margin-B-20">
                                        <button type="submit" class="btn btn-raised btn-green pull-right">LOGIN</button>
                                        <a href="{{url('/user/forgotpassword')}}" class="pull-right margin-R-20 margin-T-10 forgot-pw"><u>Forgot Password?</u> </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="{{ url('user/register') }}">Signup</a>
                </div>
                @else
                <div class="profile-info">
                    <p>Welcome, {{ Auth::user()->username}} </p> <a href="{{ url('/user/logout') }}" title="Logout">
                        <i class="fa fa-power-off hidden-xs"></i> <span class="visible-xs">Logout</span>
                    </a>
                </div>
                @endif
                <div id="navigation" class="collapse navbar-collapse navbar-right">
                    <div class="clearfix"></div>
                    <ul class="nav navbar-nav">
                       
                        @if (isset(Auth::user()->type) && Auth::user()->type == 1)
                                                          
                        <li><a href="{{ url('/gedcom/toolbox') }}" class="active">Upload Gedcom</a></li>
                        @endif
                        @if(isset(Auth::user()->type))
                        	<li><a href="{{ url('/maps/worldmap') }}">Maps</a></li>
                        	<li><a href="{{ url('/myapps/apps') }}">Apps</a></li>
						@endif
                        <li><a href="/">About GNH</a></li>
                        <li><a href="{{ url('/page/family-history') }}" >About Family History</a></li>
                        <li><a href="{{ url('/page/about-app') }}">About Application</a></li>
                        <li><a href="{{ url('/profiles/mynetwork') }}">Profile</a></li>
                        <li><a href="{{ url('/page/services') }}">Services</a></li>
                        <li><a href="{{ url('/page/contact-us') }}">Contact us</a></li>
          
                        
                        
                    </ul><!--<a href="#" data-toggle="modal" data-target="#login-modal" class="btn navbar-btn btn-ghost"><i class="fa fa-sign-in"></i>Log in</a>-->
                </div>
            </div>
        </div>
    </header>

        @yield('content')
    	<footer class="footer margin-T-100">
            <div class="footer__copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Copyrights &copy; 2017. Genealogy Network Hub. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
          

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/bootstrap.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/jquery.cookie.js"> </script>
    	<script src="{{ url('/theme') }}/{{$theme}}/js/lightbox.min.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/front.js"></script>
        
        <!-- for file uploader -->
        <script src="{{ url('/theme') }}/{{$theme}}/js/File-Upload/fileinput.js" type="text/javascript"></script>
        <!--form---->
        <script src="{{ url('/theme') }}/{{$theme}}/js/form-controls.js"></script>
        <script src="{{ url('/theme') }}/{{$theme}}/js/tab-accordion/ResponsiveTabToAccordion.js"></script>
        <!--date picker-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
        <script type="text/javascript">
            $('#AddPeople').modal({
                backdrop: 'static',
                keyboard: false
            });
    
            $(document).ready(function () {
                $('#GenDOB').datepicker({
                    autoclose: true
                });
               
            });
           
        </script>
         <!--family tree-->

    	<script src="{{ url('/theme') }}/{{$theme}}/js/app.js"></script>
    	
    	 <script type="text/javascript" src="{{ url('/theme') }}/{{$theme}}/video-apps/afterglow.min.js"></script>
    	<!--date picker-->
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.0/js/bootstrap-datepicker.js"></script>
        @if(isset($jsFiles))
        @foreach($jsFiles as $src)
        <script src="{{$src}}{{$jsTimeStamp}}"></script>
        @endforeach
        @endif

    </body>
</html>