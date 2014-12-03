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
				<% if Value %>
				<div class="fieldHolder $ClassName">
					<h2>$Title.RAW</h2>
					<div class="valueHolder">$Value.RAW</div>
					<hr />
				</div>
				<% end_if %>
			<% end_control %>
		<% else %>
			<p class="bad">Could not find data for submitted form.</p>
		<% end_if %>
	<% end_control %>
<% else %>
<p class="bad">Could not find submitted form.</p>
<% end_if %>


