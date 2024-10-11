<?php

namespace Koba\Informat\Enums;

enum MethodNotAllowedCode: string
{
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
