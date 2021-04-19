var sList_cell = document.getElementsByClassName('list-cell');
if(sList_cell.length != 0)
{
	[].forEach.call(sList_cell, function(el, i){
		var thisRow = el.parentNode;
		if(!thisRow.classList.contains('list-title-row'))
		{
			el.addEventListener('click', function(){
				var activeRow = document.querySelector('.list-row.active');
				
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
		}
	});
}

var sSearch_btn = document.getElementById('search-btn');
var sSearch_form = document.getElementById('search-form');
var sReset_btn = document.getElementById('reset-btn');
var self_url = window.location.pathname;

var sList_filter_field = document.getElementsByClassName('list-filter-field');

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
sReset_btn.addEventListener('click', function(){
	console.log('hihi');
	location.href = self_url;
});