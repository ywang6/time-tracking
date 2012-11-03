<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Achieving Goals to Change Behaviors - CSE556 HCI, Fall 2012</title>
	<?php require_once('./assets/php/includes.php'); ?>
</head>
<body>
	<div data-role="page">
		<header data-role="header">
			<h1>
				Edit
			</h1>
		</header>
		<section data-role="content">
			<ul id="goals" data-role="listview" data-inset="true" data-split-icon="delete">

			</ul>
			<br><hr><br>
			<p>When you're done editing, click 'Done' below.</p>
		</section>
		<footer data-role="footer" class="ui-bar">
			<a href="#" onclick="done()" data-role="button" data-icon="check" style="float: right">Done</a>
		</footer>
	</div>
</body>

<script id='goal-edit-template' type='text/x-handlebars-template'>
	<li >
		<!--<a href="#" data-role="button" data-inline="true" class="ui-btn-left" data-icon="delete">Delete</a>-->
		<a href="./goal.php?username={{user}}&id={{id}}" rel="external" data-icon="arrow-r">{{name}}</a>
		<a href="#" onclick="remove({{id}})" data-icon="delete" data-theme="e"></a>
		<?php //<!--<a href="#" data-role="button" data-mini="true" data-inline="true" class="ui-btn-right" data-textpos="notext" data-icon="arrow-r"></a>-->?>
	</li>
</script>
<script>
	var goals = null;
	function populateList() {
		jQuery.getJSON('./assets/php/goals.php?action=get&username=' + username, function success(data) {
			if (data.length == 0) {
				$("#message").html("<h3>You don't have any goals! Click 'EDIT' below to add some.</h3>");
				return;
			}
			template = Handlebars.compile($("#goal-edit-template").text());
			goals = data;
			var items = '';
			for (var i = 0; i < data.length; ++i) {			
				items += template(goals[i]);
			}
			$("#goals").html(items);
			$("#goals").listview('refresh');
		});
	}
	populateList();
	
	function done() {
		window.location.replace('home.php?username=' + username);
	}
	
	function remove(id) {
		$.ajax({
            type: "GET",
            url: "./assets/php/goals.php?action=delete&username="+username+"&id="+id,
             success:function(data){
                   populateList();
            }
        });
	}

</script>

</html>
