<?php

declare(strict_types=1);

namespace App\Jobs\middleware;


use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Support\Facades\Redis;

/**
 * Class JobThrottlingMiddleware
 * @package App\Jobs\Middleware
 */
class JobThrottlingMiddleware
{
    /**
     * @var int
     */
    protected int $backTimeout = 60;
    /**
     * @var int
     */
    protected int $maxLocks = 100;
    /**
     * @var int
     */
    protected int $everyDecay = 60;
    /**
     * @var int
     */
    protected int $releaseTimeout = 60;
    /**
     * Process the job.
     *
     * @param mixed $job
     * @param callable $next
     * @throws LimiterTimeoutException
     */
    public function handle(mixed $job, callable $next): void
    {
        if (config('throttling-settings.enabled', false)){
            Redis::throttle('JobThrottle:OpenAI')->block($this->backTimeout)->allow($this->maxLocks)->every($this->everyDecay)->then(function () use ($job, $next) {
                $next($job);
            }, function () use ($job) {
                return $job->release($this->releaseTimeout);
            });
        }else{
            $next($job);
        }
    }
}
