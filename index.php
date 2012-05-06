<?php
//Author: Abhishek Dey Das
//Website: http://siliconhead.in

 $response = 'No response to display';
 $urlcall = 'None';
 
 if(isset($_POST['postvalues']))
 {
  //with POST values
  $pname = $_POST['pname'];
  $pval = $_POST['pval'];
  
  $i = 0;
  
  foreach ($pname as $pname_s)
  {
   $arr_pname[$i] = $pname_s;
   $i++;
  }
  
  $i = 0;
  
  foreach ($pval as $pval_s)
  {
   $arr_pval[$i] = $pval_s;
   $i++;
  }
  
  $post_data = array();
  
  for ($i=0; $i < sizeof($arr_pname); $i++)
  {
   $post_data [$arr_pname[$i]] = $arr_pval[$i];
  }
  
  //traverse array and prepare data for posting (key1=value1)
	foreach ( $post_data as $key => $value) {
     $post_items[] = $key . '=' . $value;
	}
	//create the final string to be posted using implode()
	$post_string = implode ('&', $post_items);
	//create cURL connection
	$curl_connection =
  	curl_init($_POST['urltocall']);
	//set options
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,
  	"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	//set data to be posted
	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
	//perform our request
	$result = curl_exec($curl_connection);
	//show information regarding the request
	//print_r(curl_getinfo($curl_connection));
	//echo curl_errno($curl_connection) . '-' .
                curl_error($curl_connection);
	//close the connection
	curl_close($curl_connection);
	//print $result;
	$response = $result;
  
 }
 else
 {
  //without POST values
  $response = file_get_contents ($_POST['urltocall']);    
 }
 
 $urlcall = $_POST['urltocall'];
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Siliconhead.in API explorer demo</title>

<style type="text/css">
 body
 {
  font-family:Verdana, Arial, Helvetica, sans-serif;
  font-size:12px;
  color:#000000;
 }
 
 h1
 {
  font-family:Georgia, "Times New Roman", Times, serif;
  font-size:16px;
  color:#000033;
 }
</style>

<script type="text/javascript" src="jquery.js"></script>
 
<style type="text/css">
	div{
		padding:8px;
	}
</style>

<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 1;
 
    $("#addButton").click(function () {
 
	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}   
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);
 
	newTextBoxDiv.after().html('Post parameter #'+ counter + ' : ' +
	      'Parameter name <input type="text" name="pname[' + counter + 
	      ']" id="pname[' + counter + ']" value="" >' +
	      'Parameter value <input type="text" name="pval[' + counter + 
	      ']" id="pval[' + counter + ']" value="" >' );
 
	newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
	}
    	  alert(msg);
     });
  });
</script>

</head>

<body>

<div align="left">

<h1>Siliconhead.in API explorer demo</h1>

<form action="index.php" method="post" name="apiexp"> 
 URL to call: <input name="urltocall" type="text" size="80" value="<?php echo($urlcall); ?>" /><br />
 Does it have POST values: <input name="postvalues" type="checkbox" value="" /> (Checked = yes, Unchecked = no)<br />
 <br />Enter POST parameter names and values:<br />
 <div id='TextBoxesGroup'>
	<div id="TextBoxDiv1">
		
	</div>
</div>
<input type='button' value='Add New Parameter' id='addButton'>
<input type='button' value='Remove Last Parameter' id='removeButton'>


 <br /><br />Response: <br />
 <textarea name="response" cols="" rows="" style="width:600px; height:300px;" readonly="readonly"><?php var_dump($response); ?></textarea>
 
 <br /><br /><input name="submit" type="submit" value="Submit" />
 
</form>

</div>



</body>


</html>
