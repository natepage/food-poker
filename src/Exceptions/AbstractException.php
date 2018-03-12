<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Interfaces\ExceptionInterface;
use Exception;
use Throwable;

abstract class AbstractException extends Exception implements ExceptionInterface
{
    /**
     * Extended message for debug purposes.
     *
     * @var null|string
     */
    protected $extendedMessage;

    /**
     * HTTP headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * HTTP status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Exception sub code.
     *
     * @var int
     */
    protected $subCode;

    /**
     * Translation domain.
     *
     * @var string
     */
    protected $transDomain;

    /**
     * Translation parameters.
     *
     * @var array
     */
    protected $transParams;

    /**
     * BaseException constructor.
     *
     * @param null|string $message
     * @param int|null $code
     * @param null|\Throwable $previous
     * @param null|string $extendedMessage
     * @param array|null $headers
     * @param int|null $statusCode
     * @param null|string $transDomain
     * @param array|null $transParams
     */
    public function __construct(
        ?string $extendedMessage = null,
        ?array $transParams = null,
        ?Throwable $previous = null,
        ?string $transDomain = null,
        ?int $statusCode = null,
        ?array $headers = null
    ) {
        parent::__construct($this->initMessage() ?? 'default.exception', $this->initCode() ?? 0, $previous);

        $this->extendedMessage = $extendedMessage;
        $this->headers = $headers ?? [];
        $this->statusCode = $statusCode ?? 500;
        $this->subCode = $this->initSubCode() ?? 0;
        $this->transDomain = $transDomain ?? 'Default';
        $this->transParams = $transParams ?? [];
    }

    /**
     * Get extended message for debug purposes.
     *
     * @return null|string
     */
    public function getExtendedMessage(): ?string
    {
        return $this->extendedMessage;
    }

    /**
     * Get HTTP headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get sub code.
     *
     * @return int
     */
    public function getSubCode(): int
    {
        return $this->subCode;
    }

    /**
     * Get translation domain.
     *
     * @return string
     */
    public function getTranslationDomain(): string
    {
        return $this->transDomain;
    }

    /**
     * Get translation parameters.
     *
     * @return array
     */
    public function getTranslationParameters(): array
    {
        return $this->transParams;
    }

    /**
     * Set extended message for debug purposes.
     *
     * @param string $extendedMessage
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setExtendedMessage(string $extendedMessage): self
    {
        $this->extendedMessage = $extendedMessage;

        return $this;
    }

    /**
     * Set HTTP headers.
     *
     * @param array $headers
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set HTTP status code.
     *
     * @param int $statusCode
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Set sub code.
     *
     * @param int $subCode
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setSubCode(int $subCode): self
    {
        $this->subCode = $subCode;

        return $this;
    }

    /**
     * Set translation domain.
     *
     * @param string $transDomain
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setTranslationDomain(string $transDomain): self
    {
        $this->transDomain = $transDomain;

        return $this;
    }

    /**
     * Set translation parameters.
     *
     * @param array $transParams
     *
     * @return \App\Exceptions\AbstractException
     */
    public function setTranslationParameters(array $transParams): self
    {
        $this->transParams = $transParams;

        return $this;
    }

    /**
     * Init exception code for end users.
     *
     * @return int|null
     */
    abstract protected function initCode(): ?int;

    /**
     * Init exception message for end users.
     *
     * @return null|string
     */
    abstract protected function initMessage(): ?string;

    /**
     * Init exception sub code for end users.
     *
     * @return int|null
     */
    abstract protected function initSubCode(): ?int;
}
