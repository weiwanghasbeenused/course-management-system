<?
$tables = array(
	'InvitationUnit' => array(
		'display_name'  =>  'Invitation Unit',
		'url'           => 'invitation-unit',
		'columns' =>  array(
			'unitId' => array(
				'display_name' => ' Unit ID',
				'form_type' => false
			),
			'Unit_Name' => array(
				'display_name' => 'Unit Name',
				'form_type' => 'input'
			),
			'abbreviation' => array(
				'display_name' => 'Abbreviation',
				'form_type' => 'input'
			),
			'Address' => array(
				'display_name' => 'Address',
				'form_type' => 'input'
			),
			'VAT_Number' => array(
				'display_name' => 'VAT Number',
				'form_type' => 'input'
			),
			'URL' => array(
				'display_name' => 'Website',
				'form_type' => 'input'
			)
		)
	),
	'InvitationBranch' => array(
		'display_name'  => 'Invitation Branch',
		'url'           => 'invitation-branch',
		'columns'       => array(
			'branchId' => array(
				'display_name' => 'Branch ID',
				'form_type' => false
			),
			'Branch_Name' => array(
				'display_name' => 'Branch Name',
				'form_type' => 'input'
			),
			'Address' => array(
				'display_name' => 'Address',
				'form_type' => 'input'
			),
			'FK_UnitId' => array(
				'display_name' => 'Associated Unit',
				'form_type' => 'fk'
			)
		)
	),
	'Invoice' => array(
		'display_name'  => 'Invoice',
		'url'           => 'invoice',
		'columns'       => array(
			'invoiceId' => array(
				'display_name' => 'Invoice ID',
				'form_type' => false
			),
			'Invoice_No' => array(
				'display_name' => 'Invoice Number',
				'form_type' => 'input'
			),
			'VAT' => array(
				'display_name' => 'VAT Number',
				'form_type' => 'input'
			),
			'Description' => array(
				'display_name' => 'Description',
				'form_type' => 'input'
			),
			'Subtotal' => array(
				'display_name' => 'Subtotal',
				'form_type' => 'input'
			),
			'Total' => array(
				'display_name' => 'Total',
				'form_type' => 'input'
			),
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea'
			),
			'FK_PaymentId' => array(
				'display_name' => 'Associated Payment',
				'form_type' => 'fk'
			)
		)
		
	),
	'InvoiceDetail' => array(
		'display_name'  => 'Invoice Detail',
		'url'           => 'invoice-detail',
		'columns'       => array(
			'DetailId' => array(
				'display_name' => 'Detail ID',
				'form_type' => false
			),
			'amount' => array(
				'display_name' => 'Amount',
				'form_type' => 'input'
			),
			'Unit_Price' => array(
				'display_name' => 'Unit Price',
				'form_type' => 'input'
			),
			'FK_InvoiceId' => array(
				'display_name' => 'Associated Invoice',
				'form_type' => 'fk'
			)
		)
	),
	'Payment' => array(
		'display_name'  => 'Payment',
		'url'           => 'payment',
		'columns'       => array(
			'paymentId' => array(
				'display_name' => 'Payment ID',
				'form_type' => false
			),
			'Bank_Account' => array(
				'display_name' => 'Bank Account',
				'form_type' => 'input'
			),
			'Bank_Name' => array(
				'display_name' => 'Bank Name',
				'form_type' => 'input'
			),
			'Check_No' => array(
				'display_name' => 'Check No',
				'form_type' => 'input'
			),
			'Payment_Date' => array(
				'display_name' => 'Payment Date',
				'form_type' => 'input'
			),
			'Total_Payment' => array(
				'display_name' => 'Total Payment',
				'form_type' => 'input'
			)
		)
	),
	'Teaching' => array(
		'display_name'  => 'Teaching',
		'url'           => 'teaching',
		'columns'       => array(
			'teachingId' => array(
				'display_name' => 'Teaching ID',
				'form_type' => false
			),  
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea'
			),      
			'End_Date' => array(
				'display_name' => 'End Date',
				'form_type' => 'input'
			),     
			'Start_Date' => array(
				'display_name' => 'Start Date',
				'form_type' => 'input'
			),   
			'FK_ContactId' => array(
				'display_name' => 'Associated Contact',
				'form_type' => 'fk'
			), 
			'FK_CourseId' => array(
				'display_name' => 'Associated Course',
				'form_type' => 'fk'
			),  
			'FK_InvoiceId' => array(
				'display_name' => 'Associated Invoice',
				'form_type' => 'fk'
			)
		)
	),
	'Class' => array(
		'display_name'  => 'Class',
		'url'           => 'class',
		'columns'       => array(
			'classId' => array(
				'display_name' => 'Class ID',
				'form_type' => false
			),
			'Class_Name' => array(
				'display_name' => 'Class Name',
				'form_type' => 'input'
			),
			'Classroom_Code' => array(
				'display_name' => 'Classroom Code',
				'form_type' => 'input'
			),
			'comment' => array(
				'display_name' => 'Comment',
				'form_type' => 'textarea'
			),
			'Student_Number' => array(
				'display_name' => 'Student Amount',
				'form_type' => 'input'
			),
			'FK_ContactId' => array(
				'display_name' => 'Associated Contact',
				'form_type' => 'fk'
			),
			'FK_BranchId' => array(
				'display_name' => 'Associated Branch',
				'form_type' => 'fk'
			)
		)
	),
	'Contact' => array(
		'display_name'  => 'Contact',
		'url'           => 'contact',
		'columns'       => array(
			'contactId' => array(
				'display_name' => 'Contact ID',
				'form_type' => false
			),
			'Contact_Mobile' => array(
				'display_name' => 'Mobile',
				'form_type' => 'input'
			),
			'Contact_Name' => array(
				'display_name' => 'Name',
				'form_type' => 'input'
			),
			'Contact_Phone' => array(
				'display_name' => 'Phone',
				'form_type' => 'input'
			),
			'Contact_Phone2' => array(
				'display_name' => 'Phone 2',
				'form_type' => 'input'
			),
			'email' => array(
				'display_name' => 'Email',
				'form_type' => 'input'
			),
			'FK_BranchId' => array(
				'display_name' => 'Associated Branch',
				'form_type' => 'fk'
			)
		)
	),
	'Course' => array(
		'display_name'  => 'Course',
		'url'           => 'course',
		'columns'       => array(
			'courseId' => array(
				'display_name' => 'Course ID',
				'form_type'    => false
			),
			'Course_Name' => array(
				'display_name' => 'Course Name',
				'form_type'    => 'input'
			),
			'Course_Type' => array(
				'display_name' => 'Course Type',
				'form_type'    => 'input'
			),
			'Hourly_Rate' => array(
				'display_name' => 'Hourly Rate',
				'form_type'    => 'input'
			),
			'Total_Hours' => array(
				'display_name' => 'Total Hours',
				'form_type'    => 'input'
			),
			'prerequisite' => array(
				'display_name' => 'Notes',
				'form_type'    => 'textarea'
			),
			'IsStill_Valid' => array(
				'display_name' => 'Is Still Valid?',
				'form_type'    => 'input'
			),
			'Active_Since' => array(
				'display_name' => 'Active Date',
				'form_type'    => 'input'
			),
			'Register_Date' => array(
				'display_name' => 'Register Date',
				'form_type'    => 'input'
			),
			'FK_ClassId' => array(
				'display_name' => 'Associated Class',
				'form_type'    => 'fk'
			)
			
		)
	)

);
?>