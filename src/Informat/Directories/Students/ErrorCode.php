<?php

namespace Koba\Informat\Directories\Students;

use Koba\Informat\Contracts\HasDescriptionInterface;

enum ErrorCode: string implements HasDescriptionInterface
{
    case BR000 = 'BR000';
    case BR001A = 'BR001A';
    case BR001B = 'BR001B';
    case BR002A = 'BR002A';
    case BR002B = 'BR002B';
    case BR003 = 'BR003';
    case BR004A = 'BR004A';
    case BR005A = 'BR005A';
    case BR005B = 'BR005B';
    case BR006A = 'BR006A';
    case BR007A = 'BR007A';
    case BR008A = 'BR008A';
    case BR008B = 'BR008B';
    case BR009 = 'BR009';
    case BR010A = 'BR010A';
    case BR011 = 'BR011';
    case BR012 = 'BR012';
    case BR013 = 'BR013';
    case BR014 = 'BR014';
    case BR015 = 'BR015';
    case BR016 = 'BR016';
    case BR017 = 'BR017';
    case BR018 = 'BR018';
    case BR019 = 'BR019';
    case BR020A = 'BR020A';
    case BR021 = 'BR021';
    case BR022A = 'BR022A';
    case BR022B = 'BR022B';
    case BR023A = 'BR023A';
    case BR023B = 'BR023B';
    case BR024A = 'BR024A';
    case BR024B = 'BR024B';
    case BR025A = 'BR025A';
    case BR025B = 'BR025B';
    case BR026 = 'BR026';
    case BR027A = 'BR027A';
    case BR027B = 'BR027B';
    case BR028A = 'BR028A';
    case BR028B = 'BR028B';
    case BR029A = 'BR029A';
    case BR029B = 'BR029B';
    case BR030 = 'BR030';
    case BR031 = 'BR031';
    case BR032 = 'BR032';
    case BR033 = 'BR033';
    case BR034A = 'BR034A';
    case BR034B = 'BR034B';
    case BR035A = 'BR035A';
    case BR035B = 'BR035B';
    case BR036A = 'BR036A';
    case BR036B = 'BR036B';
    case BR037A = 'BR037A';
    case BR037B = 'BR037B';
    case BR037C = 'BR037C';
    case BR038A = 'BR038A';
    case BR038B = 'BR038B';
    case BR039 = 'BR039';
    case BR040A = 'BR040A';
    case BR040B = 'BR040B';
    case BR041A = 'BR041A';
    case BR041B = 'BR041B';
    case BR042 = 'BR042';
    case BR043A = 'BR043A';

    case DNF001 = 'DNF001';

    case MNA001 = 'MNA001';
    case MNA002 = 'MNA002';
    case MNA003 = 'MNA003';
    case MNA004 = 'MNA004';
    case MNA005 = 'MNA005';

    public function getDescription(): string
    {
        return match($this) {
            self::BR000 => 'De waarde voor het veld kon niet omgezet worden naar het verwachte type.',
            self::BR001A => 'De achternaam is verplicht.',
            self::BR001B => 'De achternaam mag maximum 50 karakters lang zijn.',
            self::BR002A => 'De voornaam is verplicht.',
            self::BR002B => 'De voornaam mag maximum 50 karakters lang zijn.',
            self::BR003 => 'Bijkomende namen mogen maximum 160 karakters lang zijn.',
            self::BR004A => 'Ongeldige geboortedatum.',
            self::BR005A => 'Code geboorteland is verplicth.',
            self::BR005B => 'Code geboorteland moet 5 karakters bevatten.',
            self::BR006A => 'Code geboorteplaats mag maximum 10 karakters bevatten.',
            self::BR007A => 'Geboorteplaats mag maximum 50 karakters bevatten.',
            self::BR008A => 'Code nationaliteit is verplicht.',
            self::BR008B => 'Code nationaliteit moet 5 karakters bevatten.',
            self::BR009 => 'Ongeldig geslacht.',
            self::BR010A => 'Ongeldig rijksregisternummer.',
            self::BR011 => 'Het eID-nummer mag maximum 12 karakters lang zijn.',
            self::BR012 => 'Het gsm-nummer mag maximum 20 karakters lang zijn.',
            self::BR013 => 'Ongeldig e-mailadres.',
            self::BR014 => 'Naam dokter mag maximum 100 karakters lang zijn.',
            self::BR015 => 'Telefoonnummer dokter mag maximum 20 karakters lang zijn.',
            self::BR016 => 'Moedertaal mag maximum 100 karakters lang zijn.',
            self::BR017 => 'Ongeldige religie.',
            self::BR018 => 'Ongeldige prioriteitsgroep.',
            self::BR019 => 'Ongeldige reden tot weigering.',
            self::BR020A => 'Er zijn maximum 2 relaties toegelaten.',
            self::BR021 => 'Ongeldig relatietype.',
            self::BR022A => 'Achternaam is verplicht voor relaties.',
            self::BR022B => 'Achternaam relatie mag maximum 50 karakters lang zijn.',
            self::BR023A => 'Voornaam is verplicht voor relaties.',
            self::BR023B => 'Voornaam relatie mag maximum 30 karakters lang zijn.',
            self::BR024A => 'Straat is verplicht voor relaties.',
            self::BR024B => 'Straat relatie mag maximum 50 karakters lang zijn.',
            self::BR025A => 'Huisnummer is verplicht voor relaties.',
            self::BR025B => 'Huisnummer relatie mag maximum 10 karakters lang zijn.',
            self::BR026 => 'Busnummer relatie mag maximum 6 karakters lang zijn.',
            self::BR027A => 'Postcode is verplicht voor relaties.',
            self::BR027B => 'Postcode relatie mag maximum 8 karakters lang zijn.',
            self::BR028A => 'Gemeente is verplicht voor relaties.',
            self::BR028B => 'Gemeente relatie mag maximum 30 karakters lang zijn.',
            self::BR029A => 'Landcode is verplicht voor relaties.',
            self::BR029B => 'Landcode relatie moet 5 karakters lang zijn.',
            self::BR030 => 'Telefoonnummer relatie mag maximum 20 karakters lang zijn.',
            self::BR031 => 'GSM-nummer relatie mag maximum 20 karakters lang zijn.',
            self::BR032 => 'Ongeldig e-mailadres voor relatie.',
            self::BR033 => 'Ongeldige preregistratie ID.',
            self::BR034A => 'Schooljaar is verplicht.',
            self::BR034B => 'Ongeldig schooljaar.',
            self::BR035A => 'Instellingsnummer is verplicht.',
            self::BR035B => 'Instellingsnummer moet 6 karakters lang zijn.',
            self::BR036A => 'Structuur is verplicht.',
            self::BR036B => 'Structuur moet 3 karakters lang zijn.',
            self::BR037A => 'Locatie ID is verplicht.',
            self::BR037B => 'Locatie ID moet 3 karakters lang zijn.',
            self::BR037C => 'Ongeldige locatie ID voor dit instellingsnummer.',
            self::BR038A => 'Administratieve groep is verplicht.',
            self::BR038B => 'Adnimistratieve groep moet 6 karakters lang zijn.',
            self::BR039 => 'Administratieve groep detail mag maximum 200 karakters lang zijn.',
            self::BR040A => 'Datum voorinschrijving is verplicht.',
            self::BR040B => 'Datum voorinschrijving moet voor de begindatum vallen.',
            self::BR041A => 'Startdatum is verplicht.',
            self::BR041B => 'Startdatum moet tussen het begin en het einde van het geselecteerde schooljaar vallen.',
            self::BR042 => 'Ongeldige registratie status.',
            self::BR043A => 'Ongeldig rijksregisternummer voor relatie.',        

            self::DNF001 => 'Geen inschrijving gevonden voor ID.',
            
            self::MNA001 => 'De voorinschrijving is reeds geaccepteerd en kan niet meer gewijzigd worden.',
            self::MNA002 => 'De voorinschrijving is reeds geweigerd en kan niet meer gewijzigd worden.',
            self::MNA003 => 'De voorinschrijving is reeds geaccepteerd en kan niet meer verwijderd worden.',
            self::MNA004 => 'De voorinschrijving is reeds geweigerd en kan niet meer gewijzigd worden.',
            self::MNA005 => 'De persoonsgegevens wijzigen van deze voorinschrijving is niet toegestaan.',
        };
    }
}