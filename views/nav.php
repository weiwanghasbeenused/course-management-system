<?
	
?>
<header>
	<h1 id = "site-title">
		<a href = '/'><? echo $site_name; ?></a>
	</h1>
	<nav>
		<? foreach($tables as $key => $table ){
			?><div><div class="menu-item"><span class="menu-item-name"><?= $table['display_name']; ?></span> <a class="menu-link list-link" href="/list/<?= $table['url']; ?>">List</a><a class="menu-link add-link" href="/add/<?= $table['url']; ?>">Add</a></div></div><?
		} ?>
	</nav>
	<div id="menu_toggle">
		<div class="menu_bar"></div>
		<div class="menu_bar"></div>
		<div class="menu_bar"></div>
	</div>
</header>
<div id="menu_holder" class="container"></div>




