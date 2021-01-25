<!DOCTYPE html>
<html lang="zxx">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta content="" name="description">
	<meta content="" name="keywords">
	<!-- Mobile Specific Metas -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="HandheldFriendly" content="true">
	<meta content="telephone=no" name="format-detection">
	<title>Aprendendo JS</title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="static/img/favicon.ico" />
	<!-- Google Fonts -->
	<link href="./1.css" rel="stylesheet">
	<link href="./2.css" rel="stylesheet">
	<link href="./3.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="static/css/main.css" rel="stylesheet" type="text/css">
	<!-- END Custom CSS -->




</head>

<body>
	<canvas id="bgCanvas"></canvas>
	<canvas id="terCanvas"></canvas>


	<form style="position: absolute; background-color:white;">

		<label for="">Discos:</label>
		<input type="number" onchange="input()" id="discos"><br><br>
		<label for="">Submit:</label>
	</form>


	<script src="static/js/main.js"></script>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
		(function(d, w, c) {
			(w[c] = w[c] || []).push(function() {
				try {
					w.yaCounter43446069 = new Ya.Metrika({
						id: 43446069,
						clickmap: true,
						trackLinks: true,
						accurateTrackBounce: true,
						webvisor: true,
						trackHash: true
					});
				} catch (e) {}
			});
			var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function() {
					n.parentNode.insertBefore(s, n);
				};
			s.type = "text/javascript";
			s.async = true;
			s.src = "https://mc.yandex.ru/metrika/watch.js";
			if (w.opera == "[object Opera]") {
				d.addEventListener("DOMContentLoaded", f, false);
			} else {
				f();
			}
		})(document, window, "yandex_metrika_callbacks");
	</script> <noscript>
		<div><img src="https://mc.yandex.ru/watch/43446069" style="position:absolute; left:-9999px;" alt="" /></div>
	</noscript> <!-- /Yandex.Metrika counter -->
</body>
<script>
	var number = 0;

	function input() {
		var number = document.getElementById("discos").value;
		var discos = [];
		this.val = number*100;
		this.velociade =0.1;
		for (var i = 0; i < number; i++) {
		
			entities.push(new ShootingStar());
			this.val -=100;
			this.velociade += 0.1;
			
			discos.push(i + 1);
		}




	}


	// Terrain stuff.
	var terrain = document.getElementById("terCanvas"),
		background = document.getElementById("bgCanvas"),
		terCtx = terrain.getContext("2d"),
		bgCtx = background.getContext("2d"),
		width = window.innerWidth,
		height = document.body.offsetHeight;
	(height < 400) ? height = 400: height;

	terrain.width = background.width = width;
	terrain.height = background.height = height;

	// Some random points
	var points = [],
		displacement = 140,
		power = Math.pow(2, Math.ceil(Math.log(width) / (Math.log(2))));

	// set the start height and end height for the terrain
	points[0] = (height - (Math.random() * height / 2)) - displacement;
	points[power] = (height - (Math.random() * height / 2)) - displacement;

	// create the rest of the points
	for (var i = 1; i < power; i *= 2) {
		for (var j = (power / i) / 2; j < power; j += power / i) {
			points[j] = ((points[j - (power / i) / 2] + points[j + (power / i) / 2]) / 2) + Math.floor(Math.random() * -displacement + displacement);
		}
		displacement *= 0.6;
	}

	// draw the terrain
	terCtx.beginPath();

	for (var i = 0; i <= width; i++) {
		if (i === 0) {
			terCtx.moveTo(0, points[0]);
		} else if (points[i] !== undefined) {
			terCtx.lineTo(i, points[i]);
		}
	}

	terCtx.lineTo(width, terrain.height);
	terCtx.lineTo(0, terrain.height);
	terCtx.lineTo(0, points[0]);
	terCtx.fill();


	// Second canvas used for the stars
	bgCtx.fillStyle = '#05004c';
	bgCtx.fillRect(0, 0, width, height);

	// stars
	function Star(options) {
		this.size = Math.random() * 2;
		this.speed = Math.random() * .1;
		this.x = options.x;
		this.y = options.y;
	}

	Star.prototype.reset = function() {
		this.size = Math.random() * 2;
		this.speed = Math.random() * .1;
		this.x = width;
		this.y = Math.random() * height;
	}

	Star.prototype.update = function() {
		this.x -= this.speed;
		if (this.x < 0) {
			this.reset();
		} else {
			bgCtx.fillRect(this.x, this.y, this.size, this.size);
		}
	}


	function ShootingStar() {
		this.reset();
	}
	this.pass = 0;
	ShootingStar.prototype.reset = function() {

		if (this.pass != 1) {
			this.speed = velociade;
			this.speed2 = 0;

		}

		this.x = 400;
		this.y = 700;
		this.len = 10;
	  
		this.size=val;
	


		// this is used so the shooting stars arent constant
		this.waitTime = 0;
		this.active = false;
	}

	ShootingStar.prototype.update = function() {
		if (this.active) {
			this.x -= this.speed;
			this.y += this.speed2;

			if (this.x < 0 || this.y >= height) {
				this.reset();
			}
			if (this.x < 0) {


				this.speed2 = 1;
				this.speed = 0;
		///		this.pass = 1;



			} else {
				bgCtx.lineWidth = this.size;
				bgCtx.beginPath();
				bgCtx.moveTo(this.y, this.x);
				bgCtx.lineTo(this.y, this.x + 10);
				bgCtx.stroke();
			}
		} else {
			if (this.waitTime < new Date().getTime()) {
				this.active = true;
			}
		}
	}

	var entities = [];

	// init the stars
	for (var i = 0; i < height; i++) {
		entities.push(new Star({
			x: Math.random() * width,
			y: Math.random() * height
		}));
	}

	// Add 2 shooting stars that just cycle.

	for (var i = 0; i < number; i++) {
		entities.push(new ShootingStar());
	}


	//animate background
	function animate() {
		bgCtx.fillStyle = '#05004c';
		bgCtx.fillRect(0, 0, width, height);
		bgCtx.fillStyle = '#ffffff';
		bgCtx.strokeStyle = '#ffffff';

		var entLen = entities.length;

		while (entLen--) {
			entities[entLen].update();
		}

		requestAnimationFrame(animate);
	}
	animate();
</script>

</html>