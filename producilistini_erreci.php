<?php
//include('include/dbcommon.php');
//$record = db_fetch_array(CustomQuery('SELECT * FROM comm.plank_listini_ee WHERE id='.$_GET['id'].';'));
//$res = producilistini($record);

function producilistini($record, $utility)
{
    //Produce listino pdf per un record di plank_listini_

    $datainiziofix = date('Y-m-01', strtotime($record['datafinefornitura'] . ' - 11 month'));
    setlocale(LC_TIME, 'it_IT');
    $azienda = db_fetch_array(CustomQuery('SELECT * FROM comm.plank_aziende WHERE particellaazienda="' . $record['particellaazienda'] . '";'));
    if (strcmp($utility, 'EE') == 0) {
        $prezzi = db_fetch_array(CustomQuery("select MIN(data) as inizio,MAX(data) as fine,ROUND(avg(pun)/1000,4) as ultimoanno ,
			ROUND(avg(if(data >= DATE_FORMAT(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH),'%Y-%m%-01') and data <= LAST_DAY(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH)),pun,null))/1000,4) as ultimomese 
			FROM comm.plank_ee_prezzi_mgp 
			WHERE data >= DATE_FORMAT(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 12 MONTH),'%Y-%m%-01') and data <= LAST_DAY(DATE_SUB('" . $record['datainiziocompetenza'] . "',INTERVAL 1 MONTH))"));
    }
    ob_start();
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>

    <head>
        <meta charset="utf-8" />
        <title><?= $record['nomeofferta'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="">
        <style>
            /* GENERAL */

            /* GENERAL */
            .blue {
                background-color: #5093e6;
            }

            .green {
                color: #05af51;
            }

            .orange {
                color: #f89a47;
            }

            .smallBlack {
                color: #222028;
            }

            .bigBlack {
                color: #221f1f;
            }

            .tableGreen {
                background-color: #d6e3bc;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                text-align: justify;
                text-justify: inter-word;
                font-family: 'Verdana';
            }

            .page {
                page-break-after: always;
                position: relative;
                width: 100%;
                height: 34cm;
                padding: 0px 40px 0px 40px;
            }

            .footer {
                position: absolute !important;
                bottom: 0 !important;
                width: 90%;
            }

            header {
                width: 100%;
            }

            section {
                padding: 2px 20px;
                min-height: 50px;
                word-wrap: break-word;
                margin: 5px 0px;
            }

            .container {
                height: 650px;
                width: 100%;
            }


            /* UTILITIES */
            .intestazione-footer {
                font-size: 12px;
            }

            section::after {
                content: "";
                display: table;
                clear: both;
            }

            .mainBlack {
                color: #221f1f;
                font-size: 16.5px;
                font-weight: 800;
                line-height: 18px;
            }

            .mediumBlack {
                color: #221f1f;
                font-size: 11.5px;
                font-weight: 500;
            }

            .smallP {
                color: #222028;
                font-size: 11px;
                line-height: 12px;
            }

            .subtitle {
                text-decoration: underline;
            }

            .bold {
                font-weight: 800;
            }

            .italic {
                font-style: italic;
            }

            .block {
                display: block;
            }

            .titleOrange {
                color: #f89a47;
                font-size: 24px;
            }

            .buyGreen {
                color: #05af51;
                font-size: 15px;
                font-weight: 800;
            }

            .floatLeft {
                float: left !important;
            }

            .floatRight {
                float: right;
            }

            .standard_margin {
                margin-bottom: 2px;
            }

            /* HEADER */
            #h_section1>.img_header {
                width: 10%;
                height: 3cm;
            }

            #h_section1 .img_header:nth-child(1) {
                float: left;
            }

            #h_section1 .img_header:nth-child(2) {
                float: right;
            }

            #h_section4 {
                min-height: 0;
            }

            /* MAIN */

            /* FOOTER */
            #f_section1>div,
            #f_section2>div {
                width: 100%;
                clear: both;

            }

            #f_section1>.part_footer,
            #f_section2>.part_footer {
                height: 100%;
            }

            #f_section3 {
                min-height: 0;
            }

            /* TABLES */
            #punmedio_blue_t_container {
                border: 0.5px solid #5093e6;
                ;
                width: 100%;
            }

            #punmedio_blue_t_container>div {
                max-width: calc(50% - 2px);
            }

            #m_section2 {
                position: relative;
            }

            #m_section2 table {
                border-collapse: collapse;
                width: 360px;
                position: relative;
                left: 30%;
                transform: translateX(-50%);
            }

            #m_section2 tr {
                float: right;
            }

            #m_section2 th,
            #m_section2 td {
                width: 90px;
                border-collapse: collapse !important;
                border: 1px solid #221f1f;
                padding: 4px 5px;
                letter-spacing: 1px;
                text-align: center;
            }

            #m_section2 td {
                background-color: #d6e3bc;
            }

            #m_section5 table {
                border-collapse: collapse !important;
            }

            #m_section5 td {
                border: 0.5px solid #5093e6;
                ;
            }

            #blue_t_list {
                border-bottom: 0.5px solid #5093e6;
                ;
            }

            #m_section5 table td {
                width: 50%;
            }

            #separator {
                width: 100%;
                height: 1px;
                background-color: #5093e6;
            }

            .flat_table {
                position: relative;
                display: -webkit-box;
                -webkit-box-pack: center;
                margin-right: 700px;
            }

            .flat_table table {
                border-collapse: collapse;
                width: 360px;
                position: relative;
                left: 30%;
                transform: translateX(-50%);
                margin-right: 30px;
            }

            .flat_table th,
            .flat_table td {
                width: 40px;
                border-collapse: collapse !important;
                border: 1px solid #221f1f;
                padding: 2px 3px;
                text-align: center;
            }

            .white_table table {
                border-collapse: collapse;
                width: 700px;
                position: relative;
                margin: 0 20px 0 20px;
                transform: translateX(-50%);
            }

            .white_table th,
            .white_table td {
                width: 120px;
                border-collapse: collapse !important;
                border: 1px solid #221f1f;
                padding: 2px 3px;
                text-align: center;
            }

            .month_table table {
                border-collapse: collapse;
                width: 500px;
                position: relative;
                margin: 0 20px 0 20px;
                transform: translateX(-50%);
            }

            .month_table th,
            .month_table td {
                width: 100px;
                border-collapse: collapse !important;
                border: 1px solid #221f1f;
                padding: 2px 3px;
                text-align: center;
            }

            .simple_table_container {
                display: flex;
            }

            #m_section_last {
                display: -webkit-box;
                -webkit-box-pack: justify;

            }

            #m_section_last table {
                border-collapse: collapse;
            }

            #m_section_last table td,
            #m_section_last table th {
                border: 1px solid black;
                padding: 3px 5px;
            }

            .lightblue_table {
                position: relative;
                display: flex;
                justify-content: center;
                display: -webkit-box;
                -webkit-box-pack: center;
            }

            .lightblue_table table {
                border-collapse: collapse;
                width: 500px;
                position: relative;
                margin: 0 20px 0 20px;
                transform: translateX(-50%);
                border: 3px solid black;
            }

            .lightblue_table th,
            .lightblue_table td {
                width: 50%;
                border-collapse: collapse !important;
                border: 1px solid #221f1f;
                padding: 10px 15px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="page">
            <!-- HEADER -->
            <header class="page-header">
                <section id="h_section1">
                    <div class="img_header">
                        <img src="https://www.plank.global/plank/<?= (my_json_decode($azienda['link_logoimg'])[0]['name']) ?>" alt="" height="100">
                    </div>
                    <div class="img_header">
                        <img src="https://www.plank.global/plank/images/erreci_logoev.jpg" alt="" height="100">
                    </div>
                </section>
                <section id="h_section2">
                    <div class="titleOrange">
                        <?= $record['nomeofferta'] . ' ' . $azienda['densociale'] . ' - ' . ((strcmp($utility, 'GAS') == 0) ? 'Gas Naturale' : 'Energia Elettrica') ?>
                    </div>
                </section>
                <section id="h_section3">
                    <div class="mainBlack">
                        CONDIZIONI ECONOMICHE <br>
                        <?php
                        if (strcmp($utility, 'EE') == 0) {
                            switch (strtoupper($record['template_pdf'])) {
                                case 'OFFERTA PUN MEDIO P.IVA':
                                    echo ('Offerta dedicata ai Clienti finali non domestici titolari di punti di prelievo per Energia Elettrica con consumi
                inferiori a 500.000 kWh/anno.');
                                    break;
                                case 'DIPENDENTI PUN':
                                    echo ('Offerta dedicata ai Clienti finali domestici titolari di punti di prelievo per Energia Elettrica e dipendenti di Erreci s.r.l.');
                                    break;
                                case 'FISSO PER TE EE':
                                    echo ('Offerta dedicata ai Clienti finali non domestici titolari di punti di prelievo per Energia Elettrica con consumi
                inferiori a 500.000 kWh/anno.');
                                    break;
                                case '50 SPECIAL EE':
                                    echo ('Offerta applicabile unicamente a punti di fornitura con almeno 100.000 kWh di consumo annuo e contatori di 
                    misura dell’energia di tipo orario.');
                                    break;
                                default:
                                    echo ('Offerta dedicata ai Clienti finali titolari di punti di prelievo per Energia Elettrica alimentati in bassa tensione 
                per USI DOMESTICI.');
                                    break;
                            }
                        }
                        if (strcmp($utility, 'GAS') == 0) {
                            switch (strtoupper($record['template_pdf'])) {
                                case '50 SPECIAL GAS':
                                    echo ('Offerta applicabile unicamente a punti di fornitura con almeno 50.000 Smc di consumo annuo.');
                                    break;
                                case 'GAS CERTO ERRECI P.IVA':
                                    echo ('Offerta dedicata ai Clienti finali non domestici titolari di un punto di riconsegna allacciato alla rete di distribuzione di gas naturale e con consumi non superiori a 200.000 mc/anno.');
                                    break;
                                case 'GAS PSV ERRECI P.IVA':
                                    echo ('Offerta dedicata ai Clienti finali non domestici titolari di punti di prelievo per GAS Naturale alimentati in bassa 
                                    pressione con consumi non superiori a 200.000 Smc/anno.');
                                    break;
                                case 'CASAGREEN PSV':
                                    echo ('Offerta dedicata ai Clienti finali non domestici titolari di punti di prelievo per GAS Naturale alimentati in bassa 
                                    pressione con consumi non superiori a 200.000 Smc/anno.');
                                    break;
                                default:
                                    echo ('Offerta applicabile unicamente a punti di fornitura con almeno 50.000 Smc di consumo annuo.');
                                    break;
                            }
                        }
                        ?>
                    </div>
                </section>
                <?php
                if (strcmp($utility, 'EE') == 0) {
                    switch (strtoupper($record['template_pdf'])) {
                        case 'OFFERTA CASAGREEN PUN MEDIO':
                ?>
                            <section id="h_section4">
                                <div class="buyGreen">
                                    Acquista energia VERDE a prezzo variabile
                                </div>
                            </section>
                            <section id="h_section5">
                                <div class="smallP">
                                    Un’offerta dinamica e green che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati energetici.
                                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che
                                    all’energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”,
                                    contenente materiale pubblicitario e il marchio “Energia Verde Powered By Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di
                                    contratti di vendita di energia rinnovabile.
                                </div>
                            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->

            <main class="container">
                <section id="m_section1">
                    <div class="mainBlack">
                        SERVIZI DI VENDITA
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Componente Energia:</span> il prezzo della componente energia, come di seguito definito, sarà applicato all’energia elettrica prelevata e alle relative perdite di rete
                        (definite dalla Delibera ARERA/ARG/elt 107/09 e s.m.i. e pari ad oggi, per un Cliente residenziale, al 10,2% dell’energia prelevata).
                        L’offerta si intende valida per 12 mesi a partire dalla data prevista di avvio della fornitura indicata nella proposta di somministrazione.
                    </div>
                </section>
                <section id="m_section2">
                    <table class="standard_margin">
                        <tr>
                            <th style="width: 270px;border-top: 2px solid #221f1f;border-right: 2px solid #221f1f;border-left: 2px solid #221f1f;" colspan="2">Prezzi €/kWh</th>
                        </tr>
                        <tr>
                            <th style="border-left: 2px solid #221f1f; border-bottom: none;">F1</th>
                            <th style="border-bottom: none;">F2</th>
                            <th style="border-right: 2px solid #221f1f;border-bottom: none;">F3</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #221f1f;">Pun +</td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f1'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f2'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;border-right: 2px solid #221f1f "><?= number_format($record['s_f3'] / 1000, 3, ',', '.') ?></td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP ">
                        Il prezzo varia ogni ora all’interno del periodo contrattuale. Il PUN (Prezzo Unico Nazionale) è il prezzo di acquisto dell’energia elettrica che si forma nel mercato
                        elettrico italiano (IPEX) ogni ora dell’anno come stabilito dall’art. 30, comma 4, lettera c) della Delibera ARERA n. 111/06 e s.m.i.
                        Il corrispettivo dovuto dal Cliente viene calcolato in base al misuratore orario di cui è dotato il punto di prelievo, come indicato di seguito:
                    </div>
                    <div class="smallP">
                        - Punto di prelievo con misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo orario;
                    </div>
                    <div class="smallP">
                        - Punto di prelievo con misuratore programmato per fasce: in ogni fascia oraria determinata secondo la Delibera ARERA n. 181/06 e s.m.i., il prodotto
                        tra il prezzo indicato sopra e il consumo della fascia di competenza del periodo di fornitura ripartito su base oraria secondo il profilo residuo d’area
                        come descritto nella Delibera ARERA n. 118/03 e s.m.i.;
                    </div>
                    <div class="smallP standard_margin">
                        - Punto di prelievo non dotato di misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo del periodo di fornitura ripartito su base oraria
                        secondo il profilo residuo d’area come descritto nella deliberazione ARERA n. 118/03 e s.m.i.
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Oneri di dispacciamento:</span> saranno disciplinati dalla Delibera ARERA n. 111/06 e s.m.i..
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Costi di commercializzazione:</span> Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                        disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall’ARERA.
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Costo di aggregazione misure:</span> : saranno disciplinati dall’Allegato A alla deliberazione ARERA 30 Luglio 2009 ARG/elt 107/09 e s.m.i
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Corrispettivo Sistema Informativo:</span> : sarà disciplinato dalla Deliberazione ARERA 27 Dicembre 2017 915/2017/R/COM
                    </div>
                </section>
                <section id="m_section4">
                    <div class="mainBlack">
                        SPESA PER IL TRASPORTO DELL’ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA
                    </div>
                    <div class="smallP standard_margin">
                        Per la distribuzione, la misura e il trasporto dell’energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                        Locale, da Terna e dall’ARERA compresa la componente Asos, a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e assimilate. Tali
                        tariffe sono aggiornate con modalità e tempi stabiliti dalle autorità competenti, dall’ARERA e dal Distributore Locale. Il Cliente si impegna inoltre a corrispondere
                        eventuali nuove componenti stabilite dall’ARERA, di volta in volta applicabili.
                    </div>
                    <div class="smallP">
                        Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente
                    </div>
                </section>

                <section id="m_section5">
                    <table>
                        <tr>
                            <td style="padding: 15px;">
                                <div class="mediumBlack bold standard_margin">LA BOLLETTA DI UNA FAMIGLIA ITALIANA: COSA È UTILE
                                    SAPERE</div>
                                <p class="smallP">
                                    La spesa per l’energia elettrica, al netto delle imposte, è composta dai
                                    corrispettivi per i servizi di vendita, che remunerano le attività del
                                    fornitore (<?= $azienda['densociale'] ?>) e dai corrispettivi per i servizi di rete, che
                                    remunerano i servizi di distribuzione, misura e trasporto effettuati dal
                                    Distributore e da Terna, nonché gli oneri generali del sistema elettrico.
                                    La tabella riporta l’incidenza de i corrispettivi sopra descritti sulla stima
                                    della spesa annua, imposte escluse, per una famiglia tipo con consumo
                                    pari a 2.700 kWh/anno, potenza impegnata pari a 3 kW nell’abitazione
                                    di residenza.
                                </p>
                            </td>
                            <td class="smallP">
                                <div style="margin: 15px;">
                                    <div class="mediumBlack bold standard_margin">SERVIZI DI VENDITA</div>
                                    <ul style="margin-left:15px">
                                        <li>
                                            Componente energia e perdite di rete
                                        </li>
                                        <li> Oneri di dispacciamento</li>
                                        <li> Costi di commercializzazione</li>
                                    </ul>
                                </div>
                                <div id="separator"></div>
                                <div style="margin: 15px;">
                                    <div class="mediumBlack bold standard_margin">SERVIZI DI RETE E ONERI GENERALI DI SISTEMA</div>
                                    <p class="smallP">
                                        Corrispettivi per i servizi di rete e oneri generali di
                                        cui il 20% dovuto alla componente Asos. Tale
                                        componente serve per finanziare il sistema di
                                        incentivi riconosciuti per la produzione di energia
                                        elettrica da fonti rinnovabili o da fonti assimilate alle
                                        rinnovabili. È a carico di tutti i clienti elettrici.
                                    </p>

                                </div>
                            </td>
                        </tr>
                    </table>
                    <span class="standard_margin" style="font-size: 7px;">Il valore massimo del PUN negli ultimi 12 mesi è stato pari a <?= number_format($prezzi['ultimoanno'], 4, ',', '.') ?> €/kWh (mese di <?= strftime("%b %Y", strtotime($prezzi['inizio']))  ?>). Il valore del PUN di <?= strftime("%b %Y", strtotime($prezzi['fine']))  ?> è stato pari a <?= number_format($prezzi['ultimomese'], 4, ',', '.') ?> €/kWh</span>
                </section>
            </main>
        <?php
                            break;
                        case '50 SPECIAL EE':
        ?>
            <section id="h_section4">
                <div class="buyGreen">
                    Acquista energia VERDE
                </div>
            </section>
            <section id="h_section5">
                <div class="smallP">
                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che all’energia
                    consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”, contenente materiale
                    pubblicitario e il marchio “Energia Verde Powered By Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di contratti di vendita di
                    energia rinnovabile. <br class="standard_margin">
                    L’offerta ti permette di avere la sicurezza di acquistare a prezzo fisso il 50% dell’energia consumata ed il restante 50% a prezzo variabile in modo da avere prezzo
                    sempre allineato al reale andamento dei mercati energetici. <br class="standard_margin">
                    Per la fornitura di energia elettrica verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di Contratto):
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="subtitle bold smallP">
                        PREZZI
                    </div>
                    <div class=" smallP">
                        Per la somministrazione dell'energia elettrica oggetto della presente offerta, il Cliente si impegna a corrispondere al Fornitore i prezzi sottoindicati che verranno
                        adeguati nel periodo contrattuale come ivi previsto. Tali prezzi sono relativi alla sola componente "energia" e sono pertanto da intendersi al netto delle perdite di
                        rete, del trasporto e del dispacciamento. I prezzi sono comprensivi degli oneri conseguenti l'applicazione della normativa europea in materia di emissioni di CO2
                        (Direttiva Europea 2003/87/CE del 13/10/2003). I prezzi offerti sono subordinati all’impegno a conferire delega al Fornitore o ad altra società indicata dallo stesso
                        per l’assegnazione di capacità di trasporto con l’estero, energia CIP6 o altre assegnazioni particolari eventualmente disposte dalle Autorità competenti. Le eventuali
                        assegnazioni non comporteranno modifiche alle condizioni economiche della presente offerta. <br class="standard_margin">
                        L’applicazione dei prezzi per fasce è comunque subordinata alla comunicazione dei consumi differenziati per fascia oraria da parte del Distributore Locale.
                        Le fasce orarie sono definite in base alla Delibera ARERA n. 181/06 e s.m.i.. <br class="standard_margin">
                        Per la fornitura di energia elettrica verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di Contratto)
                    </div>
                </section>
                <section class="flat_table">
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="blue" style="width: 180px" colspan="2">50% DEI CONSUMI<br>PREZZO FISSO PER FASCE</th>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F1</div>
                                <p class="smallP"> 8.00 – 19.00 dal Lunedi al Venerdi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f1'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F2</div>
                                <p class="smallP">7.00-8.00 e 19.00-23.00 giorni lavorativi 7.00 – 23.00 Sabato</p>
                            </th>
                            <td>
                                <p class="smallP"><?= number_format($record['c_f2'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F3</div>
                                <p class="smallP"> 23.00 – 7.00 giorni lavorativi, Domenica e festivi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f3'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                    </table>
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="tableGreen" style="width: 180px" colspan="2">50% DEI CONSUMI<br>PREZZO VARIABILE</th>
                        </tr>
                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <td>
                                <p class="smallP bold"> Prezzi €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <td>
                                <p class="smallP bold">SPREAD</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> PUN ORARIO +</div>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['s_f1'] / 1000, 3, ',', '.') ?></p>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP standard_margin">
                        Al 50% dei consumi e alle relative perdite di rete, per ciascuna fascia di consumo, verranno aplicati i corrispettivi fissi sopraindicati.
                        Al restante 50% dei consumi, per ciascuna fascia di consumo, e per ciascun punto di prelievo verrà applicato un corrispettivo pari al prodotto tra il Prezzo Unico
                        Nazionale (PUN* orario), formatosi nel Mercato del Giorno Prima (MGP) del Gestore dei Mercati Elettrici (GME) durante il mese di fornitura, e l’effettivo prelievo
                        orario aumentato delle perdite di rete, maggiorato dello spread di cui sopra. Il Fornitore gestirà direttamente gli sbilanciamenti senza chiedere al Cliente i programmi
                        di prelievo (curva oraria). Conseguentemente gli oneri di sbilanciamento rimarranno a carico del Fornitore. <br>
                        Al cliente sarà addebitata una quota fissa di gestione della fornitura, per ciascun punto di prelievo pari a 2,63 €/giorno/pdp.
                    </div>
                    <div class="smallP standard_margin">
                        Il valore massimo del PUN negli ultimi 12 mesi è stato pari a <?= number_format($prezzi['ultimoanno'], 4, ',', '.') ?> €/kWh (mese di <?= strftime("%b %Y", strtotime($prezzi['inizio']))  ?>). Il valore del PUN di <?= strftime("%b %Y", strtotime($prezzi['fine']))  ?> è stato pari a <?= number_format($prezzi['ultimomese'], 4, ',', '.') ?> €/kWh.
                    </div>
                    <div class="smallP subtitle standard_margin">
                        Offerta applicabile unicamente a punti di fornitura con almeno 100.000 kWh di consumo annuo e contatori di misura dell’energia di tipo orario
                    </div>
                </section>
                <section id="m_section4">
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Durata:
                    </div>
                    <div class="part_footer smallP bold">
                        - Dal <?= date('d/m/Y', strtotime($datainiziofix)) ?> al <?= date('d/m/Y', strtotime($record['datafinefornitura'])) ?>
                    </div>
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                    <div class="part_footer smallP">
                        Il Cliente ha la facoltà di chiedere l’applicazione di corrispettivi fissi in sostituzione del corrispettivo variabile PUN in ogni momento della durata del Contratto. Le
                        quotazioni possono essere richieste relativamente a un periodo minimo di un trimestre. Erreci srl si impegna a presentare al Cliente, tempestivamente e comunque
                        entro 2 giorni lavorativi dalla richiesta, una proposta con la quotazione a prezzo fisso, specificando la relativa validità temporale, i termini e le condizioni della
                        accettazione. In caso di accettazione della proposta da parte del Cliente, l’applicazione dei nuovi corrispettivi decorrerà dal primo giornodel primo mese del periodo
                        per il quale è stata avanzata la richiesta di quotazione a prezzo fisso fino alla scadenza del medesimo periodo.Alla fine del periodo, per il quale è stata avanzata la
                        richiesta di quotazione a prezzo fisso,si applica nuovamente il corrispettivo pari al PUN+spread.
                    </div>
                </section>
            </main>
        <?php
                            break;
                        case 'OFFERTA PUN MEDIO P.IVA':
        ?>
            <section id="h_section4">
                <div class="buyGreen">
                    Acquista energia VERDE a prezzo variabile
                </div>
            </section>
            <section id="h_section5">
                <div class="smallP">
                    Un’offerta dinamica e green che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati energetici <br class="standard_margin">
                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che
                    all’energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”,
                    contenente materiale pubblicitario e il marchio “Energia Verde Powered By Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di
                    contratti di vendita di energia rinnovabile. <br class="standard_margin">
                    Per la fornitura di energia elettrica verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di
                    Contratto):
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="mainBlack">
                        SPESA PER LA MATERIA ENERGIA
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Componente Energia:</span> il prezzo della componente energia, come di seguito definito, sarà applicato all’energia elettrica prelevata e alle relative perdite di rete
                        (definite dalla Delibera ARERA/ARG/elt 107/09 e s.m.i.) L’offerta si intende valida per 12 mesi a partire dalla data prevista di avvio della fornitura indicata nella
                        proposta di somministrazione.
                    </div>
                </section>
                <section id="m_section2">
                    <table class="standard_margin">
                        <tr>
                            <th style="width: 270px;border-top: 2px solid #221f1f;border-right: 2px solid #221f1f;border-left: 2px solid #221f1f;" colspan="2">Prezzi €/kWh</th>
                        </tr>
                        <tr>
                            <th style="border-left: 2px solid #221f1f; border-bottom: none;">F1</th>
                            <th style="border-bottom: none;">F2</th>
                            <th style="border-right: 2px solid #221f1f;border-bottom: none;">F3</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #221f1f;">Pun +</td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f1'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f2'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;border-right: 2px solid #221f1f "><?= number_format($record['s_f3'] / 1000, 3, ',', '.') ?></td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP ">
                        Il prezzo varia ogni ora all’interno del periodo contrattuale. Il PUN (Prezzo Unico Nazionale) è il prezzo di acquisto dell’energia elettrica che si forma nel mercato
                        elettrico italiano (IPEX) ogni ora dell’anno come stabilito dall’art. 30, comma 4, lettera c) della Delibera ARERA n. 111/06 e s.m.i.
                        Il corrispettivo dovuto dal Cliente viene calcolato in base al misuratore orario di cui è dotato il punto di prelievo, come indicato di seguito:
                    </div>
                    <div style="margin-left: 30px;">
                        <div class="smallP">
                            Punto di prelievo con misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo orario;
                        </div>
                        <div class="smallP">
                            Punto di prelievo con misuratore programmato per fasce: in ogni fascia oraria determinata secondo la Delibera ARERA n. 181/06 e s.m.i., il prodotto
                            tra il prezzo indicato sopra e il consumo della fascia di competenza del periodo di fornitura ripartito su base oraria secondo il profilo residuo d’area
                            come descritto nella Delibera ARERA n. 118/03 e s.m.i.;
                        </div>
                        <div class="smallP standard_margin">
                            Punto di prelievo non dotato di misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo del periodo di fornitura ripartito su base oraria
                            secondo il profilo residuo d’area come descritto nella deliberazione ARERA n. 118/03 e s.m.i.
                        </div>
                        <div class="smallP standard_margin">
                            Il valore massimo del PUN negli ultimi 12 mesi è stato pari a <?= number_format($prezzi['ultimoanno'], 4, ',', '.') ?> €/kWh (mese di <?= strftime("%b %Y", strtotime($prezzi['inizio']))  ?>). Il valore del PUN di <?= strftime("%b %Y", strtotime($prezzi['fine']))  ?> è stato pari a <?= number_format($prezzi['ultimomese'], 4, ',', '.') ?> €/kWh
                        </div>
                    </div>

                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Oneri di dispacciamento:</span> saranno disciplinati dalla Delibera ARERA n. 111/06 e s.m.i..
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Costi di commercializzazione:</span> Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                        disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall’ARERA.
                    </div>
                    <div class="smallP standard_margin">
                        La somma di tutti i corrispettivi per i servizi di vendita sopra descritti rappresenta circa il 43% della spesa complessiva di un cliente tipo, con consumi annui
                        pari a 10.000 kWh e una potenza impegnata pari a 10kW, escluse IVA e imposte. Il peso della sola componente energia, che corrisponde all’analoga
                        componente fissata dall’Autorità, comprensiva della perequazione e al netto delle perdite di rete, esclusa IVA e imposte, è pari a circa il 30% della spesa
                        complessiva per l’energia elettrica.
                    </div>
                </section>
                <section id="m_section4">
                    <div class="mainBlack">
                        SPESA PER IL TRASPORTO DELL’ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA
                    </div>
                    <div class="smallP standard_margin">
                        Per la distribuzione, la misura e il trasporto dell’energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                        Locale, da Terna e dall’ARERA compresa la componente Asos, a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e da
                        cogenerazione. È a carico di tutti i clienti elettrici. Tali tariffe sono aggiornate con modalità e tempi stabiliti dalle autorità competenti, dall’ARERA e dal
                        Distributore Locale. Il Cliente si impegna inoltre a corrispondere eventuali nuove componenti stabilite dall’ARERA, di volta in volta applicabili.
                        La somma di tutti i corrispettivi per la spesa per il servizio di trasporto e gestione del contatore sopra descritti e per la spesa degli oneri di sistema,
                        rappresentano rispettivamente circa il 21% e il 39% della spesa complessiva del suddetto cliente tipo. <br>
                    </div>
                    <div class="smallP">
                        Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente.
                    </div>
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                    <div class="part_footer smallP">
                        Il Cliente ha la facoltà di chiedere l’applicazione di corrispettivi fissi in sostituzione del corrispettivo variabile PUN in ogni momento della durata del Contratto. Le
                        quotazioni possono essere richieste relativamente a un periodo minimo di un trimestre, fino all’intero periodo contrattuale residuo. <?= $azienda['densociale'] ?> si impegna a
                        presentare al Cliente, tempoestivamente e comunque entro 2 giorni lavorativi dalla richiesta, una proposta con la quotazione a prezzo fisso, specificamndo la
                        relativa validità temporale, i termini e le condizioni della accettazione. In caso di accettazione della proposta da parte del Cliente, l’applicazione dei nuovi
                        corrispettivi decorrerà dal primo giorno del primo mese del periodo per il quale è stata avanzata la richiesta di quotazione a prezzo fisso fino alla scadenza del
                        medesimo periodo. Alla fine del periodo, per il quale è stata avanzata la richiesta di quotazione a prezzo fisso, si applica nuovamente il corrispettivo pari al PUN
                        + spread.
                    </div>
                </section>
            </main>
        <?php
                            break;
                        case 'OFFERTA CASAGREEN FISSO ERRECI':
        ?>
            <section id="h_section4">
                <div class="buyGreen">
                    Acquista Energia VERDE a prezzo FISSO
                </div>
            </section>
            <section id="h_section5">
                <div class="smallP standard_margin">
                    Un’offerta green che ti permette di avere la sicurezza di un prezzo fisso per tutta la durata contrattuale <br class="standard_margin">
                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che
                    all’energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”,
                    contenente materiale pubblicitario e il marchio “Energia Verde Powered by Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di
                    contratti di vendita di energia rinnovabile.<br class="standard_margin">
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="mainBlack">
                        SERVIZI DI VENDITA
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Componente Energia:</span> : I prezzi di seguito indicati si intendono validi per 12 mesi, saranno applicati all’energia elettrica prelevata e alle relative perdite di rete
                        (definite dalla Delibera ARERA ARG/elt 107/09 e s.m.i.), a partire dalla data prevista di avvio della fornitura indicata nella proposta di somministrazione. Al
                        termine di detto periodo le condizioni economiche applicate si intenderanno prorogate finché <?= $azienda['densociale'] ?> non procederà ad aggiornarle, previa comunicazione
                        secondo le modalità e i termini indicati dall’articolo 26 comma 4 e art. 17 delle Condizioni Generali di Contratto. L’applicazione dei prezzi per fasce è comunque
                        subordinata alla comunicazione dei consumi differenziati per fascia oraria da parte del Distributore Locale. Le fasce orarie sono definite in base alla Delibera
                        ARERA n. 181/06 e s.m.i..
                    </div>
                </section>
                <section class="flat_table">
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="tableGreen" colspan="2">PREZZO PER FASCE</th>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F1</div>
                                <p class="smallP"> 8.00 – 19.00 dal Lunedi al Venerdi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f1'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F2</div>
                                <p class="smallP">7.00-8.00 e 19.00-23.00 giorni lavorativi 7.00 – 23.00 Sabato</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f2'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F3</div>
                                <p class="smallP"> 23.00 – 7.00 giorni lavorativi, Domenica e festivi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f3'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Oneri di dispacciamento:</span>Corrispettivo Sistema Informativo:
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP">Costi di commercializzazione:</span>: Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                        disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall’ARERA.
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP">Costo di aggregazione misure: </span> saranno disciplinati dall’Allegato A alla Deliberazione ARERA 30 Luglio 2009 ARG/elt 107/09 e s.m.i.
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP">Corrispettivo Sistema Informativo: </span>sarà disciplinato dalla Deliberazione ARERA 27 Dicembre 2017 915/2017/R/COM
                    </div>
                </section>
                <section id="m_section4">
                    <div class="mainBlack">
                        SPESA PER IL TRASPORTO DELL’ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA
                    </div>
                    <div class="smallP standard_margin">
                        Per la distribuzione, la misura e il trasporto dell’energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                        Locale, da Terna e dall’ARERA compresa la componente Asos, a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e da
                        cogenerazione. È a carico di tutti i clienti elettrici. Tali tariffe sono aggiornate con modalità e tempi stabiliti dalle autorità competenti, dall’ARERA e dal
                        Distributore Locale. Il Cliente si impegna inoltre a corrispondere eventuali nuove componenti stabilite dall’ARERA, di volta in volta applicabili.
                        La somma di tutti i corrispettivi per la spesa per il servizio di trasporto e gestione del contatore sopra descritti e per la spesa degli oneri di sistema,
                        rappresentano rispettivamente circa il 21% e il 39% della spesa complessiva del suddetto cliente tipo. <br>
                    </div>
                    <div class="smallP">
                        Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente.
                    </div>
                </section>
                <section id="m_section5">
                    <table>
                        <tr>
                            <td style="padding: 10px;">
                                <div class="mediumBlack bold standard_margin">LA BOLLETTA DI UNA FAMIGLIA ITALIANA: COSA È UTILE
                                    SAPERE</div>
                                <p class="smallP">
                                    La spesa per l’energia elettrica, al netto delle imposte, è composta dai
                                    corrispettivi per i servizi di vendita, che remunerano le attività del
                                    fornitore (<?= $azienda['densociale'] ?>) e dai corrispettivi per i servizi di rete, che
                                    remunerano i servizi di distribuzione, misura e trasporto effettuati dal
                                    Distributore e da Terna, nonché gli oneri generali del sistema elettrico.
                                    La tabella riporta l’incidenza de i corrispettivi sopra descritti sulla stima
                                    della spesa annua, imposte escluse, per una famiglia tipo con consumo
                                    pari a 2.700 kWh/anno, potenza impegnata pari a 3 kW nell’abitazione
                                    di residenza.
                                </p>
                            </td>
                            <td class="smallP">
                                <div style="margin: 10px;">
                                    <div class="mediumBlack bold standard_margin">SERVIZI DI VENDITA</div>
                                    <ul style="margin-left:15px">
                                        <li>
                                            Componente energia e perdite di rete
                                        </li>
                                        <li> Oneri di dispacciamento</li>
                                        <li> Costi di commercializzazione</li>
                                    </ul>
                                </div>
                                <div id="separator"></div>
                                <div style="margin: 10px;">
                                    <div class="mediumBlack bold standard_margin">SERVIZI DI RETE E ONERI GENERALI DI SISTEMA</div>
                                    <p class="smallP">
                                        Corrispettivi per i servizi di rete e oneri generali di
                                        cui il 20% dovuto alla componente Asos. Tale
                                        componente serve per finanziare il sistema di
                                        incentivi riconosciuti per la produzione di energia
                                        elettrica da fonti rinnovabili o da fonti assimilate alle
                                        rinnovabili. È a carico di tutti i clienti elettrici.
                                    </p>

                                </div>
                            </td>
                        </tr>
                    </table>
                </section>
            </main>
        <?php
                            break;
                        case 'FISSO PER TE EE':
        ?>

            <section id="h_section5">
                <div class="smallP standard_margin">
                    Un’offerta green che ti permette di avere la sicurezza di un prezzo fisso per tutta la durata contrattuale <br class="standard_margin">
                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che
                    all’energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”,
                    contenente materiale pubblicitario e il marchio “Energia Verde Powered by Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di
                    contratti di vendita di energia rinnovabile.<br class="standard_margin">
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="mainBlack">
                        SERVIZI DI VENDITA
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Componente Energia:</span> : I prezzi di seguito indicati si intendono validi per 12 mesi, saranno applicati all’energia elettrica prelevata e alle relative perdite di rete
                        (definite dalla Delibera ARERA ARG/elt 107/09 e s.m.i.), a partire dalla data prevista di avvio della fornitura indicata nella proposta di somministrazione. Al
                        termine di detto periodo le condizioni economiche applicate si intenderanno prorogate finché <?= $azienda['densociale'] ?> non procederà ad aggiornarle, previa comunicazione
                        secondo le modalità e i termini indicati dall’articolo 26 comma 4 e art. 17 delle Condizioni Generali di Contratto. L’applicazione dei prezzi per fasce è comunque
                        subordinata alla comunicazione dei consumi differenziati per fascia oraria da parte del Distributore Locale. Le fasce orarie sono definite in base alla Delibera
                        ARERA n. 181/06 e s.m.i..
                    </div>
                </section>
                <section class="flat_table">
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="blue" style="width: 180px" colspan="2">PREZZO PER FASCE</th>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F1</div>
                                <p class="smallP"> 8.00 – 19.00 dal Lunedi al Venerdi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f1'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F2</div>
                                <p class="smallP">7.00-8.00 e 19.00-23.00 giorni lavorativi 7.00 – 23.00 Sabato</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f2'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin"> FASCIA F3</div>
                                <p class="smallP"> 23.00 – 7.00 giorni lavorativi, Domenica e festivi</p>
                            </th>
                            <td>
                                <p class="smallP"> <?= number_format($record['c_f3'] / 1000, 3, ',', '.') ?> €/kWh</p>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Oneri di dispacciamento:</span>Corrispettivo Sistema Informativo:
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP">Costi di commercializzazione:</span>: Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                        disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall’ARERA.
                    </div>
                </section>
                <section id="m_section4">
                    <div class="mainBlack">
                        SPESA PER IL TRASPORTO DELL’ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA
                    </div>
                    <div class="smallP standard_margin">
                        Per la distribuzione, la misura e il trasporto dell’energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                        Locale, da Terna e dall’ARERA compresa la componente Asos, a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e da
                        cogenerazione. È a carico di tutti i clienti elettrici. Tali tariffe sono aggiornate con modalità e tempi stabiliti dalle autorità competenti, dall’ARERA e dal
                        Distributore Locale. Il Cliente si impegna inoltre a corrispondere eventuali nuove componenti stabilite dall’ARERA, di volta in volta applicabili.
                        La somma di tutti i corrispettivi per la spesa per il servizio di trasporto e gestione del contatore sopra descritti e per la spesa degli oneri di sistema,
                        rappresentano rispettivamente circa il 21% e il 39% della spesa complessiva del suddetto cliente tipo. <br>
                    </div>
                    <div class="smallP">
                        Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente.
                    </div>
                </section>
            </main>
        <?php
                            break;
                        default:
        ?>
            <section id="h_section4">
                <div class="buyGreen">
                    Acquista energia VERDE a prezzo variabile
                </div>
            </section>
            <section id="h_section5">
                <div class="smallP">
                    Un’offerta dinamica e green che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati energetici <br class="standard_margin">
                    La scelta di energia verde consente l’acquisto della certificazione di energia prodotta da fonti rinnovabili. Il cliente riceverà un attestato che certifichi che
                    all’energia consumata corrisponde un uguale quantitativo di energia verde prodotta. Verrà messo a disposizione del cliente anche il “pacchetto verde”,
                    contenente materiale pubblicitario e il marchio “Energia Verde Powered By Erreci”. Il Contratto è coerente con la regolazione definita dall’ARERA in materia di
                    contratti di vendita di energia rinnovabile. <br class="standard_margin">
                    Per la fornitura di energia elettrica verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di
                    Contratto):
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="mainBlack">
                        SPESA PER LA MATERIA ENERGIA
                    </div>
                    <div class="smallP">
                        <span class=" subtitle bold smallP"> Componente Energia:</span> il prezzo della componente energia, come di seguito definito, sarà applicato all’energia elettrica prelevata e alle relative perdite di rete
                        (definite dalla Delibera ARERA/ARG/elt 107/09 e s.m.i.) L’offerta si intende valida per 12 mesi a partire dalla data prevista di avvio della fornitura indicata nella
                        proposta di somministrazione.
                    </div>
                </section>
                <section id="m_section2">
                    <table class="standard_margin">
                        <tr>
                            <th style="width: 270px;border-top: 2px solid #221f1f;border-right: 2px solid #221f1f;border-left: 2px solid #221f1f;" colspan="2">Prezzi €/kWh</th>
                        </tr>
                        <tr>
                            <th style="border-left: 2px solid #221f1f; border-bottom: none;">F1</th>
                            <th style="border-bottom: none;">F2</th>
                            <th style="border-right: 2px solid #221f1f;border-bottom: none;">F3</th>
                        </tr>
                        <tr>
                            <td style="border: 2px solid #221f1f;">Pun +</td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f1'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;"><?= number_format($record['s_f2'] / 1000, 3, ',', '.') ?></td>
                            <td style="border-bottom: 2px solid #221f1f;border-right: 2px solid #221f1f "><?= number_format($record['s_f3'] / 1000, 3, ',', '.') ?></td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP ">
                        Il prezzo varia ogni ora all’interno del periodo contrattuale. Il PUN (Prezzo Unico Nazionale) è il prezzo di acquisto dell’energia elettrica che si forma nel mercato
                        elettrico italiano (IPEX) ogni ora dell’anno come stabilito dall’art. 30, comma 4, lettera c) della Delibera ARERA n. 111/06 e s.m.i.
                        Il corrispettivo dovuto dal Cliente viene calcolato in base al misuratore orario di cui è dotato il punto di prelievo, come indicato di seguito:
                    </div>
                    <div style="margin-left: 30px;">
                        <div class="smallP">
                            Punto di prelievo con misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo orario;
                        </div>
                        <div class="smallP">
                            Punto di prelievo con misuratore programmato per fasce: in ogni fascia oraria determinata secondo la Delibera ARERA n. 181/06 e s.m.i., il prodotto
                            tra il prezzo indicato sopra e il consumo della fascia di competenza del periodo di fornitura ripartito su base oraria secondo il profilo residuo d’area
                            come descritto nella Delibera ARERA n. 118/03 e s.m.i.;
                        </div>
                        <div class="smallP standard_margin">
                            Punto di prelievo non dotato di misuratore orario: il prodotto tra il prezzo indicato sopra e il consumo del periodo di fornitura ripartito su base oraria
                            secondo il profilo residuo d’area come descritto nella deliberazione ARERA n. 118/03 e s.m.i.
                        </div>
                        <div class="smallP standard_margin">
                            Il valore massimo del PUN negli ultimi 12 mesi è stato pari a <?= number_format($prezzi['ultimoanno'], 4, ',', '.') ?> €/kWh (mese di <?= strftime("%b %Y", strtotime($prezzi['inizio']))  ?>). Il valore del PUN di <?= strftime("%b %Y", strtotime($prezzi['fine']))  ?> è stato pari a <?= number_format($prezzi['ultimomese'], 4, ',', '.') ?> €/kWh
                        </div>
                    </div>

                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Oneri di dispacciamento:</span> saranno disciplinati dalla Delibera ARERA n. 111/06 e s.m.i..
                    </div>
                    <div class="smallP standard_margin">
                        <span class=" subtitle bold smallP">Costi di commercializzazione:</span> Al cliente verranno fatturati il Prezzo Commercializzazione Vendita (PCV), i costi della componente dispacciamento come
                        disciplinati dal TIV, pubblicati e aggiornati di volta in volta dall’ARERA.
                    </div>
                    <div class="smallP standard_margin">
                        La somma di tutti i corrispettivi per i servizi di vendita sopra descritti rappresenta circa il 43% della spesa complessiva di un cliente tipo, con consumi annui
                        pari a 10.000 kWh e una potenza impegnata pari a 10kW, escluse IVA e imposte. Il peso della sola componente energia, che corrisponde all’analoga
                        componente fissata dall’Autorità, comprensiva della perequazione e al netto delle perdite di rete, esclusa IVA e imposte, è pari a circa il 30% della spesa
                        complessiva per l’energia elettrica.
                    </div>
                </section>
                <section id="m_section4">
                    <div class="mainBlack">
                        SPESA PER IL TRASPORTO DELL’ENERGIA, GESTIONE DEL CONTATORE E ONERI DI SISTEMA
                    </div>
                    <div class="smallP standard_margin">
                        Per la distribuzione, la misura e il trasporto dell’energia elettrica e per gli oneri generali del sistema elettrico saranno applicate le tariffe previste dal Distributore
                        Locale, da Terna e dall’ARERA compresa la componente Asos, a copertura degli incentivi per la produzione di energia elettrica da fonti rinnovabili e da
                        cogenerazione. È a carico di tutti i clienti elettrici. Tali tariffe sono aggiornate con modalità e tempi stabiliti dalle autorità competenti, dall’ARERA e dal
                        Distributore Locale. Il Cliente si impegna inoltre a corrispondere eventuali nuove componenti stabilite dall’ARERA, di volta in volta applicabili.
                        La somma di tutti i corrispettivi per la spesa per il servizio di trasporto e gestione del contatore sopra descritti e per la spesa degli oneri di sistema,
                        rappresentano rispettivamente circa il 21% e il 39% della spesa complessiva del suddetto cliente tipo. <br>
                    </div>
                    <div class="smallP">
                        Tutti i corrispettivi sono da intendersi al netto delle imposte, che sono a carico del Cliente.
                    </div>
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                    <div class="part_footer smallP">
                        Il Cliente ha la facoltà di chiedere l’applicazione di corrispettivi fissi in sostituzione del corrispettivo variabile PUN in ogni momento della durata del Contratto. Le
                        quotazioni possono essere richieste relativamente a un periodo minimo di un trimestre, fino all’intero periodo contrattuale residuo. <?= $azienda['densociale'] ?> si impegna a
                        presentare al Cliente, tempoestivamente e comunque entro 2 giorni lavorativi dalla richiesta, una proposta con la quotazione a prezzo fisso, specificamndo la
                        relativa validità temporale, i termini e le condizioni della accettazione. In caso di accettazione della proposta da parte del Cliente, l’applicazione dei nuovi
                        corrispettivi decorrerà dal primo giorno del primo mese del periodo per il quale è stata avanzata la richiesta di quotazione a prezzo fisso fino alla scadenza del
                        medesimo periodo. Alla fine del periodo, per il quale è stata avanzata la richiesta di quotazione a prezzo fisso, si applica nuovamente il corrispettivo pari al PUN
                        + spread.
                    </div>
                </section>
            </main>
        <?php

                            break;
                    }
                }
                if (strcmp($utility, 'GAS') == 0) {
                    switch (strtoupper($record['template_pdf'])) {
                        case '50 SPECIAL GAS':
        ?>
            <section id="h_section4">
                <div style="color:#5093e6;">
                    Acquista GAS Naturale
                </div>
            </section>
            <section id="h_section5">
                <div class="smallP">
                    L’offerta ti permette di avere la sicurezza di acquistare a prezzo fisso il 50% del gas consumato ed il restante 50% a prezzo variabile in modo da avere prezzo
                    sempre allineato al reale andamento dei mercati energetici.
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="subtitle bold smallP">
                        PREZZI
                    </div>
                    <div class=" smallP">
                        Per la somministrazione del gas naturale oggetto della presente offerta, il Cliente si impegna a corrispondere al Fornitore i prezzi sottoindicati che verranno adeguati
                        nel periodo contrattuale come ivi previsto. Tali prezzi sono relativi alla sola componente "gas" e sono pertanto da intendersi al netto del trasporto e del
                        dispacciamento.
                        <br class="standard_margin">
                        Verranno addebitati e resteranno a carico del cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di
                        gas naturale (QVDfissa + 4 €/mese/PDR), alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti
                        con Delibera ARERA 64/09 ARG/gas e s.m.i. e con Delibera ARERA 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo
                        gravante. I corrispettivi unitari della presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1.
                        <br class="standard_margin">
                        Per la fornitura di gas naturale verranno fatturati al Cliente i seguenti corrispettivi (ulteriori dettagli agli artt. 26, 27 e 28 delle Condizioni Generali di Contratto)
                    </div>
                </section>
                <section class="flat_table clearfix">
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="blue" colspan="1">50% DEI CONSUMI
                                PREZZO FISSO</th>
                        </tr>
                        <tr>
                            <th>
                                <div class="mediumBlack bold standard_margin" style="text-align: center;"><?= number_format($record['p0'], 4, ',', '.') ?> €/Smc</div>
                            </th>
                    </table>
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th class="tableGreen" colspan="3">
                                50% DEI CONSUMI
                                PREZZO VARIABILE
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    Qp =
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    PSVda +
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    P0

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    Qp =
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    PSVda +
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    <?= number_format($record['s0'], 4, ',', '.') ?> €/Smc
                                </div>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP">
                        Qp è la quota materia prima, proporzionale ai consumi effettuati dall’utenza espressa in €/Smc
                    </div>
                    <div class="smallP">
                        Qf è la quota fissa mensile di trasporto è pari a ______ €/mese per CG pari a ________ Smc/g
                    </div>
                    <div class="smallP standard_margin">
                        Al 50% dei consumi verrà applicato il corrispettivo fisso sopraindicato.
                        Al restante 50% dei consumi e per ciascun punto di prelievo verrà applicato un corrispettivo variabile. Il PSVda è pari alla media aritmetica delle quotazioni giornaliere
                        “Heren Day Ahead Price”, espresse in €/MWh e convertite in €/Smc sulla base di un coefficiente moltiplicativo pari a 0,0105833. Per ciascun giorno del mese di
                        prelievo, la quotazione “Heren Day Ahead Price”, espressa in €/MWh è il prezzo “Offer” relativo al periodo “Day-ahead” pubblicato sotto il titolo “PSV PRICE
                        ASSESSMENT” nel report “ICIS Heren European Spot Gas Markets” del più vicino giorno lavorativo precedente secondo il calendario inglese, che fa riferimento alle
                        seguenti quotazioni: <br>
                        - “Day Ahead”, se il giorno in questione è un giorno lavorativo secondo il calendario inglese; <br>
                        - “Weekend”, se il giorno in questione non è un giorno lavorativo secondo il calendario inglese. <br>
                        Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                        nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore dell’impianto
                        di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARERA ARG/gas 69/04 (TIVG) e s.m.i. <br>
                        Al cliente sarà addebitata una quota fissa pari a 2,63 €/giorno/pdp, per modulazione, gestione della fornitura, aggiornamento prezzi, fixing mensile della quota
                        residua a prezzo variabile, per ciascun punto di prelievo. <br>
                        Il valore massimo del PSV negli ultimi 12 mesi è stato pari a 0,213 €/Smc (mese di Gennaio 2021). Il valore del PSV di Marzo 2021 è stato pari a 0,195
                        €/Smc. <br>
                        Offerta applicabile unicamente a punti di fornitura con almeno 50.000 Smc di consumo annuo

                    </div>
                </section>
                <section id="m_section4">
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Durata:
                    </div>
                    <div class="part_footer smallP bold">
                        - Dal <?= date('d/m/Y', strtotime($datainiziofix)) ?> al <?= date('d/m/Y', strtotime($record['datafinefornitura'])) ?>
                    </div>
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                    <div class="part_footer smallP">
                        Il Cliente ha la facoltà di chiedere l’applicazione di corrispettivi fissi in sostituzione del corrispettivo variabile PSV in ogni momento della durata del Contratto. Le
                        quotazioni possono essere richieste relativamente a un periodo minimo di un trimestre. Erreci srl si impegna a presentare al Cliente, tempestivamente e comunque
                        entro 2 giorni lavorativi dalla richiesta, una proposta con la quotazione a prezzo fisso, specificando la relativa validità temporale, i termini e le condizioni della
                        accettazione. In caso di accettazione della proposta da parte del Cliente, l’applicazione dei nuovi corrispettivi decorrerà dal primo giornodel primo mese del periodo
                        per il quale è stata avanzata la richiesta di quotazione a prezzo fisso fino alla scadenza del medesimo periodo.Alla fine del periodo, per il quale è stata avanzata la
                        richiesta di quotazione a prezzo fisso,si applica nuovamente il corrispettivo pari al PSV+Spread.
                    </div>

                </section>
                <section id="m_section_last">

                    <div class="smallP subtitle">
                        Penale per supero capacità giornaliera
                    </div>
                    <div>
                        <table style="margin-left: 250px;">
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Percentuale di supero %
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        €/Smc
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Fino al 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        0
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Oltre il 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        3,064
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </section>
            </main>
        <?php
                            break;

                        case 'GAS CERTO ERRECI P.IVA':
        ?>
            <section id="h_section5">
                <div class="smallP">
                    Alla componente materia prima gas naturale prelevata mensilmente nel punto di riconsegna verrà applicato il seguente corrispettivo, espresso in €/Smc Il
                    prezzo di seguito indicato si intende valido per 12 mesi a partire dalla data prevista di avvio della fornitura indicata nella proposta di somministrazione. Al
                    termine di detto periodo le condizioni economiche si intenderanno prorogate finché ERRECI S.r.l. non procederà ad aggiornarle, previa comunicazione
                    secondo le modalità e i termini indicati all’art. 35, comma 4 e art. 17 delle Condizioni Generali di Contratto. Verranno addebitati e resteranno a carico del
                    cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di gas naturale (QVDfissa + 4 €/mese/PDR),
                    alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti dall’Autorità di Regolazione per Energia
                    Reti e Ambiente con Delibera 64/09 ARG/gas e s.m.i. e con Delibera 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo
                    gravante. I corrispettivi unitari della presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section class="lightblue_table clearfix">
                    <table class="standard_margin floatLeft">
                        <tr>
                            <th style="width: 220px; background-color: #b8cce3;" colspan="2">
                                Prezzo della componente GAS
                            </th>
                            <td style="width: 180px; background-color: #b8cce3;">
                                <?= number_format($record['p0'], 4, ',', '.') ?> €/Smc
                            </td>
                        </tr>
                    </table>
                </section>
                <section class="white_table">
                    <table class="standard_margin">
                        <tr>
                            <th style="width: 180px" colspan="2">
                                <div class="smallP">
                                    Valori dei corrispettivi e relativo impatto sulla spesa annua per il gas naturale di una famiglia tipo con consumi pari a 1.400 Smc/anno, nell’ambito
                                    tariffario Nord - Occidentale, considerando un potere calorifico superiore pari a 0,03852 GJ/Smc e con riferimento al 3 ° Trimestre 2020
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                            </th>
                            <td>
                                <p class="mediumBlack bold" style="text-align: center;"> Quota %</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p class="smallP">Componente GAS</p>
                            </th>
                            <td>
                                <p class="smallP" style="text-align: center;">48%</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p class="smallP"> Corrispettivo a remunerazione dei costi di commercializzazione della vendita al dettaglio, sostenuti dal Fornitore sul mercato libero </p>
                            </th>
                            <td>
                                <p class="smallP" style="text-align: center;"> 11%</p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p class="smallP">Restanti Componenti (distribuzione e misura, trasporto, modalità di approvvigionamento
                                    all’ingrosso e altri oneri aggiuntivi)
                                </p>
                            </th>
                            <td>
                                <p class="smallP" style="text-align: center;">41%</p>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP standard_margin">
                        Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                        nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore
                        dell’impianto di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARG/gas 69/04 (TIVG) e
                        s.m.i..
                    </div>
                </section>
                <section id="m_section4">
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                    <div class="part_footer smallP">
                        Il bonus sociale per la fornitura di gas naturale è stato introdotto come misura sociale per ridurre la spesa in energia elettrica e gas naturale delle famiglie in
                        stato di disagio economico e può essere richiesto al proprio Comune. Il bonus è previsto anche per i casi di disagio fisico cioè quando nel nucleo familiare è
                        presente una persona in gravi condizioni di salute che richieda l'uso di apparecchiature salvavita alimentate ad energia elettrica. Per maggiori informazioni
                        visita il sito www.arera.it
                    </div>
                </section>
                <section id="m_section_last">

                    <div class="smallP subtitle">
                        Penale per supero capacità giornaliera
                    </div>
                    <div>
                        <table style="margin-left: 250px;">
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Percentuale di supero %
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        €/Smc
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Fino al 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        0
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Oltre il 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        3,064
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </section>
            </main>
        <?php
                            break;
                        case 'GAS PSV ERRECI P.IVA':
        ?>
            <section id="h_section4">
                <div style=" color: #5093e6;">
                    Acquista GAS Naturale a prezzo variabile
                </div>
            </section>
            <section id="h_section5" style="min-height: 0;">
                <div class="smallP">
                    Un’offerta dinamica che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati energetici
                </div>
            </section>
            </header>
            <!--FINE HEADER -->
            <!-- MAIN -->
            <main class="container">
                <section id="m_section1">
                    <div class="subtitle bold smallP">
                        Prezzo componente GAS Naturale
                    </div>
                    <div class=" smallP">
                        Il prezzo della Componente Gas è il corrispettivo applicato al gas naturale prelevato a copertura esclusivamente dei costi di approvvigionamento. L’offerta si
                        intende valida per 12 mesi a partire dalla data prevista di avvio dellla fornitura indicata nella proposta di somministrazione.
                        <br class="standard_margin">
                        Verranno addebitati e resteranno a carico del cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di
                        gas naturale (QVDfissa + 4 €/mese/PDR), alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti
                        con Delibera ARERA 64/09 ARG/gas e s.m.i. e con Delibera ARERA 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo
                        gravante. I corrispettivi unitari della presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1.
                        <br class="standard_margin">
                        La somma dei corrispettivi dei servizi di vendita sopra descritti rappresenta una quota percentuale pari a circa il 47% della spesa complessiva di un cliente tipo
                        non domestico con un consumo di 1.400 Smc/anno (considerando un potere caloridico superiore a 0,03852 GJ/Smc e con riferimento al Trimestre 2018,
                        eslcusa IVA e imposte. Il corrispettivo a remunerazione dei costi di commercializzazione alla vendita al dettaglio rappresentano, invece, il 9% della spesa
                        complessiva del suddetto cliente tipo. I restanti componenti (distribuzione, misura, trasporto, modalità di approvvigionamento all’ingrosso e altri oneri aggiuntivi,
                        invece, costituiscono il restante 44%.
                    </div>
                </section>
                <!-- TABELLA -->
                <section class="flat_table">
                    <table style="margin-left: 200px;" class="standard_margin floatLeft">
                        <tr>
                            <th class="tableGreen" colspan="3">
                                Prezzi €/Smc
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    Qp =
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    PSVda +
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    P0

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    Qp =
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    PSVda +
                                </div>
                            </td>
                            <td>
                                <div class="mediumBlack bold standard_margin">
                                    <?= number_format($record['s0'], 4, ',', '.') ?> €/Smc
                                </div>
                            </td>
                        </tr>
                    </table>
                </section>
                <section id="m_section3">
                    <div class="smallP standard_margin">
                        Qp è la quota materia prima, proporzionale ai consumi effettuati dall’utenza espressa in €/Smc <br>
                        PSVda è pari alla media aritmetica delle quotazioni giornaliere “Heren Day Ahead Price”, espresse in €/MWh e convertite in €/Smc sulla base di un
                        coefficiente moltiplicativo pari a 0,0105833. Per ciascun giorno del mese di prelievo, la quotazione “Heren Day Ahead Price”, espressa in €/MWh è il prezzo
                        “Offer” relativo al periodo “Day-ahead” pubblicato sotto il titolo “PSV PRICE ASSESSMENT” nel report “ICIS Heren European Spot Gas Markets” del più
                        vicino giorno lavorativo precedente secondo il calendario inglese, che fa riferimento alle seguenti quotazioni: <br>
                        - “Day Ahead”, se il giorno in questione è un giorno lavorativo secondo il calendario inglese; <br>
                        - “Weekend”, se il giorno in questione non è un giorno lavorativo secondo il calendario inglese. <br>
                    </div>
                    <div class="smallP standard_margin">
                        Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                        nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore
                        dell’impianto di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARERA ARG/gas 69/04
                        (TIVG) e s.m.i..
                    </div>
                    <div class="smallP standard_margin">
                        L’andamento storico dell’indice PSVda degli ultimi 12 mesi è stato pari ai valori sotto riportati:
                    </div>
                </section>
                <section class="month_table" style="min-height: 0;margin-left: 100px;">
                    <table>
                        <tr class="blue">
                            <th>
                                <span class="smallP">Mese</span>
                            </th>
                            <th>
                                <span class="smallP">PSVda c€/Smc </span>
                            </th>
                            <th>
                                <span class="smallP">Mese</span>
                            </th>
                            <th>
                                <span class="smallP">PSVda c€/Smc</span>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">apr-20</span>
                            </td>
                            <td>
                                <span class="smallP">9.2</span>
                            </td>
                            <td>
                                <span class="smallP">ott-20</span>
                            </td>
                            <td>
                                <span class="smallP">14.1</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">mag-20</span>
                            </td>
                            <td>
                                <span class="smallP">6.9</span>
                            </td>
                            <td>
                                <span class="smallP">nov-20</span>
                            </td>
                            <td>
                                <span class="smallP">14.8</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">giu-20</span>
                            </td>
                            <td>
                                <span class="smallP">6.3</span>
                            </td>
                            <td>
                                <span class="smallP">dic-20</span>
                            </td>
                            <td>
                                <span class="smallP">17.4</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">lug-20</span>
                            </td>
                            <td>
                                <span class="smallP">6.8</span>
                            </td>
                            <td>
                                <span class="smallP">gen-21</span>
                            </td>
                            <td>
                                <span class="smallP">21.3</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">ago-20</span>
                            </td>
                            <td>
                                <span class="smallP">8.7</span>
                            </td>
                            <td>
                                <span class="smallP">feb-21</span>
                            </td>
                            <td>
                                <span class="smallP">19.3</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="smallP">set-20</span>
                            </td>
                            <td>
                                <span class="smallP">12.2</span>
                            </td>
                            <td>
                                <span class="smallP">mar-21</span>
                            </td>
                            <td>
                                <span class="smallP">19,5</span>
                            </td>
                        </tr>
                    </table>

                </section>
                <section>
                    <div class="part_footer subtitle bold standard_margin smallP">
                        Note:
                    </div>
                </section>
                <section id="m_section_last">

                    <div class="smallP subtitle">
                        Penale per supero capacità giornaliera
                    </div>
                    <div>
                        <table style="margin-left: 250px;">
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Percentuale di supero %
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        €/Smc
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Fino al 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        0
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <span class="smallP">
                                        Oltre il 10%
                                    </span>
                                </th>
                                <td>
                                    <span class="smallP">
                                        3,064
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </section>
            <?php
                            break;
                        case 'CASAGREEN PSV':
            ?>
                <section id="h_section4">
                    <div style=" color: #5093e6;">
                        Acquista GAS Naturale a prezzo variabile
                    </div>
                </section>
                <section id="h_section5" style="min-height: 0;">
                    <div class="smallP">
                        Un’offerta dinamica che ti permette di avere un prezzo sempre allineato al reale andamento dei mercati energetici
                    </div>
                </section>
                </header>
                <!--FINE HEADER -->
                <!-- MAIN -->
                <main class="container">
                    <section id="m_section1">
                        <div class="subtitle bold smallP">
                            Prezzo componente GAS Naturale
                        </div>
                        <div class=" smallP">
                            Il prezzo della Componente Gas è il corrispettivo applicato al gas naturale prelevato a copertura esclusivamente dei costi di approvvigionamento. L’offerta si
                            intende valida per 12 mesi a partire dalla data prevista di avvio dellla fornitura indicata nella proposta di somministrazione.
                            <br class="standard_margin">
                            Verranno addebitati e resteranno a carico del cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di
                            gas naturale (QVDfissa + 4 €/mese/PDR), alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti
                            con Delibera ARERA 64/09 ARG/gas e s.m.i. e con Delibera ARERA 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo
                            gravante. I corrispettivi unitari della presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1.
                            <br class="standard_margin">
                        </div>
                    </section>
                    <!-- TABELLA -->
                    <section class="flat_table" style="display: -webkit-box; -webkit-box-pack: justify;">
                        <table class="standard_margin floatLeft">
                            <tr>
                                <th class="tableGreen" colspan="3">
                                    Prezzi €/Smc
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        Qp =
                                    </div>
                                </td>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        PSVda +
                                    </div>
                                </td>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        P0

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        Qp =
                                    </div>
                                </td>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        PSVda +
                                    </div>
                                </td>
                                <td>
                                    <div class="mediumBlack bold standard_margin">
                                        <?= number_format($record['s0'], 4, ',', '.') ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section id="m_section3">
                        <div class="smallP standard_margin">
                            Qp è la quota materia prima, proporzionale ai consumi effettuati dall’utenza espressa in €/Smc <br>
                            PSVda è pari alla media aritmetica delle quotazioni giornaliere “Heren Day Ahead Price”, espresse in €/MWh e convertite in €/Smc sulla base di un
                            coefficiente moltiplicativo pari a 0,0105833. Per ciascun giorno del mese di prelievo, la quotazione “Heren Day Ahead Price”, espressa in €/MWh è il prezzo
                            “Offer” relativo al periodo “Day-ahead” pubblicato sotto il titolo “PSV PRICE ASSESSMENT” nel report “ICIS Heren European Spot Gas Markets” del più
                            vicino giorno lavorativo precedente secondo il calendario inglese, che fa riferimento alle seguenti quotazioni: <br>
                            - “Day Ahead”, se il giorno in questione è un giorno lavorativo secondo il calendario inglese; <br>
                            - “Weekend”, se il giorno in questione non è un giorno lavorativo secondo il calendario inglese. <br>
                        </div>
                    </section>
                    <section class="white_table">
                        <table class="standard_margin">
                            <tr>
                                <th style="width: 180px" colspan="2">
                                    <div class="smallP">
                                        Valori dei corrispettivi e relativo impatto sulla spesa annua per il gas naturale di una famiglia tipo con consumi pari a 1.400 Smc/anno, nell’ambito
                                        tariffario Nord - Occidentale, considerando un potere calorifico superiore pari a 0,03852 GJ/Smc e con riferimento al 3 ° Trimestre 2020
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <p class="mediumBlack bold" style="text-align: center;"> Quota %</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP">Componente GAS</p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;">48%</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP"> Corrispettivo a remunerazione dei costi di commercializzazione della vendita al dettaglio, sostenuti dal Fornitore sul mercato libero </p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;"> 11%</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP">Restanti Componenti (distribuzione e misura, trasporto, modalità di approvvigionamento
                                        all’ingrosso e altri oneri aggiuntivi)
                                    </p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;">41%</p>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section>
                        <div class="smallP standard_margin">
                            Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                            nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore
                            dell’impianto di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARERA ARG/gas 69/04
                            (TIVG) e s.m.i..
                        </div>
                        <div class="smallP standard_margin">
                            L’andamento storico dell’indice PSVda degli ultimi 12 mesi è stato pari ai valori sotto riportati:
                        </div>
                    </section>
                    <section class="month_table" style="min-height: 0;">
                        <table>
                            <tr class="blue">
                                <th>
                                    <span class="smallP">Mese</span>
                                </th>
                                <th>
                                    <span class="smallP">PSVda c€/Smc </span>
                                </th>
                                <th>
                                    <span class="smallP">Mese</span>
                                </th>
                                <th>
                                    <span class="smallP">PSVda c€/Smc</span>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">apr-20</span>
                                </td>
                                <td>
                                    <span class="smallP">9.2</span>
                                </td>
                                <td>
                                    <span class="smallP">ott-20</span>
                                </td>
                                <td>
                                    <span class="smallP">14.1</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">mag-20</span>
                                </td>
                                <td>
                                    <span class="smallP">6.9</span>
                                </td>
                                <td>
                                    <span class="smallP">nov-20</span>
                                </td>
                                <td>
                                    <span class="smallP">14.8</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">giu-20</span>
                                </td>
                                <td>
                                    <span class="smallP">6.3</span>
                                </td>
                                <td>
                                    <span class="smallP">dic-20</span>
                                </td>
                                <td>
                                    <span class="smallP">17.4</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">lug-20</span>
                                </td>
                                <td>
                                    <span class="smallP">6.8</span>
                                </td>
                                <td>
                                    <span class="smallP">gen-21</span>
                                </td>
                                <td>
                                    <span class="smallP">21.3</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">ago-20</span>
                                </td>
                                <td>
                                    <span class="smallP">8.7</span>
                                </td>
                                <td>
                                    <span class="smallP">feb-21</span>
                                </td>
                                <td>
                                    <span class="smallP">19.3</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="smallP">set-20</span>
                                </td>
                                <td>
                                    <span class="smallP">12.2</span>
                                </td>
                                <td>
                                    <span class="smallP">mar-21</span>
                                </td>
                                <td>
                                    <span class="smallP">19,5</span>
                                </td>
                            </tr>
                        </table>
                        <div class="part_footer subtitle bold standard_margin smallP">
                            Note:
                        </div>
                    </section>
                    <section class="clearfix">
                        <div class="smallP floatLeft">
                            Il bonus sociale per la fornitura di gas naturale è stato introdotto come misura sociale per ridurre la spesa in energia elettrica e gas naturale delle famiglie in
                            stato di disagio economico e può essere richiesto al proprio Comune. Il bonus è previsto anche per i casi di disagio fisico cioè quando nel nucleo familiare è
                            presente una persona in gravi condizioni di salute che richieda l'uso di apparecchiature salvavita alimentate ad energia elettrica. Per maggiori informazioni
                            visita il sito www.arera.it
                        </div>

                    </section>
                </main>
            <?php
                            break;

                        default:
            ?>
                <section id="h_section4">
                    <div class="bold " style="color:#5093e6; margin-bottom: 50px;">
                        Acquista GAS Naturale
                    </div>
                </section>
                <section id="h_section5">
                    <div class="smallP">
                        L’offerta ti permette di avere la sicurezza di acquistare a prezzo fisso il 50% del gas consumato ed il restante 50% a prezzo variabile in modo da avere prezzo
                        sempre allineato al reale andamento dei mercati energetici.
                    </div>
                </section>
                </header>
                <!--FINE HEADER -->
                <!-- MAIN -->
                <main class="container">
                    <section id="m_section1">
                        <div class=" smallP">
                            Il prezzo della Componente Gas è il corrispettivo applicato al gas naturale prelevato a copertura esclusivamente dei costi di approvvigionamento. Il prezzo di
                            seguito indicato si intende valido per 12 mesi a partire dalla data prevista di avvio della fornitura indicata nella proposta di somministrazione. Al termine di detto
                            periodo le condizioni economiche si intenderanno prorogate finché ERRECI S.r.l. non procederà ad aggiornarle, previa comunicazione secondo le modalità e i
                            termini indicati all’art. 35, comma 4 e art. 17 delle condizioni generali di contratto.
                        </div>
                        <div class=" smallP">
                            Verranno addebitati e resteranno a carico del cliente i costi relativi alla distribuzione e misura, al trasporto, alla commercializzazione della vendita al dettaglio di
                            gas naturale, alle attività connesse alle modalità di approvvigionamento all’ingrosso oltre ad oneri aggiuntivi (così come definiti con Delibera ARERA 64/09
                            ARG/gas e s.m.i. e con Delibera ARERA 159/08 ARG/gas e s.m.i. e periodicamente aggiornati), imposte e ogni altro tributo gravante. I corrispettivi unitari della
                            presente offerta sono relativi ad un valore di coefficiente di conversione dei volumi C=1.
                        </div>
                    </section>
                    <section class="lightblue_table clearfix">
                        <table class="standard_margin floatLeft">
                            <tr>
                                <th style="width: 220px; background-color: #b8cce3;" colspan="2">
                                    Prezzo della componente GAS
                                </th>
                                <td style="width: 180px; background-color: #b8cce3;">
                                    <?= number_format($record['p0'], 4, ',', '.') ?> €/Smc
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section class="white_table">
                        <table class="standard_margin">
                            <tr>
                                <th style="width: 180px" colspan="2">
                                    <div class="smallP">
                                        Valori dei corrispettivi e relativo impatto sulla spesa annua per il gas naturale di una famiglia tipo con consumi pari a 1.400 Smc/anno, nell’ambito
                                        tariffario Nord - Occidentale, considerando un potere calorifico superiore pari a 0,03852 GJ/Smc e con riferimento al 3 ° Trimestre 2020
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                </th>
                                <td>
                                    <p class="mediumBlack bold" style="text-align: center;"> Quota %</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP">Componente GAS</p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;">48%</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP"> Corrispettivo a remunerazione dei costi di commercializzazione della vendita al dettaglio, sostenuti dal Fornitore sul mercato libero </p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;"> 11%</p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <p class="smallP">Restanti Componenti (distribuzione e misura, trasporto, modalità di approvvigionamento
                                        all’ingrosso e altri oneri aggiuntivi)
                                    </p>
                                </th>
                                <td>
                                    <p class="smallP" style="text-align: center;">41%</p>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section id="m_section3">
                        <div class="smallP standard_margin">
                            Le quote di spesa riportate sono calcolate considerando, oltre allo specifico ambito territoriale e al trimestre di riferimento, il potere calorifico superiore medio
                            nazionale. I corrispettivi applicati in fase di fatturazione verranno adeguati tenendo conto sia dell’ambito territoriale che del potere calorifico superiore
                            dell’impianto di distribuzione nel quale ricade il Punto di Riconsegna (PdR) secondo le disposizioni dell’Allegato “A” della Delibera ARERA ARG/gas 69/04
                            (TIVG) e s.m.i..
                        </div>
                    </section>
                    <section id="m_section4">
                        <div class="part_footer subtitle bold standard_margin smallP">
                            Note:
                        </div>
                        <div class="part_footer smallP">
                            Il bonus sociale per la fornitura di gas naturale è stato introdotto come misura sociale per ridurre la spesa in energia elettrica e gas naturale delle famiglie in
                            stato di disagio economico e può essere richiesto al proprio Comune. Il bonus è previsto anche per i casi di disagio fisico cioè quando nel nucleo familiare è
                            presente una persona in gravi condizioni di salute che richieda l'uso di apparecchiature salvavita alimentate ad energia elettrica. Per maggiori informazioni
                            visita il sito www.arera.it
                        </div>
                    </section>
                </main>
    <?php
                            break;
                    }
                }
    ?>
    <!-- FINE MAIN -->

    <!-- FOOTER -->
    <footer class="footer">
        <section id="f_section1">
            <div class="part_footer subtitle bold standard_margin smallP">
                Sconto Puntualità:
            </div>
            <div class="part_footer smallP">
                I prezzi sopra indicati sono comprensivi di uno sconto pari a 0,005 €/kWh, lo sconto non sarà applicato nel periodo in cui il cliente cesserà di avere le caratteristiche del “Buon Pagatore” come definito all’art. 7 delle condizioni generali di contratto.
            </div>
        </section>
        <section id="f_section2 standard_margin">
            <div class="part_footer subtitle bold smallP">
                Scadenza:
            </div>
            <div class="part_footer bold smallP">
                L’Offerta è valida se sottoscritta entro il <?= date('d/m/Y', strtotime($record['datafinecompetenza'])) ?>
            </div>
        </section>
        <section id="f_section3">
            <div class="dateSign floatLeft smallP">
                Luogo: _________________________ Data: _________________________
            </div>
            <div class="dateSign floatRight smallP">
                Firma:__________________________
            </div>
        </section>
        <section id="f_section4 ">
            <h4><?= $azienda['densociale'] ?></h4>
            <p class="block intestazione-footer"><span class="italic bold">Sede legale e operativa</span> <?= $azienda['sedelegale_cap'] ?> <?= $azienda['sedelegale_localita'] ?> (<?= $azienda['sedelegale_prov'] ?>) <?= $azienda['sedelegale_indirizzo'] ?> Tel. <?= $azienda['servizioclienti_tel'] ?> Fax <?= $azienda['fax'] ?> info@erreci.info <?= $azienda['sitoweb'] ?> C.F. e P.IVA <?= $azienda['codfiscale'] ?> </p>
            <p class="block intestazione-footer"><span class="italic bold">Unità locale:</span> <?= $azienda['sedeoperativa_cap'] ?> <?= $azienda['sedeoperativa_localita'] ?> (<?= $azienda['sedeoperativa_prov'] ?>) <?= $azienda['sedeoperativa_indirizzo'] ?></p>
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
        $sql = 'UPDATE comm.plank_listini_' . strtolower($utility) . ' SET allegatocte=\'' . $allegato . '\'  WHERE id=' . $record['id'];
        CustomQuery($sql);
        $res = "OK";
    } else {
        $res = 'KO';
    }

    return $res;
}
