WEBTE2

Záverečné zadanie

LS 2022/2023


Zadanie
   Úlohou je naprogramovať aplikáciu, ktorá umožnı́ náhodné vygenerovanie matematických prı́kladov
   študentovi a neskoršiu kontrolu ich výsledkov.
   Nezabudnite na to, že sa hodnotı́ aj grafický dizajn vytvorenej aplikácie, vhodne navrhnuté
   členenie, ľahkosť orientácie v prostredı́. Pamätať by ste mali aj na zabezpečenie celej aplikácie.
   Na vypracovanie projektu je možné použiť už aj PHP framework.
   Vytvorená aplikácia bude spĺňať aj nasledovné požiadavky:

   (1) Pri práci na projekte je potrebné použı́vať verzionovacı́ systém, napr. github“, gitlab“,
   bitbucket“.

   (2) Vytvorená webstránka bude navrhnutá ako dvojjazyčná (slovenčina, angličtina).
   Pozn.: ak sa prepı́nate medzi jazykmi, musı́te zostať na tej istej stránke ako ste boli pred
   prepnutı́m a nie vrátiť sa na domovskú stránku aplikácie.

   (3) Celá stránka bude responzı́vna vrátane použitej grafiky.
   
   (4) Aplikácia bude vyžadovať 2 typy rolı́: študent a učiteľ

   (5) Po prihlásenı́ sa študent bude mať k dispozı́cii dve funcionality:
   • vygenerovanie prı́kladov na riešenie,
   • prehľad zadaných úloh (t.j. úloh, ktoré boli vygenerované pre daného študenta)
   spolu s možnosťou odovzdania ich riešenia. Z prehľadu bude aj jasné, ktoré úlohy
   už boli odovzdané a ktoré nie.
   Každú úlohu je možné generovať a aj odovzdávať samostatne.
   
   (6) Generovanie úloh bude robené na základe latexových súborov, ktoré sú prı́lohou zadania.
   • Počet súborov nie je vopred daný, to znamená, že ak do aplikácie bude pridaný ďalšı́
   latexový súbor, aplikácia to musı́ vedieť ošetriť a spracovať aj ten.
   • Latexový súbor sa môže odvolávať na obrázky, ktoré je treba tiež vedieť do aplikácie
   načı́tať. Forma ich načı́tania a spracovania nie je v zadanı́ definovaná, t.j. závisı́ od
   vašich individuálnych preferenciı́.
   • Každý súbor predstavuje sadu prı́kladov (počet prı́kladov v súbore nie je vopred
   daný), z ktorej môže byť študentovi náhodne vygenerovaný 1 prı́klad na riešenie.
   • Učiteľ bude mať možnosť definovať, z ktorých latexových súborov si bude môcť
   študent generovať prı́klady na riešenie a v ktorom obdobı́ si ich bude môcť generovať.
   Každá sada prı́kladov môže mať iný dátum, kedy môže byť použitá. Ak dátum
   nebude určený, tak generovanie prı́kladov z tejto sady je otvorené.
   Z učiteľom vymedzenej skupiny súborov si študent bude mať možnosť zvoliť, z
   ktorých súborov chce mať vygenerované prı́klady (môže si vybrať jeden súbor, ale
   aj všetky).

   (7) Odovzdanie úlohy spočı́va v napı́sanı́ odpovede, ktorá bude vo väčšine prı́padov vo forme
   matematického výrazu (napr. zlomok, diferenciálna rovnica, ...).
   Na zápis odpovede použite niektorý z dostupných nástrojov na Internete, napr. matematický
   editor http://camdenre.github.io/src/app/html/EquationEditor
   (8) Správnosť odpovede je potrebné skontrolovať voči výsledku, ktorý je zadaný v dodanom
   latexovom súbore. Treba si však uvedomiť, že výsledok, ktorý zadá študent, nemusı́ byť
   presne v tom istom formáte ako je ten, ktorý je zapı́saný v súbore. Napr. 3/4 je to isté
   ako 0.75 a 2s+1 je to isté ako s+0.5 alebo 0.5s+0.25
. V prı́pade potreby zaokrúhľovania 6s+4 3s+2 1.5s+1
   kvôli kontrole výsledkov, zaokrúhľujte na 4 desatinné miesta.
  Na vyhodnotenie správnosti odpovede je možné použiť nejakú voľne dostupnú knižnicu
  alebo dokonca aj voľne dostupný CAS (Computer Aided System) ako je naprı́klad
  Maxima alebo Octave. V takom prı́pade si je ho potrebné nainštalovať na server.

  (9) Učiteľ bude mať možnosť okrem funkcionality definovanej v bode č.6:
• zadefinovať, koľko bodov môže študent zı́skať, za ktorú sadu prı́kladov (všetky
  prı́klady zadefinované v jednom súbore budú mať rovnaké hodnotenie, t.j. toto
  hodnotenie bude mať aj prı́klad vygenerovaný pre študenta).
• si prezerať prehľadnú tabuľku všetkých študentov (meno, priezvisko, ID študenta) s
  informáciou, koľko úloh si ktorý študent vygeneroval, koľko ich odovzdal a koľko za
  ne zı́skal bodov. Študentov bude možné zotrieďovať podľa všetkých vyššie uvedených
  informáciı́ (pri rovnosti čı́selných hodnôt sa ako druhé kritérium berie zoradenie
  podľa priezviska). Túto tabuľku je potrebné exportovať aj do CSV súboru.
• si prezerať, aké úlohy si ktorý študent vygeneroval, aké odovzdal, odovzdaný výsledok
  spolu s informáciou, či bol správny a koľko zı́skal za ktorú úlohu bodov.

  (10) Súčasťou aplikácie bude návod, ako je možné aplikáciu použı́vať zo strany študenta a
  aj zo strany učiteľa. Tento návod je potrebné umožniť vygenerovať do PDF súboru. V
  prı́pade zmeny v návode na stránke, sa táto zmena musı́ odraziť aj vo vygenerovanom
  PDF súbore (t.j. súbor je treba generovať dynamicky).
 
 (11) Vytvorenú aplikáciu je potrebné odovzdať vo forme docker balı́čka.

 (12) Vytvorte video, ktorým budete dokumentovať celú funkcionalitu vytvorenej aplikácie.
  Ak niektorá funkcionalita nebude ukázaná na videu, tak ju môžeme považovať za nespravenú.