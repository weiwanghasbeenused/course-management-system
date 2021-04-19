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
var sSearch_btn = document.getElementById('search-btn');
var sSearch_form = document.getElementById('search-form');
var sReset_btn = document.getElementById('reset-btn');
var sCancel_btn = document.getElementById('cancel-btn');
var self_url = window.location.pathname;

var sList_filter_field = document.getElementsByClassName('list-filter-field');

if(sSearch_form != undefined)
{
	sSearch_form.addEventListener('submit', function(event){
		event.preventDefault();
		var query = '?';
		[].forEach.call(sList_filter_field, function(el, i){
			console.log(el.tagName);
			if(el.tagName == 'INPUT' && el.classList.contains('list-filter-field-range'))
			{
				if(el.value !== ''){
					if(query == '?')
						query += el.name + '=' + el.value;
					else
						query += '&' + el.name + '=' + el.value;
				}
			}
			else if(el.tagName == 'SELECT')
			{
				if(el.selectedIndex != 0){
					if(query == '?')
						query += el.name + '=' + el.value;
					else
						query += '&' + el.name + '=' + el.value;
				}
			}
			else
			{
				if(el.value !== ''){
					if(query == '?')
						query += el.name + '=' + el.value;
					else
						query += '&' + el.name + '=' + el.value;
				}
			}
		});
		if(query != '?')
			location.href = self_url + query;
	});
}

if(sReset_btn != undefined)
{
	sReset_btn.addEventListener('click', function(){
		location.href = self_url;
	});
}

if(sCancel_btn != undefined)
{
	sCancel_btn.addEventListener('click', function(){
		history.go(-1);
		// return false;
	});
}