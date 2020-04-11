<?php

namespace Phpactor\LanguageServer\Core\Rpc;

use DTL\Invoke\Invoke;
use RuntimeException;
use Phpactor\LanguageServer\Core\Rpc\RawMessage;

class RequestMessageFactory
{
    public static function fromRequest(RawMessage $request): Message
    {
        $body = $request->body();
        unset($body['jsonrpc']);

        if (!isset($body['id']) || $body['id'] === null) {
            unset($body['id']);
            return Invoke::new(NotificationMessage::class, $body);
        }

        return Invoke::new(RequestMessage::class, $body);
    }
}
