<script>
$(".top-header li").click(function(){
	$(this).parent('ul').children().removeClass('selected');
	$(this).addClass('selected');
});
</script>
</body>
</html>