<?php

namespace Koba\Informat\Responses\Personnel;

class Bank
{
    /** Employee’s international bank account number. */
    public string $iban;

    /**
     * Employee’s Bank Identification Code. 
     * Format: 8 to 11 characters if provided.
     */
    public string $bic;
}
