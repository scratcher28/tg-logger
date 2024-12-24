<?php

namespace ProgTime\TgLogger\Commands;

use Illuminate\Console\Command;
use ProgTime\TgLogger\TgLoggerMethods;

class TgLoggerCreateTopics extends Command
{
    protected $signature = 'tglogger:create-topics';
    protected $description = 'Create topics for logging';

    public function handle(): void
    {
        try {
            $this->call('config:cache');

            $configSettings = config('tg-logger');
            $topics = config('tg-logger.topics');

            if (empty($topics)) {
                throw new \Exception('Topics not found');
            }

            foreach ($topics as $key => $valueParams) {
                $queryParams = [
                    'name' => $valueParams['name'],
                    'icon_color' => $valueParams['icon_color'] ?? '',
                ];

                // Пробуем обновить топик
                if (!empty($valueParams['id_topic'])) {
                    $queryParams['message_thread_id'] = (int)$valueParams['id_topic'];

                    $resultQuery = (new TgLoggerMethods())->telegramQuery('editForumTopic', $queryParams);
                    if (isset($resultQuery['ok']) && $resultQuery['error_code']) {
                        if ($resultQuery['ok'] === false && $resultQuery['error_code'] === 400) {
                            if (strpos($resultQuery['description'], 'TOPIC_NOT_MODIFIED') !== false) {
                                continue;
                            }
                        }
                    }
                }

                // Создаём новый топик
                $resultQuery = (new TgLoggerMethods())->telegramQuery('createForumTopic', $queryParams);
                if (!empty($resultQuery['result'])) {
                    $configSettings['topics'][$key]['id_topic'] = $resultQuery['result']['message_thread_id'];
                }
            }

            $this->updateConfigFile($configSettings);

            $this->info('All topics have been created and the configuration has been updated.');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }

    private function updateConfigFile(array $configSettings): void
    {
        $configPath = config_path('tg-logger.php');
        $updatedContent = "<?php\n\nreturn " . var_export($configSettings, true) . "; \n";
        File::put($configPath, $updatedContent);
        $this->call('config:cache');
    }
}
