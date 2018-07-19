<!DOCTYPE html>
<html>
<head>
  
<!--Bootstrap codes-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!--Bootstrap codes--> 

<!-- Bootstrap core CSS Datatables codes-->
  <link href="docs/css/bootstrap.min_.css" rel="stylesheet">
  <link href="docs/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="docs/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="docs/css/custom.css" rel="stylesheet">
  <link href="docs/css/icheck/flat/green.css" rel="stylesheet">
  <link href="docs/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="docs/js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="docs/js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="docs/js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="docs/js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <script src="docs/js/jquery.min_.js"></script>
<!-- Bootstrap core CSS Datatables codes-->


<?php
//include "../connect.php";
if($_POST){
$ilk_tarih=$_POST["ilk_date"];
$son_tarih=$_POST["son_date"];
$kanal=$_POST['kanal'];
}
else {
$ilk_tarih="";
$son_tarih="";
$kanal="TRT1";
$gunfark="";
}


$bugununtarihi=date('Y-m-d');
$birgunsonrasisql = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
   //echo date("Y-m-d", $biryiloncesisql); // Yarın bu zamanı verir.
$birgunsonrasi=date("Y-m-d", $birgunsonrasisql);

?>
<title><?php echo "($ilk_tarih)"; echo " - "; echo "($son_tarih)"; ?> tarihleri <?php echo "($kanal)"; ?> Kanalı Planlanan Akış</title>

        <script type="text/javascript">
            jQuery(document).ready(function(){
            jQuery('#first_intake.datepicker').datepicker({
                dateFormat : 'd M, yy'
            });
            jQuery('#second_intake.datepicker').datepicker({
                dateFormat : 'd M, yy'
            });
            });
        </script>



    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        p.sansserif {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

<br>
    	<table align="center">
        	<tr>
            	<td>
                	<form action="" method="post">
                    <p class="sansserif">
                        <font color="white">First Date: </font>
                        <input class="datepicker" name="ilk_date" id="first_intake" value="<?php echo("$bugununtarihi")?>" size="30" type="date">
                        <font color="white">Last Date:</font>
                        <input class="datepicker" name="son_date" id="first_intake" value="<?php echo("$birgunsonrasi")?>" size="30" type="date">
                        <font color="white">Channel: </font>
                        <select name="kanal">

                        	<option value="TRTBELGESEL"> TRT BELGESEL</option>
                        	<option value="TRT1">TRT 1</option>
                        	<option value="TRT3">TRT3</option>
                        	<option value="TRTAvaz">TRTAvaz</option>
                        	<option value="TRTCOCUK">TRTCOCUK</option>
                        	<option value="TRTDiyanet">TRTDiyanet</option>
                        	<option value="TRTElArabia">TRTElArabia</option>
                        	<option value="TRTHABER">TRTHABER</option>
                        	<option value="TRTHD">TRTHD</option>
                        	<option value="TRTKurdi">TRTKurdi</option>
                        	<option value="TRTMÜZİK">TRTMÜZİK</option>
                        	<option value="TRTOKUL">TRTOKUL</option>
                        	<option value="TRT4K">TRT4K</option>
                        </select>
                        <input type="submit" value="SEARCH"></p>

                    </form>

                </td>
            </tr>
        </table>


<p class="sansserif">

<?php

if($_POST){

$ilk_tarih=$_POST["ilk_date"];
$son_tarih=$_POST["son_date"];
$kanal=$_POST['kanal'];
//echo $ilk_tarih; echo "<br>";
//echo $son_tarih; echo "<br>";

$ilktime=strtotime($ilk_tarih);
$ilktime_tr=date("d-m-Y",$ilktime);

$sontime=strtotime($son_tarih);
$sontime_tr=date("d-m-Y",$sontime);

//echo $ilktime_tr; echo "<br>";
//echo $sontime_tr; echo "<br>";
$gunfark=(($sontime-$ilktime)/86400)+1;
//echo $gunfark;

}
else {
	$kanal="TRT1";
}
?>
</p>

<div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Dates : <?php echo "($ilk_tarih)"; echo " - "; echo "($son_tarih)"; ?> Channel : <?php echo "($kanal)"; ?></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p class="text-muted font-13 m-b-30">
                    Çıktı almak istediğiniz formatı tıklayınız. Yapıştırmak üzere kopyala tuşuna basabilirsiniz.
                  </p>
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
    <tr>
      <th scope="col">Tarihi</th>
      <th scope="col">Program Adı</th>
      <th scope="col">Planlanan Saat</th>
      <th scope="col">Açıklama</th>
      <th scope="col">Süre</th>
    </tr>
  </thead>
  <tbody>

<?php 

$sayi=0;
while ($sayi < $gunfark) {

$yenitarih = strtotime('+'.$sayi.' days',strtotime($ilk_tarih));
$yenitarih = date('Y-m-d' ,$yenitarih );
//

        $client = new SoapClient('http://etelevizyon.trt.net.tr/eTelevizyonWS/eTelevizyonWebService.asmx?wsdl');
        $arr = array(
                    'tarih' => $yenitarih,
                    'kanal' => $kanal,
                );

        $sonuc = $client->AkisSaytekByTarihKanal($arr)->AkisSaytekByTarihKanalResult->any;
        $sonuc = str_replace('<xs:schema xmlns="" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet"><xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:MainDataTable="dtAkisSaytekByTarihKanal" msdata:UseCurrentLocale="true"><xs:complexType><xs:choice minOccurs="0" maxOccurs="unbounded"><xs:element name="dtAkisSaytekByTarihKanal"><xs:complexType><xs:sequence><xs:element name="AkisID" msdata:ReadOnly="true" msdata:AutoIncrement="true" msdata:AutoIncrementSeed="-1" msdata:AutoIncrementStep="-1" type="xs:int"/><xs:element name="Kanal"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="20"/></xs:restriction></xs:simpleType></xs:element><xs:element name="Tarihi" msdata:ReadOnly="true" minOccurs="0"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="10"/></xs:restriction></xs:simpleType></xs:element><xs:element name="P_Saat" msdata:ReadOnly="true" msdata:Caption="P.Saat" minOccurs="0"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="5"/></xs:restriction></xs:simpleType></xs:element><xs:element name="P_Süre" msdata:Caption="P.Süre" type="xs:int"/><xs:element name="ProgID" msdata:ReadOnly="true" msdata:AutoIncrement="true" msdata:AutoIncrementSeed="-1" msdata:AutoIncrementStep="-1" type="xs:int" minOccurs="0"/><xs:element name="Program_x0020_Adı" msdata:ReadOnly="true" minOccurs="0"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="8000"/></xs:restriction></xs:simpleType></xs:element><xs:element name="Açıklama" msdata:ReadOnly="true" minOccurs="0"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="8000"/></xs:restriction></xs:simpleType></xs:element><xs:element name="CBS" minOccurs="0"><xs:simpleType><xs:restriction base="xs:string"><xs:maxLength value="10"/></xs:restriction></xs:simpleType></xs:element><xs:element name="Tekrar" type="xs:boolean" minOccurs="0"/></xs:sequence></xs:complexType></xs:element></xs:choice></xs:complexType></xs:element></xs:schema>', '', $sonuc);

        

        $sonuc = simplexml_load_string($sonuc);
        
        

        foreach ($sonuc->DocumentElement->dtAkisSaytekByTarihKanal as $kayit) {
            $ProgID = $kayit->ProgID;
            $AkisID = $kayit->AkisID;
            $ProgAdi = $kayit->Program_x0020_Adı;
            $P_Saat = $kayit->P_Saat;
            $P_Sure = $kayit->P_Süre;
            $Aciklama = $kayit->Açıklama;

echo "<tr>"."<td>";
    echo $yenitarih;"</td>"; 
    echo "<td>";
    echo $ProgAdi.' '."</td>";
    echo "<td>";
    echo $P_Saat.' '."</td>";
    echo "<td>";
    echo $Aciklama.' '."</td>";
    echo "<td>";
    echo $P_Sure.' '."</td>";
    
    "</tr>"; 

//echo "<tr bgcolor='#d9e1f2'>"."<td>".$P_Saat."</td><td>".$ProgAdi."</td><td>".$Aciklama."</td><td>".$P_Sure."</td></tr>"."<br>";



            //$sql=mysql_query ("insert into planlanan (ProgID, AkisID, ProgAdi, P_Saat, P_Sure, Tarihi, Aciklama) VALUES ('$ProgID','$AkisID', '$ProgAdi', '$P_Saat', '$P_Sure', '$yenitarih','$Aciklama')");
        }   


$sayi++;
}
//mysql_close();
?>


</body>
<script src="docs/js/bootstrap.min_.js"></script>
        <!-- bootstrap progress js -->
        <script src="docs/js/progressbar/bootstrap-progressbar.min.js"></script>
        <script src="docs/js/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- icheck -->
        <script src="docs/js/icheck/icheck.min.js"></script>
        <script src="docs/js/custom.js"></script>
        <!-- Datatables -->
        <!-- <script src="js/datatables/js/jquery.dataTables.js"></script>
        <script src="js/datatables/tools/js/dataTables.tableTools.js"></script> -->

        <!-- Datatables-->
        <script src="docs/js/datatables/jquery.dataTables.min.js"></script>
        <script src="docs/js/datatables/dataTables.bootstrap.js"></script>
        <script src="docs/js/datatables/dataTables.buttons.min.js"></script>
        <script src="docs/js/datatables/buttons.bootstrap.min.js"></script>
        <script src="docs/js/datatables/jszip.min.js"></script>
        <script src="docs/js/datatables/pdfmake.min.js"></script>
        <script src="docs/js/datatables/vfs_fonts.js"></script>
        <script src="docs/js/datatables/buttons.html5.min.js"></script>
        <script src="docs/js/datatables/buttons.print.min.js"></script>
        <script src="docs/js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="docs/js/datatables/dataTables.keyTable.min.js"></script>
        <script src="docs/js/datatables/dataTables.responsive.min.js"></script>
        <script src="docs/js/datatables/responsive.bootstrap.min.js"></script>
        <script src="docs/js/datatables/dataTables.scroller.min.js"></script>

        <!-- pace -->
        <script src="docs/js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "docs/js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>


</html>
