<?php

namespace Framework\Http;

class ActionResolver
{
    public function resolver($handler): callable
    {
        return \is_string($handler) ? new $handler() :$handler;
    }
}
