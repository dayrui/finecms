<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exception - FineCMS</title>
<style type="text/css">
/*<![CDATA[*/
body {font-family:"Verdana";font-weight:normal;color:black;background-color:white;}
h1 { font-family:"Verdana";font-weight:normal;font-size:18pt;color:red }
h3 {font-family:"Verdana";font-weight:bold;font-size:11pt}
p {font-family:"Verdana";font-size:9pt;}
.message {color: maroon;}
/*]]>*/
</style>
</head>

<body>
<h1>Exception</h1>

<h3>Description</h3>
<p class="message">
<?php echo $message; ?>
</p>

<h3>Source File</h3>
<p>
<?php echo $source_file; ?>
</p>

<h3>Stack Trace</h3>
<div class="callstack">
<pre>
<?php echo $trace_string; ?>
</pre>
</div>
</body>
</html>