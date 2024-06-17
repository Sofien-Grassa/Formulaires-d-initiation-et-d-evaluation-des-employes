 function search_invoice(searchQuery='') {
    console.log(searchQuery);
    $.ajax({
        url:"search_invoice.php",
        method:"POST",
        data:{query2:searchQuery},
        success:function(response) {
            console.log(response.html);
            $('#data-table').html(response); 
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert("Error : "+thrownError);
        }
    });
};

 function search_detail_BC(searchQuery='') {
    console.log(searchQuery);
    $.ajax({
        url:"search_cout_repas.php",
        method:"POST",
        data:{detail_BC:searchQuery},
        success:function(response) {
            //console.log(response.html);
            $('#data-table').html(response); 
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert("Error : "+thrownError);
        }
    });
};

 $(document).ready(function(){

 	/*verification On Click envoyer
 	$(document).on('click', 'form button[type=submit]', $(function() {
$("#invoice-form").validate();
}));*/


	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_'+count+'" class="form-control" readonly value="'+count+'"></td>';          
		htmlRows += '<td><input type="text" name="productName[]" id="productName_'+count+'" class="form-control typeahead" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"></td>';	
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_'+count+'" class="form-control quantity" autocomplete="off"></td>';   		
		htmlRows += '<td><input type="number" name="price[]" id="price_'+count+'" class="form-control price" autocomplete="off"></td>';		 
		htmlRows += '<td><input type="number" name="PixHTVA[]" id="PixHTVA_'+count+'" class="form-control PixHTVA" readonly></td>';		 
		htmlRows += '<td><input type="text" name="taxUT[]" id="taxUT_'+count+'" class="form-control Tva" autocomplete="off"></td>';		 
		htmlRows += '<td><input type="text" name="Remise[]" id="Remise_'+count+'" class="form-control Remise" autocomplete="off"></td>';		 
		htmlRows += '<td><input type="number" name="total[]" id="total_'+count+'" class="form-control total" autocomplete="off" readonly></td>';          
		htmlRows += '<td><input type="text" size="1" value="1" name="Coutrepas[]" class="Coutrepas" id="Coutrepas_'+count+'" checked></td>';
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
        $('#productName_'+count).focus();  

	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});		
	$(document).on('blur', "[id^=quantity_]", function(){
		calculateTotal();
	});	
	$(document).on('blur', "[id^=price_]", function(){
		calculateTotal();
	});
	$(document).on('blur', "[id^=taxUT_]", function(){		
		calculateTotal();
	});
	$(document).on('blur', "#subTotal", function(){		
		calculateTotal();
	});
	$(document).on('blur', "#Timbre", function(){		
		calculateTotal();
	});	
	$(document).on('blur', "[id^=Remise_]", function(){		
		calculateTotal();
	});	

	$(document).on('click', '.deleteInvoice', function(){
		var id = $(this).attr("id");

		if(confirm("Are you sure you want to remove this?")){
			$.ajax({
				url:"action.php",
				method:"POST",
				dataType: "json",
				data:{id:id, action:'delete_invoice'},				
				success:function(response) {
					if(response.status == 1) {
						$('#'+id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
});	
function calculateTotal(){
	var totalAmount = 0; 
	$("[id^='price_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("price_",'');
		var price = $('#price_'+id).val();
		var quantity  = $('#quantity_'+id).val();
		var tva  = $('#taxUT_'+id).val();
		var Remise  = $('#Remise_'+id).val();
		//alert(tva);
		if(!quantity) {
			quantity = 1;
			}
		if(!tva){
			tva = 0;
		}
		if(!Remise){
			Remise = 0;
		}
		var totalHTVA = price*quantity;
		var totalTVA = totalHTVA+(((totalHTVA)*tva)/100);
		var total = totalTVA-((totalTVA*Remise)/100)
           // console.log('Remise:' + Remise);

		$('#PixHTVA_'+id).val(parseFloat(totalHTVA).toFixed(3) );
		$('#total_'+id).val(parseFloat(total).toFixed(3) );
		totalAmount += total;			
	});
	$('#subTotal').val(parseFloat(totalAmount.toFixed(3)));	
	var Timbre = parseFloat($("#Timbre").val());
	var subTotal = parseFloat($('#subTotal').val());
	if(Timbre) {
		var taxAmount = subTotal+Timbre;
		$('#totalAfterTimbre').val(taxAmount.toFixed(3));		
	}else{
	$('#totalAfterTimbre').val(subTotal.toFixed(3));
	}
}

 //verification Num BC disponible ou non
 	function  checkAvailability(){
 v=$("#BC");
  v.attr("disabled","true");
  v.css({background:"url(images/load.gif) no-repeat",backgroundSize: "2em",backgroundPosition: "center right"});
  $.post('action.php',{user:v.val().toLowerCase()},function(d){
   v.css("background","white");
   v.removeAttr("disabled");
   if(d=='available'){
    $("#msg").html("<span style='color:green;'>Numero BC <b>"+v.val().toLowerCase()+"</b> Disponible</span>");
   }else{
    $("#msg").html("<span style='color:red;'>Numero BC <b>"+v.val().toLowerCase()+"</b> Non Disponible</span>");
   }
  });
 
 v.bind('keyup',function(){
  $("#prev").text(v.val().toLowerCase());
 });
}