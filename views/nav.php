<?
	foreach($tables as $key => $table)
	{
		if($table['url'] == $uri[2])
			$current_table = $key;
	}
	$current_view = $uri[1];
	$nav_items = array(
		array(
			'name' => $site_name,
			'url'  => '/'
		), 
		array(
			'name' => $current_table, 
			'url'  => '/list/' . $uri[2]
		),
		array(
			'name' => $current_view,
			'url'  => '/' . $current_view . '/' . $uri[2]
		)
	);
?>
<header>
	<nav>
		<? foreach($nav_items as $key => $item){
			if($item['name'])
			{
				if($item['url'])
				{
					?><span class="nav-item"><?= $key == 0 ? '' : ' > ' ?><a href="<?= $item['url']; ?>"><?= $item['name']; ?></a></span><?
				}
				else
				{
					?><span class="nav-item"><?= $key == 0 ? $item['name'] : ' > '. $item['name']; ?></span><?
				}
			}			
		} ?>
	</nav>
	<div id = "nav-btn-container">
		<div id="menu_toggle">
			<div class="menu-bar"></div>
			<div class="menu-bar"></div>
			<div class="menu-bar"></div>
		</div>
	</div>
</header>
<div id="menu-container" class="container">
<? foreach($tables as $key => $table ){
	?><div><div class="menu-item"><span class="menu-item-name"><?= $table['display_name']; ?></span> <div class="btn-container"><a class="menu-btn list-btn btn" href="/list/<?= $table['url']; ?>">List</a><a class="menu-btn add-btn btn" href="/add/<?= $table['url']; ?>">Add</a></div></div></div><?
} ?>
</div>

<script>
	sMenu_toggle = document.getElementById('menu_toggle');
	sMenu_toggle.addEventListener('click', function(){
		body.classList.toggle('viewing-menu');
	});
</script>

