function updatescopes(scope){
	var text = document.getElementById('scope').value;
	if (text.indexOf(scope) > -1){
	$("#scope").val($("#scope").val().replace(scope, "").trim());
	}
	else
	{
	$('#scope').val($('#scope').val() + " " + scope);
	}
}
 