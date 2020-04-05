<html>
 <head>
    <!--
	<script src="jquery.js" type="text/javascript"></script>
	<script src="marquee.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function () {
        $('div.outer').marquee();
    });

	</script>
	-->
	<style type="text/css">
	@font-face {
		font-family: avenir-next-bold;
		src: url(avenir-next-bold.ttf);
	}
	@font-face {
		font-family: avenir-next-regular;
		src: url(avenir-next-regular.ttf);
	}
	html {
	  background: url(background3.jpg) no-repeat center center fixed;
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	  font-family: sans-serif;
	  color: #ffffff;
	}
	.number {
		 font-size: 50px;
		 padding-right: 40px;
		 font-family: avenir-next-regular;
	}
	.artist {
		font-size: 50px;
		font-family: avenir-next-bold;
	}
	.title {
		font-size: 45px;
		font-family: avenir-next-regular;
	}
	.top-2000-logo {
		position:absolute;
		bottom: 100;
		right:0;
		width: 500px;
	}
	.quizis-logo {
		position:absolute;
		top: 0;
		right:0;
		width: 400px;
	}
	.outer {
		padding-left: 50px;
	}

	</style>
 </head>
 <body>
    <img class="quizis-logo" src="quizis-logo.png" width="200%"/>
   <img class="top-2000-logo" src="top2000-2.gif" />
   <div class="outer">
   <marquee class="top-2000-marquee" behavior="scroll" direction="up" scrollamount="4" height="100%">
		<table>
			<?php
			$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 2000;
			if (($handle = fopen("top2000_2019.csv", "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					$list[] = $data;
				}
				fclose($handle);
			}
			$list = rotate($list, 2000 - $start);
			foreach ($list as $data) {
				print "
						<tr>
							<td class=\"number\">{$data[0]}</td><td class=\"artist\">{$data[2]}</td>
						</tr>
						<tr>
							<td></td><td class=\"title\">{$data[1]} ({$data[3]})</td>
						</tr>
					";
			}
			?>
		</table>
   </marquee>
   </div>
 </body>
</html>

<?php
	function rotate($list, $times)
	{
		for ($i=0; $i<$times; $i++) {
			array_push($list, array_shift($list));
		}

		return $list;
	}

?>
