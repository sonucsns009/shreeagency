$(document).ready(function($) 
{
		
// code for add restuarant enquiry
$("#btn_restaurant_enquiry").click(function(){
	var owner_name=$("#owner_name").val();
	var lng=$("#lng").val();
	var email_address=$("#email_address").val();
	var mobile_number=$("#mobile_number").val();
	var business_name=$("#business_name").val();
	var address=$("#address").val();
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	
	var flag=1;
	$("#err_owner_name").html('');
	$("#err_email_address").html('');
	$("#err_mobile_number").html('');
	$("#err_business_name").html('');
	$("#err_address").html('');
	
	if(owner_name=="")
	{
		if(lng=="English")
		{
			$("#err_owner_name").html('Enter full name.');
		}
		else
		{
			$("#err_owner_name").html('Ingrese el nombre completo.');
		}
		flag=0;
	}
	if(email_address=="")
	{
		if(lng=="English")
		{
				$("#err_email_address").html('Enter email address.');
		}
		else
		{
			$("#err_email_address").html('Introducir la dirección de correo electrónico.');
		}
		flag=0;
	}
	if(email_address!="" && !testEmail.test(email_address))
	{
		if(lng=="English")
		{
				$("#err_email_address").html('Please enter valid email address.');
		}
		else
		{
				$("#err_email_address").html('Por favor ingrese una dirección de correo electrónico válida.');

		}
		flag=0;
	}
	if(mobile_number=="")
	{
		if(lng=="English")
		{
				$("#err_mobile_number").html("Enter phone number.");
		}
		else
		{
			$("#err_mobile_number").html("Introduzca el número de teléfono.");
		}
		flag=0;
	}
	if(mobile_number!="" && isNaN(mobile_number))
	{
		if(lng=="English")
		{
				$("#err_mobile_number").html('Please enter valid phone number.');
		}
		else
		{
			$("#err_mobile_number").html('Por favor, introduzca un número de teléfono válido.');
		}
		flag=0;
	}
	if(business_name=="")
	{
		if(lng=="English")
		{
				$("#err_business_name").html('Select business type.');
		}
		else
		{
			$("#err_business_name").html('Seleccione el tipo de negocio.');
		}
		flag=0;
	}
	if(address=="")
	{
		if(lng=="English")
		{
				$("#err_address").html('Enter address.');
		}
		else
		{
			$("#err_address").html('Ingresa la direccion.');
		}
		flag=0;
	}
	if(flag==1)
		return true;
	else
		return false;
});	


	// code for add contact delivery enquiry
	$("#btn_delivery_enquiry").click(function()
	{
		var full_name=$("#full_name").val();
		var lng=$("#lng").val();
		var email_address=$("#email_address").val();
		var mobile_number=$("#mobile_number").val();
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		
		var flag=1;
		$("#err_owner_name").html('');
		$("#err_email_address").html('');
		$("#err_mobile_number").html('');
		
		if(full_name=="")
		{
			if(lng=="English")
			{
					$("#err_full_name").html('Enter full name.');
			}
			else
			{
				$("#err_full_name").html('Ingrese el nombre completo.');
			}
			flag=0;
		}
		if(email_address=="")
		{
			if(lng=="English")
			{
					$("#err_email_address").html('Enter email address.');
			}
			else
			{
				$("#err_email_address").html('Introducir la dirección de correo electrónico.');
			}
			flag=0;
		}
		if(email_address!="" && !testEmail.test(email_address))
		{
			if(lng=="English")
			{
					$("#err_email_address").html('Please enter valid email address.');
			}
			else
			{
				$("#err_email_address").html('Por favor ingrese una dirección de correo electrónico válida.');
			}
			flag=0;
		}
		if(mobile_number=="")
		{
			if(lng=="English")
			{
					$("#err_mobile_number").html("Enter phone number.");
			}
			else
			{
				$("#err_mobile_number").html("Introduzca el número de teléfono.");
			}
			flag=0;
		}
		if(mobile_number!="" && isNaN(mobile_number))
		{
			if(lng=="English")
			{
					$("#err_mobile_number").html('Please enter valid phone number.');
			}
			else
			{
				$("#err_mobile_number").html('Por favor, introduzca un número de teléfono válido.');
			}
			flag=0;
		}
		if(flag==1)
			return true;
		else
			return false;
	});	

});