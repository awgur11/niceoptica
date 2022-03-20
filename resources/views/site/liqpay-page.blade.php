<!DOCTYPE html>
<html lang="ru-UA">
<head>

 
<meta charaset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- jQuery library -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
</head>
<body>

	{!! $liqpay_button !!}
	<script type="text/javascript">
		$(function(){
			$('form').submit();
		})
	</script>
</body>
</html>