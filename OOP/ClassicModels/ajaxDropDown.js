

	$(document).ready(function()
	{
		$("#drop").change(function()
		{
			data = { getproduct: "get", select: $("#drop").val()}
			$.post("showDetails.php",data).done(function(result)
			{
				$("#here").html(result)
			});
		});
	});
