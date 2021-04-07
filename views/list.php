<?
foreach($tables as $key => $table)
{
	if($table['url'] == $uri[2])
		$table_name = $key;
}

$this_columns = $tables[$table_name]['columns'];
$items = get_all($table_name);
$no_item_msg = 'Currently there are no available records.';
?>
<section id="<?= isset($container_name) && $container_name ? $container_name : ''; ?>-container" class="container list-container">
<?
if($items){
		?><ul>
		<li class="list-row list-title-row">
			<? foreach($this_columns as $key => $column){
				?><span class='list-cell cell-<?= $key; ?>'><?= $column['display_name']; ?></span><?
			} ?>
			<span class='list-cell' ></span>
		</li><?
		foreach($items as $item){
			?><li class="list-row">
				<? foreach($this_columns as $key => $column){
					if(substr($key, 0, 3) == 'fk_'){
						$foreign_table = substr($key, 3);
						$foreign_display_column = $tables[$foreign_table]['display_column'];
						$foreign_id = $item[$key];
						$foreign_item = get_item($foreign_id, $foreign_table);
						?><span class='list-cell cell-<?= $key; ?>'><?= $foreign_item[$foreign_display_column]; ?></span><?
					}
					else{
						?><span class='list-cell cell-<?= $key; ?>'><?= $item[$key]; ?></span><?
					}
					
				} ?>
				<span class='list-cell action-cell' ><a class="btn edit-btn" href="/edit/<?= $uri[2]; ?>?id=<?= $item['id']; ?>">EDIT</a><a class="btn delete-btn" href="/delete/<?= $uri[2]; ?>?id=<?= $item['id']; ?>">DELETE</a></span>
			</li><?
		}
		?></ul><?
}
else
{
	?><p class="error-msg"><?= $no_item_msg; ?></p><?
}
?>
</section>