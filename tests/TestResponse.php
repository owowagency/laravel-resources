<?php

namespace OwowAgency\LaravelResources\Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse as BaseTestResponse;

class TestResponse extends BaseTestResponse
{
    /**
     * The length of the internal server error message.
     *
     * @var string
     */
    private $internalLength = 500;

    /**
     * Assert that the response has the given status code.
     *
     * @param  int  $status
     * @return $this
     */
    public function assertStatus($status)
    {
        $actual = $this->getStatusCode();

        $message = $this->prepareMessage($status, $actual);

        PHPUnit::assertTrue(
            $actual === $status,
            $message
        );

        return $this;
    }

    /**
     * Prepares the message.
     *
     * @param  int  $assertedStatus
     * @param  int  $actualStatus
     * @return string
     */
    private function prepareMessage(int $assertedStatus, int $actualStatus): string
    {
        $message = "Expected status code {$assertedStatus} but received {$actualStatus}.";

        switch ($actualStatus) {
            case 500:
                if ($assertedStatus != 500) {
                    $content = substr($this->getContent(), 0, $this->internalLength);

                    $message .= " First {$this->internalLength} characters of content: \n---------- \n {$content} \n----------";
                }
                break;

            case 422:
                if ($assertedStatus != 422) {
                    $message .= " The validation errors: \n---------- \n {$this->getContent()} \n----------";
                }
                break;
        }

        return $message;
    }
}
