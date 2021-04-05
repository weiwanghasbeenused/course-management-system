<?
	
?>
<header>
	<h1 id = "site-title">
		<a href = '/'><? echo $site_name; ?></a>
	</h1>
	<nav>
		<? foreach($tables as $key => $table ){
			?><div><a class="nav-link" href="/add/<?= $table['url']; ?>"><?= $table['display_name']; ?></a></div><?
		} ?>
	</nav>
	<div id="menu_toggle">
		<div class="menu_bar"></div>
		<div class="menu_bar"></div>
		<div class="menu_bar"></div>
	</div>
</header>
<div id="menu_holder" class="container"></div>




