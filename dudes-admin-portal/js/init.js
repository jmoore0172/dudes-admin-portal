(function($) {
	$(function() {
		//all datepickers
		$('.datepicker').datepicker({
		  dateFormat: "yy-mm-dd"
		});
		
		
		//issue/due dates
		var invoice = $('.invoice-template');
		
		invoice.find('[name="DueDateSelect"]').on('change', function() {
			var dateEle = invoice.find('[name=DueDate]');
			if ($(this).val() === 'custom') {
				dateEle.val('').focus();
			} else {
				dateEle.val($(this).val());
			}
		}).trigger('change');
		
		
		//invoice grid
		invoice.find('.add-item').on('click', function() {
			
			var updateHrs = function(rows) {
				rows.each(function() {
					var row = $(this);
					row.find(':input').off('keyup').on('keyup', function() {
						var grandTotal = 0,
							hours = Number(row.find('[name*=hours]').val()),
							rate = Number(row.find('[name*=rate]').val());
					
						row.find('[name*=total]').val(hours * rate);
						
						table.find('tr [name*=total]').each(function() {
							grandTotal += Number($(this).val());
						});
						
						grandTotal = grandTotal.toFixed(2).replace(/./g, function(c, i, a) {
						    return i && c !== "." && !((a.length - i) % 3) ? ',' + c : c;
						});
						
						invoice.find('.invoice-total .dynamic-display').html('$' + grandTotal);
						
						//console.log('updating to '+grandTotal);
					}).trigger('keyup');
				})
			},
			
			table = invoice.find('.line-items'),
			row = table.find('tr:nth-child(2)').clone().addClass('custom').each(function() {
				var cellCount = 0,
					row = $(this);
				
				row.find('td').each(function() {
					var cell = $(this),
						field = cell.find(':input').clone(),
						customItemCount = table.find('tr.custom').length,
						oldName = field.attr('name'),
						newName = oldName.substring(0, oldName.indexOf('[')) + '[custom_'+customItemCount+']';
						
					field
						.attr({
							'name': newName,
							'type': 'text',
							'value' : ''
						})
						.filter('[data-default]').val( field.attr('data-default') );
					
					cell.html('').append(field);
					
					if (cellCount == 0) {
						cell.prepend('<a class="remove" href="#">X</a>');
						cell.find('.remove').on('click', function() {
							row.remove();
							updateHrs(table.find('tr'));
							return false;
						});
					}
					
					cellCount++;
				});
			}).appendTo(table);
				
			updateHrs(row);
			return false;
		});
	});
})(jQuery);