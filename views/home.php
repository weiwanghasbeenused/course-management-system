<?
$table_name = 'Teaching';
$items = get_all($table_name);
$cells_display_name = array(
	'course_name' => array(
		'name' => '課程名稱',
		'size' => 'large'
	),
	'course_total_hours' => array(
		'name' => '時數',
		'size' => 'small'
	),
	'start_date' => array(
		'name' => '上課時間',
		'size' => 'mid'
	),
	'class_classroom' => array(
		'name' => '上課地點',
		'size' => 'mid'
	),
	'class_name' => array(
		'name' => '班級代號',
		'size' => 'mid'
	),
	'contact_name' => array(
		'name' => '導師姓名',
		'size' => 'mid'
	),
	'course_hourly_rate' => array(
		'name' => '鐘點費',
		'size' => 'small'
	),
	'course_is_valid' => array(
		'name' => '取消?',
		'size' => 'small'
	)

);
?>

<section id="home-container" class="container">
	<div id="home-list" class="list-container grid-container">
		<div class="home-list-row list-row list-title-row">
		<? 
		foreach($cells_display_name as $key => $cell){
		?><span class='list-cell cell-<?= $key; ?>'><?= $cell['name']; ?></span><?
		} 
		?></div><?
		foreach($items as $item){
			$this_associated_contact = get_item($item['fk_Contact'], 'Contact');
			$this_associated_course = get_item($item['fk_Course'], 'Course');
			$this_associated_class = get_item($this_associated_course['fk_Class'], 'Class');
			$this_contact_name = ( isset($this_associated_contact['name2']) && $this_associated_contact['name2'] != NULL ) ? $this_associated_contact['name2'] .' '. $this_associated_contact['name'] : $this_associated_contact['name'];
			$this_row = array(
				'course_name'         => $this_associated_course['name'],
				'course_total_hours'  => $this_associated_course['total_hours'],
				'start_date'          => $item['start_date'],
				'class_classroom'     => $this_associated_class['classroom'],
				'class_name'          => $this_associated_class['name'],
				'contact_name'        => $this_contact_name,
				'course_hourly_rate'  => $this_associated_course['hourly_rate'],
				'course_is_valid'     => $this_associated_course['is_valid']
			);
			?><div class="home-list-row list-row">
				<? foreach($this_row as $key => $cell){
					?><span class='list-cell cell-<?= $key; ?>'><?= $cell; ?></span><?
				} ?>
			</div><?
		}
	?>
	</ul>
</section>
<script>
	var sList_cell = document.getElementsByClassName('list-cell');
	[].forEach.call(sList_cell, function(el, i){
		el.addEventListener('click', function(){
			var activeRow = document.querySelector('.list-row.active');
			var thisRow = el.parentNode;
			if(activeRow === thisRow) 
			{
				activeRow.classList.remove('active');
			}
			else
			{
				if(activeRow != null)
					activeRow.classList.remove('active');
				thisRow.classList.add('active');
			}
			
		});
	});
</script>
