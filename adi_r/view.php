<?php
/*
 * Sports Physical Form
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://opensource.org/licenses/gpl-license.php>.
 *
 * @package   OpenEMR
 * @author    Jason Morrill
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @link      http://www.open-emr.org
 */


include_once("../../globals.php");
include_once("$srcdir/api.inc");

/** CHANGE THIS - name of the database table associated with this form **/
$table_name = "form_adi_r_simple";

/** CHANGE THIS name to the name of your form **/
$form_name = "ADI-R";

/** CHANGE THIS to match the folder you created for this form **/
$form_folder = "adi_r";

formHeader("Form: ".$form_name);
$returnurl = 'encounter_top.php';

/* load the saved record */
$record = formFetch($table_name, $_GET["id"]);

/* remove the time-of-day from the date fields */
if ($record['form_date'] != "") {
    $dateparts = explode(" ", $record['form_date']);
    $record['form_date'] = $dateparts[0];
}

?>

<html><head>
<?php html_header_show();?>

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-3-1-1/index.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js?v=<?php echo $v_js_includes; ?>"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.full.min.js"></script>

<!-- page styles -->
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" href="../../forms/<?php echo $form_folder; ?>/style.css?v=<?php echo $v_js_includes; ?>" type="text/css">
<link rel="stylesheet" href="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.min.css">

<script language="JavaScript">
// this line is to assist the calendar text boxes
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

function PrintForm() {
    newwin = window.open("<?php echo "http://".$_SERVER['SERVER_NAME'].$rootdir."/forms/".$form_folder."/print.php?id=".$_GET["id"]; ?>","mywin");
}
</script>

</head>

<body class="body_top">

<?php echo date("F d, Y", time()); ?>

<form method=post action="<?php echo $rootdir;?>/forms/<?php echo $form_folder; ?>/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">
<span class="title"><?php xl($form_name, 'e'); ?></span><br>

<!-- Save/Cancel links -->
<input type="button" class="save" value="<?php xl('Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="dontsave" value="<?php xl('Don\'t Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php xl('Print', 'e'); ?>"> &nbsp;

<!-- container for the main body of the form -->
<div id="form_container">

<div id="general">
<table>
  <tr><td>
    Total A: <input type="number" name="totalA" min="0" value="<?php echo stripslashes($record['totalA']);?>" >
  </td></tr>
  <tr><td>
    Verbal Total B: <input type="number" name="verbal_totalB" min="0" value="<?php echo stripslashes($record['verbal_totalB']);?>" >
  </td></tr>
  <tr><td>
    Nonverbal Total B: <input type="number" name="nonverbal_totalB" min="0" value="<?php echo stripslashes($record['nonverbal_totalB']);?>" >
  </td></tr>
  <tr><td>
    Total C: <input type="number" name="totalC" min="0" value="<?php echo stripslashes($record['totalC']);?>" >
  </td></tr>
  <tr><td>
    Total D: <input type="number" name="totalD" min="0" value="<?php echo stripslashes($record['totalD']);?>" >
  </td></tr>
</table>

</div> <!-- end form_container -->

<input type="button" class="save" value="<?php xl('Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="dontsave" value="<?php xl('Don\'t Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php xl('Print', 'e'); ?>"> &nbsp;

</form>

</body>

<script language="javascript">
// jQuery stuff to make the page a little easier to use

$(document).ready(function(){
    $(".save").click(function() { top.restoreSession(); document.my_form.submit(); });
    $(".dontsave").click(function() { parent.closeTab(window.name, false); });
    $(".printform").click(function() { PrintForm(); });

    $('.datepicker').datetimepicker({
        <?php $datetimepicker_timepicker = false; ?>
        <?php $datetimepicker_showseconds = false; ?>
        <?php $datetimepicker_formatInput = false; ?>
        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
    });
});

</script>

</html>
