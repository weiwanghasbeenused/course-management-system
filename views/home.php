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

$filter_arr = array();
$filter_arr['keyword']['filter-type'] = 'input';
$filter_arr['keyword']['display_name'] = 'Keyword';
$filter_arr['start_date'] = $tables['teaching']['start_date'];
$filter_arr['start_date']['display_name'] = $cells_display_name['start_date']['name'];
$filter_arr['start_date']['filter-type'] = 'range';
$filter_arr['start_date']['tablename'] = 'teaching';
$filter_arr['is_valid'] = $tables['course']['is_valid'];
$filter_arr['is_valid']['display_name'] = $cells_display_name['course_is_valid']['name'];
$filter_arr['is_valid']['filter-type'] = 'select';
$filter_arr['is_valid']['tablename'] = 'course';

?>

<section id="home-container" class="container">
	<? display_filter($filter_arr, $_GET, $table_name); ?>
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
				'course-name'         => $this_associated_course['name'],
				'course-total_hours'  => $this_associated_course['total_hours'],
				'start_date'          => $item['start_date'],
				'class-classroom'     => $this_associated_class['classroom'],
				'class-name'          => $this_associated_class['name'],
				'contact_name'        => $this_contact_name,
				'course-hourly_rate'  => $this_associated_course['hourly_rate'],
				'course-is_valid'     => $this_associated_course['is_valid']
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
<script src = '/static/js/after_list.js'></script>