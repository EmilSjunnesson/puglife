Redovisning
====================================
 
Kmom01: PHP-baserade och MVC-inspirerade ramverk
------------------------------------
**Allmänt**  
Det har minst sagt varit mycket att ta in under detta kursmoment. Det är mycket jag inte alls fått grepp om än, men jag känner i alla fall att några bitar har fallit på plats. Det var mycket intressant läsning under momentet. Jag tyckte det var speciellt givande att läsa om kod styling. Man har alltid stylat kod på sitt sätt och det är svårt att bryta inlärda mönster. Det kändes därför bra att sättet jag stylar min kod på ligger nära sätter som rekommenderades. Den delen av läsningen jag förstod minst av var delen om anonyma funktioner. Jag känner verkligen att jag har noll koll när det gäller dem. Jag antar att det bara är till att nöta in dem för de verkar minst sagt vara användbara. De användes ju till exempel för att skapa navigeringsmenyn i Anax.

Uppgiften gick hyfsat bra att genomföra. Jag hade dock en del problem med att få till snygga länkar. Först och främst berodde det på att WAMP:s rewrite-modul var avslagen. Sen ville inte den ”aktiva sidan” markeras i menyn. Det berodde på att jag använde jag mig av koden ”$this->di->get('url')->createRelative(’redovisning’)” när jag bara behövde skriva ut ’redovisning’. Till sist lade jag också till tärningspelet jag gjorde i oophp kursen. Det var inte så mycket som behövde ändras. I huvudsak lade jag bara till namespace och use i klasserna. 

**Utvecklingsmiljö**  
Jag sitter på en dator med Windows 8.1 och WAMP. Som texteditor använder jag både Eclipse och JEdit beroende på situation. Jag laddar upp filer till studentservern med FileZilla. Om jag behöver redigera bilder använder jag mig av Photoshop. Sen använder jag mig av Firefox och Firebug för att debugga. ColorZilla används också flitigt. Jag brukar oftast kolla så sidorna ser ok ut i Chrome också. 

**Bekant med ramverk och avancerade begrepp**  
Jag är nästan helt grön när det gäller ramverk. Jag har endast kikat lite på Wordpress och DNN. Men det är bara väldigt lite jag kommit i kontakt med dem. Annars är det bara Anax från oophp som jag arbetet med. Därför var de flesta lite avancerade begrepp som introducerades under momentet helt nya för mig. Det resulterade i att det var rätt mycket info att suga in under kursmomentet. Men det ska nog fastna det också. 

**Uppfattning om Anax-MVC**  
I förra kursen när jag arbetade med den enklare versionen av Anax kändes det precis som nu. Det var många filer att hålla reda på och det kändes allmänt jätterörigt. Men efter ett tag klarnade det upp och man kunde verkligen se fördelarna med att arbeta med ett ramverk. Jag tror även att så blir fallet med denna kurs. Det är många begrepp som jag inte förstår mig på än och strukturen känns överväldigande. Men jag är säker på att det blir solklart efter ett tag.


Kmom02: Kontroller och modeller
------------------------------------
Jag tycker att detta har varit en rätt klurig uppgift, men den har varit väldigt lärorik. Det känns verkligen som man har fått vara inne och pilla i alla delar av ramverket. Allt från controllers till views och modeller. Det tog rätt lång tid att komma in i tänket, men när man väl gjort det gick det ganska smidigt att bara köra på. 

För tillfället finns det möjlighet att skriva och läsa kommentarer på sidorna hem och tärningspelet. Sidorna har också separata kommentars-flöden. Det uppnås genom att kommentarerna sparas i sessionen med namnet ”comments(id)”, där idet är sidans md5(url). Det går både att editera och uppgradera en enskild kommentar. När man redirectas tillbaka till sidan efter man ändra/lagt till en kommentar länkas man också till kommentarens position på sidan med hjälp utav ”#” och kommentarens id. 

Formuläret för att skriva en ny kommentar är dolt från början. Man måste klicka på den stora länken ”kommentera” längst ner på sidan för det ska visas. Kommentar-funktionen har också stöd för gravatar. Jag testade själv att det funkade genom att skapa ett gravatar-konto, och det gjorde det!

Det känns ganska smidigt att jobba med composer. Jag har bara använt composer en gång för att göra en sak och det gjorde en bra. Jag känner inte riktigt att jag hunnit använda det tillräckligt mycket än för att kunna ge en rättvis bedömning. Jag har inte hunnit titta så mycket på vilka paket det finns på Packagist. Men jag hittade ett paket som hette ”symfony/translation” som verkade intressant. Hela biten med att översätta sidor intresserar mig rätt mycket faktiskt. Jag har dock inte någon aning om hur man gör. Så det kanske kan vara nått att titta vidare på i framtiden. 

Det känns smidigt att använda klasser som controllers. Men om jag ska vara helt ärlig känner jag inte att jag helt har fått grepp om hur det fungerar, en bit på vägen känner jag i alla fall att jag kommit. Det känns i alla fall som jag fått ihop det någorlunda som det var tänkt. Men som med allt annat krävs det en hel del repetition innan det sitter. Jag kan för lite för att kunna uttala mig om det fanns några svagheter i koden som följde med ”phpmvc/comment”. Koden gjorde vad den skulle och det fungerade för mig. Fast när jag skulle göra kommentarsflödena unika kändes det som jag förde vidare pageId variabeln genom onödigt många funktioner. 


Kmom03: Bygg ett eget tema
------------------------------------
Återigen har det varit en mycket intressant uppgift. Momentet har varit rätt omfattande men det gick faktiskt ganska smidigt att lägg till alla filer. Men jag hade lite svårt att hålla reda på om samma kod skrivits i olika filer. Det hände fler gånger att jag inte fattade varför det inte fungerade. De flesta gångerna berodde det på att gammal kod i en annan fil hade skrivit över den nya. 

Slutresultatet blev en frontkontroller bestående att tre sidor. En som visar Font Awesome, en som visar olika regioner och en som visar ett horisontellt rutnät med en matchande typografi. Rutnätet är dolt som standard men kan visas genom att lägga till ”?show-grid” i Query stringen. Sidorna är också responsiva och byter utseende vid 3 brytpunkter. Genom att ändra ”theme_style” variabeln i temats config-fil, kan man ändra hela sidan utseende. Detta eftersom html-taggen får en klass med samma namn som variabelns värde. Body-taggen får också en klass, men det är döpt efter routern. Om den är tom får klassen namnet index. Jag lade även till filen ”radius.less” från bootstrap. Den förenklar skapandet av ”border” radier, något jag ofta skapar. Det fanns också många andra intressanta filer jag kunde inkluderat, men det får räcka för tillfället. Annars har jag inte lagt till så mycket i temat, jag stylade det lite annorlunda jämfört med hur resten av me-sidan ser ut, that’s it. När jag skulle validera sidan med Unicorn visades flera felmeddelanden i CSS koden. Men det kanske inte är så konstigt, det är ju inte riktigt ”ren” CSS längre. 

Jag har ingen tidigare erfarenhet av CSS-ramverk. Men nu när jag testat det tycker jag det verkar mycket smidigt. Om det finns möjlighet att göra något enklare, så vore det dumt att inte ta tillvara på den möjligheten. Rent allmänt tycker jag att ramverk fixar många av de brister CSS har. LESS gör verkligen CSS-koden mer dynamiskt och enklare att använda. Tillägg så som variabler är verkligen ovärderliga. Och med lessphp var det enkelt att komma igång och skriva LESS-kod. Semantic.gs var nog den delen som jag känner att jag kommer ha mest nytta av. Jag har alltid tyckt det har varit jobbigt att få till en bra layout med CSS. Float dit och float hit, saker hamnar sällan där jag vill att de ska hamna. Jag tycker konceptet var lätt att förstå och mycket smidigt att använda sig av. Att man kan göra layouten responsiv är också ett stort plus. Jag kunde verkligen se hur mycket bättre en gridbaserad layout var när jag skapade sidan Typography. När till exempel texten i main låg i linje med texten i sidebaren var det en fröjd för ögat. Jag tycker absolut att det är mycket enklare att läsa text på en sida med en gridbaserad layout. 

Normalize är något man borde ha som grund varje gång man skapar en ny sida, man får då ”en tom duk” att måla på. Man slipper dessutom oroa sig för att ens sida ska se annorlunda ut i en annan webbläsare. Font Awsome är verkligen något jag kan tänka mig att fortsätta använda i framtiden. Det är ofta man känner att man är i behov av en ikon. Att ikonen kan stylas med CSS och dess storlek ändras beroende på fontens är ju också väldigt smidigt (ett återkommande ord). Jag har inte hunnit gräva så djupt i Bootstrap än men där verkar finnas en hel del kod man kan ha användning för. Fast det verkar innehålla så många fiffiga funktioner att det hade varit lika bra att använda sig av hela ramverket. 


Kmom04: Databasdrivna modeller
------------------------------------
Jag tycker att detta moment har varit det svåraste hittills i kursen och hela kurspaketet. Det har verkligen tagit mycket längre tid att slutföra än jag förväntade mig. Men jag lyckades tillslut. Först och främst hade jag svårt att få in form-paketet via Composer. Efter jag hade prövat att lägga in paketet några gånger gick det tillslut men jag har ingen aning varför. Sen hade jag också problem med att ramverket inte hittade mina klasser. Efter några timmars frustration kom jag på att det fanns en koppling mellan klassens namespace och i vilken katalog den låg i. När jag väl insåg det kändes det ganska självklart, men jag kan inte minnas att den kopplingen redogjorts någonstans. I övrigt har jag fortfarande lite svårt för ramverkets struktur, men det börjar bli bättre. Jag hade också en hel del problem med att få fram värderna som postats från formulären. 

Det är klart att formulärhanteringen med CForm har fördelar, så som succes och fail-callbacks och olika valideringsmetoder. Men jag tycker nästan att den hindrar mer än hjälper. När man skriver HTML formulär för hand kan man anpassa allt in i mista detalj. Att skriva formulär med HTML-kod är inte så krävande heller. Jag kände mig faktiskt lite låst när jag jobbade med formulären. Jag ville till exempel ha attributet ”formnovalidate” på en submit-knapp. Det hade CForm inte stöd för, så jag fick själv gå in i klassen och lägga till stöd för det. Jag var även tvungen att lägga till stöd för ”onclick”. 

Jag gillade verkligen databashanteringen. Visst det kanske inte är lika precist som att bara använda SQL. Men oftast använder man samma metoder och SQl-frågor när man interagerar med olika tabeller. Så att ha en klass som samlar de vanligaste metoderna är supersmidigt. Sen är det ju enkelt att skapa ytterligare en klass som ärver från den och innehåller mer specifika metoder för just den tabellen man arbetar emot.

Jag lade alla metoder i basklassen för modeller. I user-modellen lade jag inte till några metoder och i comment-modellen lade jag endast till en metod som hämtade alla rader med ett visst sid-id. Den enda extra metoden jag lade till i basklassen, var en ”orderby”-metod. När jag uppdaterade implementationen av kommentarerna valde jag att använda så mycket gammal kod som möjligt. Jag bytte ut klassen ”CommentsInSession” mot en modell och ärvde från basklassen CDatabaseModel. Sen flyttade jag formulären från vyerna till CForm. Annars är koden i princip oförändrad. Jag gjorde inte extrauppgiften på grund av tidsbrist.


Kmom05: Bygg ut ramverket
------------------------------------
Jag hade lite svårt att bestämma mig för vilken typ av modul jag ville lägga in i ramverket. Jag tänkte först skapa en ”HTML-helper”, med beslutade mig till sist för att göra en RSS-läsare som föreslogs i artikeln. Liksom mos gjorde jag en wrapper runt SimplePie. Det var väldigt lite kod som behövde skrivas eftersom SimplePie redan tagit hand om det mesta. Så jag fick mer tid att fokusera på GitHub och Packagist.  

Jag började med att utveckla modulen i mitt ramverk, men när jag kommit en bit på vägen valde jag att separera modulen från ramverket. Jag laddade upp den ofärdiga modulen på GitHub. Istället för att använda kommandon för att ladda upp koden använde jag programmet ”GitHub for Windows”. Eftersom jag inte riktigt är vän med Git, tycker jag det är mycket smidigare att använda programmet. 

Sen kopplade jag GitHub repot till Packagist. Det gick supersmidigt, jag fick också Packagist till att autouppdatera från Github. Jag trodde faktiskt att de skulle vara rätt krångligt men instruktionerna var kristallklara så det var nästan omöjligt att göra fel. Sen testade jag att installera modulen i ett ”vanilla” Anax-MVC. Det var inga problem med det heller. Sen fortsatte jag att jobba med modulen. 

När jag skulle implementera modulen i mitt Anax, fick jag lite problem med att ramverket inte ville autoloada min klass från modulen. Det berodde än en gång på att jag hade ”fel” namespace i klassen. Efter många om och men lyckades jag få till ett namespace som autoloadern gillade. 

Till sist skrev jag en readme fil och lade till i paketet. Texten blev rätt kort och jag gick inte in på detaljer. Men om man sen tidigare är bekant med Composer och Packagist tror jag inte det ska vara några problem att få min modul att fungera. Jag gjorde inte extrauppgiften. 


Kmom06: Verktyg och CI
------------------------------------
Min modul på [GitHub](https://github.com/EmilSjunnesson/rss) |
 [Travis](https://travis-ci.org/EmilSjunnesson/rss) |
 [Scrutinizer](https://scrutinizer-ci.com/g/EmilSjunnesson/rss/?branch=master)

Detta kursmoment introducerade många nya intressanta verktyg och tekniker för mig. Jag har aldrig stött på termer som CI och unit-tester. Det var en hel del att ta in men det känns som jag fått lite grepp om det i alla fall. Verktygen som användes under kursmomentet, Travis och Scrutinizer var också helt nya för mig. Det enda jag använt innan är i princip PHP och GitHub. 

Det gick bra att arbeta med PHPUnit och det känns som jag någorlunda fått grepp om hur det fungerar. Men det kändes som det krävdes rätt mycket kod för att testa något som innehöll rätt lite kod. Det fanns till exempel en figur i någon av läshandvisningarna som innehöll en bild på en projekt-katalog med PHP-filer. Det som överraskade mig var att test-filerna var större än originalen! Nu innehöll varken de vanliga eller testfilerna särskilt mycket kod men i alla fall.

Det gick också bra att jobba med Travis och Scrutinizer. Jag behövde i princip bara logga in med mitt GitHub-konto och följa instruktionerna. Allt sköttes bakom kulisserna helt enkelt! Jag gillar Scrutinizer speciellt mycket, man får verkligen insyn på tillståndet av alla delar av ens kod. Det är lätt att bli hemmablind och tro att det man kodar är super och då kan det vara bra att ha en objektiv part som bedömer ens kod. 

Jag gillar verktygen om teknikerna som användes och togs upp under kursmomentet. Det som inte gör mig helt såld är att det känns om man behöver lägga ner rätt mycket tid på det. Och då gäller det ju att fördelarna överväger nackdelarna. Men man kanske vinner tid på det i slutändan och slipper en massa frustration, då är det ju helt klart värt det! Jag vet inte riktigt om jag kommer använda dessa tekniker i framtiden men jag kommer absolut ha den i bakhuvudet i alla fall. 

Min modul har rätt låg ”quality” och ”coverage”. Det beror på att den använder biblioteket SimplePie och det är deras kod om är ”dålig”. Jag känner inte att jag kan gå in i den koden och göra den bättre eftersom jag inte har någon aning om hur den är strukturerad. Då känns det bättre att lägga tid och energi på annat. Den kod som jag skrivit och det kod jag arbetat direkt emot har i alla fall hög täckning och kvalitet enligt Scrutinizer. Klassen CRSS som jag skapat har ett A i ”quality” och 100 % ”coverage”.

