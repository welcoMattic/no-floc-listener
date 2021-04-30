<?php

declare(strict_types=1);

/*
 * This file is part of oskarstark/no-floc-listener.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OskarStark\Symfony\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Based on https://twitter.com/fabpot/status/1387777376898228232
 *
 * @author Fabien Potenvier <fabien@symfony.com>
 */
final class NoFlocListener implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('permissions-policy', 'interest-cohort=()');
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ResponseEvent::class => 'onKernelResponse',
        ];
    }
}
