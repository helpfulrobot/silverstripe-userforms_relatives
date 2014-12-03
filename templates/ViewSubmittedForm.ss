<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Form Submission</title>
</head>

<body>


<% if SubmittedForm %>
	<% control SubmittedForm %>
		<% if FieldValues %>
			<% control FieldValues %>
				<div class="fieldHolder $ClassName">
					<h2>$Title</h2>
					$Value.RAW
					<hr />
				</div>
			<% end_control %>
		<% else %>
			<p class="bad">Could not find data for submitted form.</p>
		<% end_if %>
	<% end_control %>
<% else %>
<p class="bad">Could not find submitted form.</p>
<% end_if %>


