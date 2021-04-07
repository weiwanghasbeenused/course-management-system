<?
$tables = array(
	'InvitationUnit' => array(
		'display_name'  =>  'Invitation Unit',
		'url'           => 'invitation-unit',
		'columns' =>  array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'name' => array(
				'display_name' => 'Unit Name',
				'form_type' => 'input',
				'isRequired' => true
			),
			'abbreviation' => array(
				'display_name' => 'Abbreviation',
				'form_type' => 'input',
				'isRequired' => false
			),
			'address' => array(
				'display_name' => 'Address',
				'form_type' => 'input',
				'isRequired' => false
			),
			'vat_number' => array(
				'display_name' => 'VAT Number',
				'form_type' => 'input',
				'isRequired' => true
			),
			'url' => array(
				'display_name' => 'Website',
				'form_type' => 'input',
				'isRequired' => false
			)
		),
		'display_column' => 'name'
	),
	'InvitationBranch' => array(
		'display_name'  => 'Invitation Branch',
		'url'           => 'invitation-branch',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'name' => array(
				'display_name' => 'Branch Name',
				'form_type' => 'input',
				'isRequired' => true
			),
			'address' => array(
				'display_name' => 'Address',
				'form_type' => 'input',
				'isRequired' => false
			),
			'fk_InvitationUnit' => array(
				'display_name' => 'Associated Unit',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'name'
	),
	'Invoice' => array(
		'display_name'  => 'Invoice',
		'url'           => 'invoice',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'invoice_number' => array(
				'display_name' => 'Invoice Number',
				'form_type' => 'input',
				'isRequired' => true
			),
			'vat' => array(
				'display_name' => 'VAT Number',
				'form_type' => 'input',
				'isRequired' => true
			),
			'description' => array(
				'display_name' => 'Description',
				'form_type' => 'input',
				'isRequired' => true
			),
			'subtotal' => array(
				'display_name' => 'Subtotal',
				'form_type' => 'input',
				'isRequired' => true
			),
			'total' => array(
				'display_name' => 'Total',
				'form_type' => 'input',
				'isRequired' => true
			),
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea',
				'isRequired' => false
			),
			'fk_Payment' => array(
				'display_name' => 'Associated Payment',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'invoice_number'
		
	),
	'InvoiceDetail' => array(
		'display_name'  => 'Invoice Detail',
		'url'           => 'invoice-detail',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'amount' => array(
				'display_name' => 'Amount',
				'form_type' => 'input',
				'isRequired' => true
			),
			'unit_price' => array(
				'display_name' => 'Unit Price',
				'form_type' => 'input',
				'isRequired' => true
			),
			'fk_Invoice' => array(
				'display_name' => 'Associated Invoice',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'invoice_number'
	),
	'Payment' => array(
		'display_name'  => 'Payment',
		'url'           => 'payment',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'check_number' => array(
				'display_name' => 'Check No',
				'form_type' => 'input',
				'isRequired' => false
			),
			'bank_account' => array(
				'display_name' => 'Bank Account',
				'form_type' => 'input',
				'isRequired' => false
			),
			'bank_name' => array(
				'display_name' => 'Bank Name',
				'form_type' => 'input',
				'isRequired' => false
			),
			'payment_date' => array(
				'display_name' => 'Payment Date',
				'form_type' => 'input',
				'isRequired' => true
			),
			'total_payment' => array(
				'display_name' => 'Total Payment',
				'form_type' => 'input',
				'isRequired' => true
			)
		),
		'display_column' => 'check_number'
	),
	'Teaching' => array(
		'display_name'  => 'Teaching',
		'url'           => 'teaching',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),  
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea',
				'isRequired' => false
			),      
			'end_date' => array(
				'display_name' => 'End Date',
				'form_type' => 'input',
				'isRequired' => true
			),     
			'start_date' => array(
				'display_name' => 'Start Date',
				'form_type' => 'input',
				'isRequired' => true
			),   
			'fk_Contact' => array(
				'display_name' => 'Associated Contact',
				'form_type' => 'fk',
				'isRequired' => true
			), 
			'fk_Course' => array(
				'display_name' => 'Associated Course',
				'form_type' => 'fk',
				'isRequired' => true
			),  
			'fk_Invoice' => array(
				'display_name' => 'Associated Invoice',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'start_date'
	),
	'Class' => array(
		'display_name'  => 'Class',
		'url'           => 'class',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'name' => array(
				'display_name' => 'Class Name',
				'form_type' => 'input',
				'isRequired' => true
			),
			'classroom' => array(
				'display_name' => 'Classroom Code',
				'form_type' => 'input',
				'isRequired' => false
			),
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea',
				'isRequired' => false
			),
			'student_number' => array(
				'display_name' => 'Student Amount',
				'form_type' => 'input',
				'isRequired' => false
			),
			'fk_Contact' => array(
				'display_name' => 'Associated Contact',
				'form_type' => 'fk',
				'isRequired' => true
			),
			'fk_InvitationBranch' => array(
				'display_name' => 'Associated Branch',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'name'
	),
	'Contact' => array(
		'display_name'  => 'Contact',
		'url'           => 'contact',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type' => false
			),
			'name' => array(
				'display_name' => 'Name',
				'form_type' => 'input',
				'isRequired' => true
			),
			'name2' => array(
				'display_name' => 'Last Name',
				'form_type' => 'input',
				'isRequired' => false
			),
			'mobile' => array(
				'display_name' => 'Mobile',
				'form_type' => 'input',
				'isRequired' => true
			),
			'phone' => array(
				'display_name' => 'Phone',
				'form_type' => 'input',
				'isRequired' => true
			),
			'phone2' => array(
				'display_name' => 'Phone 2',
				'form_type' => 'input',
				'isRequired' => false
			),
			'email' => array(
				'display_name' => 'Email',
				'form_type' => 'input',
				'isRequired' => false
			),
			'fk_InvitationBranch' => array(
				'display_name' => 'Associated Branch',
				'form_type' => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'name'
	),
	'Course' => array(
		'display_name'  => 'Course',
		'url'           => 'course',
		'columns'       => array(
			'id' => array(
				'display_name' => 'ID',
				'form_type'    => false
			),
			'name' => array(
				'display_name' => 'Course Name',
				'form_type'    => 'input',
				'isRequired' => true
			),
			'course_type' => array(
				'display_name' => 'Course Type',
				'form_type'    => 'input',
				'isRequired' => false
			),
			'hourly_rate' => array(
				'display_name' => 'Hourly Rate',
				'form_type'    => 'input',
				'isRequired' => true
			),
			'total_hours' => array(
				'display_name' => 'Total Hours',
				'form_type'    => 'input',
				'isRequired' => true
			),
			'comment' => array(
				'display_name' => 'Notes',
				'form_type'    => 'textarea',
				'isRequired' => false
			),
			'is_valid' => array(
				'display_name' => 'Is Still Valid?',
				'form_type'    => 'input',
				'isRequired' => false
			),
			'active_since' => array(
				'display_name' => 'Active Date',
				'form_type'    => 'input',
				'isRequired' => true
			),
			'register_date' => array(
				'display_name' => 'Register Date',
				'form_type'    => 'input',
				'isRequired' => true
			),
			'fk_Class' => array(
				'display_name' => 'Associated Class',
				'form_type'    => 'fk',
				'isRequired' => true
			)
		),
		'display_column' => 'name'
	)

);
?>