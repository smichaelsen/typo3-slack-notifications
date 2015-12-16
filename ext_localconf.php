<?php

$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['slack_notifications']);

if ($extensionConfiguration['registerExceptionHandler']) {
    // Registering the exception handler is done in the constructor
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Smichaelsen\SlackNotifications\ExceptionHandler::class);
}
