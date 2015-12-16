<?php
namespace Smichaelsen\SlackNotifications;

use TYPO3\CMS\Core\SingletonInterface;

class SlackNotificationService implements SingletonInterface
{

    /**
     * @param string $message
     * @param string $icon
     * @return mixed
     */
    public function notify($message, $icon = ":longbox:")
    {

        $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['slack_notifications']);

        $channel = '#' . ($extensionConfiguration['exceptionChannel'] ?: 'general');

        $url = $extensionConfiguration['slackHookEndpoint'] . '&channel=' . urlencode($channel);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
