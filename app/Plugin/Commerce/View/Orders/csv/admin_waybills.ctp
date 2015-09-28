<?php 
//Usługa
//E-Express, L-LTL
echo 'USLUGA';
echo ';';
//CK zleceniodawcy
//CK zleceniodawcy (9 znaków), np.. CK2345678
//3
echo 'ZLECENIODAWCA';
echo ';';
//Płatnik
//GN/GO/ZL/ST GN - gotówką nadawca, GO - gotówką odbiorca, ZL -
//Zleceniodawca wg umowy, ST - strona trzecia
//4
echo 'PLATNIK';
echo ';';
echo 'CK_ST';
echo ';';
//CK płatnika będącego
//stroną trzecią
//CK płatnika wskazanego jako strona trzecia (9 znaków), np.. CK2345678
//5
echo 'DATA_N';
echo ';';
//Data nadania
//rrrr-mm-dd, jeżeli 0 lub pusta system przyjmie najwcześniejszą dopuszczalną
//6
echo 'DATA_D';
echo ';';
//Data doręczenia
//j.w.
//7
echo 'N_CK';
echo ';';
//CK nadawcy
//Nr klienta nadawcy (9 znaków), np.: CK1234567. Uzupełnienie tego pola
//spowoduje, że system pominie wpisy w kol. 8-15 a dla kolumn 16-19 jeśli nie
//będzie nic uzupełnione wówczas zostaną pobrane wartości ze wskazanej
//jednostki. Jeśli przynajmniej jedna z kolumn 16-19 zostanie podana wówczas
//system bierze wartości dla tych kolumn z pliku.
//8
echo 'N_NAZWA';
echo ';';
//Nazwa nadawcy
//max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
//nadawcy
//9
echo 'N_ULICA';
echo ';';
//Ulica nadawcy
//j.w.
//10
echo 'N_MIEJSCOWOSC';
echo ';';
//Miejscowość nadawcy
//j.w.
//11
echo 'N_KOD_POCZTOWY';
echo ';';
//Kod pocztowy nadawcy
//99-999, pole uwzględniane pod warunkiem, że nie został podany CK nadawcy
//12
echo 'N_NR_DOMU';
echo ';';
//Numer domu nadawcy
//max 10 znaków
//13
echo 'N_NR_LOK';
echo ';';
//Numer lokalu nadawcy
//max 6 znaków
//14
echo 'N_OS_PRYW';
echo ';';
//Osoba prywatna nadawca
//T/N, jeżeli puste system przyjmie T
//15
echo 'N_NIP';
echo ';';
//NIP nadawcy
//012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków)
//16
echo 'N_OS_NADAJACA';
echo ';';
//Nadawca osoba
//Imię Nazwisko. max 150 znaków, jeżeli puste a zostało uzupełnione pole
//N_CK, wóczas system przyjmie wartości domyślne związane z danym CK
//17
echo 'N_TEL_ST';
echo ';';
//Telefon stacjonarny
//nadawcy
//max. 15 znaków, jeśli puste wówczas jw..
//18
echo 'N_TEL_GSM';
echo ';';
//Telefon komórkowy
//nadawcy
//max. 15 znaków, jeśli puste wówczas jw..
//19
echo 'N_EMAIL';
echo ';';
//Mail nadawcy
//max 100 znaków, jeśli puste wówczas jw..
//20
echo 'O_CK';
echo ';';
//CK odbiorcy
//Nr klienta będącego odbiorcą (9 znaków), np.: CK1234567. Uzupełnienie tego
//pola spowoduje, że system pominie wpisy w kol. 21-28 a dla kolumn 29-32 jeśli
//nie będzie nic uzupełnione wówczas zostaną pobrane wartości ze wskazanej
//jednostki. Jeśli przynajmniej jedna z kolumn 29-32 zostanie podana wówczas
//system bierze wartości dla tych kolumn z pliku.
//21
echo 'O_NAZWA';
echo ';';
//Nazwa odbiorcy
//max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
//odbiorcy
//22
echo 'O_ULICA';
echo ';';
//Ulica odbiorcy
//j.w.
//23
echo 'O_MIEJSCOWOSC';
echo ';';
//Miejscowość odbiorcy
//j.w.
//24
echo 'O_KOD_POCZTOWY';
echo ';';
//Kod pocztowy odbiorcy
//99-999, pole uwzględniane pod warunkiem, że nie został podany CK odbiorcy
//25
echo 'O_NR_DOMU';
echo ';';
//Numer domu odbiorcy
//max 10 znaków
//26
echo 'O_NR_LOK';
echo ';';
//Numer lokalu odbiorcy
//max 6 znaków
//27
echo 'O_OS_PRYW';
echo ';';
//Osoba prywatna odbiorca
//T/N, jeżeli puste system przyjmie T
//28
echo 'O_NIP';
echo ';';
//NIP odbiorcy
//012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków)
//29
echo 'O_OS_NADAJACA';
echo ';';
//Odbiorca osoba
//Imię Nazwisko. max 150 znaków, jeżeli puste a zostało uzupełnione pole
//O_CK, wóczas system przyjmie wartości domyślne związane z danym CK
//30
echo 'O_TEL_ST';
echo ';';
//Telefon stacjonarny
//odbiorcy
//max. 15 znaków, jeśli puste wówczas jw..
//31
echo 'O_TEL_GSM';
echo ';';
//Telefon komórkowy
//odbiorcy
//max. 15 znaków, jeśli puste wówczas jw..
//32
echo 'O_EMAIL';
echo ';';
//Mail odbiorcy
//max 100 znaków, jeśli puste wówczas jw..
//33
echo 'E_0';
echo ';';
//Liczba kopert
//Liczba całkowita, jeżeli puste to 0. Wartość uwzględniona dla przesyłek
//Express
//34
echo 'E_1';
echo ';';
//Przesyłki do 1kg
//j.w.
//35
echo 'E_5';
echo ';';
//Przesyłki do 5kg
//j.w.
//36
echo 'E_10';
echo ';';
//Przesyłki do 10kg
//j.w.
//37
echo 'E_15';
echo ';';
//Przesyłki do 15kg
//j.w.
//38
echo 'E_20';
echo ';';
//Przesyłki do 20kg
//j.w.
//39
echo 'E_30';
echo ';';
//Przesyłki do 30kg
//j.w.
//40
echo 'L_40';
echo ';';
//Przesyłki do 40kg
//Liczba całkowita, jeżeli puste to 0. Wartość uwzględniona dla przesyłęk LTL
//41
echo 'L_60';
echo ';';
//Przesyłki do 60kg
//j.w.
//42
echo 'L_80';
echo ';';
//Przesyłki do 80kg
//j.w.
//43
echo 'L_100';
echo ';';
//Przesyłki do 100kg
//j.w.
//44
echo 'L_150';
echo ';';
//Przesyłki do 150kg
//j.w.
//45
echo 'L_200';
echo ';';
//Przesyłki do 200kg
//j.w.
//46
echo 'L_250';
echo ';';
//Przesyłki do 250kg
//j.w.
//47
echo 'L_300';
echo ';';
//Przesyłki do 300kg
//j.w.
//48
echo 'L_350';
echo ';';
//Przesyłki do 350kg
//j.w.
//49
echo 'L_400';
echo ';';
//Przesyłki do 400kg
//j.w.
//50
echo 'L_450';
echo ';';
//Przesyłki do 450kg
//j.w.
//51
echo 'L_500';
echo ';';
//Przesyłki do 500kg
//j.w.
//52
echo 'L_600';
echo ';';
//Przesyłki do 600kg
//j.w.
//53
echo 'L_700';
echo ';';
//Przesyłki do 700kg
//j.w.
//54
echo 'L_800';
echo ';';
//Przesyłki do 800kg
//j.w.
//55
echo 'L_900';
echo ';';
//Przesyłki do 900kg
//j.w.
//56
echo 'L_1000';
echo ';';
//Przesyłki do 1000kg
//j.w.

////57
//echo 'ROD_1_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////FV, ... - symbole dokumentów zdefiniowane w systemie
////58
//echo 'ROD_1_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////max 50 znaków
////59
//echo 'ROD_2_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////60
//echo 'ROD_2_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////61
//echo 'ROD_3_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////62
//echo 'ROD_3_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////63
//echo 'ROD_4_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////64
//echo 'ROD_4_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////65
//echo 'ROD_5_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////66
//echo 'ROD_5_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////67
//echo 'ROD_6_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////68
//echo 'ROD_6_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////69
//echo 'ROD_7_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////70
//echo 'ROD_7_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////71
//echo 'ROD_8_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////72
//echo 'ROD_8_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS
////73
//echo 'ROD_9_TYP';
//echo ';';
////Typ 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_TYP
////74
//echo 'ROD_9_OPIS';
//echo ';';
////Opis 1 dokumentu
////zwrotnego
////analogicznie jak ROD_1_OPIS

//75
echo 'U_POD';
echo ';';
//Zwrot dokumentu
//potwierdzającego
//dostawę
//T/N, jeżeli puste system przyjmuje N

//76
echo 'U_UBEZP';
echo ';';
//Ubezpieczenie
//T/N, jeżeli puste system przyjmuje N

//77
echo 'U_WART_UBEZP';
echo ';';
//Wartość ubezpieczenia
//xxxxxxx,yy

//78
echo 'U_POBRANIE';
echo ';';
//Pobranie
//N/T/E/S, N- nie, T - sTandard, E - Express, S - SuperExpress, jeśli puste
//wówczas system przyjmuje N

//79
echo 'U_WART_POBRANIA';
echo ';';
//Wartość pobrania
//xxxxxxx,yy
//80
echo 'U_RACH_POBRANIA';
echo ';';
//Rachunek bankowy
//pobrania
//max 26 znaków

////81
//echo 'U_NAD_17';
//echo ';';
////Nadanie w godzinach 17-
////22
////T/N, jeżeli puste system przyjmuje N
////82
//echo 'U_NAD_AW_TEL';
//echo ';';
////Awizacja odbioru - telefon
////T/N, jeżeli puste system przyjmuje N
////83
//echo 'U_NAD_AW_SMS';
//echo ';';
////Awizacja odbioru - SMS
////T/N, jeżeli puste system przyjmuje N
////84
//echo 'U_NAD_AW_MAIL';
//echo ';';
////Awizacja odbioru - E-mail
////T/N, jeżeli puste system przyjmuje N
////85
//echo 'U_DOST_AW_TEL';
//echo ';';
////Awizacja dostawy -
////telefon
////T/N, jeżeli puste system przyjmuje N
////86
//echo 'U_DOST_AW_SMS';
//echo ';';
////Awizacja dostawy - SMS
////T/N, jeżeli puste system przyjmuje N
////87
//echo 'U_DOST_AW_MAIL';
//echo ';';
////Awizacja dostawy - E-
////mail
////T/N, jeżeli puste system przyjmuje N
////88
//echo 'U_DOST_NSTD';
//echo ';';
////Dostawa niestandardowa
////N/9/17/W/G, 9 - do 9.00, 17 - w godzinach 17.00-22.00, W - odbiór własny, G -
////do określonej godziny, jeżeli puste system przyjmuje N
////89
//echo 'U_DOST_GODZ';
//echo ';';
////Godzina dostawy
////Godzina dostawy dla dostawy określonej jako do wskazanej godziny. Zapis w
////postaci 11,12 .. 17. Wymagane jeśli U_DOST_NSTD=G
////90
//echo 'U_DOST_DRW';
//echo ';';
////Dostawa do rąk własnych
////T/N, jeżeli puste system przyjmuje N
////91
//echo 'U_DOST_POTW_MAIL';
//echo ';';
////Potwierdzenie doręczenia
////- mail
////T/N, jeżeli puste system przyjmuje N
////92
//echo 'U_DOST_POTW_SMS';
//echo ';';
////Potwierdzenie doręczenia
////- SMS
////T/N, jeżeli puste system przyjmuje N
////93
//echo 'U_BRAK_PALET';
//echo ';';
////Liczba brakujących palet
////Liczba całkowita, jeżeli puste przyjmujemy 0, tylko LTL
////94
//echo 'U_ROZLADUNEK';
//echo ';';
////Rozładunek
////T/N, jeżeli puste system przyjmuje N
////95
//echo 'U_ADR';
//echo ';';
////ADR
////T/N, jeżeli puste system przyjmuje N

//96
echo 'UWAGI';
echo ';';
//Uwagi
//max 200 znaków
//97
echo 'OPIS';
echo ';';
//Opis towaru
//max 255 znaków
//98
echo 'NR_PRZESYLKI';
echo ';';
//Nr przesyłki
//9 znaków, jeśli puste wówczas system automatycznie przydzieli numer
//przesyłce
//99
echo 'NR_REF_1';
echo ';';
//Pierwszy nr referencyjny
//przesyłki
//max. 40 znaków
//100
echo 'NR_REF_2';
echo ';';
//Drugi nr referencyjny
//przesyłki
//max. 40 znaków
//101
echo 'DZ_CK';
echo ';';
//CK klienta adresu
//dokumentów zwrotnych
//Nr klienta adresu dokumentów zwrotnych (12 znaków), np.: CK1234567.
//Uzupełnienie tego pola spowoduje, że system pominie wpisy w wierszach
//poniżej
//102
echo 'DZ_NAZWA';
echo ';';
//Nazwa adresata
//dokumentów zwrotnych
//max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
//klienta adresu dokumentów zwrotnych
//103
echo 'DZ_ULICA';
echo ';';
//Ulica adresata
//dokumentów zwrotnych
//j.w.
//104
echo 'DZ_MIEJSCOWOSC';
echo ';';
//Miejscowość adresata
//dokumentów zwrotnych
//j.w.
//105
echo 'DZ_KOD_POCZTOWY';
echo ';';
//Kod pocztowy adresata
//dokumentów zwrotnych
//99-999, pole uwzględniane pod warunkiem, że nie został podany CK adresata
//dokumentów zwrotnych
//106
echo 'DZ_NR_DOMU';
echo ';';
//Numer domu adresata
//dokumentów zwrotnych
//max 10 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
//adresata dokumentów zwrotnych
//107
echo 'DZ_NR_LOK';
echo ';';
//Numer lokalu adresata
//dokumentów zwrotnych
//max 6 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
//adresata dokumentów zwrotnych
//108
echo 'DZ_OS_PRYW';
echo ';';
//Osoba prywatna adresata
//dokumentów zwrotnych
//T/N, jeżeli puste system przyjmie T, pole uwzględniane pod warunkiem, że nie
//został podany CK adresata dokumentów zwrotnych
//109
echo 'DZ_NIP';
echo ';';
//NIP adresata
//dokumentów zwrotnych
//012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków) , pole
//uwzględniane pod warunkiem, że nie został podany CK adresata dokumentów
//zwrotnych
//110
echo 'DZ_OS_NADAJACA';
echo ';';
//Adresat dokumentów
//zwrotnych - osoba
//max 150 znaków, jeżeli puste a zostało uzupełnione pole DZ_CK, wówczas
//system przyjmie wartości domyślne związane z danym CK
//111
echo 'DZ_TEL_ST';
echo ';';
//Telefon stacjonarny
//adresata dokumentów
//zwrotnych
//max. 15 znaków, jeśli puste wówczas jw..
//112
echo 'DZ_TEL_GSM';
echo ';';
//Telefon komórkowy
//adresata dokumentów
//zwrotnych
//max. 15 znaków, jeśli puste wówczas jw..
//113
echo 'DZ_EMAIL';
echo ';';
//Mail adresata
//dokumentów zwrotnych
//max 100 znaków, jeśli puste wówczas jw..
//114
echo 'ILOSC_NIESTANDARD';
echo ';';
//Ilość przesyłek
//niestandardowych
//Liczba całkowita. Max 99 (dla EXP), dla LTL max 1.
//115
echo 'NIEST_WYSOKOSC';
echo ';';
//Wysokość
//Tylko LTL. Pole uwzględniane tylko gdy wypełnione jest
//ILOSC_NIESTANDARD
//116
echo 'NIEST_DLUGOSC';
echo ';';
//Długość
//Tylko LTL. Max. Pole uwzględniane tylko gdy wypełnione jest
//ILOSC_NIESTANDARD
//117
echo 'NIEST_SZEROKOSC';
echo ';';
//Szerokość
//Tylko LTL. Pole uwzględniane tylko gdy wypełnione jest
//ILOSC_NIESTANDARD
//118
echo 'U_DLUZYCA_ILOSC';
echo ';';
//Przesyłka dłużycowa
//T/N. Jeżeli puste system przyjmie N.
//119
echo 'U_EPLUS';
echo ';';
//Usługa Express Plus
//T/N. Jeżeli puste system przyjmie N.

foreach ($waybills AS $waybill) { 
    echo "\r\n";
    //1
    echo 'E';
    echo ';';
    //Usługa
    //E-Express, L-LTL
    
    //2
    echo Configure::read('Kex.ZLECENIODAWCA');
    echo ';';
    //CK zleceniodawcy
    //CK zleceniodawcy (9 znaków), np.. CK2345678
    
    //3
    echo 'ZL';
    echo ';';
    //Płatnik
    //GN/GO/ZL/ST GN - gotówką nadawca, GO - gotówką odbiorca, ZL -
    //Zleceniodawca wg umowy, ST - strona trzecia
    //4
    
    echo '';
    echo ';';
    //CK płatnika będącego
    //stroną trzecią
    //CK płatnika wskazanego jako strona trzecia (9 znaków), np.. CK2345678
    
    //5
    echo '';
    echo ';';
    //Data nadania
    //rrrr-mm-dd, jeżeli 0 lub pusta system przyjmie najwcześniejszą dopuszczalną
    
    //6
    echo '';
    echo ';';
    //Data doręczenia
    //j.w.
    
    //7
    echo Configure::read('Kex.N_CK');
    echo ';';
    //CK nadawcy
    //Nr klienta nadawcy (9 znaków), np.: CK1234567. Uzupełnienie tego pola
    //spowoduje, że system pominie wpisy w kol. 8-15 a dla kolumn 16-19 jeśli nie
    //będzie nic uzupełnione wówczas zostaną pobrane wartości ze wskazanej
    //jednostki. Jeśli przynajmniej jedna z kolumn 16-19 zostanie podana wówczas
    //system bierze wartości dla tych kolumn z pliku.

    //8
    echo Configure::read('Kex.N_NAZWA');
    echo ';';
    //Nazwa nadawcy
    //max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
    //nadawcy
    
    //9
    echo Configure::read('Kex.N_ULICA');
    echo ';';
    //Ulica nadawcy
    //j.w.
    
    //10
    echo Configure::read('Kex.N_MIEJSCOWOSC');
    echo ';';
    //Miejscowość nadawcy
    //j.w.
    
    //11
    echo Configure::read('Kex.N_KOD_POCZTOWY');
    echo ';';
    //Kod pocztowy nadawcy
    //99-999, pole uwzględniane pod warunkiem, że nie został podany CK nadawcy
    
    //12
    echo Configure::read('Kex.N_NR_DOMU');
    echo ';';
    //Numer domu nadawcy
    //max 10 znaków
    
    //13
    echo Configure::read('Kex.N_NR_LOK');
    echo ';';
    //Numer lokalu nadawcy
    //max 6 znaków
    //pole uwzględniane pod warunkiem, że nie został podany CK
    
    //14
    echo Configure::read('Kex.N_OS_PRYW');
    echo ';';
    //Osoba prywatna nadawca
    //T/N, jeżeli puste system przyjmie T
    
    //15
    echo Configure::read('Kex.N_NIP');
    echo ';';
    //NIP nadawcy
    //012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków)

    //16
    echo Configure::read('Kex.N_OS_NADAJACA');
    echo ';';
    //Nadawca osoba
    //Imię Nazwisko. max 150 znaków, jeżeli puste a zostało uzupełnione pole
    //N_CK, wóczas system przyjmie wartości domyślne związane z danym CK

    //17
    echo Configure::read('Kex.N_TEL_ST');
    echo ';';
    //Telefon stacjonarny
    //nadawcy
    //max. 15 znaków, jeśli puste wówczas jw..

    //18
    echo Configure::read('Kex.N_TEL_GSM');
    echo ';';
    //Telefon komórkowy
    //nadawcy
    //max. 15 znaków, jeśli puste wówczas jw..

    //19
    echo Configure::read('Kex.N_EMAIL');
    echo ';';
    //Mail nadawcy
    //max 100 znaków, jeśli puste wówczas jw..

    //20
    echo '';
    echo ';';
    //CK odbiorcy
    //Nr klienta będącego odbiorcą (9 znaków), np.: CK1234567. Uzupełnienie tego
    //pola spowoduje, że system pominie wpisy w kol. 21-28 a dla kolumn 29-32 jeśli
    //nie będzie nic uzupełnione wówczas zostaną pobrane wartości ze wskazanej
    //jednostki. Jeśli przynajmniej jedna z kolumn 29-32 zostanie podana wówczas
    //system bierze wartości dla tych kolumn z pliku.

    //21
    echo $waybill['Order']['address']['name'];
    echo ';';
    //Nazwa odbiorcy
    //max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
    //odbiorcy

    //22
    echo $waybill['Order']['address']['address'];
    echo ';';
    //Ulica odbiorcy
    //j.w.
    //23
    echo $waybill['Order']['address']['city'];
    echo ';';
    //Miejscowość odbiorcy
    //j.w.
    //24
    echo $waybill['Order']['address']['post_code'];
    echo ';';
    //Kod pocztowy odbiorcy
    //99-999, pole uwzględniane pod warunkiem, że nie został podany CK odbiorcy
    //25
    echo $waybill['Order']['address']['nr'];
    echo ';';
    //Numer domu odbiorcy
    //max 10 znaków
    //26
    echo $waybill['Order']['address']['flat_nr'];
    echo ';';
    //Numer lokalu odbiorcy
    //max 6 znaków
    //27
    echo empty($waybill['Order']['invoice_identity']['nip'])?'T':'N';
    echo ';';
    //Osoba prywatna odbiorca
    //T/N, jeżeli puste system przyjmie T
    //28
    echo '';
    echo ';';
    //NIP odbiorcy
    //012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków)
    //29
    echo $waybill['Order']['address']['name'];
    echo ';';
    //Odbiorca osoba
    //Imię Nazwisko. max 150 znaków, jeżeli puste a zostało uzupełnione pole
    //O_CK, wóczas system przyjmie wartości domyślne związane z danym CK
    //30
    echo '';
    echo ';';
    //Telefon stacjonarny
    //odbiorcy
    //max. 15 znaków, jeśli puste wówczas jw..
    //31
    echo $waybill['Order']['address']['phone'];
    echo ';';
    //Telefon komórkowy
    //odbiorcy
    //max. 15 znaków, jeśli puste wówczas jw..
    //32
    echo $waybill['Customer']['email'];
    echo ';';
    //Mail odbiorcy
    //max 100 znaków, jeśli puste wówczas jw..
    //33
    
    $weights = Commerce::kExWeightDivision($waybill);
    
    echo $weights['E_0'];
    echo ';';
    //Liczba kopert
    //Liczba całkowita, jeżeli puste to 0. Wartość uwzględniona dla przesyłek
    //Express
    //34
    
    echo $weights['E_1'];
    echo ';';
    //Przesyłki do 1kg
    //j.w.
    //35
    echo $weights['E_5'];
    echo ';';
    //Przesyłki do 5kg
    //j.w.
    //36
    echo $weights['E_10'];
    echo ';';
    //Przesyłki do 10kg
    //j.w.
    //37
    echo $weights['E_15'];
    echo ';';
    //Przesyłki do 15kg
    //j.w.
    //38
    echo $weights['E_20'];
    echo ';';
    //Przesyłki do 20kg
    //j.w.
    //39
    echo $weights['E_30'];
    echo ';';
    //Przesyłki do 30kg
    //j.w.
    //40
    echo '';
    echo ';';
    //Przesyłki do 40kg
    //Liczba całkowita, jeżeli puste to 0. Wartość uwzględniona dla przesyłęk LTL
    //41
    echo '';
    echo ';';
    //Przesyłki do 60kg
    //j.w.
    //42
    echo '';
    echo ';';
    //Przesyłki do 80kg
    //j.w.
    //43
    echo '';
    echo ';';
    //Przesyłki do 100kg
    //j.w.
    //44
    echo '';
    echo ';';
    //Przesyłki do 150kg
    //j.w.
    //45
    echo '';
    echo ';';
    //Przesyłki do 200kg
    //j.w.
    //46
    echo '';
    echo ';';
    //Przesyłki do 250kg
    //j.w.
    //47
    echo '';
    echo ';';
    //Przesyłki do 300kg
    //j.w.
    //48
    echo '';
    echo ';';
    //Przesyłki do 350kg
    //j.w.
    //49
    echo '';
    echo ';';
    //Przesyłki do 400kg
    //j.w.
    //50
    echo '';
    echo ';';
    //Przesyłki do 450kg
    //j.w.
    //51
    echo '';
    echo ';';
    //Przesyłki do 500kg
    //j.w.
    //52
    echo '';
    echo ';';
    //Przesyłki do 600kg
    //j.w.
    //53
    echo '';
    echo ';';
    //Przesyłki do 700kg
    //j.w.
    //54
    echo '';
    echo ';';
    //Przesyłki do 800kg
    //j.w.
    //55
    echo '';
    echo ';';
    //Przesyłki do 900kg
    //j.w.
    //56
    echo '';
    echo ';';
    //Przesyłki do 1000kg
    //j.w.

//    //57
//    echo 'ROD_1_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //FV, ... - symbole dokumentów zdefiniowane w systemie
//    //58
//    echo 'ROD_1_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //max 50 znaków
//    //59
//    echo 'ROD_2_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //60
//    echo 'ROD_2_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //61
//    echo 'ROD_3_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //62
//    echo 'ROD_3_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //63
//    echo 'ROD_4_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //64
//    echo 'ROD_4_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //65
//    echo 'ROD_5_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //66
//    echo 'ROD_5_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //67
//    echo 'ROD_6_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //68
//    echo 'ROD_6_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //69
//    echo 'ROD_7_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //70
//    echo 'ROD_7_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //71
//    echo 'ROD_8_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //72
//    echo 'ROD_8_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS
//    //73
//    echo 'ROD_9_TYP';
//    echo ';';
//    //Typ 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_TYP
//    //74
//    echo 'ROD_9_OPIS';
//    echo ';';
//    //Opis 1 dokumentu
//    //zwrotnego
//    //analogicznie jak ROD_1_OPIS

    //75
    echo Configure::read('Kex.U_POD');
    echo ';';
    //Zwrot dokumentu
    //potwierdzającego
    //dostawę
    //T/N, jeżeli puste system przyjmuje N

    //76
    echo Configure::read('Kex.U_UBEZP');
    echo ';';
    //Ubezpieczenie
    //T/N, jeżeli puste system przyjmuje N

    //77
    echo Configure::read('Kex.U_UBEZP')=='T'?str_replace('.', ',', $waybill['Order']['total']):'';
    echo ';';
    //Wartość ubezpieczenia
    //xxxxxxx,yy

    //78
    echo $waybill['Order']['payment_type']=='2'?Configure::read('Kex.U_POBRANIE'):'N';
    echo ';';
    //Pobranie
    //N/T/E/S, N- nie, T - sTandard, E - Express, S - SuperExpress, jeśli puste
    //wówczas system przyjmuje N

    //79
    echo $waybill['Order']['payment_type']=='2'?str_replace('.', ',', $waybill['Order']['total']):'';
    echo ';';
    //Wartość pobrania
    //xxxxxxx,yy

    //80
    echo Configure::read('Kex.U_RACH_POBRANIA');
    echo ';';
    //Rachunek bankowy
    //pobrania
    //max 26 znaków

//    //81
//    echo 'U_NAD_17';
//    echo ';';
//    //Nadanie w godzinach 17-
//    //22
//    //T/N, jeżeli puste system przyjmuje N
//
//    //82
//    echo 'U_NAD_AW_TEL';
//    echo ';';
//    //Awizacja odbioru - telefon
//    //T/N, jeżeli puste system przyjmuje N
//
//    //83
//    echo 'U_NAD_AW_SMS';
//    echo ';';
//    //Awizacja odbioru - SMS
//    //T/N, jeżeli puste system przyjmuje N
//
//    //84
//    echo 'U_NAD_AW_MAIL';
//    echo ';';
//    //Awizacja odbioru - E-mail
//    //T/N, jeżeli puste system przyjmuje N
//
//    //85
//    echo 'U_DOST_AW_TEL';
//    echo ';';
//    //Awizacja dostawy -
//    //telefon
//    //T/N, jeżeli puste system przyjmuje N
//
//    //86
//    echo 'U_DOST_AW_SMS';
//    echo ';';
//    //Awizacja dostawy - SMS
//    //T/N, jeżeli puste system przyjmuje N
//
//    //87
//    echo 'U_DOST_AW_MAIL';
//    echo ';';
//    //Awizacja dostawy - E-
//    //mail
//    //T/N, jeżeli puste system przyjmuje N
//
//    //88
//    echo 'U_DOST_NSTD';
//    echo ';';
//    //Dostawa niestandardowa
//    //N/9/17/W/G, 9 - do 9.00, 17 - w godzinach 17.00-22.00, W - odbiór własny, G -
//    //do określonej godziny, jeżeli puste system przyjmuje N
//
//    //89
//    echo 'U_DOST_GODZ';
//    echo ';';
//    //Godzina dostawy
//    //Godzina dostawy dla dostawy określonej jako do wskazanej godziny. Zapis w
//    //postaci 11,12 .. 17. Wymagane jeśli U_DOST_NSTD=G
//
//    //90
//    echo 'U_DOST_DRW';
//    echo ';';
//    //Dostawa do rąk własnych
//    //T/N, jeżeli puste system przyjmuje N
//
//    //91
//    echo 'U_DOST_POTW_MAIL';
//    echo ';';
//    //Potwierdzenie doręczenia
//    //- mail
//    //T/N, jeżeli puste system przyjmuje N
//
//    //92
//    echo 'U_DOST_POTW_SMS';
//    echo ';';
//    //Potwierdzenie doręczenia
//    //- SMS
//    //T/N, jeżeli puste system przyjmuje N
//
//    //93
//    echo 'U_BRAK_PALET';
//    echo ';';
//    //Liczba brakujących palet
//    //Liczba całkowita, jeżeli puste przyjmujemy 0, tylko LTL
//
//    //94
//    echo 'U_ROZLADUNEK';
//    echo ';';
//    //Rozładunek
//    //T/N, jeżeli puste system przyjmuje N
//
//    //95
//    echo 'U_ADR';
//    echo ';';
//    //ADR
//    //T/N, jeżeli puste system przyjmuje N

    //96
    echo '';
    echo ';';
    //Uwagi
    //max 200 znaków

    //97
    echo $waybill['Order']['hash'];
    echo ';';
    //Opis towaru
    //max 255 znaków

    //98
    echo '';
    echo ';';
    //Nr przesyłki
    //9 znaków, jeśli puste wówczas system automatycznie przydzieli numer
    //przesyłce

    //99
    echo '';
    echo ';';
    //Pierwszy nr referencyjny
    //przesyłki
    //max. 40 znaków

    //100
    echo '';
    echo ';';
    //Drugi nr referencyjny
    //przesyłki
    //max. 40 znaków

    //101
    echo Configure::read('Kex.N_CK');
    echo ';';
    //CK klienta adresu
    //dokumentów zwrotnych
    //Nr klienta adresu dokumentów zwrotnych (12 znaków), np.: CK1234567.
    //Uzupełnienie tego pola spowoduje, że system pominie wpisy w wierszach
    //poniżej

    //102
    echo Configure::read('Kex.N_NAZWA');
    echo ';';
    //Nazwa adresata
    //dokumentów zwrotnych
    //max 100 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
    //klienta adresu dokumentów zwrotnych

    //103
    echo Configure::read('Kex.N_ULICA');
    echo ';';
    //Ulica adresata
    //dokumentów zwrotnych
    //j.w.

    //104
    echo Configure::read('Kex.N_MIEJSCOWOSC');
    echo ';';
    //Miejscowość adresata
    //dokumentów zwrotnych
    //j.w.

    //105
    echo Configure::read('Kex.N_KOD_POCZTOWY');
    echo ';';
    //Kod pocztowy adresata
    //dokumentów zwrotnych
    //99-999, pole uwzględniane pod warunkiem, że nie został podany CK adresata
    //dokumentów zwrotnych

    //106
    echo Configure::read('Kex.N_NR_DOMU');
    echo ';';
    //Numer domu adresata
    //dokumentów zwrotnych
    //max 10 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
    //adresata dokumentów zwrotnych

    //107
    echo Configure::read('Kex.N_NR_LOK');
    echo ';';
    //Numer lokalu adresata
    //dokumentów zwrotnych
    //max 6 znaków, pole uwzględniane pod warunkiem, że nie został podany CK
    //adresata dokumentów zwrotnych

    //108
    echo Configure::read('Kex.N_OS_PRYW');
    echo ';';
    //Osoba prywatna adresata
    //dokumentów zwrotnych
    //T/N, jeżeli puste system przyjmie T, pole uwzględniane pod warunkiem, że nie
    //został podany CK adresata dokumentów zwrotnych

    //109
    echo Configure::read('Kex.N_NIP');
    echo ';';
    //NIP adresata
    //dokumentów zwrotnych
    //012-345-67-89, 012-32-12-456 lub 0123456789 (10 cyfr, max 13 znaków) , pole
    //uwzględniane pod warunkiem, że nie został podany CK adresata dokumentów
    //zwrotnych

    //110
    echo Configure::read('Kex.N_OS_NADAJACA');
    echo ';';
    //Adresat dokumentów
    //zwrotnych - osoba
    //max 150 znaków, jeżeli puste a zostało uzupełnione pole DZ_CK, wówczas
    //system przyjmie wartości domyślne związane z danym CK

    //111
    echo Configure::read('Kex.N_TEL_ST');
    echo ';';
    //Telefon stacjonarny
    //adresata dokumentów
    //zwrotnych
    //max. 15 znaków, jeśli puste wówczas jw..

    //112
    echo Configure::read('Kex.N_TEL_GSM');
    echo ';';
    //Telefon komórkowy
    //adresata dokumentów
    //zwrotnych
    //max. 15 znaków, jeśli puste wówczas jw..

    //113
    echo Configure::read('Kex.N_EMAIL');
    echo ';';
    //Mail adresata
    //dokumentów zwrotnych
    //max 100 znaków, jeśli puste wówczas jw..

    //114
    echo ''; //'ILOSC_NIESTANDARD';
    echo ';';
    //Ilość przesyłek
    //niestandardowych
    //Liczba całkowita. Max 99 (dla EXP), dla LTL max 1.

    //115
    echo ''; //'NIEST_WYSOKOSC';
    echo ';';
    //Wysokość
    //Tylko LTL. Pole uwzględniane tylko gdy wypełnione jest
    //ILOSC_NIESTANDARD

    //116
    echo ''; //'NIEST_DLUGOSC';
    echo ';';
    //Długość
    //Tylko LTL. Max. Pole uwzględniane tylko gdy wypełnione jest
    //ILOSC_NIESTANDARD

    //117
    echo ''; //'NIEST_SZEROKOSC';
    echo ';';
    //Szerokość
    //Tylko LTL. Pole uwzględniane tylko gdy wypełnione jest
    //ILOSC_NIESTANDARD

    //118
    echo ''; //'U_DLUZYCA_ILOSC';
    echo ';';
    //Przesyłka dłużycowa
    //T/N. Jeżeli puste system przyjmie N.

    //119
    echo ''; //'U_EPLUS';
    echo ';';
    //Usługa Express Plus
    //T/N. Jeżeli puste system przyjmie N.
}