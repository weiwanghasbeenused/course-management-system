<?
foreach($tables as $key => $table)
{
	if($table['url'] == $uri[2])
		$table_name = $key;
}
$this_id = $_GET['id'];
$this_item = get_item($this_id, $table_name);
$this_columns = $tables[$table_name]['columns'];
$this_action = $_POST['action'];

?>
<section id='add-container' class='container backend-container'>
<?
if( !isset($this_action) ){
	?>
	<form id="edit-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="POST"
		  class="backend-form"><?
	foreach($this_columns as $key => $column)
	{
		$isRequired = $column['isRequired'];
		if($column['form_type'])
		{
			?><div class="form-section"><label for='form-<?= $key; ?>'><?= $column['display_name']; ?><?= $isRequired ? '<span class="required-mark">*<span>' : ''; ?></label><?
		?><?
			$this_value = (isset($this_item[$key]) && $this_item[$key] != NULL) ? $this_item[$key] : '';
			if($column['form_type'] == 'input'){
				
				?><input id='form-<?= $key; ?>' name='<?= $key; ?>' type='text' class="<?= $isRequired ? 'required' : ''; ?>" value="<?= $this_value; ?>"><?
			}
			elseif($column['form_type'] == 'textarea')
			{
				?><textarea id='form-<?= $key; ?>' name='<?= $key; ?>' class="<?= $isRequired ? 'required' : ''; ?>" value="<?= $this_value; ?>"></textarea><?
			}
			elseif($column['form_type'] == 'fk')
			{
				$foreign_table = substr($key, 3);

				if(isset($tables[$foreign_table]['columns']['name'])){
					$display_column = 'name';
					$foreign_fields = array('id', 'name');
				}
				elseif(isset($tables[$foreign_table]['columns'][$foreign_table . '_number'])){
					$display_column = $foreign_table . '_number';
					$foreign_fields = array('id', $foreign_table . '_number');
				}
				else
					$foreign_fields = array('id');

				$foreign_items = get_all($foreign_table, $foreign_fields);
				if($foreign_items && count($foreign_items) > 0)
				{
					?><select id='form-<?= $key; ?>' name='<?= $key; ?>' class="<?= $isRequired ? 'required' : ''; ?>"><option value='0'>None</option><?
						foreach($foreign_items as $item)
						{
							$this_id = $item['id'];
							$display_name = '['.$this_id.']';
							if(isset($display_column))
								$display_name .= ' ' . $item[$display_column];
							?><option value='<?= $this_id; ?>' <?= $this_value == $this_id ? 'selected' : ''; ?>><?= $display_name; ?></option><?
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
	<input type="hidden" name="action" value="update">
	</form>
	<div class="btn-container">
		<button id='submit-btn' class="btn" form="edit-form">Update</button><button id='cancel-btn' class="btn alert-btn" >Cancel</button>
	</div>
	<script type='text/javascript' src = "/static/js/_form.js"></script>
	<script>
		var sForm = document.getElementById('edit-form');
		var sRequired = document.querySelectorAll('.required');
		submit_check(sForm, sRequired, 'edit');
	</script>
<? }elseif($this_action == 'update'){
	$item_to_update = array();
	$passed = true;
	$toFill = array();
	foreach($this_columns as $key => $column)
	{	
		$coulmn_name = $key;
		if(!empty($_POST[$coulmn_name]) && $passed)
			$item_to_update[$coulmn_name] = "'" . addslashes($_POST[$coulmn_name]) . "'";
		elseif(empty($_POST[$coulmn_name]) && $column['isRequired']){
			$passed = false;
			$toFill[] = $column['display_name'];
		}
	}

	if($passed)
		$isUpdated = update($table_name, $this_id, $item_to_update);

	if($passed && $isUpdated)
	{
		?><p>The record is updated.</p><?
	}else if(!empty($toFill))
	{
		?><div class='error-msg'>
			<p>The following field(s) are requried. Please make sure that they're filled:</p>
			<ul>
				<? foreach($toFill as $item){
					?><li><?= $item; ?></li><?
				} ?>
			</ul>
		</div><?
	}
	else
	{
		?><p class='error-msg'>The record is NOT inserted.</p><?
	}
} ?>
</section>