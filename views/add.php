<?
foreach($tables as $key => $table)
{
	if($table['url'] == $uri[2])
		$table_name = $key;
}

$this_columns = $tables[$table_name]['columns'];
$this_action = $_POST['action'];

?><section id='add-container' class='container backend-container'>
<?
if( !isset($this_action) ){
	?>
	<form id="add-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="POST"><?
	foreach($this_columns as $key => $column)
	{
		if($column['form_type'])
		{
			?><div class="form-section"><label for='form-<?= $key; ?>'><?= $column['display_name']; ?></label><?
		?><?
			if($column['form_type'] == 'input'){
				?><input id='form-<?= $key; ?>' name='<?= $key; ?>' type='text'><?
			}
			elseif($column['form_type'] == 'textarea')
			{
				?><textarea id='form-<?= $key; ?>' name='<?= $key; ?>' ></textarea><?
			}
			elseif($column['form_type'] == 'fk')
			{
				$foreign_table = substr($key, 3);
				$foreign_table = substr($foreign_table, 0, strpos($foreign_table, 'Id'));
				if($foreign_table == 'Unit' || $foreign_table == 'Branch')
					$foreign_table = 'Invitation' . $foreign_table;

				if(isset($tables[$foreign_table][$foreign_table . '_Name']))
					$foreign_fields = array($foreign_table . 'Id', $foreign_table . '_Name');
				elseif(isset($tables[$foreign_table][$foreign_table . '_No']))
					$foreign_fields = array($foreign_table . 'Id', $foreign_table . '_No');
				$foreign_items = get_all($foreign_table, $foreign_fields);
				if($foreign_items && count($foreign_items) > 0)
				{
					?><select id='form-<?= $key; ?>' name='<?= $key; ?>' ><?

						if( isset($foreign_items[0][$foreign_table . '_Name']) )
							$display_column = $foreign_table . '_Name';
						elseif( isset($foreign_items[0][$foreign_table . '_No']) )
							$display_column = $foreign_table . '_No';
						else
							$display_column = $foreign_table . 'Id';
						foreach($foreign_items as $item)
						{
							?><option value='<?= $item[$foreign_table . 'Id']; ?>' ><?= $item[$display_column]; ?></option><?
						}
					?></select><?
				}
				else
				{
					?><p class='error-msg'>There's no rows in this foreign table.</p><?
				}
			}
		?></div><?
		}
	}
	?>
	<input type="hidden" name="action" value="add">
	</form>
	<button form="add-form">Add</button>
<? }elseif($this_action == 'add'){
	$item_to_add = array();

	foreach($this_columns as $key => $column)
	{	
		$coulmn_name = $key;
		if(!empty($_POST[$coulmn_name]))
			$item_to_add[$coulmn_name] = "'" . addslashes($_POST[$coulmn_name]) . "'";
	}
	
	$insertId = insert($table_name, $item_to_add);

	if($insertId)
	{
		?><p>The record is inserted.</p><?
	}else
	{
		?><p class='error-msg'>The record is NOT inserted.</p><?
	}
} ?>
</section>