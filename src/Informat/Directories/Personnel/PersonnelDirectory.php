<?php

namespace Koba\Informat\Directories\Personnel;

use Koba\Informat\Directories\AbstractDirectory;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Directories\Personnel\GetEmployee\GetEmployeeCall;
use Koba\Informat\Directories\Personnel\GetEmployees\GetEmployeesCall;
use Koba\Informat\Enums\BaseUrl;

class PersonnelDirectory
extends AbstractDirectory
implements DirectoryInterface
{
    public function getBaseUrl(): BaseUrl
    {
        return BaseUrl::PERSONNEL;
    }

    /**
     * Gets all the employees for the combination 
     * institute number, school year and structure.
     * 
     * @param null|int|string $schoolyear 
     * For current & future school years: It limits the output results 
     * to employees with an assignment within the given schoolyear
     * or which are marked as active for your instituteNo.
     * 
     * For passed school years: It limits the output results to employees
     * with an assignment within the given schoolyear (and instituteNo).
     * Also used to determine the instituteNo’s for the properties 
     * “EersteDienstScholengroep” and “EersteDienstScholengemeenschap”.
     * 
     * Pass null for current school year.
     */
    public function getEmployees(
        string $instituteNumber,
        null|int|string $schoolyear = null,
    ): GetEmployeesCall {
        return GetEmployeesCall::make(
            $this,
            $instituteNumber,
            $schoolyear
        );
    }

    /**
     * Gets an employee by it’s personId.
     * 
     * @param string $personId
     * Limits the output results to an employee with the provided personId.
     * Should contain a GUID.
     * @param null|int|string $schoolyear
     * Only used to determine the instituteNo’s for the properties 
     * “EersteDienstScholengroep” and “EersteDienstScholengemeenschap”.
     */
    public function getEmployee(
        string $instituteNumber,
        string $personId,
        null|int|string $schoolyear = null
    ): GetEmployeeCall {
        return GetEmployeeCall::make(
            $this,
            $instituteNumber,
            $personId,
            $schoolyear,
        );
    }
}
