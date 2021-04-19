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
