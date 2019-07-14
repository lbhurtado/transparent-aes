<HTML>
<HEAD>
    <TITLE>table </TITLE>
</HEAD>
<BODY style="
    zoom: 1;
    -moz-transform: scale(3);
    -moz-transform-origin: 0 0;
">
<form action="" method="post" enctype="multipart/form-data">
    <input type="submit" value="Submit" name="submit" id="add">
    <input type="submit" value="Reset" name="reset">
</form>
<div id="table_data">
    <TABLE id="dataTable" width="350px" border="1">

        <TR>
        <?php
        //$counter = $_SESSION['col_1'] + $_SESSION['col_2'] + $_SESSION['col_2'];
        ?>
        <!--<TD><INPUT type="checkbox" name="chk"/></TD>-->
            <TD>1</TD>
            <td><p class="tally_font">a</p></td>
            <td><p class="tally_font">b</p></td>
            <td><p class="tally_font">c</p></td>
            <td><p class="tally_font">d</p></td>
        </TR>
    </TABLE>
</div>
<!-- attached file for tally font -->
<style type="text/css">
    @font-face {
        font-family: myFirstFont;
        src: url('fonts/TallyMark.ttf');
    }

    .tally_font{
        font-family: myFirstFont;
        letter-spacing: 1px;
        text-align: left;
        padding-right: 5px;
    }

</style>

</BODY>
</HTML>
