<?php

namespace ProgTime\TgLogger;

/**
 * Класс для отправки логов в Telegram
 */
class TgLogger
{
    /**
     * Формирование списка тем для логирования
     * @return array
     */
    private static function getConfigParams(): array
    {
        try {
            $topicSettings = config('tg-logger.topics');
            if (empty($topicSettings)) {
                throw new \Exception('Topics not found!');
            }

            $resultSettings = [];
            foreach ($topicSettings as $param) {
                $levelParams = strtolower($param['level']);
                $listLevelItems = explode(',', $levelParams);
                foreach ($listLevelItems as $item) {
                    $resultSettings[trim($item)] = $param;
                }
            }

            return $resultSettings;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Отправка лога в Telegram
     * @param mixed $logData - данные для логирования
     * @param string $level - код типа лога
     * @return void
     */
    public static function sendLog(mixed $logData, string $level): void
    {
        $topicSettings = self::getConfigParams();
        if (!empty($topicSettings[$level])) {
            $queryParams = [
                'message_thread_id' => $topicSettings[$level]['id_topic'],
            ];

            if (is_string($logData)) {
                $textMessage = $logData;
                $queryParams['text'] = $textMessage;
            } else {
                $queryParams['text'] = '``` '. print_r($logData, true) .' ```';
                $queryParams['parse_mode'] = 'MarkdownV2';
            }

            (new TgLoggerMethods())->telegramQuery('sendMessage', $queryParams);
        }
    }
}
