function submit_check(form, required_fields)
{
	form.addEventListener('submit', function(event){
		event.preventDefault();
		var passed = true;
		[].forEach.call(required_fields, function(el, i){
			var this_tag = el.tagName;
			console.log(el.value);
			if(el.value == ''){
				add_required_alert(el);
				passed = false;
			}
			else if(el.classList.contains('toFill'))
				remove_required_alert(el);
		});
		if(!passed)
			return false;
		else
			form.submit();
	});
}
function search_check(form, required_fields)
{
	form.addEventListener('submit', function(event){
		event.preventDefault();
		var input_table = form.querySelector('input[name="table"]');
		
		if(!passed)
			return false;
		else
			form.submit();
	});
}

function add_required_alert(field){
	field.classList.add('toFill');
	var this_id = field.id;
	var this_label = document.querySelector('label[for="'+this_id+'"] .required-mark');
	this_label.classList.add('error-msg');
	this_label.innerText = '* This field is required';
}
function remove_required_alert(field){
	field.classList.remove('toFill');
	var this_id = field.id;
	var this_label = document.querySelector('label[for="'+this_id+'"] .required-mark');
	this_label.classList.remove('error-msg');
	this_label.innerText = '*';
}