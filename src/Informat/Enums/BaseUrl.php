<?php

namespace Koba\Informat\Enums;

enum BaseUrl: string
{
    case STUDENT = 'https://leerlingenapi.informatsoftware.be';
    case PERSONNEL = 'https://personeelsapi.informatsoftware.be';
}
