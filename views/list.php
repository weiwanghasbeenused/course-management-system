<?
if(!$uri[1])
	$table_name = 'Teaching';
else
{
	foreach($tables as $key => $table)
	{
		if($table['url'] == $uri[2])
			$table_name = $key;
	}
}

$items = get_all($table_name);

?>
<section id="<?= isset($container_name) && $container_name ? $container_name : ''; ?>-container" class="container list-container">
<?
if($items){
	if($table_name == 'Teaching')
	{
		foreach($items as $item){
			$this_associated_contact = $get_accosiated_item($item['FK_ContactId'], 'Contact', 'ContactId');
			$this_associated_course = $get_accosiated_item($item['FK_CourseId'], 'Course', 'CourseId');
			$this_associated_class = $get_accosiated_item($this_associated_course['FK_ClassId'], 'Class', 'classId');

			$this_contact_name = $this_associated_contact['ContactName'];
			$this_course_name = $this_associated_contact['CourseName'];
			$this_course_rate = $this_associated_contact['Hourly_Rate'];
			$this_course_total_hours = $this_associated_contact['Total_Hours'];

			?><ul class="list_row">
				<li class="row_column"><?= $this_contact_name; ?></li>
				<li class="row_column"><?= $this_course_total_hours; ?></li>
				<li class="row_column"><?= $item['Start_Date']; ?></li>
				<li class="row_column"><?= $this_course_total_hours; ?></li>
				<li class="row_column"><?= $this_course_total_hours; ?></li>
			</ul><?
		}
	}
	else
	{
		if($table_name == 'InvitationUnit')
		$key_name = 'Unit_Name';
		else
		{
			$key_name = $table_name . 'Id';
		}
		foreach($items as $item){
			?><div class="list_row">
				<div class="row_name"><?= $item[$key_name]; ?></div>
				<div class="row_type"></div>
			</div><?
		}
	}
	
	?><?
}

?>
</section>