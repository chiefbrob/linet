<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<title>Lugha Yetu Network</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Lugha yetu network, Linet" />
	<meta name="robots" content="noindex, nofollow">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900" rel="stylesheet">

</head>
<body>

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

<!-- KARIBU -->
<div class="error_main w3_content">
	<h1 class="text-center"></h1>
	<div class="content">
		<div class="error_content">
			<div class="content_left w3ls">
				<h3>Linet</h3>
				<h4>Uh-Ah</h4>
				<h5>Intelligent Network Operating System</h5>
				<p>Allows for contact management, messaging, application development, E-learning, Internet Searching and much more</p>
				@guest
				<div class="back_to_index">
					
					<a href="{{ route('register') }}" class="text-capitalize">Authentication</a>
					
					<a href="http://facebook.com/lughayetu" class="text-capitalize">Facebook</a>
				</div>
				@else
				<div class="back_to_index">
					
					<a href="{{ url('/home') }}" class="text-capitalize">Home</a>
					
					<a href="{{ route('logout') }}" class="text-capitalize" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
					
					
				</div>
				@endguest
			</div>
			<div class="content_right agile-right text-center">
				<img src="images/linet.png" alt="" />
				<h3>search the internet</h3>
				<p></p>
				<div class="b-search w3-form">
					<form action="#" method="post">
						<input type="text" name="search" Placeholder="type here" required="">
						<input type="submit" value="">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- copyright -->
	<div class="copyright wthree text-center">
	 <p>&copy; <?php print date('Y'); ?> Lugha yetu network. <a href="{{route('terms')}}">Terms and Conditions apply</a></p>
	</div>
	<!-- //copyright -->
	
</div>
<!-- KARIBU -->

</body>
</html>