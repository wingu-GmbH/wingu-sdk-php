<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Request;

use Wingu\Engine\SDK\Model\Request\Request;

final class RequestDataManipulator
{
    /** @return mixed[] */
    public static function flatten(Request $request) : array
    {
        $requestArray = \json_decode((string) \json_encode($request), true);

        return self::flattenRequestData($requestArray);
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    private static function flattenRequestData(array $data, ?string $parentKey = null) : array
    {
        $return = [[]];

        foreach ($data as $currentKey => $value) {
            $childKey = $parentKey === null ? (string) $currentKey : $parentKey . '[' . $currentKey . ']';
            if (\is_array($value)) {
                $return[] = self::flattenRequestData($value, $childKey);
            } else {
                $return[][$childKey] = $value;
            }
        }

        return \array_merge(...$return);
    }
}
