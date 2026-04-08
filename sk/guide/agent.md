---
title: "Konfiguracia agenta"
description: "Konfiguracia vzhadu chatbota, nastaveni inteligencie a akcii vratane prepojenia na operatora, integracie kosika a stavu objednavky."
sidebar_position: 43
---

# Konfiguracia agenta

Zalozka **Agent** poskytuje moznosti konfiguracie vzhadu vasho chatbota, logiky odpovedi a integracii.

## Vzhlad

Sekcia **Vzhlad** ovlada vizualnu prezentaciu vasho chatbota.

### Meno agenta

Zobrazovane meno vasho chatbota.

### Osobnost agenta

Kratky popis zobrazeny pod menom, ktory blizsie charakterizuje vasho chatbota.

### Rod

Ovlada gramaticky rod pouzivany v odpovediach chatbota. Pri nastaveni na muzsky rod chatbot odpoveda v muzskom tvare; pri nastaveni na zensky rod pouziva zenske tvary.

### Uvitacia sprava

Tato sprava sa zobrazuje kazdemu pouzivatelovi, ktory otvori okno chatu. Typicky sluzi ako kratke predstavenie a privitanie. Text podporuje formatovanie Markdown.

### Uvodne vyzvy

Kratke navrhovane spravy zobrazene predtym, nez pouzivatel polozi svoju prvu otazku. Mali by riesit najcastejsie dotazy, odporucat konkretne produkty alebo kategorie, alebo pomoct s vyberom produktov. Ked pouzivatel klikne na jednu z tychto vyziev, text sa odosle chatbotovi ako sprava. Text by mal byt jasny a orientovany na akciu.

### Mena

Mena zobrazovana pri zobrazovani cien produktov.

### Farba znacky

Vyberte farbu vasej znacky jednym z dvoch sposobov:

- Vyber farby (Color Picker)
- Hex kod farby

Vybrana farba sa pouziva aj pre tlacidla uvodnych vyziev a navrhy rychlych odpovedi.

### Obrazok avatara

Nahrajte obrazok avatara pre vasho chatbota. Podporovane formaty: JPEG, JPG, PNG, GIF.

### Tlacidlo chatu

Ked je povolene, text tlacidla chatu sa zobrazuje vedla ikony chatbota, ked je okno chatu minimalizovane. Ked je zakazane, viditelna je iba ikona chatbota.

### Zastupny text vstupu

Zastupny text zobrazeny v poli pre zadavanie sprav.

### Pozicia

Odsadenie pozicie chat widgetu na stranke, urcene v pixeloch (napr. 24px).

### Vlastne CSS

Pridajte vlastne CSS pre stylizaciu chat widgetu (pismo, farba textu atd.).

## Inteligencia

Sekcia **Inteligencia** definuje logiku odpovedi a hranice, ktore musi vas chatbot dodrziavat.

### Jazyk

Tu vybrany jazyk je preferovanym jazykom chatbota pre komunikaciu. Ak pouzivatel komunikuje v inom jazyku, chatbot sa automaticky prisposobi.

### Systemove instrukcie

Zakladne nastavenia, ktore definuju, ako chatbot odpoveda, ako riesi specificke situacie, ake postupy musi dodrziavat a comu sa musi vyhybat.

Ak chatbot zahrna do svojich odpovedi neziaduce informacie, mozete upravit logiku jeho odpovedi aktualizaciou systemovych instrukcii.

### Ton komunikacie

Nastavte pokyny pre ton, ktory chatbot pouziva pri komunikacii. Zvazteuroven formalnosti a zladte hlas s vasou znackou.

**Kvalifikacia** — Opiste demografiu vasej cielovej skupiny, profil zakaznika, ich problemy a riesenia, ktore hladaju. Definujte, ake otazky by mal chatbot klast na kvalifikaciu pouzivatelov.

### Eskalacia

Definujte scenare, kedy by dalsim krokom mala byt eskalacia na ziveho agenta zakaznickej podpory, telefonicky kontakt alebo e-mail. AI vyhodnocuje klucove slova ako "chcem hovorit s clovekom" alebo "nechcem sa rozpravat s robotom" a podla toho konverzaciu eskaluje.

### Osobnost

Vyberte si z troch stilov osobnosti: **Formalny**, **Vyvazeny** alebo **Priatelsky**.

### Produktove preferencie

Urcite znacky, produkty a produktove kategorie, ktore maju byt uprednostnene v odporucaniach produktov. Ked je k dispozicii viac vhodnych produktov, polozky uvedene tu maju prednost.

### Navrhy rychlych odpovedi

Nastavte logiku pre generovanie tlacidiel rychlych odpovedi zobrazenych pouzivatelovi po kazdej sprave chatbota. Tieto pomahaju udrzovat plynuly priebeh konverzacie a znizuju bariery v predajnom procese. Opiste, ako ma chatbot generovat obsah tychto klikatelnych tlacidiel.

### Produkty na odporucanie

Nastavte maximalny pocet produktov zobrazenych pouzivatelom, ked sa najde zhoda.

### Proaktivne vyskakovacie okna

Povoletproaktivne oslovovanie pomocou prepinaca. Po povoleni chatbot oslovuje pouzivatelov v spravnom momente na zaklade ich aktivity na stranke — vita ich na webe, pomaha porovnavat produkty, asistuje pri vybere produktov, zachranuje opustene kosiky a dalsie.

## Akcie

Sekcia **Akcie** poskytuje moznosti pre interakciu s tretimi stranami a e-commerce platformami.

### Prepojenie na operatora

Toto nastavenie ponechajte povolene, ak chatbot sluzi ako priamy komunikacny kanal so zakaznikmi a planujete sa aktivne zucastnovat konverzacii. Pri spusteni odovzdania sa AI odpovede deaktivuju a vas tim dostane notifikacie cez dashboard (zvukove a vizualne upozornenia), prehliadacove notifikacie a e-mail. AI vyhodnocuje potrebu eskalacie na zaklade podneteov ako "nechcem sa rozpravat s robotom" alebo "chcem cloveka."

### Nakupny kosik

Pridavajte produkty do kosika zakaznika priamo cez chat. Ak pouzivate plugin Selzee pre Upgates, Shoptet alebo Shopify, toto funguje bez dalsieho nastavovania. Pre ostatne platformy je potrebna vlastna technicka integracia — podrobnosti najdete v technickej dokumentacii.

### Stav objednavky

Chatbot dokaze spracovat poziadavky "Kde je moja objednavka?" priamo v chate. Zakaznik zada cislo objednavky a e-mail na overenie a chatbot zobrazi aktualny stav objednavky. Ak pouzivate plugin Selzee pre Upgates, Shoptet alebo Shopify, toto funguje bez dalsieho nastavovania. Pre ostatne platformy musite poskytnuts API endpoint, ktory ziska stav objednavky podla cisla objednavky a e-mailu — podrobnosti najdete v technickej dokumentacii.
