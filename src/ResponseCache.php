<?php

namespace Spatie\ResponseCache;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResponseCache
{
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var ResponseHasher
     */
    private $hasher;

    /**
     * @param Repository $cache
     * @param ResponseHasher $hasher
     */
    public function __construct(Repository $cache, ResponseHasher $hasher)
    {
        $this->cache = $cache;
        $this->hasher = $hasher;
    }

    /**
     * Determine if the given request should be cached.
     *
     * @param Request $request
     * @return bool
     */
    public function shouldCache(Request $request)
    {
        return true;
    }

    /**
     * Store the given response in the cache.
     *
     * @param Request $request
     * @param Response $response
     */
    public function cacheResponse(Request $request, Response $response)
    {
        $this->cache->put($this->hasher->getHashFor($request), $response->getContent(), 5);
    }

    /**
     * Determine if the given request has been cached.
     *
     * @param Request $request
     * @return bool
     */
    public function hasCached(Request $request)
    {
        return $this->cache->has($this->hasher->getHashFor($request));
    }

    /**
     * Get the cached response for the given request.
     *
     * @param Request $request
     * @return mixed
     */
    public function getCachedResponseFor(Request $request)
    {
        return $this->cache->get($this->hasher->getHashFor($request));
    }
}

