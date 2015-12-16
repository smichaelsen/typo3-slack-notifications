<?php
namespace Smichaelsen\SlackNotifications;

use TYPO3\CMS\Core\Error\ProductionExceptionHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExceptionHandler extends ProductionExceptionHandler
{

    /**
     * Constructs this exception handler - registers itself as the default exception handler.
     */
    public function __construct()
    {
        parent::__construct();
        set_exception_handler(array($this, 'handleException'));
    }

    /**
     * Formats and echoes the exception as XHTML.
     *
     * @param \Exception $exception The exception object
     * @return void
     */
    public function echoExceptionWeb(\Exception $exception)
    {
        $this->sendToSlack($exception);
        parent::echoExceptionWeb($exception);
    }

    /**
     * Formats and echoes the exception for the command line
     *
     * @param \Exception $exception The exception object
     * @return void
     */
    public function echoExceptionCLI(\Exception $exception)
    {
        $this->sendToSlack($exception);
        parent::echoExceptionWeb($exception);
    }

    /**
     * @param \Exception $exception
     * @throws \Exception
     */
    protected function sendToSlack(\Exception $exception)
    {
        $slackNotificationService = GeneralUtility::makeInstance(SlackNotificationService::class);
        $slackNotificationService->notify('Exception from ' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] . ': [#' . $exception->getCode() . '] '. $exception->getMessage());
    }
}
