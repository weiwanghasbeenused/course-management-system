<?
$table_name = 'Teaching';
$items = get_all($table_name);
$cells_display_name = array(
	'course_name' => '課程名稱',
	'course_total_hours' => '課程時數',
	'start_date' => '上課時間',
	'class_classroom' => '上課地點',
	'class_name' => '班級代號',
	'contact_name' => '導師姓名',
	'course_hourly_rate' => '鐘點費',
	'course_is_valid' => '課程取消?'
);
?>

<section id="home-container" class="container">
	<ul>
		<li class="list_row">
		<? 
		foreach($cells_display_name as $key => $cell){
		?><span class='list-cell cell-<?= $key; ?>'><?= $cell; ?></span><?
		} 
		?></li><?
		foreach($items as $item){
			$this_associated_contact = get_accosiated_item($item['fk_Contact'], 'Contact');
			$this_associated_course = get_accosiated_item($item['fk_Course'], 'Course');
			$this_associated_class = get_accosiated_item($this_associated_course['fk_Class'], 'Class');
			$this_contact_name = ( isset($this_associated_contact['name2']) && $this_associated_contact['name2'] != NULL ) ? $this_associated_contact['name1'] : $this_associated_contact['name2'] .' '. $this_associated_contact['name1'];
			$this_row = array(
				'course_name'         => $this_associated_course['name'],
				'course_total_hours'  => $this_associated_course['total_hours'],
				'start_date'          => $item['start_date'],
				'class_classroom'     => $this_associated_class['classroom'],
				'class_name'          => $this_associated_class['name'],
				'contact_name'        => $this_associated_contact['name'],
				'course_hourly_rate'  => $this_associated_course['hourly_rate'],
				'course_is_valid'     => $this_associated_course['is_valid']
			);
			?><li class="list-row">
				<? foreach($this_row as $key => $cell){
					?><span class='list-cell cell-<?= $key; ?>'><?= $cell; ?></span><?
				} ?>
			</li><?
		}
	?>
	</ul>
</section>