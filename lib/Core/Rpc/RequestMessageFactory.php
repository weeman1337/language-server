<?php

namespace Phpactor\LanguageServer\Core\Rpc;

use DTL\Invoke\Invoke;

class RequestMessageFactory
{
    public static function fromRequest(RawMessage $request): Message
    {
        $body = $request->body();
        unset($body['jsonrpc']);

        if (array_key_exists('result', $body)) {
            return Invoke::new(ResponseMessage::class, $body);
        }

        if (!isset($body['id']) || is_null($body['id'])) {
            unset($body['id']);
            return Invoke::new(NotificationMessage::class, $body);
        }

        return Invoke::new(RequestMessage::class, $body);
    }
}
