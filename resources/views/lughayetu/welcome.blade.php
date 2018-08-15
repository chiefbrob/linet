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
				<h5>SWAHILI E-LEARNING PLATFORM</h5>
				<p>

					Yakuwezasha kujifunza, kutuma ujumbe, kuweka nyaraka na kutafuta vitu 
					 mtandaoni

				</p>
				@guest
				<div class="back_to_index">
					
					<a href="{{ route('register') }}" class="text-capitalize">Jisajili</a>
					
					<a href="http://facebook.com/lughayetu" class="text-capitalize">Facebook</a>
				</div>
				@else
				<div class="back_to_index">
					
					<a href="{{ url('/home') }}" class="text-capitalize">Nyumbani</a>
					
					<a href="{{ route('logout') }}" 
						class="text-capitalize" 
						onclick="event.preventDefault();
						       document.getElementById('logout-form').submit();
					">
						Toka
					</a>
					
					
				</div>
				@endguest
			</div>
			<div class="content_right agile-right text-center">
				<img src="images/linet.png" alt="" />
				<h3>tafuta kwa mtandao</h3>
				<p></p>
				<div class="b-search w3-form">
					<form action="https://google.com" method="get">
						<input type="text" name="q" Placeholder="andika hapa" required="">
						<input type="submit" value="">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- copyright -->
	<div class="copyright wthree text-center">
	 <p>&copy; <?php print date('Y'); ?> Lugha yetu network. <a href="{{route('terms')}}">Masharti yapo</a></p>
	</div>
	<!-- //copyright -->
	
</div>
<!-- KARIBU -->

</body>
</html>