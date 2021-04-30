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

namespace OskarStark\Symfony\EventListener\Tests;

use OskarStark\Symfony\EventListener\NoFlocListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class NoFlocListenerTest extends TestCase
{
    /**
     * @test
     */
    public function getSubscribedEvents(): void
    {
        static::assertSame(
            [
                ResponseEvent::class => 'addPermissionsPolicyHeader',
            ],
            NoFlocListener::getSubscribedEvents()
        );
    }

    /**
     * @test
     */
    public function onKernelResponse(): void
    {
        $response = new Response();

        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/'),
            HttpKernelInterface::MASTER_REQUEST,
            $response
        );

        static::assertFalse($event->getResponse()->headers->has('permissions-policy'));

        (new NoFlocListener())->onKernelResponse($event);

        static::assertTrue($event->getResponse()->headers->has('permissions-policy'));
        static::assertSame(
            'interest-cohort=()',
            $event->getResponse()->headers->get('permissions-policy')
        );
    }
}
