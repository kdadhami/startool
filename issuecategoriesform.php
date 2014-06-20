<?php

// ----------------------------
// Author: Kashif Adhami
// Dated: November, 2010
// Note:  Categories are saved in issue_types table
// ----------------------------


// Connection
require_once("./inc/connect.php");

$querysa1 = "ALTER TABLE ".$name.".issue_surrogates ENGINE='InnoDB'" ;
$mysql_dataa1 = mysql_query($querysa1, $mysql_link) or die ("#a1 Could not query: ".mysql_error());

$querysa2 = "ALTER TABLE ".$name.".issue_types ENGINE='InnoDB'" ;
$mysql_dataa2 = mysql_query($querysa2, $mysql_link) or die ("#a2 Could not query: ".mysql_error());

$querysa3 = "ALTER TABLE ".$name.".issue_class ENGINE='InnoDB'" ;
$mysql_dataa3 = mysql_query($querysa3, $mysql_link) or die ("#a3 Could not query: ".mysql_error());


// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
$querys5 = "SELECT user FROM ".$name.".sessions
                WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)) FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($yissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================

// ==============================
// Loading Data for drop downs
// ==============================
$queryA       = "select issue_class_id,issue_class,issue_class_ind,issue_class_code 
                    from ".$name.".issue_class
                order by issue_class"; 
$mysql_dataA  = mysql_query($queryA, $mysql_link) or die ("#A Could not query: ".mysql_error());
$rowcntA      = mysql_num_rows($mysql_dataA); 
$iccnt        = 0;
//$iccnt        = $iccnt + 1;
//$ic[$iccnt]   = "&nbsp";
//$icc[$iccnt]  = "";
//$icid[$iccnt] = 0;
//print($ic[$iccnt]."-".$icc[$iccnt]."-".$icid[$iccnt]."<br>");
while($rowA   = mysql_fetch_row($mysql_dataA)) {
      $iccnt         = $iccnt + 1;
      $icid[$iccnt]  = stripslashes($rowA[0]);  
      $ic[$iccnt]    = stripslashes($rowA[1]);
      $icc[$iccnt]   = stripslashes($rowA[3]);
      //print($ic[$iccnt]."-".$icc[$iccnt]."-".$icid[$iccnt]."<br>"); 
}
// -------------------------------
$queryB       = "select report_group_id,report_group,report_group_ind,issue_class_id 
                    from ".$name.".report_groups
                order by report_group"; 
$mysql_dataB    = mysql_query($queryB, $mysql_link) or die ("#B Could not query: ".mysql_error());
$rowcntB        = mysql_num_rows($mysql_dataB); 
$rgcnt          = 0;
$rgcnt          = $rgcnt + 1;
$rgid[$rgcnt]   = 0;
$rg[$rgcnt]     = "&nbsp";
$rgicid[$rgcnt] = 0;
//print($rg[$rgcnt]."-".$rgid[$rgcnt]." - ".$rgicid[$rgcnt]."<br>");     
while($rowB   = mysql_fetch_row($mysql_dataB)) {
      $rgcnt          = $rgcnt + 1;
      $rgid[$rgcnt]   = stripslashes($rowB[0]);  
      $rg[$rgcnt]     = stripslashes($rowB[1]);
      $rgicid[$rgcnt] = stripslashes($rowB[3]);
      //print($rg[$rgcnt]."-".$rgid[$rgcnt]." - ".$rgicid[$rgcnt]."<br>");        
}
// ==============================
// Loading Data for drop downs
// ==============================



// ============================== ISSUE TYPE START ==============================
$query69               = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.issue_seq
                            from ".$name.".issue_types a, issue_class b
                           where a.issue_class_id = b.issue_class_id
                             and b.issue_class_code = 'ROT' 
                        order by a.issue_seq asc"; 
$mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
$rowcnt69              = mysql_num_rows($mysql_data69); 
$icnt                  = 0;
$icnt                  = $icnt + 1;
$iid[$icnt]            = 0;        //Issue_id
$ityp[$icnt]           = "";        //issue_type
$ityp_ind[$icnt]       = 0;
$iccd[$icnt]           = 0;  //issue_class_code
$iseq[$icnt]           = 0;
while($row69           = mysql_fetch_row($mysql_data69)) {
      $icnt            = $icnt + 1;
      $iid[$icnt]      = stripslashes($row69[0]);        //Issue_id
      $ityp[$icnt]     = stripslashes($row69[1]);        //issue_type
      $ityp_ind[$icnt] = stripslashes($row69[2]);
      $iccd[$icnt]     = trim(stripslashes($row69[3]));  //issue_class_code
      $iseq[$icnt]     = stripslashes($row69[4]);
      //print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$iseq[$icnt]." - ".$ityp[$icnt]."<br>");
}
// =============================== ISSUE TYPE END ===============================



// =======================================  FIND GRANULAR ROOT CAUSE CLASS ID
                           $queryg= "SELECT issue_class_id  
                                        FROM ".$name.".issue_class
                                       WHERE issue_class_code = 'GRT'
                           ";
                           //print($queryg);
                           $mysql_datag = mysql_query($queryg, $mysql_link) or die ("#G Could not query: ".mysql_error());
                           $rowcntg     = mysql_num_rows($mysql_datag); 
                           if ($rowcntg == 1){
                               while($rowg = mysql_fetch_row($mysql_datag)) {
                                     $uissue_class_id = stripslashes($rowg[0]);
                               }
                           }                               
// ==========================================================================



// Loading Sequence No for Issue_Sequences
$querysq      =    "select distinct issue_seq 
                      from ".$name.".issue_types 
                  order by issue_seq asc";
$mysql_datasq = mysql_query($querysq, $mysql_link) or die ("Could not query: ".mysql_error());
for ($sq=1;$sq<=999;++$sq) {
     $querysq      =    "select issue_seq 
                           from ".$name.".issue_types where issue_seq = '$sq' ";
     $mysql_datasq = mysql_query($querysq, $mysql_link) or die ("Could not query: ".mysql_error());
     $rowcntsq     = mysql_num_rows($mysql_datasq);
     if ($rowcntsq > 0){
         $xsq[$sq]  = $sq;
         $xsqi[$sq] = 1;         // highlight in yellow because the sequence is already used
     } else {
         $xsq[$sq]  = $sq;       // opposite of above 
         $xsqi[$sq] = 0;
     }    
}


if ($submit == "Submit") {
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_issue_type[$key]            = addslashes(strtoupper($new_issue_type[$key]));
	        $new_issue_class_id[$key]        = addslashes($new_issue_class_id[$key]);
	        $new_report_group_id[$key]       = addslashes($new_report_group_id[$key]);
	        $new_issue_seq[$key]             = addslashes($new_issue_seq[$key]);
	        $new_parent_issue_type_id[$key]  = addslashes($new_parent_issue_type_id[$key]);

	        //if (empty($new_issue_seq[$key]) or !is_integer($new_issue_seq[$key])) {
	        //   $new_issue_seq[$key] = 0;
	        //}

             $queryh = "SELECT UPPER(trim(a.issue_type)),a.issue_class_id,b.issue_class 
                          FROM ".$name.".issue_types a, ".$name.".issue_class b
                         WHERE (
                               UPPER(trim(a.issue_type)) = '$new_issue_type[$key]'
                               AND 
                               a.issue_class_id          = '$new_issue_class_id[$key]'
                               )
                           AND a.issue_class_id = b.issue_class_id
                       ";
             //print($queryh);
             $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#1 Could not query: ".mysql_error());
             $rowcnth = mysql_num_rows($mysql_datah);

             if ($rowcnth > 0) {
                 while($rowh = mysql_fetch_row($mysql_datah)) {
	                   $uissue_class = strtoupper(stripslashes($rowh[2]));
	             }
                 $insert_ind = 1;
             } else {
                 $insert_ind = 0;
             }

             if ($insert_ind == 0) {
                 $query ="INSERT into ".$name.".issue_types(issue_type,issue_type_ind,issue_class_id,report_group_id,issue_seq,parent_issue_type_id)
                          VALUES('$new_issue_type[$key]',1,'$new_issue_class_id[$key]',
                                   '$new_report_group_id[$key]','$new_issue_seq[$key]','$new_parent_issue_type_id[$key]')";
                 //print($query);
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
                 $yissue_type_id  = mysql_insert_id();
                 // -----------------------------------------------------------------
                 //$queryh1= "SELECT a.issue_type,a.issue_class_id,a.report_group_id 
                 //             FROM ".$name.".issue_types a, ".$name.".issue_class b
                 //            WHERE a.issue_type_id = '$yissue_type_id'
                 //              AND a.issue_class_id = b.issue_class_id
                 //              AND b.issue_class_code = 'ROT'
                 //";
                 //print($queryh1);
                 //$mysql_datah1 = mysql_query($queryh1, $mysql_link) or die ("#N1.75 Could not query: ".mysql_error());
                 //$rowcnth1 = mysql_num_rows($mysql_datah1);
                 //if ($rowcnth1 == 1){
                 //    while($rowh1 = mysql_fetch_row($mysql_datah1)) {
                 //          $yissue_type      = strtoupper(stripslashes($rowh1[0]));     
	             //          $yissue_class_id  = strtoupper(stripslashes($rowh1[1]));
	             //          $yreport_group_id = strtoupper(stripslashes($rowh1[2]));
                 //          $queryh2= "SELECT max(issue_seq)+1  
                 //                       FROM ".$name.".issue_types
                 //                      WHERE issue_type_id = '$yissue_type_id'
                 //          ";
                 //          //print($queryh2);
                 //          $mysql_datah2 = mysql_query($queryh2, $mysql_link) or die ("#N1.76 Could not query: ".mysql_error());
                 //          $rowcnth2 = mysql_num_rows($mysql_datah2);
                 //          if ($rowcnth2 == 1){
                 //              while($rowh2 = mysql_fetch_row($mysql_datah2)) {
                 //                    $yissue_seq = strtoupper(stripslashes($rowh2[0]));
                 //              }
                 //              $queryh3 ="INSERT into ".$name.".issue_types(issue_type,issue_type_ind,issue_class_id,report_group_id,issue_seq,parent_issue_type_id)
                 //                         VALUES('NO GRANULAR ROOT CAUSE',1,'$uissue_class_id','$yreport_group_id','$yissue_seq','$yissue_type_id')";
                 //              //print($queryh3);
                 //              $mysql_datah3 = mysql_query($queryh3, $mysql_link) or die ("#N1.77 Could not query: ".mysql_error());
                 //          }                               
                 //    }         
                 //} 
                 // -----------------------------------------------------------------
            } else {
               echo "<script type=\"text/javascript\">window.alert(\"Issue Cause '$new_issue_type[$key]' for '$uissue_class' already exists\")</script>";
            }
    }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]                    = addslashes($xid[$key]);
	    $xissue_type[$key]            = addslashes(strtoupper($xissue_type[$key]));
	    $xissue_type_ind[$key]        = addslashes($xissue_type_ind[$key]);
	    $xissue_class_id[$key]        = addslashes($xissue_class_id[$key]);
	    $xreport_group_id[$key]       = addslashes($xreport_group_id[$key]);
	    $xissue_seq[$key]             = addslashes($xissue_seq[$key]);
	    $xparent_issue_type_id[$key]  = addslashes($xparent_issue_type_id[$key]);
	    
        //if (empty($xissue_seq[$key])) {
	    //    $xissue_seq[$key]   = 0;
	    //} else {
        //    $xissue_seq[$key]   = addslashes($xissue_seq[$key]);
	    //}

  		$query = "UPDATE ".$name.".issue_types
		             SET issue_type           = '$xissue_type[$key]',
		                 issue_class_id       = '$xissue_class_id[$key]',
		                 report_group_id      = '$xreport_group_id[$key]',
		                 issue_seq            = '$xissue_seq[$key]',
                         issue_type_ind       = 1,
                         parent_issue_type_id = '$xparent_issue_type_id[$key]' 
		           WHERE issue_type_id   = '$key'";
		//print($query);           
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
		         // -----------------------------------------------------------------
                 //$yissue_type_id  = $key;
                 //$queryh1= "SELECT a.issue_type,a.issue_class_id,a.report_group_id 
                 //             FROM ".$name.".issue_types a, ".$name.".issue_class b
                 //            WHERE a.issue_type_id = '$yissue_type_id'
                 //              AND a.issue_class_id = b.issue_class_id
                 //              AND b.issue_class_code = 'ROT'
                 //";
                 //print($queryh1);
                 //$mysql_datah1 = mysql_query($queryh1, $mysql_link) or die ("#U1.75 Could not query: ".mysql_error());
                 //$rowcnth1 = mysql_num_rows($mysql_datah1);
                 //if ($rowcnth1 == 1){
                 //    while($rowh1 = mysql_fetch_row($mysql_datah1)) {
                 //          $yissue_type      = strtoupper(stripslashes($rowh1[0]));
	             //          $yissue_class_id  = strtoupper(stripslashes($rowh1[1]));
	             //          $yreport_group_id = strtoupper(stripslashes($rowh1[2]));
                 //          $queryh2= "SELECT max(issue_seq)+1  
                 //                       FROM ".$name.".issue_types
                 //                      WHERE issue_type_id = '$yissue_type_id'
                 //          ";
                 //          //print($queryh1);
                 //         $mysql_datah2 = mysql_query($queryh2, $mysql_link) or die ("#U1.76 Could not query: ".mysql_error());
                 //          $rowcnth2 = mysql_num_rows($mysql_datah2);
                 //          if ($rowcnth2 == 1){
                 //              while($rowh2 = mysql_fetch_row($mysql_datah2)) {
                 //                    $yissue_seq = strtoupper(stripslashes($rowh2[0]));
                 //              }
  		         //              $queryh3 = "UPDATE ".$name.".issue_types
		         //                             SET issue_type           = 'NO GRANULAR ROOT CAUSE',
		         //                                 issue_class_id       = '$uissue_class_id',
		         //                                 report_group_id      = '$yreport_group_id',
		         //                                 issue_seq            = '$yissue_seq',
                 //                                 issue_type_ind       = 1,
                 //                                 parent_issue_type_id = '$yissue_type_id' 
		         //                           WHERE issue_type_id   = '$key'";
                 //              //print($queryh3);
                 //              $mysql_datah3 = mysql_query($queryh3, $mysql_link) or die ("#U1.77 Could not query: ".mysql_error());
                 //          }                               
                 //    }         
                 //}
                 // ----------------------------------------------------------------- 
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".issue_types
		             SET issue_type_ind  = 1
		           WHERE issue_type_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".issue_types
		             SET issue_type_ind  = 0
		           WHERE issue_type_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".issue_types WHERE issue_type_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link) or die ("#D Could not query: ".mysql_error());
        // 
		$queryx = "DELETE FROM ".$name.".issue_types WHERE parent_issue_type_id = '$key' ";
		$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#D.1 Could not query: ".mysql_error());
	    }
    }
}
$captn = "Issue Causes";
// Start of HTMl
print("<html>
        <head>
          <!--<link rel=\"stylesheet\" type=\"text/css\" href=\"css/common.css\">-->
           <style>
             body { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px; 
                  }
               td { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                    color: #FFFFFF; 
                  }
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
           select { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }                   
           #content
                  { top:0%;
                  }
           </style> 
        </head>
        <body>
           <form method=\"post\" action=\"./issuecategoriesform.php\">
            <table border='0' align=\"center\" width=\"100%\" >
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">ID</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Sequence</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 100px;\"><font color=\"#330099\">Cause Categories</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Cause Type</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Parent Root Cause</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Report Group</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
");

$query = "select a.issue_type_id,a.issue_type,a.issue_type_ind,a.issue_class_id,a.report_group_id,a.issue_seq,b.parent_allowed,
                 a.parent_issue_type_id,b.issue_class_code  
            from ".$name.".issue_types a,".$name.".issue_class b 
           where a.issue_class_id = b.issue_class_id 
        order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc";
//print($query);
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid               = stripslashes($row[0]);
    $xissue_type       = stripslashes($row[1]);
    $xissue_type_ind   = stripslashes($row[2]);
    $xissue_class_id   = stripslashes($row[3]);
    $xreport_group_id  = stripslashes($row[4]);
    $xissue_seq        = stripslashes($row[5]);
    $xparent_allowed   = stripslashes($row[6]);
    $xparent_type_id   = stripslashes($row[7]);
    $xissue_class_cd   = stripslashes($row[8]);

    //$queryx = "select c.issue_type_id  
    //            from ".$name.".issue_types a,".$name.".issue_class b, ".$name.".issue_types c 
    //           where a.issue_class_id = b.issue_class_id 
    //             and a.parent_issue_type_id = c.issue_type_id    
    //        order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc";
    //$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
    //$rowcntx = mysql_num_rows($mysql_datax);
    
    $xparent_type_id   = stripslashes($row[7]);
	
    $query1 = "select issue_type_id 
                 from ".$name.".issue_surrogates
                where issue_type_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xissue_type_ind == 1) {

	      print("
              <tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                 <select name=\"xissue_seq[$xid]\">
	      ");
          for ($sq1=1;$sq1<=$sq;++$sq1) {
               if ($xsq[$sq1] == $xissue_seq) {
                   print(" <option selected value=\"$xsq[$sq1]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\">$xsq[$sq1]</option> ");
               } else {
                   if ($xsqi[$sq1] == 1){
                           print(" <option value=\"$xsq[$sq1]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\">$xsq[$sq1]</option> "); 
                   } else {
                           print(" <option value=\"$xsq[$sq1]\">$xsq[$sq1]</option> ");
                   }
               }
          }
          print(" </select>
                 </td>                
	             <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\" style=\"width: 100px;\">
                  <input type=\"text\" name=\"xissue_type[$xid]\" value=\"$xissue_type\" size=\"40\" maxlength=\"50\">
	             </td>
	      ");
          print("      
                 <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <select name=\"xissue_class_id[$xid]\">
          ");
          for ($c=1;$c<=$iccnt; ++$c) {
                   if ($icid[$c] == $xissue_class_id) {
                       print(" <option selected value=\"$icid[$c]\">$ic[$c]</option> ");
                   } else {
                       print(" <option value=\"$icid[$c]\">$ic[$c]</option> ");
                   }
          }
          print(" </select>
                 </td>
          ");
          if ($xissue_class_cd == "GRT"){
              //if ($xparent_allowed == 1){
               print("                           
                     <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                      <select name=\"xparent_issue_type_id[$xid]\">
              ");
              for ($i=1;$i<=$icnt; ++$i) {
                   if ($iid[$i] == $xparent_type_id) {
                        print(" <option selected value=\"$iid[$i]\">$ityp[$i]</option> ");
                   } else {
                       print(" <option value=\"$iid[$i]\">$ityp[$i]</option> ");
                   }
              }
              print(" </select>
                     </td>                    
              ");
          } else {
	         print("<td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                     <a>&nbsp</a>
                      <input type=\"hidden\" name=\"xparent_issue_type_id[$xid]\" value=\"$xparent_type_id\">
	                </td>
             "); 
          }
          if ($xissue_class_cd == "CNT"){
              print("<td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                      <select name=\"xreport_group_id[$xid]\">
              ");
              for ($r=1;$r<=$rgcnt; ++$r) {
                //if ($rgicid[$r] == $xissue_class_id){
                   if (($rgid[$r] == $xreport_group_id) && ($rgicid[$r] == $xissue_class_id)) {
                       print(" <option selected value=\"$rgid[$r]\">$rg[$r]</option> ");
                   } else {
                       if (($rgid[$r] <> $xreport_group_id) && ($rgicid[$r] == $xissue_class_id)){
                           print(" <option value=\"$rgid[$r]\">$rg[$r]</option> ");
                       }
                       if ($rgid[$r] == 0){
                           print(" <option selected value=\"0\">&nbsp</option> ");    
                       }
                   }
                //}   
              }
              print(" </select>
                     </td>
              ");
          } else {
	          print("<td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                      <a>&nbsp</a>
                      <input type=\"hidden\" name=\"xreport_group_id[$xid]\" value=\"$xreport_group_id\">
	                 </td>
              "); 
          }
	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    </td>
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                     print("
                             <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 } 
          } else {
             print("
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                    ");
          }
          print("
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	          </tr>
	      ");
    
    } else {

	   print("
              <tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                 $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                  $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\">
                  $xissue_seq 
                 </font>
                </td>    
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\"> 
                  $xissue_type
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\">
	      ");
          for ($c=1;$c<=$iccnt; ++$c) {
               if ($icid[$c] == $xissue_class_id) {
                   print("$ic[$c]");
               }
          }
          print(" </font>
                 </td>
          ");
          //if ($xparent_allowed == 1){
          print("
                 <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <font color=\"#000000\">
          ");
          for ($i=1;$i<=$icnt; ++$i) {
               if ($iid[$i] == $xparent_type_id) {
                   print("$ityp[$i]"); 
               }
          }
          print(" </font>
                 </td>
          ");
          print("<td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <font color=\"#000000\">
          ");
          for ($r=1;$r<=$rgcnt; ++$r) {
               if ($rgid[$r] == $xreport_group_id) {
                   print("$rg[$r]");
               }
          }
          print(" </font>
                 </td>                    
          ");
	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    </td> 
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                        <input type=\"checkbox\" name=\"active[$xid]\" value=\"Active\">
                    </td>
                  ");
                 if (($rowcnt1 == 0) && ($rowcnt2 == 0)) {
                     $delcnt = $delcnt + 1;
                      print("
                             <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                      ");
                 } else {
                           print(" <td align=\"center\"  valign=\"middle\" bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 }
                }
          else {
                 print("<td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                        </td>
                  ");
                }
        print("
	            <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
	          </tr>
	     ");
    
    }
}

// Display blank entry for a new record to be inserted
if ($submit == "Add") {
    for ($x=1;$x<=$num_records; ++$x) {
		 print("
                <tr>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
		          </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
		          </td>		          
   	              <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <select name=\"new_issue_seq[$x]\">
	     ");
         for ($sq1=1;$sq1<=$sq;++$sq1) {
               if ($xsqi[$sq1] == 1){
                   print(" <option value=\"$xsq[$sq1]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\">$xsq[$sq1]</option> "); 
               } else {
                   print(" <option value=\"$xsq[$sq1]\">$xsq[$sq1]</option> ");
               }
               //print(" <option value=\"$xsq[$sq1]\">$xsq[$sq1]</option> ");
         }
         print(" </select>
                 </td>                
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\" style=\"width: 100px;\">
                     <input type=\"text\" name=\"new_issue_type[$x]\" value=\"$new_issue_type[$x]\" size=\"40\" maxlength=\"50\">
		          </td>
		 ");        
		 print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\"> 
                   <select name=\"new_issue_class_id[$x]\">
	     ");
         for ($c=1;$c<=$iccnt; ++$c) {
              print(" <option value=\"$icid[$c]\">$ic[$c]</option> ");
         }
         print("  </select>
                 </td>
                 <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <input type=\"hidden\" name=\"new_parent_issue_type_id[$x]\" value=\"0\">
   	             </td>
                 <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <input type=\"hidden\" name=\"new_report_group_id[$x]\" value=\"0\">
   	             </td>
         ");        
         //print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
         //         <select name=\"new_parent_issue_type_id[$x]\">
         //");
         //for ($i=1;$i<=$icnt; ++$i) {
         //      //if ($iid[$i] == $new_parent_issue_type_id) {
         //      //    print(" <option selected value=\"$iid[$i]\">$ityp[$i]</option> ");
         //      //} else {
         //          print(" <option value=\"$iid[$i]\">$ityp[$i]</option> ");
         //      //}
         //}
         //print(" </select>
         //        </td>                    
         //");
         //print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
         //         <select name=\"new_report_group_id[$x]\">
         //");
         //for ($r=1;$r<=$rgcnt; ++$r) {
         //     print(" <option value=\"$rgid[$r]\">$rg[$r]</option> ");
         //}
         print("  <!-- </select>
                  </td>-->                    
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>                  
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
		        </tr>
		      ");
	}
}

// Display options
print("
            </table>

            <table border='0' align=\"center\">
                <tr>
                 <td>
                   <br />
                   <!--<input type=\"submit\" name=\"submit\" value=\"Update\">
                   <input type=\"submit\" name=\"submit\" value=\"Inactive\">
                   <input type=\"submit\" name=\"submit\" value=\"Active\">-->
     ");

if ($delcnt ==0) {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
} else {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
}

print("            <input type=\"submit\" name=\"submit\" value=\"Submit\">
     ");

// Select no. of new inserts
if ($submit != "Add") {
    print("
                   <input type=\"submit\" name=\"submit\" value=\"Add\">
                    <select name =\"num_records\">
                      <option value=\"1\">1</optons>
                      <option value=\"2\">2</optons>
                      <option value=\"3\">3</optons>
                      <option value=\"4\">4</optons>
                      <option value=\"5\">5</optons>
                    </select>
          ");
}

// Display blank entries for a new records
//if ($submit == "Add") {
//    print("
//                   <input type=\"submit\" name=\"submit\" value=\"Insert\">
//          ");
//}

// End of HTML
print("
                   <!--<input type=\"submit\" name=\"submit\" value=\"Refresh\">-->
                 </td>
                </tr>
            </table>
           </form>
          </body>
         </html>
");
mysql_close($mysql_link);     
?>
