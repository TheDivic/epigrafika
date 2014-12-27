epigrafika
==========

Projekat PWEB 2014

## Client
* Potrudite se da kod bude lepo formatiran i pregledan
* Za indentaciju koristiti space (ne tabove) i to tacno 4 space-a po nivou indendacije. **VAZNO!**
* Svi staticki fajlovi (slike, css, javascript...) treba da se nalaze u static folderu
* Za imenovanje svih fajlova (.php, .html, .js, ...) koristiti notaciju malim slovima sa donjom crtom (underscore) kao separatorom
* Svakoj stranici u aplikaciji odgovara ISTOIMENI .js fajl u folderu static/scripts koji sadrzi angular kontroler za tu stranu. Svakoj strani odgovara **tacno jedan** angular kontroler. Na primer za stranicu unos.php postoji fajl static/scripts/unos.js koji sadrzi unosController
* Eksterne biblioteke i moduli se nalaze u static/scripts/libs
* Koristiti odgovarajuce funkcije za logovanje u konzolu u odgovarajucim slucajevima. Npr console.error za greske, console.info za informacije.
* Izbegavati globalne funkcije, ponavljanje, importovanje skriptova pre nego sto su neophodni, koristiti angular, module i kontrolere. 

### Visejezicnost za interfejs
* U folderu languages se nalaze prevodi za podrzane jezike. Svakom jeziku odgovara jedan JSON fajl. Svaki unos unutar JSON-a je oblika "kljuc_stringa": "prevod_stringa".
* Za svaki string u interfejsu za koji je neophodno da bude visejezican koristiti angular objekat **tr** na sledeci nacin: {{ tr.kljuc_stringa }} koji ce automatski biti zamenjen prevodom na odgovarajuci jezik. 
* Popunjavati JSON fajlove prevodima po potrebi. 