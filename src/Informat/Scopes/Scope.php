<?php

namespace Koba\Informat\Scopes;

enum Scope: string
{
    case STUDENTS = 'api_informat_sas_leerlingen.leerlingen';
    case PREREGISTRATIONS = "api_informat_sas_leerlingen.voorinschrijvingen";
}
