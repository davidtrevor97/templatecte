<?php
//include('include/dbcommon.php');
//$record = db_fetch_array(CustomQuery('SELECT * FROM comm.plank_listini_ee WHERE id='.$_GET['id'].';'));
//$res = producilistini($record);

function producilistini($record,$utility)
{
    //Produce listino pdf per un record di plank_listini_

    $datainiziofix = date('Y-m-01', strtotime($record['datafinefornitura'] . ' - 11 month'));
    setlocale(LC_TIME, 'it_IT');
    $azienda = db_fetch_array(CustomQuery('SELECT * FROM comm.plank_aziende WHERE particellaazienda="' . $record['particellaazienda'] . '";'));
	if(strcmp($utility,'EE')==0){
		$prezzi = db_fetch_array(CustomQuery("select MIN(data) as inizio,MAX(data) as fine,ROUND(avg(pun)/1000,4) as ultimoanno ,
			ROUND(avg(if(data >= DATE_FORMAT(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH),'%Y-%m%-01') and data <= LAST_DAY(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH)),pun,null))/1000,4) as ultimomese 
			FROM comm.plank_ee_prezzi_mgp 
			WHERE data >= DATE_FORMAT(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 12 MONTH),'%Y-%m%-01') and data <= LAST_DAY(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH))"));
	}
    ob_start();
?>

      <?php
	if (strcmp($utility,'GAS')==0){
      switch (strtoupper($record['template_pdf'])) {
          case 'CASAGREEN PSV':
      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
      <!-- http://fe3.plank.global/services/htmlrendering/upload.php -->
    <style>
        /* GENERAL */
        *{
            margin:0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Istok Web', sans-serif;
            text-align: justify;
        }
        .page {
        	page-break-after: always;
            position: relative;
            width: 100%;
            height: 34cm;
            max-height: 34cm;
        }

        footer {
            position: absolute !important;
            bottom: 0 !important;
        	width: 100%;
        }
        header{
        	width: 100%;
        }
        header,
        main{
            padding:0 0 0 1.5cm;
        }
        section{
        	word-wrap: break-word;
            margin-bottom: 25px;
        }
        .container {
           height: 650px;
           width: 100%;
        }
        /* UTILITIES */
        .pink{
            color: #e71d73;
        }
        .blue{
            color: #2d2e83;
        }
        .black{
            color: black;
        }
        .lightblack{
            color: #666;
        }
        .white{
            color: white;
        }
        .title{
            font-size: 24px;
            font-weight: 400;
            margin:0px 5px 20px 0px;
        }
        .abstract{
            font-size: 18px;
            font-weight: 400;
        }
        .bigP{
            font-size: 15px;
            font-weight: 400;
            margin:0px 5px 15px 0px;
        }
        .smallP{
            font-size: 12px;
            font-weight: 400;
            margin:0px 5px 10px 0px;
        }
        .bold{
            font-weight: 700;
        }
        .clearfix::after{
        content: "";
        display: table;
        clear: both;
        }
        .floatleft{
            float: left;
        }
        .floatright{
            float: right;
        }
        .justification{
            display: -webkit-box;
            -webkit-box-pack: justify;
        }
        .ball{
            border-radius: 50%; 
            position: absolute;
        }
        /* HEADER */
        #logo{
            height: 100px;
        }
        #logo div:nth-child(1){
            width: 70%;
            height: 100%;
        }
        #logo div:nth-child(2){  
            width: 30%;
            height: 100%;
        }
        #logo div:nth-child(2) .ball{
            width: 150px;
            height: 150px;
            background-color: #2d2e83;
            top: -10px;
            right: -50px;
            z-index: 1;
            position: absolute;
        }
        #logo div:nth-child(2) .ball:nth-child(2){
            top: -50px;
            right: 50px;
            z-index: 0; 
            background-color: #e71d73;  
            position: absolute;
        }
        /* MAIN */
        table{
            margin: 20px 10px;
        }
        table td,
        table div{
            margin: 4px 40px;
        }
        #third_table td{
            text-align: center;
        }
        /* FOOTER */
        
        #coDetails{
            height: 50px;
        }
        #coDetails > div:nth-child(2){
            background-color: #2d2e83;
            position: relative;
            width: 70%;
            height: 100%;
            border: 1px solid black;
            z-index: 1 !important;
        }
        #coDetails  .ball{
            position: absolute;
            width: 75px;
            height: 75px;
            background-color: #e71d73;
            left: 27%;
            bottom: -10px;
            z-index: 0 !important;
        }
    </style>
</head>
<body>
<div class="page">
            <!-- HEADER -->
    <header>
        <section id="logo" class="clearfix">
            <div class="floatleft title">
               ERRECI
            </div>
            <div class="floatleft">
                <div class="ball"></div>
                <div class="ball"></div>
            </div>
        </section>
        <section id="headline" class="clearfix">
            <div class="title blue bold floatleft">
                OFFERTA CASAGREEN PSV ERRECI S.r.l. – GAS NATURALE
            </div>
        </section>
        <section id="abstract">
            <div class="bigP bold">
                Condizioni economiche <br>
                Offerta dedicata ai Clienti finali titolari di punti di prelievo per GAS Naturale alimentati in bassa pressione e 
                destinati a USI DOMESTICI
            </div>
        </section>
    </header>
    <!-- FINE HEADER -->

    <!-- MAIN -->
    <main class="container">
        <section class="text">
            <div class="smallP">
                Un’offerta dinamica che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati del gas.
                Prezzo componente GAS Naturale <br>
                Il prezzo della Componente Gas è il corrispettivo applicato al gas naturale prelevato a copertura esclusivamente dei costi di approvvigionamento. L’offerta si 
                intende valida per 12 mesi a partire dalla data prevista di avvio dellla fornitura indicata nella proposta di somministrazione. <br>
                Verranno addebitati e resteranno a carico del cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di
                gas naturale, alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti con Delibera ARERA 64/09
                ARG/gas e s.m.i. e con Delibera ARERA 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo gravante. I corrispettivi unitari della
                presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1
            </div>
        </section>
        <section class="table" style="height: 150px;position: relative; margin-bottom: 0;">
            <table style="position: absolute; left: 50%; transform: translateX(-50%);" class="floatleft">
                <tbody><tr>
                    <th class="bold blue bigP" colspan="3" style="text-align:center">
                        Prezzi €/Smc 
                    </th>
                </tr>
                 <tr>
                   <td>
                    <div class="bold black bigP"> 
                        Qp =
                    </div>
                  </td>
                   <td>
                      <div class="bold black bigP"> 
                        PSVda +
                    </div>
                    </td>
                    <td>
                        <div class="bold pink bigP"> 
                            P0 
                      </div>
                      </td>
                 </tr>
                 <tr>
                    <td>
                     <div class="bold black bigP"> 
                        Qp = 
                     </div>
                   </td>
                    <td>
                       <div class="bold black bigP"> 
                         PSVda +
                     </div>
                     </td>
                     <td>
                         <div class="bold pink bigP"> 
                            <?= number_format($record['s0'], 4, ',', '.') ?>
                       </div>
                       </td>
                 </tr>
               </tbody></table>
        </section>
        <section  class="text">
            <div class="smallP">
                Qp è la quota materia prima, proporzionale ai consumi effettuati dall’utenza espressa in €/Smc <br>
                PSVda è pari alla media aritmetica delle quotazioni giornaliere “Heren Day Ahead Price”, espresse in €/MWh e convertite in €/Smc sulla base di un coefficiente 
                moltiplicativo pari a 0,0105833. Per ciascun giorno del mese di prelievo, la quotazione “Heren Day Ahead Price”, espressa in €/MWh è il prezzo “Offer” relativo 
                al periodo “Day-ahead” pubblicato sotto il titolo “PSV PRICE ASSESSMENT” nel report “ICIS Heren European Spot Gas Markets” del più vicino giorno lavorativo 
                precedente secondo il calendario inglese, che fa riferimento alle seguenti quotazioni: <br>
                - “Day Ahead”, se il giorno in questione è un giorno lavorativo secondo il calendario inglese; <br>
                - “Weekend”, se il giorno in questione non è un giorno lavorativo secondo il calendario inglese.
            </div>
        </section>
        <section  class="table clearfix">
            <div style="width: 500px" class="smallP floatleft">
                Valori dei corrispettivi e relativo impatto sulla spesa annua per il gas naturale di una famiglia tipo con consumi pari a 1.400 Smc/anno, nell’ambito 
                tariffario Nord - Occidentale, considerando un potere calorifico superiore pari a 0,03852 GJ/Smc e con riferimento al 3 ° Trimestre 2020 
            </div>
            <table class="floatleft">
                <tbody><tr>
                  <th>
                 </th>
                  <td>
                     <p class="blue bold" style="text-align: center;"> Quota %</p>
                   </td>
                </tr>
                <tr>
                  <th>
                       <p class="smallP black bold">Componente GAS</p>
                  </th>
                  <td>
                     <p class="smallP pink bold" style="text-align: center;">48%</p> 
                   </td>
                </tr>
                <tr>
                  <th> 
                   <p class="smallP  black bold" style="width: 200px;"> Remunerazione costi di commercializzazione</p>
                  </th>
                  <td>
                     <p class="smallP pink bold" style="text-align: center;"> 11%</p>
                   </td>
                </tr>
                <tr>
                   <th> 
                    <p class="smallP  black bold" style="width: 200px;">Restanti Componenti
                       </p>
                   </th>
                   <td>
                      <p class="smallP pink bold" style="text-align: center;">41%</p>
                    </td>
                 </tr>
              </tbody></table>
         </section>
         <section class="text">
             <div class="smallP">Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore
                dell’impianto di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARERA ARG/gas 69/04
                (TIVG) e s.m.i.. <br>
                L’andamento storico dell’indice PSVda degli ultimi 12 mesi è stato pari ai valori sotto riportati</div>
         </section>
         <section id="third_table" class="table" style="min-height: 0;">
            <table>
                <tr class="blue">
                  <th> 
                      <span class="bigP bold blue">Mese</span>
                  </th>
                  <th>
                      <span class="bigP bold blue">PSVda c€/Smc </span>
                  </th> 
                  <th> 
                      <span class="bigP bold blue">Mese</span>
                  </th>
                  <th>
                      <span class="bigP bold blue">PSVda c€/Smc</span>
                  </th>
                </tr>
                <tr>
                  <td>
                      <span class="smallP bold black">ott-19</span>
                  </td>
                  <td>
                    <span class="bigP bold pink">13,59</span>
                 </td>
                  <td>
                    <span class="smallP bold black">apr-20</span>
                 </td>
                  <td> 
                    <span class="bigP bold pink">9,14</span>
                  </td>
                </tr>
                <tr>
                    <td>
                        <span class="smallP bold black">ott-19</span>
                    </td>
                    <td>
                      <span class="bigP bold pink">13,59</span>
                   </td>
                    <td>
                      <span class="smallP bold black">apr-20</span>
                   </td>
                    <td> 
                      <span class="bigP bold pink">9,14</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="smallP bold black">ott-19</span>
                    </td>
                    <td>
                      <span class="bigP bold pink">13,59</span>
                   </td>
                    <td>
                      <span class="smallP bold black">apr-20</span>
                   </td>
                    <td> 
                      <span class="bigP bold pink">9,14</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="smallP bold black">ott-19</span>
                    </td>
                    <td>
                      <span class="bigP bold pink">13,59</span>
                   </td>
                    <td>
                      <span class="smallP bold black">apr-20</span>
                   </td>
                    <td> 
                      <span class="bigP bold pink">9,14</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="smallP bold black">ott-19</span>
                    </td>
                    <td>
                      <span class="bigP bold pink">13,59</span>
                   </td>
                    <td>
                      <span class="smallP bold black">apr-20</span>
                   </td>
                    <td> 
                      <span class="bigP bold pink">9,14</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="smallP bold black">ott-19</span>
                    </td>
                    <td>
                      <span class="bigP bold pink">13,59</span>
                   </td>
                    <td>
                      <span class="smallP bold black">apr-20</span>
                   </td>
                    <td> 
                      <span class="bigP bold pink">9,14</span>
                    </td>
                </tr>
              </table>                      
         </section>
    </main>
    <!-- FINE MAIN -->

    <!-- FOOTER -->
    <footer>
        <section id="signature">

        </section>
        <section id="coDetails">
            <div class="ball">
                
            </div>
            <div class="floatright" style="padding: 15px 5px;">
                <div class="smallP bold white floatleft" style="margin-right:250px">21052 Busto Arsizio (VA) Via Marcello Candia</div>
                <div class="smallP bold white floatleft"  style="margin-right: 40px;">Erreci S.r.l.</div>
                <div class="smallP bold white floatright">Tel. 0331 341963 Fax 0331 341956 </div>
            </div>
        </section>
    </footer>
    <!-- FINE FOOTER -->
</div>


</body>
</html>

 <?php
              
         break;
      }
  }
  ?>

  
<?php
    $html = ob_get_clean();

    //Uso wkhtmltopdf
    $outfileusr = 'Listino_' . preg_replace('/[^A-Za-z0-9\-]/', '', $record['codiceofferta']);;
    $outfile = $outfileusr . '_' . date('YmdHis') . rand(10000, 99999);
    $pathoutfile = '.\\producilistini\\generati\\' . $outfile . '.pdf';
    $pathinfile = $outfile . '.html';
    file_put_contents($pathinfile, $html);
    exec('"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe" ' . $pathinfile . ' ' . $pathoutfile);
    unlink($pathinfile);


    //Da fare

    //Se ho successo...
    if (file_exists($pathoutfile)) {
        //Scrivo l'allegato
        $allegato = '[{"name":"producilistini\\\\/generati\\\\/' . $outfile . '.pdf","usrName":"' . $outfileusr . '.pdf","size":' . filesize($pathoutfile) .
            ',"type":"application/pdf","searchStr":"' . $outfileusr . '.pdf,!:sStrEnd"}]';
        //Metto lo stato GENERATA su Comunicazioni
        $sql = 'UPDATE comm.plank_listini_'.strtolower($utility).' SET allegatocte=\'' . $allegato . '\'  WHERE id=' . $record['id'];
        CustomQuery($sql);
        $res = "OK";
    } else {
        $res = 'KO';
    }

    return $res;
}