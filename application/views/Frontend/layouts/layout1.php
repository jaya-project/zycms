<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>{% block title %}Test{% endblock %}</title>
</head>
<body>
	<div id="header">
		{% block header %}
			<ul>
				  <li><a href="/">Home</a></li>
				  <li><a href="/blog">Blog</a></li>
			</ul>
		{% endblock %}
	</div>
	
	<div id="content">
		{% block content %}
			
		{% endblock %}
	</div>
	
	<div id="footer">
		{% block footer %}
			尾部
		{% endblock %}
	</div>
</body>
</html>