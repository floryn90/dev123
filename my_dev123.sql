--
-- Struttura della tabella `admin_administrators`
--

CREATE TABLE IF NOT EXISTS `admin_administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `admin_administrators`
--

INSERT INTO `admin_administrators` (`id`, `username`, `password`, `email`) VALUES
(1, 'Floryn90', 'aaf9625f4f06801934bc99b4db775222', 'florin.lungu@tiscali.it'),
(2, 'KinG-InFeT', '227edf7c86c02a44d17eec9aa5b30cd1', 'king.infet@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_blog`
--

CREATE TABLE IF NOT EXISTS `admin_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` text NOT NULL,
  `title` text NOT NULL,
  `post` text NOT NULL,
  `post_date` text NOT NULL,
  `num_read` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `admin_blog`
--

INSERT INTO `admin_blog` (`id`, `author`, `title`, `post`, `post_date`, `num_read`, `cat_id`) VALUES
(1, 'floryn90', 'Il nostro Blog!', 'Benvenuti sul nostro blog! In questo blog pubblicheremmo le notizie sul andamento dello sviluppo del portale:P', '04/01/12', 0, 1),
(2, 'floryn90', 'Aggiornamenti', 'Aggiornamenti:\r\n-&gt;Ã¨ stato &quot;creato&quot; il modulo di registrazione per gli utenti ma si deve ancora sistemare \r\n-&gt;aggiunto il modulo per la visualizzazione dei ultimi 7 articoli del blog\r\n-&gt;Ã¨ stata separata la parte del sito da quella del blog\r\n-&gt;nell''amministrazione sono state create delle sezioni per la modifica dei articoli del blog e dei articoli del sito(incluse le categorie)\r\n-&gt;Ã¨ stata separata la parte extra dal corpo(contain)(un bug del mitico Kinginfett)\r\n-&gt;sono state apportate delle modifiche al DB\r\n-&gt;aggiunto un modulo di contatto (per adesso le mail vengono inviate al mio contatto)\r\n-&gt;adesso si vede bene anche su Firefox :P\r\n\r\n\r\n\r\nAlla prossima :P \r\n\r\nP.S. King in Fett se puoi, vuoi sistemare tu il modulo di login? devi creare il form e la relativa pagina per il login', '04/01/12', 0, 1),
(3, 'KinG-InFeT', 'Aspetti da FIXARE!', 'Cose che a mio parere bisognerebbe fixare:\r\n\r\n1) il contact Ã¨ da migliorare, potrbbero floddarci e rompere i coglioni con spam ecc..(CAPTCHA anche a 1+1 :P)\r\n\r\n2) Inserire degli unless nelle POST del contact altrimenti anche non inserendo niente lo script si &quot;rompe&quot;\r\n\r\n3) Effettuare il login con una query AJAX cosÃ¬ da velocizzare la cosa e renderla piÃ¹ fluida e carina\r\n\r\n4) Nella home del sito inserire solo dei riquadri riassuntivi per poi scegliere cosa si vuol fare in seguito (WEB-SEO) IMPORTANTE A MIO PARERE\r\n\r\n5) Sistemare l''output dell''HTML della pagina registrazioni (WEB SEO)\r\n\r\n6) Completare e rendere quanto meno funzionanre le registrazioni (questa potremmo lasciarla quando avremo un pÃ² piÃ¹ di tempo dato che Ã¨ una cosa un pÃ² lunghetta da seguire che porterÃ  modifiche penso a qalche classe di gestione)\r\n\r\n7) RENDERE IL PORTALE MULTIPIATTAFORMA E RENDERLO (CROSS-PLATFORM)\r\n\r\n[center][b]8) il prossimo che mi chiama kinginfettt o kinginfet lo ammazzo io mi chiamo [b]KinG-InFeT[/b] hahahahah[/b][/center]\r\n\r\n\r\nspero di aver reso bene alla comunitÃ \r\n\r\nSALUTI,\r\nKinG-InFeT. :P', '05/01/12', 0, 1),
(4, 'KinG-InFeT', '0.0.6-alpha cosa abbiamo fatto?', 'dall''articolo precedente ci rimane da fare solo il punto:\r\n\r\n3) Effettuare il login con una query AJAX cosÃ¬ da velocizzare la cosa e renderla piÃ¹ fluida e carina \r\n\r\n5) Sistemare l''output dell''HTML della pagina registrazioni (WEB SEO) \r\n\r\n6) Completare e rendere quanto meno funzionanre le registrazioni (questa potremmo lasciarla quando avremo un pÃ² piÃ¹ di tempo dato che Ã¨ una cosa un pÃ² lunghetta da seguire che porterÃ  modifiche penso a qalche classe di gestione)\r\n\r\n7) RENDERE IL PORTALE MULTIPIATTAFORMA E RENDERLO (CROSS-PLATFORM) \r\n\r\nquindi vbb io e floryn abbiamo fatto un pÃ² di strada contando che abbiamo lavorato per 2 orette xD\r\n\r\nciauz da KInG-InFeT', '10/01/12', 0, 1),
(5, 'floryn90', 'Sistemato il modulo dei commenti', 'E'' stato sistemato il modulo per la visualizzazione e l''inserimento dei commenti. prima se non c''erano dei commenti per un certo articolo veniva visualizzata la stringa (non ci sono ancora commenti) perÃ² non veniva caricato il modulo per l''inserimento del commento. Adesso funziona tutto per il verso giusto :P \r\n\r\nFloryn90', '12/01/12', 0, 1),
(6, 'KinG-InFeT', '0.0.7-alpha ebene si xD', 'bhÃ¨ ho completato una revisione compelta del codice precedente ora \r\nfunziona praticamente tutto quello che abbiamo fatto in precedenza\r\n\r\nper il resto ho &quot;fatto&quot; le sequenti cose:\r\n\r\n1) Sistemato il login nella home e aggiunto la possibilitÃ  di fare loggare amministratori e utenti indistintamente con diversa pagina di arrivo\r\n\r\n2) sistemate le funzione send_login e divise in 2 per il controllo separato di amministratori e utenti normali\r\n\r\n3) stessa cosa della 2 solo per gli is_admin() e is_user()\r\n\r\n4) sistemato il messaggio benvenuto utente nella home dopo effettuato il login\r\n\r\n5) sistemato alcune piccolezze in amministrazione tra menÃ¬ e template\r\n\r\n6) HO SISTEMATO E REVISIONATO INTERAMENTE IL SISTEMA DI LOADING DELLE PAGINE RICHIESTE DEL SISTEMA ORA Ãˆ ANCORA PIÃ™ FLUIDO\r\n\r\nle cose da fare:\r\n\r\nPRINCIPALE:\r\n\r\n1) [b]Completare e rendere quanto meno funzionanre le registrazioni (questa potremmo lasciarla quando avremo un pÃ² piÃ¹ di tempo dato che Ã¨ una cosa un pÃ² lunghetta da seguire che porterÃ  modifiche penso a qalche classe di gestione)[/b]\r\n\r\n2) RENDERE IL PORTALE MULTIPIATTAFORMA E RENDERLO (CROSS-PLATFORM) \r\n\r\n3) Sistemare l''output dell''HTML della pagina registrazioni (WEB SEO)\r\n\r\n4) sistemare il contact che a quanto pare non funziona come dovrebbe xD\r\n\r\n5) controllare il CSS dell''amministrazione che il MENU fa degli brutti scherzi (floryn90 serve na tua mano xD)\r\n\r\nper il continuo ovviamente a domani\r\n\r\nSaluti,\r\nKinG-InFeT\r\n', '16/01/12', 0, 1),
(7, 'KinG-InFeT', '0.0.8-alpha cosa ho fatto? ', 'ok ecco cosa ho fatto oggi\r\n\r\n1) Ho fatto funzionare finalmente le registrazioni con tutti i controlli necessari e la sicurezza dovuta ora funziona tutto\r\n\r\n2) ho sistemato e messo in funzione la pagine per la gestione del profilo dell''utente e fixato alcune XSS e SQL INjection (brutta roba)\r\n\r\n3) Fatti alcuni fix per quanto riguarda delle classi per la gestione delle registrazioni (che ho anche aggiunto)\r\n\r\n4) si Ã¨ sistemato il problemino con le CSS nell''amministrazione (thanks floryn90)\r\n\r\n5) Ho implementato la classe per la gestione dell''impaginazione, ora funziona sia nel blog che nei tutorial ^_^\r\n\r\nbene cose da fare ancora\r\n\r\n1) sistemare il contact che a quanto pare non funziona come dovrebbe xD \r\n\r\nvbb quella cosa mi rode vederla hahah poi vedremo :P\r\n\r\nSaluti,\r\nKinG-InFeT.', '18/01/12', 0, 1),
(8, 'KinG-InFeT', 'Piccola Pausa', 'La progettazione e la costruzione del portale Ã¨ in pausa temporanea \r\nricominceremo nonappena si ha la possibilitÃ  di tempo da dedicargli.\r\n\r\nSaluti,\r\nKinG-InFeT.', '04/02/12', 0, 1),
(9, 'Floryn90', 'Aggiornamento sviluppo ', 'Sono riuscito a trovare un pochissimo tempo da dedicare al portale e in questo poco tempo sono riuscito a sistemare alcuni bug e a cambiare il modulo captcha presente nel modulo di contatto (per adesso ma che sarÃ  diffuso anche alla pagina di registrazione). Inoltre ho sistemato alcuni bug minori nella gestione dei commenti e nella loro gestione dal panello di amministrazione dove non venivano cancellati i commenti di un articolo presente in tutorial quando si cancellava l''articolo.\r\n\r\nSaluto tutti voi e ci &quot;becchiamo&quot; alla prossima :P\r\n\r\n*Sono state apportate anche alcune modifiche al file css xD', '17/02/12', 0, 1),
(10, 'KinG-InFeT', 'Prossimo Sviluppi per la 0.0.9-alpha', 'nel prossimo tempo lo sviluppo del portale seguirÃ  i seguenti obbiettivi:\r\n\r\n[b]Florin Lungu:[/b]\r\n* Revisione del template sia Utente che Amministrazione\r\n* Snellire la grafica rendendo le immagini caricate in esterno , renderle locali\r\n* implementare un &quot;captcha&quot; numerico tipo 1 + 2 nell contact page\r\n\r\n\r\n[b]Vincenzo Luongo:[/b]\r\n* Implementazione dell''account Twitter e scrittura di un plugin jQuery adatto per la visualizzazione rapida dei tweets\r\n* Implementazione della pagina di download.\r\n* Implementazione di htaccess per mod_rewrite e accesso protetto alla cartella di gestione del MySQL\r\n[img]http://dealerplatform.com/wp-content/themes/optimize/images/icon-check.png[/img] Rendere CASE-INSENSITIVE il login (solo l''username)\r\n[img]http://dealerplatform.com/wp-content/themes/optimize/images/icon-check.png[/img] Implementare l''automatismo degli Username amministratori in aggiungi articolo e modifica articolo\r\n* Implementare il reset password per gli utenti\r\n* implementare il reset password in amministrazione gestione utenti\r\n\r\n[BUG FIX]\r\n[img]http://dealerplatform.com/wp-content/themes/optimize/images/icon-check.png[/img] Sistemati tutti i &quot;notice&quot; del parser PHP e ottimizzate delle funzioni\r\n[img]http://dealerplatform.com/wp-content/themes/optimize/images/icon-check.png[/img] Sistemato alcuni errori nel view_article e nel view_blog\r\n\r\nBy Luongo Vincenzo\r\n\r\n\r\nIDEE FUTURE\r\n* Creazione di un servizio di assistenza PC ed Help-Desk a pagamento (Multipiattaforma)\r\n* Per una maggione diffusione del portale implementare l''integrazione con i maggioni Social Network (FB, G+, Twitter, ecc...)\r\n\r\nRevisioni al codice [LOW]\r\n* Commentare tutti i sorgenti per una visione migliore nel futuro', '17/04/12', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_categories_blog`
--

CREATE TABLE IF NOT EXISTS `admin_categories_blog` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` text NOT NULL,
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `admin_categories_blog`
--

INSERT INTO `admin_categories_blog` (`cat_id`, `cat_name`) VALUES
(1, 'Generale');

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_categories_tutorial`
--

CREATE TABLE IF NOT EXISTS `admin_categories_tutorial` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` text NOT NULL,
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `admin_categories_tutorial`
--

INSERT INTO `admin_categories_tutorial` (`cat_id`, `cat_name`) VALUES
(1, 'General'),
(2, 'GNU/Linux');

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_comments_blog`
--

CREATE TABLE IF NOT EXISTS `admin_comments_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `ip` text NOT NULL,
  `data` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dump dei dati per la tabella `admin_comments_blog`
--

INSERT INTO `admin_comments_blog` (`id`, `blog_id`, `name`, `comment`, `ip`, `data`) VALUES
(1, 3, 'Floryn90', 'Ci sono anche altre cose da fare :P', '', ''),
(6, 4, 'Floryn90', 'il form dei commenti non funziona (il form per inserire i commenti non viene caricato/visualizzato se non ci sono dei commenti giÃ  inseriti in precedenza)', '62.98.76.139', ''),
(4, 4, 'KinG-InFeT', 'direi che per stasera basti ^_^', '151.70.124.50', ''),
(5, 4, 'Floryn90', 'Anche io direi che per stasera basti :P ^_^', '62.98.76.139', ''),
(7, 1, 'prova', 'prova invio commento', '62.98.76.139', ''),
(8, 5, 'Floryn90', 'Ho sistemato alcune cosette per quanto riguarda i commenti e la loro gestione dal pannello di amministrazione :P', '62.98.22.251', ''),
(9, 5, 'KinG-InFeT', 'ora va molto meglio ;)', '151.70.124.50', ''),
(10, 6, 'Floryn90', 'complimenbti per il lavoro che hai fatto! cnq per quando il css provedo io e anche per il menu del utente:P (ho in mento una cosa piÃ¹ carina :P )', '62.98.22.251', ''),
(11, 6, 'Floryn90', '@KinG-InFeT: si deve sistemare la visualizzazione dei articoli/tutorial in pagine (massimo 5 articoli su pagina) altrimenti le pagine diventano infinite :)', '62.98.22.251', ''),
(12, 6, 'KinG-InFeT', 'l''impaginazione si ci penso io :D', '151.70.124.50', ''),
(13, 7, 'KinG-InFeT', 'sta venendo bene dai :P', '151.70.124.50', ''),
(14, 7, 'Floryn90', 'sta veramente venendo molto bene! devo ancora sistemare una cosetta al css per i menu dei articoli :P (sono un pÃ² troppo lunghi)', '87.19.137.228', ''),
(15, 7, 'KinG-InFeT', 'diminuire il padding? ma sÃ¬ ;)', '151.70.124.50', ''),
(16, 7, 'Floryn90', 'Non il padding ma diminuire la larghezza della div del titolo :P', '62.98.72.33', ''),
(17, 7, 'Floryn90', '@KinG-InFeT: you are the &lt;&lt;king&gt;&gt;', '87.16.19.26', ''),
(18, 7, '', 'thanks ma ora dobbiamo andare avanti :S e forse dobbiamo mettere data e ora ai commenti :P', '151.70.124.50', ''),
(19, 7, 'KinG-InFeT', 'sistemato questo piccolo errore da name a nome la var via $_POST inviata che non prendeva xD', '151.70.124.50', ''),
(20, 8, 'floryn90', 'confermato :( anch''io sono impegnato in vari progetti e realizzazione di siti web breve termine. appena ho un pÃ² di spazio (tempo) mi dedico anche al portale', '62.98.163.0', ''),
(22, 9, 'KinG-InFeT', 'bisogna sistemare la pagina contact :P', '151.70.124.50', ''),
(23, 9, 'KinG-InFeT', 'Fatal error: require_once() [function.require]: Failed opening required ''../../classes/recaptchalib.php'' (include_path=''.:'') in /membri/dev123/pages/contact/index.php on line 36', '151.70.124.50', ''),
(24, 9, 'KinG-InFeT', 'vbb sistemato io il form contatti ora dovrebbe funzionare xD', '151.70.124.50', ''),
(25, 9, 'Floryn90', 'Ho apportato alcune modifiche al file CSS e ai commenti :P', '62.98.78.64', 'Sun, 26 Feb 12 22:03:31 +0100'),
(26, 10, 'Floryn90', 'per quanto riguarda il template userÃ² il nuovo HTML5 con i controlli sui campi per una migliore usabilitÃ ', '62.98.1.189', 'Tue, 17 Apr 12 10:47:36 +0200'),
(27, 10, 'KinG-InFeT', 'perfetto ;)', '127.0.0.1', 'Wed, 18 Apr 12 21:46:41 +0200');

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_comments_tutorial`
--

CREATE TABLE IF NOT EXISTS `admin_comments_tutorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tutorial_id` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `ip` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `admin_comments_tutorial`
--

INSERT INTO `admin_comments_tutorial` (`id`, `tutorial_id`, `name`, `comment`, `ip`) VALUES
(5, 6, 'Floryn90', 'Molto interessante l''articolo !', '62.98.22.251');

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_tutorial`
--

CREATE TABLE IF NOT EXISTS `admin_tutorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` text NOT NULL,
  `title` text NOT NULL,
  `post` text NOT NULL,
  `post_date` text NOT NULL,
  `num_read` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `admin_tutorial`
--

INSERT INTO `admin_tutorial` (`id`, `author`, `title`, `post`, `post_date`, `num_read`, `cat_id`) VALUES
(1, 'admin', 'Benvenuto', 'Benvenuto sul nostro portale che per adesso Ã¨ ancora in fase di sviluppo!\r\nGrazie per averci visitato e ti aspettiamo al piÃ¹ presto.', '27/11/11', 0, 1),
(6, 'floryn90', 'Che distro scegliere?', 'Forse a molti di noi (mi riferisco ai piÃ¹ &quot;smanettoni&quot; ) ci Ã¨ capitato che un nostro amico ci chiedesse di consigliargli una distribuzione Gnu/Linux da usare sul suo computer portatile o desktop. La risposta, nella maggior parte dei casi, Ã¨ la seguente: &quot;Dipende!&quot; Eh si! Dipende da molti fattori come il tipo di architettura del computer, da che uso ne fa l''utente finale, ecc, ecc. Ebbene per aiutarvi nella scelta della distribuzione da usare, oggi vi voglio presentare un sito che grazie ad un semplice quiz disponibile in diverse lingue, tra cui anche l''italiano, vi permette di conoscere la distribuzione Gnu/Linux piÃ¹ appropriata alle vostre esigenze.\r\nIl sito in questione Ã¨ il seguente: [url]http://www.zegeniestudios.net/ldc/index.php[/url]. Per iniziare il test non dovete fare altro che cliccare sul tasto &quot;Take the test&quot; (non spaventatevi se Ã¨ in inglese perchÃ© in seguito vi permette di scegliere la lingua in cui volete che sia visualizzato il quiz), scegliere la lingua italiana dalle diverse lingue disponibili e rispondere al test in modo piÃ¹ sincero possibile perchÃ© in questo modo la risposta del quiz sarÃ  il piÃ¹ precisa possibile.\r\n\r\nLink al sito: [url]http://www.zegeniestudios.net/ldc/index.php[/url]\r\nLink al sito direttamente in italiano: [url]http://www.zegeniestudios.net/ldc/index.php?lang=it[/url]', '03/01/12', 0, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `action_code` int(11) NOT NULL,
  `time_activation_code` time NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `action_code`, `time_activation_code`) VALUES
(1, 'prova', '189bbbb00c5f1fb7fba9ad9285f193d1', 'prova@live.it', 0, '00:00:00'),
(2, 'prova2_edit3', '280093f2cfe260a00ee1bb06f96584de', 'prova2@live.it', 0, '00:00:00');
