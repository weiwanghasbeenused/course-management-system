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
<section id='delete-container' class='container backend-container'>
<?
if( !isset($this_action) ){
	$associated_items = get_accosiated_item($this_id, $table_name);
	// var_dump($associated_items['all']);
	if($associated_items){
		?>
		<p>This record is linked by other records, which are</p>
		<ul><? foreach($associated_items['all'] as $item){
			?><li><?= $item[$item['display_column']]; ?></li><?
		} ?></ul>
		<?
	} ?>
	<p>Do you want to delete this record?</p>
	<form id="delete-form" 
		  enctype="multipart/form-data"
		  action=""
		  method="POST">
	<input type="hidden" name="action" value="delete">
	</form>
	<button id='submit-btn' class="btn btn-alert"form="delete-form">DELETE</button>
	<!-- <script type='text/javascript' src = "/static/js/_form.js"></script>
	<script>
		var sForm = document.getElementById('add-form');
		var sRequired = document.querySelectorAll('.required');
		submit_check(sForm, sRequired, 'edit');
	</script> -->
<? }elseif($this_action == 'delete'){
	$item_to_update = array('active' => 0);
	$passed = true;
	$isDeleted = delete($this_id, $table_name);
var_dump($isDeleted);
	if($passed && $isDeleted)
	{
		?><p>The record is deleted.</p><?
	}else
	{
		?><p class='error-msg'>The record is NOT deleted.</p><?
	}
} ?>
</section>