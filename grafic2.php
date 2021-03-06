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
   if (strcmp($utility,'EE')==0){
          switch (strtoupper($record['template_pdf'])) {
          case 'FISSO PER TE EE':
       ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=+, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
            /* GENERAL */
        *{
            margin:0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
            text-align: justify;
        }
        .page {
        	page-break-after: always;
            position: relative;
            width: 100%;
            height: 11.7in;
            max-height: 11.7in;
        }

        footer {
            position: absolute !important;
            bottom: 0 !important;
        	width: 100%;
        }
        header{
        	width: 100%;
        }
        main{
            padding:0 1.5cm 0 1.5cm;
        }
        section{
        	word-wrap: break-word;
            margin-bottom: 10px;
        }
        .container {
           height: 650px;
           width: 100%;
        }
        /* Utilities */
        .green{
            color: #84b150;
        }
        .blue{
            color:#434a9e;
        }
        .black{
            color: black;
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
            font-size: 11px;
            font-weight: 400;
            margin:0px 5px 10px 0px;
        }
        .tinyP{
            font-size: 9px;
            font-weight: 400;
            margin:0px 5px 10px 0px;
        }
        .bold{
            font-weight: 700;
        }
        .block{
            display: block;
        }
        /* header */
        #h_section1{
            display: flex;
            margin-top: 20px;
        }
        #h_section1 > div:nth-child(1){
            width: 80%;
            background-color: #84b150;
        }
        #h_section1 > div:nth-child(2){
            padding: 20px 10px;
            flex-grow: 1;
            text-align: right;
        }
        /* main */
        /* footer */
        footer section{
            height: 70px;
            display: flex;
            align-items: center;
            margin-bottom: 50px;
        }
        footer section div:nth-child(1){
            width: 80%;
        }
        footer > section>div:nth-child(2){
            flex-grow: 1;
            height: 100%;
            background-color: #84b150;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- HEADER -->
        <header>
            <section id="h_section1">
                <div id="logo">
                    <img src="img/erreci.PNG" alt="">
                </div>
                <div class="tinyP black" id="codetails">
                    Erreci S.r.l. <br>
                    Sede legale e operativa: 21052 Busto Arsizio (VA) Via Marcello Candia 12 <br>
                    Tel. 0331 341963 Fax 0331 341956 info@erreci.info <br>
                    www.erreci.info C.F. e P.IVA 02989180126 <br>
                    Unit?? locale: 29017 Fiorenzuola d'Arda (PC) Via XX Settembre, 68
                </div>
            </section>
        </header>
        <!-- FINE HEADER -->
        <!-- MAIN -->
        <main>
            <section >
                <div class="title blue">
                    OFFERTA FISSO PER TE ERRECI S.r.l. ??? Energia Elettrica
                </div>
            </section>
            <section class="abstract green">
                CONDIZIONI ECONOMICHE <br>
                Offerta dedicata ai clienti finali non domestici titolari di punti di prelievo per Energia Elettrica con consumi
                fino a 500.000 kWh/anno.
            </section>
            <section>
                <div class="smallP">
                    Un???offerta green che ti permette di avere la sicurezza di un prezzo fisso per tutta la durata contrattuale. <br>
                    La scelta di energia verde consente l???acquisto della certificazione di energia prodotta da fonti rinnovabili.  Il cliente ricever?? un attestato che certifichi che
                    all???energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verr?? messo a disposziione del cliente anche il ???pacchetto verde???,
                    contenente materiale pubblicitario e il marchio ???Energia Verde Powered by Erreci???. Il Contratto ?? coerente con la regolazione definita dall???ARERA in materia di
                    contratti di vendita di energia rinnovabile. <br>
                    Per la fornitura di energia elettrica verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di
                    Contratto):
                </div>
            </section>
            <section id="first_table" style="display: flex; justify-content: center;">
                <table style="float: left;border-bottom: 2px solid #434a9e">
                    <tbody style="border-bottom: 2px solid #434a9e"><tr>
                     <th class="green abstract" style="width: 180px; border-bottom: 2px solid #434a9e" colspan="2">PREZZO PER FASCE</th>
                    </tr>
                     <tr>
                       <th>
                        <div class="bigP bold "> FASCIA F1</div>
                        <p class="smallP"> 8.00 ??? 19.00 dal Lunedi al Venerdi</p>
                      </th>
                       <td>
                          <p class="bigP bold blue">  <?= number_format($record['c_f1'] / 1000, 3, ',', '.') ?> ???/kWh</p>
                        </td>
                     </tr>
                     <tr>
                       <th>
                        <div class="bigP bold "> FASCIA F2</div>
                            <p class="smallP">7.00-8.00 e 19.00-23.00 giorni lavorativi <br> 7.00 ??? 23.00 Sabato</p>
                       </th>
                       <td>
                          <p class="bigP bold blue"> <?= number_format($record['c_f2'] / 1000, 3, ',', '.') ?> ???/kWh</p> 
                        </td>
                     </tr>
                     <tr>
                       <th> 
                        <div class="bigP bold "> FASCIA F3</div>
                        <p class="smallP"> 23.00 ??? 7.00 giorni lavorativi, Domenica e  festivi</p>
                       </th>
                       <td>
                          <p class="bigP bold blue"> <?= number_format($record['c_f3'] / 1000, 3, ',', '.') ?> ???/kWh</p>
                        </td>
                     </tr>
                   </tbody></table>
            </section>
            <section>
                <div class="smallP">
                    Oneri di dispacciamento: saranno disciplinati dalla Delibera ARERA n. 111/06 e s.m.i.; <br>
                    Costi di commercializzazione: Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                    disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall???ARERA. <br>
                    La somma di tutti i corrispettivi per i servizi di vendita sopra descritti rappresenta circa il 40% della spesa complessiva di un cliente tipo, con consumi annui pari
                    a 10.000 kWh e una potenza impegnata pari a 10kW, escluse IVA e imposte. Il peso della sola componente energia al netto delle perdite di rete, esclusa IVA e
                    imposte, ?? pari a circa il 30% della spesa complessiva per l???energia elettrica.
                </div>
                <div class="smallP">
                    <span class="abstract blue block"> SPESA PER IL TRASPORTO DELL???ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA</span>
                    Per la distribuzione, la misura e il trasporto dell???energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                    Locale, da Terna e dall???ARERA, compresa la componente Asos a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e assimilate. Tali
                    tariffe sono aggiornate con modalit?? e tempi stabiliti dalle autorit?? competenti, dall???ARERA e dal Distributore Locale. Il Cliente si impegna, inoltre, a corrispondere
                    eventuali nuove componenti stabilite dall???ARERA di volta in volta applicabili.
                    La somma di tutti i corrispettivi per la spesa per il servizio di trasporto e gestione del contatore sopra descritti e per la spesa degli oneri di sistema,
                    rappresentano rispettivamente circa il 21% e il 39% della spesa complessiva del suddetto cliente tipo.
                    Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente
                </div>
            </section>
        </main>
        <!-- FINE MAIN -->
        <!-- FOOTER -->
        <footer>
            <section>
                <div class="bigP" style="display: flex; justify-content: space-between;">
                    <div>
                        <span>Luogo________________</span>
                        <span>Data________________</span>
                    </div>
                    <div>
                        <span>Firma________________</span>   
                    </div>
                </div>
                <div>

                </div>
            </section>
        </footer>
        <!-- FINE FOOTER -->
    </div>
    
</body>
</html>
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