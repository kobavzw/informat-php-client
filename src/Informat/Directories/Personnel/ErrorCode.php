<?php

namespace Koba\Informat\Directories\Personnel;

use Koba\Informat\Contracts\HasDescriptionInterface;

enum ErrorCode: string implements HasDescriptionInterface
{
    case BR001 = 'BR001';
    case BR002 = 'BR002';
    case BR003A = 'BR003A';
    case BR004A = 'BR004A';
    case BR004B = 'BR004B';
    case BR005A = 'BR005A';
    case BR005B = 'BR005B';
    case BR006A = 'BR006A';
    case BR006B = 'BR006B';
    case BR007A = 'BR007A';
    case BR008A = 'BR008A';
    case BR008B = 'BR008B';
    case BR009 = 'BR009';
    case BR010 = 'BR010';
    case BR011 = 'BR011';
    case BR012A = 'BR012A';
    case BR012B = 'BR012B';
    case BR013 = 'BR013';
    case BR014 = 'BR014';
    case BR015 = 'BR015';
    case BR016A = 'BR016A';
    case BR016B = 'BR016B';
    case BR016C = 'BR016C';
    case BR017A = 'BR017A';
    case BR017B = 'BR017B';
    case BR018 = 'BR018';
    case BR019 = 'BR019';

    case MNA001 = 'MNA001';
    case MNA002 = 'MNA002';
    case MNA003 = 'MNA003';
    case MNA004 = 'MNA004';
    case MNA005 = 'MNA005';
    case MNA006 = 'MNA006';
    case MNA007 = 'MNA007';
    case MNA008 = 'MNA008';
    case MNA009 = 'MNA009';
    case MNA010 = 'MNA010';
    case MNA011 = 'MNA011';

    public function getDescription(): string
    {
        return match ($this) {
            self::BR001 => 'Ongeldig PersonId.',
            self::BR002 => 'Ongeldig InterruptionId.',
            self::BR003A => 'Het instellingsnummer is verplicht.',
            self::BR004A => 'Het schooljaar is verplicht.',
            self::BR004B => 'Ongeldig schooljaar formaat.',
            self::BR005A => 'Hoofdstructuur is verplicht.',
            self::BR005B => 'Hoofdstructuur moet bestaan uit 3 karakters.',
            self::BR006A => 'Code is verplicht.',
            self::BR006B => 'Ongeldige code.',
            self::BR007A => 'Begindatum is verplicht.',
            self::BR008A => 'Einddatum is verplicht.',
            self::BR008B => 'Einddatum kan niet voor de begindatum vallen.',
            self::BR009 => 'Opmerking mag maximum 50 karakters bevatten.',
            self::BR010 => 'Naam geneesheer mag maximum 75 karakters bevatten.',
            self::BR011 => 'Telefoon geneesheer mag maximum 20 karakters bevatten.',
            self::BR012A => 'Afzender is verplicht',
            self::BR012B => 'Afzender mag maximum 50 karakters bevatten',
            self::BR013 => 'Ongeldige combinatie van instellingsnummer, schooljaar en structuur.',
            self::BR014 => 'Geen personeelslid gevonden voor de PersonId.',
            self::BR015 => 'Ongeldig AttachmentId.',
            self::BR016A => 'Bestandsnaam is verplicht.',
            self::BR016B => 'Bestandsnaam mag maximum 100 karakters bevatten.',
            self::BR016C => 'Ongeldige extensie.',
            self::BR017A => 'Bestand is verplicht.',
            self::BR017B => 'Bestand mag maximum 10MB groot zijn.',
            self::BR018 => 'Geen dienstonderbreking gevonden voor deze ID.',
            self::BR019 => 'Geen geldige combinatie van dienstonderbreking en attachment gevonden.',

            self::MNA001 => 'De dienstonderbrekening is reeds gekoppeld aan een andere school.',
            self::MNA002 => 'De dienstonderbrekening is reeds gekoppeld aan een ander personeelslid.',
            self::MNA003 => 'De hoofdstructuur, code, begin- en einddatum kunnen niet meer gewijzigd worden omdat de dienstonderbreking reeds is doorgestuurd naar AgODi.',
            self::MNA004 => 'De hoofdstructuur, begin- en einddatum kunnen niet meer gewijzigd worden aangezien er reeds een vervanging is voor de dienstonderbreking.',
            self::MNA005 => 'De dienstonderbreking kon niet toegevoegd worden omdat er reeds een overlappende dienstonderbreking bestaat.',
            self::MNA006 => 'De dienstonderbreking kon niet gewijzigd worden omdat er reeds een overlappende dienstonderbreking bestaat.',
            self::MNA007 => 'Het attachment is reeds gekoppeld aan een ander personeelslid.',
            self::MNA008 => 'Enkel onderbrekingen die toegevoegd zijn via de API kunnen verwijderd worden.',
            self::MNA009 => 'De dienstonderbreking kon niet verwijderd worden omdat ze reeds geverifieerd is door het secretariaat.',
            self::MNA010 => 'De dienstonderbreking kon niet verwijderd worden omdat ze reeds ingediend is bij AgODi.',
            self::MNA011 => 'De dienstonderbreking kon niet verwijderd worden omdat er reeds een vervanging voor bestaat.',
        };
    }
}
