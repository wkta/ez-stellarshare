<!DOCTYPE html>
<html>
<body>

<h2 style="color:DarkSlateBlue; background-color:Lavender;">
&nbsp;ez-stellarshare<br>
&nbsp;&nbsp;&nbsp;a simple "lumen dividend" payment service
</h2>

<p style="font-weight:bold;">
Important notice!<br>
Never use this tool on a server not providing HTTPS secured connection to the webpage.
This tool is still in beta version, but has been tested several times. Use it at your own risks.
</p>

	<hr>
	
	<?php
	echo 'Please upload a .txt file listing all token owners, separated by line breaks<br>';
	?>

		<form action="upload1.php" method="POST" enctype="multipart/form-data">
			Provide the .txt file to upload:
			<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
			
			<input type="submit" value="Upload File" name="submit">
		</form>

</body>

</html>