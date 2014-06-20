<?php
// Connection
require_once("./inc/connect.php");
set_time_limit(0);

print("<html>
        <head>
         <style>
             body    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px; 
                     }
               td    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                       color: #FFFFFF;
                       border: 1px solid #CCCCCC; 
                       /*border-style:solid;
                       border-color:#CCCCCC;*/
                     }
         textarea    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }        
          /*caption    { background:#FFC000; color:#0000FF; font-size:1em;}*/
             caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }
           select    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }                   
           #content
                     { top:0%;
                       width: 100%; height: 100%; background: #FFFFF0;
                       /*border: 1px solid; border-color:#BDBDBD;*/
                     }
           /*#contentb { top:0%;
                       width: 100%; height: 1%;*/ /*background: #CEE3F6;*/
                     /*}
           #contentc { top:0%;
                       width: 100%; height: 34%;*/ /*background: #CEF6E3;*/
                       /*border: 1px solid; border-color:#BDBDBD;
                     }*/
           #content a:link 
                     { text-decoration: none;
                       color: #2554C7;
                     }
           #content a:visited 
                     {
                       text-decoration: none;
                       color: #2554C7;
                     }
           #content a:hover 
                     { text-decoration: underline overline;
                       color: #2554C7;
                     }
           #content a:active 
                     {
                       text-decoration: none;
                       color: #2554C7;
                     }
            a:link   {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
            a:visited 
                     {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
            a:hover  {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: underline overline;
                       color: #FF0000;
                     }
            a:active {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
         </style>       
         <script type=\"text/javascript\">
                 function PopupCenter(pageURL, title,w,h)
                  {
                    var left = (screen.width/2)-(w/2);
                    var top = (screen.height/2)-(h/2);
                    var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                  }
         </script>
        </head>
        <body>
");  
       // Find out PDP_ID for given PDP
       $query78      = "select pdp_id,pdp_desc 
                          from ".$name.".pdp
                         where pdp_period_id <> 0";     //pdp_desc = '2010-0556'
       $mysql_data78 = mysql_query($query78, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt78     = mysql_num_rows($mysql_data78);
       $pdpno        = 0;
       while($row78 = mysql_fetch_row($mysql_data78)) {
             $pdpno     = $pdpno + 1;
             $xid       = stripslashes($row78[0]);
             $xpdp_desc = stripslashes($row78[1]);
       //} 

       // ================================== INITIALIZATION START ====================================
       $query79      = "select issue_type_id,issue_type,issue_type_ind 
                          from ".$name.".issue_types
                      order by issue_type"; 
       $mysql_data79 = mysql_query($query79, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt79     = mysql_num_rows($mysql_data79); 
       $icnt         = 0;
       $tcnt         = array();
       while($row79 = mysql_fetch_row($mysql_data79)) {
             $icnt         = $icnt + 1;
             $iid[$icnt]   = stripslashes($row79[0]);  //Issue_id
             $ityp[$icnt]  = stripslashes($row79[1]);  //issue_type
             $tcnt[$icnt]  = 0;
       }
       // ----->>>>>>>> print("PDP ID: ".$xid."<br> PDP Description: ".$xpdp_desc."<br><br>");
       // ================================== INITIALIZATION END ======================================
       
       // ================================== LOAD ROOT CAUSE START ====================================
       // $pi indicates a given issue in the pdp
       // $pu indicates a given update in an issue
       // piid[$picnt] indicates issue_id of an issue in a given pdp
       // pidesc[$pcnt] indicates description of the issue
       // pimax[$picnt] indicates total of master and update rows for a given issue
       // puid[$picnt][$pucnt] indicates issue_history_id of a given update for a given issue in a pdp
       // pudesc[$picnt][$pucnt] indicates description of a given update for a given issue in a pdp 
       // Declare Arrays
       // stores root cause per issue and update (i.e. A 3 dimensional array [picnt][i][lines]
       // [picnt] = Issue no. in a given PDP
       // [i] = seq in an absolute value icnt indicates total issues types (i.e. root causes)
       // [lines] indicates sum of .....
       //        master rows from issues table         (always 1, issue_surrogate.surrogate_type = 0) 
       //                   + 
       //        updates rows from issue_history table (can be 1 or many, issue_surrogate.surrogate_type = 1) 
       $pi = array();
       // Second dimension is known from Initialization Section i.e. ($icnt)         
       // Know the 1st dimension i.e. $picnt (No. of issues in a given PDP)
       $query80      = "select issue_id,issue_desc 
                          from ".$name.".issues
                         where pdp_id = '$xid' 
                      order by issue_id";
       // ----->>>>>>>> print("SQL: Get all Issues for this PDP<br>"."$query80"."<br>");               
       $mysql_data80 = mysql_query($query80, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt80     = mysql_num_rows($mysql_data80);
       $picnt        = 0;
       while($row80  = mysql_fetch_row($mysql_data80)) {
             $picnt          = $picnt + 1;           
             $piid[$picnt]   = stripslashes($row80[0]);  // PDP Issue_id found for this given PDP (A)
             $pidesc[$picnt] = stripslashes($row80[1]);  // Issue Description
             $piidx          = $piid[$picnt];            // Move (A) to a non-array variable
             // ----->>>>>>>> print("<br>"."-----------------------------------------------------------------------------------");
             // ----->>>>>>>> print("<br> Issue No: ".$picnt."<br> Issue ID: ".$piid[$picnt]."<br> Issue Description: ".$pidesc[$picnt]."<br><br>");
             // Load Master Record
             $line           = 1;
             $query91        = "select a.issue_type_id,b.issue_type 
                                  from ".$name.".issue_surrogates a, issue_types b 
                                 where a.issue_surrogate_id = $piid[$picnt]
                                   and a.surrogate_type = 0
                                   and a.issue_type_id = b.issue_type_id
                               ";
             // ----->>>>>>>> print("SQL: Get all Root Cause logged in Master Record for issue ".$piid[$picnt]."<br>"."$query91"."<br><br>");                   
             $mysql_data91   = mysql_query($query91, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt91       = mysql_num_rows($mysql_data91);
             $pitcnt         = 0;
             while($row91  = mysql_fetch_row($mysql_data91)) {
                   $pitcnt         = $pitcnt + 1;
                   $pitid[$pitcnt] = stripslashes($row91[0]);
                   $pityp[$pitcnt] = stripslashes($row91[1]);
             }
             // Know how many updates has happened on this issue 
             $query57      = "select issue_history_id,issue_note 
                                from ".$name.".issue_history  
                               where issue_id = $piid[$picnt]";
             $mysql_data57 = mysql_query($query57, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt57     = mysql_num_rows($mysql_data57);
             // ----->>>>>>>> print("SQL: Get all Updates for issue ".$piid[$picnt]."<br>"."$query57"."<br>");
             //if ($rowcnt57 == 0){
             //} else {
             $pimax[$picnt] = $line + $rowcnt57;  // Record that will be used in Analysis, Master line if no updates else the last update line
             $piu           = $pimax[$picnt] - 1; // No. of updates
             $pim           = $pimax[$picnt];     // Same as $pimax[$picnt] 
             //}                   
             // ----->>>>>>>> print("<br>"."Master Record"."<br> Line = ".$line);
             // ----->>>>>>>> print("<br>"."No. of Root Casuses Found = ".$pitcnt);
             // ----->>>>>>>> print("<br>"."[picnt]-[line]-[i]");
             for ($i=1;$i<=$icnt ; ++$i) {
                  $pi[$picnt][$line][$i] = 0;
                  for ($pit=1;$pit<=$pitcnt ; ++$pit) {
                       if ($ityp[$i] == $pityp[$pit]){
                           $pi[$picnt][$line][$i] = 1;
                           if ($line == $pimax[$picnt]) {
                               $totl     = $pi[$picnt][$line][$i];
                               $tcnt[$i] = $tcnt[$i] + 1;
                           } 
                       } else {
                           //$pi[$picnt][$i][$line] = 0;    
                       }
                  } 
                  $ypi = $pi[$picnt][$line][$i];
                  // ----->>>>>>>> print("<br>".$picnt." - ".$line." - ".$i." - Value = ".$ypi." - ".$ityp[$i]);
             }             
             $pucnt = 0;   //counter for no. of updates for the given issue
             while($row57  = mysql_fetch_row($mysql_data57)) {
                   $pucnt                    = $pucnt + 1;
                   $puid[$picnt][$pucnt+1]     = stripslashes($row57[0]);
                   $pudesc[$picnt][$pucnt+1]   = stripslashes($row57[1]);
             }
             // ----->>>>>>>> print("<br><br>"."Updates Found "." = ".$piu."<br><br>");
             // pu indicates no. of updates found
             // putcnt indicates no. of issue types (root cause) for each update i.e. issue_history_id  
             for ($pu=1;$pu<=$pucnt ; ++$pu) {
                  //$pu             = $pu + 1;
                  $line           = $line + 1;
                  $yid            = $puid[$picnt][$pu+1]; 
                  $query81        = "select a.issue_type_id,b.issue_type 
                                       from ".$name.".issue_surrogates a, issue_types b 
                                      where a.issue_surrogate_id = '$yid' 
                                        and a.surrogate_type = 1
                                        and a.issue_type_id = b.issue_type_id
                                    ";
                  // ----->>>>>>>> print("SQL: Get all Root Cause logged in for this Update Record ".$yid."<br>".$query81."<br><br>");                  
                  $mysql_data81   = mysql_query($query81, $mysql_link) or die ("Could not query: ".mysql_error());
                  $rowcnt81       = mysql_num_rows($mysql_data81);
                  $putcnt         = 0;
                  while($row81  = mysql_fetch_row($mysql_data81)) {
                        $putcnt         = $putcnt + 1;
                        $putid[$picnt][$putcnt] = stripslashes($row81[0]);
                        $putyp[$picnt][$putcnt] = stripslashes($row81[1]);
                  }
                  $w = $pu + 1;
                  // ----->>>>>>>> print("Update No: ".$pu."<br> Line = ".$w);    //$line
                  // ----->>>>>>>> print("<br> Issue History ID: ".$puid[$picnt][$pu+1]);
                  // ----->>>>>>>> print("<br>"."No. of Root Casuses Found = ".$putcnt);
                  // ----->>>>>>>> print("<br>"."[picnt]-[line]-[i]");
                  for ($i=1;$i<=$icnt ; ++$i) {
                       $pi[$picnt][$line][$i] = 0;
                       for ($put=1;$put<=$putcnt ; ++$put) { 
                            if ($ityp[$i] == $putyp[$picnt][$put]){
                                $pi[$picnt][$line][$i] = 1;
                                if ($line == $pimax[$picnt]) {
                                    $totl     = $pi[$picnt][$line][$i];
                                    $tcnt[$i] = $tcnt[$i] + 1;
                                }
                            } else {
                            }
                       }
                       $ypi = $pi[$picnt][$line][$i];
                       // ----->>>>>>>> print("<br>".$picnt." - ".$i." - ".$line." - Value = ".$ypi." - ".$ityp[$i]);
                  }
                  // ----->>>>>>>> print("<br><br>");
             }                   
       }
       // ----->>>>>>>> print("========================================================<br>");
       for ($i=1;$i<=$icnt ; ++$i) {
            $ytotl = $tcnt[$i];
            $stotl = $stotl + $tcnt[$i];
            if ($ytotl <= 9) {
                if ($i <= 9) {
                    // ----->>>>>>>> print("0".$i." = "."0".$ytotl." - ".$ityp[$i]."<br>");
                } else {
                    // ----->>>>>>>> print($i." = "."0".$ytotl." - ".$ityp[$i]."<br>"); 
                }
            } else {
                if ($i <= 9) {
                    // ----->>>>>>>> print("0".$i." = ".$ytotl." - ".$ityp[$i]."<br>");
                } else {
                    // ----->>>>>>>> print($i." = ".$ytotl." - ".$ityp[$i]."<br>"); 
                }
            }
       }
       // ----->>>>>>>> print("<br> Total: ".$stotl."<br>");
       // ----->>>>>>>> print("========================================================<br>");
       // ================================== LOAD ROOT CAUSE END ======================================

       // ================================== HEADING START ===========================================

       print("
              <table border='1' align=\"center\" width=\"100%\" style=\"border: 1px solid #CCCCCC; border-color:#CCCCCC; background-color: #FFFFFF\">
               <tr>
                <td bgcolor=\"#CCCC99\" align=\"center\" valign=\"middle\" style=\"width:30%;\">
                 <font color=\"#330099\">
                  Issue No
                 </font>
                </td>
                <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width:70%;\">
                 <font color=\"#330099\">
                  $pdpno
                 </font>
                </td>
               </tr>
               <tr>
                <td bgcolor=\"#CCCC99\" align=\"center\" valign=\"middle\" style=\"width:30%;\">
                 <font color=\"#330099\">
                  PDP
                 </font>
                </td>
                <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width:70%;\">
                 <font color=\"#330099\">
                  $xpdp_desc
                 </font>
                </td>
               </tr>
               <tr>
                <td bgcolor=\"#CCCC99\" align=\"center\" valign=\"middle\" style=\"width:30%;\">
                 <font color=\"#330099\">
                  ID
                 </font>
                </td>
                <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width:70%;\">
                 <font color=\"#330099\">
                  $xid
                 </font>
                </td>
               </tr>
              </table>
              <table border='1' align=\"center\" width=\"100%\" style=\"border: 1px solid #CCCCCC; border-color:#CCCCCC; background-color: #FFFFFF\">
               <tr>
                <td colspan=\"4\" bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"width: 300px;\">
                 <font color=\"#330099\">
                  Issues Types
                 </font>
                </td> 
       ");
       for ($i=1;$i<=$icnt ; ++$i) {
            print(" <td rowspan=\"2\" bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                     <font color=\"#330099\">
                      $ityp[$i]
                     </font>
                    </td> 
            ");                
       }
       print("</tr>
              <tr>
               <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 Issue No
                </font>
               </td>
               <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 ID
                </font>
               </td>
               <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 150px;\">
                <font color=\"#330099\">
                 Issues and Updates
                </font>
               </td>
               <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 M/U
                </font>
               </td>
              </tr> 
       ");
       // ================================== HEADING END ==============================================

       // ================================== DISPLAY DETAIL RESULTS ===================================
       // display PDP-Wide Root Cause weighted average
       print ("<tr> 
                <td bgcolor=\"#FFFFCC\" colspan=\"4\" align=\"right\" valign=\"middle\">
                 <font color=\"#330099\">
                  Weighted Average or each Root Cause
                 </font>
                </td>
       ");
       for ($i=1;$i<=$icnt; ++$i) {
            if ($stotl == 0) {
                $prtotl = 0;
            } else {              
                $prtotl = round(($tcnt[$i] / $stotl) * 100,2);
            }
            print("
                   <td bgcolor=\"#FFFFCC\" bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\">
                    <font color=\"#330099\">
                     $prtotl%
                    </font>
                   </td> 
            ");
       }
       //display PDP-wide Root Cause totals
       print ("</tr>
               <tr> 
                <td bgcolor=\"#99FF99\" colspan=\"4\" align=\"right\" valign=\"middle\">
                 <font color=\"#330099\">
                  Total (Sum of Yellow in column)
                 </font>
                </td>
       ");
       for ($i=1;$i<=$icnt; ++$i) {             // loop through totals 
            $ytotl = $tcnt[$i];
            print("
                   <td bgcolor=\"#99FF99\" bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\">
                    <font color=\"#330099\">
                     $tcnt[$i]
                    </font>
                   </td> 
            ");
       }
       // display PDP-Wide per issue display of root cause selected
       print("</tr>");
       $blnkline = 4 + $icnt;       
       for ($p=1;$p<=$picnt ; ++$p) {
            print("<!--<tr>
                    <td colspan=\"$blnkline\" bgcolor=\"#99FF99\" align=\"center\" valign=\"middle\" style=\"height: 5px;\">
                     <font color=\"#330099\">
                     </font>
                    </td>                      
                   </tr>-->
                   <tr>
                    <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                     <font color=\"#330099\">
                      $p
                     </font>
                    </td> 
                    <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                     <font color=\"#330099\">
                      $piid[$p]
                     </font>
                    </td>
                    <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\"  valign=\"middle\" style=\"width: 150px;\">
                     <font color=\"#330099\">
                      $pidesc[$p]
                     </font>
                    </td>                                        
                    <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                     <font color=\"#330099\">
                      M
                     </font>
                    </td> 
            ");            
            for ($l=1;$l<=$pimax[$p] ; ++$l) {
                 //if ($l == $pimax[$p]){
                 //    $colr = "#FFFF00";
                 //} else {
                 //    $colr = "#FFFFFF";
                 //}
                 if ($l <> 1) {
                     $uuid   = $puid[$p][$l];
                     $uudesc = $pudesc[$p][$l]; 
                     print("<tr>
                             <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #FF0000;\">
                              <font color=\"#330099\">
                              </font>
                             </td> 
                             <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #FF0000;\">
                              <font color=\"#330099\">
                               $uuid
                              </font>
                             </td>
                             <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\"  valign=\"middle\" style=\"width: 150px; border: 1px solid #FF0000;\">
                              <font color=\"#330099\">
                               $uudesc
                              </font>
                             </td>                                        
                             <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #FF0000;\">
                              <font color=\"#330099\">
                               U
                              </font>
                             </td> 
                     ");                           
                 }
                 for ($i=1;$i<=$icnt ; ++$i) {
                      $uval      = $pi[$p][$l][$i];
                      //$vval[$i]  = $uval + $vval[$i];
                      //$uvalx[$i] = 0;
                      if ($uval == 0) {
                          //$uvalx[$p][$i] = " ";
                          $uvalx = "&nbsp";
                          $colr = "#FFFFFF";
                      } else {
                          //$uvalx = "X";
                          if ($l == $pimax[$p]){
                              $uval      = 1;                 //---->>>> supressing display on number
                              $vval[$i]  = $uval + $vval[$i]; //---->>>> supressing display on number
                              $uvalx = $vval[$i];             //---->>>> supressing display on number
                              //$uvalx = "&nbsp";
                              $colr  = "#FFFF00";
                          } else {
                              $uvalx = "&nbsp";
                              $colr  = "#E8E8E8";
                          }
                      }
                      //$vval = $uvalx[$p][$i];
                      if ($l == 1){
                          $colrx = "#CCCCCC";
                      } else {
                          $colrx = "#FF0000"; 
                      }
                      print("
                             <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\" background-color: $colr; width: 50px; border: 1px solid $colrx;\">
                              <font color=\"#330099\">
                               $uvalx
                              </font>
                             </td>                       
                      ");
                 }
                 print("</tr>");
            }
            print("</tr>");
       }
       // =============================================================================================
       unset($iid,$ityp,$tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval,$ytotl,$stotl,$rtotl);
       print(" <!--</tr>-->
              </table>
              <br />
              <br />
       ");       
       }
       print(" <!--</tr>
              </table>-->
              <br />
             </body>
            </html>
       ");
       //unset($iid,$ityp,$tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval);
       //unset($ityp);
       //var_dump($iid,$ityp,$tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval);    //can dump the array or variable contents        
       mysql_close($mysql_link);
?>        
