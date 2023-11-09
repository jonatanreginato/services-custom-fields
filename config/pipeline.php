<?php

declare(strict_types=1);

use Mezzio\Application;

return static function (Application $app): void {
    // The error handler should be the first (most outer) middleware to catch all Exceptions.
    $app->pipe(Laminas\Stratigility\Middleware\ErrorHandler::class);

    // Server Url Middleware
    $app->pipe(Mezzio\Helper\ServerUrlMiddleware::class);

    /**
     * Pipe more middleware here that you want to execute on every appRequest:
     * - bootstrapping
     * - pre-conditions
     * - modifications to outgoing responses
     *
     * Piped Middleware may be either callables or service names.
     * Middleware may also be passed as an array;
     * Each item in the array must resolve to middleware eventually (i.e., callable or service name).
     *
     * Middleware can be attached to specific paths, allowing you to mix and match applications under a common domain.
     * The handlers in each middleware attached this way will see a URI with the matched path segment removed.
     *
     * i.e., path of "/api/member/profile" only passes "/member/profile" to $apiMiddleware
     * - $app->pipe('/api', $apiMiddleware);
     * - $app->pipe('/docs', $apiDocMiddleware);
     * - $app->pipe('/files', $filesMiddleware);
     */

    // JWT Authentication Middleware
    $app->pipe(Tuupola\Middleware\JwtAuthentication::class);

    // RequestId Middleware
    $app->pipe(Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMiddleware::class);

    // Request/Response Logger Middleware
    $app->pipe(Nuvemshop\CustomFields\Infrastructure\Log\Middleware\LoggerMiddleware::class);

    /**
     * Register the routing middleware in the middleware pipeline.
     * This middleware registers the Mezzio\Router\RouteResult appRequest attribute.
     */
    $app->pipe(Mezzio\Router\Middleware\RouteMiddleware::class);

    // CORS Middleware
    $app->pipe(Tuupola\Middleware\CorsMiddleware::class);

    /**
     * The following handle routing failures for common conditions:
     * - HEAD appRequest but no routes answer that method
     * - OPTIONS appRequest but no routes answer that method
     * - method not allowed
     * Order here matters; the MethodNotAllowedMiddleware should be placed after the Implicit*Middleware.
     */
    $app->pipe(Mezzio\Router\Middleware\ImplicitHeadMiddleware::class);
    $app->pipe(Mezzio\Router\Middleware\ImplicitOptionsMiddleware::class);
    $app->pipe(Mezzio\Router\Middleware\MethodNotAllowedMiddleware::class);

    // Seed the UrlHelper with the routing results:
    $app->pipe(Mezzio\Helper\UrlHelperMiddleware::class);

    /**
     * Add more middleware here that needs to introspect the routing results; this might include:
     *
     * - route-based authentication
     * - route-based validation
     * - etc.
     */

    // Register the dispatch middleware in the middleware pipeline
    $app->pipe(Mezzio\Router\Middleware\DispatchMiddleware::class);

    /**
     * At this point, if no Response is returned by any middleware, the NotFoundHandler kicks in;
     * alternately, you can provide other fallback middleware to execute.
     */
    $app->pipe(Mezzio\Handler\NotFoundHandler::class);
};
