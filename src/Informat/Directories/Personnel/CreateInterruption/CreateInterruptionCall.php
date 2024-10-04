<?php

namespace Koba\Informat\Directories\Personnel\CreateInterruption;

use DateTime;
use Exception;
use Koba\Informat\Call\AbstractCall;
use Koba\Informat\Directories\Personnel\PersonnelDirectory;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\InterruptionCode;
use Koba\Informat\Helpers\Schoolyear;
use Psr\Http\Message\ResponseInterface;

class CreateInterruptionCall extends AbstractCall
{
    protected string $personId;
    protected string $interruptionId;

    /**
     * @var array<string,mixed> $body
     */
    protected array $body;

    public static function make(
        PersonnelDirectory $directory,
        string $instituteNumber,
        string $personId,
        string $interruptionId,
        null|int|string $schoolyear,
        string $hoofdstructuur,
        string|InterruptionCode $code,
        string|DateTime $begindatum,
        string|DateTime $einddatum,
        string $afzender,
    ): self {
        return (new self($directory, $instituteNumber))
            ->setPersonId($personId)
            ->setInterruptionId($interruptionId)
            ->setSchoolyear($schoolyear)
            ->setHoofdstructuur($hoofdstructuur)
            ->setCode($code)
            ->setBegindatum($begindatum)
            ->setEinddatum($einddatum)
            ->setAfzender($afzender);
    }

    /**
     * The mandatory unique identifier of an existing employee, to which the 
     * interruption will be linked.
     */
    protected function setPersonId(string $personId): self
    {
        $this->personId = $personId;
        return $this;
    }

    /**
     * A mandatory unique identifier which is used to identify the interruption.
     * Based on this Id the decision will be made to add a new interruption or
     * update an existing one.
     */
    protected function setInterruptionId(string $interruptionId): self
    {
        $this->interruptionId = $interruptionId;
        return $this;
    }

    /**
     * The school year in which the employee’s interruption takes place.
     */
    public function setSchoolyear(int|string|null $schoolyear): self
    {
        $this->body['schooljaar'] = (string)(new Schoolyear($schoolyear));
        return $this;
    }

    /**
     * The school structure (111, 211,…) of the interruption.
     */
    public function setHoofdstructuur(string $hoofdstructuur): self
    {
        $hoofdstructuur = trim($hoofdstructuur);
        if (strlen($hoofdstructuur) !== 3) {
            throw new Exception('De hoofdstructuur moet 3 karakters bevatten.');
        }

        $this->body['hfd'] = $hoofdstructuur;
        return $this;
    }

    /**
     * Official interruption code.
     */
    public function setCode(string|InterruptionCode $code): self
    {
        if (is_string($code)) {
            $code = InterruptionCode::from($code);
        }

        $this->body['code'] = $code->value;
        return $this;
    }

    /**
     * Interruption’s start date.
     */
    public function setBegindatum(string|DateTime $begindatum): self
    {
        if (is_string($begindatum)) {
            $begindatum = new DateTime($begindatum);
        }

        $this->body['begindatum'] = $begindatum->format('Y-m-d');
        return $this;
    }

    /**
     * Interruption’s end date.
     */
    public function setEinddatum(string|DateTime $einddatum): self
    {
        if (is_string($einddatum)) {
            $einddatum = new DateTime($einddatum);
        }

        $this->body['einddatum'] = $einddatum->format('Y-m-d');
        return $this;
    }

    /**
     * Name of the sender. Can be the name of an application, user, …
     */
    public function setAfzender(string $afzender): self
    {
        $this->body['afzender'] = $afzender;
        return $this;
    }

    /**
     * Remark given by the employee. Will be stored in a separate database
     * field different from the one entered by the secretariat.
     */
    public function setOpmerking(?string $opmerking): self
    {
        if ($opmerking === null) {
            unset($this->body['opmerking']);
        } else {
            $this->body['opmerking'] = $opmerking;
        }

        return $this;
    }

    /**
     * Name of the doctor
     */
    public function setNaamGeneesheer(?string $naamGeneesheer): self
    {
        if ($naamGeneesheer === null) {
            unset($this->body['naamGeneesheer']);
        } else {
            $this->body['naamGeneesheer'] = $naamGeneesheer;
        }

        return $this;
    }

    /**
     * Doctor’s Phone number.
     */
    public function setTelefoonGeneesheer(?string $telefoonGeneesheer): self
    {
        if ($telefoonGeneesheer === null) {
            unset($this->body['telefoonGeneesheer']);
        } else {
            $this->body['telefoonGeneesheer'] = $telefoonGeneesheer;
        }

        return $this;
    }

    /**
     * Indicates whether the employee may leave his/her home.
     * Note: If not provided, value true will be stored as a default.
     */
    public function setMagWoonstVerlaten(?bool $magWoonstVerlaten): self
    {
        if ($magWoonstVerlaten === null) {
            unset($this->body['magWoonstVerlaten']);
        } else {
            $this->body['magWoonstVerlaten'] = $magWoonstVerlaten;
        }

        return $this;
    }

    /**
     * The method of the API call.
     */
    protected function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    /**
     * The endpoint to which the call will be made.
     */
    protected function getEndpoint(): string
    {
        return "/employees/{$this->personId}/interruptions/{$this->interruptionId}";
    }

    /**
     * The body of the API call.
     * 
     * @return array<string,mixed>
     */
    protected function getBody(): array
    {
        return [
            ...$this->body,
            'instelnr' => (string)$this->instituteNumber,
        ];
    }

    /**
     * Perform the actual request.
     */
    public function send(): ResponseInterface
    {
        return $this->performRequest();
    }
}
