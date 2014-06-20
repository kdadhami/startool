<?php

if (isset($usr)) {
   print($usr."<br>");
} else {
  print("user not set"."<br>");
} 

print("
 <head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
  <style type=\"text/css\">
   * {
      margin:0;
      padding:0;
      list-style:none;
     }
   body {
      font-family: Arial, Helvetica, sans-serif;
	  font-size: 11px;
	  margin:10px;
   }
   #basic-accordian{
     /*border:5px solid #EEE;*/
	padding:5px;
	width:90%;
	position:absolute;
	left:2%;
	top:0%;
	/*margin-left:-10px;
	z-index:2;
	margin-top:-10px;*/
}

.accordion_headings{
	padding:5px;
	background:#99CC00;
	color:#FFFFFF;
	border:1px solid #FFF;
	cursor:pointer;
	font-weight:bold;
}

.accordion_headings:hover{
	background:#00CCFF;
}

.accordion_child{
	padding:15px;
	background:#EEE;
}

.accordion_child a:link {
text-decoration: none;
color: #2554C7;
}

.accordion_child a:visited {
text-decoration: none;
color: #2554C7;
}

.accordion_child a:hover {
text-decoration: underline overline;
color: #2554C7;
}

.accordion_child a:active {
text-decoration: none;
color: #FF0000; /*#2554C7;*/
}

.header_highlight{
	background:#00CCFF;
}

  </style>
  <script type=\"text/javascript\" src=\"js/accordian.js\"></script>
        <!--
		<link type=\"text/css\" href=\"css/ui-lightness/jquery-ui-1.8.custom.css\" rel=\"stylesheet\" />	
		<script type=\"text/javascript\" src=\"js/jquery-1.4.2.min.js\"></script>
		<script type=\"text/javascript\" src=\"js/jquery-ui-1.8.custom.min.js\"></script>
		<script type=\"text/javascript\">
			$(function(){

  			// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
	</script>
    -->

 </head>
 <body onload=\"new Accordian('basic-accordian',5,'header_higlight');\">
  <div id=\"basic-accordian\" ><!--Parent of the Accordion-->
  <!--<div align=\"center\">Simple Accordions</div>-->
   <!--Start of each accordion item-->
   <div id=\"test-header\" class=\"accordion_headings header_higlight\" >Webmaster
   </div>
   <div id=\"test-content\">
    <div class=\"accordion_child\">
      <ul>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;globalform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Global Variables</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;usertypesform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">User Types</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;categoryscopeform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Scope Types</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;statustypesform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Status Types</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;userform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Users</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;menulevelform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Menu Levels</a>
	  </ul>
    </div>
   </div>
   <!--End of each accordion item--> 
   <!--Start of each accordion item-->
   <div id=\"test1-header\" class=\"accordion_headings\" >Backoffice
   </div>
   <div id=\"test1-content\">
    <div class=\"accordion_child\">
      <ul>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;userform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Users</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;loadpdpinfo?usr=$usr.php&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Load PDP</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;setup_pdp.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">List PDP</a>
      </ul>
    </div>
   </div>
   <!--End of each accordion item--> 
   <!--Start of each accordion item-->
   <div id=\"test2-header\" class=\"accordion_headings\" >PDP Administrator
   </div>
   <div id=\"test2-content\">
    <div class=\"accordion_child\">
      <ul>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;userform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Users</a>
       <li>&nbsp</li>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;pdptypesform2.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">PDP Types</a>	   
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;issueareasform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Departments</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;pdpstlcform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">PDP Work</a>
	   <li>&nbsp</li>	   
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;pdpcategoriesform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">PDP Scope Categories</a>
	   <li><a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;issuecategoriesform.php?usr=$usr&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">Issue Root Cause</a>
	  </ul>
    </div>
   </div>
   <!--End of each accordion item--> 
  </div><!--End of accordion parent-->
 </body>
</html>

");

?>
